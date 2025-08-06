<?php $widget = (is_superadmin_loggedin() ? 2 : 3); ?>
<div class="row">

	<div class="col-md-12">

		<section class="panel">

			<?php echo form_open('exam/hostel_comments', array('class' => 'validate')); ?>

			<header class="panel-heading">

				<h4 class="panel-title"><?=translate('select_ground')?></h4>

			</header>

			<div class="panel-body">

				<div class="row mb-sm">

				<?php if (is_superadmin_loggedin() ): ?>

					<div class="col-md-3 mb-sm">

						<div class="form-group">

							<label class="control-label"><?=translate('branch')?> <span class="required">*</span></label>

							<?php

								$arrayBranch = $this->app_lib->getSelectList('branch');

								echo form_dropdown("branch_id", $arrayBranch, set_value('branch_id'), "class='form-control' id='branch_id' required

								data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");

							?>

						</div>

					</div>

				<?php endif; ?>
				
				    <div class="col-md-<?=$widget?> mb-sm">

						<div class="form-group">

							<label class="control-label"><?=translate('exam')?> <span class="required">*</span></label>

							<?php

								

								if(!empty($branch_id)){

									$arrayExam = array("" => translate('select'));

									$exams = $this->db->get_where('exam', array('branch_id' => $branch_id,'session_id' => get_session_id()))->result();

									foreach ($exams as $exam){

										$arrayExam[$exam->id] = $this->application_model->exam_name_by_id($exam->id);

									}

								} else {

									$arrayExam = array("" => translate('select_branch_first'));

								}

								echo form_dropdown("exam_id", $arrayExam, set_value('exam_id'), "class='form-control' id='exam_id' required

								data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");

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



		<?php if (isset($student_list)) { ?>

            <section class="panel appear-animation" data-appear-animation="<?php echo $global_config['animations'];?>" data-appear-animation-delay="100">
        
                <?php echo form_open('exam/save_hostel_comments', array('class' => 'frm-submit-msg')); ?>
        
                <header class="panel-heading">
                    <h4 class="panel-title">
                        <i class="fas fa-users"></i> <?=translate('hostel_comments')?>
                    </h4>
                </header>
        
                <div class="panel-body">
                    <div class="table-responsive mt-md mb-lg">
                        <input type="hidden" name="exam_id" value="<?=$exam_id?>">
        
                        <table class="table table-bordered table-hover table-condensed mb-none" id="tableExport">
                            <thead class="text-dark">
                                <tr>
                                    <th><?=translate('students')?></th>
                                    <th><?=translate('register_no')?></th>
                                    <th><?=translate('class')?></th>
                                    <th><?=translate('roll')?></th>
                                    <th><?=translate('teacher_comments')?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($student_list) && count($student_list)) {
                                    $count = 1;
                            
                                    foreach ($student_list as $student) {
                                        // Extract required fields
                                        $enroll_id = $student['enroll_id'];
                                        $register_no = $student['register_no'];
                                        $full_name = $student['first_name'] . ' ' . $student['last_name'];
                                        $class_name = isset($student['class_name']) ? $student['class_name'] : '';
                                        $roll = isset($student['roll']) ? $student['roll'] : '0';
                                        $hostel_comment = $student['hostel_comment'] ?? '';
                                ?>
                                    <tr>
                                        <!-- Enroll ID hidden input -->
                                        <input type="hidden" name="rank[<?php echo $count ?>][enroll_id]" value="<?= $enroll_id?>">
                            
                                        <td><?php echo $full_name; ?></td>
                                        <td><?php echo $register_no; ?></td>
                                        <td><?php echo $class_name; ?></td>
                                        <td><?php echo $roll; ?></td>
                                        <td>
                                            <div class="form-group" style="width: 200px !important;">
                                                <input 
                                                    class="form-control" 
                                                    type="text" 
                                                    autocomplete="off" 
                                                    name="rank[<?php echo $count ?>][hostel_comment]" 
                                                    value="<?php echo htmlspecialchars($hostel_comment); ?>">
                                                <span class="error"></span>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                        $count++; // Ensure `count` is incremented here for the next student
                                    }
                                } else {
                                    echo '<tr><td colspan="5" class="text-center">' . translate('no_data_available') . '</td></tr>';
                                }
                                ?>
                            </tbody>

                        </table>
                    </div>
                </div>
        
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-offset-10 col-md-2">
                            <button type="submit" class="btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
                                <i class="fas fa-plus-circle"></i> <?=translate('save')?>
                            </button>
                        </div>
                    </div>
                </div>
        
                <?php echo form_close(); ?>
        
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

	});

</script>

