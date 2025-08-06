<style type="text/css">
	.radio-custom p {
		margin: 0;
	}
</style>
<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-list-ul"></i> <?=translate('exam_preparation') ." ". translate('list')?></h4>
	</header>
	<div class="panel-body">
		<h4 class="text-center mb-lg mt-lg"><span class="text-weight-bold"><?=translate('exam') ." ". translate('name')?> </span> : <?php echo $exam['exam_name']; ?></h4>
		<div class="table-responsive mb-md">
			<table class="table table-striped table-condensed mb-none">
				<tbody>
					<tr>
						<th><?=translate('subject')?></th>
						<td><?php echo $exam['subject_name']; ?></p></td>
						
						<th><?=translate('year')?></th>
						<td><?php echo $exam['year_name']; ?></td>
					</tr>
					<tr>
						<th><?=translate('total') . " " . translate('questions')?></th>
						<td><?php echo 20; ?></td>
						<th><?=translate('duration')?></th>
						<td><?php echo 20 . ' minutes'; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
            <div class="text-center">
                <button class="btn btn-default btn-lg mt-lg start_btn" 
                    data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing"
                    data-examid="<?= $exam_id ?>"
                    data-subjectid="<?= $subject_id ?>"
                    data-yearid="<?= $year_id ?>"
                    data-subject="<?= $exam['subject_name'] ?>"
                    data-year="<?= $exam['year_name'] ?>"
                >
                    <i class="fas fa-computer-mouse"></i> <?= translate('start_exam') ?>
                </button>
            </div>
	    </div>
</section>
<div class="questionmodal">
      <div id="ans_modalBox" class="modal fade" role="dialog">
         <div class="modal-dialog modal-dialogfullwidth">
            <!-- Modal content-->
            <div class="modal-content modal-contentfull">
               <div class="modal-header">
                  <button type="button" class="close questionclose" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><i class="fas fa-users-between-lines"></i> <?php echo $exam['exam_name'] . ' - '  . $exam['subject_name'] . ' - ' . $exam['year_name']; ?></h4>
               </div>
               <div class="modal-body">
               	<div id="online_questions"></div>
               </div>
            </div>
         </div>
      </div>
</div>

<script>
    var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';
</script>

<script type="text/javascript">
	var examDuration = "<?php echo 20 ?>"; // in minutes
	var totalQuestions = 20;
	var currentStep = 1;
	var remainingTime = examDuration * 60; // in seconds
	var interval;
	let totalDuration = examDuration * 60;

	$(document).on('click', '.start_btn', function () {
		elapsed_seconds = 0;
		var $this = $(this);
		var examID = $this.attr("data-examid");
		var yearID = $this.attr("data-yearid");
		var subjectID = $this.attr("data-subjectid");
		var subject = $this.attr('data-subject');
		var year = $this.attr('data-year');

		$.ajax({
			type: 'POST',
			url: base_url + "exam_preparation/ajaxQuestions",
			data: {
				exam_id: examID,
				subject_id: subjectID,
				year_id: yearID,
				subject: subject,
				year: year
			},
			dataType: 'JSON',
			beforeSend: function () {
				$this.button('loading');
				clearInterval(interval);
			},
			success: function (data) {
				if (data.status == 1 && $('#online_questions').length) {
					totalQuestions = 20;
					$('#online_questions').html(data.page);
					updateAttemptedStatus();

					$('#fueluxWizard').on('actionclicked.fu.wizard', function (e, data) {
						var steps = data.direction === "next" ? data.step + 1 : data.step - 1;
						var btn = $('#question' + steps).addClass('active');
						$(".que_btn").not(btn).removeClass('active');

						const resp = updateCompleteButtonState();

						if (steps === totalQuestions) {
							if (resp) {
								$('#nextbutton')
									.html('<i class="fas fa-check"></i>')
									.attr('data-direction', '')
									.hide();
								$('#finishedbutton').show();
							} else {
								$('#nextbutton').hide();
								$('#finishedbutton').hide();
							}
						} else {
							if(resp)
							{
							    $('#nextbutton')
									.html('<i class="fas fa-check"></i>')
									.attr('data-direction', '')
									.hide();
								$('#finishedbutton').show();
							} else {
							    $('#nextbutton')
								.html('<?=translate('next')?> <i class="fa fa-angle-right"></i>')
								.attr('data-direction', 'next')
								.show();
							    $('#finishedbutton').hide();
							}
						}

						currentStep = steps;
						makeAnswered(data.step);
					});

					timer();

					$('#ans_modalBox').modal({
						show: true,
						backdrop: 'static',
						keyboard: false
					});
				} else {
					alertMsg(data.message, "error", "<?php echo translate('error') ?>", "");
				}
			},
			error: function (xhr) {
				console.log(xhr);
				alert("Error occurred. Please try again.");
				$this.button('reset');
			},
			complete: function () {
				$this.button('reset');
			}
		});
	});

	function savePartialAnswer(questionID) {
		var formData = $('#answerForm').serialize();
		$.ajax({
			type: 'POST',
			url: base_url + "exam_preparation/onlineexam_partial_save",
			data: formData,
			dataType: 'JSON',
			success: function () {},
			error: function (xhr) {
				console.log("Error in temporary save. Please try again.");
			}
		});
	}

	function changeQuestion(questionID) {
		currentStep = questionID;
		makeAnswered(currentStep);
		makeAnswered(questionID);

		$('#fueluxWizard').wizard('selectedItem', { step: questionID });

		var btn = $('#question' + questionID).addClass('active');
		$(".que_btn").not(btn).removeClass('active');

		const resp = updateCompleteButtonState();

		if (questionID == totalQuestions) {
			if (resp) {
				$('#nextbutton')
					.html('<i class="fas fa-check"></i>')
					.attr('data-direction', '')
					.hide();
				$('#finishedbutton').show();
			} else {
				$('#nextbutton').hide();
				$('#finishedbutton').hide();
			}
		} else {
			if(resp)
			{
			    $('#nextbutton')
					.html('<i class="fas fa-check"></i>')
					.attr('data-direction', '')
					.hide();
				$('#finishedbutton').show();
			} else {
			    $('#nextbutton')
				.html('<?=translate('next')?> <i class="fa fa-angle-right"></i>')
				.attr('data-direction', 'next')
				.show();
			    $('#finishedbutton').hide();
			}
		}
	}

	function completeExams() {
		$('#answerForm').submit();
	}

	function padZero(num) {
		return num < 10 ? '0' + num : num;
	}

	function durationUpdate() {
		if (remainingTime > 0) {
			remainingTime--;
			let minutes = Math.floor(remainingTime / 60);
			let seconds = remainingTime % 60;
			if (remainingTime <= 60) {
				$('.remain_duration').addClass('text-danger blink');
			}
			return { formatted: `${padZero(minutes)}:${padZero(seconds)}`, remaining: remainingTime };
		} else {
			clearInterval(interval);
			alert("⏰ Time's up! Submitting your answers...");
			$('#answerForm').submit();
			return { formatted: "00:00", remaining: 0 };
		}
	}

	var timer = function () {
		$('.remain_duration').text(`${padZero(Math.floor(remainingTime / 60))}:${padZero(remainingTime % 60)}`);
		interval = setInterval(function () {
			const timeData = durationUpdate();
			$('.remain_duration').text(timeData.formatted);
			let elapsed = totalDuration - timeData.remaining;
			let elapsedMinutes = Math.floor(elapsed / 60);
			let elapsedSeconds = elapsed % 60;
			let elapsedFormatted = `${padZero(elapsedMinutes)}:${padZero(elapsedSeconds)}`;
			$('#duration_input').val(elapsedFormatted);
		}, 1000);
	};

	function makeAnswered(questionID) {
		let btn = $('#question' + questionID);
		btn.addClass('attempted');
	}

	function clearAnswer(questionID = currentStep) {
		$(`#questionPanel${questionID} input[type="radio"], #questionPanel${questionID} input[type="checkbox"]`).prop('checked', false);
		$('#question' + questionID).removeClass('attempted');
		
		updateCompleteButtonState();
		
		const resp = updateCompleteButtonState();

		if (questionID == totalQuestions) {
			if (resp) {
				$('#nextbutton')
					.html('<i class="fas fa-check"></i>')
					.attr('data-direction', '')
					.hide();
				$('#finishedbutton').show();
			} else {
				$('#nextbutton').hide();
				$('#finishedbutton').hide();
			}
		} else {
			if(resp)
			{
			    $('#nextbutton')
					.html('<i class="fas fa-check"></i>')
					.attr('data-direction', '')
					.hide();
				$('#finishedbutton').show();
			} else {
			    $('#nextbutton')
				.html('<?=translate('next')?> <i class="fa fa-angle-right"></i>')
				.attr('data-direction', 'next')
				.show();
			    $('#finishedbutton').hide();
			}
		}
	}

	function updateAttemptedStatus() {
		$('.question-panel').each(function () {
			let questionID = $(this).data('questionid');
			let hasAnswer = $(this).find('input:checked').length > 0;
			let btn = $('#question' + questionID);
			btn.toggleClass('attempted', hasAnswer);
		});
	}

	$(document).on('change', '.question-options input[type="radio"], .question-options input[type="checkbox"]', function () {
		let questionID = $(this).closest('.question-panel').data('questionid');
		if (!questionID) return;
		let hasAnswer = $(this).closest('.question-panel').find('input:checked').length > 0;
		let btn = $('#question' + questionID);
		btn.toggleClass('attempted', hasAnswer);
		
		const resp = updateCompleteButtonState();

		if (questionID == totalQuestions) {
			if (resp) {
				$('#nextbutton')
					.html('<i class="fas fa-check"></i>')
					.attr('data-direction', '')
					.hide();
				$('#finishedbutton').show();
			} else {
				$('#nextbutton').hide();
				$('#finishedbutton').hide();
			}
		} else {
			if(resp)
			{
			    $('#nextbutton')
					.html('<i class="fas fa-check"></i>')
					.attr('data-direction', '')
					.hide();
				$('#finishedbutton').show();
			} else {
			    $('#nextbutton')
				.html('<?=translate('next')?> <i class="fa fa-angle-right"></i>')
				.attr('data-direction', 'next')
				.show();
			    $('#finishedbutton').hide();
			}
		}
		
		updateCompleteButtonState();
	});

	function updateCompleteButtonState() {
		let answeredQuestionIds = new Set();
		$('input[type="radio"]:checked').each(function () {
			let name = $(this).attr('name');
			let questionID = name.match(/\d+/);
			if (questionID) {
				answeredQuestionIds.add(questionID[0]);
			}
		});
		return answeredQuestionIds.size >= totalQuestions;
	}
	
	
	function fetchExplanation(id) {
      $('#explanationContent').html('<p class="text-center">Loading...</p>');
      var data = {};
      data[csrfName] = csrfHash;
      data['id'] = id;
    
      $.ajax({
        type: 'POST',
        url: base_url + 'exam_preparation/fetch_explanation',
        data: data,
        dataType: 'JSON',
        success: function (response) {
          $('#explanationContent').html(response.explanation || '<p>No explanation found.</p>');
          $('#explanationModal').modal('show');
        },
        error: function (xhr) {
          console.error(xhr);
          $('#explanationContent').html('<p class="text-danger">Error fetching explanation. Please try again.</p>');
          $('#explanationModal').modal('show');
        }
      });
    }


</script>



<!-- Add this lil CSS spice for the blink warning -->
<style>
	.blink {
		animation: blinker 1s linear infinite;
	}
	@keyframes blinker {
		50% {
			opacity: 0;
		}
	}


</style>
