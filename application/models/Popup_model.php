<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Popup_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // data save and update function
    public function save($data)
    {
        $insertGallery = array(
            'branch_id'     => $this->application_model->get_branch_id(),
            'date'          => date("Y-m-d", strtotime($data['date'])),
            'show_web'      => (isset($_POST['show_website']) ? 1 : 0),
            'image'         => $this->fileupload('image', './uploads/frontend/popups/', $this->input->post('old_photo')),
        );

        if (isset($data['popup_id']) && !empty($data['popup_id'])) {
            unset($insertGallery['elements']);
            $insertGallery['alias'] = $this->slug->create_uri($insertGallery, $data['popup_id']);
            $this->db->where('id', $data['popup_id']);
            $this->db->update('front_cms_popup_list', $insertGallery);
        } else {
            $insertGallery['alias'] = $this->slug->create_uri($insertGallery);
            $this->db->insert('front_cms_popup_list', $insertGallery);
        }
    }

    public function get_image_url($file_path = '')
    {
        $path = 'uploads/frontend/popups/' . $file_path;
        if (empty($file_path) || !file_exists($path)) {
            $image_url = base_url('uploads/frontend/popups/defualt.png');
        } else {
            $image_url = base_url($path);
        }
        return $image_url;
    }
}
