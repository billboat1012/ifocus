<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_generate_pdfs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // ✅ Make sure database is loaded
        $this->load->helper(['file', 'url']);
        $this->load->library('m_pdf'); // ✅ Confirm mPDF is working
    }

    public function index() {
        $queueItems = $this->db
            ->where('status', 'pending')
            ->get('pdf_queue')
            ->result();

        foreach ($queueItems as $item) {
            $this->processQueueItem($item);
        }
    }

    private function processQueueItem($item) {
        $this->db->where('id', $item->id)->update('pdf_queue', ['status' => 'processing']);

        try {
            $student_ids = json_decode($item->student_ids, true);
            if (!is_array($student_ids)) {
                throw new Exception("Invalid student_ids format");
            }

            $html = '';
            foreach ($student_ids as $student_id) {
                // Simulate $_POST input (only if reportCard_PDF.php depends on it)
                $_POST = [
                    'student_id'  => $student_id,
                    'exam_id'     => $item->exam_id,
                    'class_id'    => $item->class_id,
                    'section_id'  => $item->section_id,
                    'session_id'  => $item->session_id,
                    'template'    => $item->template_id,
                ];

                // Safely include reportCard_PDF
                ob_start();
                try {
                    include(APPPATH . 'views/reportCard_PDF.php'); // Ensure this script echoes HTML
                } catch (Throwable $e) {
                    ob_end_clean(); // Discard partial output
                    throw new Exception("Error in reportCard_PDF.php: " . $e->getMessage());
                }
                $html .= ob_get_clean();
            }

            $timestamp = time();
            $fileName = "report-multi-{$timestamp}.pdf";
            $fullPath = FCPATH . "uploads/pdf_reports/ReportCard/" . $fileName;

            if (!is_dir(dirname($fullPath))) {
                @mkdir(dirname($fullPath), 0777, true);
            }

            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            $mpdf->WriteHTML($html);
            $mpdf->Output($fullPath, \Mpdf\Output\Destination::FILE);

            $this->db->where('id', $item->id)->update('pdf_queue', [
                'status' => 'done',
                'result_file' => "uploads/pdf_reports/ReportCard/{$fileName}",
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            $this->db->where('id', $item->id)->update('pdf_queue', [
                'status' => 'error',
                'error_message' => $e->getMessage(),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            log_message('error', "PDF generation failed for queue item {$item->id}: " . $e->getMessage());
        }
    }
}
