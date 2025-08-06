<?php $marksheet_template = $this->marksheet_template_model->getTemplate($templateID, $branchID); 
//echo '<pre>'; print_r($marksheet_template); echo '</pre>';
?>
<style type="text/css">

	div#quickViewStudentModal .modal-dialog {
	    width: 80%;
	}
	.template-footer {
	display:none;
	}
	.fullpagebreak {
	    float: left;
	    width: 100%;
	    height: 2px;
	    background: #ccc;
	    margin: 60px 0;
	}
	div#quickViewStudentModal header.panel-heading {
	    float: left;
	    width: 100%;
	    margin-top: 10px;
	}
	div#quickViewStudentModal .modal-body {
	    clear: both;
	}
	div#quickViewStudentModal header.panel-heading h4.panel-title {
	    float: left;
	}
	div#quickViewStudentModal header.panel-heading button.btn.btn-default {
	    float: right;
	}
	.mark-container {
	    height: 100%;
	    min-width: 1000px;
	    position: relative;
	    z-index: 2;
	    margin: 0 auto;
	    font-size: 12px;
	    padding: 20px 20px 20px 20px;
	    max-width: 1200px;
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
@media screen and (max-width: 768px) {
	div#quickViewStudentModal .modal-dialog {
	    width: 97%;
	    display: block;
	}
	.modal-content {
	    background-color: #ecedf0;
	    width: 100%;
	    overflow: scroll;
	}
}



	.table-bordered {

	    border-color: #000 !important;

	}
	.logo img {
    width: 100px;
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

		background-size: 100% !important;

	<?php } ?>

	}

</style>



<?php

$extINTL = extension_loaded('intl');
$count = 0;
if (!empty($student_array)) {
// echo '<pre>'; print_r($student_array); echo '<pre>';
	foreach ($student_array as $sc => $studentID) {

		$result = $this->exam_model->getStudentReportCard($studentID, $examID, $sessionID, $class_id);
		
		$marks = $this->exam_model->getMarksForPlayGroupStudent($studentID, $examID);
		
		 ?>
		
<?php

		$student = $result['student'];

		$getMarksList = $result['exam'];



		$rankDetail = $this->db->where(array('exam_id ' => $examID, 'enroll_id  ' => $student['enrollID']))->get('exam_rank')->row();

		$getExam = $this->db->where(array('id' => $examID))->get('exam')->row_array();

		$schoolYear = get_type_name_by_id('schoolyear', $sessionID, 'school_year');



		$extendsData = [];

		$extendsData['print_date'] = $print_date;

		$extendsData['schoolYear'] = $schoolYear;
		
		$extendsData['term'] = $this->marksheet_template_model->getExamTerm($getExam['term_id']);

		$extendsData['exam_name'] = $getExam['name'];

		$extendsData['teacher_comments'] = empty($rankDetail->teacher_comments) ? '' : $rankDetail->teacher_comments;
		
		
		if($getExam['branch_id'] == $this->config->item('branch_for_special_feature')){
		
		$extendsData['hostel_comment'] = empty($rankDetail->hostel_comment) ? '' : $rankDetail->hostel_comment;
		
		}

		$extendsData['principal_comments'] = empty($rankDetail->principal_comments) ? '' : $rankDetail->principal_comments;

		$header_content = $this->marksheet_template_model->tagsReplace($student, $marksheet_template, $extendsData, 'header_content');

		$footer_content = $this->marksheet_template_model->tagsReplace($student, $marksheet_template, $extendsData, 'footer_content');

		$branchDetail = $this->db->where(array('id ' => $getExam['branch_id']))->get('branch')->row();
		//echo '<pre>'; print_r($result); echo '</pre>';



		?>

<div style="position: relative; width: 100%; height: 100%;"> 

	<div class="mark-container">
		<div class="background-img"><img src="<?=base_url('uploads/marksheet/' . $marksheet_template['logo'])?>" /></div>
		<?php
		   $color = $this->db->where(['branch_id' => $branchID])->get('front_cms_setting')->row();
		?>
       <table border="0" class="row company-header" 
    style="border-color: transparent !important; width: 100%; min-height: 250px; text-align: center; margin-bottom: 20px; background-color: <?= $color->primary_color; ?>;">
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
                <td style="width: 80%; text-align: center; padding: 50px;">
                    <h2 style="color: <?=$textColor;?>; margin: 0; font-size: 26px; font-weight: bold;">
                        <?= $branchDetail->name; ?>
                    </h2>
                    <p style="margin: 10px 0; font-size: 16px; color: white;">
                        <?= $branchDetail->address; ?>
                    </p>
                    <p style="margin: 10px 0; font-size: 16px; color: white;">
                        <span style="font-weight: bold;">TEL:</span> <?= $branchDetail->mobileno; ?>  
                        | <span style="font-weight: bold;">EMAIL:</span> <?= $branchDetail->email; ?>  
                       
                    </p>
                </td>
            </tr>
        </table>
		<div class="empty-space" style="height: 20px;float: left; width: 100%;clear: both;display: block;"></div>

		<?php echo $header_content ?>
		<div class="empty-space" style="height: 20px;float: left; width: 100%;clear: both;display: block;"></div>
	

        <?php if($getExam['type_id'] == 4) : $exams = $result['exam']; ?>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <th style="border: 1px solid #000; padding: 5px; text-align: center;">
                <tr class="academic-record-heading">
					<td style="background-color: #0F335C !important;-webkit-print-color-adjust: exact;text-align: center;color: #fff !important;font-weight: bold;font-size: 14px;" colspan="11">ACADEMIC RECORDS</td>
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
                <?php } ?>
            </tr>
            <?php foreach($subSubject as $id => $sub){ ?>
            <?php $submark = $this->exam_model->getMarkBySubSubjectID($studentID, $exam['subject_id'], $examID, $id); ?>
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
				<tr class="academic-record-heading">
					<td style="background-color: #0F335C !important;-webkit-print-color-adjust: exact;text-align: center;color: #fff !important;font-weight: bold;font-size: 14px;" colspan="<?=$colspan;?>">ACADEMIC RECORDS</td>
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
					
					<th style="font-size: 11px">1st term <br/> (100)</th>
					
				    <th style="font-size: 11px">2nd term <br/> (100)</th>
				    
				    <th style="font-size: 11px">Session </br>Average</th>
				    
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
					
					<th style="font-size: 11px">1st term <br/> (100)</th>
					
				    <th style="font-size: 11px">2nd term <br/> (100)</th>
					
				    <th style="font-size: 11px">Session </br>Average</th>
				    
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

					<td valign="middle"><?=$total_obtain_marks?></td>
					
					<?php if($student['is_third_term'] == 1){ ?>
					
					<td valign="middle"><?=$row['first_term_total']?></td>
					
					<td valign="middle"><?=$row['second_term_total']?></td>
					
					<td valign="middle"><?=$row['session_average']?></td>
					
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

						<td valign="middle"><?php echo $this->exam_progress_model->getSubjectPosition($student['class_id'], [$examID], $sessionID, $row['subject_id'], $total_obtain_marks); ?></td>

					<?php } ?>

<?php if ($marksheet_template['remark'] == 1) { ?>

					<td valign="middle" style="color:<?php if($grade['remark']=='FAIL'){ echo 'red'; }else{ echo 'green'; } ?> !important;"><?=$grade['remark']?></td>

<?php } ?>

				<?php } ?>

				</tr>

			<?php } ?>

			</tbody>

		</table>
		<?php endif; ?>

		<div class="empty-space" style="height: 20px;float: left; width: 100%;clear: both;display: block;"></div
		
		    <?php if($result['first_term_total'] && $result['second_term_total']){ ?>
        <table class="table table-condensed table-bordered">
        		<tbody>
        			<tr style="border: 1px solid #000 !important">
            <th colspan="3" class="text-center" style="background-color: <?= $headerTextColor ?: '#0F335C' ?> !important;-webkit-print-color-adjust: exact;text-align: center;color: <?= $headerBgColor ?: '#fff' ?> !important;font-weight: bold;font-size: 12px; padding: 3px;">PAST RECORDS TOTALS</th>
                                    </tr>
        				<tr class="text-weight-semibold" style="border: 1px solid #000 !important">
        					<td valign="top" ><strong>1ST TERM TOTAL:</strong></td>
        					<td valign="top" ><strong><?= $result['first_term_total']; ?></strong></td>
        				</tr>
        				<tr class="text-weight-semibold" style="border: 1px solid #000 !important">
        				    <td valign="top" ><strong>2ND TERM TOTAL:</strong></td>
        					<td valign="top"><strong><?= $result['second_term_total'] ?></strong></td>

        				</tr>
                </tbody>
        </table>
    <?php } ?>
		

        <?php if($marksheet_template['playgroup'] != 1){ ?>
        <?php if($getExam['type_id'] != 4) : ?>
		
		<table class="table table-condensed table-bordered mt-lg">
		<tbody>
			<tr class="academic-record-heading">
				<td style="background-color: #0F335C !important;-webkit-print-color-adjust: exact;text-align: center;color: #fff !important;font-weight: bold;font-size: 14px;" colspan="4">ACADEMIC RECORDS SUMMARY</td>
			</tr>
			<?php if ($getExam['type_id'] == 1 || $getExam['type_id'] == 3) { ?>

				<tr class="text-weight-semibold">
					<td valign="top" ><strong>TOTAL SCORE:</strong> <?= $grand_obtain_marks; ?></td>
					<td valign="top" ><strong>OUT OF:</strong> <?= $grand_full_marks ?></td>
					<td valign="top" ><strong>Class Average:</strong> <?php $percentage = ($grand_obtain_marks * 100) / $grand_full_marks; echo number_format($percentage, 2, '.', '')?>%</td>
					<?php if ($getExam['type_id'] == 1 || $getExam['type_id'] == 3) { ?>

					<?php if ($marksheet_template['result'] == 1) { ?>
							<td><strong>Result</strong> :<?=$result_status == 0 ? 'Fail' : 'Promoted'; ?></td>
					<?php } } ?>
				</tr>

			<?php if ($extINTL == true) { ?>
				<td><strong>TOTAL SCORE IN WORDS:</strong>
					<?php
					$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
					echo ucwords($f->format($grand_obtain_marks));
					?>
				</td>
			<?php } ?>

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

<?php

if ($marksheet_template['attendance_percentage'] == 1) {

					$year = explode('-', $schoolYear);

					// First, try fetching from manual_attendance
$this->db->select('days_present, total_days');
$this->db->where([
    'class_id'   => $class_id,
    'branch_id'  => $branchID,
    'exam_id'    => $examID,
    'session_id' => $sessionID,
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

				<table class="table table-bordered table-condensed">

					<tbody>

						<tr>

							<th colspan="2" class="text-center" style="background-color: #0F335C !important;-webkit-print-color-adjust: exact;text-align: center;color: #fff !important;font-weight: bold;font-size: 14px;">Attendance</th>

						</tr>

						<tr>

							<th style="width: 65%;">No. of times school opened</th>

							<td><?=$totalWorkingDays?></td>

						</tr>

						<tr>

							<th style="width: 65%;">No. of days attended</th>

							<td><?=$totalAttendance?></td>

						</tr>

						<tr>

							<th style="width: 65%;">Attendance Percentage</th>

							<td><?=number_format($attenPercentage, 2, '.', '') ?>%</td>

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

						<tr>

							<th colspan="3" class="text-center" style="background-color: #0F335C !important;-webkit-print-color-adjust: exact;text-align: center;color: #fff !important;font-weight: bold;font-size: 14px;">Grading Scale</th>

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

<?php } ?>
<div class="pagebreak"></div>
<table class="table table-condensed table-bordered" style="margin-top: 50px; width: 100%;  float: left;">
	<tr>
		<td style="width:33.333%">
			<table class="table table-condensed">
				<tr class="academic-record-heading">
					<td style="background-color: #0F335C !important;-webkit-print-color-adjust: exact;text-align: center;color: #fff !important;font-weight: bold;font-size: 14px;" colspan="2">Affective Domain</td>
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
				<tr class="academic-record-heading">
					<td style="background-color: #0F335C !important;-webkit-print-color-adjust: exact;text-align: center;color: #fff !important;font-weight: bold;font-size: 14px;" colspan="2">Psychomotor Development</td>
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

	</div>

</div>

	<?php if($count < count($student_array)) { ?>
<div class="fullpagebreak"></div>
<?php } ?>

<?php } ?>