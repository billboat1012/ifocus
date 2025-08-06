<?php
$widget = (is_superadmin_loggedin() ? 2 : 3);
$branch = $this->db->where('id',$branch_id)->get('branch')->row_array();
?>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<?php echo form_open('exam/spread_sheet', array('class' => 'validate')); ?>
			<header class="panel-heading">
				<h4 class="panel-title"><?=translate('select_ground')?></h4>
			</header>
			<div class="panel-body">
				<div class="row mb-sm">
					<?php if (is_superadmin_loggedin()): ?>
					<div class="col-md-2 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('branch')?> <span class="required">*</span></label>
							<?php
								$arrayBranch = $this->app_lib->getSelectList('branch');
								echo form_dropdown("branch_id", $arrayBranch, set_value('branch_id'), "class='form-control' id='branch_id'
								data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
							?>
						</div>
					</div>
					<?php endif; ?>
										<div class="col-md-<?=$widget?> mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('academic_year')?> <span class="required">*</span></label>
							<?php
								$arrayYear = array("" => translate('select'));
								$years = $this->db->get('schoolyear')->result();
								foreach ($years as $year){
									$arrayYear[$year->id] = $year->school_year;
								}
								echo form_dropdown("session_id", $arrayYear, set_value('session_id', get_session_id()), "class='form-control' required
								data-plugin-selectTwo data-width='100%'");
							?>
						</div>
					</div>
					<div class="col-md-<?php echo $widget; ?> mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('exam')?> <span class="required">*</span></label>
							<?php
								if(isset($branch_id)){
									$arrayExam = array("" => translate('select'));
									$exams = $this->db->get_where('exam', array('branch_id' => $branch_id,'session_id' => get_session_id()))->result();
									foreach ($exams as $row){
										$arrayExam[$row->id] = $this->application_model->exam_name_by_id($row->id);
									}
								} else {
									$arrayExam = array("" => translate('select_branch_first'));
								}
								echo form_dropdown("exam_id", $arrayExam, set_value('exam_id'), "class='form-control' id='exam_id' required data-plugin-selectTwo
								data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
						</div>
					</div>
					<div class="col-md-2 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('class')?> <span class="required">*</span></label>
							<?php
								$arrayClass = $this->app_lib->getClass($branch_id);
								echo form_dropdown("class_id", $arrayClass, set_value('class_id'), "class='form-control' id='class_id'
								required data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label"><?=translate('subject')?> <span class="required">*</span></label>
							<?php
								if(!empty(set_value('class_id'))) {
									$arraySubject = array("" => translate('select'));
									$query = $this->subject_model->getSubjectByClassSection(set_value('class_id'));
									$subjects = $query->result_array();
									foreach ($subjects as $row){
										$subjectID = $row['subject_id'];
										$arraySubject[$subjectID] = $row['subjectname'];
									}
								} else {
									$arraySubject = array("" => translate('select_class_first'));
								}
							echo form_dropdown("subject_id", $arraySubject, set_value('subject_id'), "class='form-control' id='subject_id'
								data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
							<small class="required"><?=translate('not_important')?></small>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-offset-10 col-md-2">
						<button type="submit" name="submit" value="search" class="btn btn-default btn-block"><i class="fas fa-filter"></i> <?=translate('filter')?></button>
					</div>
				</div>
			</div>
			<?php echo form_close();?>
		</section>

		<?php if (isset($get_subjects)) { ?>
			<section class="panel appear-animation" data-appear-animation="<?php echo $global_config['animations'];?>" data-appear-animation-delay="100">
				<header class="panel-heading">
					<h4 class="panel-title">
						<i class="fas fa-users"></i> <?=translate('spread_sheet')?>
					</h4>
				</header>
				<div class="panel-body">
					<div class="mt-sm mb-md">
						<!-- hidden school information prints -->
						<div class="export_title"><?php echo translate('class') . ' : ' . get_type_name_by_id('class', set_value('class_id'));
									echo $this->application_model->exam_name_by_id(set_value('exam_id')) . " Spread Sheet";
									?></div>
						<div class="visible-print fn_print">
							<center>
								<h4 class="text-dark text-weight-bold"><?=$branch['name']?></h4>
								<h5 class="text-dark"><?=$branch['address']?></h5>
								<h5 class="text-dark text-weight-bold"><?=$this->application_model->exam_name_by_id(set_value('exam_id'))?> - Spread Sheet</h5>
								<h5 class="text-dark">
									<?php 
									echo translate('class') . ' : ' . get_type_name_by_id('class', set_value('class_id'));
									?>
								</h5>
								<hr>
							</center>
						</div>
						
						<table class="table table-bordered table-hover table-condensed mb-none" id="tableExport">
							<thead class="text-dark">
								<tr>
									<th><?=translate('position')?></th>
									<th><?=translate('students')?></th>
									<th><?=translate('register_no')?></th>
									<th><?=translate('roll')?></th>
									<?php if(empty($exam_distributions)) : ?>
                                    <?php
                                        foreach($get_subjects as $subject){
                                        	$fullMark = array_sum(array_column(json_decode($subject['mark_distribution'], true), 'full_mark'));
                                            echo '<th>' . $subject['subject_name'] . " (" . $fullMark . ')</th>';
                                        }
                                    ?>
									<th><?=translate('total_marks')?></th>
<th>GPA</th>
<th>CLASS AV.</th>
<th><?=translate('result')?></th>
									<?php elseif(!empty($exam_distributions)) : ?>
									<?php
						            $distributions = json_decode($exam_distributions['mark_distribution'], true);
									
									foreach($distributions as $id => $value){
									    echo "<th>" . get_type_name_by_id('exam_mark_distribution', $id) . "</th>";
									}
									?>
									<th>TOTAL</th>
									<th>CLASS AV.</th>
									<?php endif; ?>
								</tr>
							</thead>
							<tbody>
								<?php
								$count = 1;
								$enrolls = $this->db->get_where('enroll', array(
									'class_id' 		=> set_value('class_id'),
									'session_id' 	=> set_value('session_id'),
									'branch_id' 	=> $branch_id,
								))->result_array();
								$studentArrayList = array();
								if(count($students_list)) {
									foreach($students_list as $enroll) {
										$studentArray = array();
										$studentArray['rank'] = empty($enroll->rank) ? translate("not_generated") : $enroll->rank;
										$studentArray['enrollID'] = $enroll->id;
										$studentArray['class_name'] = $enroll->class_name;
										$studentArray['student_name'] = $enroll->fullname;
										$studentArray['register_no'] = $enroll->register_no;
										$studentArray['principal_comments'] = $enroll->principal_comments;
										$studentArray['teacher_comments'] = $enroll->teacher_comments;
										$studentArray['roll'] = $enroll->roll;

										$totalMarks 		= 0;
										$totalFullmarks 	= 0;
										$totalGradePoint 	= 0;
										$grand_result 		= 0;
										$unset_subject 		= 0;
										$subject_array_list = array();
										$result_status = 1;
                                        										foreach ($get_subjects as $subject) {
                                            $subjectArray = array();
                                            $this->db->where(array(
                                                'class_id'   => set_value('class_id'),
                                                'exam_id'    => set_value('exam_id'),
                                                'subject_id' => $subject['subject_id'],
                                                'student_id' => $enroll->student_id,
                                                'session_id' => set_value('session_id')
                                            ));
                                            $getMark = $this->db->get('mark')->row_array();
                                            if (!empty($getMark)) {
                                                if ($getMark['absent'] != 'on') {
                                                    $totalObtained = 0;
                                                    $totalFullMark = 0;
                                                    $fullMarkDistribution = json_decode($subject['mark_distribution'], true);
                                                    $obtainedMark = json_decode($getMark['mark'], true);
                                                    foreach ($fullMarkDistribution as $i => $val) {
                                                        $obtained_mark = floatval($obtainedMark[$i]);
                                                        $totalObtained += $obtained_mark;
                                                        $totalFullMark += $val['full_mark'];
                                                        $passMark = floatval($val['pass_mark']);
                                                        if ($obtained_mark < $passMark) {
                                                            $result_status = 0;
                                                        }
                                                    }
                                        
                                                    // Only add the subject if the totalObtained is greater than 0
                                                    if ($totalObtained > 0) {
                                                        $subjectArray['totalObtained'] = $totalObtained;
                                                        $subjectArray['totalFullMark'] = $totalFullMark;
                                        
                                                        if (!empty($totalObtained)) {
                                                            $grade = $this->exam_model->get_grade($totalObtained, $branch_id);
                                                            $totalGradePoint += $grade['grade_point'];
                                                        }
                                                        $totalMarks += $totalObtained;
                                                        $totalFullmarks += $totalFullMark;
                                                    } else {
                                                        // Mark the subject as not taken
                                                        $subjectArray['not_taken'] = true;
                                                    }
                                                } else {
                                                    $subjectArray['absent'] = true;
                                                }
                                            } else {
                                                $subjectArray['mark_empty'] = true;
                                                $unset_subject++;
                                            }
                                            $subjectArray['result_status'] = $unset_subject;
                                            $subject_array_list[] = $subjectArray;
                                        }
										if ($unset_subject == 0) {
											if ($result_status == 1) {
												$studentArray['result_pass'] = true;
											} else {
												$studentArray['result_pass'] = false;
											}
										}

										$studentArray['result_status'] = $unset_subject;
										$studentArray['subject_array_list'] = $subject_array_list;
										$studentArray['totalFullmarks'] = $totalFullmarks;
										$studentArray['totalMarks'] = $totalMarks;
										$studentArray['totalGradePoint'] = $totalGradePoint;
										$studentArrayList[] = $studentArray;
									}
									$classTotalSum = 0;
                                    $classStudentCount = 0;
                                    
                                    foreach ($studentArrayList as $student) {
                                        
                                    	if ($student['totalFullmarks'] > 0) {
                                    		$classTotalSum += $student['totalMarks'];
                                    		$classStudentCount++;
                                    	}
                                    }
                                    
                                    $classAverage = ($classStudentCount > 0) ? round($classTotalSum / $classStudentCount, 2) : 0;
								}
								
								if (!empty($studentArrayList)) {
								foreach ($studentArrayList as $row1):
								    
							?>
								<tr>
									<td><?php echo $row1['rank']; ?></td>
									<td><?php echo $row1['student_name']; ?></td>
									<td><?php echo $row1['register_no']; ?></td>
									<td><?php echo $row1['roll']; ?></td>
									<?php if(empty($exam_distributions)) : ?>
									<?php foreach ($row1['subject_array_list'] as $subject): ?>
									<td>
									<?php
									if (isset($subject['absent']) && $subject['absent'] === true) {
                                        echo translate('absent');
                                    } elseif (isset($subject['mark_empty']) && $subject['mark_empty'] === true) {
                                        echo "N/A";
                                    } elseif ($subject['totalObtained'] == 0) {
                                        echo "N/A";
                                    } else {
                                        echo $subject['totalObtained'] . "/" . $subject['totalFullMark'];
                                    }
									?>
									</td>
									<?php endforeach; ?>
									<td><?php echo ($row1['totalMarks'] . '/' . $row1['totalFullmarks']); ?>
									</td>
									<td>
										<?php
										$totalSubjects = count($get_subjects);
										if(!empty($totalSubjects)) {
											echo number_format(($row1['totalGradePoint'] / $totalSubjects), 2,'.','');
										}
										?>
									</td>
									<td><?= $classAverage ?></td>
									<td>
									<?php
										if ($row1['result_status'] == 0) {
											if ($row1['result_pass']) {
												echo '<span class="label label-primary">PASS</span>';
											} else {
												echo '<span class="label label-danger">FAIL</span>';
											}
										}
									?>
									</td>
									<?php elseif(!empty($exam_distributions)):
									$dat = $this->exam_model->getStudentTabMark($branchID, $classID, $examID, $subject_ID, $row1['register_no']);
									$stud_mark = json_decode($dat, true);
									foreach($stud_mark as $row => $value) :
									?>
									<td><span class="<?=$row1['enrollID']?>"><?= $value ?></span></td>
									<?php endforeach; ?>                           
                                    <script>
                                $(document).ready((e) => {
                                    // Calculate the total scores for each student and display it
                                    var studentRegID = "<?=$row1['enrollID']?>";
                                    var totalNumber = 0;
                            
                                    // Sum up all scores for the specific student based on their ID
                                    $("[class='" + studentRegID + "']").each(function () {
                                        totalNumber += parseFloat($(this).text()) || 0;
                                    });
                            
                                    // Display individual total for the student
                                    $("#total_for_" + studentRegID).text(totalNumber);
                            
                                    // -------- Class Average Calculation --------
                                    var totalScores = 0;
                                    var studentCount = 0;
                            
                                    // Loop through all total score spans to calculate the class total and student count
                                    $(".totalScores").each(function () {
                                        var score = parseFloat($(this).text()) || 0;
                                        if (score > 0) {
                                            totalScores += score;
                                            studentCount++;
                                        }
                                    });
                            
                                    // Calculate class average if we have students with scores
                                    var classAverage = studentCount > 0 ? (totalScores / studentCount) : 0;
                            
                                    // Display the class average in a span withf ID 'classAverage'
                                    $(".classAverage").text(classAverage.toFixed(2));
                                });
                            </script>



									<td><span class="totalScores" id="total_for_<?=$row1['enrollID']?>"></span></td>
									<td><span class="classAverage"></span></td>
									<?php endif; ?>
								</tr>
								<?php
									endforeach;
								} ?>
							</tbody>
						</table>
					</div>
				</div>
			</section>
	<?php } ?>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
	    
	    
	    
		$('#branch_id').on("change", function() {
			var branchID = $(this).val();
			getClassByBranch(branchID);
			getExamByBranch(branchID);
		});
		
		
		$('#class_id').on('change', function() {
			var classID = $('#class_id').val();
			$.ajax({
				url: base_url + 'subject/getByClassSection',
				type: 'POST',
				data: {
					classID: classID,
				},
				success: function (data) {
					$('#subject_id').html(data);
				}
			});
		});

		var spread_sheet = $('#tableExport').DataTable({
			"dom": '<"row"<"col-sm-6 mb-xs"B><"col-sm-6"f>><"table-responsive"t>p',
			"lengthChange": false,
			"pageLength": -1,
			"columnDefs": [
				{targets: [-1], orderable: false}
			],
			"buttons": [
				{
					extend: 'copyHtml5',
					text: '<i class="far fa-copy"></i>',
					titleAttr: 'Copy',
					title: $('.export_title').html(),
					exportOptions: {
						columns: ':visible'
					}
				},
				{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel"></i>',
					titleAttr: 'Excel',
					title: $('.export_title').html(),
					exportOptions: {
						columns: ':visible'
					}
				},
				{
					extend: 'csvHtml5',
					text: '<i class="fa fa-file-alt"></i>',
					titleAttr: 'CSV',
					title: $('.export_title').html(),
					exportOptions: {
						columns: ':visible'
					}
				},
				{
					extend: 'pdfHtml5',
					text: '<i class="fa fa-file-pdf"></i>',
					titleAttr: 'PDF',
					title: $('.export_title').html(),
					footer: true,
					customize: function ( win ) {
						win.styles.tableHeader.fontSize = 10;
						win.styles.tableFooter.fontSize = 10;
						win.styles.tableHeader.alignment = 'left';
					},
					exportOptions: {
						columns: ':visible'
					}
				},
				{
					extend: 'print',
					text: '<i class="fa fa-print"></i>',
					titleAttr: 'Print',
					title: $('.fn_print').html(),
					customize: function ( win ) {
						$(win.document.body)
							.css( 'font-size', '9pt' );

						$(win.document.body).find( 'table' )
							.addClass( 'compact' )
							.css( 'font-size', 'inherit' );

						$(win.document.body).find( 'h1' )
							.css( 'font-size', '14pt' );
					},
					footer: true,
					exportOptions: {
						columns: ':visible'
					}
				},
				{
					extend: 'colvis',
					text: '<i class="fas fa-columns"></i>',
					titleAttr: 'Columns',
					title: $('.export_title').html(),
					postfixButtons: ['colvisRestore']
				},
			]
		});
	});
</script>
