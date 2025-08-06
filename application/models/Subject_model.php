<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Subject_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    
    // get subjects assign list
    public function getAssignList()
    {
        $this->db->select('sa.class_id,sa.branch_id,b.name as branch_name,c.name as class_name');
        $this->db->from('subject_assign as sa');
        $this->db->join('branch as b', 'b.id = sa.branch_id', 'left');
        $this->db->join('class as c', 'c.id = sa.class_id', 'left');
        $this->db->group_by(array('sa.class_id', 'sa.branch_id'));
        $this->db->where('sa.session_id', get_session_id());
        if (!is_superadmin_loggedin()) {
            $this->db->where('sa.branch_id', get_loggedin_branch_id());
        }
        $result = $this->db->get()->result_array();
        return $result;
    }

    // get subject list by class id and section id
    public function get_subject_list($class_id = '')
    {
        $this->db->select('sa.subject_id,s.name');
        $this->db->from('subject_assign as sa');
        $this->db->join('subject as s', 's.id = sa.subject_id', 'left');
        $this->db->where('sa.class_id', $class_id);
        $this->db->where('sa.session_id', get_session_id());
        $subjects = $this->db->get()->result();
        $name_list = '';
        foreach ($subjects as $row) {
            $name_list .= '- ' . $row->name . '<br>';
        }
        return $name_list;
    }

    // get teacher assign list
    public function getTeacherAssignList()
    {
        $sql = "SELECT sa.*, c.name as class_name, sb.name as subject_name, t.name as teacher_name, t.department, sd.name as department_name FROM subject_assign as sa LEFT JOIN class as c ON c.id = sa.class_id LEFT JOIN subject as sb ON sb.id = sa.subject_id LEFT JOIN staff as t ON t.id = sa.teacher_id LEFT JOIN staff_department as sd ON sd.id = t.department WHERE sa.teacher_id != 0";
        if (!is_superadmin_loggedin()) {
            $sql .= " AND sa.branch_id = " . $this->db->escape(get_loggedin_branch_id());
        }
        $sql .= " ORDER BY sa.id ASC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function getSubjectByClassSection($classID = '')
    {
        if (loggedin_role_id() == 3) {
            $restricted = $this->getSingle('branch', get_loggedin_branch_id(), true)->teacher_restricted;
            if ($restricted == 1) {
                $getClassTeacher = $this->getClassTeacherByClassSection($classID);
                if ($getClassTeacher == true) {
                    $isTeacher = true;
                    $query = $this->getSubjectList($classID, $isTeacher);
                } else {
                    $this->db->select('timetable_class.subject_id,subject.name as subjectname,subject.subject_code');
                    $this->db->from('timetable_class');
                    $this->db->join('subject', 'subject.id = timetable_class.subject_id', 'left');
                    $this->db->where(array('timetable_class.teacher_id' => get_loggedin_user_id(), 'timetable_class.session_id' => get_session_id(), 'timetable_class.class_id' => $classID));
                    $this->db->group_by('timetable_class.subject_id');
                    $query = $this->db->get();
                }
            } else {
                $query = $this->getSubjectList($classID);
            }
        } else {
            $query = $this->getSubjectList($classID);
        }
        return $query;
    }


    public function getSubjectList($classID = '',  $isTeacher = false)
    {
    // Step 1: Prepare the query for subject assignment
    $this->db->select('subject_assign.subject_id, subject.name as subjectname, subject.subject_code');
    $this->db->from('subject_assign');
    $this->db->join('subject', 'subject.id = subject_assign.subject_id', 'left');
    $this->db->where('subject_assign.class_id', $classID);
   
    // Step 2: Filter by session_id (assuming session_id is constant)
    $this->db->where('subject_assign.session_id', get_session_id());
    
    // Step 3: Check if we need to filter for the teacher
    if ($isTeacher) {
        $this->db->where('subject_assign.teacher_id', get_loggedin_user_id());
    }


    $query = $this->db->get();
    $assignedSubjects = $query->result_array();

    
    if (empty($assignedSubjects)) {
        // Fetch all subjects in the class and handle assigned/unassigned cases
        $this->db->select('
            IFNULL(subject_assign.subject_id, subject.id) as subject_id, 
            subject.name as subjectname, 
            subject.subject_code
        ');
        $this->db->from('subject');
        $this->db->join('subject_assign', 'subject_assign.subject_id = subject.id AND subject_assign.class_id = ' . $classID, 'left');
    
        // Exclude subjects already assigned to other teachers
        $this->db->group_start();
        $this->db->where('subject_assign.teacher_id !=', get_loggedin_user_id());
        $this->db->or_where('subject_assign.teacher_id IS NULL'); // Handle unassigned subjects
        $this->db->group_end();
    
        $this->db->where('subject_assign.session_id', get_session_id());
        $query = $this->db->get();
    }


    return $query;
}



    
    public function getClassTeacherByClassSection($classID = '')
    {
        // Check in teacher_allocation table
        $this->db->select('teacher_allocation.id');
        $this->db->from('teacher_allocation');
        $this->db->where('teacher_allocation.teacher_id', get_loggedin_user_id());
        $this->db->where('teacher_allocation.session_id', get_session_id());
        $this->db->where('teacher_allocation.class_id', $classID);
    
        $q1 = $this->db->get()->num_rows();
    
        // Check in subject_assign table
        $this->db->select('subject_assign.id');
        $this->db->from('subject_assign');
        $this->db->where('subject_assign.teacher_id', get_loggedin_user_id());
        $this->db->where('subject_assign.session_id', get_session_id());
        $this->db->where('subject_assign.class_id', $classID);
        $q2 = $this->db->get()->num_rows();
    
        // Return true if either query finds a match
        if ($q1 > 0 || $q2 > 0) {
            return true;
        } else {
            return false;
        }
    }

    
    
    public function getAssign()
    {
        $this->db->select('*');
            $this->db->from('suject_assign');
            $query = $this->db->get();
            
            return $query;
    }
    
    
    
}
