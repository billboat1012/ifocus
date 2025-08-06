<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-08-05 00:00:56 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\config\config.php 26
ERROR - 2025-08-05 00:11:05 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\config\routes.php 60
ERROR - 2025-08-05 00:11:05 --> Severity: Warning --> Undefined array key "REQUEST_URI" C:\xampp\htdocs\ifocus\application\config\routes.php 60
ERROR - 2025-08-05 00:11:05 --> Severity: 8192 --> substr(): Passing null to parameter #1 ($string) of type string is deprecated C:\xampp\htdocs\ifocus\application\config\routes.php 64
ERROR - 2025-08-05 00:11:05 --> Query error: Unknown column 's.dob' in 'field list' - Invalid query: SELECT `s`.`id` as `student_id`, `s`.`first_name`, `s`.`last_name`, `s`.`photo`, `s`.`gender`, `s`.`dob`, `e`.`roll`, `c`.`name` as `class_name`, `se`.`name` as `section_name`, CONCAT_WS(" ", `s`.`first_name`, s.last_name) as name, `s`.`register_no` as `admission_no`
FROM `enroll` as `e`
JOIN `student` as `s` ON `s`.`id` = `e`.`student_id`
JOIN `class` as `c` ON `c`.`id` = `e`.`class_id`
LEFT JOIN `section` as `se` ON `se`.`id` = `e`.`section_id`
WHERE `e`.`class_id` = '8'
AND `e`.`branch_id` = '2'
AND `e`.`session_id` = '5'
ORDER BY `e`.`roll` ASC
ERROR - 2025-08-05 00:21:42 --> Query error: Unknown column 's.dob' in 'field list' - Invalid query: SELECT `s`.`id` as `student_id`, `s`.`first_name`, `s`.`last_name`, `s`.`photo`, `s`.`gender`, `s`.`dob`, `e`.`roll`, `c`.`name` as `class_name`, `se`.`name` as `section_name`, CONCAT_WS(" ", `s`.`first_name`, s.last_name) as name, `s`.`register_no` as `admission_no`
FROM `enroll` as `e`
JOIN `student` as `s` ON `s`.`id` = `e`.`student_id`
JOIN `class` as `c` ON `c`.`id` = `e`.`class_id`
LEFT JOIN `section` as `se` ON `se`.`id` = `e`.`section_id`
WHERE `e`.`class_id` = '8'
AND `e`.`branch_id` = '2'
AND `e`.`session_id` = '5'
ORDER BY `e`.`roll` ASC
ERROR - 2025-08-05 00:23:52 --> Query error: Unknown column 'error_message' in 'field list' - Invalid query: UPDATE `pdf_queue` SET `status` = 'error', `error_message` = 'Template not found or empty.', `updated_at` = '2025-08-05 00:23:52'
WHERE `id` = '5'
ERROR - 2025-08-05 00:25:15 --> [Queue] Job 5 failed: Template not found or empty.
ERROR - 2025-08-05 00:27:58 --> [Queue] Job 6 failed: Template not found or empty.
ERROR - 2025-08-05 00:30:54 --> [Queue] Job 6 failed: Template not found or empty.
ERROR - 2025-08-05 00:33:44 --> [Queue] Job 6 failed: Template not found or empty.
ERROR - 2025-08-05 00:34:33 --> [Queue] Job 6 failed: Template not found or empty.
ERROR - 2025-08-05 00:37:43 --> [Queue] Job 6 failed: Template not found or empty.
ERROR - 2025-08-05 00:40:41 --> [Queue] Job 6 failed: Template not found or empty.
ERROR - 2025-08-05 00:43:18 --> [Queue] Job 6 failed: Template not found or empty.
ERROR - 2025-08-05 00:50:20 --> [Queue] Job 7 failed: Template not found or empty.
ERROR - 2025-08-05 01:37:37 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 3
ERROR - 2025-08-05 01:37:37 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 5
ERROR - 2025-08-05 01:37:37 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 7
ERROR - 2025-08-05 01:37:37 --> Severity: Warning --> Undefined property: CI_Loader::$exam_model C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 20
ERROR - 2025-08-05 01:37:37 --> Severity: error --> Exception: Call to a member function getStudentReportCard() on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 20
ERROR - 2025-08-05 01:39:36 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 3
ERROR - 2025-08-05 01:39:36 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 5
ERROR - 2025-08-05 01:39:36 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 7
ERROR - 2025-08-05 01:39:36 --> Severity: Warning --> Undefined property: CI_Loader::$exam_model C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 20
ERROR - 2025-08-05 01:39:36 --> Severity: error --> Exception: Call to a member function getStudentReportCard() on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 20
ERROR - 2025-08-05 01:54:11 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 3
ERROR - 2025-08-05 01:54:11 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 5
ERROR - 2025-08-05 01:54:11 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 7
ERROR - 2025-08-05 01:54:11 --> Severity: Warning --> Undefined property: CI_Loader::$exam_model C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 20
ERROR - 2025-08-05 01:54:11 --> Severity: error --> Exception: Call to a member function getStudentReportCard() on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 20
ERROR - 2025-08-05 01:38:24 --> Severity: Warning --> Undefined property: Exam::$cache C:\xampp\htdocs\ifocus\system\core\Model.php 74
ERROR - 2025-08-05 01:38:25 --> Severity: error --> Exception: Call to a member function get() on null C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 36
ERROR - 2025-08-05 01:38:33 --> Severity: Warning --> Undefined property: Exam::$cache C:\xampp\htdocs\ifocus\system\core\Model.php 74
ERROR - 2025-08-05 01:38:33 --> Severity: error --> Exception: Call to a member function get() on null C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 36
ERROR - 2025-08-05 01:40:27 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:40:31 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:40:37 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:40:37 --> Query error: Unknown column 'show_photo' in 'field list' - Invalid query: SELECT `id`, `name`, `logo`, `grading_scale`, `attendance_percentage`, `show_photo`, `photo_size`, `background`
FROM `marksheet_template`
WHERE `id` = '3'
AND `branch_id` = '2'
ERROR - 2025-08-05 01:44:06 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:44:13 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:44:13 --> Query error: Unknown column 'show_photo' in 'field list' - Invalid query: SELECT `id`, `name`, `logo`, `grading_scale`, `attendance_percentage`, `show_photo`, `photo_size`, `background`
FROM `marksheet_template`
WHERE `id` = '3'
AND `branch_id` = '2'
ERROR - 2025-08-05 01:44:43 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:44:54 --> Severity: 8192 --> json_decode(): Passing null to parameter #1 ($json) of type string is deprecated C:\xampp\htdocs\ifocus\application\models\Exam_model.php 100
ERROR - 2025-08-05 01:45:03 --> Severity: 8192 --> str_replace(): Passing null to parameter #2 ($replace) of type array|string is deprecated C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 351
ERROR - 2025-08-05 01:45:03 --> Severity: 8192 --> str_replace(): Passing null to parameter #2 ($replace) of type array|string is deprecated C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 351
ERROR - 2025-08-05 01:46:42 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:47:02 --> Severity: 8192 --> str_replace(): Passing null to parameter #2 ($replace) of type array|string is deprecated C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 351
ERROR - 2025-08-05 01:47:02 --> Severity: 8192 --> str_replace(): Passing null to parameter #2 ($replace) of type array|string is deprecated C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 351
ERROR - 2025-08-05 01:48:00 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:49:24 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:52:29 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:52:33 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:52:38 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:53:02 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:55:15 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:55:20 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:55:24 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:55:33 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 01:56:11 --> Severity: Warning --> Undefined property: Exam::$cache C:\xampp\htdocs\ifocus\system\core\Model.php 74
ERROR - 2025-08-05 01:56:11 --> Severity: error --> Exception: Call to a member function get() on null C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 36
ERROR - 2025-08-05 03:46:54 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\models\Home_model.php 293
ERROR - 2025-08-05 03:46:54 --> Severity: Warning --> Undefined array key "REQUEST_URI" C:\xampp\htdocs\ifocus\application\models\Home_model.php 293
ERROR - 2025-08-05 03:46:54 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\core\MY_Controller.php 175
ERROR - 2025-08-05 03:46:54 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\ifocus\system\core\Exceptions.php:272) C:\xampp\htdocs\ifocus\system\helpers\url_helper.php 565
ERROR - 2025-08-05 03:55:10 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\core\MY_Controller.php 175
ERROR - 2025-08-05 03:55:10 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\ifocus\system\core\Exceptions.php:272) C:\xampp\htdocs\ifocus\system\helpers\url_helper.php 565
ERROR - 2025-08-05 03:59:48 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\core\MY_Controller.php 175
ERROR - 2025-08-05 03:59:48 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\ifocus\system\core\Exceptions.php:272) C:\xampp\htdocs\ifocus\system\helpers\url_helper.php 565
ERROR - 2025-08-05 09:52:20 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\models\Home_model.php 293
ERROR - 2025-08-05 09:52:20 --> Severity: Warning --> Undefined array key "REQUEST_URI" C:\xampp\htdocs\ifocus\application\models\Home_model.php 293
ERROR - 2025-08-05 09:52:20 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\core\MY_Controller.php 175
ERROR - 2025-08-05 09:52:20 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\ifocus\system\core\Exceptions.php:272) C:\xampp\htdocs\ifocus\system\helpers\url_helper.php 565
ERROR - 2025-08-05 09:52:40 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\models\Home_model.php 293
ERROR - 2025-08-05 09:52:40 --> Severity: Warning --> Undefined array key "REQUEST_URI" C:\xampp\htdocs\ifocus\application\models\Home_model.php 293
ERROR - 2025-08-05 09:52:40 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\core\MY_Controller.php 175
ERROR - 2025-08-05 09:52:40 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\ifocus\system\core\Exceptions.php:272) C:\xampp\htdocs\ifocus\system\helpers\url_helper.php 565
ERROR - 2025-08-05 09:53:10 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\models\Home_model.php 293
ERROR - 2025-08-05 09:53:10 --> Severity: Warning --> Undefined array key "REQUEST_URI" C:\xampp\htdocs\ifocus\application\models\Home_model.php 293
ERROR - 2025-08-05 09:53:10 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\core\MY_Controller.php 175
ERROR - 2025-08-05 09:53:10 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\ifocus\system\core\Exceptions.php:272) C:\xampp\htdocs\ifocus\system\helpers\url_helper.php 565
ERROR - 2025-08-05 09:53:21 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\models\Home_model.php 293
ERROR - 2025-08-05 09:53:21 --> Severity: Warning --> Undefined array key "REQUEST_URI" C:\xampp\htdocs\ifocus\application\models\Home_model.php 293
ERROR - 2025-08-05 09:53:21 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\core\MY_Controller.php 175
ERROR - 2025-08-05 09:53:21 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\ifocus\system\core\Exceptions.php:272) C:\xampp\htdocs\ifocus\system\helpers\url_helper.php 565
ERROR - 2025-08-05 09:56:58 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\models\Home_model.php 293
ERROR - 2025-08-05 09:56:58 --> Severity: Warning --> Undefined array key "REQUEST_URI" C:\xampp\htdocs\ifocus\application\models\Home_model.php 293
ERROR - 2025-08-05 09:56:58 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\core\MY_Controller.php 175
ERROR - 2025-08-05 09:56:58 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\ifocus\system\core\Exceptions.php:272) C:\xampp\htdocs\ifocus\system\helpers\url_helper.php 565
ERROR - 2025-08-05 10:58:38 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\config\config.php 26
ERROR - 2025-08-05 10:58:38 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\config\routes.php 54
ERROR - 2025-08-05 10:58:38 --> Severity: Warning --> Undefined array key "REQUEST_URI" C:\xampp\htdocs\ifocus\application\config\routes.php 54
ERROR - 2025-08-05 10:58:38 --> Severity: 8192 --> substr(): Passing null to parameter #1 ($string) of type string is deprecated C:\xampp\htdocs\ifocus\application\config\routes.php 57
ERROR - 2025-08-05 09:58:38 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\models\Home_model.php 293
ERROR - 2025-08-05 09:58:38 --> Severity: Warning --> Undefined array key "REQUEST_URI" C:\xampp\htdocs\ifocus\application\models\Home_model.php 293
ERROR - 2025-08-05 09:58:38 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\core\MY_Controller.php 175
ERROR - 2025-08-05 09:58:38 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\ifocus\application\config\config.php:26) C:\xampp\htdocs\ifocus\system\helpers\url_helper.php 565
ERROR - 2025-08-05 11:00:56 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\config\config.php 26
ERROR - 2025-08-05 10:13:38 --> Severity: 8192 --> json_decode(): Passing null to parameter #1 ($json) of type string is deprecated C:\xampp\htdocs\ifocus\application\models\Exam_model.php 643
ERROR - 2025-08-05 10:16:45 --> Severity: error --> Exception: The HTML code size is larger than pcre.backtrack_limit 1000000. You should use WriteHTML() with smaller string lengths. C:\xampp\htdocs\ifocus\application\third_party\mpdf\mpdf\mpdf\src\Mpdf.php 27043
ERROR - 2025-08-05 10:18:28 --> Severity: 8192 --> json_decode(): Passing null to parameter #1 ($json) of type string is deprecated C:\xampp\htdocs\ifocus\application\models\Exam_model.php 643
ERROR - 2025-08-05 10:21:35 --> Severity: error --> Exception: The HTML code size is larger than pcre.backtrack_limit 1000000. You should use WriteHTML() with smaller string lengths. C:\xampp\htdocs\ifocus\application\third_party\mpdf\mpdf\mpdf\src\Mpdf.php 27043
ERROR - 2025-08-05 10:43:57 --> Severity: Warning --> fopen(C:\xampp\htdocs\ifocus\uploads/pdf_reports/ReportCard/report-20250805_104357.pdf): Failed to open stream: No such file or directory C:\xampp\htdocs\ifocus\application\third_party\mpdf\mpdf\mpdf\src\Mpdf.php 9641
ERROR - 2025-08-05 10:43:57 --> Severity: error --> Exception: Unable to create output file C:\xampp\htdocs\ifocus\uploads/pdf_reports/ReportCard/report-20250805_104357.pdf C:\xampp\htdocs\ifocus\application\third_party\mpdf\mpdf\mpdf\src\Mpdf.php 9644
ERROR - 2025-08-05 10:45:57 --> Severity: Warning --> fopen(C:\xampp\htdocs\ifocus\uploads/pdf_reports/ReportCard/report-20250805_104557.pdf): Failed to open stream: No such file or directory C:\xampp\htdocs\ifocus\application\third_party\mpdf\mpdf\mpdf\src\Mpdf.php 9641
ERROR - 2025-08-05 10:45:57 --> Severity: error --> Exception: Unable to create output file C:\xampp\htdocs\ifocus\uploads/pdf_reports/ReportCard/report-20250805_104557.pdf C:\xampp\htdocs\ifocus\application\third_party\mpdf\mpdf\mpdf\src\Mpdf.php 9644
ERROR - 2025-08-05 10:54:35 --> Severity: 8192 --> json_decode(): Passing null to parameter #1 ($json) of type string is deprecated C:\xampp\htdocs\ifocus\application\models\Exam_model.php 643
ERROR - 2025-08-05 10:54:35 --> Severity: 8192 --> json_decode(): Passing null to parameter #1 ($json) of type string is deprecated C:\xampp\htdocs\ifocus\application\models\Exam_model.php 643
ERROR - 2025-08-05 10:59:59 --> Severity: error --> Exception: The HTML code size is larger than pcre.backtrack_limit 1000000. You should use WriteHTML() with smaller string lengths. C:\xampp\htdocs\ifocus\application\third_party\mpdf\mpdf\mpdf\src\Mpdf.php 27043
ERROR - 2025-08-05 12:00:56 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\config\config.php 26
ERROR - 2025-08-05 11:24:02 --> Severity: 8192 --> mb_convert_encoding(): Handling HTML entities via mbstring is deprecated; use htmlspecialchars, htmlentities, or mb_encode_numericentity/mb_decode_numericentity instead C:\xampp\htdocs\ifocus\application\controllers\Exam.php 1097
ERROR - 2025-08-05 11:24:02 --> Severity: 8192 --> mb_convert_encoding(): Handling HTML entities via mbstring is deprecated; use htmlspecialchars, htmlentities, or mb_encode_numericentity/mb_decode_numericentity instead C:\xampp\htdocs\ifocus\application\controllers\Exam.php 1097
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "punctualtiy" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 441
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "punctualtiy" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 441
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "neatness" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 445
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "neatness" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 445
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "obedience" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 449
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "obedience" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 449
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "self_control" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 453
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "self_control" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 453
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "participation" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 457
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "participation" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 457
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "use_of_intiative" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 468
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "use_of_intiative" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 468
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "handling" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 472
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "handling" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 472
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "communication" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 476
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "communication" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 476
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "realtionship" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 480
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "realtionship" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 480
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "sports" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 484
ERROR - 2025-08-05 11:51:32 --> Severity: Warning --> Attempt to read property "sports" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 484
ERROR - 2025-08-05 11:57:47 --> Severity: Warning --> mkdir(): File exists C:\xampp\htdocs\ifocus\application\controllers\Exam.php 1043
ERROR - 2025-08-05 11:58:21 --> Severity: Warning --> Attempt to read property "use_of_intiative" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 469
ERROR - 2025-08-05 11:58:21 --> Severity: Warning --> Attempt to read property "use_of_intiative" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 469
ERROR - 2025-08-05 11:58:21 --> Severity: Warning --> Attempt to read property "handling" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 473
ERROR - 2025-08-05 11:58:21 --> Severity: Warning --> Attempt to read property "handling" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 473
ERROR - 2025-08-05 11:58:21 --> Severity: Warning --> Attempt to read property "communication" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 477
ERROR - 2025-08-05 11:58:21 --> Severity: Warning --> Attempt to read property "communication" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 477
ERROR - 2025-08-05 11:58:21 --> Severity: Warning --> Attempt to read property "realtionship" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 481
ERROR - 2025-08-05 11:58:21 --> Severity: Warning --> Attempt to read property "realtionship" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 481
ERROR - 2025-08-05 11:58:21 --> Severity: Warning --> Attempt to read property "sports" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 485
ERROR - 2025-08-05 11:58:21 --> Severity: Warning --> Attempt to read property "sports" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 485
ERROR - 2025-08-05 13:00:56 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\config\config.php 26
ERROR - 2025-08-05 12:02:26 --> Severity: Warning --> Attempt to read property "use_of_intiative" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 469
ERROR - 2025-08-05 12:02:26 --> Severity: Warning --> Attempt to read property "handling" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 473
ERROR - 2025-08-05 12:02:26 --> Severity: Warning --> Attempt to read property "communication" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 477
ERROR - 2025-08-05 12:02:26 --> Severity: Warning --> Attempt to read property "realtionship" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 481
ERROR - 2025-08-05 12:02:26 --> Severity: Warning --> Attempt to read property "sports" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 485
ERROR - 2025-08-05 12:02:27 --> Severity: Warning --> Attempt to read property "use_of_intiative" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 469
ERROR - 2025-08-05 12:02:27 --> Severity: Warning --> Attempt to read property "handling" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 473
ERROR - 2025-08-05 12:02:27 --> Severity: Warning --> Attempt to read property "communication" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 477
ERROR - 2025-08-05 12:02:27 --> Severity: Warning --> Attempt to read property "realtionship" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 481
ERROR - 2025-08-05 12:02:27 --> Severity: Warning --> Attempt to read property "sports" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 485
ERROR - 2025-08-05 12:04:33 --> Severity: Warning --> Attempt to read property "use_of_intiative" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 469
ERROR - 2025-08-05 12:04:33 --> Severity: Warning --> Attempt to read property "handling" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 473
ERROR - 2025-08-05 12:04:33 --> Severity: Warning --> Attempt to read property "communication" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 477
ERROR - 2025-08-05 12:04:33 --> Severity: Warning --> Attempt to read property "realtionship" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 481
ERROR - 2025-08-05 12:04:33 --> Severity: Warning --> Attempt to read property "sports" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 485
ERROR - 2025-08-05 12:04:33 --> Severity: Warning --> Attempt to read property "use_of_intiative" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 469
ERROR - 2025-08-05 12:04:33 --> Severity: Warning --> Attempt to read property "handling" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 473
ERROR - 2025-08-05 12:04:33 --> Severity: Warning --> Attempt to read property "communication" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 477
ERROR - 2025-08-05 12:04:33 --> Severity: Warning --> Attempt to read property "realtionship" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 481
ERROR - 2025-08-05 12:04:33 --> Severity: Warning --> Attempt to read property "sports" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 485
ERROR - 2025-08-05 12:27:33 --> Severity: Warning --> Attempt to read property "use_of_intiative" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 469
ERROR - 2025-08-05 12:27:33 --> Severity: Warning --> Attempt to read property "handling" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 473
ERROR - 2025-08-05 12:27:33 --> Severity: Warning --> Attempt to read property "communication" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 477
ERROR - 2025-08-05 12:27:33 --> Severity: Warning --> Attempt to read property "use_of_intiative" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 469
ERROR - 2025-08-05 12:27:33 --> Severity: Warning --> Attempt to read property "realtionship" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 481
ERROR - 2025-08-05 12:27:33 --> Severity: Warning --> Attempt to read property "handling" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 473
ERROR - 2025-08-05 12:27:33 --> Severity: Warning --> Attempt to read property "sports" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 485
ERROR - 2025-08-05 12:27:33 --> Severity: Warning --> Attempt to read property "communication" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 477
ERROR - 2025-08-05 12:27:33 --> Severity: Warning --> Attempt to read property "realtionship" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 481
ERROR - 2025-08-05 12:27:33 --> Severity: Warning --> Attempt to read property "sports" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 485
ERROR - 2025-08-05 12:49:36 --> Severity: Warning --> Attempt to read property "punctualtiy" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 441
ERROR - 2025-08-05 12:49:36 --> Severity: Warning --> Attempt to read property "neatness" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 445
ERROR - 2025-08-05 12:49:36 --> Severity: Warning --> Attempt to read property "obedience" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 449
ERROR - 2025-08-05 12:49:36 --> Severity: Warning --> Attempt to read property "self_control" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 453
ERROR - 2025-08-05 12:49:36 --> Severity: Warning --> Attempt to read property "participation" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 457
ERROR - 2025-08-05 12:49:36 --> Severity: Warning --> Attempt to read property "use_of_intiative" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 468
ERROR - 2025-08-05 12:49:36 --> Severity: Warning --> Attempt to read property "handling" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 472
ERROR - 2025-08-05 12:49:36 --> Severity: Warning --> Attempt to read property "communication" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 476
ERROR - 2025-08-05 12:49:36 --> Severity: Warning --> Attempt to read property "realtionship" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 480
ERROR - 2025-08-05 12:49:36 --> Severity: Warning --> Attempt to read property "sports" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 484
ERROR - 2025-08-05 12:59:03 --> Severity: error --> Exception: syntax error, unexpected token "if", expecting "," or ";" C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 91
ERROR - 2025-08-05 12:59:14 --> Severity: error --> Exception: syntax error, unexpected token "if", expecting "," or ";" C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 91
ERROR - 2025-08-05 14:00:56 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\config\config.php 26
ERROR - 2025-08-05 13:01:49 --> Severity: Warning --> Attempt to read property "punctualtiy" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 439
ERROR - 2025-08-05 13:01:49 --> Severity: Warning --> Attempt to read property "neatness" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 443
ERROR - 2025-08-05 13:01:49 --> Severity: Warning --> Attempt to read property "obedience" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 447
ERROR - 2025-08-05 13:01:49 --> Severity: Warning --> Attempt to read property "self_control" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 451
ERROR - 2025-08-05 13:01:49 --> Severity: Warning --> Attempt to read property "participation" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 455
ERROR - 2025-08-05 13:01:49 --> Severity: Warning --> Attempt to read property "use_of_intiative" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 466
ERROR - 2025-08-05 13:01:49 --> Severity: Warning --> Attempt to read property "handling" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 470
ERROR - 2025-08-05 13:01:49 --> Severity: Warning --> Attempt to read property "communication" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 474
ERROR - 2025-08-05 13:01:49 --> Severity: Warning --> Attempt to read property "realtionship" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 478
ERROR - 2025-08-05 13:01:49 --> Severity: Warning --> Attempt to read property "sports" on null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 482
ERROR - 2025-08-05 13:27:27 --> Severity: Warning --> Undefined property: stdClass::$punctualtiy C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 440
ERROR - 2025-08-05 13:27:27 --> Severity: Warning --> Undefined property: stdClass::$neatness C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 444
ERROR - 2025-08-05 13:27:27 --> Severity: Warning --> Undefined property: stdClass::$obedience C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 448
ERROR - 2025-08-05 13:27:27 --> Severity: Warning --> Undefined property: stdClass::$self_control C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 452
ERROR - 2025-08-05 13:27:27 --> Severity: Warning --> Undefined property: stdClass::$participation C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 456
ERROR - 2025-08-05 13:27:27 --> Severity: Warning --> Undefined property: stdClass::$use_of_intiative C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 467
ERROR - 2025-08-05 13:27:27 --> Severity: Warning --> Undefined property: stdClass::$handling C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 471
ERROR - 2025-08-05 13:27:27 --> Severity: Warning --> Undefined property: stdClass::$communication C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 475
ERROR - 2025-08-05 13:27:27 --> Severity: Warning --> Undefined property: stdClass::$realtionship C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 479
ERROR - 2025-08-05 13:27:27 --> Severity: Warning --> Undefined property: stdClass::$sports C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 483
ERROR - 2025-08-05 13:29:01 --> Severity: Warning --> Undefined property: stdClass::$punctualtiy C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 450
ERROR - 2025-08-05 13:29:01 --> Severity: Warning --> Undefined property: stdClass::$neatness C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 454
ERROR - 2025-08-05 13:29:01 --> Severity: Warning --> Undefined property: stdClass::$obedience C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 458
ERROR - 2025-08-05 13:29:01 --> Severity: Warning --> Undefined property: stdClass::$self_control C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 462
ERROR - 2025-08-05 13:29:01 --> Severity: Warning --> Undefined property: stdClass::$participation C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 466
ERROR - 2025-08-05 13:29:01 --> Severity: Warning --> Undefined property: stdClass::$use_of_intiative C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 477
ERROR - 2025-08-05 13:29:01 --> Severity: Warning --> Undefined property: stdClass::$handling C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 481
ERROR - 2025-08-05 13:29:01 --> Severity: Warning --> Undefined property: stdClass::$communication C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 485
ERROR - 2025-08-05 13:29:01 --> Severity: Warning --> Undefined property: stdClass::$realtionship C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 489
ERROR - 2025-08-05 13:29:01 --> Severity: Warning --> Undefined property: stdClass::$sports C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 493
ERROR - 2025-08-05 13:45:53 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\core\MY_Controller.php 175
ERROR - 2025-08-05 13:45:55 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$file is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 13:47:59 --> Severity: 8192 --> json_decode(): Passing null to parameter #1 ($json) of type string is deprecated C:\xampp\htdocs\ifocus\application\models\Exam_model.php 643
ERROR - 2025-08-05 13:56:18 --> Severity: 8192 --> json_decode(): Passing null to parameter #1 ($json) of type string is deprecated C:\xampp\htdocs\ifocus\application\models\Exam_model.php 643
ERROR - 2025-08-05 15:00:56 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\config\config.php 26
ERROR - 2025-08-05 16:00:56 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\config\config.php 26
ERROR - 2025-08-05 17:00:56 --> Severity: Warning --> Undefined array key "HTTP_HOST" C:\xampp\htdocs\ifocus\application\config\config.php 26
ERROR - 2025-08-05 19:32:35 --> Severity: Warning --> Undefined property: Exam::$student_model C:\xampp\htdocs\ifocus\application\controllers\Exam.php 1075
ERROR - 2025-08-05 19:32:35 --> Severity: error --> Exception: Call to a member function getSingleStudent() on null C:\xampp\htdocs\ifocus\application\controllers\Exam.php 1075
ERROR - 2025-08-05 19:32:58 --> Severity: Warning --> Undefined property: Exam::$student_model C:\xampp\htdocs\ifocus\application\controllers\Exam.php 1075
ERROR - 2025-08-05 19:32:58 --> Severity: error --> Exception: Call to a member function getSingleStudent() on null C:\xampp\htdocs\ifocus\application\controllers\Exam.php 1075
ERROR - 2025-08-05 19:37:48 --> Severity: Warning --> Undefined property: Exam::$student_model C:\xampp\htdocs\ifocus\application\controllers\Exam.php 1076
ERROR - 2025-08-05 19:37:48 --> Severity: error --> Exception: Call to a member function getSingleStudent() on null C:\xampp\htdocs\ifocus\application\controllers\Exam.php 1076
ERROR - 2025-08-05 19:38:43 --> 404 Page Not Found: 
ERROR - 2025-08-05 19:44:47 --> 404 Page Not Found: 
ERROR - 2025-08-05 19:45:25 --> 404 Page Not Found: 
ERROR - 2025-08-05 19:46:16 --> 404 Page Not Found: 
ERROR - 2025-08-05 19:46:50 --> 404 Page Not Found: 
ERROR - 2025-08-05 19:48:56 --> 404 Page Not Found: 
ERROR - 2025-08-05 19:55:25 --> 404 Page Not Found: 
ERROR - 2025-08-05 19:56:09 --> 404 Page Not Found: 
ERROR - 2025-08-05 21:02:29 --> Severity: error --> Exception: syntax error, unexpected identifier "ppublic", expecting "function" or "const" C:\xampp\htdocs\ifocus\application\controllers\Exam.php 1004
ERROR - 2025-08-05 21:02:34 --> Severity: error --> Exception: syntax error, unexpected identifier "ppublic", expecting "function" or "const" C:\xampp\htdocs\ifocus\application\controllers\Exam.php 1004
ERROR - 2025-08-05 20:03:09 --> Severity: Warning --> Undefined property: Exam::$attendance_model C:\xampp\htdocs\ifocus\application\controllers\Exam.php 1103
ERROR - 2025-08-05 20:03:09 --> Severity: error --> Exception: Call to a member function getStudentAttendanceSummary() on null C:\xampp\htdocs\ifocus\application\controllers\Exam.php 1103
ERROR - 2025-08-05 20:11:05 --> Severity: Warning --> Undefined property: Exam::$cache C:\xampp\htdocs\ifocus\system\core\Model.php 74
ERROR - 2025-08-05 20:11:05 --> Severity: error --> Exception: Call to a member function get() on null C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 35
ERROR - 2025-08-05 20:11:49 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$dummy is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 20:22:50 --> Severity: 8192 --> json_decode(): Passing null to parameter #1 ($json) of type string is deprecated C:\xampp\htdocs\ifocus\application\models\Exam_model.php 643
ERROR - 2025-08-05 21:01:03 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\core\MY_Controller.php 175
ERROR - 2025-08-05 21:01:06 --> Severity: 8192 --> Creation of dynamic property CI_Cache::$file is deprecated C:\xampp\htdocs\ifocus\system\libraries\Driver.php 189
ERROR - 2025-08-05 23:43:50 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 3
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 214
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 216
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 218
ERROR - 2025-08-05 23:44:09 --> Severity: 8192 --> str_replace(): Passing null to parameter #3 ($subject) of type array|string is deprecated C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 341
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 214
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 216
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 218
ERROR - 2025-08-05 23:44:09 --> Severity: 8192 --> str_replace(): Passing null to parameter #3 ($subject) of type array|string is deprecated C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 341
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 66
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 176
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 179
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 315
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 331
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 338
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 398
ERROR - 2025-08-05 23:44:09 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 498
ERROR - 2025-08-05 23:45:22 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 3
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 214
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 216
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 218
ERROR - 2025-08-05 23:45:42 --> Severity: 8192 --> str_replace(): Passing null to parameter #3 ($subject) of type array|string is deprecated C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 341
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 214
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 216
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 218
ERROR - 2025-08-05 23:45:42 --> Severity: 8192 --> str_replace(): Passing null to parameter #3 ($subject) of type array|string is deprecated C:\xampp\htdocs\ifocus\application\models\Marksheet_template_model.php 341
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 66
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 176
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 179
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 277
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 280
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 315
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 331
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 338
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 398
ERROR - 2025-08-05 23:45:42 --> Severity: Warning --> Trying to access array offset on value of type null C:\xampp\htdocs\ifocus\application\views\exam\reportCard_PDF.php 498
