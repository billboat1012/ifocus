<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'third_party/twilio/src/Twilio/autoload.php');

class Twilio
{
    protected $client;
    protected $account_sid = 'ba07cdad9024f8f2212225774ab8e8f2';
    protected $auth_token = 'AC56b73826425a7de75b778f13138790b9';
    protected $number;

    function __construct()
    {
        $ci = & get_instance();
        if (is_superadmin_loggedin()) {
            $branchID = $ci->input->post('branch_id');
        } else {
            $branchID = get_loggedin_branch_id();
        }
        $twilio = $ci->db->get_where('sms_credential', array('sms_api_id' => 1, 'branch_id' => $branchID))->row_array();
        $this->account_sid = isset($twilio['field_one']) ? $twilio['field_one'] : ' ';
        $this->auth_token  = isset($twilio['field_two']) ? $twilio['field_two'] : ' ';
        $this->number      = isset($twilio['field_three']) ? $twilio['field_three'] : '';

        // Initialize the client
        $this->client = new Twilio\Rest\Client($this->account_sid, $this->auth_token);
    }

    public function sms($to, $body) {
        // Send SMS
        $message = $this->client->messages->create(
            $to,
            [
                'from' => $this->number,
                'body' => $body
            ]
        );
        return $message->sid;
    }

    public function sendWhatsAppMessage($to, $body) {
        // Send WhatsApp message
        $message = $this->client->messages->create(
            "whatsapp:$to",
            [
                'from' => "whatsapp:" . $this->number,
                'body' => $body
            ]
        );
        return $message->sid;
    }
}
