<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pin_model extends CI_Model {

    public function get_pins() {
        // Retrieve pins from the database
        return $this->db->order_by('id','desc')->get('pins')->result_array();
    }

    public function save_pin($data) {
        // Save pin to the database
        $arrayExam = array(
            'pin' => $data['pin'],
            'use_time' => $data['use_time'],
            'satuts' => $data['satuts']
        );
            $this->db->insert('pins', $arrayExam);
        
    }

    // Other methods for managing pins
}
?>
