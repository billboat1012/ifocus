<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="keyword" content="<?php echo $page_data['meta_keyword']; ?>">
		<meta name="description" content="<?php echo $page_data['meta_description']; ?>">
		<!-- Favicon -->
		<link rel="shortcut icon" href="<?php echo base_url('uploads/frontend/images/' . $cms_setting['fav_icon']); ?>">
		<title><?php echo $page_data['page_title'] . " - " . $cms_setting['application_title']; ?></title>
		<!-- Bootstrap -->
		<link href="<?php echo base_url() ?>assets/frontend/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
		<!-- Template CSS Files  -->
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/font-awesome/css/all.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/frontend/css/fadesrek.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/frontend/plugins/animate.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/frontend/css/responsive.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/frontend/css/owl.carousel.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/select2/css/select2.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/sweetalert/sweetalert-custom.css');?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.standalone.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/frontend/plugins/magnific-popup/magnific-popup.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/frontend/css/style.css'); ?>">
		<style>
		    
::-webkit-scrollbar{
    width:9px;
    background: inherit;
    }

/* div{
    border: 1px solid red;
} */

::-webkit-scrollbar-thumb{
    background: <?php echo $cms_setting["primary_color"] = "" ? "#000" : $cms_setting["primary_color"] ?>;
}

.equalizer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100px; /* Adjust the width as needed */
}

.bar {
    width: 7px; /* Adjust the width of each bar */
    height: 20px; /* Initial height of the bars */
    background-color: <?php echo $cms_setting["primary_color"] = "" ? "#000" : $cms_setting["primary_color"] ?>;
    animation: equalizer 1s infinite;
    border-radius: 5px; /* Adjust the border radius to match the gif */
}

.bar:nth-child(1) {
    animation-delay: 0.1s;
}

.bar:nth-child(2) {
    animation-delay: 0.2s;
}

.bar:nth-child(3) {
    animation-delay: 0.3s;
}

.bar:nth-child(4) {
    animation-delay: 0.4s;
}

.bar:nth-child(5) {
    animation-delay: 0.5s;
}

.bar:nth-child(6) {
    animation-delay: 0.6s;
}

.bar:nth-child(7) {
    animation-delay: 0.7s;
}

.bar:nth-child(8) {
    animation-delay: 0.8s;
}

@keyframes equalizer {
    0% {
        transform: scaleY(1);
    }
    50% {
        transform: scaleY(2.5);
    }
    100% {
        transform: scaleY(1);
    }
}

		</style>
		<script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
		<!-- If user have enabled CSRF proctection this function will take care of the ajax requests and append custom header for CSRF -->
		<script type="text/javascript">
			var base_url = "<?php echo base_url(); ?>";
			var csrfData = <?php echo json_encode(csrf_jquery_token()); ?>;
			$(function($) {
				$.ajaxSetup({
					data: csrfData
				});
			});
		</script>
		<!-- Google Analytics --> 
		<?php echo $cms_setting['google_analytics']; ?>
		
		<!-- Theme Color Options -->
		<script type="text/javascript">
			document.documentElement.style.setProperty('--thm-primary', '<?php echo $cms_setting["primary_color"] ?>');
			document.documentElement.style.setProperty('--thm-hover', '<?php echo $cms_setting["hover_color"] ?>');
			document.documentElement.style.setProperty('--thm-text', '<?php echo $cms_setting["text_color"] ?>');
			document.documentElement.style.setProperty('--thm-secondary-text', '<?php echo $cms_setting["text_secondary_color"] ?>');
			document.documentElement.style.setProperty('--thm-footer-text', '<?php echo $cms_setting["footer_text_color"] ?>');
			document.documentElement.style.setProperty('--thm-radius', '<?php echo $cms_setting["border_radius"] ?>');
		</script>
	</head>
	<body>
		<!-- Preloader -->
		<div class="loader-container d-flex align-items-center justify-content-center" style="z-index:999999999999">
             <div class="equalizer h-25">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>
		</div>
		<?php $this->load->view('home/layout/header'); ?>
		<?php echo $main_contents; ?>
		<?php $this->load->view('home/layout/footer'); ?>
	</body>
</html>