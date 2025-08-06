<section class="panel">
    <div class="panel-body">

        <?php
        // Score summary
        $score = isset($score) ? $score : 0;
        // $total = isset($total_questions) ? $total_questions : 20;
        $total = 20;

        // Rating system
        if ($score == 20) {
            $remark = "🎯 Certified genius! Hats up For You Chieftain";
        } elseif ($score >= 16) {
            $remark = "🔥 Big brain energy Chief!";
        } elseif ($score >= 10) {
            $remark = "😌 Not bad, but you can do better.";
        } elseif ($score >= 5) {
            $remark = "😬 Phew, that was Intense.";
        } else {
            $remark = "💀 Damn.";
        }
        ?>

        <div class="mb-md text-center">
            <h2>Score: <span class="text-primary"><?= $score ?> / <?= $total ?></span></h2>
            <p><?= $remark ?></p>
        </div>

        <hr>

        <?php if (!empty($q_and_a)) : ?>
            <ol>
                <?php foreach ($q_and_a as $q) : ?>
                    <?php
                    $isCorrect = $q['chosen'] == $q['correct_answer'];
                    $chosenClass = $isCorrect ? 'text-success' : 'text-danger';
                    ?>
                    <li class="mb-sm">
                        <p><strong><?= $q['question'] ?></strong></p>
                        <ul style="list-style: none; padding-left: 0;">
                            <?php for ($i = 1; $i <= 4; $i++) : ?>
                                <li>
                                    <?php
                                    $labelClass = '';
                                    if ($q['chosen'] == $i && !$isCorrect && $q['correct_answer'] != $i) {
                                        $labelClass = 'text-danger'; // wrong choice
                                    } elseif ($q['chosen'] == $i && $isCorrect) {
                                        $labelClass = 'text-success'; // correct choice
                                    } elseif ($q['correct_answer'] == $i && $q['chosen'] != $i) {
                                        $labelClass = 'text-success'; // correct answer not picked
                                    }
                                    ?>
                                    <span class="<?= $labelClass ?>">
                                        <?= $i ?>. <?= $q[$i] ?>
                                        <?php if ($q['chosen'] == $i) : ?>
                                            <strong>(Your choice)</strong>
                                        <?php endif; ?>
                                        <?php if ($q['correct_answer'] == $i) : ?>
                                            <em>(Correct)</em>
                                        <?php endif; ?>
                                    </span>
                                </li>
                            <?php endfor; ?>
                        </ul>
                        <hr>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php else : ?>
            <p>No questions available for review.</p>
        <?php endif; ?>
        
        <div class="mb-md text-center">
            <?php echo form_open('/exam_preparation/take_exam', array('class' => 'validate'));?>
                <input type="hidden" name="exam_id" value="<?= $exam->exam_id?>"/>
                <input type="hidden" name="year_id" value="<?= $exam->year_id?>"/>
                <input type="hidden" name="subject_id" value="<?= $exam->subject_id?>"/>
                <div class="mb-md text-center">
					<button type="submit" class="col-md-5 col-12 btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
					    <i class="fas fa-plus-circle"></i> <?=translate('attempt_again')?>
					</button>
				</div>
            </form>
        </div>
    </div>
</section>
