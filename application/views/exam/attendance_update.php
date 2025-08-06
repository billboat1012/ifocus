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
					<div class="col-md-4 mb-sm">
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
					<div class="col-md-<?php echo $widget; ?> mb-sm">
    				<div class="form-group">
    					<label class="control-label"><?=translate('exam_name')?> <span class="required">*</span></label>
    					<?php
    						$arrayExam = array("" => translate('select_branch_first'));
    						if(!empty($branch_id)){
    							$exams = $this->db->get_where('exam', array('branch_id' => $branch_id,'session_id' => get_session_id()))->result();
    							foreach ($exams as $exam){
    								$arrayExam[$exam->id] = $this->application_model->exam_name_by_id($exam->id);
    							}
    						}
    						echo form_dropdown("exam_id", $arrayExam, set_value('exam_id'), "class='form-control' id='exam_id' required
    						data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
    					?>
    				</div>
			</div>
			        <div class="col-md-3 mb-sm">
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
		
		
		<?php if(isset($student)) { ?>
    <section class="panel appear-animation" data-appear-animation="<?php echo $global_config['animations'];?>" data-appear-animation-delay="100">
        <?php echo form_open('exam/attendance_save', array('class' => 'frm-submit-msg'));
            $data = array(
                'class_id' => $class_id,
                'session_id' => $session_id,
                'branch_id' => $branch_id,
                'exam_id' => $exam_id,
            );
            echo form_hidden($data);
        ?>
        <header class="panel-heading">
            <h4 class="panel-title"><i class="fas fa-users"></i> <?=translate('attendance_update')?></h4>
        </header>
        <div class="panel-body">
            <?php if (!empty($student)) { ?>
            <?php 
                        $td = null; 
                        foreach($attendance as $attend) {
                            $td = $attend['total_days'];
                        } 
                        ?>
            <div class="table-responsive mt-md mb-lg">
                <div class="col-lg-3 col-md-12 col-12">
                    <label>Total School Days</label>
                    <div class="form-group" style="padding: 4px">
                        <input type="number" class="form-control total_days" autocomplete="off" name="total_days" id="total_days" value="<?=$td?>">
                        <span class="error"></span>
                    </div>
                </div>
                <table class="table table-bordered table-condensed mb-none">
                    <thead>
                        <tr>
                            <th><?=translate('sl')?></th>
                            <th><?=translate('student_name')?></th>
                            <th><?=translate('category')?></th>
                            <th><?=translate('register_no')?></th>
                            <th><?=translate('attendance')?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $count = 1;
                        foreach ($student as $key => $row):
                            echo form_hidden("student_id[$key]", $row['id']);
                        ?>
                       <?php 
                        $dp = null; 
                        foreach($attendance as $attend) {
                            if($attend['student_id'] !== null && $attend['student_id'] == $row['id']) {
                                $dp = $attend['days_present'];
                                break;
                            }
                        } 
                        ?>

                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                            <td><?php echo get_type_name_by_id('student_category', $row['category_id']); ?></td>
                            <td><?php echo $row['register_no']; ?></td>
                            <td class="min-w-sm">
                                <div class="form-group">
                                    <input type="number" class="form-control  days_present" disabled autocomplete="off" name="days_present[<?=$key?>]" value="<?=$dp ?>">
                                    <span class="error"></span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-offset-10 col-md-2 mt-3">
                        <button type="submit" id="saveButton" class="btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
                            <i class="fas fa-plus-circle"></i> <?=translate('save')?>
                        </button>
                    </div>
                </div>
            </div>
            <?php } else { echo '<div class="alert alert-subl mt-md text-center">' . translate('no_information_available') . '</div>'; } ?>
        </div>
        <?php echo form_close(); ?>
    </section>
<?php } ?>

	</div>
</div>
<script type="text/javascript">


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
					classID: classID,
				},
				success: function (data) {
					$('#subject_id').html(data);
				}
			});
		});
	});
    
    function totalDays() {
    var totalDays = $("#total_days").val();
    var hasError = false;

    // Assuming totalDays is a string, convert it to a number
var totalDays = parseInt($("#total_days").val(), 10);
var hasError = false; // Initialize hasError variable

if (isNaN(totalDays) || totalDays === "") {
    // Disable all .days_present fields and the save button if totalDays is empty or not a number
    $(".days_present").attr('disabled', 'disabled').val("");
    $("#saveButton").attr('disabled', 'disabled');
} else {
    // Enable .days_present fields
    $(".days_present").removeAttr('disabled');

    // Iterate over each .days_present field
    $(".days_present").each(function() {
        var daysPresent = parseInt($(this).val(), 10);

        // Check if daysPresent is greater than totalDays
        if (daysPresent > totalDays) {
            $(this).next(".error").text("Days present cannot exceed total days.");
            hasError = true;
        } else {
            $(this).next(".error").text("");
        }
    });

    // Disable save button if there is any error
    if (hasError) {
        $("#saveButton").attr('disabled', 'disabled');
    } else {
        $("#saveButton").removeAttr('disabled');
    }
}

}

setInterval(() => {
    totalDays();
}, 100);



</script>	