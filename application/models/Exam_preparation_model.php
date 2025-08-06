<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Exam_preparation_model extends CI_Model
{
   
    public function __construct()

    {

        parent::__construct();
        $this->load->model('userrole_model');
    }
    
    public function get_my_attempts()
    {
        $stu = $this->userrole_model->getStudentDetails();
    
        $this->db->select('
            epa.*,
            epe.name as exam_name,
            eps.name as subject_name,
            epy.year as year_name
        ');
        $this->db->from('exam_preparation_attempts as epa');
        $this->db->join('exam_preparation_exams as epe', 'epe.id = epa.exam_id');
        $this->db->join('exam_preparation_subjects as eps', 'eps.id = epa.subject_id');
        $this->db->join('exam_preparation_years as epy', 'epy.id = epa.year_id');
        $this->db->where('epa.user_id', $stu['student_id']);
    
        $query = $this->db->get();
        return $query->result();
    }

    
    public function get_dropdown_options($table, $key = 'id', $value = 'name', $default_text = '-- Select Option --')
    {
        $this->db->select("$key, $value");
        $query = $this->db->get($table)->result_array();
        $options = ['' => $default_text];
    
        foreach ($query as $row) {
            $options[$row[$key]] = $row[$value];
        }
    
        return $options;
    }
    
    
    public function getExamQuestions($examID, $yearID, $subjectID)
    {
        $this->db->select('*')->from('exam_preparation_questions');
        $this->db->where('exam_id', $examID);
        $this->db->where('subject_id', $subjectID);
        $this->db->where('year_id', $yearID);
        $this->db->limit(20);
        $this->db->order_by('rand()');
        $query = $this->db->get();
        return $query->result();
    }
    
    
    public function getLeaderboardRanking()
    {
        $this->db->select('epa.user_id, SUM(epa.score) as max_score, SUM(epa.duration_in_seconds) as duration, e.class_id, c.name as class_name, s.last_name');
        $this->db->from('exam_preparation_attempts as epa');
        $this->db->join('enroll as e', 'e.student_id = epa.user_id');
        $this->db->join('student as s', 's.id = epa.user_id');
        $this->db->join('class as c', 'c.id = e.class_id');
        $this->db->group_by('epa.user_id');
        $this->db->order_by('max_score', 'DESC');
        $query = $this->db->get();
        return $query->result();

    }
}