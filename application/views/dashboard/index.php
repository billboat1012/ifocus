<?php $roleID = $this->session->userdata('loggedin_role_id'); ?>
<?php

$div = 0;

if (get_permission('employee_count_widget', 'is_view')) {

	$div++;	

}

if (get_permission('student_count_widget', 'is_view')) {

	$div++;	

}

if (get_permission('parent_count_widget', 'is_view')) {

	$div++;	

}

if (get_permission('teacher_count_widget', 'is_view')) {

	$div++;	

}

if ($div == 0) {

	$widget1 = 0;

}else{

	$widget1 = 12 / $div;

}



$div2 = 0;

if (get_permission('admission_count_widget', 'is_view')) {

	$div2++;	

}

if (get_permission('voucher_count_widget', 'is_view')) {

	$div2++;	

}

if (get_permission('transport_count_widget', 'is_view') && moduleIsEnabled('transport')) {

	$div2++;	

}

if (get_permission('hostel_count_widget', 'is_view') && moduleIsEnabled('hostel')) {

	$div2++;	

}

if ($div2 == 0) {

	$widget2 = 0;

}else{

	$widget2 = 12 / $div2;

}



$div3 = 12;

if (get_permission('student_birthday_widget', 'is_view') || get_permission('staff_birthday_widget', 'is_view')) {

	$div3 = 9;	

}

?>

<?php if ($sqlMode == true) { ?>

    <div class="alert alert-danger">

        <i class="fas fa-exclamation-triangle"></i> This School management system may not work properly because "ONLY_FULL_GROUP_BY" is enabled, <strong>Strongly recommended</strong> - consult with your hosting provider to disable "ONLY_FULL_GROUP_BY" in sql_mode configuration.

    </div>

<?php } ?>



<?php 

if (!is_superadmin_loggedin()) {

	if (!empty($this->saas_model->getSubscriptionsExpiredNotification())) { ?>

    <div class="alert alert-danger">

        <?php echo $this->saas_model->getSubscriptionsExpiredNotification(); ?>

    </div>

<?php } } ?>



<div class="dashboard-page">

<div class="card-container">
    <a href="<?php echo site_url(); ?>student/add">
    <div class="card ">
        <div class="card-content">
		
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Admission</span>
			
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
    <a href="<?php echo site_url(); ?>attendance/student_entry">
    <div class="card">
        <div class="card-content">
		
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Attendance</span>
        </div>
        <div class="card-icon c2">

		<svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5 8a1 1 0 0 1-2 0V5.923c0-.76.082-1.185.319-1.627.223-.419.558-.754.977-.977C4.738 3.082 5.162 3 5.923 3H8a1 1 0 0 1 0 2H5.923c-.459 0-.57.022-.684.082a.364.364 0 0 0-.157.157c-.06.113-.082.225-.082.684V8zm3 11a1 1 0 1 1 0 2H5.923c-.76 0-1.185-.082-1.627-.319a2.363 2.363 0 0 1-.977-.977C3.082 19.262 3 18.838 3 18.077V16a1 1 0 1 1 2 0v2.077c0 .459.022.57.082.684.038.07.087.12.157.157.113.06.225.082.684.082H8zm7-15a1 1 0 0 0 1 1h2.077c.459 0 .57.022.684.082.07.038.12.087.157.157.06.113.082.225.082.684V8a1 1 0 1 0 2 0V5.923c0-.76-.082-1.185-.319-1.627a2.363 2.363 0 0 0-.977-.977C19.262 3.082 18.838 3 18.077 3H16a1 1 0 0 0-1 1zm4 12a1 1 0 1 1 2 0v2.077c0 .76-.082 1.185-.319 1.627a2.364 2.364 0 0 1-.977.977c-.442.237-.866.319-1.627.319H16a1 1 0 1 1 0-2h2.077c.459 0 .57-.022.684-.082a.363.363 0 0 0 .157-.157c.06-.113.082-.225.082-.684V16zM3 11a1 1 0 1 0 0 2h18a1 1 0 1 0 0-2H3z" fill="#fff"></path></svg>

	</div>
    	</div>
    </a>
    <?php if($roleID != 3 && $roleID != 11){ ?>
    <a href="<?php echo site_url(); ?>payroll/salary_template">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Payroll</span>
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
    <a href="<?php echo site_url(); ?>fees/invoice_list">
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
    <?php }elseif($roleID == 3 || $roleID == 11){; ?>
    <a href="<?php echo site_url(); ?>student/view">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Student list</span>
        </div>
        <div class="card-icon c1">
            <svg fill="#ffffff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 29.127 29.128" xml:space="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M22.471,15.103c0,1.021,0.824,1.847,1.849,1.847c1.021,0,1.845-0.826,1.845-1.847c0-1.021-0.824-1.847-1.845-1.847 C23.295,13.254,22.471,14.081,22.471,15.103z"></path> <path d="M21.66,20.878c0,1.465,1.19,2.657,2.659,2.657c1.463,0,2.654-1.192,2.654-2.657c0-1.468-1.191-2.659-2.654-2.659 C22.85,18.219,21.66,19.41,21.66,20.878z"></path> <polygon points="27.485,24.576 25.344,23.932 24.364,25.107 23.352,23.932 21.004,24.576 21.004,29.056 27.633,29.056 "></polygon> <path d="M14.808,18.293c-1.467,0-2.659,1.191-2.659,2.658c0,1.465,1.192,2.657,2.659,2.657c1.466,0,2.656-1.192,2.656-2.657 C17.463,19.485,16.272,18.293,14.808,18.293z"></path> <polygon points="15.835,24.006 14.852,25.183 13.842,24.006 11.494,24.65 11.494,29.128 18.124,29.128 17.975,24.65 "></polygon> <circle cx="19.487" cy="17.242" r="1.944"></circle> <path d="M21.91,23.107c-0.347-0.654-0.588-1.364-0.588-2.156c0-0.521,0.141-1.005,0.298-1.474H21.43h-0.473h-0.723l-0.717,0.86 l-0.739-0.86h-0.761h-0.424c0.196,0.455,0.31,0.952,0.31,1.472c0,0.855-0.3,1.638-0.794,2.278h4.803L21.91,23.107z"></path> <circle cx="6.152" cy="10.675" r="3.732"></circle> <polygon points="14.664,12.543 9.908,14.967 7.51,14.967 6.089,16.617 4.711,14.967 1.703,15.612 1.495,22.236 2.775,22.236 2.826,23.264 9.576,23.264 9.903,16.904 15.242,14.289 "></polygon> <path d="M13.141,8.3l-1.498,2.234l0.581-0.046c0.04-0.004,3.914-0.328,6.596-0.923c3.521-0.778,5.616-2.336,5.755-4.273 c0.186-2.635-2.781-4.998-6.612-5.267c-3.83-0.27-7.097,1.654-7.282,4.289C10.575,5.807,11.49,7.281,13.141,8.3z M17.924,0.586 c3.521,0.248,6.254,2.341,6.088,4.667c-0.166,2.373-3.771,3.423-5.312,3.764c-2.027,0.449-4.753,0.743-5.935,0.857l1.178-1.76 L13.68,7.965c-1.622-0.913-2.534-2.265-2.44-3.612C11.406,2.028,14.402,0.339,17.924,0.586z"></path> </g> </g> </g></svg>
        </div>
    </div>
    </a>
    <a href="<?php echo site_url(); ?>homework">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Homework</span>
        </div>
        <div class="card-icon c2">
            <svg fill="#ffffff" height="200px" width="200px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 470 470" xml:space="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M192.465,294.786h-12.5v-25.895c0-4.142-3.357-7.5-7.5-7.5s-7.5,3.358-7.5,7.5v25.895H148.31v-55.895 c0-4.142-3.357-7.5-7.5-7.5s-7.5,3.358-7.5,7.5v55.895h-16.654v-25.895c0-4.142-3.357-7.5-7.5-7.5s-7.5,3.358-7.5,7.5v25.895H85 v-55.895c0-4.142-3.357-7.5-7.5-7.5s-7.5,3.358-7.5,7.5v63.395c0,4.142,3.357,7.5,7.5,7.5h114.965c4.143,0,7.5-3.358,7.5-7.5 S196.607,294.786,192.465,294.786z"></path> <path d="M192.465,53.251H77.5c-4.143,0-7.5,3.358-7.5,7.5s3.357,7.5,7.5,7.5h114.965c4.143,0,7.5-3.358,7.5-7.5 S196.607,53.251,192.465,53.251z"></path> <path d="M192.465,88.879H77.5c-4.143,0-7.5,3.358-7.5,7.5s3.357,7.5,7.5,7.5h114.965c4.143,0,7.5-3.358,7.5-7.5 S196.607,88.879,192.465,88.879z"></path> <path d="M77.5,139.507h57.482c4.143,0,7.5-3.358,7.5-7.5s-3.357-7.5-7.5-7.5H77.5c-4.143,0-7.5,3.358-7.5,7.5 S73.357,139.507,77.5,139.507z"></path> <path d="M192.465,160.135H77.5c-4.143,0-7.5,3.358-7.5,7.5s3.357,7.5,7.5,7.5h114.965c4.143,0,7.5-3.358,7.5-7.5 S196.607,160.135,192.465,160.135z"></path> <path d="M192.465,195.763H77.5c-4.143,0-7.5,3.358-7.5,7.5s3.357,7.5,7.5,7.5h114.965c4.143,0,7.5-3.358,7.5-7.5 S196.607,195.763,192.465,195.763z"></path> <path d="M235,58.675c-4.143,0-7.5,3.358-7.5,7.5v252.848c0,4.142,3.357,7.5,7.5,7.5s7.5-3.358,7.5-7.5V66.175 C242.5,62.032,239.143,58.675,235,58.675z"></path> <path d="M462.5,73.251H440v-52.5c0-4.142-3.357-7.5-7.5-7.5H263.732c-10.816,0-21.035,4.135-28.732,11.373 c-7.698-7.238-17.917-11.373-28.732-11.373H37.5c-4.143,0-7.5,3.358-7.5,7.5v52.5H7.5c-4.143,0-7.5,3.358-7.5,7.5v321.535 c0,4.142,3.357,7.5,7.5,7.5h197.337l8.396,9.793c1.425,1.662,3.505,2.618,5.694,2.618l32.152-0.003c2.189,0,4.27-0.957,5.694-2.62 l8.389-9.789h41.087v27.463c0,10.752,8.748,19.5,19.502,19.5h16c10.751,0,19.498-8.748,19.498-19.5v-27.463H462.5 c4.143,0,7.5-3.358,7.5-7.5V80.751C470,76.609,466.643,73.251,462.5,73.251z M346.25,126.249v252.5h-25v-252.5H346.25z M321.25,393.749h25v15h-25V393.749z M325,111.249l8.751-21l8.749,21H325z M341.752,441.749h-16c-2.44,0-4.502-2.061-4.502-4.5 v-13.5h25v13.5C346.25,439.688,344.19,441.749,341.752,441.749z M455,394.786h-93.75V118.749c0-0.25-0.013-0.499-0.038-0.747 c-0.021-0.207-0.054-0.41-0.091-0.612c-0.007-0.038-0.01-0.077-0.018-0.115c-0.103-0.515-0.258-1.011-0.461-1.483l-19.968-47.927 c-1.164-2.795-3.895-4.616-6.923-4.616c-3.027,0-5.759,1.82-6.923,4.615l-19.974,47.932c-0.201,0.47-0.356,0.964-0.459,1.478 c-0.008,0.042-0.011,0.084-0.019,0.126c-0.036,0.198-0.07,0.398-0.09,0.601c-0.025,0.248-0.038,0.497-0.038,0.747v276.037h-42.518 c-3.839,0-7.414,1.824-9.675,4.907l-6.429,7.502l-25.254,0.002l-6.433-7.503c-2.264-3.084-5.84-4.908-9.675-4.908H15V88.251h15 v254.035c0,4.142,3.357,7.5,7.5,7.5h168.768c8.344,0,16.128,3.834,21.232,10.343v10.42c-6.34-3.718-13.637-5.763-21.232-5.763H37.5 c-4.143,0-7.5,3.358-7.5,7.5s3.357,7.5,7.5,7.5h168.768c9.057,0,17.463,4.51,22.488,12.063c0.165,0.246,0.339,0.473,0.525,0.692 c0.049,0.058,0.102,0.112,0.153,0.168c0.139,0.154,0.282,0.302,0.433,0.444c0.067,0.063,0.134,0.124,0.203,0.184 c0.158,0.138,0.323,0.269,0.492,0.394c0.056,0.041,0.11,0.085,0.167,0.125c0.234,0.163,0.477,0.314,0.73,0.45 c0.248,0.133,0.505,0.248,0.767,0.353c0.062,0.025,0.126,0.046,0.189,0.069c0.205,0.075,0.412,0.142,0.625,0.199 c0.077,0.021,0.155,0.042,0.233,0.06c0.209,0.049,0.421,0.088,0.636,0.12c0.075,0.011,0.149,0.025,0.225,0.034 c0.285,0.033,0.574,0.054,0.868,0.054c0.297,0,0.583-0.021,0.867-0.054c0.079-0.009,0.156-0.024,0.234-0.036 c0.211-0.031,0.42-0.07,0.626-0.118c0.081-0.019,0.16-0.04,0.24-0.062c0.209-0.057,0.414-0.123,0.615-0.197 c0.066-0.024,0.132-0.046,0.197-0.072c0.258-0.103,0.51-0.217,0.753-0.346c0.265-0.141,0.506-0.292,0.739-0.454 c0.06-0.041,0.116-0.087,0.175-0.131c0.167-0.123,0.328-0.251,0.484-0.387c0.07-0.061,0.139-0.124,0.207-0.188 c0.149-0.14,0.291-0.286,0.427-0.438c0.053-0.058,0.107-0.114,0.158-0.174c0.185-0.218,0.358-0.444,0.517-0.682 c5.029-7.561,13.435-12.071,22.494-12.071h20.018c4.143,0,7.5-3.358,7.5-7.5s-3.357-7.5-7.5-7.5h-20.018 c-7.596,0-14.892,2.044-21.232,5.762v-10.419c5.102-6.508,12.887-10.343,21.232-10.343h20.018c4.143,0,7.5-3.358,7.5-7.5 s-3.357-7.5-7.5-7.5h-20.018c-10.817,0-21.035,4.131-28.733,11.364c-7.698-7.232-17.916-11.364-28.731-11.364H45V28.251h161.268 c9.056,0,17.461,4.514,22.486,12.075c1.39,2.092,3.734,3.349,6.246,3.349s4.856-1.257,6.247-3.349 c5.023-7.561,13.43-12.074,22.485-12.074H425v306.535h-41.25c-4.143,0-7.5,3.358-7.5,7.5s3.357,7.5,7.5,7.5h48.75 c4.143,0,7.5-3.358,7.5-7.5V88.251h15V394.786z"></path> <path d="M432.5,364.786h-48.75c-4.143,0-7.5,3.358-7.5,7.5s3.357,7.5,7.5,7.5h48.75c4.143,0,7.5-3.358,7.5-7.5 S436.643,364.786,432.5,364.786z"></path> </g> </g></svg>
        </div>
    </div>
    </a>
    <a href="<?php echo site_url(); ?>exam/mark_entry">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Mark Entries</span>
        </div>
        <div class="card-icon c3">
            <svg fill="#ffffff" height="200px" width="200px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 204 204" xml:space="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M139.185,157.339h25.175l-27.223,29.022v-26.974C137.137,158.257,138.056,157.339,139.185,157.339z M108.805,44.654 l7.761-1.004l-4.845-6.953L108.805,44.654z M179.518,5v142.339h-40.333c-6.644,0-12.048,5.405-12.048,12.048V204H29.482 c-2.762,0-5-2.239-5-5V5c0-2.761,2.238-5,5-5h145.035C177.279,0,179.518,2.239,179.518,5z M95.746,65.76 c0.568,0.208,1.148,0.307,1.721,0.307c2.038,0,3.953-1.256,4.694-3.281l2.765-7.546l18.084-2.34l4.595,6.594 c0.973,1.395,2.526,2.142,4.106,2.142c0.987,0,1.984-0.292,2.854-0.898c2.266-1.579,2.822-4.695,1.244-6.96l-21.377-30.677 c-0.008-0.011-0.019-0.02-0.027-0.031c-0.138-0.196-0.303-0.372-0.47-0.547c-0.061-0.064-0.113-0.141-0.177-0.201 c-0.132-0.124-0.286-0.226-0.432-0.336c-0.117-0.088-0.225-0.189-0.348-0.266c-0.094-0.059-0.202-0.098-0.301-0.151 c-0.193-0.103-0.384-0.209-0.588-0.285c-0.014-0.005-0.025-0.014-0.039-0.019c-0.117-0.043-0.237-0.057-0.354-0.091 c-0.183-0.052-0.364-0.11-0.552-0.141c-0.166-0.028-0.33-0.03-0.496-0.04c-0.157-0.01-0.313-0.028-0.471-0.024 c-0.169,0.005-0.333,0.034-0.5,0.056c-0.155,0.02-0.31,0.033-0.464,0.068c-0.166,0.038-0.324,0.099-0.486,0.154 c-0.145,0.049-0.292,0.089-0.434,0.153c-0.192,0.086-0.369,0.197-0.549,0.306c-0.09,0.055-0.185,0.091-0.273,0.152 c-0.01,0.007-0.018,0.017-0.028,0.024c-0.201,0.142-0.382,0.31-0.561,0.481c-0.061,0.058-0.132,0.107-0.19,0.167 c-0.121,0.128-0.219,0.278-0.326,0.419c-0.092,0.121-0.197,0.234-0.276,0.362c-0.052,0.083-0.086,0.18-0.134,0.267 c-0.111,0.205-0.222,0.409-0.303,0.626c-0.005,0.013-0.013,0.023-0.017,0.036L92.772,59.345 C91.822,61.938,93.153,64.81,95.746,65.76z M108.899,152.339c0-2.761-2.238-5-5-5H53.25c-2.762,0-5,2.239-5,5c0,2.761,2.238,5,5,5 h50.65C106.661,157.339,108.899,155.1,108.899,152.339z M130.157,121.839c0-2.761-2.238-5-5-5H53.25c-2.762,0-5,2.239-5,5 c0,2.761,2.238,5,5,5h71.907C127.919,126.839,130.157,124.6,130.157,121.839z M145.75,91.339c0-2.761-2.238-5-5-5h-87.5 c-2.762,0-5,2.239-5,5c0,2.761,2.238,5,5,5h87.5C143.512,96.339,145.75,94.1,145.75,91.339z M164.797,32.019 c-0.354-2.737-2.852-4.672-5.601-4.317l-6.681,0.865l-0.865-6.681c-0.354-2.738-2.851-4.673-5.601-4.317 c-2.738,0.354-4.672,2.862-4.317,5.6l0.865,6.681l-6.681,0.865c-2.738,0.354-4.672,2.861-4.317,5.6 c0.326,2.521,2.477,4.359,4.953,4.359c0.213,0,0.43-0.014,0.648-0.042l6.681-0.865l0.865,6.681c0.326,2.521,2.477,4.359,4.953,4.359 c0.213,0,0.43-0.014,0.647-0.042c2.738-0.354,4.672-2.862,4.317-5.6l-0.865-6.681l6.681-0.865 C163.218,37.265,165.151,34.758,164.797,32.019z"></path> </g></svg>
        </div> 
    </div>
    </a>
    <a href="<?php echo site_url(); ?>attachments">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Lesson Notes</span>
        </div>
        <div class="card-icon c4">
            <svg viewBox="0 0 192 192" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="12" clip-path="url(#a)"> <path d="M55 139.591 61.173 171l26.432-17.816L136 35.594 103.394 22 55 139.591ZM22 42h72m40 0h36M22 78h57m41 0h50M22 114h41m41 0h66M22 150h34m34 0h32"></path> </g> <defs> <clipPath id="a"> <path fill="#ffffff" d="M0 0h192v192H0z"></path> </clipPath> </defs> </g></svg>
        </div>
    </div>
    </a>
    <a href="<?php echo site_url(); ?>live_class">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Live Class Rooms</span>
        </div>
        <div class="card-icon c1">
            <svg viewBox="0 0 24 24" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;stroke:#ffffff;stroke-miterlimit:10;stroke-width:1.91px;}</style></defs><path class="cls-1" d="M18.68,1.48H5.32A3.82,3.82,0,0,0,1.5,5.3v9.54a3.82,3.82,0,0,0,3.82,3.82H9.14L12,21.52l2.86-2.86h3.82a3.82,3.82,0,0,0,3.82-3.82V5.3A3.82,3.82,0,0,0,18.68,1.48Z"></path><rect class="cls-1" x="7.23" y="7.2" width="5.73" height="6.68"></rect><polygon class="cls-1" points="12.96 10.07 12.96 11.02 15.82 13.89 16.77 13.89 16.77 7.21 15.82 7.21 12.96 10.07 12.96 10.07"></polygon></g></svg>
        </div>
    </div>
    </a>
    <a href="<?php echo site_url(); ?>library/book">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Library Books</span>
        </div>
        <div class="card-icon c2">
            <svg fill="#ffffff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M6,23H18a3,3,0,0,0,3-3V4a3,3,0,0,0-3-3H6A3,3,0,0,0,3,4V20A3,3,0,0,0,6,23ZM19,9.5v5h-.132L17.9,12.553a1,1,0,0,0-1.79.894l.527,1.053H15V12a1,1,0,0,0-2,0v2.5H12V13a1,1,0,0,0-2,0v1.5H5v-5ZM18,21H14V19a1,1,0,0,0-2,0v2H11V19a1,1,0,0,0-2,0v2H8V20a1,1,0,0,0-2,0v1a1,1,0,0,1-1-1V16.5H19V20A1,1,0,0,1,18,21ZM6,3H18a1,1,0,0,1,1,1V7.5H14.868L13.9,5.553a1,1,0,1,0-1.79.894L12.632,7.5H11V5A1,1,0,0,0,9,5V7.5H8V6A1,1,0,0,0,6,6V7.5H5V4A1,1,0,0,1,6,3Z"></path></g></svg>
        </div>
    </div>
    </a>
    
    <?php }; ?>
</div>
<?php if($roleID == 3 || $roleID == 11){ ?>
<div class="owl-carousel owl-theme" style="margin-bottom: 40px">
    <a href="<?php echo site_url(); ?>communication/mailbox/inbox">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Message</span>
        </div>
        <div class="card-icon c1">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 9H17M10 13H17M7 9H7.01M7 13H7.01M21 20L17.6757 18.3378C17.4237 18.2118 17.2977 18.1488 17.1656 18.1044C17.0484 18.065 16.9277 18.0365 16.8052 18.0193C16.6672 18 16.5263 18 16.2446 18H6.2C5.07989 18 4.51984 18 4.09202 17.782C3.71569 17.5903 3.40973 17.2843 3.21799 16.908C3 16.4802 3 15.9201 3 14.8V7.2C3 6.07989 3 5.51984 3.21799 5.09202C3.40973 4.71569 3.71569 4.40973 4.09202 4.21799C4.51984 4 5.0799 4 6.2 4H17.8C18.9201 4 19.4802 4 19.908 4.21799C20.2843 4.40973 20.5903 4.71569 20.782 5.09202C21 5.51984 21 6.0799 21 7.2V20Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
        </div>
    </div>
    </a>
    <a href="<?php echo site_url(); ?>exam/marksheet">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Report Cards</span>
        </div>
        <div class="card-icon c2">
            <svg fill="#ffffff" viewBox="0 0 32 32" id="icon" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;}</style></defs><title>report--alt</title><rect x="10" y="18" width="8" height="2"></rect><rect x="10" y="13" width="12" height="2"></rect><rect x="10" y="23" width="5" height="2"></rect><path d="M25,5H22V4a2,2,0,0,0-2-2H12a2,2,0,0,0-2,2V5H7A2,2,0,0,0,5,7V28a2,2,0,0,0,2,2H25a2,2,0,0,0,2-2V7A2,2,0,0,0,25,5ZM12,4h8V8H12ZM25,28H7V7h3v3H22V7h3Z"></path><rect id="_Transparent_Rectangle_" data-name="<Transparent Rectangle>" class="cls-1" width="32" height="32"></rect></g></svg>
        </div>
    </div>
    </a>
    <a href="<?php echo site_url(); ?>qrcode_attendance/take">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">QR Code Attendance</span>
        </div>
        <div class="card-icon c3">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3,11H5v2H3V11m8-6h2V9H11V5M9,11h4v4H11V13H9V11m6,0h2v2h2V11h2v2H19v2h2v4H19v2H17V19H13v2H11V17h4V15h2V13H15V11m4,8V15H17v4h2M15,3h6V9H15V3m2,2V7h2V5H17M3,3H9V9H3V3M5,5V7H7V5H5M3,15H9v6H3V15m2,2v2H7V17Z"></path> <rect width="24" height="24" fill="none"></rect> </g></svg>
        </div>
    </div>
    </a>
    <a href="<?php echo site_url(); ?>exam/class_position">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Result Comment</span>
        </div>
        <div class="card-icon c4">
            <svg fill="#ffffff" viewBox="0 0 64 64" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/" xmlns:xlink="http://www.w3.org/1999/xlink" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="ICON"> <path d="M10,15l-4,0c-0.796,0 -1.559,0.316 -2.121,0.879c-0.563,0.562 -0.879,1.325 -0.879,2.121c-0,2.509 -0,7.081 -0,12c-0,0.552 0.448,1 1,1c0.552,0 1,-0.448 1,-1l-0,-12c-0,-0.265 0.105,-0.52 0.293,-0.707c0.187,-0.188 0.442,-0.293 0.707,-0.293l4,0l-0,21c0,1.657 1.343,3 3,3l39,-0c0.796,-0 1.559,-0.316 2.121,-0.879c0.563,-0.562 0.879,-1.325 0.879,-2.121c0,-3.172 0,-9 0,-9c0,-0.552 -0.448,-1 -1,-1c-0.552,-0 -1,0.448 -1,1l-0,9c0,0.265 -0.105,0.52 -0.293,0.707c-0.187,0.188 -0.442,0.293 -0.707,0.293c-0,-0 -39,0 -39,0c-0.552,-0 -1,-0.448 -1,-1c-0,-0 0,-32 0,-32c0,-0.552 0.448,-1 1,-1c0,0 39,-0 39,-0c0.552,0 1,0.448 1,1c0,0 0,19 0,19c0,0.552 0.448,1 1,1c0.552,-0 1,-0.448 1,-1l0,-8l3,-0c0.265,0 0.52,0.105 0.707,0.293c0.188,0.187 0.293,0.442 0.293,0.707l-0,25l-54,0l-0,-9c-0,-0.552 -0.448,-1 -1,-1c-0.552,-0 -1,0.448 -1,1c-0,5.651 -0,11.154 -0,14c-0,0.796 0.316,1.559 0.879,2.121c0.562,0.563 1.325,0.879 2.121,0.879l4,0c0.552,0 1,-0.448 1,-1c-0,-0.552 -0.448,-1 -1,-1l-4,0c-0.265,-0 -0.52,-0.105 -0.707,-0.293c-0.188,-0.187 -0.293,-0.442 -0.293,-0.707l-0,-3l54,0l-0,3c0,0.265 -0.105,0.52 -0.293,0.707c-0.187,0.188 -0.442,0.293 -0.707,0.293l-44,0c-0.552,0 -1,0.448 -1,1c0,0.552 0.448,1 1,1l12.606,0c-0.16,2.682 -0.855,6.147 -3.417,8l-1.689,0c-0.552,-0 -1,0.448 -1,1c-0,0.552 0.448,1 1,1l21,0c0.552,-0 1,-0.448 1,-1c-0,-0.552 -0.448,-1 -1,-1l-1.689,0c-2.562,-1.854 -3.257,-5.318 -3.417,-8l20.606,0c0.796,-0 1.559,-0.316 2.121,-0.879c0.563,-0.562 0.879,-1.325 0.879,-2.121c-0,-6.028 -0,-23.972 -0,-30c0,-0.796 -0.316,-1.559 -0.879,-2.121c-0.562,-0.563 -1.325,-0.879 -2.121,-0.879l-3,-0l0,-9c-0,-1.657 -1.343,-3 -3,-3l-39,0c-1.657,0 -3,1.343 -3,3l0,9Zm25.394,36l-6.788,0c-0.155,2.531 -0.785,5.68 -2.585,8l11.958,0c-1.8,-2.32 -2.43,-5.47 -2.585,-8Zm-5.962,-19l-0.932,0c-0.552,0 -1,0.448 -1,1c0,0.552 0.448,1 1,1l0.182,0l-0.618,1.649c-0.194,0.517 0.068,1.094 0.585,1.287c0.517,0.194 1.094,-0.068 1.287,-0.585l0.882,-2.351l2.364,0l0.882,2.351c0.193,0.517 0.77,0.779 1.287,0.585c0.517,-0.193 0.779,-0.77 0.585,-1.287l-0.618,-1.649l0.182,0c0.552,0 1,-0.448 1,-1c0,-0.552 -0.448,-1 -1,-1l-0.932,0l-1.632,-4.351c-0.146,-0.39 -0.519,-0.649 -0.936,-0.649c-0.417,-0 -0.79,0.259 -0.936,0.649l-1.632,4.351Zm2.136,0l0.864,0l-0.432,-1.152l-0.432,1.152Zm-16.275,-10.293l2,2c0.39,0.391 1.024,0.391 1.414,0l3.967,-3.966c0.39,-0.391 0.39,-1.024 -0,-1.415c-0.391,-0.39 -1.024,-0.39 -1.415,0l-3.259,3.26c0,-0 -1.293,-1.293 -1.293,-1.293c-0.39,-0.39 -1.024,-0.39 -1.414,-0c-0.39,0.39 -0.39,1.024 -0,1.414Zm11.707,2.293l14,-0c0.552,0 1,-0.448 1,-1c0,-0.552 -0.448,-1 -1,-1l-14,-0c-0.552,0 -1,0.448 -1,1c0,0.552 0.448,1 1,1Zm-0,-4l21,-0c0.552,-0 1,-0.448 1,-1c-0,-0.552 -0.448,-1 -1,-1l-21,-0c-0.552,-0 -1,0.448 -1,1c-0,0.552 0.448,1 1,1Zm0,-6l14,-0c0.552,0 1,-0.448 1,-1c0,-0.552 -0.448,-1 -1,-1l-14,-0c-0.552,0 -1,0.448 -1,1c0,0.552 0.448,1 1,1Zm-11.707,-2.293l2,2c0.39,0.391 1.024,0.391 1.414,0l3.967,-3.966c0.39,-0.391 0.39,-1.024 -0,-1.415c-0.391,-0.39 -1.024,-0.39 -1.415,0l-3.259,3.26c0,-0 -1.293,-1.293 -1.293,-1.293c-0.39,-0.39 -1.024,-0.39 -1.414,-0c-0.39,0.39 -0.39,1.024 -0,1.414Zm11.707,-1.707l21,-0c0.552,-0 1,-0.448 1,-1c-0,-0.552 -0.448,-1 -1,-1l-21,-0c-0.552,-0 -1,0.448 -1,1c-0,0.552 0.448,1 1,1Z"></path> </g> </g></svg>
        </div>
    </div>
    </a>
    <a href="<?php echo site_url(); ?>exam/hostel_comments">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Hostel Comments</span>
        </div>
        <div class="card-icon c1">
            <svg fill="#ffffff" height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 503.607 503.607" xml:space="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g transform="translate(1 1)"> <g> <g> <path d="M343.131,217.229h-50.361c-5.036,0-8.393,3.357-8.393,8.393v83.934h-67.148v-83.934c0-5.036-3.357-8.393-8.393-8.393 h-50.361c-5.036,0-8.393,3.357-8.393,8.393v235.016c0,5.036,3.357,8.393,8.393,8.393h50.361c5.036,0,8.393-3.357,8.393-8.393 v-83.934h67.148v83.934c0,5.036,3.357,8.393,8.393,8.393h50.361c5.036,0,8.393-3.357,8.393-8.393V225.623 C351.525,220.587,348.167,217.229,343.131,217.229z M334.738,452.246h-33.574v-83.934c0-5.036-3.357-8.393-8.393-8.393h-83.934 c-5.036,0-8.393,3.357-8.393,8.393v83.934h-33.574v-218.23h33.574v83.934c0,5.036,3.357,8.393,8.393,8.393h83.934 c5.036,0,8.393-3.357,8.393-8.393v-83.934h33.574V452.246z"></path> <path d="M469.033-1H32.574C14.108-1-1,14.108-1,32.574v436.459c0,18.466,15.108,33.574,33.574,33.574h436.459 c18.466,0,33.574-15.108,33.574-33.574V32.574C502.607,14.108,487.498-1,469.033-1z M485.82,469.033 c0,9.233-7.554,16.787-16.787,16.787H32.574c-9.233,0-16.787-7.554-16.787-16.787V32.574c0-9.233,7.554-16.787,16.787-16.787 h436.459c9.233,0,16.787,7.554,16.787,16.787V469.033z"></path> <path d="M215.551,119.866l-15.108,44.485c-0.839,3.357,0,6.715,3.357,9.233c3.357,2.518,7.554,2.518,10.072,0l36.931-29.377 l36.931,29.377c1.679,0.839,3.357,1.679,5.036,1.679c1.679,0,3.357-0.839,4.197-1.679c3.357-1.679,4.197-5.875,3.357-9.233 l-15.108-44.485l37.77-30.216c2.518-2.518,3.357-5.875,2.518-9.233c-0.839-3.357-4.197-5.875-7.554-5.875h-44.485L258.357,37.61 c-0.839-3.357-4.197-5.036-7.554-5.036s-6.715,2.518-8.393,5.036l-14.269,36.931h-44.485c-3.357,0-6.715,2.518-8.393,5.875 c-1.679,3.357,0,6.715,2.518,9.233L215.551,119.866z M234.016,91.328c3.357,0,6.715-1.679,7.554-5.036l9.233-22.662l9.233,22.662 c0.839,3.357,4.197,5.036,7.554,5.036h26.859l-23.502,18.466c-2.518,2.518-3.357,5.875-2.518,9.233l7.554,23.502l-20.144-15.948 c-1.679-0.839-3.357-1.679-5.036-1.679s-3.357,0.839-5.036,1.679l-20.144,15.948l8.393-23.502c1.679-3.357,0-6.715-2.518-9.233 l-23.502-18.466H234.016z"></path> </g> </g> </g> </g></svg>
        </div>
    </div>
    </a>
    <a href="<?php echo site_url(); ?>exam/attendance_update">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Attendance Update</span>
        </div>
        <div class="card-icon c2">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M13 3H7C5.89543 3 5 3.89543 5 5V10M13 3L19 9M13 3V8C13 8.55228 13.4477 9 14 9H19M19 9V19C19 20.1046 18.1046 21 17 21H10C7.79086 21 6 19.2091 6 17V17C6 14.7909 7.79086 13 10 13H13M13 13L10 10M13 13L10 16" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
        </div>
    </div>
    </a>
    <a href="<?php echo site_url(); ?>event">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Events</span>
        </div>
        <div class="card-icon c3">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M0 0h24v24H0z" fill="none"></path><path d="M17 10H7v2h10v-2zm2-7h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zm-5-5H7v2h7v-2z"></path></g></svg>
        </div>
    </div>
    </a>
    <a href="<?php echo site_url(); ?>exam/spread_sheet">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">spread sheet</span>
        </div>
        <div class="card-icon c4">
            <svg viewBox="-4 0 34 34" xmlns="http://www.w3.org/2000/svg" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g fill="none" fill-rule="evenodd"> <g> <path d="M1 1.993c0-.55.45-.993.995-.993h17.01c.55 0 1.34.275 1.776.625l3.44 2.75c.43.345.78 1.065.78 1.622v26.006c0 .55-.447.997-1 .997H2c-.552 0-1-.452-1-.993V1.993z" stroke="#ffffff" stroke-width="2"></path> <path fill="#ffffff" d="M18 2h1v6h-1z"></path> <path fill="#ffffff" d="M18 7h6v1h-6z"></path> <g fill="#575757"> <path d="M9 12h1v10H9z"></path> <path d="M7 18h1v4H7z"></path> <path d="M13 17h1v5h-1z"></path> <path d="M17 20h1v2h-1z"></path> <path d="M15 14h1v8h-1z"></path> <path d="M11 15h1v7h-1z"></path> </g> </g> </g> </g></svg>
        </div>
    </div>
    </a>
    <a href="<?php echo site_url(); ?>leave/request">
    <div class="card">
        <div class="card-content">
            <!-- <span class="patient-count">0</span> -->
			
            <span class="patient-text">Leave Application</span>
        </div>
        <div class="card-icon c3">
            <svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>Session-Leave</title> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Session-Leave"> <rect id="Rectangle" fill-rule="nonzero" x="0" y="0" width="24" height="24"> </rect> <line x1="9" y1="12" x2="19" y2="12" id="Path" stroke="#ffffff" stroke-width="2" stroke-linecap="round"> </line> <path d="M16,8 L18.5858,10.5858 C19.3668,11.3668 19.3668,12.6332 18.5858,13.4142 L16,16" id="Path" stroke="#ffffff" stroke-width="2" stroke-linecap="round"> </path> <path d="M16,4 L6,4 C4.89543,4 4,4.89543 4,6 L4,18 C4,19.1046 4.89543,20 6,20 L16,20" id="Path" stroke="#ffffff" stroke-width="2" stroke-linecap="round"> </path> </g> </g> </g></svg>
        </div>
    </div>
    </a>
</div>
<?php }; ?>

<?php if ($widget1 > 0) { ?>

	<div class="row widget-1">

		<div class="col-md-12 col-lg-12 col-sm-12">

			<div class="panel">

				<div class="row widget-row-in">

				<?php if (get_permission('employee_count_widget', 'is_view')) { ?>

					<div class="col-lg-<?php echo $widget1; ?> col-sm-6 ">

						<div class="panel-body">

							<div class="widget-col-in row">

								<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-users"></i>

									<h5><?php echo translate('employee'); ?></h5>

								</div>

								<div class="col-md-6 col-sm-6 col-xs-6">

									<h3 class="counter text-right mt-md text-primary"><?php

									$staff = $this->dashboard_model->getstaffcounter('', $school_id);

									echo $staff['snumber'];

									?></h3>

								</div>

								<div class="col-md-12 col-sm-12 col-xs-12">

									<div class="box-top-line line-color-primary">

										<span class="text-uppercase"><?php echo translate('total_strength'); ?></span>

									</div>

								</div>

							</div>

						</div>

					</div>

				<?php } ?>

				<?php if (get_permission('student_count_widget', 'is_view')) { ?>

					<div class="col-lg-<?php echo $widget1; ?> col-sm-6">

						<div class="panel-body">

							<div class="widget-col-in row">

								<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-user-graduate"></i>

									<h5><?php echo translate('students'); ?></h5> </div>

								<div class="col-md-6 col-sm-6 col-xs-6">

									<h3 class="counter text-right mt-md text-primary"><?=$get_total_student?></h3>

								</div>

								<div class="col-md-12 col-sm-12 col-xs-12">

									<div class="box-top-line line-color-primary">

											<span class="text-uppercase"><?php echo translate('total_strength'); ?></span>

									</div>

								</div>

							</div>

						</div>

					</div>

				<?php } ?>

				<?php if (get_permission('parent_count_widget', 'is_view')) { ?>

					<div class="col-lg-<?php echo $widget1; ?> col-sm-6 ">

						<div class="panel-body">

							<div class="widget-col-in row">

								<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-user-tie" ></i>

									<h5><?php echo translate('parents'); ?></h5></div>

								<div class="col-md-6 col-sm-6 col-xs-6">

									<h3 class="counter text-right mt-md text-primary"><?php

										if (!empty($school_id))

											$this->db->where('branch_id', $school_id);

										echo $this->db->select('id')->get('parent')->num_rows();

									?></h3>

								</div>

								<div class="col-md-12 col-sm-12 col-xs-12">

									<div class="box-top-line line-color-primary">

										<span class="text-uppercase"><?php echo translate('total_strength'); ?></span>

									</div>

								</div>

							</div>

						</div>

					</div>

				<?php } ?>

				<?php if (get_permission('teacher_count_widget', 'is_view')) { ?>

					<div class="col-lg-<?php echo $widget1; ?> col-sm-6 ">

						<div class="panel-body">

							<div class="widget-col-in row">

								<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-chalkboard-teacher" ></i>

									<h5><?php echo translate('teachers'); ?></h5></div>

								<div class="col-md-6 col-sm-6 col-xs-6">

									<h3 class="counter text-right mt-md text-primary"><?php

									$staff = $this->dashboard_model->getstaffcounter(3, $school_id);

									echo $staff['snumber'];

									?></h3>

								</div>

								<div class="col-md-12 col-sm-12 col-xs-12">

									<div class="box-top-line line-color-primary">

										<span class="text-uppercase"><?=translate('total_strength')?></span>

									</div>

								</div>

							</div>

						</div>

					</div>

				<?php } ?>

				</div>

			</div>

		</div>

	</div>

<?php } ?>

	<div class="row">

<?php if (get_permission('monthly_income_vs_expense_chart', 'is_view')) { ?>

		<!-- monthly cash book transaction -->

		<div class="<?php echo get_permission('annual_student_fees_summary_chart', 'is_view') ? 'col-md-12 col-lg-4 col-xl-3' : 'col-md-12'; ?>">

			<section class="panel pg-fw">

				<div class="panel-body">

					<h4 class="chart-title mb-xs"><?=translate('income_vs_expense_of') . " " . translate(strtolower(date('F')))?></h4>

					<div id="cash_book_transaction"></div>

					<div class="round-overlap"><i class="fab fa-sellcast"></i></div>

					<div class="text-center">

						<ul class="list-inline">

							<li>

								<h6 class="text-muted"><i class="fa fa-circle text-blue"></i> <?=translate('income')?></h6>

							</li>

							<li>

								<h6 class="text-muted"><i class="fa fa-circle text-danger"></i> <?=translate('expense')?></h6>

							</li>

						</ul>

					</div>

				</div>

			</section>

		</div>

<?php } ?>

<?php if (get_permission('annual_student_fees_summary_chart', 'is_view')) { ?>

		<!-- student fees summary graph -->

		<div class="<?php echo get_permission('monthly_income_vs_expense_chart', 'is_view') ? 'col-md-12 col-lg-8 col-xl-9' : 'col-md-12'; ?>">

			<section class="panel">

				<div class="panel-body">

					<h4 class="chart-title mb-md"><?=translate('annual_fee_summary')?></h4>

					<div class="pe-chart">

						<canvas id="fees_graph" style="height: 322px;"></canvas>

					</div>

				</div>

			</section>

		</div>

<?php } ?>

	</div>

	<!-- student quantity chart -->

	<div class="row">

<?php if (get_permission('student_quantity_pie_chart', 'is_view')) { ?>

		<div class="<?php echo get_permission('weekend_attendance_inspection_chart', 'is_view') ? 'col-md-12 col-lg-4 col-xl-3' : 'col-md-12'; ?>">

			<section class="panel pg-fw">

				<div class="panel-body">

					<h4 class="chart-title mb-xs"><?=translate('student_quantity')?></h4>

					<div id="student_strength"></div>

					<div class="round-overlap"><i class="fas fa-school"></i></div>

				</div>

			</section>

		</div>

<?php } ?>

<?php if (get_permission('weekend_attendance_inspection_chart', 'is_view')) { ?>

		<div class="<?php echo get_permission('student_quantity_pie_chart', 'is_view') ? 'col-md-12 col-lg-8 col-xl-9' : 'col-md-12'; ?>">

			<section class="panel">

				<div class="panel-body">

					<h4 class="chart-title mb-md"><?=translate('weekend_attendance_inspection')?></h4>

					<div class="pg-fw">

						<canvas id="weekend_attendance" style="height: 340px;"></canvas>

					</div>

				</div>

			</section>

		</div>

<?php } ?>

	</div>

<?php if ($widget2 > 0) { ?>

	<div class="row widget-2">

		<div class="col-md-12 col-lg-12 col-sm-12">

			<div class="panel">

				<div class="row widget-row-in">

				<?php if (get_permission('admission_count_widget', 'is_view')) { ?>

					<div class="col-lg-<?php echo $widget2; ?> col-sm-6 ">

						<div class="panel-body">

							<div class="widget-col-in row">

								<div class="col-md-6 col-sm-6 col-xs-6"> <i class="far fa-address-card"></i>

									<h5><?php echo translate('admission'); ?></h5>

								</div>

								<div class="col-md-6 col-sm-6 col-xs-6">

									<h3 class="counter text-right mt-md text-primary"><?=$get_monthly_admission;?></h3>

								</div>

								<div class="col-md-12 col-sm-12 col-xs-12">

									<div class="box-top-line line-color-primary">

										<span class="text-uppercase"><?php echo translate('interval_month'); ?></span>

									</div>

								</div>

							</div>

						</div>

					</div>

				<?php } ?>

				<?php if (get_permission('voucher_count_widget', 'is_view')) { ?>

					<div class="col-lg-<?php echo $widget2; ?> col-sm-6">

						<div class="panel-body">

							<div class="widget-col-in row">

								<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-money-check-alt"></i>

									<h5><?php echo translate('voucher'); ?></h5> </div>

								<div class="col-md-6 col-sm-6 col-xs-6">

									<h3 class="counter text-right mt-md text-primary"><?=$get_voucher?></h3>

								</div>

								<div class="col-md-12 col-sm-12 col-xs-12">

									<div class="box-top-line line-color-primary">

											<span class="text-uppercase"><?php echo translate('total_number'); ?></span>

									</div>

								</div>

							</div>

						</div>

					</div>

				<?php } ?>

				<?php if (get_permission('transport_count_widget', 'is_view') && moduleIsEnabled('transport')) { ?>

					<div class="col-lg-<?php echo $widget2; ?> col-sm-6 ">

						<div class="panel-body">

							<div class="widget-col-in row">

								<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-road" ></i>

									<h5><?php echo translate('transport'); ?></h5></div>

								<div class="col-md-6 col-sm-6 col-xs-6">

									<h3 class="counter text-right mt-md text-primary"><?=$get_transport_route?></h3>

								</div>

								<div class="col-md-12 col-sm-12 col-xs-12">

									<div class="box-top-line line-color-primary">

										<span class="text-uppercase"><?php echo translate('total_route'); ?></span>

									</div>

								</div>

							</div>

						</div>

					</div>

				<?php } ?>

				<?php if (get_permission('hostel_count_widget', 'is_view') && moduleIsEnabled('hostel')) { ?>

					<div class="col-lg-<?php echo $widget2; ?> col-sm-6 ">

						<div class="panel-body">

							<div class="widget-col-in row">

								<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-warehouse" ></i>

									<h5><?php echo translate('hostel'); ?></h5></div>

								<div class="col-md-6 col-sm-6 col-xs-6">

									<h3 class="counter text-right mt-md text-primary"><?php

										if (!empty($school_id))

											$this->db->where('branch_id', $school_id);

										$hostel_room = $this->db->select('id')->get('hostel_room')->num_rows();

										echo $hostel_room;

										?></h3>

								</div>

								<div class="col-md-12 col-sm-12 col-xs-12">

									<div class="box-top-line line-color-primary">

										<span class="text-uppercase"><?=translate('total_room')?></span>

									</div>

								</div>

							</div>

						</div>

					</div>

				<?php } ?>

				</div>

			</div>

		</div>

	</div>

<?php } ?>

	<div class="row">

	    <!-- event calendar -->

		<div class="col-md-<?php echo $div3 ?>">

			<section class="panel">

				<div class="panel-body">

					<div id="event_calendar"></div>

				</div>

			</section>

		</div>

	<?php if ($div3 == 9) { ?>

		<div class="col-md-3">

			<div class="panel">

				<div class="row widget-row-in">

				<?php if (get_permission('student_birthday_widget', 'is_view')) { ?>

					<div class="col-xs-12">

						<div class="panel-body">

							<div class="widget-col-in row">

								<div class="col-md-6 col-sm-6 col-xs-6"> <a href="<?php echo base_url('birthday/student') ?>" data-toggle="tooltip" data-original-title="<?=translate('view') . " " . translate('list')?>"><i class="fas fa-birthday-cake" ></i></a>

									<h5 class="text-muted"><?=translate('student')?></h5></div>

								<div class="col-md-6 col-sm-6 col-xs-6">

									<h3 class="counter text-right mt-md text-primary"><?php

										$this->db->select('student.id');

										$this->db->from('student');

										$this->db->join('enroll', 'enroll.student_id = student.id', 'inner');

										$this->db->where("enroll.session_id", get_session_id());

										if (!empty($school_id))

											$this->db->where('branch_id', $school_id);

										$this->db->where("MONTH(student.birthday)", date('m'));

										$this->db->where("DAY(student.birthday)", date('d'));

										$this->db->group_by('student.id'); 

										$stuTodayBirthday = $this->db->get()->result();

										echo(count($stuTodayBirthday));

										?></h3>

								</div>

								<div class="col-md-12 col-sm-12 col-xs-12">

									<div class="box-top-line line-color-primary">

										<span class="text-muted text-uppercase"><?=translate('today_birthday')?></span>

									</div>

								</div>

							</div>

						</div>

					</div>

				<?php } if (get_permission('staff_birthday_widget', 'is_view')) { ?>

					<div class="col-xs-12">

						<div class="panel-body">

							<div class="widget-col-in row">

								<div class="col-md-6 col-sm-6 col-xs-6"> <a href="<?php echo base_url('birthday/staff') ?>" data-toggle="tooltip" data-original-title="<?=translate('view') . " " . translate('list')?>"><i class="fas fa-birthday-cake" ></i></a>

									<h5 class="text-muted"><?=translate('employee')?></h5></div>

								<div class="col-md-6 col-sm-6 col-xs-6">

									<h3 class="counter text-right mt-md text-primary"><?php

										$this->db->select('id');

										if (!empty($school_id))

											$this->db->where('branch_id', $school_id);

										$this->db->where("MONTH(birthday)", date('m'));

										$this->db->where("DAY(birthday)", date('d'));

										$emyTodayBirthday = $this->db->get('staff')->result();

										echo(count($emyTodayBirthday));

										?></h3>

								</div>

								<div class="col-md-12 col-sm-12 col-xs-12">

									<div class="box-top-line line-color-primary">

										<span class="text-muted text-uppercase"><?=translate('today_birthday')?></span>

									</div>

								</div>

							</div>

						</div>

					</div>

				<?php } ?>

				</div>

			</div>

		</div>

	<?php } ?>

	</div>

</div>



<div class="zoom-anim-dialog modal-block modal-block-primary mfp-hide" id="modal">

	<section class="panel">

		<header class="panel-heading">

			<div class="panel-btn">

				<button onclick="fn_printElem('printResult')" class="btn btn-default btn-circle icon" ><i class="fas fa-print"></i></button>

			</div>

			<h4 class="panel-title"><i class="fas fa-info-circle"></i> <?=translate('event_details')?></h4>

		</header>

		<div class="panel-body">

			<div id="printResult" class=" pt-sm pb-sm">

				<div class="table-responsive">						

					<table class="table table-bordered table-condensed text-dark tbr-top" id="ev_table">

						

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

		timezone: 'UTC',

		lang: '<?php echo $language ?>',

		events: {

			url: "<?=base_url('event/get_events_list/'. $school_id)?>"

		},

		

		eventRender: function(event, element) {

			$(element).on("click", function() {

				viewEvent(event.id);

			});

			if(event.icon){          

				element.find(".fc-title").prepend("<i class='fas fa-"+event.icon+"'></i> ");

			}

		}

	});



	// Annual Fee Summary JS

	var total_fees = <?php echo json_encode($fees_summary["total_fee"]);?>;

	var total_paid = <?php echo json_encode($fees_summary["total_paid"]);?>;

	var total_due = <?php echo json_encode($fees_summary["total_due"]);?>;

	var feesGraph = {

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

	}



	var days = <?php echo json_encode($weekend_attendance["days"]);?>;

	var employees_att = <?php echo json_encode($weekend_attendance["employee_att"]);?>;

	var student_att = <?php echo json_encode($weekend_attendance["student_att"]);?>;

	var weekendAttendanceChart = {

		type: 'bar',

		data: {

			labels: days,

			datasets: [{

				label: '<?php echo translate("employee");?>',

				data: employees_att,

				backgroundColor: 'rgba(0, 136, 204, .6)',

				borderColor: '#F5F5F5',

				borderWidth: 1,

				fill: false,

			},{

				label: '<?php echo translate("student");?>',

				data: student_att,

				backgroundColor: 'rgba(204, 102, 102, .6)',

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

	};



<?php if (get_permission('annual_student_fees_summary_chart', 'is_view')) { ?>

	var ctx = document.getElementById('fees_graph').getContext('2d');

	window.myLine =new Chart(ctx, feesGraph);

<?php } ?>

<?php if (get_permission('weekend_attendance_inspection_chart', 'is_view')) { ?>

	var ctx2 = document.getElementById('weekend_attendance').getContext('2d');

	window.myLine =new Chart(ctx2, weekendAttendanceChart);

<?php } ?>

<?php if (get_permission('monthly_income_vs_expense_chart', 'is_view')) { ?>

	// monthly income vs expense chart

	var cash_book_transaction = document.getElementById("cash_book_transaction");

	var cashbookchart = echarts.init(cash_book_transaction);

	cashbookchart.setOption({

		tooltip: {

			trigger: 'item',

			formatter: "{a} <br/>{b} : <?php echo $global_config["currency_symbol"];?> {c} ({d}%)"

		}, 

		legend: {

			show: false

		},

		color: ["#d81b60", "#009efb"],

		series: [{

			name: 'Transaction',

			type: 'pie',

			radius: ['75%', '90%'],

			itemStyle: {

				normal: {

					label: {

						show: false

					},

					labelLine: {

						show: false

					}

				},

				emphasis: {

					label: {

						show: false

					}

				}

			},

			data: <?=json_encode($income_vs_expense)?>

		}]

	});

<?php } ?>

<?php if (get_permission('student_quantity_pie_chart', 'is_view')) { ?>

	// Student Strength Doughnut Chart

	var color = ['#546570', '#c4ccd3', '#c23531', '#2f4554', '#61a0a8', '#d48265', '#91c7ae', '#749f83',  '#ca8622', '#bda29a', '#6e7074'];

	var strength_data = <?php echo json_encode($student_by_class);?>;

	var student_strength = document.getElementById("student_strength");

	var studentchart = echarts.init(student_strength);

	studentchart.setOption( {

		tooltip: {

			trigger: 'item',

			formatter: "{a} <br/>{b} : {c} ({d}%)"

		}, 

		legend: {

			type: 'scroll',

			x: 'center',

			y: 'bottom',

			itemWidth: 14,

<?php if($theme_config["dark_skin"] == "true"): ?>

			inactiveColor: '#4b4b4b',

			textStyle: {

				color: '#6b6b6c'

			}

<?php endif; ?>

		},

		series: [{

			name: 'Strength',

			type: 'pie',

			color: color,

			radius: ['70%', '85%'],

			center: ['50%', '46%'],

			itemStyle: {

				normal: {

					label: {

						show: false

					},

					labelLine: {

						show: false

					}

				},

				emphasis: {

					label: {

						show: false

					}

				}

			},

			data: strength_data

		}]

	});

<?php } ?>

	// charts resize

	$(".sidebar-toggle").on("click",function(event){

		echartsresize();

	});



	$(window).on("resize", echartsresize);



	function echartsresize() {

		setTimeout(function () {

			if ($("#student_strength").length) {

				studentchart.resize();

			}

			if ($("#cash_book_transaction").length) {

				cashbookchart.resize();

			}

		}, 350);

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