<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Timetable_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // class wise information save
    public function classwise_save($data)
    {
        $branchID   = $this->application_model->get_branch_id();
        $classID    = $data['class_id'];
        $sessionID  = get_session_id();
        $day        = $data['day'];
        $arrayItems = $this->input->post('timetable');
        if (!empty($arrayItems)) {
            foreach ($arrayItems as $key => $value) {
                if (!isset($value['break'])) {
                    $subjectID  = $value['subject'];
                    $teacherID  = $value['teacher'];
                    $break      = false;
                } else {
                    $subjectID  = 0;
                    $teacherID  = 0;
                    $break      = true;
                }
                $timeStart = date("H:i:s", strtotime($value['time_start']));
                $timeEnd = date("H:i:s", strtotime($value['time_end']));
                $roomNumber = $value['class_room'];
                if (!empty($timeStart) && !empty($timeEnd)) {
                    $arrayRoutine = array(
                        'class_id'      => $classID,
                        'subject_id'    => $subjectID,
                        'teacher_id'    => $teacherID,
                        'time_start'    => $timeStart,
                        'time_end'      => $timeEnd,
                        'class_room'    => $roomNumber,
                        'session_id'    => $sessionID,
                        'branch_id'     => $branchID,
                        'break'         => $break,
                        'day'           => $day,
                    );
                    if ($data['old_id'][$key] == 0) {
                        $this->db->insert('timetable_class', $arrayRoutine);
                    } else {
                        $this->db->where('id', $data['old_id'][$key]);
                        $this->db->update('timetable_class', $arrayRoutine);
                    }
                }
            }
        }
    
        $arrayI = (isset($data['i'])) ? $data['i'] : array();
        $preserve_array = (isset($data['old_id'])) ? $data['old_id'] : array();
        $deleteArray = array_diff($arrayI, $preserve_array);
        if (!empty($deleteArray)) {
            $this->db->where_in('id', $deleteArray);
            $this->db->delete('timetable_class');
        }
        
    }

    public function getExamTimetableList($classID, $branchID)
    {
        $sessionID = get_session_id();
        $this->db->select('t.*,b.name as branch_name');
        $this->db->from('timetable_exam as t');
        $this->db->join('branch as b', 'b.id = t.branch_id', 'left');
        $this->db->where('t.branch_id', $branchID);
        $this->db->where('t.class_id', $classID);
        $this->db->where('t.session_id', $sessionID);
        $this->db->order_by('t.id', 'asc');
        $this->db->group_by('t.exam_id');
        return $this->db->get()->result_array();
    }

    public function getSubjectExam($classID, $examID, $branchID)
    {
        $sessionID = get_session_id();
    
        // Include subject_category in the query
        $sql = "
            SELECT sa.*, s.name as subject_name, s.subject_category, te.time_start, te.time_end, te.hall_id, te.exam_date, te.mark_distribution
            FROM subject_assign as sa
            LEFT JOIN subject as s ON s.id = sa.subject_id
            LEFT JOIN timetable_exam as te 
                ON te.class_id = sa.class_id
                AND te.subject_id = sa.subject_id 
                AND te.session_id = sa.session_id 
                AND te.exam_id = " . $this->db->escape($examID) . "
            WHERE sa.class_id = " . $this->db->escape($classID) . "
            AND sa.branch_id = " . $this->db->escape($branchID) . "
            AND sa.session_id = " . $this->db->escape($sessionID);
    
        $query = $this->db->query($sql);
        $subjects = $query->result_array();
        
        
    
        // Fetch exam category to compare with subject category
        $this->db->select('exam_category');
        $this->db->from('exam');
        $this->db->where('id', $examID);
        $examQuery = $this->db->get();
        $exam = $examQuery->row_array();
        
        // Filter subjects based on category match
        $filteredSubjects = [];
        foreach ($subjects as $subject) {
            if (isset($subject['subject_category']) && isset($exam['exam_category'])) {
                if ($subject['subject_category'] == $exam['exam_category']) {
                    $filteredSubjects[] = $subject; // Add to filtered list if categories match
                }
            }
        }
    
        return $filteredSubjects;
    }

    // public function getSubjectExam($classID, $sectionID, $examID, $branchID)
    // {
    //     $sessionID  = get_session_id();
    //     $sql = "SELECT sa.*, s.name as subject_name, te.time_start, te.time_end, te.hall_id, te.exam_date, te.mark_distribution FROM subject_assign as sa
    //     LEFT JOIN subject as s ON s.id = sa.subject_id LEFT JOIN timetable_exam as te ON te.class_id = sa.class_id and
    //     te.subject_id = sa.subject_id and te.session_id = sa.session_id and te.exam_id = " . $this->db->escape($examID) . " WHERE sa.class_id = " .
    //     $this->db->escape($classID) . " AND sa.branch_id = " .
    //     $this->db->escape($branchID) . " AND sa.session_id = " . $this->db->escape($sessionID);
    //     $query = $this->db->query($sql);
    //     return $query->result_array();
    // }

    public function getExamTimetableByModal($examID, $classID, $branchID = '')
    {
        $sessionID = get_session_id();
        $this->db->select('t.*,s.name as subject_name,eh.hall_no');
        $this->db->from('timetable_exam as t');
        $this->db->join('subject as s', 's.id = t.subject_id', 'left');
        $this->db->join('exam_hall as eh', 'eh.id = t.hall_id', 'left');
        if (!empty($branchID)) {
            $this->db->where('t.branch_id', $branchID);
        } else {
            if (!is_superadmin_loggedin()) {
                $this->db->where('t.branch_id', get_loggedin_branch_id());
            }
        }
        $this->db->where('t.exam_id', $examID);
        $this->db->where('t.class_id', $classID);
        $this->db->where('t.session_id', $sessionID);
        return $this->db->get();
    }
    
    public function getExamType($examId)
    {
        $this->db->select('type_id');
        $this->db->from('exam');
        $this->db->where('id', $examId);

        $result = $this->db->get()->row();
        return $result ? $result->type_id : null;
    }
    
    public function getExamMarks($examId)
{
    $this->db->select('mark_distribution');
    $this->db->from('exam');
    $this->db->where('id', $examId);

    $result = $this->db->get()->row();

    if ($result && $result->mark_distribution) {
        // Decode the JSON string
        $distributionArray = json_decode($result->mark_distribution, true);
        
        // Convert to an associative array
        $associativeArray = [];
        if (is_array($distributionArray)) {
            foreach ($distributionArray as $value) {
                $associativeArray[$value] = $value;
            }
        }
        
        return $associativeArray;
    }
    
    return null;
}



}
