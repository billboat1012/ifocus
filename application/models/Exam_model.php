<?php

if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}



class Exam_model extends CI_Model

{



    public function __construct()

    {

        parent::__construct();
        $this->load->model('marksheet_template_model');

    }



    public function getExamByID($id = null)

    {

        $sql = "SELECT `e`.*, `exam_term`.`name` as `term_name`, `b`.`name` as `branch_name` FROM `exam` as `e` INNER JOIN `branch` as `b` ON `b`.`id` = `e`.`branch_id` LEFT JOIN `exam_term` ON `exam_term`.`id` = `e`.`term_id` WHERE `e`.`id` = {$this->db->escape($id)}";

        return $this->db->query($sql)->row();

    }
    
    
    
    
public function getExamStudentScores($branchID, $classID, $examID, $sessionID)
{
    // Step 1: Fetch all students enrolled in the class for the given session and branch
    $this->db->select('en.student_id, en.roll, CONCAT_WS(" ", st.first_name, st.last_name) as student_name');
    $this->db->from('enroll as en');
    $this->db->join('student as st', 'st.id = en.student_id', 'inner');
    $this->db->where('en.class_id', $classID);
    $this->db->where('en.branch_id', $branchID);
    $this->db->where('en.session_id', $sessionID);
    $this->db->order_by('en.roll', 'ASC');
    $students = $this->db->get()->result_array();

    if (empty($students)) {
        return [
            'error' => 'No students found for the given class, branch, and session.',
        ];
    }

    // Step 2: Fetch all subjects for the given exam
    $this->db->select('te.subject_id, te.mark_distribution');
    $this->db->from('timetable_exam as te');
    $this->db->where('te.exam_id', $examID);
    $this->db->where('te.class_id', $classID);
    $this->db->where('te.branch_id', $branchID);
    $this->db->where('te.session_id', $sessionID);
    $subjects = $this->db->get()->result_array();

    if (empty($subjects)) {
        return [
            'error' => 'No subjects found for the given exam.',
        ];
    }

    // Step 3: Initialize variables for calculations
    $totalClassScore = 0;
    $totalStudents = count($students);

    // Step 4: Process each student
    foreach ($students as &$student) {
        $studentTotalMarks = 0;
        $studentTotalFullMarks = 0;

        // Step 5: Process each subject for the student
        foreach ($subjects as $subject) {
            $subjectID = $subject['subject_id'];
            $markDistribution = json_decode($subject['mark_distribution'], true);

            // Fetch the student's marks for the subject
            $this->db->select('mark');
            $this->db->from('mark');
            $this->db->where('student_id', $student['student_id']);
            $this->db->where('exam_id', $examID);
            $this->db->where('subject_id', $subjectID);
            $this->db->where('class_id', $classID);
            $this->db->where('branch_id', $branchID);
            $this->db->where('session_id', $sessionID);
            $markRow = $this->db->get()->row();

            if ($markRow) {
                $marks = json_decode($markRow->mark ?? '[]', true);

                // Sum up the marks for the subject
                foreach ($markDistribution as $index => $distribution) {
                    $obtainedMark = isset($marks[$index]) ? floatval($marks[$index]) : 0;
                    $fullMark = floatval($distribution['full_mark']);

                    $studentTotalMarks += $obtainedMark;
                    $studentTotalFullMarks += $fullMark;
                }
            }
        }

        // Calculate the student's average score
        $student['total_marks'] = $studentTotalMarks;
        $student['total_full_marks'] = $studentTotalFullMarks;
        $student['average_score'] = $studentTotalFullMarks > 0
            ? ($studentTotalMarks / $studentTotalFullMarks) * 100
            : 0;

        // Add the student's average score to the class total
        $totalClassScore += $student['average_score'];
    }

    // Step 6: Multiply the total class score by the number of students
    $finalClassScore = $totalClassScore / $totalStudents;

    // Step 7: Return the results
    return $finalClassScore; 
    // [
    //     'students' => $students,
    //     'total_class_score' => $totalClassScore,
    //     'final_class_score' => 
    //     // 'total_students' => $totalStudents,
    // ];
}


    public function getExamType($examId)
    {
        $this->db->select('type_id');
        $this->db->from('exam');
        $this->db->where('id', $examId);

        $result = $this->db->get()->row();
        return $result ? $result->type_id : null;
    }


    public function searchExamStudentsByRank($class_ID = '', $session_ID = '', $exam_ID = '', $branch_id = '')

    {

        $this->db->select('e.*,CONCAT_WS(" ",first_name, last_name) as fullname,register_no,c.name as class_name,exam_rank.rank,exam_rank.principal_comments,exam_rank.forms_teacher_comments,exam_rank.teacher_comments,exam_rank.punctualtiy,exam_rank.neatness,exam_rank.obedience,exam_rank.self_control,exam_rank.participation,exam_rank.use_of_intiative,exam_rank.handling,exam_rank.communication,exam_rank.realtionship,exam_rank.sports');

        $this->db->from('enroll as e');

        $this->db->join('student as s', 'e.student_id = s.id', 'inner');

        $this->db->join('login_credential as l', 'l.user_id = s.id and l.role = 7', 'inner');

        $this->db->join('class as c', 'e.class_id = c.id', 'left');

    
        $this->db->join('exam_rank', 'exam_rank.enroll_id=e.id and exam_rank.exam_id = ' . $this->db->escape($exam_ID), 'left');

        $this->db->where('e.class_id', $class_ID);

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
            
            'exam_category' => $data['exam_category'],
            
            'parent_exam_id' => $data['parent_exam_id'],
            
            'unique_identifier' => $data['unique_identifier'],

            'mark_distribution' => json_encode($data['mark_distribution']),

            'remark' => $data['remark'],

            'session_id' => get_session_id(),

            'status' => (isset($_POST['exam_publish']) ? 1 : 0),

            'publish_result' => 0,
            
            'next_terms' => $data['next_terms'] ?? NULL

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
            
            'slug' => $post['slug'],

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



    public function getSubjectList($examID, $classID, $sessionID)
    {

        $branchID = $this->application_model->get_branch_id();

        $this->db->select('t.*,s.name as subject_name');

        $this->db->from('timetable_exam as t');

        $this->db->join('subject as s', 's.id = t.subject_id', 'inner');

        $this->db->where('t.exam_id', $examID);

        $this->db->where('t.class_id', $classID);

        $this->db->where('t.session_id', $sessionID);

        $this->db->where('t.branch_id', $branchID);

        $this->db->group_by('t.subject_id');

        return $this->db->get()->result_array();

    }



    public function getTimetableDetail($classID, $examID, $subjectID)
    {
        $this->db->select('timetable_exam.mark_distribution');
        $this->db->where('class_id', $classID);
        $this->db->where('exam_id', $examID);
        $this->db->where('subject_id', $subjectID);
        $this->db->where('session_id', get_session_id());
    
        $result = $this->db->get('timetable_exam')->row_array();
    
        // Debug: Check if timetable detail is fetched
        if (!$result) {
            log_message('error', "Timetable not found for Class ID: $classID, Exam ID: $examID, Subject ID: $subjectID.");
        } else {
            log_message('debug', 'Timetable detail: ' . print_r($result, true));
        }
    
        return $result;
    }




    public function getMarkAndStudent($branchID, $classID, $examID, $subjectID)
    {
        // Fetch unique identifier for the exam
        $exam = $this->db->select('unique_identifier')
                         ->from('exam')
                         ->where('id', $examID)
                         ->get()
                         ->row_array();
    
        if (!$exam) {
            log_message('error', "Exam with ID $examID not found.");
            return [];
        }
    
        // Main query to fetch student data along with marks
        $this->db->select('en.*, 
                           st.first_name, 
                           st.last_name, 
                           st.register_no, 
                           st.category_id, 
                           subject.name as subject_name, 
                           IFNULL(m.mark, 0) as get_mark, 
                           IFNULL(m.sub_mark, 0) as get_sub_mark, 
                           IFNULL(m.absent, 0) as get_abs, 
                           IFNULL(m.n_a, 0) as n_a'); 
        $this->db->from('enroll as en');
        $this->db->join('student as st', 'st.id = en.student_id', 'inner');
        $this->db->join('subject', 'subject.id = ' . $this->db->escape($subjectID), 'left');
        $this->db->join("(SELECT student_id, class_id, exam_id, subject_id, sub_subject_id, mark, sub_mark, absent, n_a 
                          FROM mark 
                          WHERE exam_id = " . $this->db->escape($examID) . " 
                          AND subject_id = " . $this->db->escape($subjectID) . " 
                          GROUP BY student_id, class_id, subject_id) as m", 
                        'm.student_id = en.student_id AND m.class_id = en.class_id', 'left');
        $this->db->where('en.class_id', $classID);
        $this->db->where('en.branch_id', $branchID);
        $this->db->where('en.session_id', get_session_id());
        $this->db->group_by('en.student_id'); // Ensure one row per student
        $this->db->order_by('en.roll', 'ASC');
    
        $students = $this->db->get()->result_array();
    
        if (empty($students)) {
            log_message('error', "No students found for Class ID: $classID, Branch ID: $branchID.");
            return [];
        }
    
        // Additional processing for examination-type exams
        if ($exam['unique_identifier'] == 'examination') {
            foreach ($students as &$student) {
                $student_id = $student['student_id'];
    
                // Fetch related exams (e.g., 1st CA, 2nd CA) for the student
                $related_exams = $this->db->select('mark.mark, mark.n_a, exam.unique_identifier')
                                          ->from('mark')
                                          ->join('exam', 'exam.id = mark.exam_id')
                                          ->where('mark.student_id', $student_id)
                                          ->where('mark.class_id', $classID)
                                          ->where('mark.subject_id', $subjectID)
                                          ->where('exam.parent_exam_id', $examID)
                                          ->get()
                                          ->result_array();
    
                $first_ca_total = 0;
                $second_ca_total = 0;
    
                // Process related exams to calculate totals
                foreach ($related_exams as $related_exam) {
                    if ($related_exam['unique_identifier'] == '1st_ca') {
                        $first_ca_total = $related_exam['mark'];
                    } elseif ($related_exam['unique_identifier'] == '2nd_ca') {
                        $second_ca_total = $related_exam['mark'];
                    }
                }
    
                $student['first_ca_total'] = $first_ca_total;
                $student['second_ca_total'] = $second_ca_total;
            }
        }
    
        // Log the final result for debugging
        log_message('debug', 'Final student data: ' . print_r($students, true));
    
        return $students;
    }


    
    
    
    public function getStudentsForAttendance($branchID, $classID, $sessionID = null)
    {
        $this->db->select('st.id, st.first_name, st.last_name, st.register_no, st.category_id');
        $this->db->from('enroll as en');
        $this->db->join('student as st', 'st.id = en.student_id', 'inner');
        
        $this->db->where('en.class_id', $classID);
        $this->db->where('en.branch_id', $branchID);
        $this->db->where('en.session_id', $sessionID);
        $this->db->order_by('en.roll', 'ASC');
    
        return $this->db->get()->result_array();
    }
    
    public function getStudentsForHostelComments($branchID, $classID, $examID)
    {
        $this->db->select('
            en.id as enroll_id,
            st.id as student_id,
            st.first_name,
            st.last_name,
            st.register_no,
            en.roll,
            en.class_id,
            en.branch_id,
            exam_rank.hostel_comment
        ');
        $this->db->from('enroll as en');
        $this->db->join('student as st', 'st.id = en.student_id', 'inner');
        $this->db->join('exam_rank', 'exam_rank.enroll_id = en.id AND exam_rank.exam_id = ' . (int)$examID, 'left');
        $this->db->where('en.class_id', $classID);
        $this->db->where('en.branch_id', $branchID);
        $this->db->where('en.session_id', get_session_id());
        $this->db->order_by('en.roll', 'ASC');
    
        return $this->db->get()->result_array();
    }






    public function getStudentReportCard($studentID, $examID, $sessionID, $classID = '')
    {
        $result = array();
    
        // Fetch student details
        $this->db->select('
            s.*, 
            CONCAT_WS(" ", s.first_name, s.last_name) as name, 
            e.id as enrollID, 
            e.roll, 
            e.branch_id, 
            e.session_id, 
            e.class_id, 
            c.name as class, 
            sc.name as category, 
            IFNULL(p.father_name, "N/A") as father_name, 
            IFNULL(p.mother_name, "N/A") as mother_name, 
            br.name as institute_name, 
            br.email as institute_email, 
            br.address as institute_address, 
            br.mobileno as institute_mobile_no,
        ');
        $this->db->from('enroll as e');
        $this->db->join('student as s', 'e.student_id = s.id', 'inner');
        $this->db->join('class as c', 'e.class_id = c.id', 'left');
        $this->db->join('student_category as sc', 's.category_id = sc.id', 'left');
        $this->db->join('parent as p', 'p.id = s.parent_id', 'left');
        $this->db->join('branch as br', 'br.id = e.branch_id', 'left');
    
        $this->db->where('e.student_id', $studentID);
        $this->db->where('e.session_id', $sessionID);
    
        if (!empty($classID)) {
            $this->db->where('e.class_id', $classID);
        }
    
        $result['student'] = $this->db->get()->row_array();
    
        // Fetch exam marks
        $this->db->select('
            m.mark as get_mark, 
            IFNULL(m.absent, 0) as get_abs, 
            subject.name as subject_name, 
            te.mark_distribution, 
            m.subject_id, 
            m.n_a
        ');
        $this->db->from('mark as m');
        $this->db->join('subject', 'subject.id = m.subject_id', 'left');
        $this->db->join('timetable_exam as te', 'te.exam_id = m.exam_id AND te.class_id = m.class_id AND te.subject_id = m.subject_id', 'left');
    
        $this->db->where('m.exam_id', $examID);
        $this->db->where('m.student_id', $studentID);
        $this->db->where('m.session_id', $sessionID);
    
        if (!empty($classID)) {
            $this->db->where('m.class_id', $classID);
        }
    
        $this->db->group_by('m.subject_id');
        $this->db->order_by('subject.id', 'ASC');
    
        $examResults = $this->db->get()->result_array();
        
        $filteredResults = array_filter($examResults, function ($exam) {
            $marks = json_decode($exam['get_mark'] ?? '[]', true);
            return !empty($marks) && array_sum($marks) > 0;
        });
    
        $result['exam'] = array_values($filteredResults);
        
        $this->db->select('exam.*, exam_term.name AS term_name');
        $this->db->from('exam');
        $this->db->join('exam_term', 'exam_term.id = exam.term_id', 'left');
        $this->db->where('exam.id', $examID);
        $getExam = $this->db->get()->row_array();
        $result['student']['resumption_date'] = $getExam['next_terms'];
        $result['student']['term'] = $getExam['term_name'];
        
        if ($getExam) {
            $termInfo = $this->marksheet_template_model->getExamTermFor3rdTerm($getExam['term_id']);
            
            $result['student']['is_third_term'] = ($termInfo == '3') ? 1 : 0;
    
            if ($termInfo && $termInfo == '3') {
                foreach ($result['exam'] as &$subject) {
                    $subjectID = $subject['subject_id'];
                    $subjectTotals = ['1' => 0, '2' => 0];
    
                    foreach ($subjectTotals as $termName => &$total) {
                        $term = $this->db->get_where('exam_term', ['slug' => $termName, 'branch_id' => $result['student']['branch_id']])->row_array();
                        if ($term) {
                            $termExams = $this->db->get_where('exam', [
                                'term_id' => $term['id'],
                                'session_id' => $sessionID
                            ])->result_array();
    
                            $examIDs = array_column($termExams, 'id');
                            if (!empty($examIDs)) {
                                $this->db->select('mark');
                                $this->db->from('mark');
                                $this->db->where_in('exam_id', $examIDs);
                                $this->db->where('student_id', $studentID);
                                $this->db->where('session_id', $sessionID);
                                $this->db->where('subject_id', $subjectID);
                                if (!empty($classID)) {
                                    $this->db->where('class_id', $classID);
                                }
    
                                $subjectMarks = $this->db->get()->result_array();
                                foreach ($subjectMarks as $markRow) {
                                    $decoded = json_decode($markRow['mark'], true);
                                    if (is_array($decoded)) {
                                        $total += array_sum($decoded);
                                    }
                                }
                            }
                        }
                    }
    
                    // 🔥 Attach subject totals to the subject array
                    $subject['first_term_total'] = $subjectTotals['1'];
                    $subject['second_term_total'] = $subjectTotals['2'];
                    
                    $currentMark = 0;
                    $decodedCurrent = json_decode($subject['get_mark'], true);
                    if (is_array($decodedCurrent)) {
                        $currentMark = array_sum($decodedCurrent);
                    }
                    
                    // 🧮 Calculate Section Average
                    $sumOfTerms = $subjectTotals['1'] + $subjectTotals['2'] + $currentMark;
                    $subject['session_average'] = round($sumOfTerms / 3, 2); 
                }
            }
        }
    
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
        $this->db->where('subject_id', $subjectID); 
        
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
    
    
    public function getMarkBySubSubjectID($studentID, $subjectID, $examID, $subSubject_id)
{
    // Select all columns from the mark table
    $this->db->select('*');
    $this->db->from('mark');
    $this->db->where('student_id', $studentID);
    $this->db->where('subject_id', $subjectID);
    $this->db->where('sub_subject_id', $subSubject_id);
    $this->db->where('exam_id', $examID);
    
    $markRow = $this->db->get()->row();
    
    if ($markRow) {
        $marks = json_decode($markRow->mark, true);
        $firstMark = reset($marks);
        return $firstMark;
    }

    return null;
}

// public function getMarkBySubSubjectID($studentID, $subjectID, $examID, $subSubjectID = null)
// {
//     $this->db->select('*');
//     $this->db->from('mark');
//     $this->db->where('student_id', $studentID);
//     $this->db->where('subject_id', $subjectID);
//     $this->db->where('exam_id', $examID);

//     if ($subSubjectID !== null) {
//         $this->db->where('sub_subject_id', $subSubjectID); // only if this column exists
//     }

//     $markRow = $this->db->get()->row();

//     if ($markRow) {
//         return json_decode($markRow->mark, true); // return full mark array
//     }

//     return [];
// }



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
                    'exam_id' => $data['exam_id'],
                    'days_present' => $data['days_present'][$key],
                    'total_days' => $data['total_days'],
                );
    
                $this->db->where('student_id', $student_id);
                $this->db->where('class_id', $data['class_id']);
                $this->db->where('session_id', $data['session_id']);
                $this->db->where('exam_id', $data['exam_id']);
                $this->db->where('branch_id', $data['branch_id']);
                $studentData = $this->db->get('attendance_update');
    
                if ($studentData->num_rows() === 0) {
                    $this->db->insert('attendance_update', $arrayData);
                } else {
                    $this->db->where('student_id', $student_id);
                    $this->db->where('class_id', $data['class_id']);
                    $this->db->where('session_id', $data['session_id']);
                    $this->db->where('exam_id', $data['exam_id']);
                    $this->db->where('branch_id', $data['branch_id']);
                    $this->db->update('attendance_update', $arrayData);
                }
            }
        }
    }
    
    
    public function getManualAttendance($branchID, $classID, $examID = null, $sessionID = null)
    {
        $this->db->select('student_id, days_present, total_days');
        $this->db->from('attendance_update');
        $this->db->where('class_id', $classID);
        $this->db->where('session_id', $sessionID);
        $this->db->where('branch_id', $branchID);
    
        if (!is_null($examID) && $examID !== '') {
            // Match specific exam_id
            $this->db->where('exam_id IS NULL', null, false);
        } else {
            // Include only rows where exam_id IS NULL
            $this->db->where('exam_id', $examID);
        }
    
        $studentArray = $this->db->get()->result_array();
        
        return !empty($studentArray) ? $studentArray : null;
    }



    public function getStudentTabMark($branchID, $classID, $examID, $subjectID, $registerNo)
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





