<?php
// echo "<pre>";
// print_r($attempts);
// echo "</pre>";
?>
<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fas fa-list-ul"></i> <?=translate('past_attempts')?></a>
			</li>
			<li>
				<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> <?=translate('take_exam')?></a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="list" class="tab-pane active">
				<table class="table table-bordered table-hover mb-none table-export">
					<thead>
						<tr>
							<th width="50"><?=translate('sl')?></th>
							<th><?=translate('exam')?></th>
							<th><?=translate('subject')?></th>
							<th><?=translate('year')?></th>
							<th><?=translate('score')?></th>
							<th><?=translate('duration')?></th>
							<th><?=translate('action')?></th>
						</tr>
					</thead>
					<tbody>
						<?php $count = 1; foreach($attempts as $row): ?>
						<tr>
							<td><?php echo $count++; ?></td>
							<td><?= $row->exam_name; ?></td>
							<td><?= $row->subject_name; ?></td>
							<td><?= $row->year_name; ?></td>
							<td><?= $row->score . '/20'; ?></td>
							<td><?= $row->duration; ?></td>
							<td class="action">
							    <a href="/exam_preparation/result/<?= $row->id;?>" class="btn btn-circle btn-default icon" data-toggle="tooltip" data-original-title="<?=translate('view')?>">
									<i class="fas fa-eye"></i>
								</a>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane" id="create">
				<?php echo form_open('/exam_preparation/take_exam', array('class' => 'validate'));?>
					<div class="form-horizontal form-bordered mb-lg">
						<div class="form-group">
                            <label class="col-md-3 control-label"><?=translate('Exam')?></label>
                            <div class="col-md-6">
                                <?php
                                        echo form_dropdown("exam_id", $exams, set_value('exam_id'), "class='form-control' id='exam_id' required
                                        data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
                                ?>
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?=translate('Subject')?></label>
                            <div class="col-md-6">
                                <?php
                                        echo form_dropdown("subject_id", [], set_value('subject_id'), "class='form-control' id='subject_id' required
                                        data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
                                ?>
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?=translate('Year')?></label>
                            <div class="col-md-6">
                                <?php
                                        echo form_dropdown("year_id", [], set_value('year_id'), "class='form-control' id='year_id' required
                                        data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
                                ?>
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?=translate('Duration (minutes)')?></label>
                            <div class="col-md-6">
                                <input type="number" readonly disabled placeholder="Enter time in minutes" name="duration" class="form-control" min="1" max="180" value="<?=set_value('duration', 20)?>" />
                                <span class="error"></span>
                            </div>
                        </div>
					</div>
					<footer class="panel-footer">
						<div class="row">
							<div class="col-md-offset-3 col-md-2">
								<button type="submit" class="btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
									<i class="fas fa-plus-circle"></i> <?=translate('take_exam')?>
								</button>
							</div>
						</div>
					</footer>
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
    initDatatable('.exam-list', 'exam_preparation/getExamListDT', {}, 25);
    
    
    $('#subject_id').prop('disabled', true);
    $('#year_id').prop('disabled', true);

    $('#exam_id').on('change', function () {
        let examId = $(this).val();
        if (!examId) {
            alert('Please select an Exam first!');
            $('#subject_id').empty().prop('disabled', true);
            return;
        }

        $.ajax({
            url: '<?= base_url("exam_preparation/getSubjectsByExam") ?>',
            method: 'POST',
            data: { exam_id: examId },
            success: function (data) {
                console.log(data)
                let subjects = JSON.parse(data);
                $('#subject_id').empty().append('<option value="">Select Subject</option>');
                $.each(subjects, function (i, subject) {
                    $('#subject_id').append(`<option value="${subject.id}">${subject.name}</option>`);
                });
                $('#subject_id').prop('disabled', false);
            }
        });
    });

    $('#subject_id').on('change', function () {
        let subjectId = $(this).val();
        if (!subjectId) {
            alert('Please select a Subject!');
            $('#year_id').empty().prop('disabled', true)
            return;
        }

        $.ajax({
            url: '<?= base_url("exam_preparation/getYearsBySubject") ?>',
            method: 'POST',
            data: { subject_id: subjectId },
            success: function (data) {
                let years = JSON.parse(data);
                $('#year_id').empty().append('<option value="">Select Year</option>');
                $.each(years, function (i, year) {
                    $('#year_id').append(`<option value="${year.id}">${year.year}</option>`);
                });
                $('#year_id').prop('disabled', false);
            }
        });
    });
});

	$(document).ready(function () {
		$(document).on('change', '#branch_id', function() {
			var branchID = $(this).val();
			$.ajax({
				url: "<?=base_url('ajax/getDataByBranch')?>",
				type: 'POST',
				data: {
					branch_id: branchID,
					table: 'exam_term'
				},
				success: function (data) {
					$('#term_id').html(data);
				}
			});
			
			$.ajax({
				url: "<?=base_url('ajax/getDataByBranch')?>",
				type: 'POST',
				data: {
					branch_id: branchID,
					table: 'exam'
				},
				success: function (data) {
					$('#parent_exam_id').html(data);
				}
			});

			$.ajax({
				url: "<?=base_url('exam/getDistributionByBranch')?>",
				type: 'POST',
				data: {
					branch_id: branchID,
				},
				success: function (data) {
					$('#mark_distribution').html(data);
				}
			});
		});


		// exam status
		$(".exam-status-switch").on("change", function() {
			var state = $(this).prop('checked');
			var id = $(this).data('id');
			if (state != null) {
				$.ajax({
					type: 'POST',
					url: base_url + "exam/publish_status",
					data: {
						id: id,
						status: state
					},
					dataType: "json",
					success: function (data) {
						if(data.status == true) {
							alertMsg(data.msg);
						}
					}
				});
			}
		});

		// publish result status
		$(".exam-result-switch").on("change", function() {
			var state = $(this).prop('checked');
			var id = $(this).data('id');
			if (state != null) {
				$.ajax({
					type: 'POST',
					url: base_url + "exam/publish_result_status",
					data: {
						id: id,
						status: state
					},
					dataType: "json",
					success: function (data) {
						if(data.status == true) {
							alertMsg(data.msg);
						}
					}
				});
			}
		});
	});
	
	$(document).ready(function () {
        const specialBranch = "<?= $this->config->item('branch_for_special_feature') ?>";
    
        $("#branch_id").change(function () {
            var selectedBranch = $(this).val();
            var subjectCodeDiv = $("#exam_category_div");
    
            
            if (selectedBranch === specialBranch) {
                subjectCodeDiv.show(); 
            } else {
                subjectCodeDiv.hide();
            }
        });
    });
    
    
    $(document).ready(function(){
        function getResult(id)
        {
            if(id)
            {
                $.ajax({
                    type: 'POST',
                    url: base_url + "exam_preparation/result",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function (data) {
                        
                    }
                })
            }
        }
    })

</script>