<?php if (empty($student_id)): ?>

	<div class="row">

		<?php

		$sessionID = get_session_id();

		$this->db->select('s.id,s.first_name,s.last_name,s.photo,s.register_no,s.birthday,e.class_id,e.id as enroll_id,e.roll,e.session_id,c.name as class_name');

		$this->db->from('enroll as e');

		$this->db->join('student as s', 'e.student_id = s.id', 'left');

		$this->db->join('class as c', 'e.class_id = c.id', 'left');


		$this->db->where('s.parent_id', get_loggedin_user_id());

		$this->db->where('e.session_id', $sessionID);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {

			$students = $query->result();

			foreach ($students as $row):

		?>

		<div class="col-md-12 mb-lg">

			<div class="profile-head">

				<div class="col-md-12 col-lg-4 col-xl-3">

					<div class="image-content-center user-pro">

						<div class="preview">

							<img src="<?php echo get_image_url('student', $row->photo);?>">

						</div>

					</div>

				</div>

				<div class="col-md-12 col-lg-5 col-xl-5">

					<h5><?=html_escape($row->first_name . " " . $row->last_name)?></h5>

					<p><?=translate('my_child')?></p>

					<ul>

						<li><div class="icon-holder" data-toggle="tooltip" data-original-title="<?=translate('class')?>"><i class="fas fa-school"></i></div><?=html_escape($row->class_name); ?></li>

						<li><div class="icon-holder" data-toggle="tooltip" data-original-title="<?=translate('roll')?>"><i class="fas fa-award"></i></div><?=html_escape($row->roll)?></li>

						<li><div class="icon-holder" data-toggle="tooltip" data-original-title="<?=translate('register_no')?>"><i class="far fa-registered"></i></div><?=html_escape($row->register_no)?></li>

						<li><div class="icon-holder" data-toggle="tooltip" data-original-title="<?=translate('birthday')?>"><i class="fas fa-birthday-cake"></i></div><?=_d($row->birthday)?></li>

					</ul>

				</div>

				<div class="col-md-12 col-lg-3 col-xl-4">

					<a href="<?=base_url('parents/select_child/' . $row->enroll_id);?>" class="chil-shaw btn btn-primary btn-circle pull-right"><i class="fas fa-tachometer-alt"></i> <?=translate('dashboard')?></a>

				</div>

			</div>

		</div>

		<?php endforeach; } else { ?>

			<div class="alert alert-subl text-center">

				<strong><i class="fas fa-exclamation-triangle"></i> <?=translate('no_child_was_found')?></strong>

			</div>

		<?php } ?>

	</div>

<?php

else :

    $book_issued = $this->dashboard_model->getMonthlyBookIssued($student_id);

    $get_monthly_payment = $this->dashboard_model->getMonthlyPayment($student_id);

    $fees_summary = $this->dashboard_model->annualFeessummaryCharts($school_id, $student_id);

    $get_student_attendance = $this->dashboard_model->getStudentAttendance($student_id);

    $get_monthly_attachments = $this->dashboard_model->get_monthly_attachments($student_id);

?>



<div class="dashboard-page">

	<div class="card-container">
	<a href="<?php echo site_url(); ?>userrole/report_card">
    <div class="card ">
        <div class="card-content">
		
            <!-- <span class="patient-count">0</span> -->
            <span class="patient-text">Check Result</span>
        </div>
        <div class="card-icon c1">
		<svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
		<style type="text/css">
			.st0{fill:#fff;}
		</style>
		<g>
			<path class="st0" d="M176.276,409.035c50.06,0,84.474-6.492,85-12.75c2.172-26.112-31.707-39.741-45.362-44.844
				c-1.422-0.535-2.965-1.276-4.544-2.13l-26.25,36.31l-1.871-23.784h-13.957l-1.87,23.784l-26.259-36.31
				c-1.62,0.906-3.189,1.647-4.535,2.13c-13.758,4.836-47.534,18.759-45.37,44.844C91.793,402.543,126.207,409.035,176.276,409.035z"></path>
			<path class="st0" d="M145.259,297.578c1.923,10.828,5.121,20.396,9.354,25.095c0,5.646,0,9.767,0,13.06
				c0,0.328-0.061,0.672-0.155,1.034l14.836,7.138v10.483h13.957v-10.474l14.828-7.138c-0.095-0.353-0.155-0.715-0.155-1.042
				c0-3.294,0-7.414,0-13.06c4.233-4.699,7.449-14.267,9.362-25.095c4.456-1.586,7.008-4.138,10.181-15.285
				c3.388-11.87-5.086-11.474-5.086-11.474c6.862-22.706-2.182-44.034-17.293-42.465c-10.431-18.259-45.37,4.164-56.319,2.603
				c0,6.241,2.604,10.957,2.604,10.957c-3.811,7.224-2.337,21.62-1.268,28.905c-0.63,0-8.294,0.078-5.034,11.474
				C138.25,293.439,140.793,295.992,145.259,297.578z"></path>
			<path class="st0" d="M317.793,61.353c0-24.336-19.802-44.138-44.138-44.138h-35.31c-24.336,0-44.138,19.802-44.138,44.138v79.448
				h123.586V61.353z M282.483,79.009c0,4.88-3.949,8.828-8.828,8.828h-35.31c-4.879,0-8.828-3.948-8.828-8.828V61.353
				c0-4.879,3.949-8.828,8.828-8.828h35.31c4.879,0,8.828,3.949,8.828,8.828V79.009z"></path>
			<path class="st0" d="M461.948,124.026h-126.5v16.776c0,9.707-7.948,17.655-17.655,17.655H194.207
				c-9.707,0-17.655-7.948-17.655-17.655v-16.776h-126.5C22.422,124.026,0,146.449,0,174.078v270.655
				c0,27.63,22.422,50.052,50.052,50.052h411.897c27.63,0,50.052-22.422,50.052-50.052V174.078
				C512,146.449,489.578,124.026,461.948,124.026z M459.034,454.181H52.966V189.353h406.069V454.181z"></path>
			<rect x="294.992" y="265.862" class="st0" width="111.819" height="26.483"></rect>
			<rect x="294.992" y="342.38" class="st0" width="76.508" height="26.483"></rect>
		</g>
		</svg> 
        </div>
    </div>
    </a>
    <!-- Repeat the card structure for additional cards -->
    <a href="<?php echo site_url(); ?>userrole/online_exam">
    <div class="card">
        <div class="card-content">
		
            <!-- <span class="patient-count">0</span> -->
            <span class="patient-text">Online Exams</span>
        </div>
        <div class="card-icon c2">

		<svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5 8a1 1 0 0 1-2 0V5.923c0-.76.082-1.185.319-1.627.223-.419.558-.754.977-.977C4.738 3.082 5.162 3 5.923 3H8a1 1 0 0 1 0 2H5.923c-.459 0-.57.022-.684.082a.364.364 0 0 0-.157.157c-.06.113-.082.225-.082.684V8zm3 11a1 1 0 1 1 0 2H5.923c-.76 0-1.185-.082-1.627-.319a2.363 2.363 0 0 1-.977-.977C3.082 19.262 3 18.838 3 18.077V16a1 1 0 1 1 2 0v2.077c0 .459.022.57.082.684.038.07.087.12.157.157.113.06.225.082.684.082H8zm7-15a1 1 0 0 0 1 1h2.077c.459 0 .57.022.684.082.07.038.12.087.157.157.06.113.082.225.082.684V8a1 1 0 1 0 2 0V5.923c0-.76-.082-1.185-.319-1.627a2.363 2.363 0 0 0-.977-.977C19.262 3.082 18.838 3 18.077 3H16a1 1 0 0 0-1 1zm4 12a1 1 0 1 1 2 0v2.077c0 .76-.082 1.185-.319 1.627a2.364 2.364 0 0 1-.977.977c-.442.237-.866.319-1.627.319H16a1 1 0 1 1 0-2h2.077c.459 0 .57-.022.684-.082a.363.363 0 0 0 .157-.157c.06-.113.082-.225.082-.684V16zM3 11a1 1 0 1 0 0 2h18a1 1 0 1 0 0-2H3z" fill="#fff"></path></svg>

	</div>
    	</div>
    </a>
    <a href="<?php echo site_url(); ?>userrole/homework">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
            <span class="patient-text">Home Work</span>
        </div>
        <div class="card-icon c3">
		<svg fill="#fff" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="256px" height="240px" viewBox="0 0 256 240" enable-background="new 0 0 256 240" xml:space="preserve">
<path d="M84.635,20.256c18.383,0,33.286,14.903,33.286,33.286s-14.903,33.286-33.286,33.286S51.349,71.925,51.349,53.542
S66.251,20.256,84.635,20.256z M31.002,145.011c0-2.499,1.606-4.194,4.194-4.194s4.194,1.606,4.194,4.194v92.986h91.469v-92.986
c0-2.499,1.606-4.194,4.194-4.194c2.499,0,4.194,1.606,4.194,4.194v92.986h29.092V136.623c0-22.934-18.74-41.585-41.585-41.585
h-8.388l-24.451,38.015l-2.945-28.467l4.016-9.638H76.96l4.016,9.638l-3.123,28.645L53.401,95.038h-9.816
C20.651,95.038,2,113.778,2,136.623v101.375h29.092v-92.986H31.002z M224.674,82.529c-4.562-1.862-6.61-2.793-6.61-4.934
c0-1.862,1.583-3.445,5.12-3.445c3.445,0,6.051,0.931,7.355,1.583l1.769-6.424c-1.676-0.652-3.631-1.303-6.331-1.583v-5.213h-9.123
v6.051c-4.562,1.583-7.262,5.213-7.262,9.682c0,5.12,3.724,8.379,9.775,10.52c4.282,1.49,5.865,2.793,5.865,4.934
c0,2.327-1.955,3.724-5.586,3.724c-3.445,0-6.703-1.21-8.844-2.141l-1.583,6.61c1.583,0.931,4.469,1.676,7.541,1.955v5.12h9.124
v-5.958c5.12-1.862,7.541-5.586,7.541-10.054C233.798,87.928,230.912,84.763,224.674,82.529z M201.68,34.77h39.473v6.61H201.68
V34.77z M201.68,21.643h39.473v6.61H201.68V21.643z M254,19.688c-0.186-9.403-7.634-16.851-16.757-17.502
c-0.279,0-0.745-0.093-1.024-0.093c0,0-58.186-0.093-58.465-0.093c-3.724,0-7.262,1.117-10.054,3.072
c-2.421,1.676-4.469,3.91-5.772,6.61c-1.303,2.421-2.048,5.213-2.048,8.193c0,0.093,0,0.186,0,0.279c0,0.093,0,0.093,0,0.186
c0,9.775,7.913,17.781,17.781,17.781c4.282,0,8.193-1.583,11.265-4.096v6.237v30.536v6.61v22.995v19.737H254V21.643
C254,20.992,254,20.247,254,19.688z M247.483,21.643v12.103v79.784h-52.041c0,0,0.093-93.097,0.093-93.562
c0-4.189-1.583-8.193-4.096-11.265h45.059c6.237,1.117,10.892,6.517,10.892,12.94H247.483z M201.68,47.897h39.473v6.61H201.68
V47.897z"></path>
</svg>


        </div>
    </div>
    </a>
    <a href="<?php echo site_url(); ?>userrole/invoice">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
            <span class="patient-text">Fees Pay / Invoice</span>
        </div>
        <div class="card-icon c4">
		<svg fill="#fff" height="800px" width="800px" version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve">
		<g>
			<path d="M16,6.1V5c0-1.7-1.3-3-3-3H3C2.4,2,2,2.4,2,3s0.4,1,1,1c0.6,0,1,0.4,1,1v1.1c-1.7,0.4-3,2-3,3.9v16c0,2.2,1.8,4,4,4h10
				c2.2,0,4-1.8,4-4V10C19,8.1,17.7,6.6,16,6.1z M13,26H7c-0.6,0-1-0.4-1-1s0.4-1,1-1h6c0.6,0,1,0.4,1,1S13.6,26,13,26z M14,16H6V5
				c0-0.4-0.1-0.7-0.2-1H13c0.6,0,1,0.4,1,1V16z"></path>
			<path d="M9.5,11h1c0.3,0,0.5,0.2,0.5,0.5S10.8,12,10.5,12H9c-0.6,0-1,0.4-1,1s0.4,1,1,1c0,0.6,0.4,1,1,1s1-0.4,1-1v-0.1
				c1.1-0.2,2-1.2,2-2.4c0-1.4-1.1-2.5-2.5-2.5h-1C9.2,9,9,8.8,9,8.5S9.2,8,9.5,8H11c0.6,0,1-0.4,1-1s-0.4-1-1-1c0-0.6-0.4-1-1-1
				S9,5.4,9,6v0.1C7.9,6.3,7,7.3,7,8.5C7,9.9,8.1,11,9.5,11z"></path>
		</g>
		<g>
			<path d="M28,9h-7v4h10v-1C31,10.3,29.7,9,28,9z"></path>
			<path d="M21,25h7c1.7,0,3-1.3,3-3v-7H21V25z M23,19c0-0.6,0.4-1,1-1h3c0.6,0,1,0.4,1,1v2c0,0.6-0.4,1-1,1h-3c-0.6,0-1-0.4-1-1V19z"></path>
		</g>
		</svg>
        </div>
    </div>
    </a>
    <!--new items -->
    <?php $showNew1 = true; $showNew2 = true; 
    if($showNew1 == true){
    ?>
    <a href="<?php echo site_url(); ?>userrole/live_class">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
            <span class="patient-text">Live Class Rooms</span>
        </div>
        <div class="card-icon c1" >
		    <svg viewBox="0 0 192 192" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path stroke="#fff" stroke-linejoin="round" stroke-width="12" d="M22 126V42a4 4 0 0 1 4-4h140a4 4 0 0 1 4 4v84a4 4 0 0 1-4 4H26a4 4 0 0 1-4-4Z"></path><path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="12" d="M52 154h88"></path><path stroke="#FFF" stroke-linejoin="round" stroke-width="12" d="M118 84 82 62v44l36-22Z"></path></g></svg>
        </div>
    </div>
    </a>
    <a href="<?php echo site_url(); ?>userrole/attachments">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
            <span class="patient-text">Notes</span>
        </div>
        <div class="card-icon c2">
		<svg fill="#FFFFFF" height="800px" width="800px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve">
    <g>
        <path d="M4,4v24h24V8l-8-8H4z M20,4.4L25.6,10H20V4.4z M26,26H6V6h12v8h8V26z"></path>
        <path d="M10,12h12v2H10V12z"></path>
        <path d="M10,16h12v2H10V16z"></path>
        <path d="M10,20h8v2h-8V20z"></path>
    </g>
</svg>

        </div>
    </div>
    </a>
    <a href="<?php echo site_url(); ?>userrole/leave_request">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
            <span class="patient-text">Leave application</span>
        </div>
        <div class="card-icon c3">
            <svg viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="layer1"> <path d="M 6 1 L 6 4 L 7 4 L 7 2 L 18 2 L 18 13 L 16 13 L 16 14 L 19 14 L 19 1 L 6 1 z M 1 6 L 1 19 L 14 19 L 14 6 L 1 6 z M 2 7 L 13 7 L 13 18 L 2 18 L 2 7 z M 7 9 L 7 12 L 4 12 L 4 13 L 7 13 L 7 16 L 8 16 L 8 13 L 11 13 L 11 12 L 8 12 L 8 9 L 7 9 z " style="fill:#ffffff; fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
        </div>
    </div>
    </a>
    <a href="<?php echo site_url(); ?>communication/mailbox/inbox">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
            <span class="patient-text">Messages</span>
        </div>
        <div class="card-icon c4">
		<svg fill="#FFFFFF" height="800px" width="800px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve">
            <g class="text-white">
                <path d="M2,4v24l6-6h20V4H2z M26,20H7.8L4,23.8V6h22V20z"></path>
            </g>
        </svg>
        </div>
    </div>
    </a>
    <?php }; ?>
</div>


    <?php if($showNew2 == true){ ?>
    <div class="owl-carousel owl-theme" style="margin-bottom: 40px">
        <a href="<?php echo site_url(); ?>userrole/book">
        <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Library Books List</span>
        </div>
        <div class="card-icon c1">
		    <svg fill="#ffffff" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <path d="M136.533,315.733h256v-102.4h-256V315.733z M187.733,256h162.133c4.71,0,8.533,3.814,8.533,8.533 s-3.823,8.533-8.533,8.533H187.733c-4.71,0-8.533-3.814-8.533-8.533S183.023,256,187.733,256z"></path> <rect x="85.333" y="213.333" width="34.133" height="102.4"></rect> <rect x="409.6" y="213.333" width="17.067" height="102.4"></rect> <path d="M443.733,315.733H486.4c4.719,0,8.533-3.814,8.533-8.533v-85.333c0-4.719-3.814-8.533-8.533-8.533h-42.667V315.733z"></path> <path d="M8.533,315.733h59.733v-102.4H8.533c-4.71,0-8.533,3.814-8.533,8.533V307.2C0,311.919,3.823,315.733,8.533,315.733z"></path> <path d="M25.6,110.933h17.067v76.8c0,4.719,3.823,8.533,8.533,8.533h51.2h34.133H460.8c4.719,0,8.533-3.814,8.533-8.533V102.4 c0-4.719-3.814-8.533-8.533-8.533h-8.533V34.133c0-4.719-3.814-8.533-8.533-8.533h-42.667v68.267H384V25.6h-17.067v68.267 h-17.067V25.6H153.6v68.267h-17.067V25.6H102.4v68.267H85.333V25.6H25.6c-4.71,0-8.533,3.814-8.533,8.533V102.4 C17.067,107.119,20.89,110.933,25.6,110.933z M204.8,59.733h102.4c4.71,0,8.533,3.814,8.533,8.533S311.91,76.8,307.2,76.8H204.8 c-4.71,0-8.533-3.814-8.533-8.533S200.09,59.733,204.8,59.733z M145.067,110.933H358.4h34.133h51.2h8.533V179.2h-307.2V110.933z"></path> <path d="M426.667,136.533H187.733c-4.71,0-8.533,3.814-8.533,8.533s3.823,8.533,8.533,8.533h238.933 c4.719,0,8.533-3.814,8.533-8.533S431.386,136.533,426.667,136.533z"></path> <path d="M503.467,469.333h-11.964c-2.927-5.513-5.385-11.23-7.475-17.067H349.867c-4.71,0-8.533-3.814-8.533-8.533 s3.823-8.533,8.533-8.533h129.348c-1.169-5.615-1.988-11.307-2.381-17.033h-49.587c-0.128,0-0.239-0.068-0.375-0.077 c-0.068,0-0.128,0.043-0.205,0.043H179.2c-4.71,0-8.533-3.814-8.533-8.533c0-4.719,3.823-8.533,8.533-8.533h247.467 c0.137,0,0.247,0.068,0.375,0.077c0.068,0,0.137-0.043,0.205-0.043h49.579c0.393-5.751,1.22-11.46,2.389-17.101H307.2 c-4.71,0-8.533-3.814-8.533-8.533s3.823-8.533,8.533-8.533h176.828c2.091-5.837,4.548-11.554,7.475-17.067h11.964 c4.719,0,8.533-3.814,8.533-8.533c0-4.719-3.814-8.533-8.533-8.533H486.4h-59.733H76.8C34.458,332.8,0,367.249,0,409.6 c0,42.351,34.458,76.8,76.8,76.8h349.867H486.4h17.067c4.719,0,8.533-3.814,8.533-8.533 C512,473.148,508.186,469.333,503.467,469.333z M187.733,452.267H76.8c-23.526,0-42.667-19.14-42.667-42.667 c0-23.526,19.14-42.667,42.667-42.667h196.267c4.71,0,8.533,3.814,8.533,8.533S277.777,384,273.067,384H76.8 c-14.114,0-25.6,11.486-25.6,25.6c0,14.114,11.486,25.6,25.6,25.6h110.933c4.71,0,8.533,3.814,8.533,8.533 S192.444,452.267,187.733,452.267z M145.067,409.6c0,4.719-3.823,8.533-8.533,8.533h-51.2c-4.71,0-8.533-3.814-8.533-8.533 c0-4.719,3.823-8.533,8.533-8.533h51.2C141.244,401.067,145.067,404.881,145.067,409.6z M307.2,452.267h-76.8 c-4.71,0-8.533-3.814-8.533-8.533s3.823-8.533,8.533-8.533h76.8c4.71,0,8.533,3.814,8.533,8.533S311.91,452.267,307.2,452.267z"></path> </g> </g> </g> </g></svg>
        </div>
    </div>
        </a>
        <a href="<?php echo site_url(); ?>userrole/book_request">
        <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
            <span class="patient-text">Library Issued Book</span>
        </div>
        <div class="card-icon c2">
		    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 19V6.2C5 5.0799 5 4.51984 5.21799 4.09202C5.40973 3.71569 5.71569 3.40973 6.09202 3.21799C6.51984 3 7.0799 3 8.2 3H15.8C16.9201 3 17.4802 3 17.908 3.21799C18.2843 3.40973 18.5903 3.71569 18.782 4.09202C19 4.51984 19 5.0799 19 6.2V17H7C5.89543 17 5 17.8954 5 19ZM5 19C5 20.1046 5.89543 21 7 21H19M18 17V21M10 6V10M14 10V14M8 8H12M12 12H16" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
        </div>
    </div>
        </a>
        <a href="<?php echo site_url(); ?>userrole/event">
        <div class="card">
            <div class="card-content">
                <!-- <span class="patient-count">0</span> -->
    			
                <span class="patient-text">Events</span>
            </div>
            <div class="card-icon c3">
    		    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M0 0h24v24H0z" fill="none"></path><path d="M16.53 11.06L15.47 10l-4.88 4.88-2.12-2.12-1.06 1.06L10.59 17l5.94-5.94zM19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"></path></g></svg>
            </div>
        </div>
        </a>
        <a href="<?php echo site_url(); ?>userrole/invoice">
        <div class="card">
            <div class="card-content">
                <!-- <span class="patient-count">0</span> -->
    			
                <span class="patient-text">Fees History</span>
    			
            </div>
            <div class="card-icon c4">
    		    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.55281 1.60553C7.10941 1.32725 7.77344 1 9 1C10.2265 1 10.8906 1.32722 11.4472 1.6055L11.4631 1.61347C11.8987 1.83131 12.2359 1.99991 13 1.99993C14.2371 1.99998 14.9698 1.53871 15.2141 1.35512C15.5944 1.06932 16.0437 1.09342 16.3539 1.2369C16.6681 1.38223 17 1.72899 17 2.24148L17 13H20C21.6562 13 23 14.3415 23 15.999V19C23 19.925 22.7659 20.6852 22.3633 21.2891C21.9649 21.8867 21.4408 22.2726 20.9472 22.5194C20.4575 22.7643 19.9799 22.8817 19.6331 22.9395C19.4249 22.9742 19.2116 23.0004 19 23H5C4.07502 23 3.3148 22.7659 2.71092 22.3633C2.11331 21.9649 1.72739 21.4408 1.48057 20.9472C1.23572 20.4575 1.11827 19.9799 1.06048 19.6332C1.03119 19.4574 1.01616 19.3088 1.0084 19.2002C1.00194 19.1097 1.00003 19.0561 1 19V2.24146C1 1.72899 1.33184 1.38223 1.64606 1.2369C1.95628 1.09341 2.40561 1.06931 2.78589 1.35509C3.03019 1.53868 3.76289 1.99993 5 1.99993C5.76415 1.99993 6.10128 1.83134 6.53688 1.6135L6.55281 1.60553ZM3.00332 19L3 3.68371C3.54018 3.86577 4.20732 3.99993 5 3.99993C6.22656 3.99993 6.89059 3.67269 7.44719 3.39441L7.46312 3.38644C7.89872 3.1686 8.23585 3 9 3C9.76417 3 10.1013 3.16859 10.5369 3.38643L10.5528 3.39439C11.1094 3.67266 11.7734 3.9999 13 3.99993C13.7927 3.99996 14.4598 3.86581 15 3.68373V19C15 19.783 15.1678 20.448 15.4635 21H5C4.42498 21 4.0602 20.8591 3.82033 20.6992C3.57419 20.5351 3.39761 20.3092 3.26943 20.0528C3.13928 19.7925 3.06923 19.5201 3.03327 19.3044C3.01637 19.2029 3.00612 19.1024 3.00332 19ZM19.3044 20.9667C19.5201 20.9308 19.7925 20.8607 20.0528 20.7306C20.3092 20.6024 20.5351 20.4258 20.6992 20.1797C20.8591 19.9398 21 19.575 21 19V15.999C21 15.4474 20.5529 15 20 15H17L17 19C17 19.575 17.1409 19.9398 17.3008 20.1797C17.4649 20.4258 17.6908 20.6024 17.9472 20.7306C18.2075 20.8607 18.4799 20.9308 18.6957 20.9667C18.8012 20.9843 18.8869 20.9927 18.9423 20.9967C19.0629 21.0053 19.1857 20.9865 19.3044 20.9667Z" fill="#ffffff"></path> <path d="M5 8C5 7.44772 5.44772 7 6 7H12C12.5523 7 13 7.44772 13 8C13 8.55229 12.5523 9 12 9H6C5.44772 9 5 8.55229 5 8Z" fill="#ffffff"></path> <path d="M5 12C5 11.4477 5.44772 11 6 11H12C12.5523 11 13 11.4477 13 12C13 12.5523 12.5523 13 12 13H6C5.44772 13 5 12.5523 5 12Z" fill="#ffffff"></path> <path d="M5 16C5 15.4477 5.44772 15 6 15H12C12.5523 15 13 15.4477 13 16C13 16.5523 12.5523 17 12 17H6C5.44772 17 5 16.5523 5 16Z" fill="#ffffff"></path> </g></svg>
            </div>
        </div></a>
        <a href="<?php echo site_url(); ?>userrole/attendance">
        <div class="card">
            <div class="card-content">
                <!-- <span class="patient-count">0</span> -->
    			
                <span class="patient-text">Attendance</span>
    			
            </div>
            <div class="card-icon c1">
    		    <svg viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill="#ffffff" fill-rule="evenodd" d="M6.9 0h.2A2.9 2.9 0 0 1 10 2.9v1.2A2.9 2.9 0 0 1 7.1 7h-.2A2.9 2.9 0 0 1 4 4.1V2.9A2.9 2.9 0 0 1 6.9 0z M14.81 4.58l-4.15 5.82c.226.503.341 1.049.34 1.6v4.67A1.336 1.336 0 0 1 9.67 18l-5.34-.01A1.327 1.327 0 0 1 3 16.67V12a4.012 4.012 0 0 1 4-4 3.9 3.9 0 0 1 2.36.79l3.83-5.37a1 1 0 0 1 1.62 1.16z"></path> </g></svg>
            </div>
        </div>
        </a>
        <a href="<?php echo site_url(); ?>userrole/teacher">
        <div class="card">
            <div class="card-content">
                <!-- <span class="patient-count">0</span> -->
    			
                <span class="patient-text">Teachers</span>
    			
            </div>
            <div class="card-icon c2">
    		    <svg fill="#ffffff" viewBox="0 0 64 64" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/" xmlns:xlink="http://www.w3.org/1999/xlink" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="ICON"> <path d="M60,3.5l-56,-0c-0.552,0 -1,0.448 -1,1c0,0.552 0.448,1 1,1l2.171,-0c-0.111,0.313 -0.171,0.649 -0.171,1l-0,10.176c-0,0.552 0.448,1 1,1c0.552,0 1,-0.448 1,-1l0,-6.676l44,-0c0.552,0 1,-0.448 1,-1c0,-0.552 -0.448,-1 -1,-1l-44,-0l0,-1.5c0,-0.552 0.448,-1 1,-1l46,-0c0.552,-0 1,0.448 1,1c0,0 -0,30.5 -0,30.5c-0,0.552 -0.448,1 -1,1l-23,-0l-0,-10.25c-0,-6.075 -4.925,-11 -11,-11c-0.665,0 -1.335,0 -2,0c-6.075,0 -11,4.925 -11,11l0,17.542c-1.104,0.329 -2.12,0.929 -2.95,1.758c-1.313,1.313 -2.05,3.093 -2.05,4.95c0,3.799 0,8 0,8c0,0.552 0.448,1 1,1l32,-0c0.552,-0 1,-0.448 1,-1l-0,-8c0,-1.857 -0.737,-3.637 -2.05,-4.95c-0.83,-0.829 -1.846,-1.429 -2.95,-1.758l-0,-5.292l23,0c1.657,-0 3,-1.343 3,-3l0,-30.5c-0,-0.351 -0.06,-0.687 -0.171,-1l2.171,-0c0.552,0 1,-0.448 1,-1c0,-0.552 -0.448,-1 -1,-1Zm-30,43.5l-4.083,0c-0.477,2.836 -2.946,5 -5.917,5c-2.971,-0 -5.44,-2.164 -5.917,-5l-4.083,0c-1.326,-0 -2.598,0.527 -3.536,1.464c-0.937,0.938 -1.464,2.21 -1.464,3.536c0,0 0,7 0,7l4,-0l0,-4c0,-0.552 0.448,-1 1,-1c0.552,0 1,0.448 1,1l0,4l18,-0l0,-4c0,-0.552 0.448,-1 1,-1c0.552,0 1,0.448 1,1l0,4l4,-0l0,-7c0,-1.326 -0.527,-2.598 -1.464,-3.536c-0.938,-0.937 -2.21,-1.464 -3.536,-1.464Zm-6.126,0l-7.748,0c0.445,1.724 2.012,3 3.874,3c1.862,-0 3.429,-1.276 3.874,-3Zm6.126,-2l-20,-0c0,0 0,-17.25 0,-17.25c0,-4.971 4.029,-9 9,-9c0.665,0 1.335,0 2,0c4.971,0 9,4.029 9,9l0,17.25Zm-2,-17c-0,-0.552 -0.448,-1 -1,-1l-6.382,0c0,-0 -1.724,-3.447 -1.724,-3.447c-0.169,-0.339 -0.515,-0.553 -0.894,-0.553c-0.379,-0 -0.725,0.214 -0.894,0.553l-1.724,3.447c-0,0 -2.382,0 -2.382,0c-0.552,0 -1,0.448 -1,1l0,10c0,2.761 2.239,5 5,5c1.881,0 4.119,0 6,0c2.761,-0 5,-2.239 5,-5c-0,-4.138 -0,-10 -0,-10Zm-2,1l-0,9c-0,1.657 -1.343,3 -3,3c-0,-0 -6,0 -6,0c-1.657,-0 -3,-1.343 -3,-3c0,-0 0,-9 0,-9c-0,0 2,0 2,0c0.379,-0 0.725,-0.214 0.894,-0.553l1.106,-2.211c0,0 1.106,2.211 1.106,2.211c0.169,0.339 0.515,0.553 0.894,0.553l6,-0Zm14.5,6l11.5,0c0.552,-0 1,-0.448 1,-1c-0,-0.552 -0.448,-1 -1,-1l-11.5,0c-0.552,-0 -1,0.448 -1,1c-0,0.552 0.448,1 1,1Zm-3.5,-5l15,0c0.552,0 1,-0.448 1,-1c0,-0.552 -0.448,-1 -1,-1l-15,0c-0.552,0 -1,0.448 -1,1c0,0.552 0.448,1 1,1Zm-0,-5l15,0c0.552,-0 1,-0.448 1,-1c-0,-0.552 -0.448,-1 -1,-1l-15,0c-0.552,-0 -1,0.448 -1,1c-0,0.552 0.448,1 1,1Zm0,-5l15,0c0.552,0 1,-0.448 1,-1c0,-0.552 -0.448,-1 -1,-1l-15,0c-0.552,0 -1,0.448 -1,1c0,0.552 0.448,1 1,1Zm-7,-5l22,0c0.552,-0 1,-0.448 1,-1c-0,-0.552 -0.448,-1 -1,-1l-22,0c-0.552,-0 -1,0.448 -1,1c-0,0.552 0.448,1 1,1Z"></path> </g> </g></svg>
            </div>
        </div>
        </a>
        <a href="<?php echo site_url(); ?>userrole/subject">
        <div class="card">
            <div class="card-content">
                <!-- <span class="patient-count">0</span> -->
    			
                <span class="patient-text">Subjects</span>
    			
            </div>
            <div class="card-icon c3">
    		    <svg fill="#ffffff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M13,16H3a1,1,0,0,0,0,2H13a1,1,0,0,0,0-2ZM3,8H21a1,1,0,0,0,0-2H3A1,1,0,0,0,3,8Zm18,3H3a1,1,0,0,0,0,2H21a1,1,0,0,0,0-2Z"></path></g></svg>
            </div>
        </div>
        </a>
        <a href="<?php echo site_url(); ?>userrole/class_schedule">
        <div class="card">
            <div class="card-content">
                <!-- <span class="patient-count">0</span> -->
    			
                <span class="patient-text">Class Schedule</span>
    			
            </div>
            <div class="card-icon c4">
    		    <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#ffffff;} </style> <g> <rect x="119.256" y="222.607" class="st0" width="50.881" height="50.885"></rect> <rect x="341.863" y="222.607" class="st0" width="50.881" height="50.885"></rect> <rect x="267.662" y="222.607" class="st0" width="50.881" height="50.885"></rect> <rect x="119.256" y="302.11" class="st0" width="50.881" height="50.885"></rect> <rect x="267.662" y="302.11" class="st0" width="50.881" height="50.885"></rect> <rect x="193.46" y="302.11" class="st0" width="50.881" height="50.885"></rect> <rect x="341.863" y="381.612" class="st0" width="50.881" height="50.885"></rect> <rect x="267.662" y="381.612" class="st0" width="50.881" height="50.885"></rect> <rect x="193.46" y="381.612" class="st0" width="50.881" height="50.885"></rect> <path class="st0" d="M439.277,55.046h-41.376v39.67c0,14.802-12.195,26.84-27.183,26.84h-54.025 c-14.988,0-27.182-12.038-27.182-26.84v-39.67h-67.094v39.297c0,15.008-12.329,27.213-27.484,27.213h-53.424 c-15.155,0-27.484-12.205-27.484-27.213V55.046H72.649c-26.906,0-48.796,21.692-48.796,48.354v360.246 c0,26.661,21.89,48.354,48.796,48.354h366.628c26.947,0,48.87-21.692,48.87-48.354V103.4 C488.147,76.739,466.224,55.046,439.277,55.046z M453.167,462.707c0,8.56-5.751,14.309-14.311,14.309H73.144 c-8.56,0-14.311-5.749-14.311-14.309V178.089h394.334V462.707z"></path> <path class="st0" d="M141.525,102.507h53.392c4.521,0,8.199-3.653,8.199-8.144v-73.87c0-11.3-9.27-20.493-20.666-20.493h-28.459 c-11.395,0-20.668,9.192-20.668,20.493v73.87C133.324,98.854,137.002,102.507,141.525,102.507z"></path> <path class="st0" d="M316.693,102.507h54.025c4.348,0,7.884-3.513,7.884-7.826V20.178C378.602,9.053,369.474,0,358.251,0H329.16 c-11.221,0-20.349,9.053-20.349,20.178v74.503C308.81,98.994,312.347,102.507,316.693,102.507z"></path> </g> </g></svg>
            </div>
        </div>
        </a>
        <a href="<?php echo site_url(); ?>userrole/exam_schedule">
        <div class="card">
            <div class="card-content">
                <!-- <span class="patient-count">0</span> -->
    			
                <span class="patient-text">Exam Schedule</span>
    			
            </div>
            <div class="card-icon c1">
    		<svg fill="#fff" height="800px" width="800px" version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve">
    		    <g>
                    <path d="M4,4v24h24V4H4z M26,26H6V6h20V26z"></path>
                    <path d="M10,10h12v2H10V10z"></path>
                    <path d="M10,14h8v2h-8V14z"></path>
                    <path d="M10,18h4v2h-4V18z"></path>
                </g>
    		</svg>
            </div>
        </div>
        </a>
        <a href="<?php echo site_url(); ?>userrole/hostels">
        <div class="card">
            <div class="card-content">
                <!-- <span class="patient-count">0</span> -->
    			
                <span class="patient-text">Hostel</span>
    			
            </div>
            <div class="card-icon c2">
    		<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA40lEQVR4nO3UMUpDQRCH8bVJYywsrBQrz2AhSaWFFl7BO1iqF/AKtl5BT5DOM5gUib2tYOFPHrzGp5jNMILK+2Bhd2HnY/4LU0rPbwUDnGPWrmY/+GnpKR59Zo4zrGUL9zGxnAeMM4S7uMWb1bjDXkS4iWu8iPOKG2zVSo/wLI+m1mGNeNp5eIF1XLbne2wvqTHq1JjWiLsM2/uN9rxTmdwHSkDcdDrEVVWBRHEKJSA+qO3ymz8WEY8C4nGGOIXSi7t8kVLGABER9wMkRAlE/f8HyJN8FjXik2T5Aserptbz93kHD99ma9CEdisAAAAASUVORK5CYII=" alt="hostel">
            </div>
        </div>
        </a>
        <a href="<?php echo site_url(); ?>userrole/route">
        <div class="card">
            <div class="card-content">
                <!-- <span class="patient-count">0</span> -->
    			
                <span class="patient-text">Transport</span>
    			
            </div>
            <div class="card-icon c4">
    		    <svg viewBox="0 0 48 48" id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;stroke:#ffffff;stroke-linecap:round;stroke-linejoin:round;}</style></defs><rect class="cls-1" x="8.54" y="39.08" width="7.74" height="4.42"></rect><rect class="cls-1" x="31.72" y="39.08" width="7.74" height="4.42"></rect><path class="cls-1" d="M7.29,11h1.2v7.94a2.44,2.44,0,0,1-2.4-2.47V12.22A1.22,1.22,0,0,1,7.29,11Z"></path><path class="cls-1" d="M40.71,11h-1.2v7.94a2.44,2.44,0,0,0,2.4-2.47V12.22A1.22,1.22,0,0,0,40.71,11Z"></path><path class="cls-1" d="M24,4.5c-5.51,0-15.46.86-15.46,3.1V39.08H39.46V7.6C39.46,5.36,29.44,4.5,24,4.5Zm0,4.23q8.19,0,12.2,1.23a1,1,0,0,1,.67.92v17a1,1,0,0,1-1,1H12.14a1,1,0,0,1-1-1v-17a1,1,0,0,1,.67-.92q4-1.23,12.19-1.23ZM13.59,31.5a2.5,2.5,0,0,1,0,5h0A2.47,2.47,0,0,1,11.16,34h0A2.47,2.47,0,0,1,13.59,31.5Zm20.87,0a2.5,2.5,0,0,1,0,5h0A2.47,2.47,0,0,1,32,34h0A2.47,2.47,0,0,1,34.46,31.5Z"></path></g></svg>
            </div>
            </div>
        </div>
        </a>
    <?php }; ?>

	<div class="row">

		<div class="col-md-12 col-lg-12 col-sm-12">

			<div class="panel">

			<div class="panel-body" style="padding-top: 0;padding-bottom: 0;">

				<div class="row widget-row-in">

					<div class="col-lg-3 col-sm-6 widget-row-d-br">

						<div class="widget-col-in row">

							<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-book-reader"></i>

								<h5 class="text-muted"><?=translate('book_issued')?></h5>

							</div>

							<div class="col-md-6 col-sm-6 col-xs-6">

								<h3 class="counter text-right mt-md text-primary">

									<?=$book_issued?>

								</h3>

							</div>

							<div class="col-md-12 col-sm-12 col-xs-12">

								<div class="box-top-line line-color-primary">

									<span class="text-muted text-uppercase"><?=translate('interval_month')?></span>

								</div>

							</div>

						</div>

					</div>

					<div class="col-lg-3 col-sm-6 widget-row-d-br b-r-none">

						<div class="widget-col-in row">

							<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-cloud-download-alt"></i>

								<h5 class="text-muted"><?=translate('attachments')?></h5> </div>

							<div class="col-md-6 col-sm-6 col-xs-6">

								<h3 class="counter text-right text-primary">

									<?=$get_monthly_attachments?>

								</h3>

							</div>

							<div class="col-md-12 col-sm-12 col-xs-12">

								<div class="box-top-line line-color-primary">

										<span class="text-muted text-uppercase"><?=translate('interval_month')?></span>

								</div>

							</div>

						</div>

					</div>

					<div class="col-lg-3 col-sm-6 widget-row-d-br">

						<div class="widget-col-in row">

							<div class="col-md-6 col-sm-6 col-xs-6"> <i class="far fa-money-bill-alt" ></i>

								<h5 class="text-muted"><?=translate('fees_payment')?></h5></div>

							<div class="col-md-6 col-sm-6 col-xs-6">

								<h3 class="counter text-right mt-md text-primary">

									<?=$get_monthly_payment?>

								</h3>

							</div>

							<div class="col-md-12 col-sm-12 col-xs-12">

								<div class="box-top-line line-color-primary">

									<span class="text-muted text-uppercase"><?=translate('interval_month');?></span>

								</div>

							</div>

						</div>

					</div>

					<div class="col-lg-3 col-sm-6">

						<div class="widget-col-in row">

							<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-bullhorn"></i>

								<h5 class="text-muted"><?=translate('events')?></h5>

							</div>

							<div class="col-md-6 col-sm-6 col-xs-6">

								<h3 class="counter text-right mt-md text-primary">

									<?php

										$this->db->from('event');

										$this->db->where('start_date BETWEEN DATE_SUB(CURDATE() ,INTERVAL 1 MONTH) AND CURDATE() AND branch_id = "'. get_loggedin_branch_id() .'"');

								    	echo $this->db->get()->num_rows();				

									?>

								</h3>

							</div>

							<div class="col-md-12 col-sm-12 col-xs-12">

								<div class="box-top-line line-color-primary">

										<span class="text-muted text-uppercase"><?=translate('interval_month') ?></span>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

			</div>

		</div>

	</div>

	<div class="row">

		<!-- annual fees summary of students graph -->

		<div class="col-md-12">

			<section class="panel">

				<div class="panel-body">

					<h4 class="chart-title mb-md"><?=translate('my_annual_fee_summary')?></h4>

					<div class="pg-fw">

						<canvas id="fees_graph" style="height:340px;"></canvas>

					</div>

				</div>

			</section>

		</div>

	</div>

	<!-- annual attendance overview of students -->

	<div class="row">

		<div class="col-md-12">

			<section class="panel">

				<div class="panel-body">

					<h4 class="chart-title mb-md"><?=translate('my_annual_attendance_overview')?></h4>

					<div class="pg-fw">

						<canvas id="attendance_overview" style="height:380px;"></canvas>

					</div>

				</div>

			</section>

		</div>

	</div>



	<div class="row">

	    <!-- event calendar -->

		<div class="col-md-12">

			<section class="panel">

				<div class="panel-body">

					<div id="event_calendar"></div>

				</div>

			</section>

		</div>

	</div>

</div>



<div class="zoom-anim-dialog modal-block modal-block-primary mfp-hide" id="modal">

	<section class="panel">

		<header class="panel-heading">

			<h4 class="panel-title"><i class="fas fa-info-circle"></i> <?=translate('event_details')?></h4>

			<div class="panel-btn">

				<button id="print" class="btn btn-default btn-circle icon"><i class="fas fa-print"></i></button>

			</div>

		</header>

		<div class="panel-body">

			<div id="printResult pt-sm pb-sm">

				<div class="table-responsive">						

					<table class="table table-bordered table-condensed text-dark mb-sm tbr-top" id="ev_table">

						

					</table>

				</div>

			</div>

		</div>

		<footer class="panel-footer">

			<div class="row">

				<div class="col-md-12 text-right">

					<button class="btn btn-default modal-dismiss">

						<?=translate('close')?>

					</button>

				</div>

			</div>

		</footer>

	</section>

</div>

<script type="application/javascript">

	(function($) {

		"use strict";

		

		// event calendar

		$('#event_calendar').fullCalendar({

			header: {

			left: 'prev,next,today',

			center: 'title',

				right: 'month,agendaWeek,agendaDay,listWeek'

			},

			firstDay: 1,

			height: 720,

			droppable: false,

			editable: true,

	        events: {

	            url: "<?=base_url('event/get_events_list');?>"

	        },

			buttonText: {

				today:    'Today',

				month:    'Month',

				week:     'Week',

				day:      'Day',

				list:     'List'

			},

			eventRender: function(event, element) {

				$(element).on("click", function() {

	                view_event(event.id);

	            });

				if(event.icon){          

					element.find(".fc-title").prepend("<i class='fas fa-"+event.icon+"'></i> ");

				}

			}

		});



		// Own Annual Fee Summary JS

		var total_fees = <?php echo json_encode($fees_summary['total_fee']);?>;

		var total_paid = <?php echo json_encode($fees_summary['total_paid']);?>;

		var total_due = <?php echo json_encode($fees_summary['total_due']);?>;

		var ctx = document.getElementById('fees_graph').getContext('2d');

		var fees_graph = new Chart(ctx, {

			type: 'line',

			data: {

				labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

				datasets: [{

					label: '<?php echo translate("total");?>',

					data: total_fees,

					backgroundColor: 'rgba(216, 27, 96, .6)',

					borderColor: '#F5F5F5',

					borderWidth: 1

				},{

					label: '<?php echo translate("collected");?>',

					data: total_paid,

					backgroundColor: 'rgba(0, 136, 204, .6)',

					borderColor: '#F5F5F5',

					borderWidth: 1

				},{

					label: '<?php echo translate("remaining");?>',

					data: total_due,

					backgroundColor: 'rgba(204, 102, 102, .6)',

					borderColor: '#F5F5F5',

					borderWidth: 1

				}]

			},

			options: {

				responsive: true,

				maintainAspectRatio: false,

				circumference: Math.PI,

				tooltips: {

					mode: 'index',

					bodySpacing: 4

				},

				legend: {

					position: 'bottom',

					labels: {

					boxWidth: 12

				}

				},

				scales: {

					xAxes: [{

						scaleLabel: {

						display: false

						}

					}],

					yAxes: [{

						stacked: true,

						scaleLabel: {

							display: false,

						}

					}]

				}

			}

		});



		//annual attendance overview of students

		var total_present = <?php echo json_encode($get_student_attendance['total_present']);?>;

		var total_absent = <?php echo json_encode($get_student_attendance['total_absent']);?>;

		var total_late = <?php echo json_encode($get_student_attendance['total_late']);?>;



		var ctx = document.getElementById('attendance_overview').getContext('2d');

		var attendance_overview = new Chart(ctx, {

			type: 'bar',

			data: {

				labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

				datasets: [{

					label: '<?php echo translate("total_present");?>',

					data: total_present,

					backgroundColor: 'rgba(71, 164, 71, .6)',

					borderColor: '#F5F5F5',

					borderWidth: 1,

					fill: false,

				},{

					label: '<?php echo translate("total_absent");?>',

					data: total_absent,

					backgroundColor: 'rgba(210, 50, 45, .6)',

					borderColor: '#F5F5F5',

					borderWidth: 1,

					fill: false,

				},{

					label: '<?php echo translate("total_late");?>',

					data: total_late,

					backgroundColor: 'rgba(91, 192, 222, .6)',

					borderColor: '#F5F5F5',

					borderWidth: 1,

					fill: false,

				}]

			},

			options: {

				responsive: true,

				maintainAspectRatio: false,

				circumference: Math.PI,

				tooltips: {

					mode: 'index',

					bodySpacing: 4

				},

				legend: {

					position: 'bottom',

					labels: {

					boxWidth: 12

				}

				},

				scales: {

					xAxes: [{

						scaleLabel: {

						display: false

						}

					}],

					yAxes: [{

						scaleLabel: {

							display: false,

						}

					}]

				}

			}

		});

		

		function view_event(id) {

			$.ajax({

				url: "<?=base_url('event/getDetails')?>",

				type: 'POST',

				data: {

					event_id: id

				},

				success: function (data) {

					$('#ev_table').html(data);

					mfp_modal('#modal');

				}

			});

		}

	})(jQuery);

</script>
<script>

$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav: false,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:3,
            nav:false
        },
        1000:{
            items:5,
            nav:true,
            loop:false
        }
    }
})

</script>
<?php endif;?>