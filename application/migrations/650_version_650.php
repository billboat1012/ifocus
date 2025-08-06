<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_650 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
		
		$this->db->query("ALTER TABLE `online_admission` ADD `reference_no` VARCHAR(255) NULL DEFAULT NULL AFTER `id`; ");
		$this->db->query("ALTER TABLE `subject_assign` CHANGE `subject_id` `subject_id` INT NOT NULL;");
		
		$this->db->query("ALTER TABLE `enroll` CHANGE `branch_id` `branch_id` INT NOT NULL;");
		$this->db->query("ALTER TABLE `enroll` ADD `default_login` TINYINT NOT NULL DEFAULT '0' AFTER `session_id`;");
		$this->db->query("ALTER TABLE `enroll` ADD `is_alumni` TINYINT NOT NULL DEFAULT '0' AFTER `branch_id`;");

		$this->db->query("ALTER TABLE `promotion_history` ADD `is_leave` TINYINT(1) NOT NULL DEFAULT '0' AFTER `prev_due`; ");

		
		$this->db->query("ALTER TABLE `branch` ADD `student_login` TINYINT NOT NULL DEFAULT '1' AFTER `reg_prefix_enable`, ADD `parent_login` TINYINT NOT NULL DEFAULT '1' AFTER `student_login`; ");
		$this->db->query("ALTER TABLE `branch` ADD `teacher_mobile_visible` TINYINT NOT NULL DEFAULT '1' AFTER `parent_login`, ADD `teacher_email_visible` TINYINT NOT NULL DEFAULT '1' AFTER `teacher_mobile_visible`;");
		$this->db->query("ALTER TABLE `branch` ADD `attendance_type` TINYINT NOT NULL DEFAULT '0' AFTER `offline_payments`; ");
		$this->db->query("ALTER TABLE `branch` ADD `show_own_question` TINYINT NOT NULL DEFAULT '0' AFTER `attendance_type`; ");
		
		$this->db->query("ALTER TABLE `purchase_bill_details` CHANGE `product_id` `product_id` INT NOT NULL;");
		$this->db->query("ALTER TABLE `product_issues_details` CHANGE `product_id` `product_id` INT NOT NULL;");
		$this->db->query("ALTER TABLE `sales_bill_details` CHANGE `product_id` `product_id` INT NOT NULL; ");
		$this->db->query("ALTER TABLE `subject_assign` CHANGE `subject_id` `subject_id` INT NOT NULL; ");

		$this->db->query("CREATE TABLE IF NOT EXISTS `student_subject_attendance` (
						  `id` int NOT NULL AUTO_INCREMENT,
						  `enroll_id` int DEFAULT NULL,
						  `subject_timetable_id` int DEFAULT NULL,
						  `status` varchar(255) DEFAULT NULL,
						  `date` date DEFAULT NULL,
						  `remark` text,
						  `branch_id` int NOT NULL,
						  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						  PRIMARY KEY (`id`),
						  KEY `attendence_type_id` (`status`),
						  KEY `student_session_id` (`enroll_id`),
						  KEY `subject_timetable_id` (`subject_timetable_id`),
						  KEY `student_subject_attendance_rms_1` (`branch_id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$this->db->query("CREATE TABLE IF NOT EXISTS `login_log` (
						  `id` int NOT NULL AUTO_INCREMENT,
						  `user_id` int NOT NULL,
						  `role` int NOT NULL,
						  `ip` varchar(255) NOT NULL,
						  `browser` varchar(255) NOT NULL,
						  `platform` varchar(255) NOT NULL,
						  `timestamp` timestamp NOT NULL,
						  `branch_id` int DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `login_log_rms_1` (`branch_id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$this->db->query("CREATE TABLE IF NOT EXISTS `front_cms_news` (
						  `id` int NOT NULL AUTO_INCREMENT,
						  `title` varchar(255) NOT NULL,
						  `description` text NOT NULL,
						  `page_title` varchar(255) DEFAULT NULL,
						  `banner_image` varchar(255) DEFAULT NULL,
						  `meta_description` text NOT NULL,
						  `meta_keyword` text NOT NULL,
						  `branch_id` int NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->db->query("INSERT INTO `front_cms_news` (`id`, `title`, `description`, `page_title`, `banner_image`, `meta_description`, `meta_keyword`, `branch_id`) VALUES
						(1, '', '<p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</p><p>Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.</p>', 'News', 'news1.jpg', 'Ramom - School Management System With CMS', 'Ramom News Page', 1); ");

		$this->db->query("CREATE TABLE IF NOT EXISTS `front_cms_news_list` (
						  `id` int NOT NULL AUTO_INCREMENT,
						  `title` varchar(255) DEFAULT NULL,
						  `description` text NOT NULL,
						  `image` varchar(255) NOT NULL,
						  `alias` varchar(500) NOT NULL,
						  `date` date NOT NULL,
						  `show_web` tinyint NOT NULL DEFAULT '1',
						  `branch_id` int NOT NULL,
						  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
						
        $this->db->query("CREATE TABLE IF NOT EXISTS `front_cms_popup_list` (
						  `id` int NOT NULL AUTO_INCREMENT,
						  `image` varchar(255) NOT NULL,
						  `alias` varchar(500) NOT NULL,
						  `date` date NOT NULL,
						  `show_web` tinyint NOT NULL DEFAULT '1',
						  `branch_id` int NOT NULL,
						  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
						
		$this->db->query("CREATE TABLE IF NOT EXISTS `alumni_events` (
						  `id` int NOT NULL AUTO_INCREMENT,
						  `title` text NOT NULL,
						  `audience` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
						  `session_id` int DEFAULT NULL,
						  `selected_list` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
						  `from_date` date NOT NULL,
						  `to_date` date NOT NULL,
						  `note` text NOT NULL,
						  `photo` varchar(255) DEFAULT NULL,
						  `show_web` int NOT NULL DEFAULT '0',
						  `status` tinyint(1) NOT NULL DEFAULT '1',
						  `branch_id` int NOT NULL,
						  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						  PRIMARY KEY (`id`),
						  KEY `session_id` (`session_id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->db->query("CREATE TABLE IF NOT EXISTS `alumni_students` (
						  `id` int NOT NULL AUTO_INCREMENT,
						  `enroll_id` int NOT NULL,
						  `email` varchar(255) NOT NULL,
						  `mobile_no` varchar(255) NOT NULL,
						  `address` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
						  `profession` varchar(255) NOT NULL,
						  `photo` varchar(500) NOT NULL,
						  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->db->query("CREATE TABLE IF NOT EXISTS `marksheet_template` (
						  `id` int NOT NULL AUTO_INCREMENT,
						  `name` varchar(255) NOT NULL,
						  `background` varchar(355) DEFAULT NULL,
						  `logo` varchar(355) DEFAULT NULL,
						  `left_signature` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
						  `middle_signature` varchar(255) DEFAULT NULL,
						  `right_signature` varchar(255) DEFAULT NULL,
						  `attendance_percentage` tinyint NOT NULL DEFAULT '1',
						  `grading_scale` tinyint NOT NULL DEFAULT '1',
						  `position` tinyint NOT NULL DEFAULT '1',
						  `cumulative_average` tinyint NOT NULL DEFAULT '1',
						  `class_average` tinyint NOT NULL DEFAULT '1',
						  `result` tinyint NOT NULL DEFAULT '1',
						  `subject_position` tinyint NOT NULL DEFAULT '1',
						  `remark` tinyint NOT NULL DEFAULT '1',
						  `header_content` text CHARACTER SET utf8 COLLATE utf8_general_ci,
						  `footer_content` text,
						  `page_layout` tinyint(1) NOT NULL,
						  `photo_style` tinyint(1) NOT NULL,
						  `photo_size` float NOT NULL DEFAULT '120',
						  `top_space` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
						  `bottom_space` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
						  `right_space` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
						  `left_space` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
						  `branch_id` int NOT NULL,
						  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$this->db->query("INSERT INTO `permission` (`id`, `module_id`, `name`, `prefix`, `show_view`, `show_add`, `show_edit`, `show_delete`, `created_at`) VALUES
						(169, 18, 'User Login Log', 'user_login_log', 1, 0, 0, 1, '2024-04-08 09:01:26'),
						(170, 26, 'Manage Alumni', 'manage_alumni', 1, 1, 1, 1, '2024-04-08 09:01:26'),
						(171, 26, 'Alumni Events', 'alumni_events', 1, 1, 1, 1, '2024-04-08 09:01:26'),
						(172, 27, 'Multi Class Student', 'multi_class', 1, 1, 0, 0, '2024-05-02 08:28:04'),
						(173, 22, 'Frontend News', 'frontend_news', 1, 1, 1, 1, '2024-05-05 08:45:48'),
						(174, 9, 'Marksheet Template', 'marksheet_template', 1, 1, 1, 1, '2024-05-10 05:59:53'); ");

		$this->db->query("INSERT INTO `permission_modules` (`id`, `name`, `prefix`, `system`, `sorted`, `in_module`, `created_at`) VALUES
						(26, 'Alumni', 'alumni', 1, 24, 1, '2023-06-13 19:16:49'),
						(27, 'Multi Class', 'multi_class', 1, 25, 1, '2024-05-02 08:32:01');");

		$this->db->query("INSERT INTO `sms_template` (`id`, `name`, `tags`) VALUES
						(11, 'alumni_event', '{student_name}, {event_title}, {start_date}, {end_date}'); ");

		$this->db->query("INSERT INTO `front_cms_menu` (`title`, `alias`, `ordering`, `parent_id`, `open_new_tab`, `ext_url`, `ext_url_address`, `publish`, `system`, `branch_id`, `created_at`) VALUES
						('News', 'news', 8, 0, 0, 0, '', 1, 1, 0, '2024-05-12 14:50:05');");
		$this->db->query("INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`) VALUES
						(2, 173, 1, 1, 1, 1),
						(2, 154, 0, 0, 0, 0),
						(2, 174, 1, 1, 1, 1),
						(2, 155, 0, 0, 0, 0),
						(2, 156, 1, 1, 1, 1),
						(2, 401, 0, 0, 0, 0),
						(2, 501, 0, 0, 0, 0),
						(2, 502, 0, 0, 0, 0),
						(2, 503, 0, 0, 0, 0),
						(2, 504, 0, 0, 0, 0),
						(2, 518, 0, 0, 0, 0),
						(2, 169, 0, 0, 1, 1),
						(2, 170, 1, 1, 1, 1),
						(2, 171, 1, 1, 1, 1),
						(2, 172, 1, 0, 1, 0); ");
		$feeAllocation = $this->db->select('id,student_id,session_id')->get('fee_allocation')->result();
		foreach ($feeAllocation as $key => $value) {
			$enroll = $this->db->select('id')->where(array('student_id' => $value->student_id, 'session_id' => $value->session_id))->get('enroll')->row();
			if (!empty($enroll->id)) {
		        $this->db->where('id', $value->id);
		        $this->db->update('fee_allocation', ['student_id' => $enroll->id]);
			}
		}

		$onlineAdmission = $this->db->select('id,reference_no')->get('online_admission')->result();
		foreach ($onlineAdmission as $key => $value) {
            do {
                $reference_no = mt_rand(0000001, 99999999);
                $refence_status = ($value->reference_no == $reference_no ? 1 : 0);
            } while ($refence_status);

            $this->db->where("id", $value->id);
			$this->db->update('online_admission', ['reference_no' => $reference_no]);
		}

		$tags = "{institute_name}, {reference_no}, {applicant_name}, {applicant_mobile}, {class}, {section}, {apply_date}, {payment_url}, {admission_copy_url}, {paid_amount}";
        $this->db->where("name","apply_online_admission");
		$this->db->update('email_templates', ['tags' => $tags]);
    }
}
