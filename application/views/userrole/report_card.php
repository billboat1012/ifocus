<div class="row">
<div class="col-md-12">
<section class="panel">
    <header class="panel-heading">

        <h4 class="panel-title"><i class="fas fa-id-card"></i> <?=translate('report_card')?></h4>

    </header>

    <div class="panel-body">
        

<?php

$student_id = $stu['student_id'];
$branch_id_this = $stu['branch_id'];
$exams = $this->exam_model->get_unique_exam_ids($student_id, $branch_id_this);
?>

<?php echo form_open($this->uri->uri_string() , array('class' => 'validate')); ?>
<div class="col-md-<?=$widget?> mb-sm">
    <div class="form-group">
        <label class="control-label"><?=translate('exam')?> <span class="required">*</span></label>

        <?php
        if (!empty($exams)) {
            $arrayExam = array("" => translate('select')) + $exams;
        } else {
            $arrayExam = array("" => translate('Nothing here yet'));
        }

        echo form_dropdown(
            "exam_id",
            $arrayExam,
            set_value('exam_id'),
            "class='form-control' id='exam_id' required data-plugin-selectTwo data-width='100%'"
        );
        ?>

        <span class="error"><?php echo form_error('exam_id'); ?></span>
    </div>
</div>

<!-- Hidden fields to send additional data -->
<?php
$data = array(
    'class_id' => $stu['class_id'],
    'session_id' => get_session_id(),
    'student_id' => $stu['student_id']
);
echo form_hidden($data);
?>

<div class="row mb-3">
    <div class="col-md-offset-10 col-md-2">
        <button type="submit" name="search" value="1" class="btn btn btn-default btn-block"> <i class="fas fa-filter"></i> <?=translate('filter')?></button>
    </div>
</div>
<?php echo form_close(); ?>
</div>
</section>
<?php
    
    

    if(isset($filteredexam)) :
	if (!empty($filteredexam)) {
    
	    
		foreach ($filteredexam as  $erow) {

			$examID = $erow['exam_id'];

	
	$markTemp = [];
		
		foreach($exams as $key => $value){
    $markTemp = $this->userrole_model->getTemplateByBranch($stu['branch_id'], $key);
    }
    
    $marksheet_template = [];
    
    foreach($markTemp as $temp){
       $marksheet_template = $this->marksheet_template_model->getTemplate($temp->id, $stu['branch_id']); 
    };
    
    $result = $this->exam_model->getStudentReportCard($stu['student_id'], $erow['exam_id'], get_session_id(), $stu['class_id']);
		
		$marks = $this->exam_model->getMarksForPlayGroupStudent($stu['student_id'], $erow['exam_id']);
		
		$classAverage = $this->exam_model->getExamStudentScores( $branch_id_this, $stu['class_id'], $erow['exam_id'], get_session_id());
		
// 		echo "<pre>";
// 		print_r($learnersAverages);
// 		echo "</pre>"
?>

<style type="text/css">

    .panel {
    overflow-x: auto;
    overflow-y: hidden; 
    white-space: nowrap; 
}

.panel-body {
    width: 100%;
}

.mark-container {
    min-width: 100%;
}

.table {
    width: 100%;
    table-layout: auto;
}

.table th, .table td {
    white-space: nowrap; 
}

	
	   .mark-container {
        height: 100%;
        min-width: 1000px;
        position: relative;
        z-index: 2;
        margin: 0 auto;
        font-size: 12px;
        padding: 20px;
        max-width: 1200px;
    }

    /* Scaling for smaller screens */
    @media (max-width: 1200px) {
        .mark-container {
            /* Scaling factor */
            transform: scale(0.8);
            transform-origin: top left;
            width: 90%; /* Adjust width as needed */
        }
    }

    @media (max-width: 992px) {
        .mark-container {
            transform: scale(0.7);
            transform-origin: top left;
            width: 80%; /* Adjust width as needed */
        }
    }
    
    
    @media (max-width: 768px) {
        .mark-container {
            transform: scale(0.38);
            transform-origin: top left;
            width: 50%; /* Adjust width as needed */
        }
    }

    @media (max-width: 573px) {
        .mark-container {
            transform: scale(0.3);
            transform-origin: top left;
            width: 60%; /* Adjust width as needed */
        }
    }
	
	.branch-name h4 {
	    font-size: 18px;
	}
	.marksheet-head {
	    width: 85% !important;
	    float: left;
	}
	.marksheet-user {
        width: 15% !important;
        text-align: right !important;
        margin: 0 !important;
        float: left;
    }
	.marksheet-head table.table.table-bordered {
	    margin: 0 !important;
	    border: 2px solid #0F335C;
	    width: 100% !important;
	}
	.marksheet-header {
	    margin: 10px 0;
	    float: left;
	    width: 100%;
	}
	.marksheet-user img {
	    height: 107px;
	}
	table.academic-record-heading {
	    border: 2px solid #0F335C;
	    margin-bottom: 0;
	    text-align: center;
	    background-color: #0F335C;
	    color: #fff;
	}
	table.academic-record-heading h5 {
    margin: 5px 0;
    font-size: 18px;
}
.pass-marking > div {
    float: left;
    text-align: center;
    color: #000;
    font-size: 14px;
    margin-bottom: 20px;
}
table {
    border: 2px solid #0F335C !important;
}
.branch-name h4 {
    color: #0F335C;
}
.row.company-header strong {
    color: #0F335C;
}
.row.company-header {
    color: #AD00AB;
}
table th, table td, table tr {
    border-color: #eee;
}
.table-bordered {
    border-color: #0F335C !important;
    margin-bottom: 10px;
}
table.template-footer {
    border-bottom: 0;
    border-left: 0;
    border-right: 0;
    margin-bottom: 15px;
    float: left;
    width: 100%;
    border-top: 2px solid #ccc !important;
    border-bottom: none !important;
    border-left: none !important;
    border-right: none !important;
}

	table {

	    border-collapse: collapse;

	    width: 100%;

	    margin: 0 auto;

	}
.background-img {
    position: absolute;
    left: 0;
    right: 0;
    top: 40%;
    margin: auto;
    z-index: -9;
    opacity: .3;
    background-repeat: no-repeat;
    text-align: center;
}
.background-img img {
	width: 500px;
	height: auto;
}


	@page {

		margin: -2px;

		size: <?php echo $marksheet_template['page_layout'] == 1 ? 'portrait' : 'landscape'; ?>;

	}



	

		.pagebreak {

			clear: both;

			page-break-before: always;

		}

		.table-bordered > thead > tr > th,

		.table-bordered > tbody > tr > th,

		.table-bordered > tfoot > tr > th,

		.table-bordered > thead > tr > td,

		.table-bordered > tbody > tr > td,

		.table-bordered > tfoot > tr > td {

		    border-color: #000 !important;

		    background: transparent !important;

		}
.modal-footer {
    clear: both;
}



	.background {

		position: absolute;

		z-index: 0;

		width: 100%;

		height: 100%;

	<?php if (empty($marksheet_template['background'])) { ?>

		background: #fff;

	<?php } else { ?>

		background-repeat: no-repeat !important;

		background-size: 100% 100% !important;

	<?php } ?>

	}

</style>
            <?php
            
        $extINTL = extension_loaded('intl');

		$student = $result['student'];

		$getMarksList = $result['exam'];



		$rankDetail = $this->db->where(array('exam_id ' => $erow['exam_id'], 'enroll_id  ' => $student['enrollID']))->get('exam_rank')->row();

		$getExam = $this->db->where(array('id' => $erow['exam_id']))->get('exam')->row_array();

		$schoolYear = get_type_name_by_id('schoolyear', get_session_id(), 'school_year');


		$extendsData = [];

		$extendsData['schoolYear'] = $schoolYear;

		$extendsData['exam_name'] = $getExam['name'];
		
		$extendsData['term'] = $this->marksheet_template_model->getExamTerm($getExam['term_id']);

		$extendsData['teacher_comments'] = empty($rankDetail->teacher_comments) ? '' : $rankDetail->teacher_comments;

		$extendsData['principal_comments'] = empty($rankDetail->principal_comments) ? '' : $rankDetail->principal_comments;
		
		if($getExam['branch_id'] == $this->config->item('branch_for_special_feature')){
		$extendsData['hostel_comment'] = empty($rankDetail->hostel_comment) ? '' : $rankDetail->hostel_comment;
		}

		$header_content = $this->marksheet_template_model->tagsReplace($student, $marksheet_template, $extendsData, 'header_content');

		$footer_content = $this->marksheet_template_model->tagsReplace($student, $marksheet_template, $extendsData, 'footer_content');
		

		$branchDetail = $this->db->where(array('id ' => $getExam['branch_id']))->get('branch')->row();
		
		
		$headerBgColor = $marksheet_template['header_bg_color'];
		$headerTextColor = $marksheet_template['header_text_color'];
		$schoolName = $marksheet_template['school_name'];
		
		?>


<section class="panel" style="width: 100%">		
     <header class="panel-heading" >
                <h4 class="panel-title"><?=$this->application_model->exam_name_by_id($examID);?></h4>
                
                <?php echo form_open('userrole/reportCardPdf', array('class' => 'printIn')); ?>
                
                
                <input type="hidden" name="student_id" id="student_id" value="<?=$stu['student_id']?>">

				<input type="hidden" name="exam_id" value="<?=$examID?>">

				<input type="hidden" name="class_id" id="class_id" value="<?=$stu['class_id']?>">


				<input type="hidden" name="session_id" id="session_id" value="<?=get_session_id()?>">

				<input type="hidden" name="branch_id" id="branch_id" value="<?=$branch_id?>">

				<input type="hidden" name="template_id" id="template_id" value="<?=$marksheet_template['id']?>">
				
				<div class="panel-btn">

						<button type="submit" class="btn btn-default btn-circle" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing" >

							<i class="fa-solid fa-file-pdf"></i> <?=translate('download')?> PDF

						</button>

						

					</div>
					<?php echo form_close(); ?>
            </header>
    <div class="panel-body" id="elem">
	<div class="mark-container">
		<div class="background-img"><img src="<?=base_url('uploads/marksheet/' . $marksheet_template['logo'])?>" /></div>
		<?php
		   $color = $this->db->where(['branch_id' => $branch_id_this])->get('front_cms_setting')->row();
		?>
       <table border="0" class="row company-header" 
    style="border-color: transparent !important; width: 100%; min-height: 250px; text-align: center; margin-bottom: 20px; background-color: <?= $headerBgColor ?: '#0F335C' ?>;">
            <tr>
                <td style="width: 20%; vertical-align: middle; padding: 20px;">
                    <img width="150" style="display: block; margin: auto;" 
                        src="<?= base_url('uploads/marksheet/' . $marksheet_template['logo']) ?>" />
                </td>
                <?php
                $textColor='white';
                if(!$color){
                    $textColor='black';
                };
                ?>
                <td style="width: 80%; text-align: center; padding: 50px; color: <?=$headerTextColor ?: '#fff';?>;">
                    <h2 style="margin: 0; font-size: 26px; font-weight: bold; ">
                        <?= $schoolName ?: $branchDetail->name; ?>
                    </h2>
                    <p style="margin: 10px 0; font-size: 16px; color: <?=$headerTextColor ?: '#fff';?>;">
                        <?= $branchDetail->address; ?>
                    </p>
                    <p style="margin: 10px 0; font-size: 16px; color: <?=$headerTextColor ?: '#fff';?>;">
                        <span style="font-weight: bold;">TEL:</span> <?= $branchDetail->mobileno; ?>  
                        | <span style="font-weight: bold;">EMAIL:</span> <?= $branchDetail->email; ?>  
                        | <span style="font-weight: bold;">SESSION:</span> <?= $schoolYear; ?>
                    </p>
                </td>
            </tr>
        </table>
        <div>
            <hr style="background-color: <?= $headerBgColor ?: '#0F335C' ?> !important; height: 10px; border: none;">
        </div>

		<div class="empty-space" style=" ,height: 20px; float: left; width: 100%;clear: both;display: block;"></div>

		<?php echo $header_content ?>
		<div class="empty-space" style="height: 20px;float: left; width: 100%;clear: both;display: block;"></div>
		
		
        <?php if($getExam['type_id'] == 4) : $exams = $result['exam']; ?>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <th style="border: 1px solid #000; padding: 5px; text-align: center;">
                <tr style="border: 1px solid #000 !important">
                    <th colspan="11" class="text-center" style="background-color: <?= $headerTextColor ?: '#0F335C' ?> !important;-webkit-print-color-adjust: exact;text-align: center;color: <?= $headerBgColor ?: '#fff' ?> !important;font-weight: bold;font-size: 14px; padding: 6px;">STUDENT ACADEMIC PERFORMANCE RECORD</th>
                </tr>
            </th>
        </table>
        <?php foreach($exams as $exam){ 
        $subSubject = $this->exam_model->getSubSubjectId($exam['subject_id']);
        ?>
        <table>
            <tr>
                <th style="border: 1px solid #000; padding: 5px; text-align: center;">
                <?php echo $exam['subject_name']; ?>
                </th>
                <?php 
                $mark_distribution = json_decode($exam['mark_distribution'], true);
                $keys = array_keys($mark_distribution);
                foreach($keys as $key){ ?>
                <th style="border: 1px solid #000; padding: 5px; text-align: center;">
                    <?php echo get_type_name_by_id('exam_mark_distribution' ,$key); ?>
                </th>
                <?php }  ?>
            </tr>
            <?php foreach($subSubject as $id => $sub){ ?>
            <?php $submark = $this->exam_model->getMarkBySubSubjectID($student_id, $exam['subject_id'], $examID, $id);   ?>
            <tr>
                    <th style="border: 1px solid #000; padding: 5px; text-align: center;">
                    <?php echo $sub; ?>
                    </th>
                    <?php foreach($keys as $key){ ?>
                    <th style="border: 1px solid #000; padding: 5px; text-align: center;">
                        <?php if($key == $submark){ ?>
                        ✔️
                        <?php } ?>
                    </th>
                    <?php } ?>
            </tr>
            <?php } ?>
        </table>
        <?php } ?>
        <?php elseif($getExam['type_id'] != 4) : ?>
		<table class="table table-condensed table-bordered mt-lg">
            <?php
            $colspan = ($student['is_third_term'] == 1) ? 13 : 11;
            ?>
			<thead>
				<tr style="border: 1px solid #000 !important">
                    <th colspan="<?=$colspan;?>" class="text-center" style="background-color: <?= $headerTextColor ?: '#0F335C' ?> !important;-webkit-print-color-adjust: exact;text-align: center;color: <?= $headerBgColor ?: '#fff' ?> !important;font-weight: bold;font-size: 14px; padding: 6px;">STUDENT ACADEMIC PERFORMANCE RECORD</th>
                </tr>

				<tr>

					<th style="font-size: 11px;">Subjects</th>

				<?php 

				$markDistribution = json_decode($getExam['mark_distribution'], true);

				foreach ($markDistribution as $id) {

					?>

					<th style="font-size: 11px;"><?php echo get_type_name_by_id('exam_mark_distribution',$id)  ?></th>

				<?php } ?>

				<?php if ($getExam['type_id'] == 1) { ?>

					<th style="font-size: 11px;">Total</th>
					
					<?php if($student['is_third_term'] == 1){ ?>
					
					<th style="font-size: 11px">1st term</th>
					
				    <th style="font-size: 11px">2nd term</th>
				    
				    <th style="font-size: 11px">Session</br>Average</th>
				    
				    <?php }; ?>

				<?php } elseif($getExam['type_id'] == 2) { ?>

					<th style="font-size: 11px;">Grade</th>

					<th style="font-size: 11px;">Point</th>

<?php if ($marksheet_template['remark'] == 1) { ?>

					<th style="font-size: 11px;">Remark</th>

<?php } ?>

				<?php } elseif ($getExam['type_id'] == 3) { ?>

					<th style="font-size: 11px;">Total</th>
					
					<?php if($student['is_third_term'] == 1){ ?>
					
					<th style="font-size: 11px">1st term</th>
					
				    <th style="font-size: 11px">2nd term</th>
				    
				    <th style="font-size: 11px">Session</br>Average</th>
				    
				    <?php }; ?>

					<th style="font-size: 11px;">Grade</th>

					<th style="font-size: 11px;">Point</th>
					
					<?php if ($marksheet_template['subject_position'] == 1) { ?>

					<th style="font-size: 11px;">Subject Position</th>

<?php } ?>

<?php if ($marksheet_template['remark'] == 1) { ?>

					<th style="font-size: 11px;">Remark</th>

<?php } ?>

				<?php } ?>



				</tr>

			</thead>

			<tbody>

			<?php

			$colspan = count($markDistribution) + 1;

			$total_grade_point = 0;

			$grand_obtain_marks = 0;

			$grand_full_marks = 0;

			$result_status = 1;

			foreach ($getMarksList as $row) {

				?>

				<tr>

					<td valign="middle" width="22%"><?=$row['subject_name']?></td>

				<?php 

				$total_obtain_marks = 0;

				$total_full_marks = 0;

				$fullMarkDistribution = json_decode($row['mark_distribution'], true);

				$obtainedMark = json_decode($row['get_mark'], true);

				foreach ($fullMarkDistribution as $i => $val) {

					$obtained_mark = floatval($obtainedMark[$i]);

					$fullMark = floatval($val['full_mark']);

					$passMark = floatval($val['pass_mark']);

					if ($obtained_mark < $passMark) {

						$result_status = 0;

					}



					$total_obtain_marks += $obtained_mark;

					$obtained = $row['get_abs'] == 'on' ? 'Absent' : $obtained_mark;

					$total_full_marks += $fullMark;

					?>

				<?php if ($getExam['type_id'] == 1 || $getExam['type_id'] == 3){ ?>

					<td valign="middle">

						<?php 

							if ($row['get_abs'] == 'on') {

								echo 'Absent';

							} else {

								echo $obtained_mark;

							}

						?>

					</td>

				<?php } if ($getExam['type_id'] == 2){ ?>

					<td valign="middle">

						<?php 

							if ($row['get_abs'] == 'on') {

								echo 'Absent';

							} else {

								$percentage_grade = ($obtained_mark * 100) / $fullMark;

								$grade = $this->exam_model->get_grade($percentage_grade, $getExam['branch_id']);

								echo $grade['name'];

							}

						?>

					</td>

				<?php } ?>

				<?php

				}

				$grand_obtain_marks += $total_obtain_marks;

				$grand_full_marks += $total_full_marks;

				?>

				<?php if($getExam['type_id'] == 1 || $getExam['type_id'] == 3) { ?>

					<td valign="middle"><?=$total_obtain_marks . "/" . $total_full_marks?></td>
					
					<?php if($student['is_third_term'] == 1){ ?>
					
					<td valign="middle"><?=$row['first_term_total']?></td>
					
					<td valign="middle"><?=$row['second_term_total']?></td>
					
					<?php }; ?>

				<?php } if($getExam['type_id'] == 2) { 

					$colspan += 1;

					$percentage_grade = ($total_obtain_marks * 100) / $total_full_marks;

					$grade = $this->exam_model->get_grade($percentage_grade, $getExam['branch_id']);

					$total_grade_point += $grade['grade_point'];

					?>

					<td valign="middle"><?=$grade['name']?></td>

					<td valign="middle"><?=number_format($grade['grade_point'], 2, '.', '')?></td>

<?php if ($marksheet_template['remark'] == 1) { ?>

					<td valign="middle"><?=$grade['remark']?></td>

<?php } ?>

				<?php } if ($getExam['type_id'] == 3) {

					$colspan += 2;

					$percentage_grade = ($total_obtain_marks * 100) / $total_full_marks;

					$grade = $this->exam_model->get_grade($percentage_grade, $getExam['branch_id']);

					$total_grade_point += $grade['grade_point'];

					?>

					<td valign="middle"><?=$grade['name']?></td>

					<td valign="middle"><?=number_format($grade['grade_point'], 2, '.', '')?></td>
					
						<?php if ($marksheet_template['subject_position'] == 1) {?>
                    
						<td valign="middle"><?php echo $this->exam_progress_model->getSubjectPosition($stu['class_id'], [$examID], get_session_id(), $row['subject_id'], $total_obtain_marks); ?></td>

					<?php } ?>

<?php if ($marksheet_template['remark'] == 1) { ?>

					<td valign="middle" style="color:<?php if($grade['remark']=='FAIL'){ echo 'red'; }else{ echo 'green'; } ?>;"><?=$grade['remark']?></td>

<?php } ?>

				<?php } ?>

				</tr>

			<?php } ?>

			</tbody>

		</table>
		<?php endif; ?>

		<div class="empty-space" style="height: 20px;float: left; width: 100%;clear: both;display: block;"></div>

        <?php if($marksheet_template['playgroup'] != 1){ ?>
        <?php if($getExam['type_id'] != 4) : ?>
		
		<table class="table table-condensed table-bordered mt-lg">
		<tbody>
		    
		    <tr style="border: 1px solid #000 !important">
                                <th colspan="3" class="text-center" style="background-color: <?= $headerTextColor ?: '#0F335C' ?> !important;-webkit-print-color-adjust: exact;text-align: center;color: <?= $headerBgColor ?: '#fff' ?> !important;font-weight: bold;font-size: 12px; padding: 6px;">ACADEMIC RECORDS SUMMARY</th>
                            </tr>
                            
			
			
			<?php if ($getExam['type_id'] == 1 || $getExam['type_id'] == 3) { ?>

				<tr class="text-weight-semibold">
					<td valign="top" ><strong>GRAND TOTAL:</strong> <?= $grand_obtain_marks; ?></td>
					<td valign="top" ><strong>OUT OF:</strong> <?= $grand_full_marks ?></td>
					<td valign="top" ><strong>Learners average:</strong> <?php $percentage = ($grand_obtain_marks * 100) / $grand_full_marks; echo number_format($percentage, 2, '.', '')?>%</td>
					<?php if ($getExam['type_id'] == 1 || $getExam['type_id'] == 3) { ?>

					<?php if ($marksheet_template['result'] == 1) { ?>
							<td><strong>Result</strong> :<?=$result_status == 0 ? 'Fail' : 'Promoted'; ?></td>
					<?php } } ?>
				</tr>

				<?php
			    $studentCount = $this->exam_model->searchExamStudentsByRank($stu['class_id'], get_session_id(), $examID, $branch_id_this);
		
		        $totalStudents = count($studentCount);
			?>
								<td>
                                    <strong>Class Average:</strong> 
                                    <?php echo number_format($classAverage, 2, '.', '') . '%'; ?>
                                </td>


			<?php } if ($getExam['type_id'] == 2) { ?>
					<td><strong>GPA:</strong> <?=number_format(($total_grade_point / count($getMarksList)), 2, '.', '')?></td>

			<?php } if ($getExam['type_id'] == 3) { ?>
					<td><strong>GPA:</strong> <?=number_format(($total_grade_point / count($getMarksList)), 2, '.', '')?></td>

			<?php } ?>

<?php if ($marksheet_template['position'] == 1) { ?>
					<td colspan="2"><strong>Position:</strong> <?php echo (!empty($rankDetail->rank) ? $rankDetail->rank : translate("not_generated"));?></td>

<?php } ?>

			</tbody>
		</table>
		<?php endif; ?>
	    <?php } ?>

		

		<div style="width: 100%; display: flex;">

			<div style="<?php if($getExam['type_id'] == 4){ ?> width: 100%; <?php }else{ ?> width: 50%; <?php } ?> padding-right: 15px;">

                    <?php if ($marksheet_template['attendance_percentage'] == 1) {
                    $year = explode('-', $schoolYear);
                    $this->db->select('days_present, total_days');
$this->db->where([
    'class_id'   => $stu['class_id'],
    'branch_id'  => $branch_id_this,
    'exam_id'    => $examID,
    'session_id' => get_session_id(),
    'student_id' => $student['id'],
]);
$manualAttendance = $this->db->get('attendance_update')->row_array();

if (!empty($manualAttendance)) {
    // Use manual attendance
    $totalAttendance = (int)$manualAttendance['days_present'];
    $totalWorkingDays = (int)$manualAttendance['total_days'];
} else {
    // Fallback to student_attendance
    $getTotalWorking = $this->db
        ->where(['enroll_id' => $student['enrollID']])
        ->where('YEAR(date)', $year[1], false)
        ->get('student_attendance')
        ->num_rows();

    $getTotalAttendance = $this->db
        ->where(['enroll_id' => $student['enrollID'], 'status' => 'P'])
        ->where('YEAR(date)', $year[1], false)
        ->get('student_attendance')
        ->num_rows();

    $totalAttendance = $getTotalAttendance;
    $totalWorkingDays = $getTotalWorking;
}

// Final percentage calculation
$attenPercentage = $totalWorkingDays === 0 ? '0.00' : ($totalAttendance * 100) / $totalWorkingDays;
                    ?>
                    <table class="table table-bordered table-condensed" style="width: 100%; margin: 10px 0 !important;" class="section-spacing">
                        <tbody>
                            <tr style="border: 1px solid #000 !important">
                                <th colspan="2" class="text-center" style="background-color: <?= $headerTextColor ?: '#0F335C' ?> !important;-webkit-print-color-adjust: exact;text-align: center;color: <?= $headerBgColor ?: '#fff' ?> !important;font-weight: bold;font-size: 12px; padding: 6px;">ATTENDANCE</th>
                            </tr>
                            <tr style="border: 1px solid #000 !important">
                                <th style="width: 65%; font-size: 10px; padding: 4px;">No. of times school opened</th>
                                <td style="font-size: 10px; padding: 4px;"><?=$totalWorkingDays?></td>
                            </tr>
                            <tr style="border: 1px solid #000 !important;">
                                <th style="width: 65%; font-size: 10px; padding: 4px;">No. of days attended</th>
                                <td style="font-size: 10px; padding: 4px;"><?=$totalAttendance?></td>
                            </tr>
                            <tr style="border: 1px solid #000 !important">
                                <th style="width: 65%; font-size: 10px; padding: 4px;">Attendance Percentage</th>
                                <td style="font-size: 10px; padding: 4px;"><?=number_format($attenPercentage, 2, '.', '') ?>%</td>
                            </tr>
                        </tbody>
                    </table>
                    <?php } ?>
            

			</div>

	<?php

	if ($marksheet_template['grading_scale'] == 1) {
	    if($getExam['type_id'] != 4) :

		if ($getExam['type_id'] != 1) {

			?>

			<div style="width: 50%; padding-left: 15px;">

				<table class="table table-condensed table-bordered">

					<tbody>

						<tr style="border: 1px solid #000 !important">
                                <th colspan="3" class="text-center" style="background-color: <?= $headerTextColor ?: '#0F335C' ?> !important;-webkit-print-color-adjust: exact;text-align: center;color: <?= $headerBgColor ?: '#fff' ?> !important;font-weight: bold;font-size: 12px; padding: 6px;">PERFORMANCE EVALUATION SCALE</th>
                            </tr>

						<tr>

							<th>Grade</th>

							<th>Min Percentage</th>

							<th>Max Percentage</th>

						</tr>

					<?php 

					$grade = $this->db->where('branch_id', $getExam['branch_id'])->get('grade')->result_array();

					foreach ($grade as $key => $row) {

					?>

						<tr>

							<td style="width: 30%;"><?=$row['name']?></td>

							<td style="width: 30%;"><?=$row['lower_mark']?>%</td>

							<td style="width: 30%;"><?=$row['upper_mark']?>%</td>

						</tr>

					<?php } ?>

					</tbody>

				</table>

			</div>

	<?php } endif; } ?>

		</div>


<div class="pagebreak"></div>
<table class="table table-condensed table-bordered" style="margin-top: 50px; width: 100%;  float: left;">
	<tr>
		<td style="width:33.333%">
			<table class="table table-condensed">
				<tr style="border: 1px solid #000 !important">
                    <th colspan="2" class="text-center" style="background-color: <?= $headerTextColor ?: '#0F335C' ?> !important;-webkit-print-color-adjust: exact;text-align: center;color: <?= $headerBgColor ?: '#fff' ?> !important;font-weight: bold;font-size: 12px; padding: 6px;">AFFECTIVE DOMAIN</th>
                </tr>
				<tr><td>Punctuality</td><td><?php echo $rankDetail->punctualtiy ? $rankDetail->punctualtiy : '-'; ?></td></tr>
				<tr><td>General Neatness</td><td><?php echo $rankDetail->neatness ? $rankDetail->neatness : '-'; ?></td></tr>
				<tr><td>Obedience</td><td><?php echo $rankDetail->obedience ? $rankDetail->obedience : '-'; ?></td></tr>
				<tr><td>Self Control</td><td><?php echo $rankDetail->self_control ? $rankDetail->self_control : '-'; ?></td></tr>
				<tr><td>Participation in Class</td><td><?php echo $rankDetail->participation ? $rankDetail->participation : '-'; ?></td></tr>
			</table>
		</td>
		<td valign="middle" style="width:33.333%;text-align:center;">
			<img width="200" src="<?=base_url('uploads/marksheet/' . $marksheet_template['stamp'])?>" />
		</td>
		<td style="width:33.333%">
			<table class="table table-condensed">
				<tr style="border: 1px solid #000 !important">
                    <th colspan="2" class="text-center" style="background-color: <?= $headerTextColor ?: '#0F335C' ?> !important;-webkit-print-color-adjust: exact;text-align: center;color: <?= $headerBgColor ?: '#fff' ?> !important;font-weight: bold;font-size: 12px; padding: 6px;">PSYCHOMOTOR DEVELOPMENT</th>
                </tr>
				<tr><td>Use of Intiative</td><td><?php echo $rankDetail->use_of_intiative ? $rankDetail->use_of_intiative : '-'; ?></td></tr>
				<tr><td>Handling of Tools</td><td><?php echo $rankDetail->handling ? $rankDetail->handling : '-'; ?></td></tr>
				<tr><td>Communication Skills</td><td><?php echo $rankDetail->communication ? $rankDetail->communication : '-'; ?></td></tr>
				<tr><td>Relationship with Others</td><td><?php echo $rankDetail->realtionship ? $rankDetail->realtionship : '-'; ?></td></tr>
				<tr><td>Sports & Games</td><td><?php echo $rankDetail->sports ? $rankDetail->sports : '-'; ?></td></tr>
			</table>
		</td>
	</tr>
</table>

<?php echo $footer_content;
$count++; ?>
<?php } ?>
	</div>
	</div>
	<?php }  else { ?>
		<div class="alert alert-subl mb-none text-center">

			<i class="fas fa-exclamation-triangle"></i> <?=translate('no_information_available')?>

		</div>
    <?php } ?>
    <?php endif ?>
</section>
</div>
</div>
<script>

    var exam_id = "<?=$getExam['id']?>";

	var class_id = "<?=$stu['class_id']?>";


	var session_id = "<?=get_session_id()?>";

	var template_id = "<?=$marksheet_template['id']?>";
	
	var branch_id = "<?=$getExam['branch_id']?>";


    $('form.printIn').on('submit', function(e) {

        e.preventDefault();

        var btn = $(this).find('[type="submit"]');

	        var exam_name = $('#exam_id').find('option:selected').text();

	        var class_name = $('#class_id').val();

	        var fileName = exam_name + '-' + class_name + '-Marksheet.pdf";

	        $.ajax({

	            url: $(this).attr('action'),

	            type: "POST",

	            data: $(this).serialize(),

	            cache: false,

				xhr: function () {

                    var xhr = new XMLHttpRequest();

                    xhr.onreadystatechange = function () {

                        if (xhr.readyState == 2) {

                            if (xhr.status == 200) {

                                xhr.responseType = "blob";

                            } else {

                                xhr.responseType = "text";

                            }

                        }

                    };

                    return xhr;

				},

	            beforeSend: function () {

	                btn.button('loading');

	            },

	            success: function (data, jqXHR, response) {
	                

					var blob = new Blob([data], {type: 'application/pdf'});

					var link = document.createElement('a');

					link.href = window.URL.createObjectURL(blob);

					link.download = fileName;

					document.body.appendChild(link);

					link.click();

					document.body.removeChild(link);

					btn.button('reset');

	            },

	            error: function (response) {

	                btn.button('reset');

	                alert("An error occured, please try again");
	                

	            },

	            complete: function () {

	                btn.button('reset');

	            }

	        });

    });
    
    
    $(document).on('click','#printBtn',function(){

		btn = $(this);

            $.ajax({

                url: "<?php echo base_url('userrole/reportCardPrint') ?>",

                type: "POST",

                data: {

                	'exam_id' : exam_id,

                	'class_id' : class_id,


                	'session_id' : session_id,

                	'branch_id' : branch_id,

                	'template_id' : template_id,

                	'student_id' : $("#student_id").val(),

                },

                dataType: 'html',

                beforeSend: function () {

                    btn.button('loading');

                },

                success: function (data) {

                	fn_printElem(data, true);

                },

                error: function (response) {

	                btn.button('reset');

	                alert("An error occured, please try again");
	                
	                console.log(response);

                },

	            complete: function () {

	                btn.button('reset');

	            }

            });
            
    });


</script>