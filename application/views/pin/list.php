<style>
	.card {
		width: 400px;
		height: 250px;
		border: 1px solid #000;
		padding: 5px;
		font-family: Arial, sans-serif;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		border-radius: 5px;
		display: inline-block;
		margin: 5px;
	}

	.header_card {
		display: flex;
		justify-content: space-between;
		align-items: center;
		height: 40px;
	}
	.lists {font-size:13px;}

	.logo {
		width: 50px;
		height: 50px;
	}

	.content {
		flex-grow: 1;
	}

	.instructions {
		list-style-type: none;
		padding: 0;
		margin: 5px 0;
	}

	.instructions li {
		margin-bottom: 5px;
	}

	.pin {
		font-weight: bold;
		margin: 5px 0;
	}

	.footer {
		font-size: 12px;
		text-align: center;
	}

	#pins {
		margin-top: 10px;
	}

	@media print {
		.card {
			page-break-inside: avoid;
		}
	}
</style>

<section class="panel">
	<header class="panel-heading">
		<?php if (get_permission('pin', 'is_delete')) : ?>
			<div class="panel-btn">
				<button class="btn btn-default btn-circle" id="student_bulk_print" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
					<i class="fas fa-trash-alt"></i> <?= translate('Print') ?>
				</button>
				<button class="btn btn-default btn-circle" id="student_bulk_delete" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
					<i class="fas fa-trash-alt"></i> <?= translate('bulk_delete') ?>
				</button>
			</div>

		<?php endif; ?>
		<h4 class="panel-title"><i class="fas fa-user-graduate"></i> <?php echo translate('pin_list'); ?></h4>
	</header>
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fas fa-list-ul"></i> Pin List</a>
			</li>
			<?php if (get_permission('pin', 'is_add')) : ?>
				<li>
					<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> <?= translate('create_pin') ?></a>
				</li>
			<?php endif; ?>
		</ul>
		<div class="tab-content">
			<div id="list" class="tab-pane active">
				<table class="table table-bordered table-hover mb-none table-export">
					<thead>
						<tr>
							<th><?= translate('sl') ?></th>
							<th width="10" class="no-sort">
								<div class="checkbox-replace">
									<label class="i-checks"><input type="checkbox" id="selectAllchkbox"><i></i></label>
								</div>
							</th>
							<th><?= translate('pin') ?></th>
							<th><?= translate('trials_left') ?></th>
							<th>Used By</th>
							<th>Pin Status</th>
							<th>School</th>
							<th>Date & Time Created</th>
							<th><?= translate('action') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php $count = 1;
						foreach ($pinlist as $row) : ?>
							<tr>
								<td class="center"><?php echo $count++; ?></td>
								<td class="checked-area">
									<div class="checkbox-replace">
										<label class="i-checks">
											<input type="checkbox" class="cb_bulkdelete" id="<?= $row['id'] ?>" value=""><i></i>
										</label>
									</div>
								</td>
								<td id="pin_<?= $row['id'] ?>"><?php echo (empty($row['pin']) ? 'N/A' : $row['pin']); ?></td>
								<td><?php echo (empty($row['use_time']) ? '<span class="label label-dark">FULLY USED</span>' :  $row['use_time']); ?></td>
								<td><?php
									$used_by = $row['used_by'];

									/*$CI->db->query('select register_no from student where id=$used_by');
                                $data=$CI->get()->result_array(); print_r($data);*/
									if (empty($row['used_by'])) {
										echo '- - -';
									} else {
										$CI = &get_instance();
										$CI->load->model('student_model');
										$student_data = $CI->student_model->getSingleStudent($used_by);
										// print_r($student_data);
										echo  $student_data['register_no'];
									} ?>
								</td>
								<td>
									<?php
									if (empty($row['used_by'])) {
										echo '<span class="label label-success">ACTIVE PIN</span>';
									} elseif (!empty($row['use_time'])) {
										echo '<span class="label label-warning">PIN IN USE</span>';
									} else {
										echo '<span class="label label-dark">INVALID PIN</span>';
									}
									?>
								</td>
								<td>N/A</td>
								<td>
									<?php
									if (!empty($row['created_at'])) {
										echo date('d-M-Y | h:i A', strtotime($row['created_at']));
									} else {
										echo 'N/A';
									}
									?>
								</td>
								<td class="min-w-xs">
									<?php if (get_permission('pin', 'is_delete')) : ?>
										<!-- delete link -->
										<?php echo btn_delete('pin/delete/' . $row['id']); ?>
									<?php endif; ?>
								</td>

							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php if (get_permission('exam', 'is_add')) : ?>
				<div class="tab-pane" id="create">
					<div class="form-horizontal form-bordered mb-lg">

						<div class="form-group">
							<label class="col-md-3 control-label"></label>
							<div class="col-md-6">
								<div class="row">
									<div class="col-lg-4">
										<label> Pin Length</label>
										<input type="number" class="form-control" id="length" value="15" min="1">
										<span class="error"></span>
									</div>
									<div class="col-lg-4">
										<label> Use Time</label>
										<input type="number" class="form-control" id="usedTime" value="15" min="1">
										<span class="error"></span>
									</div>
									<div class="col-lg-4">
										<label> No of PIN</label>
										<input type="number" class="form-control" id="noOfPin" value="10" min="1">
										<span class="error"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"></label>
							<div class="col-md-6" id="password"></div>
						</div>

					</div>

					<footer class="panel-footer">
						<div class="row">
							<div class="col-md-offset-3 col-md-2">
								<button class="btn btn-default btn-block" onclick="generatePassword()">Generate PIN</button>
							</div>
						</div>
					</footer>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div id="pins"></div>
</section>

<script>
	function generatePassword() {
		var length = $('#length').val();
		var usedTime = $('#usedTime').val();
		var noOfPin = $('#noOfPin').val();
		$.ajax({
			url: '<?php echo base_url("pin/generate"); ?>',
			method: 'POST',
			data: {
				length: length,
				used_time: usedTime,
				no_of_pin: noOfPin
			},
			success: function(response) {
				$('#password').text(response);
				setTimeout(function() {
					window.location.href = "https://schoolportal.ng/pin";
				}, 2000);
			},
			error: function(xhr, status, error) {
				console.error(xhr.responseText);
			}
		});
	}
</script>
<?php if (get_permission('student', 'is_delete')) : ?>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#student_bulk_delete').on('click', function() {
				var btn = $(this);
				var arrayID = [];
				$("input[type='checkbox'].cb_bulkdelete").each(function(index) {
					if (this.checked) {
						arrayID.push($(this).attr('id'));
					}
				});
				var current_url = window.location.href;
				// alert(current_url);
				if (arrayID.length != 0) {
					swal({
						title: "<?php echo translate('are_you_sure') ?>",
						text: "<?php echo translate('delete_this_information') ?>",
						type: "warning",
						showCancelButton: true,
						confirmButtonClass: "btn btn-default swal2-btn-default",
						cancelButtonClass: "btn btn-default swal2-btn-default",
						confirmButtonText: "<?php echo translate('yes_continue') ?>",
						cancelButtonText: "<?php echo translate('cancel') ?>",
						buttonsStyling: false,
						footer: "<?php echo translate('deleted_note') ?>"
					}).then((result) => {
						if (result.value) {
							$.ajax({
								url: base_url + "pin/bulk_delete",
								type: "POST",
								dataType: "JSON",
								data: {
									array_id: arrayID
								},
								success: function(data) {
									swal({
										title: "<?php echo translate('deleted') ?>",
										text: data.message,
										buttonsStyling: false,
										showCloseButton: true,
										focusConfirm: false,
										confirmButtonClass: "btn btn-default swal2-btn-default",
										type: data.status
									}).then((result) => {
										if (result.value) {
											location.reload();
											location.href = current_url;
										}
									});
								}
							});
						}
					});
				}
			});

			// Bulk print
			$('#student_bulk_print').on('click', function() {
				var btn = $(this);
				var arrayID = [];
				$("input[type='checkbox'].cb_bulkdelete").each(function(index) {
					if (this.checked) {
						arrayID.push($(this).attr('id'));
					}
				});
				
				var pinsContainer = $('#pins');
				pinsContainer.html(''); // Clear previous content
				var arrayPIN = [];
				// Simulate fetching data from the database
				arrayID.forEach(function(id) {

					var pin = $('#pin_' + id).html();
					arrayPIN.push(pin);

				});
				if (arrayPIN.length > 10) {
					alert("Please select 10 pins at one time.");
				} else {
					createPopupWithCard(arrayPIN);
				}
			});

			function createCardHtml(pin) {
			return `
				<div class="card">
					<div class="header_card">
						<h4>HOW TO USE CARD</h4>
						<img src="<?=$this->application_model->getBranchImage(get_loggedin_branch_id(), 'logo-small')?>" alt="Logo" class="logo">
					</div>
					<div class="content">
						<ul class="instructions">
							<li class="lists">1. LOGIN TO THE SCHOOL WEBSITE</li>
							<li class="lists">2. CLICK ON CHECK RESULT</li>
							<li class="lists">3. INPUT YOUR REG NO. AND CHECK RESULT</li>
						</ul>
						<div class="pin"><b>PIN:</b> ${pin}</div>
					</div>
					<div class="footer lists" >
						NOTE: YOU CAN ALSO LOGIN TO YOUR DASHBOARD TO CHECK YOUR RESULT
					</div>
				</div>
			`;
			}

			function createPopupWithCard(pins) {
    const popupWindow = window.open("", "popupWindow", "width=800,height=600");
    popupWindow.document.write("<html><head><title>Print Cards</title>");
    popupWindow.document.write("</head><body>");

    // CSS styles for the popup window
    popupWindow.document.write(`
        <style>
            .card { width: 45%; height: 150px; border: 1px solid #ccc; margin: 5px; float: left; }
            .card:nth-child(2n+1) { clear: left; }
            .header_card { padding: 1px;height: 25px; border-bottom: 1px solid #ccc; display: flex; justify-content: space-between; align-items: center; }
            .content { padding: 1px; }
            .pin { margin-top: 4px; }
            .footer { padding: 4px; border-top: 1px solid #ccc;font-size:13px; }
            .instructions { list-style-type: none; padding: 0;margin-block-start: 0.2em;margin-block-end: 0.2em; }
            .logo { max-width: 77px; }
			.lists {font-size:13px;}
            #printButton { display: block; } /* Display the button by default */
        </style>
    `);

    popupWindow.document.write("<h1>Cards</h1>");

    // Generating cards HTML
    for (let i = 0; i < pins.length; i++) {
        popupWindow.document.write(createCardHtml(pins[i]));
    }

    // Print button
    popupWindow.document.write('<button id="printButton" onclick="window.print()">Print</button>');

    popupWindow.document.write("</body></html>");
    popupWindow.document.close();
}



		});
	</script>
<?php endif; ?>