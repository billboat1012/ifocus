<?php $widget = (is_superadmin_loggedin() ? 2 : 3); ?>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
		<?php echo form_open($this->uri->uri_string(), array('class' => 'validate'));?>
			<header class="panel-heading">
				<h4 class="panel-title"><?=translate('select_ground')?></h4>
			</header>
			<div class="panel-body">
				<div class="row mb-sm">
					<?php if (is_superadmin_loggedin()): ?>
					<div class="col-md-3 mb-sm">
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
					<div class="col-md-3 mb-sm">
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
								echo form_dropdown("subject_id", $arraySubject, set_value('subject_id'), "class='form-control' id='subject_id' required
								data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-offset-10 col-md-2">
						<button type="submit" name="search" value="1" class="btn btn btn-default btn-block"> <i class="fas fa-filter"></i> <?=translate('filter')?></button>
					</div>
				</div>
			</footer>
			<?php echo form_close();?>
		</section>
		
		<?php if (isset($student)): $readonly = ''; ?>
		<?php if($sub_subject_id == null) : ?>
		<section class="panel appear-animation" data-appear-animation="<?php echo $global_config['animations'];?>" data-appear-animation-delay="100">
			<?php echo form_open('exam/mark_save', array('class' => 'frm-submit-msg'));
				$data = array(
					'class_id' => $class_id,
					'exam_id' => $exam_id,
					'subject_id' => $subject_id, 
					'session_id' => get_session_id(),
					'branch_id' => $branch_id,
					'exam_type_id' => $exam_type_id
				);
				echo form_hidden($data);
			?>
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-users"></i> <?=translate('mark_entries')?></h4>
			</header>
			<div class="panel-body">
				<?php if (!empty($student) && !empty($timetable_detail)) { ?>
                <div class="table-responsive mt-md mb-lg">
    
    <table class="table table-bordered table-condensed mb-none">
        <thead>
            <tr>
                <th><?=translate('sl')?></th>
                <th><?=translate('student_name')?></th>
                <th><?=translate('category')?></th>
                <th><?=translate('register_no')?></th>
                <th><?=translate('roll')?></th>
                <th>IsAbsent</th>
                <?php
                $distributions = json_decode($timetable_detail['mark_distribution'], true);
                foreach ($distributions as $i => $value) {
                    ?>
                    <th><?php
                        $data = array(
                            'max_mark_' .  $i => $value['full_mark'],
                        );
                        echo form_hidden($data);
                        echo get_type_name_by_id('exam_mark_distribution', $i) . " (" . $value['full_mark'] . ")" ;
                        ?></th>
                <?php } ?>
                <?php ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($student as $key => $row):
$first_ca_total = isset($row['first_ca_total']) ? $row['first_ca_total'] : 0;
$second_ca_total = isset($row['second_ca_total']) ? $row['second_ca_total'] : 0;
                ?>
            <tr>
                <input type="hidden" name="mark[<?=$key?>][student_id]" value="<?=$row['student_id']?>">
                <td><?php echo $count++; ?></td>
                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                <td><?php echo get_type_name_by_id('student_category', $row['category_id']); ?></td>
                <td><?php echo $row['register_no']; ?></td>
                <td><?php echo $row['roll']; ?></td>
                <td>
                    <div class="checkbox-replace">
                        <label class="i-checks">
                            <input type="checkbox" name="mark[<?=$key?>][absent]" <?=($row['get_abs'] == 'on' ? 'checked' : ''); ?> onclick="toggleRadioButtons(<?=$key?>, this.checked)">
                            <i></i>
                        </label>
                    </div>
                </td>
                <?php if(isset($exam_type_id) && $exam_type_id == 4) :
                $getDetails = json_decode($row['get_mark'], true);
                foreach ($distributions as $id => $ass) {
                    $existMark = isset($getDetails[$id]) ? $getDetails[$id]  : '';
                    ?>
                <td class="min-w-sm">
                    <div class="checkbox-replace">
                        <label class="i-checks">
                            <input type="radio" name="mark[<?=$key?>][assessment]" value="<?=$id?>" <?=$existMark == $id ? 'checked' : ''; ?>>
                            <i></i>
                        </label>
                    </div>
                </td>
                <?php } else : ?>
                <?php
                $getDetails = json_decode($row['get_mark'], true);
                foreach ($distributions as $id => $ass) {
                    $identi = $this->db->select('unique_identifier')
                    ->where('id', $id)
                    ->from('exam_mark_distribution')
                    ->get()
                    ->result_array();
                    
                    $thisExam = $this->db->select('unique_identifier')
                    ->where('id',$exam_id)
                    ->from('exam')
                    ->get()
                    ->row_array();
                    $existMark = isset($getDetails[$id]) ? $getDetails[$id]  : '';
                    $value = $existMark;

                    foreach($identi as $value){
                        if ($value['unique_identifier'] == '1st_ca' && $thisExam['unique_identifier'] == 'examination') {
                            $readonly = 'readonly';
                            
                            $total = 0;
                            
                            $jsonData = $first_ca_total;
                            
                            if($jsonData !== 0){

                            // Decode the JSON string into an associative array
                            $dataArray = json_decode($jsonData, true);
                            
                            // Sum the values
                            $total = array_sum($dataArray);
                            
                            }
                            $value = $total;
                        } elseif ($value['unique_identifier'] == '2nd_ca' && $thisExam['unique_identifier'] == 'examination') {
                            $readonly = 'readonly';

                            $jsonData = $second_ca_total;
                            
                            $total = 0;
                            
                            if($jsonData !== 0){
                            
                            $dataArray = json_decode($jsonData, true);
                            
                            $total = array_sum($dataArray);
                            
                            }

                            $value = $total;
                        } elseif($value['unique_identifier'] == 'examination') {
                            $readonly = '';
                            $value = $existMark;
                        } else {
                            $value = $existMark;
                        }
                    }
                    
                    ?>
                <td class="min-w-sm">
                    <div class="form-group">
                        <input type="text" class="form-control" autocomplete="off" name="mark[<?=$key?>][assessment][<?=$id?>]" value="<?=$value === 'Array' ? 0 : $value?>" <?=$readonly?>>
                        <span class="error"></span>
                    </div>
                </td>
                <?php } endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
                <div class="row">
					<div class="col-md-offset-10 col-md-2 mt-3">
						<button type="submit" class="btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
							<i class="fas fa-plus-circle"></i> <?=translate('save')?>
						</button>
					</div>
				</div>
</div>

				<?php } else { echo '<div class="alert alert-subl mt-md text-center">' . translate('no_information_available') . '</div>'; } ?>
			</div>
			<?php echo form_close(); ?>
		</section>
		<?php elseif(!empty($sub_subject_id)):
		   foreach($sub_subject_id as $subID => $subName):
		?>
        <section class="panel appear-animation" data-appear-animation="<?php echo $global_config['animations'];?>" data-appear-animation-delay="100">
			<?php echo form_open('exam/mark_save', array('class' => 'frm-submit-msg'));
				$data = array(
					'class_id' => $class_id,
					'exam_id' => $exam_id,
					'subject_id' => $subject_id,
					'sub_subject_id' => $subID,
					'session_id' => get_session_id(),
					'branch_id' => $branch_id,
					'exam_type_id' => $exam_type_id
				);
				echo form_hidden($data);
			?>
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-users"></i> <?=translate('mark_entries for ') . " Sub-Subject( " . translate($subName) . " )"?></h4>
			</header>
			<div class="panel-body">
				<?php if (!empty($student) && !empty($timetable_detail)) { ?>
                <div class="table-responsive mt-md mb-lg">
    
    <table class="table table-bordered table-condensed mb-none">
        <thead>
            <tr>
                <th><?=translate('sl')?></th>
                <th><?=translate('student_name')?></th>
                <th><?=translate('category')?></th>
                <th><?=translate('register_no')?></th>
                <th><?=translate('roll')?></th>
                <th>IsAbsent</th>
                <?php
                $distributions = json_decode($timetable_detail['mark_distribution'], true);
                foreach ($distributions as $i => $value) {
                    ?>
                    <th><?php
                        $data = array(
                            'max_mark_' .  $i => $value['full_mark'],
                        );
                        echo form_hidden($data);
                        echo get_type_name_by_id('exam_mark_distribution', $i) ;
                        ?></th>
                <?php } ?>
                <?php ?>
            </tr>
        </thead>
        <tbody>
            <?php 
            $count = 1;
            foreach ($student as $key => $row):
$first_ca_total = isset($row['first_ca_total']) ? $row['first_ca_total'] : 0;
$second_ca_total = isset($row['second_ca_total']) ? $row['second_ca_total'] : 0;
                ?>
            <tr>
                <input type="hidden" name="mark[<?=$key?>][student_id]" value="<?=$row['student_id']?>">
                <td><?php echo $count++; ?></td>
                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                <td><?php echo get_type_name_by_id('student_category', $row['category_id']); ?></td>
                <td><?php echo $row['register_no']; ?></td>
                <td><?php echo $row['roll']; ?></td>
                <?php $absent = $this->exam_model->getAbsentStatusBySubSub($subject_id, $subID, $exam_id, $row['student_id']); ?>
                <td>
                    <div class="checkbox-replace">
                        <label class="i-checks">
                            <input type="checkbox" name="mark[<?=$key?>][absent]" <?=($absent == 'on' ? 'checked' : ''); ?> onclick="toggleRadioButtons(<?=$key?>, this.checked)">
                            <i></i>
                        </label>
                    </div>
                </td>
                <?php $datas = $this->exam_model->getMarkBySubSubject($subject_id, $subID, $exam_id, $row['student_id']);?>
                <?php $getDetails = json_decode($row['get_mark'], true);
                foreach ($distributions as $id => $ass) {
                    $existMark = isset($getDetails[$id]) ? $getDetails[$id]  : '';
                    $value = $existMark;
                    ?>
                <td class="min-w-sm">
                    <div class="checkbox-replace">
                        <label class="i-checks">
                            <input type="radio" name="mark[<?=$key?>][assessment]" value="<?=$id?>" <?=$datas == $id ? 'checked' : ''; ?>>
                            <i></i>
                        </label>
                    </div>
                </td>
                <?php }  ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

				<?php } else { echo '<div class="alert alert-subl mt-md text-center">' . translate('no_information_available') . '</div>'; } ?>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-offset-10 col-md-2 mt-3">
						<button type="submit" class="btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
							<i class="fas fa-plus-circle"></i> <?=translate('save')?>
						</button>
					</div>
				</div>
			</div>
			<?php echo form_close(); ?>
		</section>
		<?php endforeach; endif; endif; ?>
	</div>
</div>
<script type="text/javascript">

// $('form').on('submit', function(event) {
//     event.preventDefault();
//     console.log($(this).serialize());
//     // Perform AJAX submission here
// });

function toggleRadioButtons(studentKey, isAbsentChecked) {
        if (isAbsentChecked) {
            var radioButtons = document.querySelectorAll('input[name="mark[' + studentKey + '][assessment]"]');
            radioButtons.forEach(function(radio) {
                radio.checked = false;
            });
        }
    }

	$(document).ready(function () {
		$('#branch_id').on('change', function() {
			var branchID = $(this).val();
			getClassByBranch(branchID);
			getExamByBranch(branchID);
			$('#subject_id').html('').append('<option value=""><?=translate("select")?></option>');
		});

		$('#class_id').on('change', function() {
			var classID = $('#class_id').val();
			$.ajax({
				url: base_url + 'subject/getByClassSection',
				type: 'POST',
				data: {
					classID: classID
				},
				success: function (data) {
					$('#subject_id').html(data);
				}
			});
		});
	});
</script>	