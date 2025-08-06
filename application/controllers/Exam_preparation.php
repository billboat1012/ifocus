<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @package : Ramom school management system
 * @version : 6.5
 * @developed by : RamomCoder
 * @support : ramomcoder@yahoo.com
 * @author url : http://codecanyon.net/user/RamomCoder
 * @filename : Exam_preparation.php
 * @copyright : Reserved RamomCoder Team
 */

class Exam_preparation extends User_Controller
{
    
    // protected $examPrepModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('exam_preparation_model');
        $this->load->model('userrole_model');
    }

    public function index()
    {
        
        
        $this->data['attempts'] = $this->exam_preparation_model->get_my_attempts();
        $this->data['subjects'] = $this->exam_preparation_model->get_dropdown_options('exam_preparation_subjects', 'id', 'name');
        $this->data['exams'] = $this->exam_preparation_model->get_dropdown_options('exam_preparation_exams', 'id', 'name');
        $this->data['years'] = $this->exam_preparation_model->get_dropdown_options('exam_preparation_years', 'id', 'year');
        $this->data['title'] = translate('exam_preparation');
        $this->data['sub_page'] = 'exam_preparation/index';
        $this->data['main_menu'] = 'exam_preparation';
        $this->load->view('layout/index', $this->data);
    }
    
    public function take_exam()
    {
        if($_POST)
        {
            $examID = $this->input->post('exam_id');
            $yearID = $this->input->post('year_id');
            $subjectID = $this->input->post('subject_id');
            
            $this->db->select('e.name as exam_name, s.name as subject_name, y.year as year_name');
            $this->db->from('exam_preparation_questions as q');
            $this->db->join('exam_preparation_exams as e', 'e.id = q.exam_id');
            $this->db->join('exam_preparation_subjects as s', 's.id = q.subject_id');
            $this->db->join('exam_preparation_years as y', 'y.id = q.year_id');
            $this->db->where('q.exam_id', $examID);
            $this->db->where('q.subject_id', $subjectID);
            $this->db->where('q.year_id', $yearID);
            $this->db->limit(1);
            $query = $this->db->get();
            $exam = $query->row_array();
            
            if(!$exam)
            {
                show_404();
            }
            
            
            $this->data['exam'] = $exam;
            $this->data['exam_id'] = $this->input->post('exam_id');
            $this->data['year_id'] = $this->input->post('year_id');
            $this->data['subject_id'] = $this->input->post('subject_id');
            $this->data['title'] = translate('exam_preparation');
            $this->data['sub_page'] =  'exam_preparation/take_exam';
            $this->data['main_menu'] = 'exam_preparation';
            $this->load->view('layout/index', $this->data);
        }
    }
    
    public function leaderboard()
    {
        
        $ranks = $this->exam_preparation_model->getLeaderboardRanking();
       

        
        $this->data['ranks'] = $ranks;
        $this->data['title'] = translate('leaderboard');
        $this->data['sub_page'] = 'exam_preparation/leaderboard';
        $this->data['main_menu'] = 'exam_preparation';
        $this->load->view('layout/index', $this->data);
    }
    
    
    public function getSubjectsByExam()
    {
        $exam_id = $this->input->post('exam_id');
    
        // Step 1: Get distinct subject_ids from exam_preparation_questions
        $subject_ids = $this->db->distinct()
                                ->select('subject_id')
                                ->from('exam_preparation_questions')
                                ->where('exam_id', $exam_id)
                                ->get()
                                ->result_array();
    
        if (empty($subject_ids)) {
            echo json_encode([]);
            return;
        }
    
        $subject_ids = array_column($subject_ids, 'subject_id');
    
        // Step 2: Get subject names from exam_preparation_subjects
        $subjects = $this->db->select('id, name')
                             ->from('exam_preparation_subjects')
                             ->where_in('id', $subject_ids)
                             ->get()
                             ->result_array();
    
        echo json_encode($subjects);
    }

    public function getYearsBySubject()
    {
        $subject_id = $this->input->post('subject_id');
    
        // Step 1: Get distinct year_ids from exam_preparation_questions
        $year_ids = $this->db->distinct()
                             ->select('year_id')
                             ->from('exam_preparation_questions')
                             ->where('subject_id', $subject_id)
                             ->get()
                             ->result_array();
    
        if (empty($year_ids)) {
            echo json_encode([]);
            return;
        }
    
        $year_ids = array_column($year_ids, 'year_id');
    
        // Step 2: Get year details from exam_preparation_years
        $years = $this->db->select('id, year')
                          ->from('exam_preparation_years')
                          ->where_in('id', $year_ids)
                          ->get()
                          ->result_array();
    
        echo json_encode($years);
    }


    public function ajaxQuestions()
    {
        $status = 1;
        $totalQuestions = 20;
        $message = "";
        $examID = $this->input->post('exam_id');
        $subjectID = $this->input->post('subject_id');
        $yearID = $this->input->post('year_id');
        $this->data['exam_id'] = $this->input->post('exam_id');
        $this->data['subject_id'] = $this->input->post('subject_id');
        $this->data['year_id'] = $this->input->post('year_id');
        $this->data['year'] = $this->input->post('year');
        $this->data['subject'] = $this->input->post('subject');
        

        $this->data['questions'] = $this->exam_preparation_model->getExamQuestions($examID, $yearID, $subjectID);
        $pag_content = $this->load->view('exam_preparation/ajax_take', $this->data, true);
        echo json_encode(array('status' => $status, 'total_questions' => $totalQuestions, 'message' => $message, 'page' => $pag_content));
    }
    
    public function exam_submission()
    {
        if ($_POST) {
            $stu = $this->userrole_model->getStudentDetails();
            $answers = $this->input->post('answer');
            $examID = $this->input->post('exam_id');
            $subjectID = $this->input->post('subject_id');
            $yearID = $this->input->post('year_id');
            $duration = $this->input->post('duration_input');
    
            $score = 0;
    
            foreach ($answers as $key => $value) {
                $this->db->select('*')->from('exam_preparation_questions');
                $this->db->where([
                    'exam_id' => $examID,
                    'subject_id' => $subjectID,
                    'year_id' => $yearID,
                    'question_id' => $key
                ]);
                $query = $this->db->get();
                $resp = $query->row();
    
                if ($resp && $resp->answer === $value) {
                    $score++;
                }
            }
            
            function timeToSeconds($timeString) {
                $parts = explode(':', $timeString);
                $seconds = 0;
            
                if (count($parts) == 3) {
                    // Format: HH:MM:SS
                    $seconds = ($parts[0] * 3600) + ($parts[1] * 60) + $parts[2];
                } elseif (count($parts) == 2) {
                    // Format: MM:SS
                    $seconds = ($parts[0] * 60) + $parts[1];
                }
            
                return $seconds;
            }
            
            
    
            $durationInSeconds = timeToSeconds($duration); // Convert it first

            $data = [
                'user_id' => $stu['student_id'],
                'exam_id' => $examID,
                'subject_id' => $subjectID,
                'year_id' => $yearID,
                'score' => $score,
                'duration' => $duration, // still keeping this for display
                'duration_in_seconds' => $durationInSeconds, // for logic stuff
                'questions' => count($answers),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->db->insert('exam_preparation_attempts', $data);
            $attempt_id = $this->db->insert_id();

    
            $answerData = [
                'attempt_id' => $attempt_id,
                'answers' => json_encode($answers)
            ];
            $this->db->insert('exam_preparation_answers_submitted', $answerData);
    
            // Redirect to result page
            redirect('exam_preparation/result/' . $attempt_id);
        }
    }
    
    
    public function fetch_explanation()
    {
        $id = $this->input->post('id');
        $this->db->select('explanation');
        $this->db->from('exam_preparation_questions');
        $this->db->where('question_id', $id);
        $query = $this->db->get()->row();
    
        echo json_encode($query);
    }


    
    public function result($attempt_id)
    {
    $this->db->select('
        epa.*,
        epe.name as exam_name,
        eps.name as subject_name,
        epy.year as year_name,
        epas.answers
    ');
    $this->db->from('exam_preparation_attempts as epa');
    $this->db->join('exam_preparation_exams as epe', 'epa.exam_id = epe.id', 'left');
    $this->db->join('exam_preparation_subjects as eps', 'epa.subject_id = eps.id', 'left');
    $this->db->join('exam_preparation_years as epy', 'epa.year_id = epy.id', 'left');
    $this->db->join('exam_preparation_answers_submitted as epas', 'epas.attempt_id = epa.id', 'left');
    $this->db->where('epa.id', $attempt_id);
    $attempt = $this->db->get()->row();

    if (!$attempt) {
        show_404();
    }
    

    $answers = json_decode($attempt->answers, true);
    $q_and_a = [];

    foreach ($answers as $question_id => $chosen) {
        $this->db->where('question_id', $question_id);
        $question = $this->db->get('exam_preparation_questions')->row();

        if ($question) {
            $q_and_a[$question_id] = [
                'question' => $question->question,
                '1' => $question->opt_1,
                '2' => $question->opt_2,
                '3' => $question->opt_3,
                '4' => $question->opt_4,
                'correct_answer' => $question->answer,
                'chosen' => $chosen
            ];
        }
    }

    $this->data['title'] = translate('exam_preparation');
    $this->data['main_menu'] = 'exam_preparation';
    $this->data['sub_page'] = 'exam_preparation/result';

    $this->data['score'] = $attempt->score;
    $this->data['total_questions'] = $attempt->questions;
    $this->data['exam'] = $attempt;
    $this->data['q_and_a'] = $q_and_a;

    $this->load->view('layout/index', $this->data);
}

}