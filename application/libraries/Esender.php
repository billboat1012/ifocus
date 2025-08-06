<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class eSender
{
    protected $api_key;

    public function __construct()
    {
        $ci = &get_instance();
        if (is_superadmin_loggedin()) {
            $branchID = $ci->input->post('branch_id');
        } else {
            $branchID = get_loggedin_branch_id();
        }

        $sms_credential = $ci->db->get_where('sms_credential', array('sms_api_id' => 9, 'branch_id' => $branchID))->row_array();
        $this->api_key = isset($sms_credential['field_one']) ? $sms_credential['field_one'] : '';
    }

    public function send($to, $message, $gatewayIdentifier = null, $scheduleAt = null)
    {
        $url = "https://sdm.nste.com.np/api/sms/send";
        $api_key = $this->api_key;

        $contact = [
            [
                "number" => $to,
                "body" => $message,
                "sms_type" => "plain",
                "gateway_identifier" => $gatewayIdentifier ?? "default_gateway"
            ]
        ];

        if ($scheduleAt) {
            $contact[0]['schedule_at'] = $scheduleAt;
        }

        $postdata = [
            "contact" => $contact
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($postdata),
            CURLOPT_HTTPHEADER => [
                'Api-key: ' . $api_key,
                'Content-Type: application/json',
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($ch);

        return $response;
    }
}
