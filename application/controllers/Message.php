<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('twilio');
    }

    public function send_whatsapp() {
        $to = '+2348140507193'; // Recipient's WhatsApp number
        $body = 'Your appointment is coming up on July 21 at 3PM';

        $sid = $this->twilio->sendWhatsAppMessage($to, $body);

        echo "WhatsApp message sent with SID: " . $sid;
    }
}
