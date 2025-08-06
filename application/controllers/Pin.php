<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pin extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load Pin model
        $this->load->model('Pin_model');
        if (!is_superadmin_loggedin()) {
            access_denied();
        }
    }

    public function create()
    {

        // Display pins view
        // $this->data['pinlist'] = $this->Pin_model->get_pins();
        $this->data['sub_page'] = 'pin/index';
        $this->data['main_menu'] = 'pin';
        $this->load->view('layout/index', $this->data);
    }
    public function index()
    {

        if (!get_permission('pin', 'is_view')) {
            access_denied();
        }
        // Display pins view
        $this->data['title'] = 'Pin';
        $this->data['pinlist'] = $this->Pin_model->get_pins();
        $this->data['sub_page'] = 'pin/list';
        $this->data['main_menu'] = 'pin';
        $this->load->view('layout/index', $this->data);
    }
    public function delete($id)
    {
        if (!get_permission('pin', 'is_delete')) {
            access_denied();
        }
        $this->db->where('id', $id);
        $this->db->delete('pins');
    }


    public function bulk_delete()
    {
        $status = 'success';
        $message = translate('information_deleted');
        if (get_permission('pin', 'is_delete')) {
            $arrayID = $this->input->post('array_id');
            foreach ($arrayID as $key => $row) {
                $this->db->where('id', $row);
                $this->db->delete('pins');
            }
        } else {
            $message = translate('access_denied');
            $status = 'error';
        }
        echo json_encode(array('status' => $status, 'message' => $message));
    }



    public function pin_settings()
    {
        // Display pin settings view
        $this->load->view('pin_settings');
    }

    public function generate()
    {
        $length = $this->input->post('length');
        $used_time = $this->input->post('used_time');
        $no_of_pin = $this->input->post('no_of_pin');
        $noOfTimes = $no_of_pin;
        // Get the length from the input field
        for ($i = 1; $i <= $noOfTimes; $i++) {
            $randomPassword = $this->generateRandomPassword($length);
            // Save the generated password into the database
            $data = array(
                'pin' => $randomPassword,
                'status' => 1,
                'use_time' => $used_time
                // Add more fields if needed
            );
            $result = $this->db->insert('pins', $data);

            // echo $randomPassword.'<br/>';
        }
        if ($result) {
            echo "Pin Generated Successfully.";
        }
    }

    private function generateRandomPassword($length)
    {
        $characters = '0123456789';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $password;
    }

    public function getPin()
    {
        if ($_POST) {
            $id = $this->input->post('pin');

            if ($id) {
                $this->load->model('Pin_model');
                $pin = $this->db->select('pin')->where('id', $id)->get('pins')->row_array();

                if (!empty($pin)) {
                    echo json_encode(['status' => 'success', 'pin' => $pin['pin']]);
                } else {
                    echo json_encode(['status' => 'fail', 'message' => 'No PIN found for ID ' . $id]);
                }
            } else {
                echo json_encode(['status' => 'fail', 'message' => 'ID parameter is missing']);
            }
        } else {
            echo json_encode(['status' => 'fail', 'message' => 'Invalid request method']);
        }
    }
}
