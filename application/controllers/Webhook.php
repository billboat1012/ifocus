<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webhook extends CI_Controller {

    public function receive() {
        // Verification code for Meta
        $hub_mode = $this->input->get('hub_mode');
        $hub_challenge = $this->input->get('hub_challenge');
        $hub_verify_token = $this->input->get('hub_verify_token');

        // Replace 'YOUR_VERIFY_TOKEN' with your actual token
        if ($hub_mode === 'subscribe' && $hub_verify_token === 'lorditOne') {
            
            // Run the first request to send the template message
            $api_url_template = 'https://graph.facebook.com/v20.0/416911551498605/messages';
            $access_token = 'EAALfYBGSEloBO1vHwfotMn4Y5FQDAEe1o9haZAcWCZBV30EofZA0WvcSLSWLWk2dK82FOapf2hD4BnQMI9FIZCcZAqHZCZCKsCwZB1Nd9aJ2yqUZByuyg82QZCB1MPoNVnIjXJ5sw8rZBieMgmPBo0xRCdec2Xjcyuwx6lSPkScAvmImscJWA80PIlu9Yk7AWpurmJN';

            $data_template = array(
                'messaging_product' => 'whatsapp',
                'to' => +2348140507193,
                'type' => 'template',
                'template' => array(
                    'name' => 'introduction',
                    'language' => array(
                        'code' => 'en'
                    )
                )
            );

            $headers_template = array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $access_token
            );

            $opts_template = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => implode("\r\n", $headers_template),
                    'content' => json_encode($data_template),
                ),
            );

            $context_template = stream_context_create($opts_template);
            $response_template = file_get_contents($api_url_template, false, $context_template);
            $result_template = json_decode($response_template, true);
            
        }

        // Handle other incoming webhook data here
        $data = file_get_contents('php://input');
        $this->log_message('info', "Received webhook data: $data");

        // Respond with 200 OK
        $this->output->set_status_header(200);
        echo 'OK';
    }
}
