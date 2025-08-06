<?php

if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}



class Exam_model extends CI_Model

{



    public function __construct()

    {

        parent::__construct();

    }



    public function getExamByID($id = null)

    {

        $sql = "SELECT `e`.*, `exam_term`.`name` as `term_name`, `b`.`name` as `branch_name` FROM `exam` as `e` INNER JOIN `branch` as `b` ON `b`.`id` = `e`.`branch_id` LEFT JOIN `exam_term` ON `exam_term`.`id` = `e`.`term_id` WHERE `e`.`id` = {$this->db->escape($id)}";

        return $this->db->query($sql)->row();

    }



    public function getExamType($examId)
    {
        $this->db->select('type_id');
        $this->db->from('exam');
        $this->db->where('id', $examId);

        $result = $this->db->get()->row();
        return $result ? $result->type_id : null;
    }


    public function searchExamStudentsByRank($class_ID = '', $section_ID = '', $session_ID = '', $exam_ID = '', $branch_id = '')

    {

        $this->db->select('e.*,CONCAT_WS(" ",first_name, last_name) as fullname,register_no,c.name as class_name,se.name as section_name,exam_rank.rank,exam_rank.principal_comments,exam_rank.teacher_comments,exam_rank.punctualtiy,exam_rank.neatness,exam_rank.obedience,exam_rank.self_control,exam_rank.participation,exam_rank.use_of_intiative,exam_rank.handling,exam_rank.communication,exam_rank.realtionship,exam_rank.sports');

        $this->db->from('enroll as e');

        $this->db->join('student as s', 'e.student_id = s.id', 'inner');

        $this->db->join('login_credential as l', 'l.user_id = s.id and l.role = 7', 'inner');

        $this->db->join('class as c', 'e.class_id = c.id', 'left');

        $this->db->join('section as se', 'e.section_id=se.id', 'left');

        $this->db->join('exam_rank', 'exam_rank.enroll_id=e.id and exam_rank.exam_id = ' . $this->db->escape($exam_ID), 'left');

        $this->db->where('e.class_id', $class_ID);

        if (!empty($section_ID)) {

            $this->db->where('e.section_id', $section_ID);

        }

        $this->db->where('e.branch_id', $branch_id);

        $this->db->where('e.session_id', $session_ID);

        $this->db->order_by('exam_rank.rank', 'ASC');

        $this->db->where('l.active', 1);

        return $this->db->get()->result();

    }



    public function getExamList()

    {

        $this->db->select('e.*,b.name as branch_name');

        $this->db->from('exam as e');

        $this->db->join('branch as b', 'b.id = e.branch_id', 'left');

        if (!is_superadmin_loggedin()) {

            $this->db->where('e.branch_id', get_loggedin_branch_id());

        }

        $this->db->where('e.session_id', get_session_id());

        $this->db->order_by('e.id', 'asc');

        return $this->db->get()->result_array();

    }



    public function exam_save($data)

    {

        $arrayExam = array(

            'name' => $data['name'],

            'branch_id' => $this->application_model->get_branch_id(),

            'term_id' => $data['term_id'],

            'type_id' => $data['type_id'],

            'mark_distribution' => json_encode($data['mark_distribution']),

            'remark' => $data['remark'],

            'session_id' => get_session_id(),

            'status' => (isset($_POST['exam_publish']) ? 1 : 0),

            'publish_result' => 0,

        );

        if (!isset($data['exam_id'])) {

            $this->db->insert('exam', $arrayExam);

        } else {

            $this->db->where('id', $data['exam_id']);

            $this->db->update('exam', $arrayExam);

        }

    }



    public function termSave($post)

    {

        $arrayTerm = array(

            'name' => $post['term_name'],

            'branch_id' => $this->application_model->get_branch_id(),

            'session_id' => get_session_id(),

        );

        if (!isset($post['term_id'])) {

            $this->db->insert('exam_term', $arrayTerm);

        } else {

            if (!is_superadmin_loggedin()) {

                $this->db->where('branch_id', get_loggedin_branch_id());

            }

            $this->db->where('id', $post['term_id']);

            $this->db->update('exam_term', $arrayTerm);

        }

    }



    public function hallSave($post)

    {

        $arrayHall = array(

            'hall_no' => $post['hall_no'],

            'seats' => $post['no_of_seats'],

            'branch_id' => $this->application_model->get_branch_id(),

        );

        if (!isset($post['hall_id'])) {

            $this->db->insert('exam_hall', $arrayHall);

        } else {

            if (!is_superadmin_loggedin()) {

                $this->db->where('branch_id', get_loggedin_branch_id());

            }

            $this->db->where('id', $post['hall_id']);

            $this->db->update('exam_hall', $arrayHall);

        }

    }



    public function gradeSave($data)

    {

        $arrayData = array(

            'branch_id' => $this->application_model->get_branch_id(),

            'name' => $data['name'],

            'grade_point' => $data['grade_point'],

            'lower_mark' => $data['lower_mark'],

            'upper_mark' => $data['upper_mark'],

            'remark' => $data['remark'],

        );

        // posted all data XSS filtering

        if (!isset($data['grade_id'])) {

            $this->db->insert('grade', $arrayData);

        } else {

            if (!is_superadmin_loggedin()) {

                $this->db->where('branch_id', get_loggedin_branch_id());

            }

            $this->db->where('id', $data['grade_id']);

            $this->db->update('grade', $arrayData);

        }

    }



    public function get_grade($mark, $branch_id)

    {

        $this->db->where('branch_id', $branch_id);

        $query = $this->db->get('grade');

        $grades = $query->result_array();

        foreach ($grades as $row) {

            if ($mark >= $row['lower_mark'] && $mark <= $row['upper_mark']) {

                return $row;

            }

        }

    }



    public function getSubjectList($examID, $classID, $sectionID, $sessionID)

    {

        $branchID = $this->application_model->get_branch_id();

        $this->db->select('t.*,s.name as subject_name');

        $this->db->from('timetable_exam as t');

        $this->db->join('subject as s', 's.id = t.subject_id', 'inner');

        $this->db->where('t.exam_id', $examID);

        $this->db->where('t.class_id', $classID);

        $this->db->where('t.section_id', $sectionID);

        $this->db->where('t.session_id', $sessionID);

        $this->db->where('t.branch_id', $branchID);

        $this->db->group_by('t.subject_id');

        return $this->db->get()->result_array();

    }



    public function getTimetableDetail($classID, $sectionID, $examID, $subjectID)

    {

        $this->db->select('timetable_exam.mark_distribution');

        $this->db->where('class_id', $classID);

        $this->db->where('section_id', $sectionID);

        $this->db->where('exam_id', $examID);

        $this->db->where('subject_id', $subjectID);

        $this->db->where('session_id', get_session_id());

        return $this->db->get('timetable_exam')->row_array();

    }



    public function getMarkAndStudent($branchID, $classID, $sectionID, $examID, $subjectID)
{
    $this->db->select('en.*, st.first_name, st.last_name, st.register_no, st.category_id, m.mark as get_mark, m.sub_mark as get_sub_mark, IFNULL(m.absent, 0) as get_abs, subject.name as subject_name');
    $this->db->from('enroll as en');
    $this->db->join('student as st', 'st.id = en.student_id', 'inner');
    $this->db->join('subject', 'subject.id = ' . $this->db->escape($subjectID), 'left');

    // Conditional join to get marks, including cases with NULL sub_subject_id
    $this->db->join("(SELECT student_id, class_id, section_id, exam_id, subject_id, sub_subject_id, mark, sub_mark, absent 
                      FROM mark 
                      WHERE exam_id = " . $this->db->escape($examID) . " 
                      AND subject_id = " . $this->db->escape($subjectID) . ") as m", 
                    'm.student_id = en.student_id and m.class_id = en.class_id and m.section_id = en.section_id', 'left');

    $this->db->where('en.class_id', $classID);
    $this->db->where('en.section_id', $sectionID);
    $this->db->where('en.branch_id', $branchID);
    $this->db->where('en.session_id', get_session_id());
    $this->db->order_by('en.roll', 'ASC');

    return $this->db->get()->result_array();
}

    
    
    
    public function getStudentsForAttendance($branchID, $classID, $sectionID)
    {
        $this->db->select('st.id, st.first_name, st.last_name, st.register_no, st.category_id');
        $this->db->from('enroll as en');
        $this->db->join('student as st', 'st.id = en.student_id', 'inner');
        
        $this->db->where('en.class_id', $classID);
        $this->db->where('en.section_id', $sectionID);
        $this->db->where('en.branch_id', $branchID);
        $this->db->where('en.session_id', get_session_id());
        $this->db->order_by('en.roll', 'ASC');
    
        return $this->db->get()->result_array();
    }





    public function getStudentReportCard($studentID, $examID, $sessionID, $classID = '', $sectionID = '')

    {

        $result = array();



        $this->db->select('s.*,CONCAT_WS(" ",s.first_name, s.last_name) as name,e.id as enrollID,e.roll,e.branch_id,e.session_id,e.class_id,e.section_id,c.name as class,se.name as section,sc.name as category,IFNULL(p.father_name,"N/A") as father_name,IFNULL(p.mother_name,"N/A") as mother_name,br.name as institute_name,br.email as institute_email,br.address as institute_address,br.mobileno as institute_mobile_no');

        $this->db->from('enroll as e');

        $this->db->join('student as s', 'e.student_id = s.id', 'inner');

        $this->db->join('class as c', 'e.class_id = c.id', 'left');

        $this->db->join('section as se', 'e.section_id = se.id', 'left');

        $this->db->join('student_category as sc', 's.category_id=sc.id', 'left');

        $this->db->join('parent as p', 'p.id=s.parent_id', 'left');

        $this->db->join('branch as br', 'br.id = e.branch_id', 'left');

        $this->db->where('e.student_id', $studentID);

        $this->db->where('e.session_id', $sessionID);

        if (!empty($classID))

            $this->db->where('e.class_id', $classID);

        if (!empty($sectionID))

            $this->db->where('e.section_id', $sectionID);

        $result['student'] = $this->db->get()->row_array();



        $this->db->select('m.mark as get_mark,IFNULL(m.absent, 0) as get_abs,subject.name as subject_name, te.mark_distribution, m.subject_id');

        $this->db->from('mark as m');

        $this->db->join('subject', 'subject.id = m.subject_id', 'left');

        $this->db->join('timetable_exam as te', 'te.exam_id = m.exam_id and te.class_id = m.class_id and te.section_id = m.section_id and te.subject_id = m.subject_id', 'left');

        $this->db->where('m.exam_id', $examID);

        $this->db->where('m.student_id', $studentID);

        $this->db->where('m.session_id', $sessionID);

        if (!empty($classID))

            $this->db->where('m.class_id', $classID);

        if (!empty($sectionID))

            $this->db->where('m.section_id', $sectionID);

        $this->db->group_by('m.subject_id');

        $this->db->order_by('subject.id', 'ASC');

        $result['exam'] = $this->db->get()->result_array();

        return $result;

    }

    
    public function getPlayGroupStudentMark($examID, $subjectID, $studentID)
    {
        $this->db->select('mark');
        $this->db->from('mark');
        $this->db->where('student_id', $studentID);
        $this->db->where('exam_id', $examID);
        $this->db->where('subject_id', $subjectID);
        
        $result = $this->db->get()->row();
        return $result ? $result->mark : null;
    }
    
    
        public function getSubSubjectId($subjectID)
    {
        $this->db->select('id, sub_subject_text');
        $this->db->from('sub_subject');
        $this->db->where('subject_id', $subjectID); // Assuming 'subject_id' is the correct column name
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return array_column($query->result_array(), 'sub_subject_text', 'id');
        } else {
            return []; 
        }
    }
    
    
    public function getAbsentStatusBySubSub($subjectID, $subSubjectID, $examID, $studentID)
    {
        $this->db->select('absent');
        $this->db->from('mark');
        $this->db->where('student_id', $studentID);
        $this->db->where('subject_id', $subjectID);
        $this->db->where('exam_id', $examID);
        $this->db->where('sub_subject_id', $subSubjectID);
        
        $result = $this->db->get()->row();
        return $result ? $result->absent : null;
    }
    
    
    public function getMarkBySubSubject($subjectID, $subSubjectID, $examID, $studentID)
    {
        $this->db->select('mark');
        $this->db->from('mark');
        $this->db->where('student_id', $studentID);
        $this->db->where('subject_id', $subjectID);
        $this->db->where('exam_id', $examID);
        $this->db->where('sub_subject_id', $subSubjectID);
        
        $result = $this->db->get()->row();
        
        if ($result) {
            $marksArray = json_decode($result->mark, true);
            if (is_array($marksArray) && !empty($marksArray)) {
                $keys = array_keys($marksArray);
                return $keys[0];
            }
        }
        
        return null;
    }
    
    public function getMarksForPlayGroupStudent($studentID, $examID)
    {
        
        $result = array();
        
        $this->db->select('*');
        $this->db->from('mark');
        $this->db->where('student_id', $studentID);
        $this->db->where('exam_id', $examID);
        
        $marks = $this->db->get()->row();
        
        
        return $marks ? $marks : null;
    }
    
    
    public function getMarkBySubSubjectID($studentID, $subjectID, $examID)
{
    // Select all columns from the mark table
    $this->db->select('*');
    $this->db->from('mark');
    $this->db->where('student_id', $studentID);
    $this->db->where('subject_id', $subjectID);
    $this->db->where('exam_id', $examID);

    // Get the row
    $markRow = $this->db->get()->row();

    // Check if a result was found
    if ($markRow) {
        // Decode the JSON mark column
        $marks = json_decode($markRow->mark, true);

        // Get the first key-value pair
        $firstMark = reset($marks);

        return $firstMark;
    }

    return null;
}


    public function get_unique_exam_ids($student_id, $branchID) {
        $this->db->distinct();
        $this->db->select('exam_id');
        $this->db->from('mark');
        $this->db->where('student_id', $student_id);
        $query = $this->db->get();
        $exam_ids = $query->result_array();

        $exam_array = array();

        foreach ($exam_ids as $exam) {
            $exam_id = $exam['exam_id'];
            $this->db->select('id, name');
            $this->db->from('exam');
            $this->db->where('id', $exam_id);
            $this->db->where('branch_id', $branchID);
            $this->db->where('session_id', get_session_id());
            $exam_query = $this->db->get();
            $exam_details = $exam_query->row();

            if ($exam_details) {
                $exam_array[$exam_details->id] = $exam_details->name;
            }
        }

        return $exam_array;
    }
    
    
    public function manual_attendance_update($data)
    {
        foreach ($data['student_id'] as $key => $student_id) {
            if (!empty($data['days_present'][$key])) {
                $arrayData = array(
                    'branch_id' => $data['branch_id'],
                    'student_id' => $student_id,
                    'class_id' => $data['class_id'],
                    'session_id' => $data['session_id'],
                    'section_id' => $data['section_id'],
                    'days_present' => $data['days_present'][$key],
                    'total_days' => $data['total_days'],
                );
    
                $this->db->where('student_id', $student_id);
                $this->db->where('class_id', $data['class_id']);
                $this->db->where('session_id', $data['session_id']);
                $this->db->where('section_id', $data['section_id']);
                $this->db->where('branch_id', $data['branch_id']);
                $studentData = $this->db->get('attendance_update');
    
                if ($studentData->num_rows() === 0) {
                    $this->db->insert('attendance_update', $arrayData);
                } else {
                    $this->db->where('student_id', $student_id);
                    $this->db->where('class_id', $data['class_id']);
                    $this->db->where('session_id', $data['session_id']);
                    $this->db->where('section_id', $data['section_id']);
                    $this->db->where('branch_id', $data['branch_id']);
                    $this->db->update('attendance_update', $arrayData);
                }
            }
        }
    }
    
    
    public function getManualAttendance($branchID, $classID, $sectionID)
    {
        $this->db->select('student_id, days_present, total_days');
        $this->db->where('class_id', $classID);
        $this->db->where('section_id', $sectionID);
        $this->db->where('branch_id', $branchID);
        $this->db->from('attendance_update');
        $studentArray = $this->db->get()->result_array();
        
        return !empty($studentArray) ? $studentArray : null;
    }



    public function getStudentTabMark($branchID, $classID, $sectionID, $examID, $subjectID, $registerNo)
    {
        $this->db->select('id as student_id');
        $this->db->where('register_no', $registerNo);
        $this->db->from('student');
        $stud = $this->db->get()->row();
    
        if ($stud) {
            
            $this->db->select('mark');
            $this->db->where('student_id', $stud->student_id);
            $this->db->where('exam_id', $examID);
            $this->db->where('branch_id', $branchID);
            $this->db->where('class_id', $classID);
            $this->db->where('subject_id', $subjectID);
            $this->db->from('mark');
            
            $studentMark = $this->db->get()->row();
            
            return $studentMark ? $studentMark->mark : null;
        }
    
        return null;
        
    }




}




