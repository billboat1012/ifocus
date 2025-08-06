<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-list-ul"></i> <?=translate('online_exam') ." ". translate('list')?></h4>
	</header>
	<div class="panel-body">
		<table class="table table-bordered table-hover mb-none table-condensed exam-list" width="100%">
			<thead>
				<tr>
					<th class="no-sort"><?=translate('sl')?></th>
					<th><?=translate('title')?></th>
					<th><?=translate('class')?></th>
					<th class="no-sort"><?=translate('subject')?></th>
					<th><?=translate('questions_qty')?></th>
					<th><?=translate('start_time')?></th>
					<th><?=translate('end_time')?></th>
					<th><?=translate('duration')?></th>
					<th class="no-sort"><?=translate('exam') . " " . translate('fees')?></th>
					<th class="no-sort"><?=translate('exam_status')?></th>
					<th><?=translate('action')?></th>
				</tr>
			</thead>
		</table>
	</div>
</section>

<div class="zoom-anim-dialog modal-block modal-block-lg mfp-hide payroll-t-modal" id="modal">
	<section class="panel">
		<header class="panel-heading">
			<h4 class="panel-title"><i class="fas fa-users-between-lines"></i> <?php echo translate('exam_result'); ?></h4>
		</header>
		<div class="panel-body">
			<div id="quick_view"></div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button class="btn btn-default modal-dismiss"><?php echo translate('close'); ?></button>
				</div>
			</div>
		</footer>
	</section>
</div>

<div class="zoom-anim-dialog modal-block modal-block-lg mfp-hide payroll-t-modal" id="detailed_result_modal">
    <section class="panel">
        <header class="panel-heading">
            <h4 class="panel-title"><i class="fas fa-users-between-lines"></i> <?php echo translate('exam_result'); ?></h4>
        </header>
        <div class="panel-body">
            <div id="exam_result_view">
                <h5><strong>Exam:</strong> <span id="exam_name"></span></h5>
                <h4 class="mt-lg">Question Breakdown</h4>
                <div id="question_breakdown"></div>
            </div>
        </div>
        <footer class="panel-footer">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button class="btn btn-default modal-dismiss">Close</button>
                </div>
            </div>
        </footer>
    </section>
</div>

<div class="zoom-anim-dialog modal-block mfp-hide" id="payModal">
	<section class="panel">
		<?php echo form_open('onlineexam_payment/checkout', array('class' => ' frm-submit' )); ?>
		<header class="panel-heading">
			<h4 class="panel-title"><i class="fas fa-credit-card"></i> <?php echo translate('online_exam') . " " . translate('payment'); ?></h4>
		</header>
		<div class="panel-body">
			<div id="payForm"></div>
		</div>
		<footer class="panel-footer mt-md">
			<div class="row">
				<div class="col-md-12 text-right">
					<button class="btn btn-default modal-dismiss"><?php echo translate('cancel'); ?></button>
					<button type="submit" class="btn btn-default" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing"><?php echo translate('pay_now') ?></button>
				</div>
			</div>
		</footer>
		<?php echo form_close();?>
	</section>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		// initiate Datatable
		initDatatable('.exam-list', 'userrole/getExamListDT', {}, 25);


		$(document).on('change', '#payVia', function(){
			var method = $(this).val();
			if (method =="payumoney") {
				$('.payu').show(400);
				$('.sslcommerz').hide(400);
				$('.toyyibpay').hide(400);
			} else if (method =="sslcommerz") {
				$('.sslcommerz').show(400);
				$('.payu').hide(400);
				$('.toyyibpay').hide(400);
			} else if (method == "toyyibpay" || method == "payhere") {
				$('.toyyibpay').show(400);
				$('.sslcommerz').hide(400);
				$('.payu').hide(400);
			} else if (method =="toyyibpay") {
				$('.toyyibpay').show(400);
				$('.sslcommerz').hide(400);
				$('.payu').hide(400);
			} else{
				$('.sslcommerz').hide(400);
				$('.toyyibpay').hide(400);
				$('.payu').hide(400);
			}
		});
	});


function paymentModal(id) {
    $.ajax({
        url: base_url + 'userrole/getExamPaymentForm',
        type: 'POST',
        data: {'examID': id},
        dataType: "json",
        success: function (res) {
        	if (res.status == 1) {
	            $('#payForm').html(res.data);
				$('#payVia').themePluginSelect2({});
	            mfp_modal('#payModal');
        	} else {
        		alertMsg(res.message, "error", "<?php echo translate('error') ?>", "");
        	}
        }
    });
}



function getStudentDetailedResult(exam_id) {
    $.ajax({
        url: base_url + 'userrole/getStudentDetailedResult/' + exam_id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                alert(response.error);
                return;
            }
            
            console.log(response);

            $('#exam_name').text(response.exam_name);
            $('#exam_date').text(response.exam_start); // Fixed: No `date`, replaced with `exam_start`
            $('#exam_duration').text(response.duration);
            $('#total_marks').text(response.total_questions); // Fixed: `total_questions` instead of `total_marks`
            $('#obtain_marks').text(response.obtain_marks);
            $('#percentage').text(response.percentage);
            $('#exam_status').text(response.status);

            let breakdown = '';

            if (Array.isArray(response.answers)) {
                response.answers.forEach((q, index) => {
                    let cleanQuestion = q.question.replace(/<\/?[^>]+(>|$)/g, ""); // Remove unwanted HTML tags

                    // Function to clean HTML from options
                    function cleanHTML(html) {
                        return html ? html.replace(/<\/?[^>]+(>|$)/g, "").trim() : "N/A";
                    }

                    let options = {
                        1: cleanHTML(q.opt_1),
                        2: cleanHTML(q.opt_2),
                        3: cleanHTML(q.opt_3),
                        4: cleanHTML(q.opt_4)
                    };

                    let studentAnswerText = options[q.student_answer] || "No Answer";
                    let correctAnswerText = options[q.correct_answer] || "No Correct Answer";

                   let bgStyle = q.student_answer == q.correct_answer ? 'rgba(25, 135, 84, 0.2)' : 'rgba(220, 53, 69, 0.2)';

                    breakdown += `<div class='question-result-detail' style='background-color: ${bgStyle}; padding: 10px'>
                        <p><strong>Q${index+1}:</strong> ${cleanQuestion}</p>
                        <p><strong>Your Answer:</strong> ${studentAnswerText}</p>
                        <p><strong>Correct Answer:</strong> ${correctAnswerText}</p>
                        <p><strong>Marks Earned:</strong> ${q.marks_earned}</p>
                    </div><hr>`;
                });
            }

            $('#question_breakdown').html(breakdown);

            // Ensure modal exists before opening
            if ($('#detailed_result_modal').length) {
                mfp_modal('#detailed_result_modal'); // Open the modal
            } else {
                console.error("Modal element #detailed_result_modal not found!");
            }
        },
        error: function(xhr, status, error) {
            console.log("Error:", error);
            console.log("XHR:", xhr);
            console.log("Response:", xhr.responseText);
        }
    });
}


</script>