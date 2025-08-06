
<?php  $widget = (is_superadmin_loggedin() ? 4 : 6); ?>

<div class="row">

	<div class="col-md-12">

		<section class="panel">

			<header class="panel-heading">

				<h4 class="panel-title"><?=translate('select_ground')?></h4>

			</header>

			<?php echo form_open($this->uri->uri_string(), array('class' => 'validate'));?>

			<div class="panel-body">

				<div class="row mb-sm">

				<?php if (is_superadmin_loggedin() ): ?>

					<div class="col-md-4">

						<div class="form-group">

							<label class="control-label"><?=translate('branch')?> <span class="required">*</span></label>

							<?php

								$arrayBranch = $this->app_lib->getSelectList('branch');

								echo form_dropdown("branch_id", $arrayBranch, set_value('branch_id'), "class='form-control' onchange='getClassByBranch(this.value)'

								data-plugin-selectTwo data-width='100%'");

							?>

						</div>

					</div>

				<?php endif; ?>

					<div class="col-md-4 mb-sm">

						<div class="form-group">

							<label class="control-label"><?=translate('class')?> <span class="required">*</span></label>

							<?php

								$arrayClass = $this->app_lib->getClass($branch_id);

								echo form_dropdown("class_id", $arrayClass, set_value('class_id'), "class='form-control' id='class_id'

								required data-plugin-selectTwo data-width='100%'");

							?>

						</div>

					</div>
					
					<div class="col-md-4 mb-sm">
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

						<button type="submit" name="search" value="1" class="btn btn-default btn-block"> <i class="fas fa-filter"></i> <?=translate('filter')?></button>

					</div>

				</div>

			</footer>

			<?php echo form_close();?>

		</section>



		<?php if (isset($students)): ?>

            <section class="panel appear-animation" data-appear-animation="<?= $global_config['animations'] ?>" data-appear-animation-delay="100">
                <header class="panel-heading">
                    <h4 class="panel-title">
                        <i class="fas fa-user-graduate"></i> <?= translate('create_student_login') ?>
                    </h4>
                </header>
            
                <div class="panel-body">
                    <table class="table table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th><?= translate('name') ?></th>
                                <th><?=translate('register_no')?></th>
                                <th><?= translate('username') ?></th>
                                <th><?= translate('password') ?></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr class="student-login-row" data-enroll-id="<?= $student['student_id'] ?>">
                                    <td><?= html_escape($student['fullname']) ?></td>
                                    <td><?= $student['register_no']; ?></td>
                                    <td><input type="text" class="form-control username" value="<?=$student['register_no']?>" placeholder="<?= translate('username') ?>"></td>
                                    <td><input type="password" class="form-control password" value="password" placeholder="<?= translate('password') ?>"></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="button" id="save_login_info" class="btn btn-primary"><?= translate('save_logins') ?></button>
                </div>
            </section>

        
        <?php endif; ?>


	</div>

</div>



<div class="zoom-anim-dialog modal-block modal-block-primary mfp-hide" id="quickView">

	<section class="panel">

		<header class="panel-heading">

			<h4 class="panel-title">

				<i class="far fa-user-circle"></i> <?=translate('quick_view')?>

			</h4>

		</header>

		<div class="panel-body">

			<div class="quick_image">

				<img alt="" class="user-img-circle" id="quick_image" src="<?=base_url('uploads/app_image/defualt.png')?>" width="120" height="120">

			</div>

			<div class="text-center">

				<h4 class="text-weight-semibold mb-xs" id="quick_full_name"></h4>

				<p><?=translate('student')?> / <span id="quick_category"></p>

			</div>

			<div class="table-responsive mt-md mb-md">

				<table class="table table-striped table-bordered table-condensed mb-none">

					<tbody>

						<tr>

							<th><?=translate('register_no')?></th>

							<td><span id="quick_register_no"></span></td>

							<th><?=translate('roll')?></th>

							<td><span id="quick_roll"></span></td>

						</tr>

						<tr>

							<th><?=translate('admission_date')?></th>

							<td><span id="quick_admission_date"></span></td>

							<th><?=translate('date_of_birth')?></th>

							<td><span id="quick_date_of_birth"></span></td>

						</tr>

						<tr>

							<th><?=translate('blood_group')?></th>

							<td><span id="quick_blood_group"></span></td>

							<th><?=translate('religion')?></th>

							<td><span id="quick_religion"></span></td>

						</tr>

						<tr>

							<th><?=translate('email')?></th>

							<td colspan="3"><span id="quick_email"></span></td>

						</tr>

						<tr>

							<th><?=translate('mobile_no')?></th>

							<td><span id="quick_mobile_no"></span></td>

							<th><?=translate('state')?></th>

							<td><span id="quick_state"></span></td>

						</tr>

						<tr class="quick-address">

							<th><?=translate('address')?></th>

							<td colspan="3" height="80px;"><span id="quick_address"></span></td>

						</tr>

					</tbody>

				</table>

			</div>

		</div>

		<footer class="panel-footer">

			<div class="row">

				<div class="col-md-12 text-right">

					<button class="btn btn-default modal-dismiss"><?=translate('close')?></button>

				</div>

			</div>

		</footer>

	</section>

</div>

<script type="text/javascript">
    
    $(document).ready(function () {
    $("#save_login_info").click(function () {
        var loginData = [];

        $(".student-login-row").each(function () {
            var userId = $(this).data('enroll-id');
            var username = $(this).find(".username").val();
            var password = $(this).find(".password").val();

            if (username || password) {
                loginData.push({
                    user_id: userId,
                    username: username,
                    password: password
                });
            }
        });
        

        if (loginData.length > 0) {
            $.ajax({
                url: '<?= base_url('student/save_login_credentials') ?>',
                type: 'POST',
                data: { login_data: loginData },
                success: function (response) {
                    var res = JSON.parse(response);
                    if (res.success) {
                        alert('Login info saved successfully');
                    } else {
                        alert('Error: ' + res.message); // Show error message from backend
                    }
                },
                error: function () {
                    alert('An error occurred. Please try again.');
                }
            });
        } else {
            alert('No data to save');
        }
    });
});


</script>

<?php if (get_permission('student', 'is_delete')): ?>

<script type="text/javascript">

	$(document).ready(function () {

		$('#student_bulk_delete').on('click', function() {

			var btn = $(this);

			var arrayID = [];

			$("input[type='checkbox'].cb_bulkdelete").each(function (index) {

				if(this.checked) {

					arrayID.push($(this).attr('id'));

				}

			});

			if (arrayID.length != 0) {

				swal({

					title: "<?php echo translate('are_you_sure')?>",

					text: "<?php echo translate('delete_this_information')?>",

					type: "warning",

					showCancelButton: true,

					confirmButtonClass: "btn btn-default swal2-btn-default",

					cancelButtonClass: "btn btn-default swal2-btn-default",

					confirmButtonText: "<?php echo translate('yes_continue')?>",

					cancelButtonText: "<?php echo translate('cancel')?>",

					buttonsStyling: false,

					footer: "<?php echo translate('deleted_note')?>"

				}).then((result) => {

					if (result.value) {

						$.ajax({

							url: base_url + "student/bulk_delete",

							type: "POST",

							dataType: "JSON",

							data: { array_id : arrayID },

							success:function(data) {

								swal({

								title: "<?php echo translate('deleted')?>",

								text: data.message,

								buttonsStyling: false,

								showCloseButton: true,

								focusConfirm: false,

								confirmButtonClass: "btn btn-default swal2-btn-default",

								type: data.status

								}).then((result) => {

									if (result.value) {

										location.reload();

									}

								});

							}

						});

					}

				});

			}

		});

	});

</script>

<?php endif; ?>