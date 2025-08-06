<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width,initial-scale=1" name="viewport">
	<meta name="keywords" content="">
	<meta name="description" content="<?php echo $global_config['institute_name'] ?>">
	<meta name="author" content="<?php echo $global_config['institute_name'] ?>">
	<title><?php echo translate('login');?></title>
	<link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png');?>">
    
    <!-- Web Fonts  -->
	<link href="<?php echo is_secure('fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');?>" rel="stylesheet"> 
	<link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/vendor/font-awesome/css/all.min.css'); ?>">
	<script src="<?php echo base_url('assets/vendor/jquery/jquery.js');?>"></script>
	
	<!-- sweetalert js/css -->
	<link rel="stylesheet" href="<?php echo base_url('assets/vendor/sweetalert/sweetalert-custom.css');?>">
	<script src="<?php echo base_url('assets/vendor/sweetalert/sweetalert.min.js');?>"></script>
	
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		
		html, body {
			font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
			background: linear-gradient(135deg, #e8f2ff 0%, #f0f4ff 50%, #e6f0ff 100%);
			min-height: 100vh;
			overflow-x: hidden;
		}
		
		.auth-container {
			min-height: 100vh;
			display: flex;
			position: relative;
		}
		
		/* Background decorative elements */
		.bg-decoration {
			position: absolute;
			border-radius: 50%;
			background: linear-gradient(135deg, rgba(99, 179, 237, 0.1), rgba(139, 195, 245, 0.15));
			z-index: 1;
		}
		
		.bg-decoration-1 {
			width: 200px;
			height: 200px;
			top: 10%;
			left: 5%;
			animation: float 8s ease-in-out infinite;
		}
		
		.bg-decoration-2 {
			width: 150px;
			height: 150px;
			top: 60%;
			left: 15%;
			animation: float 10s ease-in-out infinite reverse;
		}
		
		.bg-decoration-3 {
			width: 100px;
			height: 100px;
			top: 30%;
			right: 20%;
			animation: float 12s ease-in-out infinite;
		}
		
		.bg-decoration-4 {
			width: 180px;
			height: 180px;
			bottom: 20%;
			right: 10%;
			animation: float 9s ease-in-out infinite reverse;
		}
		
		@keyframes float {
			0%, 100% { transform: translateY(0px) scale(1); }
			50% { transform: translateY(-20px) scale(1.05); }
		}
		
		/* Student Materials for Mobile Background */
		.mobile-student-material {
			position: absolute;
			opacity: 0.3;
			filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
			z-index: 1;
			display: none; /* Hidden by default, shown on mobile */
		}
		
		/* Pen */
		.mobile-pen {
			width: 6px;
			height: 80px;
			background: linear-gradient(0deg, #3742fa 0%, #2f3542 80%, #ff6348 80%, #ff6348 90%, #2f3542 90%);
			border-radius: 3px;
		}
		
		/* Pencil */
		.mobile-pencil {
			width: 8px;
			height: 100px;
			background: linear-gradient(0deg, #feca57 0%, #feca57 75%, #ff6348 75%, #ff6348 85%, #2f3542 85%);
			border-radius: 4px;
		}
		
		/* Crayon */
		.mobile-crayon {
			width: 10px;
			height: 60px;
			border-radius: 5px;
		}
		
		.mobile-crayon-red { background: linear-gradient(0deg, #ff4757 0%, #ff4757 80%, #2f3542 80%); }
		.mobile-crayon-blue { background: linear-gradient(0deg, #3742fa 0%, #3742fa 80%, #2f3542 80%); }
		.mobile-crayon-green { background: linear-gradient(0deg, #2ed573 0%, #2ed573 80%, #2f3542 80%); }
		.mobile-crayon-yellow { background: linear-gradient(0deg, #ffa502 0%, #ffa502 80%, #2f3542 80%); }
		
		/* Book */
		.mobile-book {
			width: 50px;
			height: 65px;
			border-radius: 3px;
			box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
		}
		
		.mobile-book-red { background: linear-gradient(135deg, #ff4757, #c44569); }
		.mobile-book-blue { background: linear-gradient(135deg, #3742fa, #2f3542); }
		.mobile-book-green { background: linear-gradient(135deg, #2ed573, #1e90ff); }
		.mobile-book-purple { background: linear-gradient(135deg, #a55eea, #8e44ad); }
		
		/* Eraser */
		.mobile-eraser {
			width: 30px;
			height: 15px;
			background: linear-gradient(135deg, #ff9ff3, #f368e0);
			border-radius: 8px;
		}
		
		/* Position mobile student materials */
		.mobile-pen-1 { top: 8%; left: 5%; transform: rotate(25deg); animation: float 12s infinite ease-in-out; }
		.mobile-pen-2 { top: 75%; right: 8%; transform: rotate(-15deg); animation: float 10s infinite ease-in-out; }
		.mobile-pencil-1 { top: 20%; right: 5%; transform: rotate(-30deg); animation: float 14s infinite ease-in-out; }
		.mobile-pencil-2 { bottom: 25%; left: 8%; transform: rotate(20deg); animation: float 8s infinite ease-in-out; }
		.mobile-crayon-1 { top: 35%; left: 10%; transform: rotate(60deg); animation: float 11s infinite ease-in-out; }
		.mobile-crayon-2 { top: 60%; right: 12%; transform: rotate(-20deg); animation: float 13s infinite ease-in-out; }
		.mobile-crayon-3 { top: 15%; right: 25%; transform: rotate(40deg); animation: float 9s infinite ease-in-out; }
		.mobile-crayon-4 { bottom: 40%; left: 15%; transform: rotate(-60deg); animation: float 15s infinite ease-in-out; }
		.mobile-book-1 { top: 25%; left: 25%; transform: rotate(-10deg); animation: float 16s infinite ease-in-out; }
		.mobile-book-2 { bottom: 30%; right: 20%; transform: rotate(15deg); animation: float 7s infinite ease-in-out; }
		.mobile-book-3 { top: 50%; right: 30%; transform: rotate(-25deg); animation: float 12s infinite ease-in-out; }
		.mobile-eraser-1 { top: 45%; left: 20%; transform: rotate(30deg); animation: float 10s infinite ease-in-out; }
		.mobile-eraser-2 { top: 70%; right: 25%; transform: rotate(-40deg); animation: float 14s infinite ease-in-out; }
		
		/* Left side - Illustration */
		.illustration-section {
			flex: 1;
			display: flex;
			align-items: center;
			justify-content: center;
			position: relative;
			background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
			overflow: hidden;
		}
		
		.illustration-container {
			position: relative;
			z-index: 2;
			text-align: center;
		}
		
		/* Educational Icons */
		.edu-icon {
			position: absolute;
			z-index: 1;
		}
		
		.graduation-cap {
			top: 15%;
			right: 15%;
			width: 80px;
			height: 60px;
			background: linear-gradient(135deg, #3b82f6, #1d4ed8);
			border-radius: 8px 8px 0 0;
			position: relative;
			animation: float 6s ease-in-out infinite;
		}
		
		.graduation-cap::before {
			content: '';
			position: absolute;
			top: -8px;
			left: -10px;
			right: -10px;
			height: 8px;
			background: #1d4ed8;
			border-radius: 50px;
		}
		
		.graduation-cap::after {
			content: '';
			position: absolute;
			top: -12px;
			right: -5px;
			width: 4px;
			height: 20px;
			background: #ef4444;
			border-radius: 2px;
		}
		
		.lightbulb {
			top: 20%;
			right: 5%;
			width: 40px;
			height: 60px;
			background: linear-gradient(135deg, #fbbf24, #f59e0b);
			border-radius: 50% 50% 20% 20%;
			position: relative;
			animation: float 8s ease-in-out infinite reverse;
		}
		
		.lightbulb::before {
			content: '';
			position: absolute;
			bottom: -8px;
			left: 8px;
			right: 8px;
			height: 8px;
			background: #6b7280;
			border-radius: 0 0 4px 4px;
		}
		
		.report-card {
			top: 10%;
			right: 25%;
			width: 60px;
			height: 80px;
			background: white;
			border-radius: 8px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
			position: relative;
			animation: float 10s ease-in-out infinite;
		}
		
		.report-card::before {
			content: 'A+';
			position: absolute;
			top: 12px;
			left: 8px;
			font-size: 14px;
			font-weight: 700;
			color: #ef4444;
		}
		
		.report-card::after {
			content: '';
			position: absolute;
			top: 30px;
			left: 8px;
			right: 8px;
			height: 2px;
			background: repeating-linear-gradient(
				90deg,
				#e5e7eb,
				#e5e7eb 8px,
				transparent 8px,
				transparent 12px
			);
		}
		
		.gears {
			bottom: 30%;
			left: 10%;
			width: 80px;
			height: 80px;
			position: relative;
			animation: float 7s ease-in-out infinite;
		}
		
		.gear {
			position: absolute;
			border-radius: 50%;
			background: linear-gradient(135deg, #60a5fa, #3b82f6);
		}
		
		.gear-1 {
			width: 50px;
			height: 50px;
			top: 0;
			left: 0;
			animation: rotate 8s linear infinite;
		}
		
		.gear-2 {
			width: 35px;
			height: 35px;
			bottom: 0;
			right: 0;
			animation: rotate 8s linear infinite reverse;
		}
		
		@keyframes rotate {
			from { transform: rotate(0deg); }
			to { transform: rotate(360deg); }
		}
		
		/* Main character illustration */
		.character {
			width: 300px;
			height: 350px;
			position: relative;
			margin: 0 auto;
		}
		
		.character-body {
			width: 120px;
			height: 160px;
			background: linear-gradient(135deg, #a78bfa, #8b5cf6);
			border-radius: 60px 60px 20px 20px;
			position: absolute;
			bottom: 0;
			left: 50%;
			transform: translateX(-50%);
		}
		
		.character-head {
			width: 80px;
			height: 80px;
			background: #fbbf24;
			border-radius: 50%;
			position: absolute;
			top: 40px;
			left: 50%;
			transform: translateX(-50%);
		}
		
		.character-hair {
			width: 90px;
			height: 50px;
			background: #1f2937;
			border-radius: 50px 50px 0 0;
			position: absolute;
			top: 35px;
			left: 50%;
			transform: translateX(-50%);
		}
		
		.character-book {
			width: 60px;
			height: 80px;
			background: linear-gradient(135deg, #3b82f6, #1d4ed8);
			border-radius: 8px;
			position: absolute;
			bottom: 40px;
			left: 50%;
			transform: translateX(-50%);
			box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
		}
		
		.character-book::before {
			content: '';
			position: absolute;
			top: 0;
			left: 50%;
			transform: translateX(-50%);
			width: 2px;
			height: 100%;
			background: rgba(255, 255, 255, 0.3);
		}
		
		/* Right side - Form - REDUCED SIZE */
		.form-section {
			flex: 0 0 380px; /* Reduced from 500px to 380px */
			padding: 20px; /* Reduced from 40px to 20px */
			display: flex;
			flex-direction: column;
			justify-content: center;
			position: relative;
			z-index: 2;
			background: rgba(255, 255, 255, 0.8);
			backdrop-filter: blur(10px);
		}
		
		.form-container {
			background: white;
			border-radius: 20px; /* Reduced from 24px to 20px */
			padding: 32px 28px; /* Reduced from 48px 40px to 32px 28px */
			box-shadow: 
				0 20px 40px rgba(0, 0, 0, 0.08),
				0 8px 16px rgba(0, 0, 0, 0.04);
			border: 1px solid rgba(255, 255, 255, 0.8);
		}
		
		.logo-container {
			text-align: center;
			margin-bottom: 24px; /* Reduced from 32px to 24px */
		}
		
		.logo-container img {
			width: 60px; /* Reduced from 80px to 60px */
			height: 60px; /* Reduced from 80px to 60px */
			border-radius: 50%;
			border: 3px solid #e5e7eb;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
			margin-bottom: 12px; /* Reduced from 16px to 12px */
		}
		
		.brand-title {
			font-size: 24px; /* Reduced from 32px to 24px */
			font-weight: 700;
			color: #2563eb;
			margin-bottom: 6px; /* Reduced from 8px to 6px */
			letter-spacing: -0.5px;
		}
		
		.brand-subtitle {
			font-size: 13px; /* Reduced from 16px to 13px */
			color: #6b7280;
			font-weight: 400;
		}
		
		.form-group {
			margin-bottom: 18px; /* Reduced from 24px to 18px */
		}
		
		.form-label {
			display: block;
			font-size: 13px; /* Reduced from 14px to 13px */
			font-weight: 500;
			color: #374151;
			margin-bottom: 6px; /* Reduced from 8px to 6px */
		}
		
		.form-input {
			width: 100%;
			padding: 12px 16px; /* Reduced from 16px 20px to 12px 16px */
			border: 2px solid #e5e7eb;
			border-radius: 10px; /* Reduced from 12px to 10px */
			font-size: 14px; /* Reduced from 16px to 14px */
			font-weight: 400;
			color: #1f2937;
			background: #ffffff;
			transition: all 0.2s ease;
			outline: none;
		}
		
		.form-input:focus {
			border-color: #3b82f6;
			box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
		}
		
		.form-input::placeholder {
			color: #9ca3af;
			font-weight: 400;
		}
		
		.password-container {
			position: relative;
		}
		
		.password-toggle {
			position: absolute;
			right: 12px; /* Reduced from 16px to 12px */
			top: 50%;
			transform: translateY(-50%);
			background: none;
			border: none;
			color: #6b7280;
			cursor: pointer;
			padding: 4px;
			font-size: 14px; /* Added smaller font size */
		}
		
		.form-options {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 24px; /* Reduced from 32px to 24px */
			flex-wrap: wrap;
			gap: 12px; /* Reduced from 16px to 12px */
		}
		
		.checkbox-container {
			display: flex;
			align-items: center;
			gap: 6px; /* Reduced from 8px to 6px */
		}
		
		.checkbox-container input[type="checkbox"] {
			width: 16px; /* Reduced from 18px to 16px */
			height: 16px; /* Reduced from 18px to 16px */
			accent-color: #3b82f6;
		}
		
		.checkbox-label {
			font-size: 13px; /* Reduced from 14px to 13px */
			color: #6b7280;
			font-weight: 400;
		}
		
		.forgot-link {
			font-size: 13px; /* Reduced from 14px to 13px */
			color: #3b82f6;
			text-decoration: none;
			font-weight: 500;
			transition: color 0.2s ease;
		}
		
		.forgot-link:hover {
			color: #2563eb;
			text-decoration: underline;
		}
		
		.login-button {
			width: 100%;
			padding: 12px 20px; /* Reduced from 16px 24px to 12px 20px */
			background: linear-gradient(135deg, #3b82f6, #2563eb);
			color: white;
			border: none;
			border-radius: 10px; /* Reduced from 12px to 10px */
			font-size: 14px; /* Reduced from 16px to 14px */
			font-weight: 600;
			cursor: pointer;
			transition: all 0.2s ease;
			box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
		}
		
		.login-button:hover {
			background: linear-gradient(135deg, #2563eb, #1d4ed8);
			transform: translateY(-1px);
			box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
		}
		
		.login-button:active {
			transform: translateY(0);
		}
		
		.error-message {
			color: #ef4444;
			font-size: 12px; /* Reduced from 14px to 12px */
			margin-top: 6px; /* Reduced from 8px to 6px */
			font-weight: 500;
		}
		
		.has-error .form-input {
			border-color: #ef4444;
			box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
		}
		
		.footer-text {
			text-align: center;
			margin-top: 24px; /* Reduced from 32px to 24px */
			font-size: 12px; /* Reduced from 14px to 12px */
			color: #6b7280;
		}
		
		/* Responsive Design */
		@media (max-width: 1024px) {
			.illustration-section {
				display: none;
			}
			
			.form-section {
				max-width: 100%;
				flex: 1;
				/* Keep the same background on mobile */
				background: linear-gradient(135deg, #e8f2ff 0%, #f0f4ff 50%, #e6f0ff 100%);
				/* FIXED: Remove justify-content center to prevent moving */
				justify-content: flex-start;
				padding-top: 60px; /* Add top padding instead */
			}
			
			.auth-container {
				/* Ensure mobile has the same background */
				background: linear-gradient(135deg, #e8f2ff 0%, #f0f4ff 50%, #e6f0ff 100%);
				/* FIXED: Remove flex alignment that causes movement */
				align-items: flex-start;
			}
			
			/* Show mobile student materials */
			.mobile-student-material {
				display: block;
			}
		}
		
		@media (max-width: 768px) {
			.form-section {
				padding: 16px; /* Reduced from 20px to 16px */
				/* Maintain desktop background on mobile */
				background: linear-gradient(135deg, #e8f2ff 0%, #f0f4ff 50%, #e6f0ff 100%);
				/* FIXED: Ensure no vertical centering */
				justify-content: flex-start;
				padding-top: 40px;
			}
			
			.form-container {
				padding: 24px 20px; /* Reduced from 32px 24px to 24px 20px */
			}
			
			.brand-title {
				font-size: 20px; /* Reduced from 28px to 20px */
			}
			
			.form-options {
				flex-direction: column;
				align-items: flex-start;
				gap: 10px; /* Reduced from 12px to 10px */
			}
			
			/* Show background decorations on mobile too */
			.bg-decoration {
				display: block;
			}
			
			.logo-container img {
				width: 50px; /* Reduced from 60px to 50px on mobile */
				height: 50px; /* Reduced from 60px to 50px on mobile */
			}
			
			/* Show mobile student materials */
			.mobile-student-material {
				display: block;
			}
		}
		
		/* Ensure mobile has desktop background */
		@media (max-width: 480px) {
			html, body {
				background: linear-gradient(135deg, #e8f2ff 0%, #f0f4ff 50%, #e6f0ff 100%) !important;
				/* FIXED: Prevent scrolling that causes movement */
				overflow: hidden;
				height: 100vh;
			}
			
			.auth-container {
				background: linear-gradient(135deg, #e8f2ff 0%, #f0f4ff 50%, #e6f0ff 100%) !important;
				/* FIXED: Prevent any movement */
				height: 100vh;
				overflow: hidden;
			}
			
			.form-section {
				background: rgba(255, 255, 255, 0.8) !important;
				backdrop-filter: blur(10px) !important;
				padding: 12px; /* Further reduced for small mobile */
				/* FIXED: Absolute positioning to prevent movement */
				position: absolute;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				justify-content: center;
				align-items: center;
			}
			
			.form-container {
				padding: 20px 16px; /* Further reduced for small mobile */
			}
			
			.brand-title {
				font-size: 18px; /* Further reduced for small mobile */
			}
			
			/* Show mobile student materials */
			.mobile-student-material {
				display: block;
			}
		}
		
		/* Loading animation */
		.slideIn {
			animation: slideInUp 0.6s ease-out;
		}
		
		@keyframes slideInUp {
			from {
				opacity: 0;
				transform: translateY(30px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}
	</style>
</head>
<body>
	<div class="auth-container">
		<!-- Background decorations -->
		<div class="bg-decoration bg-decoration-1"></div>
		<div class="bg-decoration bg-decoration-2"></div>
		<div class="bg-decoration bg-decoration-3"></div>
		<div class="bg-decoration bg-decoration-4"></div>
		
		<!-- Mobile Student Materials Background -->
		<div class="mobile-student-material mobile-pen mobile-pen-1"></div>
		<div class="mobile-student-material mobile-pen mobile-pen-2"></div>
		<div class="mobile-student-material mobile-pencil mobile-pencil-1"></div>
		<div class="mobile-student-material mobile-pencil mobile-pencil-2"></div>
		<div class="mobile-student-material mobile-crayon mobile-crayon-red mobile-crayon-1"></div>
		<div class="mobile-student-material mobile-crayon mobile-crayon-blue mobile-crayon-2"></div>
		<div class="mobile-student-material mobile-crayon mobile-crayon-green mobile-crayon-3"></div>
		<div class="mobile-student-material mobile-crayon mobile-crayon-yellow mobile-crayon-4"></div>
		<div class="mobile-student-material mobile-book mobile-book-red mobile-book-1"></div>
		<div class="mobile-student-material mobile-book mobile-book-blue mobile-book-2"></div>
		<div class="mobile-student-material mobile-book mobile-book-green mobile-book-3"></div>
		<div class="mobile-student-material mobile-eraser mobile-eraser-1"></div>
		<div class="mobile-student-material mobile-eraser mobile-eraser-2"></div>
		
		<!-- Left side - Illustration -->
		<div class="illustration-section">
			<!-- Educational icons -->
			<div class="edu-icon graduation-cap"></div>
			<div class="edu-icon lightbulb"></div>
			<div class="edu-icon report-card"></div>
			<div class="edu-icon gears">
				<div class="gear gear-1"></div>
				<div class="gear gear-2"></div>
			</div>
			
			<!-- Main character -->
			<div class="illustration-container">
				<div class="character">
					<div class="character-hair"></div>
					<div class="character-head"></div>
					<div class="character-body"></div>
					<div class="character-book"></div>
				</div>
			</div>
		</div>
		
		<!-- Right side - Form -->
		<div class="form-section">
			<div class="form-container slideIn">
				<div class="logo-container">
					<img src="<?=$this->application_model->getBranchImage($branch_id, 'logo')?>" alt="School Logo">
					<h1 class="brand-title"><?php echo $global_config['institute_name'];?></h1>
					<p class="brand-subtitle">Student Information System</p>
				</div>
				
				<?php echo form_open($this->uri->uri_string()); ?>
					<div class="form-group <?php if (form_error('email')) echo 'has-error'; ?>">
						<label class="form-label"><?php echo translate('username');?></label>
						<input 
							type="text" 
							class="form-input" 
							name="email" 
							value="<?php echo set_value('email');?>" 
							placeholder="Enter your username"
							autocomplete="username"
						/>
						<?php if (form_error('email')): ?>
							<div class="error-message"><?php echo form_error('email'); ?></div>
						<?php endif; ?>
					</div>
					
					<div class="form-group <?php if (form_error('password')) echo 'has-error'; ?>">
						<label class="form-label"><?php echo translate('password');?></label>
						<div class="password-container">
							<input 
								type="password" 
								class="form-input" 
								name="password" 
								placeholder="Enter your password"
								autocomplete="current-password"
								id="password-input"
							/>
							<button type="button" class="password-toggle" onclick="togglePassword()">
								<i class="far fa-eye" id="password-icon"></i>
							</button>
						</div>
						<?php if (form_error('password')): ?>
							<div class="error-message"><?php echo form_error('password'); ?></div>
						<?php endif; ?>
					</div>
					
					<div class="form-options">
						<div class="checkbox-container">
							<input type="checkbox" name="remember" id="remember">
							<label for="remember" class="checkbox-label"><?php echo translate('remember');?></label>
						</div>
						<a href="<?php echo base_url("{$this->authentication_model->getSegment(1)}forgot"); ?>" class="forgot-link">
							<?php echo translate('lose_your_password');?>
						</a>
					</div>
					
					<button type="submit" class="login-button">
						<i class="fas fa-sign-in-alt"></i>
						<?php echo translate('login');?>
					</button>
				<?php echo form_close();?>
				
				<div class="footer-text">
					<p><?php echo $global_config['footer_text'];?></p>
				</div>
			</div>
		</div>
	</div>
	
	<script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.js');?>"></script>
	<script src="<?php echo base_url('assets/vendor/jquery-placeholder/jquery-placeholder.js');?>"></script>
	
	<script>
		function togglePassword() {
			const passwordInput = document.getElementById('password-input');
			const passwordIcon = document.getElementById('password-icon');
			
			if (passwordInput.type === 'password') {
				passwordInput.type = 'text';
				passwordIcon.className = 'far fa-eye-slash';
			} else {
				passwordInput.type = 'password';
				passwordIcon.className = 'far fa-eye';
			}
		}
	</script>

	<?php
	$alertclass = "";
	if($this->session->flashdata('alert-message-success')){
		$alertclass = "success";
	} else if ($this->session->flashdata('alert-message-error')){
		$alertclass = "error";
	} else if ($this->session->flashdata('alert-message-info')){
		$alertclass = "info";
	}
	if($alertclass != ''):
		$alert_message = $this->session->flashdata('alert-message-'. $alertclass);
	?>
		<script type="text/javascript">
			swal({
				toast: true,
				position: 'top-end',
				type: '<?php echo $alertclass;?>',
				title: '<?php echo $alert_message;?>',
				confirmButtonClass: 'btn btn-default',
				buttonsStyling: false,
				timer: 8000
			})
		</script>
	<?php endif; ?>
</body>
</html>
