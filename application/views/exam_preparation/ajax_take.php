<?php 
if (!empty($questions)) {
	$totalQuestions = count($questions); 
	?>
<div class="row mt-lg">
	<div class="col-md-5">
		<div class="row">
		   <div class="col-sm-12">
				<section class="panel pg-fw">
				   <div class="panel-body">
				       <h5 class="chart-title mb-xs"><i class="fas fa-clock"></i> <?=translate('time') . " " . translate('status')?></h5>
				       <div class="time_status mt-md">
		               <div class="row">
		                   <div class="col-sm-6">
		                       <h4><?=translate('total') . " " . translate('time')?> :</h4>
		                   </div>
		                   <div class="col-sm-6">
		                       <h4 class="text-dark"><?= '20:00' ?></h4>
		                   </div>
		               </div>
		               <div class="row">
		                   <div class="col-sm-6">
		                       <h4><?=translate('remain_time')?> :</h4>
		                   </div>
		                   <div class="col-sm-6">
		                       <h4 class="remain_duration text-dark"><?='20'?></h4>
		                   </div>
		               </div>
				       </div>
				   </div>
				</section>
		   </div>
		   <div class="col-sm-12">
				<section class="panel pg-fw">
				   <div class="panel-body">
				       <h5 class="chart-title mb-xs"><i class="fas fa-circle-question"></i> <?=translate('total_questions_map')?></h5>
				       <div class="mt-lg">
							<nav>
								<ul class="on_answer_box questionColor">
								<?php foreach ($questions as $key => $question) {  ?>
									<li><a class="que_btn <?=$key == 0 ? 'active' : '' ?>" id="question<?php echo $key+1 ?>" href="javascript:void(0);" onclick="changeQuestion(<?php echo $key+1 ?>)"><?php echo $key+1 ?></a></li>
								<?php } ?>
								</ul>
							</nav>
				       </div>
				   </div>
				</section>
		   </div>
		</div>
	</div>
	<div class="col-md-7">
      <div class="box wizard" data-initialize="wizard" id="fueluxWizard">
        <div class="steps-container">
          <ul class="steps hidden" style="margin-left: 0;">
            <?php foreach (range(1, $totalQuestions) as $value) { ?>
              <li data-step="<?= $value ?>" class="<?= $value == 1 ? 'active' : '' ?>" id="question<?= $value ?>"></li>
            <?php } ?>
          </ul>
        </div>
        <?php echo form_open('exam_preparation/exam_submission', array('id' => 'answerForm')); ?>
        <input type="hidden" name="exam_id" value="<?= $exam_id ?>">
        <input type="hidden" name="year_id" value="<?= $year_id ?>">
        <input type="hidden" name="subject_id" value="<?= $subject_id ?>">
        <input type="hidden" id="duration_input" name="duration_input">
        <div class="box-body step-content">
          <?php foreach ($questions as $key => $question) { ?>
            <div class="clearfix step-pane <?= $key == 0 ? 'active' : '' ?>" data-step="<?= $key + 1 ?>">
              <section class="panel pg-fw">
                <div class="panel-body">
                  <h5 class="chart-title mb-xs">
                    <i class="fas fa-clipboard-question"></i> <?= translate('question') ?> <?= $key + 1 ?> of <?= $totalQuestions ?>
                  </h5>
                  <div class="d-flex mt-lg">
                    <p><?= $question->question ?> <?php if($question->explanation){ ?> | <button type="button" class="btn btn-info btn-sm"
                            onClick="fetchExplanation(<?=$question->question_id?>)">
                      <i title="AI explanation">i</i>
                    </button> <?php }; ?> 
                    </p>
                    <div class="mt-lg mb-sm question-panel" id="questionPanel<?= $key + 1 ?>" data-questionid="<?= $key + 1 ?>">
                      <?php
                      $quesOption = ['opt_1' => 1, 'opt_2' => 2, 'opt_3' => 3, 'opt_4' => 4];
                      foreach ($quesOption as $optKey => $optVal) {
                        if (!empty($question->{$optKey})) {
                          $savedAnswer = isset($previousAnswers[$question->question_id]) ? $previousAnswers[$question->question_id] : null;
                      ?>
                          <div class="radio-custom radio-success mt-md question-options">
                            <input class="question-input" type="radio" value="<?= $optVal ?>" name="answer[<?= $question->question_id ?>]" id="opt<?= $key . $optVal ?>" <?= ($savedAnswer == $optVal) ? 'checked' : '' ?>>
                            <label for="opt<?= $key . $optVal ?>"><?= $question->{$optKey} ?></label>
                          </div>
                      <?php }
                      } ?>
                      <?php if ($exam->marks_display == 1 || $exam->neg_mark == 1) { ?>
                        <div class="ques-marks mt-lg">
                          <div class="row">
                            <?php if ($exam->marks_display == 1) { ?>
                              <div class="col-xs-6"><span>Marks : <strong><?= $question->marks ?></strong></span></div>
                            <?php } if ($exam->neg_mark == 1) { ?>
                              <div class="col-xs-6 <?= $exam->marks_display == 1 ? 'text-right' : '' ?>">
                                <span><?= translate('negative_marks') ?> : <strong><?= $question->neg_marks ?></strong></span>
                              </div>
                            <?php } ?>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          <?php } ?>
          <div class="question-answer-button d-flex flex-wrap gap-2 mt-3">
            <button class="btn btn-default btn-prev" type="button" id="prevbutton" disabled>
              <i class="fa fa-angle-left"></i> Previous
            </button>
            <button class="btn btn-default btn-next" type="button" id="nextbutton" data-direction="next">
              Next <i class="fa fa-angle-right"></i>
            </button>
            <button class="btn btn-danger" type="button" onclick="clearAnswer()">
              <i class="fas fa-xmark"></i> Clear Answer
            </button>
            <button class="btn btn-default" type="button" id="finishedbutton" style="display:none" onclick="completeExams()">
              <i class="fas fa-check"></i> Submit
            </button>
          </div>
        </div>
        </form>
      </div>
    </div>
    <!-- Explanation Modal -->
    <div id="explanationModal" class="modal fade" role="dialog" style="background: rgba(255, 255, 255, .5);">
      <div class="modal-dialog modal-sm"> <!-- modal-sm makes it small -->
        <div class="modal-content">
          <header class="panel-heading">
            <h4 class="panel-title"><i class="fas fa-robot"></i> AI Explanation</h4>
          </header>
          <div class="modal-body" id="explanationContent" style="padding: 10px;">
            <p class="text-center">Loading...</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="$('#explanationModal').modal('hide')"> Close</button>
          </div>
        </div>
      </div>
    </div>


</div>
<?php } else { 
	echo '<div class="alert alert-subl mt-lg text-center">' . translate('no_questions_have_been_assigned') . ' !</div>';
} ?>
