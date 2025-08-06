<style type="text/css">
	body {
    font-size: 13px;
    line-height: 18px;
    font-family: 'Raleway', sans-serif;
    color: var(--thm-text);
    background: #fff;
}
	@media print {
		.pagebreak {
			page-break-before: always;
		}
		
	}
	.blurred-background::before {
    content: "";
    display: block;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black overlay */
    z-index: 0;
}
	.mark-container {
	    background: #fff;
	    width: 1000px;
	    position: relative;
	    z-index: 2;
	    margin: 0 auto;
	    padding: 20px 30px;
	}
	table {
	    border-collapse: collapse;
	    width: 100%;
	    margin: 0 auto;
	}
</style>
<?php
		$student = $result['student'];  
		$getMarksList = $result['exam']; 
		$rankDetail = $this->db->where(array('exam_id ' => $examID, 'enroll_id  ' => $student['enrollID']))->get('exam_rank')->row();
		$getExam = $this->db->where(array('id' => $examID))->get('exam')->row_array();
		$getSchool = $this->db->where(array('id' => $getExam['branch_id']))->get('branch')->row_array();
		$schoolYear = get_type_name_by_id('schoolyear', $sessionID, 'school_year');
		
		?>
	<!--	style="background-position: center;background-repeat: no-repeat;background-size: contain;background-color: rgba(255, 255, 255, 0.5);justify-content: center;align-items: center;background-image:  url('<?= $this->application_model->getBranchImage($getExam['branch_id'], 'bg-logo') ?>')"-->
	<div class="mark-container" style="overflow: hidden;  position: relative;">
		<img class="demo-bg" src="<?= $this->application_model->getBranchImage($getExam['branch_id'], 'bg-logo') ?>" alt="" style="opacity: 0.09; position: absolute; left: 0; top: 0; width: 100%; height: 100%;">
		<table border="0" style="margin-top: 20px; height: 100px;">
			<tbody>
				<tr>
				<td style="width:60%;vertical-align: top;"><img style="max-width:250px;" src="<?=$this->application_model->getBranchImage($getExam['branch_id'], 'report-card-logo')?>"></td>
				<td style="width:35%;vertical-align: top;">
					<table align="left" class="table-head text-left" >
						<tbody>
							<tr><th style="font-size: 26px;" class="text-left"><?=$getSchool['school_name']?></th></tr>
							<tr><th style="font-size: 14px; padding-top: 4px;" class="text-left">Academic Session : <?=$schoolYear?></th></tr>
							<tr><td><b>Address:</b><?=$getSchool['address']?></td></tr>
							<tr><td><b>Phone:</b><?=$getSchool['mobileno']?></td></tr>
							<tr><td><b>Email:</b><?=$getSchool['email']?></td></tr>
						</tbody>
					</table>
				</td>
				</tr>
			</tbody>
		</table>
		<div style="width: 100%;">
			<div style="width: 80%; float: left;">
				<table class="table table-bordered" style="margin-top: 20px;border: 2px solid black">
					<tbody>
						<tr>
							<th style="font-size: 12px;">Name</td>
							<td><?=$student['first_name'] . " " . $student['last_name']?></td>
							<th style="font-size: 12px;">Register No</td>
							<td><?=$student['register_no']?></td>
							<th style="font-size: 12px;">Roll Number</td>
							<td><?=$student['roll']?></td>
						</tr>
						<tr>
							<th style="font-size: 12px;">Gender</td>
							<td><?=ucfirst($student['gender'])?></td>
							<th style="font-size: 12px;">Admission Date</td>
							<td><?=_d($student['admission_date'])?></td>
							<th style="font-size: 12px;">Date of Birth</td>
							<td><?=_d($student['birthday'])?></td>
						</tr>
						<tr>
							<th style="font-size: 12px;">Class</td>
							<td><?=$student['class_name'] . ")"?></td>
							<th style="font-size: 12px;">Term Close</td>
							<td><?=_d($getExam['end_terms'])?></td>
							<th style="font-size: 12px;">Next Term</td>
							<td><?=_d($getExam['next_terms'])?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div style="width: 20%; float: left; text-align: right;">
				<img src="<?php echo get_image_url('student', $student['photo']); ?>" style="margin-top: 20px; border-radius: 10px;object-fit: fill;" height="110px" width="94%">
			</div>
		</div>
		<table class="table table-condensed table-bordered mt-lg" style="border: 2px solid black">
		  	<thead style="margin-bottom: 0rem;">
			  <tr><th style="background-color: #cdcdcd;color:black" class="text-center">ACADEMIC RECORDS</th></tr>
			</thead>
		</table>
		<table class="table table-condensed table-bordered mt-lg" style="border: 2px solid black">
			<thead>
				
				<tr>
					<th>Subjects</th>
				<?php 
				$markDistribution = json_decode($getExam['mark_distribution'], true);
				foreach ($markDistribution as $id) {
					?>
					<th><?php echo get_type_name_by_id('exam_mark_distribution',$id)  ?></th>
				<?php } ?>
				<?php if ($getExam['type_id'] == 1) { ?>
					<th>Total</th>
				<?php } elseif($getExam['type_id'] == 2) { ?>
					<th>Grade</th>
					<th>Subject Position</th>
					<th>Remark</th>
				<?php } elseif ($getExam['type_id'] == 3) { ?>
					<th>Total</th>
					<th>Grade</th>
					<th> Subject Position</th> <!---->
					<th>Remark</th>
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
					<td valign="middle" width="35%"><?=$row['subject_name']?></td>
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
					$obtained = $row['get_abs'] == 'on' ? '-' : $obtained_mark;
					$total_full_marks += $fullMark;
					?>
				<?php if ($getExam['type_id'] == 1 || $getExam['type_id'] == 3){ ?>
					<td valign="middle">
						<?php 
							if ($row['get_abs'] == 'on') {
								echo '-';
							} else {
								echo $obtained_mark . '/' . $fullMark;
							}
						?>
					</td>
				<?php } if ($getExam['type_id'] == 2) { ?>
					<td valign="middle">
						<?php 
							if ($row['get_abs'] == 'on') {
								echo '-';
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
				<?php } if($getExam['type_id'] == 2) { 
					$colspan += 1;
					$percentage_grade = ($total_obtain_marks * 100) / $total_full_marks;
					$grade = $this->exam_model->get_grade($percentage_grade, $getExam['branch_id']);
					$total_grade_point += $grade['grade_point'];
					?>
					<td valign="middle"><?=$grade['name']?></td>
					<td valign="middle"><?=$grade['subject_position'];?></td>
					<td valign="middle"><?=$grade['remark']?></td>
				<?php } if ($getExam['type_id'] == 3) {
					$colspan += 2;
					$percentage_grade = ($total_obtain_marks * 100) / $total_full_marks;
					$grade = $this->exam_model->get_grade($percentage_grade, $getExam['branch_id']);
					
					$total_grade_point += $grade['grade_point'];
					?>
					<td valign="middle"><?php if($grade['name']=='F'){ echo '-'; }else{ echo $grade['name']; } ?></td>
					
					<td valign="middle"><?=$grade['subject_position'];  ?></td>
					<td valign="middle"><?php if($grade['remark']=='FAIL'){ echo '-'; }else{ echo $grade['remark']; } ?></td>
				<?php } ?>
				</tr>
			<?php } ?>
			
			</tbody>
		</table>
		<table style="width:100%; outline:none; margin-top: 10px;margin-bottom: 10px">
			<tbody>
				<tr>
					<td style="font-size: 15px; text-align:left;">70 - 100 = A (Excellent)</td>
					<td style="font-size: 15px; text-align:left;">60 - 69 = B (V.Good)</td>
					<td style="font-size: 15px; text-align:left;">50 - 59 = C(Good)</td>
					<td style="font-size: 15px; text-align:left;">40 - 49 = D (Pass)</td>
					<td style="font-size: 15px; text-align:left;">0 - 39 =F (Fail)</td>
				</tr>
			</tbody>
		</table>
		<table class="table table-condensed table-bordered mt-lg"style="border: 2px solid black">
		  	<thead style="margin-bottom: 0rem;">
			  <tr><th style="background-color: #cdcdcd;color:black" class="text-center">ACADEMIC RECORDS SUMMARY</th></tr>
			</thead>
		</table>
		<table class="table table-condensed table-bordered mt-lg"style="border: 2px solid black">
		  	<thead>
			  <?php if ($getExam['type_id'] == 1 || $getExam['type_id'] == 3) { ?>
				<tr class="text-weight-semibold">
					<td valign="middle" > <b> GRAND TOTAL : <?=$grand_obtain_marks ; ?></b></td>
					<td valign="middle"><b> OUT OF : <?= $grand_full_marks; ?></b></td>
					<td valign="middle"><b> Average : <?php $percentage = ($grand_obtain_marks * 100) / $grand_full_marks; echo number_format($percentage, 2, '.', '')?>%</b></td>
				</tr>
				</tr>
			<?php } if ($getExam['type_id'] == 2) { ?>
				<?php } if ($getExam['type_id'] == 3) { ?>
			<?php } if ($getExam['type_id'] == 1 || $getExam['type_id'] == 3) { ?>
				<tr class="text-weight-semibold">
				<td valign="middle" ><b>GRAND TOTAL IN WORDS : <?php
						$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
						echo ucwords($f->format($grand_obtain_marks));
						?></b></td>
					<!-- <td valign="middle" ><b>RESULT : <?=$result_status == 0 ? 'Fail' : 'Pass'; ?></b></td> -->
			<?php } ?>
					<td valign="middle"><b>Position : <?php echo (!empty($rankDetail->rank) ? $rankDetail->rank : translate("not_generated"));?></b></td>
					
				</tr>
			</thead>
		</table>
		
		<div style="width: 100%; float: left;">
			<table  class="table table-bordered"  style="margin-top: 20px;border: 2px solid black">
				<tbody>
					<tr>
						<!-- First Table -->
						<td style="width: 33%; text-align: right;">
							<table class="table table-condensed table-bordered mt-lg"style="border: 2px solid black">
								<thead style="margin-bottom: 0rem;">
								<tr><th style="background-color: #cdcdcd;color:black" class="text-center">AFFECTIVE DOMAIN</th></tr>
								</thead>
							</table>
							<table class="table table-bordered" style="width:100%;border: 2px solid black">
								<tbody>
									<tr>
										<th style="text-align: left;">Punctualtiy</td>
										<td><?=$rankDetail->punctualtiy?></td>
									</tr>
									<tr>
										<th style="text-align: left;">General Neatness</td>
										<td><?=$rankDetail->neatness?></td>
									</tr>
									<tr>
										<th style="text-align: left;">Obedience</td>
										<td><?=$rankDetail->obedience?></td>
									</tr>
									<tr>
										<th style="text-align: left;">Self Control</td>
										<td><?=$rankDetail->self_control?></td>
									</tr>
									<tr>
										<th style="text-align: left;">Participation in Class</td>
										<td><?=$rankDetail->participation?></td>
									</tr>
								</tbody>
							</table>
						</td>

						<!-- Second Table -->
						<td style="width: 34%; text-align: center;">
							<table style="width:100%; outline:none;">
								<tbody>
									<tr>
									<td style="width:60%;vertical-align: top;"><img style="max-width:300px;" src="<?=$this->application_model->getBranchImage($getExam['branch_id'], 'stamp-logo')?>"></td>
									</tr>
								</tbody>
							</table>
						</td>

						<!-- Third Table -->
						<td style="width: 33%; text-align: left;">
							<table class="table table-condensed table-bordered mt-lg"style="width:100%;border: 2px solid black">
								<thead style="margin-bottom: 0rem;">
								<tr><th style="background-color: #cdcdcd;color:black" class="text-center">Psychomotor development</th></tr>
								</thead>
							</table>
							<table class="table table-bordered" style="width:100%;"style="border: 2px solid black">
								<tbody>
									<tr>
										<th>Use of Intiative</td>
										<td><?=$rankDetail->use_of_intiative?></td>
									</tr>
									<tr>
										<th>Handling of Tools</td>
										<td><?=$rankDetail->handling?></td>
									</tr>
									<tr>
										<th>Communication Skills</td>
										<td><?=$rankDetail->communication?></td>
									</tr>
									<tr>
										<th>Realtionship with Others</td>
										<td><?=$rankDetail->realtionship?></td>
									</tr>
									<tr>
										<th>Sports & Games</td>
										<td><?=$rankDetail->sports?></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div style="width: 100%; display: flex;">
			<div style="width: 50%; padding-right: 15px;">
				<?php
				if ($attendance == 1) {
					$year = explode('-', $schoolYear);
					$getTotalWorking = $this->db->where(array('enroll_id' => $student['enrollID'], 'status !=' => 'H', 'year(date)' => $year[0]))->get('student_attendance')->num_rows();
					$getTotalAttendance = $this->db->where(array('enroll_id' => $student['enrollID'], 'status' => 'P', 'year(date)' => $year[0]))->get('student_attendance')->num_rows();
					$attenPercentage = empty($getTotalWorking) ? '0.00' : ($getTotalAttendance * 100) / $getTotalWorking;
					?>
				<table class="table table-bordered table-condensed"style="border: 2px solid black">
					<tbody>
						<tr>
							<th colspan="2" class="text-center">Attendance</th>
						</tr>
						<tr>
							<th style="width: 65%;">No. of working days</th>
							<td><?=$getTotalWorking?></td>
						</tr>
						<tr>
							<th style="width: 65%;">No. of days attended</th>
							<td><?=$getTotalAttendance?></td>
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
	if ($grade_scale == 1) {
		if ($getExam['type_id'] != 1) {
			?>
			<div style="width: 50%; padding-left: 15px;">
				<table class="table table-condensed table-bordered"style="border: 2px solid black">
					<tbody>
						<tr>
							<th colspan="3" class="text-center">Grading Scale</th>
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
	<?php } } ?>
		</div>
		
	<?php if (!empty($rankDetail->principal_comments) || !empty($rankDetail->teacher_comments)) { ?>
		<div style="width: 100%;">
			<table class="table table-condensed table-bordered"style="border: 2px solid black">
				<tbody>
				<?php if (!empty($rankDetail->principal_comments)) { ?>
					<tr>
						<th style="width: 250px;">Principal Comments</th>
						<td><?=$rankDetail->principal_comments?></td>
					</tr>
				<?php } if (!empty($rankDetail->teacher_comments)) { ?>
					<tr>
						<th style="width: 250px;">Teacher Comments</th>
						<td><?=$rankDetail->teacher_comments?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	<?php } ?>
		

		<table style="width:100%; outline:none; margin-top: 35px;">
			<tbody>
				<tr>
					<td style="font-size: 15px; text-align:left;">Print Date : <?=_d($print_date)?></td>
					<td style="border-top: 1px solid #ddd; font-size:15px;text-align:left">Principal Signature</td>
					<td style="border-top: 1px solid #ddd; font-size:15px;text-align:center;">Class Teacher Signature</td>
					<td style="border-top: 1px solid #ddd; font-size:15px;text-align:right;">Parent Signature</td>
				</tr>
			</tbody>
		</table>
	</div>

