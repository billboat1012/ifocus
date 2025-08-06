<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @package : Ramom school management system
 * @version : 6.6
 * @developed by : RamomCoder
 * @support : ramomcoder@yahoo.com
 * @author url : http://codecanyon.net/user/RamomCoder
 * @filename : Exam.php
 * @copyright : Reserved RamomCoder Teamm
 */

class Exam extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('exam_model');
        $this->load->model('student_model');
        $this->load->model('subject_model');
        $this->load->model('attendance_model');
        $this->load->model('sms_model');
        $this->load->model('email_model');
        $this->load->model('marksheet_template_model');
        $this->load->model('exam_progress_model');
    }

    
    protected function exam_validation()
    {
        if (is_superadmin_loggedin()) {
            $this->form_validation->set_rules('branch_id', translate('branch'), 'required');
        }
        $this->form_validation->set_rules('name', translate('name'), 'trim|required');
        $this->form_validation->set_rules('type_id', translate('exam_type'), 'trim|required');
        $this->form_validation->set_rules('mark_distribution[]', translate('mark_distribution'), 'trim|required');
    }

    public function index()
    {
        if (!get_permission('exam', 'is_view')) {
            access_denied();
        }

        if ($_POST) {
            if (!get_permission('exam', 'is_view')) {
                ajax_access_denied();
            }
            $this->exam_validation();
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $this->exam_model->exam_save($post);
                set_alert('success', translate('information_has_been_saved_successfully'));
                $url = base_url('exam');
                $array = array('status' => 'success', 'url' => $url);
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }

        $this->data['branch_id'] = $this->application_model->get_branch_id();
        $this->data['examlist'] = $this->exam_model->getExamList();
        $this->data['title'] = translate('exam_list');
        $this->data['sub_page'] = 'exam/index';
        $this->data['main_menu'] = 'exam';
        $this->load->view('layout/index', $this->data);
    }

    public function edit($id = '')
    {
        if (!get_permission('exam', 'is_edit')) {
            access_denied();
        }

        if ($_POST) {
            $this->exam_validation();
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $this->exam_model->exam_save($post);
                set_alert('success', translate('information_has_been_saved_successfully'));
                $url = base_url('exam');
                $array = array('status' => 'success', 'url' => $url);
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }

        $this->data['branch_id'] = $this->application_model->get_branch_id();
        $this->data['exam'] = $this->app_lib->getTable('exam', array('t.id' => $id), true);
        $this->data['title'] = translate('exam_list');
        $this->data['sub_page'] = 'exam/edit';
        $this->data['main_menu'] = 'exam';
        $this->load->view('layout/index', $this->data);
    }

    // exam information delete stored in the database here
    public function delete($id)
    {
        if (!get_permission('exam', 'is_delete')) {
            access_denied();
        }
        if (!is_superadmin_loggedin()) {
            $this->db->where('branch_id', get_loggedin_branch_id());
        }
        $this->db->where('id', $id);
        $this->db->delete('exam');
    }

    /* term form validation rules */
    protected function term_validation()
    {
        if (is_superadmin_loggedin()) {
            $this->form_validation->set_rules('branch_id', translate('branch'), 'required');
        }
        $this->form_validation->set_rules('term_name', translate('name'), 'trim|required|callback_unique_term');
        $this->form_validation->set_rules('slug', translate('slug'), 'trim|required');
    }

    // exam term information are prepared and stored in the database here
    public function term()
    {
        if (isset($_POST['save'])) {
            if (!get_permission('exam_term', 'is_add')) {
                access_denied();
            }
            $this->term_validation();
            if ($this->form_validation->run() !== false) {
                //save exam term information in the database file
                $this->exam_model->termSave($this->input->post());
                set_alert('success', translate('information_has_been_saved_successfully'));
                redirect(current_url());
            }
        }
        $this->data['termlist'] = $this->app_lib->getTable('exam_term');
        $this->data['sub_page'] = 'exam/term';
        $this->data['main_menu'] = 'exam';
        $this->data['title'] = translate('exam_term');
        $this->load->view('layout/index', $this->data);
    }

    public function term_edit()
    {
        if ($_POST) {
            if (!get_permission('exam_term', 'is_edit')) {
                ajax_access_denied();
            }
            $this->term_validation();
            if ($this->form_validation->run() !== false) {
                //save exam term information in the database file
                $this->exam_model->termSave($this->input->post());
                set_alert('success', translate('information_has_been_updated_successfully'));
                $url = base_url('exam/term');
                $array = array('status' => 'success', 'url' => $url, 'error' => '');
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'url' => '', 'error' => $error);
            }
            echo json_encode($array);
        }
    }

    public function term_delete($id)
    {
        if (!get_permission('exam_term', 'is_delete')) {
            access_denied();
        }
        if (!is_superadmin_loggedin()) {
            $this->db->where('branch_id', get_loggedin_branch_id());
        }
        $this->db->where('id', $id);
        $this->db->delete('exam_term');
    }

    /* unique valid exam term name verification is done here */
    public function unique_term($name)
    {
        $branchID = $this->application_model->get_branch_id();
        $term_id = $this->input->post('term_id');
        if (!empty($term_id)) {
            $this->db->where_not_in('id', $term_id);
        }
        $this->db->where(array('name' => $name, 'branch_id' => $branchID));
        $uniform_row = $this->db->get('exam_term')->num_rows();
        if ($uniform_row == 0) {
            return true;
        } else {
            $this->form_validation->set_message("unique_term", translate('already_taken'));
            return false;
        }
    }

    public function mark_distribution()
    {
        if (isset($_POST['save'])) {
            if (!get_permission('mark_distribution', 'is_add')) {
                access_denied();
            }
            if (is_superadmin_loggedin()) {
                $this->form_validation->set_rules('branch_id', translate('branch'), 'required');
            }
            $this->form_validation->set_rules('name', translate('name'), 'trim|required');
            if ($this->form_validation->run() !== false) {
                // save mark distribution information in the database file
                $arrayDistribution = array(
                    'name' => $this->input->post('name'),
                    'unique_identifier' => $this->input->post('unique_identifier'),
                    'branch_id' => $this->application_model->get_branch_id(),
                );
                $this->db->insert('exam_mark_distribution', $arrayDistribution);
                set_alert('success', translate('information_has_been_saved_successfully'));
                redirect(current_url());
            }
        }
        $this->data['termlist'] = $this->app_lib->getTable('exam_mark_distribution');
        $this->data['sub_page'] = 'exam/mark_distribution';
        $this->data['main_menu'] = 'exam';
        $this->data['title'] = translate('mark_distribution');
        $this->load->view('layout/index', $this->data);
    }

    public function mark_distribution_edit()
    {
        if ($_POST) {
            if (!get_permission('mark_distribution', 'is_edit')) {
                ajax_access_denied();
            }
            if (is_superadmin_loggedin()) {
                $this->form_validation->set_rules('branch_id', translate('branch'), 'required');
            }
            $this->form_validation->set_rules('name', translate('name'), 'trim|required');
            if ($this->form_validation->run() !== false) {
                // save mark distribution information in the database file
                $arrayDistribution = array(
                    'name' => $this->input->post('name'),
                    'unique_identifier' => $this->input->post('unique_identifier'),
                    'branch_id' => $this->application_model->get_branch_id(),
                );
                $this->db->where('id', $this->input->post('distribution_id'));
                $this->db->update('exam_mark_distribution', $arrayDistribution);
                set_alert('success', translate('information_has_been_updated_successfully'));
                $url = base_url('exam/mark_distribution');
                $array = array('status' => 'success', 'url' => $url);
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
        }
    }

    public function mark_distribution_delete($id)
    {
        if (!get_permission('mark_distribution', 'is_delete')) {
            access_denied();
        }
        if (!is_superadmin_loggedin()) {
            $this->db->where('branch_id', get_loggedin_branch_id());
        }
        $this->db->where('id', $id);
        $this->db->delete('exam_mark_distribution');
    }

    /* hall form validation rules */
    protected function hall_validation()
    {
        if (is_superadmin_loggedin()) {
            $this->form_validation->set_rules('branch_id', translate('branch'), 'required');
        }
        $this->form_validation->set_rules('hall_no', translate('hall_no'), 'trim|required|callback_unique_hall_no');
        $this->form_validation->set_rules('no_of_seats', translate('no_of_seats'), 'trim|required|numeric');
    }

    /* exam hall information moderator and page */
    public function hall($action = '', $id = '')
    {
        if (isset($_POST['save'])) {
            if (!get_permission('exam_hall', 'is_add')) {
                access_denied();
            }
            $this->hall_validation();
            if ($this->form_validation->run() !== false) {
                //save exam hall information in the database file
                $this->exam_model->hallSave($this->input->post());
                set_alert('success', translate('information_has_been_saved_successfully'));
                redirect(current_url());
            }
        }
        $this->data['halllist'] = $this->app_lib->getTable('exam_hall');
        $this->data['title'] = translate('exam_hall');
        $this->data['sub_page'] = 'exam/hall';
        $this->data['main_menu'] = 'exam';
        $this->load->view('layout/index', $this->data);
    }

    public function hall_edit()
    {
        if ($_POST) {
            if (!get_permission('exam_hall', 'is_edit')) {
                ajax_access_denied();
            }
            $this->hall_validation();
            if ($this->form_validation->run() !== false) {
                //save exam hall information in the database file
                $this->exam_model->hallSave($this->input->post());
                set_alert('success', translate('information_has_been_updated_successfully'));
                $url = base_url('exam/hall');
                $array = array('status' => 'success', 'url' => $url);
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
        }
    }

    public function hall_delete($id)
    {
        if (!get_permission('exam_hall', 'is_delete')) {
            access_denied();
        }
        if (!is_superadmin_loggedin()) {
            $this->db->where('branch_id', get_loggedin_branch_id());
        }
        $this->db->where('id', $id);
        $this->db->delete('exam_hall');
    }

    /* exam hall number exists validation */
    public function unique_hall_no($hall_no)
    {
        $branchID = $this->application_model->get_branch_id();
        $term_id = $this->input->post('term_id');
        if (!empty($term_id)) {
            $this->db->where_not_in('id', $term_id);
        }
        $this->db->where(array('hall_no' => $hall_no, 'branch_id' => $branchID));
        $uniform_row = $this->db->get('exam_hall')->num_rows();
        if ($uniform_row == 0) {
            return true;
        } else {
            $this->form_validation->set_message("unique_hall_no", translate('already_taken'));
            return false;
        }
    }

    /* exam mark information are prepared and stored in the database here */
    public function mark_entry()
    {
        if (!get_permission('exam_mark', 'is_add')) {
            access_denied();
        }
        
        
    
        $branchID = $this->application_model->get_branch_id();
        $classID = $this->input->post('class_id');
        $sectionID = $this->input->post('section_id');
        $subjectID = $this->input->post('subject_id');
        $examID = $this->input->post('exam_id');
        $subSubjectID = $this->input->post('sub_subject_id');
    
        $this->data['branch_id'] = $branchID;
        $this->data['class_id'] = $classID;
        $this->data['section_id'] = $sectionID;
        $this->data['subject_id'] = $subjectID;
        $this->data['exam_id'] = $examID;
        $this->data['sub_subject_id'] = isset($subSubjectID) ? $subSubjectID : null;
    
        if (isset($_POST['search'])) {
            $this->data['timetable_detail'] = $this->exam_model->getTimetableDetail($classID, $examID, $subjectID);
            $this->data['student'] = $this->exam_model->getMarkAndStudent($branchID, $classID, $examID, $subjectID);
            
            $this->data['sub_subject_id'] = $this->exam_model->getSubSubjectId($subjectID);
            $this->data['exam_type_id'] = $this->exam_model->getExamType($examID);
        }
        
        $this->data['sub_page'] = 'exam/marks_register';
        $this->data['main_menu'] = 'mark';
        $this->data['title'] = translate('mark_entries');
        $this->load->view('layout/index', $this->data);
    }


    // public function mark_save()
    // {
    //     if ($_POST) {
    //     if (!get_permission('exam_mark', 'is_add')) {
    //         ajax_access_denied();
    //     }
        
    //     $examTypeId = $this->input->post('exam_type_id');
        
    //     log_message('debug', print_r($_POST['mark'], true));
        
    //     if (isset($examTypeId) && $examTypeId == 4) {
    //         $branchID = $this->application_model->get_branch_id();
    //         $classID = $this->input->post('class_id');
    //         $sectionID = $this->input->post('section_id');
    //         $subjectID = $this->input->post('subject_id');
    //         $subSubjectID = $this->input->post('sub_subject_id');
    //         $examID = $this->input->post('exam_id');
    //         $inputMarks = $this->input->post('mark');
            
    //         foreach ($inputMarks as $key => $value) {
    //             if (empty($value['assessment'])) {
    //                 $marks = NULL;
    //             } else {
    //                 $value['assessment'] = '"' . $value['assessment'] . '"';
    //                 $formatted = '{' . $value['assessment'] . ':' . $value['assessment'] . '}';
    //                 $marks = $formatted;
    //             }

    //             $arrayMarks = array(
    //                 'student_id' => $value['student_id'],
    //                 'exam_id' => $examID,
    //                 'class_id' => $classID,
    //                 'section_id' => $sectionID,
    //                 'subject_id' => $subjectID,
    //                 'sub_subject_id' => $subSubjectID,
    //                 'branch_id' => $branchID,
    //                 'session_id' => get_session_id(),
    //                 'mark' => !$value['absent'] ? $marks : NULL,
    //                 'absent' => $value['absent'] ? $value['absent'] : NULL,
    //             );

    //             $this->db->where('exam_id', $examID);
    //             $this->db->where('student_id', $value['student_id']);
    //             $this->db->where('sub_subject_id', $subSubjectID);
    //             $query = $this->db->get('mark');
                
    //             if ($query->num_rows() > 0) {
    //                 // Update existing record
    //                 $this->db->where('exam_id', $examID);
    //                 $this->db->where('student_id', $value['student_id']);
    //                 $this->db->where('sub_subject_id', $subSubjectID);
    //                 $this->db->update('mark', $arrayMarks);
    //             } else {
    //                 // Insert new record
    //                 $this->db->insert('mark', $arrayMarks);
    //             }
    //         }

    //         $message = translate('information_has_been_saved_successfully');
    //         $array = array('status' => 'success', 'message' => $message);
    //     } else {
    //         $inputMarks = $this->input->post('mark');
    //         foreach ($inputMarks as $key => $value) {
    //             if (!isset($value['absent'])) {
    //                 foreach ($value['assessment'] as $i => $row) {
    //                     $field = "mark[{$key}][assessment][{$i}]";
    //                     $this->form_validation->set_rules($field, translate('mark'), "trim|numeric|callback_valid_Mark[$i]");
    //                 }
    //             }
    //         }

    //         if ($this->form_validation->run() !== false) {
    //             $branchID = $this->application_model->get_branch_id();
    //             $classID = $this->input->post('class_id');
    //             $sectionID = $this->input->post('section_id');
    //             $subjectID = $this->input->post('subject_id');
    //             $examID = $this->input->post('exam_id');
    //             $inputMarks = $this->input->post('mark');
                
    //             foreach ($inputMarks as $key => $value) {
    //                 $assMark = array();
    //                 foreach ($value['assessment'] as $i => $row) {
    //                     $assMark[$i] = !empty($row) ? $row : null;
    //                 }

    //                 $arrayMarks = array(
    //                     'student_id' => $value['student_id'],
    //                     'exam_id' => $examID,
    //                     'class_id' => $classID,
    //                     'section_id' => $sectionID,
    //                     'subject_id' => $subjectID,
    //                     'branch_id' => $branchID,
    //                     'session_id' => get_session_id(),
    //                 );

    //                 $inputMark = isset($value['absent']) ? null : json_encode($assMark);
    //                 $absent = isset($value['absent']) ? 'on' : '';

    //                 $query = $this->db->get_where('mark', $arrayMarks);

    //                 if ($query->num_rows() > 0) {
    //                     // Update the record
    //                     $this->db->where('id', $query->row()->id);
    //                     $this->db->update('mark', array('mark' => $inputMark, 'absent' => $absent));
    //                 } else {
    //                     // Insert new record
    //                     $arrayMarks['mark'] = $inputMark;
    //                     $arrayMarks['absent'] = $absent;
    //                     $this->db->insert('mark', $arrayMarks);
    //                     // Send exam results SMS
    //                     $this->sms_model->send_sms($arrayMarks, 5);
    //                 }
    //             }

    //             $message = translate('information_has_been_saved_successfully');
    //             $array = array('status' => 'success', 'message' => $message);
    //         } else {
    //             $error = $this->form_validation->error_array();
    //             $array = array('status' => 'fail', 'error' => $error);
    //         }
    //     }

    //     echo json_encode($array);
    // }
    // }


//     public function mark_save()
// {
//     if ($_POST) {
//         if (!get_permission('exam_mark', 'is_add')) {
//             ajax_access_denied();
//         }

//         $examTypeId = $this->input->post('exam_type_id');
//         $branchID = $this->application_model->get_branch_id();
//         $classID = $this->input->post('class_id');
//         $sectionID = $this->input->post('section_id');
//         $subjectID = $this->input->post('subject_id');
//         $subSubjectID = $this->input->post('sub_subject_id') ?? NULL;
//         $examID = $this->input->post('exam_id');
//         $inputMarks = $this->input->post('mark');

//         // Log input for debugging
//         log_message('debug', 'Input Marks: ' . print_r($inputMarks, true));


//         if (isset($examTypeId) && $examTypeId == 4) {
//             foreach ($inputMarks as $key => $value) {
//                 $studentID = $value['student_id'];

//                 // Validate and sanitize inputs
//                 $isAbsent = !empty($value['absent']);
//                 $assessmentMarks = !empty($value['assessment']) ? array_filter($value['assessment'], 'strlen') : [];

//                 // If no marks and student is not absent, delete the record
//                 if (empty($assessmentMarks) && !$isAbsent) {
//                     $this->db->where('exam_id', $examID);
//                     $this->db->where('student_id', $studentID);
//                     $this->db->where('subject_id', $subjectID);
//                     $this->db->where('sub_subject_id', $subSubjectID);
//                     $this->db->delete('mark');

//                     log_message('debug', "Mark deleted for student_id: $studentID");
//                     continue;
//                 }

//                 // Prepare marks for storage
//                 $encodedMarks = $isAbsent ? NULL : json_encode($assessmentMarks);
//                 $absentFlag = $isAbsent ? 'on' : NULL;

//                 $data = [
//                     'student_id' => $studentID,
//                     'exam_id' => $examID,
//                     'class_id' => $classID,
//                     'section_id' => $sectionID,
//                     'subject_id' => $subjectID,
//                     'sub_subject_id' => $subSubjectID,
//                     'branch_id' => $branchID,
//                     'session_id' => get_session_id(),
//                     'mark' => $encodedMarks,
//                     'absent' => $absentFlag,
//                 ];

//                 // Check if record exists
//                 $this->db->where('exam_id', $examID);
//                 $this->db->where('student_id', $studentID);
//                 $this->db->where('subject_id', $subjectID);
//                 $this->db->where('sub_subject_id', $subSubjectID);
//                 $query = $this->db->get('mark');

//                 if ($query->num_rows() > 0) {
//                     // Update existing record
//                     $this->db->where('exam_id', $examID);
//                     $this->db->where('student_id', $studentID);
//                     $this->db->where('subject_id', $subjectID);
//                     $this->db->where('sub_subject_id', $subSubjectID);
//                     $this->db->update('mark', $data);

//                     log_message('debug', "Mark updated for student_id: $studentID");
//                 } else {
//                     // Insert new record
//                     $this->db->insert('mark', $data);
//                     $this->sms_model->send_sms($data, 5);

//                     log_message('debug', "Mark inserted for student_id: $studentID");
//                 }
//             }
//         } else {
//             foreach ($inputMarks as $key => $value) {
//                 $studentID = $value['student_id'];

//                 // Validate and sanitize inputs
//                 $isAbsent = !empty($value['absent']);
//                 $assessmentMarks = !empty($value['assessment']) ? array_filter($value['assessment'], 'strlen') : [];

//                 // If no marks and student is not absent, delete the record
//                 if (empty($assessmentMarks) && !$isAbsent) {
//                     $this->db->where('exam_id', $examID);
//                     $this->db->where('student_id', $studentID);
//                     $this->db->where('subject_id', $subjectID);
//                     $this->db->delete('mark');

//                     log_message('debug', "Mark deleted for student_id: $studentID");
//                     continue;
//                 }

//                 // Prepare marks for storage
//                 $encodedMarks = $isAbsent ? NULL : json_encode($assessmentMarks);
//                 $absentFlag = $isAbsent ? 'on' : NULL;

//                 $data = [
//                     'student_id' => $studentID,
//                     'exam_id' => $examID,
//                     'class_id' => $classID,
//                     'section_id' => $sectionID,
//                     'subject_id' => $subjectID,
//                     'branch_id' => $branchID,
//                     'session_id' => get_session_id(),
//                     'mark' => $encodedMarks,
//                     'absent' => $absentFlag,
//                 ];

//                 // Check if record exists
//                 $query = $this->db->get_where('mark', [
//                     'student_id' => $studentID,
//                     'exam_id' => $examID,
//                     'subject_id' => $subjectID,
//                 ]);

//                 if ($query->num_rows() > 0) {
//                     // Update the record
//                     $this->db->where('id', $query->row()->id);
//                     $this->db->update('mark', $data);

//                     log_message('debug', "Mark updated for student_id: $studentID");
//                 } else {
//                     // Insert new record
//                     $this->db->insert('mark', $data);
//                     $this->sms_model->send_sms($data, 5);

//                     log_message('debug', "Mark inserted for student_id: $studentID");
//                 }
//             }
//         }

//         $message = translate('information_has_been_saved_successfully');
//         echo json_encode(['status' => 'success', 'message' => $message]);
//     }
// }

    public function mark_save()
{
    if ($_POST) {
        if (!get_permission('exam_mark', 'is_add')) {
            ajax_access_denied();
        }

        log_message('debug', 'Received POST data: ' . print_r($_POST, true));

        $examTypeId = $this->input->post('exam_type_id');
        
        if (isset($examTypeId) && $examTypeId == 4) {
            $branchID = $this->application_model->get_branch_id();
            $classID = $this->input->post('class_id');
            $subjectID = $this->input->post('subject_id');
            $subSubjectID = $this->input->post('sub_subject_id');
            $examID = $this->input->post('exam_id');
            $inputMarks = $this->input->post('mark');
            
            log_message('debug', 'Branch ID: ' . $branchID);
            log_message('debug', 'Session ID: ' . get_session_id());

            foreach ($inputMarks as $key => $value) {
                if (empty($value['assessment'])) {
                    $marks = NULL;
                } else {
                    if (is_array($value['assessment'])) {
                        $marks = json_encode($value['assessment']);
                    } else {
                        $value['assessment'] = '"' . $value['assessment'] . '"';
                        $formatted = '{' . $value['assessment'] . ':' . $value['assessment'] . '}';
                        $marks = $formatted;
                    }
                }

                $arrayMarks = array(
                    'student_id' => $value['student_id'],
                    'exam_id' => $examID,
                    'class_id' => $classID,
                    'subject_id' => $subjectID,
                    'sub_subject_id' => $subSubjectID,
                    'branch_id' => $branchID,
                    'session_id' => get_session_id(),
                    'mark' => !$value['absent'] ? $marks : NULL,
                    'absent' => $value['absent'] ? $value['absent'] : NULL,
                );

                $this->db->where('exam_id', $examID);
                $this->db->where('student_id', $value['student_id']);
                $this->db->where('sub_subject_id', $subSubjectID);
                $query = $this->db->get('mark');
                
                if ($query->num_rows() > 0) {
                    // Update existing record
                    $this->db->where('exam_id', $examID);
                    $this->db->where('student_id', $value['student_id']);
                    $this->db->where('sub_subject_id', $subSubjectID);
                    if (!$this->db->update('mark', $arrayMarks)) {
                        log_message('error', 'Update Error: ' . $this->db->error()['message']);
                    }
                } else {
                    // Insert new record
                    if (!$this->db->insert('mark', $arrayMarks)) {
                        log_message('error', 'Insert Error: ' . $this->db->error()['message']);
                    }
                }
            }

            $message = translate('information_has_been_saved_successfully');
            $array = array('status' => 'success', 'message' => $message);
        } else {
            $inputMarks = $this->input->post('mark');
            foreach ($inputMarks as $key => $value) {
                if (!isset($value['absent'])) {
                    foreach ($value['assessment'] as $i => $row) {
                        $field = "mark[{$key}][assessment][{$i}]";
                        $this->form_validation->set_rules($field, translate('mark'), "trim|numeric|callback_valid_Mark[$i]");
                    }
                }
            }

            if ($this->form_validation->run() !== false) {
                $branchID = $this->application_model->get_branch_id();
                $classID = $this->input->post('class_id');
                $subjectID = $this->input->post('subject_id');
                $examID = $this->input->post('exam_id');
                $inputMarks = $this->input->post('mark');
                
                log_message('debug', 'Branch ID: ' . $branchID);
                log_message('debug', 'Session ID: ' . get_session_id());

                foreach ($inputMarks as $key => $value) {
                    $assMark = array();
                    foreach ($value['assessment'] as $i => $row) {
                        $assMark[$i] = !empty($row) ? $row : null;
                    }

                    $arrayMarks = array(
                        'student_id' => $value['student_id'],
                        'exam_id' => $examID,
                        'class_id' => $classID,
                        'subject_id' => $subjectID,
                        'branch_id' => $branchID,
                        'session_id' => get_session_id(),
                    );

                    $inputMark = isset($value['absent']) ? null : json_encode($assMark);
                    $absent = isset($value['absent']) ? 'on' : '';

                    $query = $this->db->get_where('mark', $arrayMarks);

                    if ($query->num_rows() > 0) {
                        // Update the record
                        $this->db->where('id', $query->row()->id);
                        if (!$this->db->update('mark', array('mark' => $inputMark, 'absent' => $absent))) {
                            log_message('error', 'Update Error: ' . $this->db->error()['message']);
                        }
                    } else {
                        // Insert new record
                        $arrayMarks['mark'] = $inputMark;
                        $arrayMarks['absent'] = $absent;
                        if (!$this->db->insert('mark', $arrayMarks)) {
                            log_message('error', 'Insert Error: ' . $this->db->error()['message']);
                        } else {
                            // Send exam results SMS
                            $this->sms_model->send_sms($arrayMarks, 5);
                        }
                    }
                }

                $message = translate('information_has_been_saved_successfully');
                $array = array('status' => 'success', 'message' => $message);
            } else {
                $error = $this->form_validation->error_array();
                log_message('error', 'Validation Errors: ' . print_r($error, true));
                $array = array('status' => 'fail', 'error' => $error);
            }
        }

        echo json_encode($array);
    }
}


   



    //exam mark register validation check
    public function valid_Mark($val, $i)
    {
        $fullMark = $this->input->post('max_mark_' .$i);
        if ($fullMark < $val) {
            $this->form_validation->set_message("valid_Mark", translate("invalid_marks"));
            return false;
        }
        return true;
    }

    /* exam grade form validation rules */
    protected function grade_validation()
    {
        if (is_superadmin_loggedin()) {
            $this->form_validation->set_rules('branch_id', translate('branch'), 'required');
        }
        $this->form_validation->set_rules('name', translate('name'), 'trim|required');
        $this->form_validation->set_rules('grade_point', translate('grade_point'), 'trim|required|numeric');
        $this->form_validation->set_rules('lower_mark', translate('mark_from'), 'trim|required');
        $this->form_validation->set_rules('upper_mark', translate('mark_upto'), 'trim|required');
    }

    /* exam grade information are prepared and stored in the database here */
    public function grade($action = '')
    {
        if (!get_permission('exam_grade', 'is_view')) {
            access_denied();
        }

        if ($_POST) {
            if (!get_permission('exam_grade', 'is_view')) {
                ajax_access_denied();
            }
            $this->grade_validation();
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $this->exam_model->gradeSave($post);
                set_alert('success', translate('information_has_been_saved_successfully'));
                $url = base_url('exam/grade');
                $array = array('status' => 'success', 'url' => $url);
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }
        $this->data['title'] = translate('grades_range');
        $this->data['sub_page'] = 'exam/grade';
        $this->data['main_menu'] = 'mark';
        $this->load->view('layout/index', $this->data);
    }

    // exam grade information updating here
    public function grade_edit($id = '')
    {
        if (!get_permission('exam_grade', 'is_edit')) {
            ajax_access_denied();
        }

        if ($_POST) {
            $this->grade_validation();
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $this->exam_model->gradeSave($post);
                set_alert('success', translate('information_has_been_updated_successfully'));
                $url = base_url('exam/grade');
                $array = array('status' => 'success', 'url' => $url);
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }
        $this->data['grade'] = $this->app_lib->getTable('grade', array('t.id' => $id), true);
        $this->data['sub_page'] = 'exam/grade_edit';
        $this->data['title'] = translate('grades_range');
        $this->data['main_menu'] = 'exam';
        $this->load->view('layout/index', $this->data);
    }

    public function grade_delete($id = '')
    {
        if (get_permission('exam_grade', 'is_delete')) {
            if (!is_superadmin_loggedin()) {
                $this->db->where('branch_id', get_loggedin_branch_id());
            }
            $this->db->where('id', $id);
            $this->db->delete('grade');
        }
    }

    public function marksheet()
    {
        if (!get_permission('report_card', 'is_view')) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        if ($_POST) {

            if (is_superadmin_loggedin()) {
                $this->form_validation->set_rules('branch_id', translate('branch'), 'required');
            }
            $this->form_validation->set_rules('session_id', translate('academic_year'), 'trim|required');
            $this->form_validation->set_rules('exam_id', translate('exam'), 'trim|required');
            $this->form_validation->set_rules('class_id', translate('class'), 'trim|required');
            $this->form_validation->set_rules('template_id', translate('marksheet') . " " . translate('template'), 'trim|required');
            if ($this->form_validation->run() == true) {
                $sessionID = $this->input->post('session_id');
                // if($sessionID)
                // {
                //      $this->session->set_userdata('session_id', $sessionId);
                // }
                $examID = $this->input->post('exam_id');
                $classID = $this->input->post('class_id');
                $this->db->select('e.roll,e.id as enrollID,s.*,c.name as category');
                $this->db->from('enroll as e');
                $this->db->join('student as s', 'e.student_id = s.id', 'inner');
                $this->db->join('mark as m', 's.id = m.student_id', 'inner');
                $this->db->join('student_category as c', 'c.id = s.category_id', 'left');
                $this->db->join('exam_rank as r', 'r.exam_id = m.exam_id and r.enroll_id = e.id', 'left');
                
            
                $this->db->where('e.session_id', $sessionID);
                $this->db->where('m.session_id', $sessionID);
                $this->db->where('m.class_id', $classID);
                $this->db->where('e.branch_id', $branchID);
                $this->db->where('m.exam_id', $examID);
                $this->db->group_by('m.student_id');
                $this->db->order_by('r.rank', 'ASC');
                $this->data['student'] = $this->db->get()->result_array();
            }
        }

        $this->data['branch_id'] = $branchID;
        $this->data['sub_page'] = 'exam/marksheet';
        $this->data['main_menu'] = 'exam_reports';
        $this->data['title'] = translate('report_card');
        $this->load->view('layout/index', $this->data);
    }

    public function reportCardPrint()
    {
        if ($_POST) {
            if (!get_permission('report_card', 'is_view')) {
                ajax_access_denied();
            }
            $this->data['student_array'] = $this->input->post('student_id');
            $this->data['print_date'] = $this->input->post('print_date');
            $this->data['examID'] = $this->input->post('exam_id');
            $this->data['class_id'] = $this->input->post('class_id');
            $this->data['section_id'] = $this->input->post('section_id');
            $this->data['sessionID'] = $this->input->post('session_id');
            $this->data['templateID'] = $this->input->post('template_id');
            $this->data['branchID'] = $this->application_model->get_branch_id();
            echo $this->load->view('exam/reportCard', $this->data, true);
        }
    }

    // public function reportCardPdf()
    // {
    //     if ($_POST) {
    //         if (!get_permission('report_card', 'is_view')) {
    //             ajax_access_denied();
    //         }
    //         $this->data['student_array'] = $this->input->post('student_id');
    //         $this->data['print_date'] = $this->input->post('print_date');
    //         $this->data['examID'] = $this->input->post('exam_id');
    //         $this->data['class_id'] = $this->input->post('class_id');
    //         $this->data['section_id'] = $this->input->post('section_id');
    //         $this->data['sessionID'] = $this->input->post('session_id');
    //         $this->data['templateID'] = $this->input->post('template_id');
    //         $this->data['branchID'] = $this->application_model->get_branch_id();
    //         $this->data['marksheet_template'] = $this->marksheet_template_model->getTemplate($this->data['templateID'], $this->data['branchID']);
    //         $html = $this->load->view('exam/reportCard_PDF', $this->data, true);

    //         $this->load->library('html2pdf');
    //         $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/vendor/bootstrap/css/bootstrap.min.css')), 1);
    //         $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/css/custom-style.css')), 1);
    //         $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/css/pdf-style.css')), 1);
    //         $this->html2pdf->mpdf->WriteHTML($html);
    //         $this->html2pdf->mpdf->SetDisplayMode('fullpage');
    //         $this->html2pdf->mpdf->autoScriptToLang  = true;
    //         $this->html2pdf->mpdf->baseScript        = 1;
    //         $this->html2pdf->mpdf->autoLangToFont    = true;
           
    //         return $this->html2pdf->mpdf->Output(time() . '.pdf', "I");
    //     }
    // }
    

    public function generatePdfAjax()
    {
        if (!get_permission('report_card', 'is_view')) {
            echo json_encode(['status' => 'error', 'msg' => 'Access denied']);
            return;
        }

        session_write_close();
        ini_set('max_execution_time', 600);
        ini_set('memory_limit', '1024M');
        ini_set('pcre.backtrack_limit', '10000000');

        $studentIDs = $this->input->post('student_id');
        $examID = $this->input->post('exam_id');
        $classID = $this->input->post('class_id');
        $sectionID = $this->input->post('section_id');
        $sessionID = $this->input->post('session_id');
        $templateID = $this->input->post('template_id');
        $printDate = $this->input->post('print_date');
        $branchID = $this->application_model->get_branch_id();

        if (!is_array($studentIDs) || empty($studentIDs)) {
            echo json_encode(['status' => 'error', 'msg' => 'No students selected']);
            return;
        }

        // Prepare path
        $filename = 'ReportCard_' . date('Ymd_His') . '.pdf';
        $saveDir = FCPATH . 'uploads/pdf_reports/';
        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0755, true);
        }
        $relativePath = 'uploads/pdf_reports/' . $filename;
        $fullPath = $saveDir . $filename;

        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0755, true);
        }

        // Load template
        $template = $this->marksheet_template_model->getTemplate($templateID, $branchID);

        // Init mPDF
        $this->load->library('html2pdf');
        $pdf = $this->html2pdf->mpdf;

        // CSS
        $cssFiles = [
            'assets/vendor/bootstrap/css/bootstrap.min.css',
            'assets/css/custom-style.css',
            'assets/css/pdf-style.css',
        ];
        foreach ($cssFiles as $css) {
            $pdf->WriteHTML(@file_get_contents(base_url($css)), 1);
        }

        // Watermark
        if (!empty($template['logo'])) {
            $logoPath = FCPATH . 'uploads/marksheet/' . $template['logo'];
            if (file_exists($logoPath)) {
                $pdf->SetWatermarkImage($logoPath, 0.7, [200, 200]);
                $pdf->showWatermarkImage = true;
            }
        }

        // Write each student's marksheet
        foreach ($studentIDs as $index => $studentID) {
            $data = [
                'student_array' => [$studentID],
                'print_date' => $printDate,
                'examID' => $examID,
                'class_id' => $classID,
                'section_id' => $sectionID,
                'sessionID' => $sessionID,
                'templateID' => $templateID,
                'branchID' => $branchID,
                'marksheet_template' => $template,
            ];
            $html = $this->load->view('exam/reportCard_PDF', $data, true);
            if (empty(trim($html))) {
                log_message('error', "Skipped student $studentID: empty view output.");
                continue;
            }

            $pdf->WriteHTML($html);

            if ($index < count($studentIDs) - 1) {
                $pdf->AddPage(); // only between students
            }
        }

        $pdf->SetDisplayMode('fullpage');
        $pdf->Output($fullPath, 'F');

        echo json_encode([
            'status' => 'success',
            'url' => base_url($relativePath),
            'csrf_token' => $this->security->get_csrf_hash()
        ]);

    }



    public function download_report_card($filename)
    {
        $this->load->helper('download');

        $path = FCPATH . 'uploads/pdf_reports/ReportCard/' . $filename;
        if (file_exists($path)) {
            force_download($path, null); // triggers download
        } else {
            show_404();
        }
    }



    public function reportCardPdf()
    {
    if ($_POST) {
        if (!get_permission('report_card', 'is_view')) {
            ajax_access_denied();
        }
        
         // 🛑 Close the session early to avoid session lock issues during heavy PDF generation
        session_write_close();

//      // ⚙️ Max Performance Boost
        ini_set('max_execution_time', 900); // 15 minutes
        ini_set('memory_limit', '1024M'); // 1 GB just to be safe
        
        $this->data['student_array'] = $this->input->post('student_id');
        $this->data['print_date'] = $this->input->post('print_date');
        $this->data['examID'] = $this->input->post('exam_id');
        $this->data['class_id'] = $this->input->post('class_id');
        $this->data['section_id'] = $this->input->post('section_id');
        $this->data['sessionID'] = $this->input->post('session_id');
        $this->data['templateID'] = $this->input->post('template_id');
        $this->data['branchID'] = $this->application_model->get_branch_id();
        $this->data['marksheet_template'] = $this->marksheet_template_model->getTemplate($this->data['templateID'], $this->data['branchID']);

        $html = $this->load->view('exam/reportCard_PDF', $this->data, true);

        $this->load->library('html2pdf');
        
        // Add Bootstrap & Custom Styles
        $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/vendor/bootstrap/css/bootstrap.min.css')), 1);
        $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/css/custom-style.css')), 1);
        $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/css/pdf-style.css')), 1);

        // Set watermark image (background)
        $marksheet_template = $this->marksheet_template_model->getTemplate($this->data['templateID'], $this->data['branchID']);
        $watermarkImage = base_url('uploads/marksheet/' . $marksheet_template['logo']);
        $this->html2pdf->mpdf->SetWatermarkImage($watermarkImage, 0.7, [200, 200]); // 0.2 = 20% opacity
        $this->html2pdf->mpdf->showWatermarkImage = true;

        // Write HTML Content
        $this->html2pdf->mpdf->WriteHTML($html);
        $this->html2pdf->mpdf->SetDisplayMode('fullpage');
        $this->html2pdf->mpdf->autoScriptToLang  = true;
        $this->html2pdf->mpdf->baseScript        = 1;
        $this->html2pdf->mpdf->autoLangToFont    = true;
        
        return $this->html2pdf->mpdf->Output(time() . '.pdf', "I");
    }
    }

    
//     public function reportCardPdf()
// {
//     if ($_POST) {
//         if (!get_permission('report_card', 'is_view')) {
//             ajax_access_denied();
//         }

//         // 🛑 Close the session early to avoid session lock issues during heavy PDF generation
//         session_write_close();

//         // ⚙️ Increase performance headroom
//         ini_set('max_execution_time', 300); // 5 minutes
//         ini_set('memory_limit', '512M');

//         // 🧠 Collect form data
//         $studentIDs               = $this->input->post('student_id');
//         $this->data['print_date'] = $this->input->post('print_date');
//         $this->data['examID']     = $this->input->post('exam_id');
//         $this->data['class_id']   = $this->input->post('class_id');
//         $this->data['section_id'] = $this->input->post('section_id');
//         $this->data['sessionID']  = $this->input->post('session_id');
//         $this->data['templateID'] = $this->input->post('template_id');
//         $this->data['branchID']   = $this->application_model->get_branch_id();

//         // 📄 Get marksheet template
//         $marksheet_template = $this->marksheet_template_model->getTemplate($this->data['templateID'], $this->data['branchID']);
//         $this->data['marksheet_template'] = $marksheet_template;

//         // 🖼 Watermark logo
//         $watermarkImage = base_url('uploads/marksheet/' . $marksheet_template['logo']);

//         // 🧾 Load PDF library
//         $this->load->library('html2pdf');

//         // 📦 Add CSS (Bootstrap + Custom Styles)
//         $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/vendor/bootstrap/css/bootstrap.min.css')), 1);
//         $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/css/custom-style.css')), 1);
//         $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/css/pdf-style.css')), 1);

//         // 💦 Apply watermark image
//         $this->html2pdf->mpdf->SetWatermarkImage($watermarkImage, 0.7, [200, 200]); // 0.7 = 70% opacity
//         $this->html2pdf->mpdf->showWatermarkImage = true;

//         // 🧃 Generate combined PDF content for all students
//         $fullHtml = '';
//         $this->data['student_array'] = $studentIDs;

//         foreach ($studentIDs as $student_id) {
//             $this->data['student_id'] = $student_id;

//             // 🎨 View rendered per student
//             $html = $this->load->view('exam/reportCard_PDF', $this->data, true);
//             $fullHtml .= $html;
//         }

//         // ✨ Final render
//         $this->html2pdf->mpdf->WriteHTML($fullHtml);
//         $this->html2pdf->mpdf->autoScriptToLang  = true;
//         $this->html2pdf->mpdf->baseScript        = 1;
//         $this->html2pdf->mpdf->autoLangToFont    = true;

//         // 🚀 Output final PDF
//         return $this->html2pdf->mpdf->Output('report_cards_' . time() . '.pdf', 'I');
//     }
// }





    
    
     public function quickViewStudent()

    {

       if ($_POST) {

            if (!get_permission('report_card', 'is_view')) {

                ajax_access_denied();

            }

            $this->data['student_array'] = $this->input->post('student_id');

            $this->data['print_date'] = $this->input->post('print_date');

            $this->data['examID'] = $this->input->post('exam_id');

            $this->data['class_id'] = $this->input->post('class_id');

            $this->data['section_id'] = $this->input->post('section_id');

            $this->data['sessionID'] = $this->input->post('session_id');

            $this->data['templateID'] = $this->input->post('template_id');

            $this->data['branchID'] = $this->application_model->get_branch_id();

            echo $this->load->view('exam/quick_view_student', $this->data, true);

        }
    }

    public function pdf_sendByemail()
    {
        if ($_POST) {
            if (!get_permission('report_card', 'is_view')) {
                ajax_access_denied();
            }
            $enrollID = $this->input->post('enrollID');
            $this->data['student_array'] = [$this->input->post('student_id')];
            $this->data['print_date'] = $this->input->post('print_date');
            $this->data['examID'] = $this->input->post('exam_id');
            $this->data['class_id'] = $this->input->post('class_id');
            $this->data['section_id'] = $this->input->post('section_id');
            $this->data['sessionID'] = $this->input->post('session_id');
            $this->data['templateID'] = $this->input->post('template_id');
            $this->data['branchID'] = $this->application_model->get_branch_id();
            $this->data['marksheet_template'] = $this->marksheet_template_model->getTemplate($this->data['templateID'], $this->data['branchID']);
            $html = $this->load->view('exam/reportCard_PDF', $this->data, true);

            $this->load->library('html2pdf');
            $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/vendor/bootstrap/css/bootstrap.min.css')), 1);
            $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/css/custom-style.css')), 1);
            $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/css/pdf-style.css')), 1);
            $this->html2pdf->mpdf->WriteHTML($html);
            $this->html2pdf->mpdf->SetDisplayMode('fullpage');
            $this->html2pdf->mpdf->autoScriptToLang  = true;
            $this->html2pdf->mpdf->baseScript        = 1;
            $this->html2pdf->mpdf->autoLangToFont    = true;
           
            $file = $this->html2pdf->mpdf->Output(time() . '.pdf', "S");
            $data['exam_name'] = get_type_name_by_id('exam', $this->data['examID']);
            $data['file'] = $file;
            $data['enroll_id'] = $enrollID;
            $response = $this->email_model->emailPDFexam_marksheet($data);
            if ($response == true) {
                $array = array('status' => 'success', 'message' => translate('mail_sent_successfully'));

            } else {
                $array = array('status' => 'error', 'message' => translate('something_went_wrong'));

            }
            echo json_encode($array);
        }
    }

    /* tabulation sheet report generating here */
    public function spread_sheet()
    {
        if (!get_permission('tabulation_sheet', 'is_view')) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        $this->data['branch_id'] = $branchID;
        if (!empty($this->input->post('submit'))) {
            $classID = $this->input->post('class_id');
            $examID = $this->input->post('exam_id');
            $sessionID = $this->input->post('session_id');

            $this->data['students_list'] = $this->exam_model->searchExamStudentsByRank($classID, $sessionID, $examID, $branchID);
            $this->data['exam_details'] = $this->exam_model->getExamByID($examID);
            $this->data['get_subjects'] = $this->exam_model->getSubjectList($examID, $classID, $sessionID);
        }
        $this->data['title'] = translate('spread_sheet');
        $this->data['sub_page'] = 'exam/spread_sheet';
        $this->data['main_menu'] = 'exam_reports';
        $this->load->view('layout/index', $this->data);
    }

    public function getDistributionByBranch()
    {
        $html = "";
        $table = $this->input->post('table');
        $branch_id = $this->application_model->get_branch_id();
        if (!empty($branch_id)) {
            $result = $this->db->select('id,name')->where('branch_id', $branch_id)->get('exam_mark_distribution')->result_array();
            if (count($result)) {
                foreach ($result as $row) {
                    $html .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                }
            }
        }
        echo $html;
    }


    // exam publish status
    public function publish_status()
    {
        if (get_permission('exam', 'is_add')) {
            $id = $this->input->post('id');
            $status = $this->input->post('status');
            if ($status == 'true') {
                $arrayData['status'] = 1;
            } else {
                $arrayData['status'] = 0;
            }
            if (!is_superadmin_loggedin()) {
                $this->db->where('branch_id', get_loggedin_branch_id());
            }
            $this->db->where('id', $id);
            $this->db->update('exam', $arrayData);
            $return = array('msg' => translate('information_has_been_updated_successfully'), 'status' => true);
            echo json_encode($return);
        }
    }

    // exam result publish status
    public function publish_result_status()
    {
        if (get_permission('exam', 'is_add')) {
            $id = $this->input->post('id');
            $status = $this->input->post('status');
            if ($status == 'true') {
                $arrayData['publish_result'] = 1;
            } else {
                $arrayData['publish_result'] = 0;
            }
            if (!is_superadmin_loggedin()) {
                $this->db->where('branch_id', get_loggedin_branch_id());
            }
            $this->db->where('id', $id);
            $this->db->update('exam', $arrayData);
            $return = array('msg' => translate('information_has_been_updated_successfully'), 'status' => true);
            echo json_encode($return);
        }
    }


    public function class_position()
    {
        if (!get_permission('generate_position', 'is_view')) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        $this->data['branch_id'] = $branchID;
        if (!empty($this->input->post('submit'))) {
            $classID = $this->input->post('class_id');
            $examID = $this->input->post('exam_id');
            $sessionID = $this->input->post('session_id');
            $this->data['students_list'] = $this->exam_model->searchExamStudentsByRank($classID, $sessionID, $examID, $branchID);
            $this->data['exam_details'] = $this->exam_model->getExamByID($examID);
            $this->data['get_subjects'] = $this->exam_model->getSubjectList($examID, $classID, $sessionID);
        }
        $this->data['title'] = translate('class_position');
        $this->data['sub_page'] = 'exam/class_position';
        $this->data['main_menu'] = 'mark';
        $this->load->view('layout/index', $this->data);
    }

    
    public function save_position()
    {
        if ($_POST) {
            if (!get_permission('generate_position', 'is_view')) {
                ajax_access_denied();
            }
            $rank = $this->input->post('rank');
            foreach ($rank as $key => $value) {
                $this->form_validation->set_rules('rank[' . $key . '][position]', translate('position'), 'trim|numeric|required');
            }
            if ($this->form_validation->run() == true) {
                $examID = $this->input->post('exam_id');
                foreach ($rank as $key => $value) {
                    $q = $this->db->select('id')->where(array('exam_id' => $examID, 'enroll_id' => $value['enroll_id']))->get('exam_rank');
                    $arrayRank = array(
                        'rank' => $value['position'], 
                        'teacher_comments' => $value['teacher_comments'],
                        'forms_teacher_comments' => $value['forms_teacher_comments'],
                        'principal_comments' => $value['principal_comments'],
                        'punctualtiy' => $value['punctualtiy'], 
                        'neatness' => $value['neatness'], 
                        'obedience' => $value['obedience'], 
                        'self_control' => $value['self_control'], 
                        'participation' => $value['participation'], 
                        'use_of_intiative' => $value['use_of_intiative'], 
                        'handling' => $value['handling'], 
                        'communication' => $value['communication'], 
                        'realtionship' => $value['realtionship'], 
                        'sports' => $value['sports'], 
                        'enroll_id' => $value['enroll_id'], 
                        'exam_id' => $examID, 
                    );
                    if ($q->num_rows() == 0) {
                        $this->db->insert('exam_rank', $arrayRank);
                    } else {
                        $this->db->where('id', $q->row()->id);
                        $this->db->update('exam_rank', $arrayRank);
                    }
                }
                $message = translate('information_has_been_saved_successfully');
                $array = array('status' => 'success', 'message' => $message);
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
        }
    }

    
    
    
    public function getExamsBySession()
    {
        $this->load->model('exam_model'); // Load your model if necessary
    
        $session_id = $this->input->post('session_id');
        $branch_id = $this->input->post('branch_id');
    
        if ($session_id && $branch_id) {
            $this->db->select('id, name');
            $this->db->where('session_id', $session_id);
            $this->db->where('branch_id', $branch_id);
            $exams = $this->db->get('exam')->result_array();
    
            $output = [];
            foreach ($exams as $exam) {
                $output[$exam['id']] = $exam['name'];
            }
            echo json_encode($output);
        } else {
            echo json_encode([]);
        }
    }
    
    
     // attendance update 
    
    
    public function attendance_save($action = '')
    {
        if ($_POST) {
            
            try{

            if (!get_permission('exam_mark', 'is_view')) {
                ajax_access_denied();
            }

            $post = $this->input->post();
            $response = $this->exam_model->manual_attendance_update($post);
            
            $message = translate('information_has_been_saved_successfully');
            $array = array('status' => 'success', 'message' => $message);
            
            echo json_encode($array);
            }catch(\Throwable $th)
            {
            
                $message = translate('an_error_occured_try_again');
                $array = array('error' => 'error', 'message' => $message); 
                
                echo json_encode($array);
            
            }
        }
        
    }

    
    public function attendance_update()
    {
        if (!get_permission('exam_mark', 'is_add')) {
            access_denied();
        }
    
        $branchID = $this->application_model->get_branch_id();
        $classID = $this->input->post('class_id');
        $examID = $this->input->post('exam_id');
        $sessionID = $this->input->post('session_id');
    
        $this->data['branch_id'] = $branchID;
        $this->data['class_id'] = $classID;
        $this->data['exam_id'] = $examID;
        $this->data['session_id'] = $sessionID;
    
        if (isset($_POST['search'])) {
            $this->data['student'] = $this->exam_model->getStudentsForAttendance($branchID, $classID, $sessionID);
            $this->data['attendance'] = $this->exam_model->getManualAttendance($branchID, $classID, $examID, $sessionID);
        }
    
        $this->data['sub_page'] = 'exam/attendance_update';
        $this->data['main_menu'] = 'mark';
        $this->data['title'] = translate('attendance_update');
        $this->load->view('layout/index', $this->data);
    }
    
    
    
    // hostel remarks 
    
    public function hostel_comments()
    {
        // if (!get_permission('exam_mark', 'is_view')) {
        //     access_denied();
        // }
        
        $branchID = $this->application_model->get_branch_id();
        
        // if(is_superadmin_loggedin() || $branchID !== $this->config->item('branch_for_special_feature'))
        // {
        //     access_denied();
        // }
        
        $this->data['branch_id'] = $branchID;
        if (!empty($this->input->post('submit'))) {
            $classID = $this->input->post('class_id');
            $examID = $this->input->post('exam_id');
            $this->data['student_list'] = $this->exam_model->getStudentsForHostelComments($branchID, $classID, $examID); 
            $this->data['exam_id'] = $examID;
        }
        $this->data['title'] = translate('hostel_comments');
        $this->data['sub_page'] = 'exam/hostel_comments';
        $this->data['main_menu'] = 'mark';
        $this->load->view('layout/index', $this->data);
    }

    
    public function save_hostel_comments()
    {
        if ($_POST) {
            // if (!get_permission('generate_position', 'is_view')) {
            //     ajax_access_denied();
            // }
    
            $rank = $this->input->post('rank');
    
            // Validate `hostel_comment` for each student
            foreach ($rank as $key => $value) {
                $this->form_validation->set_rules('rank[' . $key . '][hostel_comment]', translate('hostel_comment'), 'trim');
            }
    
            if ($this->form_validation->run() == true) {
                $examID = $this->input->post('exam_id');
    
                foreach ($rank as $key => $value) {
                    // Check if record exists
                    $query = $this->db->select('id')
                                      ->where(array('exam_id' => $examID, 'enroll_id' => $value['enroll_id']))
                                      ->get('exam_rank');
    
                    // Prepare data for insert/update
                    $arrayRank = array(
                        'hostel_comment' => $value['hostel_comment'],
                        'enroll_id' => $value['enroll_id'],
                        'exam_id' => $examID,
                    );
    
                    if ($query->num_rows() == 0) {
                        // Insert new record if not exists
                        $this->db->insert('exam_rank', $arrayRank);
                    } else {
                        // Update existing record
                        $this->db->where('id', $query->row()->id);
                        $this->db->update('exam_rank', $arrayRank);
                    }
                }
    
                // Success response
                $message = translate('information_has_been_saved_successfully');
                $array = array('status' => 'success', 'message' => $message);
            } else {
                // Validation error response
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
    
            echo json_encode($array);
        }
    }


}
