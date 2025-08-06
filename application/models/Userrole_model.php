<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Userrole_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getTeachersList($branchID = '')
    {
        $this->db->select('staff.*,staff_designation.name as designation_name,staff_department.name as department_name,login_credential.role as role_id, roles.name as role');
        $this->db->from('staff');
        $this->db->join('login_credential', 'login_credential.user_id = staff.id and login_credential.role != "6" and login_credential.role != "7"', 'inner');
        $this->db->join('roles', 'roles.id = login_credential.role', 'left');
        $this->db->join('staff_designation', 'staff_designation.id = staff.designation', 'left');
        $this->db->join('staff_department', 'staff_department.id = staff.department', 'left');
        if ($branchID != "") {
            $this->db->where('staff.branch_id', $branchID);
        }
        $this->db->where('login_credential.role', 3);
        $this->db->where('login_credential.active', 1);
        $this->db->order_by('staff.id', 'ASC');
        return $this->db->get()->result();
    }

    // get route information by route id and vehicle id
    public function getRouteDetails($routeID, $vehicleID)
    {
        $this->db->select('ta.route_id,ta.stoppage_id,ta.vehicle_id,r.name as route_name,r.start_place,r.stop_place,sp.stop_position,sp.stop_time,sp.route_fare,v.vehicle_no,v.driver_name,v.driver_phone');
        $this->db->from('transport_assign as ta');
        $this->db->join('transport_route as r', 'r.id = ta.route_id', 'left');
        $this->db->join('transport_vehicle as v', 'v.id = ta.vehicle_id', 'left');
        $this->db->join('transport_stoppage as sp', 'sp.id = ta.stoppage_id', 'left');
        $this->db->where('ta.route_id', $routeID);
        $this->db->where('ta.vehicle_id', $vehicleID);
        return $this->db->get()->row_array();
    }

    public function getAssignList($branch_id = '')
    {
        $this->db->select('ta.route_id,ta.stoppage_id,ta.branch_id,r.name,r.start_place,r.stop_place,sp.stop_position,sp.stop_time,sp.route_fare');
        $this->db->from('transport_assign as ta');
        $this->db->join('transport_route as r', 'r.id = ta.route_id', 'left');
        $this->db->join('transport_stoppage as sp', 'sp.id = ta.stoppage_id', 'left');
        $this->db->group_by(array('ta.route_id', 'ta.stoppage_id', 'ta.branch_id'));
        if (!empty($branch_id)) {
            $this->db->where('ta.branch_id', $branch_id);
        }
        return $this->db->get()->result_array();
    }

    // get vehicle list by route_id
    public function getVehicleList($route_id)
    {
        $this->db->select('ta.vehicle_id,v.vehicle_no');
        $this->db->from('transport_assign as ta');
        $this->db->join('transport_vehicle as v', 'v.id = ta.vehicle_id', 'left');
        $this->db->where('ta.route_id', $route_id);
        $vehicles = $this->db->get()->result();
        $name_list = '';
        foreach ($vehicles as $row) {
            $name_list .= '- ' . $row->vehicle_no . '<br>';
        }
        return $name_list;
    }

    // get hostel information by hostel id and room id
    public function getHostelDetails($hostelID, $roomID)
    {
        $this->db->select('h.name as hostel_name,h.watchman,h.category_id,h.address,hc.name as hcategory_name,rc.name as rcategory_name,hr.name as room_name,hr.no_beds,hr.bed_fee');
        $this->db->from('hostel as h');
        $this->db->join('hostel_category as hc', 'hc.id = h.category_id', 'left');
        $this->db->join('hostel_room as hr', 'hr.hostel_id = h.id', 'left');
        $this->db->join('hostel_category as rc', 'rc.id = hr.category_id', 'left');
        $this->db->where('hr.id', $roomID);
        $this->db->where('h.id', $hostelID);
        return $this->db->get()->row();
    }

    // check attendance by staff id and date
    public function get_attendance_by_date($enroll_id, $date)
    {
        $sql = "SELECT `student_attendance`.* FROM `student_attendance` WHERE `enroll_id` = " . $this->db->escape($enroll_id) . " AND `date` = " . $this->db->escape($date);
        return $this->db->query($sql)->row_array();
    }

    public function getStudentDetails()
    {
        $sessionID = get_session_id();
        if (is_student_loggedin()) {
            $enrollID = $this->session->userdata('enrollID');
        } elseif (is_parent_loggedin()) {
            $enrollID = $this->session->userdata('enrollID');
        }
        $this->db->select('CONCAT_WS(" ",s.first_name, s.last_name) as fullname,s.email as student_email,s.register_no,e.branch_id,e.id as enroll_id,e.student_id,s.hostel_id,s.room_id,s.route_id,s.vehicle_id,e.class_id,c.name as class_name,b.school_name,b.email as school_email,b.mobileno as school_mobileno,b.address as school_address');
        $this->db->from('enroll as e');
        $this->db->join('student as s', 's.id = e.student_id', 'inner');
        $this->db->join('branch as b', 'b.id = e.branch_id', 'left');
        $this->db->join('class as c', 'c.id = e.class_id', 'left');
        $this->db->where('e.id', $enrollID);
        $this->db->where('e.session_id', $sessionID);
        return $this->db->get()->row_array();
    }

    public function getHomeworkList($enrollID = '')
    {
        $this->db->select('homework.*,CONCAT_WS(" ",s.first_name, s.last_name) as fullname,s.register_no,e.student_id, e.roll,subject.name as subject_name,class.name as class_name,he.id as ev_id,he.status as ev_status,he.remark as ev_remarks,he.rank,hs.message,hs.enc_name,hs.file_name');
        $this->db->from('homework');
        $this->db->join('enroll as e', 'e.class_id=homework.class_id and e.session_id = homework.session_id', 'inner');
        $this->db->join('student as s', 'e.student_id = s.id', 'inner');
        $this->db->join('homework_evaluation as he', 'he.homework_id = homework.id and he.student_id = e.student_id', 'left');
        $this->db->join('subject', 'subject.id = homework.subject_id', 'left');
        $this->db->join('homework_submit as hs', 'hs.homework_id = homework.id and hs.student_id = e.student_id', 'left');
        $this->db->join('class', 'class.id = homework.class_id', 'left');
        $this->db->where('e.id', $enrollID);
        $this->db->where('homework.status', 0);
        $this->db->where('homework.session_id', get_session_id());
        $this->db->group_by('homework.id');
        $this->db->order_by('homework.id', 'desc');
        return $this->db->get()->result_array();
    }

    public function getUserDetails()
    {
        if (is_student_loggedin()) {
            $studentID = get_loggedin_user_id();
            $this->db->select('*,CONCAT_WS(" ",first_name, last_name) as name, current_address as address');
            $this->db->from('student');
        } elseif (is_parent_loggedin()) {
            $this->db->select('*');
            $this->db->from('parent');
        }
        $this->db->where('id', get_loggedin_user_id());
        return $this->db->get()->row_array();
    }

    
    public function examListDT($postData, $currency_symbol = '')
    {
        $response = array();
        $sessionID = get_session_id();
    
        // Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $searchValue = $postData['search']['value']; // Search value
    
        // Order
        $columnIndex = empty($postData['order'][0]['column']) ? 0 : $postData['order'][0]['column'];
        $columnSortOrder = empty($postData['order'][0]['dir']) ? 'DESC' : $postData['order'][0]['dir'];
        $column_order = array('`online_exam`.`id`');
    
        // Search filters
        $search_arr = array();
        $searchQuery = "";
        if ($searchValue != '') {
            $search_arr[] = " (`online_exam`.`title` LIKE '%" . $searchValue . "%' OR `online_exam`.`exam_start` LIKE '%" . $searchValue . "%' OR `online_exam`.`exam_end` LIKE '%" . $searchValue . "%') ";
        }
    
        $enrollID = $this->session->userdata('enrollID');
        $enroll = $this->db->select('*')->where(array('id' => $enrollID))->get('enroll')->row();
    
        $branch_id = $this->db->escape(get_loggedin_branch_id());
        $search_arr[] = " `online_exam`.`branch_id` = $branch_id AND `online_exam`.`class_id` = " . $this->db->escape($enroll->class_id);
    
        // Order columns
        $column_order[] = '`online_exam`.`title`';
        $column_order[] = '`class`.`id`';
        $column_order[] = '';
        $column_order[] = '`questions_qty`';
        $column_order[] = '`online_exam`.`exam_start`';
        $column_order[] = '`online_exam`.`exam_end`';
        $column_order[] = '`online_exam`.`duration`';
    
        if (count($search_arr) > 0) {
            $searchQuery = implode(" AND ", $search_arr);
        }
    
        // Total number of records without filtering
        $totalRecords = 0;
    
        // Total number of records with filtering
        $sql = "SELECT `id` FROM `online_exam` WHERE `publish_status` = '1'";
        if (!empty($searchQuery)) {
            $sql .= " AND " . $searchQuery;
        }
        $records = $this->db->query($sql)->result();
    
        // Set totalRecordwithFilter without section filtering
        $totalRecordwithFilter = count($records);
    
        // Fetch records
        $studentID = $this->db->escape(get_loggedin_user_id());
        $sql = "SELECT `online_exam`.*, `class`.`name` as `class_name`, 
                       (SELECT COUNT(`id`) FROM `questions_manage` WHERE `questions_manage`.`onlineexam_id` = `online_exam`.`id`) as `questions_qty`, 
                       (SELECT COUNT(`id`) FROM `online_exam_payment` WHERE `online_exam_payment`.`exam_id` = `online_exam`.`id` AND `online_exam_payment`.`student_id` = $studentID) as `payment_status`, 
                       `branch`.`name` as `branchname` 
                FROM `online_exam` 
                INNER JOIN `branch` ON `branch`.`id` = `online_exam`.`branch_id` 
                LEFT JOIN `class` ON `class`.`id` = `online_exam`.`class_id` 
                WHERE `publish_status` = '1'";
    
        if (!empty($searchQuery)) {
            $sql .= " AND " . $searchQuery;
        }
    
        $sql .= " ORDER BY " . $column_order[$columnIndex] . " $columnSortOrder LIMIT $start, $rowperpage";
        $records = $this->db->query($sql)->result();
    
        $data = array();
        $count = $start + 1;
        foreach ($records as $record) {
            // Removed the section filtering here
            $startTime = strtotime($record->exam_start);
            $endTime = strtotime($record->exam_end);
            $now = strtotime("now");
            $examSubmitted = $this->onlineexam_model->getStudentSubmitted($record->id);
            $status = '';
            $labelmode = '';
            $takeExam = 0;
    
            // Determine exam status
            if ($record->publish_result == 1 && !empty($examSubmitted)) {
                $status = translate('result_published');
                $labelmode = 'label-success-custom';
            } else {
                if (!empty($examSubmitted)) {
                    $status = '<i class="fas fa-check fa-fw"></i> ' . translate('already_submitted');
                    $labelmode = 'label-success-custom';
                } elseif ($startTime <= $now && $now <= $endTime) {
                    $status = translate('live');
                    $labelmode = 'label-warning-custom';
                    $takeExam = 1;
                } elseif ($startTime >= $now && $now <= $endTime) {
                    $status = '<i class="far fa-clock"></i> ' . translate('waiting');
                    $labelmode = 'label-info-custom';
                } elseif ($now >= $endTime) {
                    $status = translate('closed');
                    $labelmode = 'label-danger-custom';
                }
            }
    
            $row = array();
            $action = "";
            $paymentStatus = 0;
            if ($record->exam_type == 1 && $record->payment_status == 0) {
                $paymentStatus = 1;
            }
            if ($takeExam == 1) {
                $url = base_url('userrole/onlineexam_take/' . $record->id);
                if ($paymentStatus == 1) {
                    $action .= '<a href="javascript:void(0);" onclick="paymentModal(' . $this->db->escape($record->id) . ')" class="btn btn-circle btn-default"> <i class="fas fa-credit-card"></i> ' . translate('pay') . " & " . translate('take_exam') . '</a>';
                } else {
                    $action .= '<a href="' . $url . '" class="btn btn-circle btn-default"> <i class="fas fa-users-between-lines"></i> ' . translate('take_exam') . '</a>';
                }
            } else {
                if ($record->publish_result == 1 && !empty($examSubmitted)) {
                    $url = base_url('userrole/onlineexam_take/' . $record->id);
                        $action .= '<a href="javascript:void(0);" onclick="getStudentResult(' . $this->db->escape($record->id) . ')" class="btn btn-circle btn-primary"> 
                                        <i class="fas fa-eye"></i> ' . translate('view') . " " . translate('result') . '
                                    </a>';
                        $action .= '<a href="javascript:void(0);" onclick="getStudentDetailedResult(' . $this->db->escape($record->id) . ')" class="btn btn-circle btn-success"> 
                                        <i class="fas fa-list-alt"></i> ' . translate('view') . " " . translate('script') . '
                                    </a>';
                        $action .= '<a href="' . $url . '" class="btn btn-circle btn-default"> <i class="fas fa-users-between-lines"></i> ' . translate('retake_exam') . '</a>';
                } elseif ($record->limits_participation == 0) {
                    $url = base_url('userrole/onlineexam_take/' . $record->id);
                    $action .= '<a href="' . $url . '" class="btn btn-circle btn-default"> <i class="fas fa-users-between-lines"></i> ' . translate('take_exam') . '</a>';
                } else {
                    $action .= '<a href="javascript:void(0);" disabled class="btn btn-circle btn-default"> <i class="fas fa-users-between-lines"></i> ' . translate('take_exam') . '</a>';
                }
            }
    
            $row[] = $count++;
            $row[] = $record->title;
            $row[] = $record->class_name;
            $row[] = $this->onlineexam_model->getSubjectDetails($record->subject_id);
            $row[] = $record->questions_qty;
            $row[] = _d($record->exam_start) . "<p class='text-muted'>" . date("h:i A", strtotime($record->exam_start)) . "</p>";
            $row[] = _d($record->exam_end) . "<p class='text-muted'>" . date("h:i A", strtotime($record->exam_end)) . "</p>";
            $row[] = $record->duration;
            $row[] = $record->exam_type == 0 ? translate('free') : $currency_symbol . $record->fee;
            $row[] = "<span class='label " . $labelmode . " '>" . $status . "</span>";
            $row[] = $action;
            $data[] = $row;
        }
    
        // Response
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordwithFilter,
            "data" => $data,
        );
    
        return json_encode($response);
    }



    public function getExamDetails($onlineexamID)
    {
        $student = $this->getStudentDetails();
        $classID = $student['class_id'];
        $onlineexamID = $this->db->escape($onlineexamID);
        $sessionID = $this->db->escape(get_session_id());
        $branchID = $this->db->escape(get_loggedin_branch_id());
        $studentID = $this->db->escape(get_loggedin_user_id());
        $sql = "SELECT `online_exam`.*, `class`.`name` as `class_name`,(SELECT COUNT(`id`) FROM `questions_manage` WHERE `questions_manage`.`onlineexam_id`=`online_exam`.`id`) as `questions_qty`,(SELECT COUNT(`id`) FROM `online_exam_payment` WHERE `online_exam_payment`.`exam_id`=`online_exam`.`id` AND `online_exam_payment`.`student_id`=$studentID) as `payment_status`, `branch`.`name` as `branchname` FROM `online_exam` INNER JOIN `branch` ON `branch`.`id` = `online_exam`.`branch_id` LEFT JOIN `class` ON `class`.`id` = `online_exam`.`class_id` WHERE `online_exam`.`session_id` = $sessionID AND `online_exam`.`publish_status` = '1' AND `online_exam`.`id` = $onlineexamID AND `online_exam`.`branch_id` = $branchID AND `online_exam`.`class_id` = $classID";
        $records = $this->db->query($sql)->row();
        return $records;
    }


    public function getOfflinePaymentsList($where = array(), $single = false)
    {
        $student = $this->getStudentDetails();
        $this->db->select('op.*,CONCAT_WS(" ",student.first_name, student.last_name) as fullname,student.email,student.mobileno,student.register_no,class.name as class_name,branch.name as branchname');
        $this->db->from('offline_fees_payments as op');
        $this->db->join('enroll', 'enroll.id = op.student_enroll_id', 'left');
        $this->db->join('branch', 'branch.id = enroll.branch_id', 'left');
        $this->db->join('student', 'student.id = enroll.student_id', 'left');
        $this->db->join('class', 'class.id = enroll.class_id', 'left');
        $this->db->where('op.student_enroll_id', $student['enroll_id']);
        if (!empty($where)) {
            $this->db->where($where);
        }
        if ($single == true) {
            $result = $this->db->get()->row_array();
        } else {
            $this->db->order_by('op.id', 'ASC');
            $result = $this->db->get()->result();
        }
        return $result;
    }

    public function getOfflinePaymentsConfig()
    {
        $branchID = get_loggedin_branch_id();
        $row = $this->db->select('offline_payments')->where('id', $branchID)->get('branch')->row()->offline_payments;
        return $row;
    }
    
    
    public function getTemplateByBranch($branchID = '', $examID = '') {
    // First, get the exam type based on the examID
    $this->db->where('id', $examID);
    $this->db->from('exam');
    $examQuery = $this->db->get();

    // Check if the exam details were found
    if ($examQuery->num_rows() > 0) {
        $examDetails = $examQuery->row(); // Fetch the exam details

        if($examDetails->type_id == 4){
            
        $this->db->where('branch_id', $branchID);
        $this->db->where('playgroup', 1);
        $this->db->from('marksheet_template');
        $templateQuery = $this->db->get();
        
        $templates = $templateQuery->result();
        
        }else{
            
        $this->db->where('branch_id', $branchID);
        $this->db->where('playgroup', 0);
        $this->db->from('marksheet_template');
        $templateQuery = $this->db->get();
            
        $templates = $templateQuery->result();
        
        }
        
        return $templates;
        
    } else {
        return ''; // Return an empty string if no exam details are found
    }
}



}
