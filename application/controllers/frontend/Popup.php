<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Popup extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $config = array(
            'field' => 'alias',
            'title' => 'title',
            'table' => 'front_cms_popup_list',
            'id'    => 'id',
        );
        $this->load->library('slug', $config);
        $this->load->model('popup_model');
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/dropify/css/dropify.min.css',
                'vendor/summernote/summernote.css',
                'vendor/bootstrap-fileupload/bootstrap-fileupload.min.css',
            ),
            'js' => array(
                'vendor/dropify/js/dropify.min.js',
                'vendor/summernote/summernote.js',
                'vendor/bootstrap-fileupload/bootstrap-fileupload.min.js',
            ),
        );
    }

    private function popup_validation()
    {
        if (is_superadmin_loggedin()) {
            $this->form_validation->set_rules('branch_id', translate('branch'), 'required');
        }
        $this->form_validation->set_rules('date', translate('date'), 'trim|required');
        $this->form_validation->set_rules('image', translate('image'), 'trim|callback_photoHandleUpload[image]');
        if (empty($_FILES['image']['name']) &&  empty($this->input->post('old_photo'))) {
            $this->form_validation->set_rules('image', translate('image'), 'required');
        }
    }

    public function index()
    {
        // check access permission
        if (!get_permission('frontend_popup', 'is_view')) {
            access_denied();
        }
        if ($_POST) {
            if (!get_permission('frontend_popup', 'is_add')) {
                access_denied();
            }
            $this->popup_validation();
            if ($this->form_validation->run() !== false) {
                // save information in the database file
                $this->popup_model->save($this->input->post());
                set_alert('success', translate('information_has_been_saved_successfully'));
                $array = array('status' => 'success');
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }

        $this->data['popuplist'] = $this->app_lib->getTable('front_cms_popup_list');
        $this->data['title'] = translate('frontend');
        $this->data['sub_page'] = 'frontend/popup';
        $this->data['main_menu'] = 'frontend';
        $this->load->view('layout/index', $this->data);
    }

    public function edit($id = '')
    {
        if (!get_permission('frontend_popup', 'is_edit')) {
            access_denied();
        }
        if ($_POST) {
            $this->popup_validation();
            if ($this->form_validation->run() !== false) {
                // save information in the database file
                $this->popup_model->save($this->input->post());
                set_alert('success', translate('information_has_been_updated_successfully'));
                $url = base_url('frontend/popup/index');
                $array = array('status' => 'success', 'url' => $url);
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }

        $this->data['gallery'] = $this->popup_model->get('front_cms_popup_list', array('id' => $id), true);
        $this->data['title'] = translate('frontend');
        $this->data['sub_page'] = 'frontend/popup_edit';
        $this->data['main_menu'] = 'frontend';
        $this->load->view('layout/index', $this->data);
    }

    public function delete($id = '')
    {
        if (!get_permission('frontend_popup', 'is_delete')) {
            access_denied();
        }
        if (!is_superadmin_loggedin()) {
            $this->db->where('branch_id', get_loggedin_branch_id());
        }
        $row = $this->db->get_where('front_cms_popup_list', array('id' => $id))->row();
        if (!empty($row)) {
            if ($this->db->where(array('id' => $id))->delete("front_cms_popup_list")) {
                // delete popup user image
                $destination = './uploads/frontend/popups/';
                if (file_exists($destination . $row->image)) {
                    @unlink($destination . $row->image);
                }
            }
        }
    }

    // publish on show website
    public function show_website()
    {
        if ($_POST) {
            $id = $this->input->post('id');
            $status = $this->input->post('status');
            if ($status == 'true') {
                $arrayData['show_web'] = 1;
            } else {
                $arrayData['show_web'] = 0;
            }
            if (!is_superadmin_loggedin()) {
                $this->db->where('branch_id', get_loggedin_branch_id());
            }
            $this->db->where('id', $id);
            $this->db->update('front_cms_popup_list', $arrayData);
            $return = array('msg' => translate('information_has_been_updated_successfully'), 'status' => true);
            echo json_encode($return);
        }
    }
}