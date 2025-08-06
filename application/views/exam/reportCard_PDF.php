<?php $marksheet_template = $this->marksheet_template_model->getTemplate($templateID, $branchID);

$headerBgColor = $marksheet_template['header_bg_color'];

$headerTextColor = $marksheet_template['header_text_color'] ?? '#ffffff';

$schoolName = $marksheet_template['school_name'] ?? ($branchDetail->name ?? '');

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<?php

$extINTL = extension_loaded('intl');

if (!empty($student_array)) {

    foreach ($student_array as $sc => $studentID) {

        $result = $this->exam_model->getStudentReportCard($studentID, $examID, $sessionID, $class_id);

        $classAverage = $this->exam_model->getExamStudentScores($branchID, $class_id, $examID, $sessionID);

        $student = $result['student'];

        $getMarksList = $result['exam'];

        $rankDetail = $this->db->where(array('exam_id ' => $examID, 'enroll_id  ' => $student['enrollID']))->get('exam_rank')->row();

        $getExam = $this->db->where(array('id' => $examID))->get('exam')->row_array();

        $schoolYear = get_type_name_by_id('schoolyear', $sessionID, 'school_year');

        $extendsData = [];

        $extendsData['print_date'] = $print_date;

        $extendsData['schoolYear'] = $schoolYear;
        
        $extendsData['term'] = $this->marksheet_template_model->getExamTerm($getExam['term_id']);

        $extendsData['exam_name'] = $getExam['name'];

        $extendsData['teacher_comments'] = empty($rankDetail->teacher_comments) ? '' : $rankDetail->teacher_comments;

        if ($getExam['branch_id'] == $this->config->item('branch_for_special_feature')) {

            $extendsData['hostel_comment'] = empty($rankDetail->hostel_comment) ? '' : $rankDetail->hostel_comment;
        }

        $extendsData['principal_comments'] = empty($rankDetail->principal_comments) ? '' : $rankDetail->principal_comments;

        $header_content = $this->marksheet_template_model->tagsReplace($student, $marksheet_template, $extendsData, 'header_content');

        $footer_content = $this->marksheet_template_model->tagsReplace($student, $marksheet_template, $extendsData, 'footer_content');

        $branchDetail = $this->db->where(array('id ' => $getExam['branch_id']))->get('branch')->row();
?>

        <div style="position: relative; width: 100%;">
            <div class="mark-container">
                <table border="0" class="row company-header" style="margin: 0px !important; padding: 0 !important; border-color: transparent !important; width: 100%; text-align: center; background-color: <?= $headerBgColor ?: '#0F335C' ?> !important;">
                    <tr style="border: 1px solid #000 !important">
                        <td style="width: 15%; vertical-align: middle; padding: 8px; border: 1px solid #000 !important">
                            <img width="80" style="display: block; margin: auto;"
                                src="<?= base_url('uploads/marksheet/' . $marksheet_template['logo']) ?>" />
                        </td>
                        <?php
                        $color = '';
                        $textColor = 'white';
                        if (!$color) {
                            $textColor = 'black';
                        }
                        ?>
                        <td style="width: 85%; text-align: center; border: 1px solid #000 !important; padding: 8px !important">
                            <h2 style="color: <?= $headerTextColor ?: '#fff' ?> !important; margin: 0; font-size: 18px; font-weight: bold; text-align: center;">
                                <?= $schoolName ?: $branchDetail->name; ?>
                            </h2>
                            <p style="font-size: 12px; color: <?= $headerTextColor ?: '#fff' ?> !important; margin: 5px 0; text-align: center;">
                                <?= $branchDetail->address; ?>
                            </p>
                            <p style="font-size: 12px; color: <?= $headerTextColor ?: '#fff' ?> !important; margin: 0; text-align: center;">
                                <span style="font-weight: bold;">TEL:</span> <?= $branchDetail->mobileno; ?>
                                | <span style="font-weight: bold;">EMAIL:</span> <?= $branchDetail->email; ?>
                            </p>
                        </td>
                    </tr>
                </table>

                <?php if (!empty($header_content)) echo $header_content; ?>

                <?php if ($getExam['type_id'] == 4) : $exams = $result['exam']; ?>
                    <table class="table table-bordered table-condensed section-spacing" style="width: 100%; margin: 10px 0 !important;">
                        <tbody>
                            <tr style="border: 1px solid #000 !important">
                                <th colspan="2" class="text-center" style="background-color: <?= $headerTextColor ?: '#0F335C' ?> !important;-webkit-print-color-adjust: exact;text-align: center;color: <?= $headerBgColor ?: '#fff' ?> !important;font-weight: bold;font-size: 14px; padding: 6px;">STUDENT ACADEMIC PERFORMANCE RECORD
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <?php foreach ($exams as $exam) {
                        $subSubject = $this->exam_model->getSubSubjectId($exam['subject_id']);
                    ?>
                        <table style="width: 100%; border-collapse: collapse; margin: 8px 0 !important;">
                            <tr style="border: 1px solid #000 !important">
                                <th style="border: 1px solid #000; padding: 4px; text-align: center; font-size: 10px;">
                                    <?php echo $exam['subject_name']; ?>
                                </th>
                                <?php
                                $mark_distribution = json_decode($exam['mark_distribution'], true);
                                $keys = array_keys($mark_distribution);
                                foreach ($keys as $key) { ?>
                                    <th style="border: 1px solid #000; padding: 4px; text-align: center; font-size: 10px;">
                                        <?php echo get_type_name_by_id('exam_mark_distribution', $key); ?>
                                    </th>
                                <?php } ?>
                            </tr>
                            <?php foreach ($subSubject as $id => $sub) { ?>
                                <?php $submark = $this->exam_model->getMarkBySubSubjectID($studentID, $exam['subject_id'], $examID, $id); ?>
                                <tr style="border: 1px solid #000 !important">
                                    <th style="border: 1px solid #000; padding: 4px; text-align: center; font-size: 10px;">
                                        <?php echo $sub; ?>
                                    </th>
                                    <?php foreach ($keys as $key) { ?>
                                        <th style="border: 1px solid #000; padding: 4px; text-align: center; font-size: 10px;">
                                            <?php if (!empty($submark) && isset($submark[$key])) { echo '✔️'; } ?>
                                        </th>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </table>
                    <?php } ?>
                <?php elseif ($getExam['type_id'] != 4) : ?>
                    <table class="table table-condensed table-bordered section-spacing" style="margin: 10px 0 !important;">
            <?php
            $colspan = ($student['is_third_term'] == 1) ? 13 : 11;
            ?>
                        <thead>
                            <tr style="border: 1px solid #000 !important">
                                <th colspan="<?=$colspan;?>" class="text-center" style="background-color: <?= $headerTextColor ?: '#0F335C' ?> !important;-webkit-print-color-adjust: exact;text-align: center;color: <?= $headerBgColor ?: '#fff' ?> !important;font-weight: bold;font-size: 14px; padding: 6px;">STUDENT ACADEMIC PERFORMANCE RECORD</th>
                            </tr>



                            <tr style="border: 1px solid #000 !important">
                                <th style="font-size: 10px; padding: 4px;">Subjects</th>
                                <?php
                                $markDistribution = json_decode($getExam['mark_distribution'], true);
                                foreach ($markDistribution as $id) {
                                ?>
                                    <th style="font-size: 10px; padding: 4px;"><?php echo get_type_name_by_id('exam_mark_distribution', $id) ?></th>
                                <?php } ?>
                                <?php if ($getExam['type_id'] == 1) { ?>
                                    <th style="font-size: 10px; padding: 4px;">Total</th>
                                    <?php if($student['is_third_term'] == 1){ ?>
                                    <th style="font-size: 10px; padding: 4px;">1st Term</br>(100)</th>
                                    <th style="font-size: 10px; padding: 4px;">2nd Term</br>(100)</th>
                                    <th style="font-size: 10px; padding: 4px;">Session</br>Average</th>
                                    <?php }; ?>
                                <?php } elseif ($getExam['type_id'] == 2) { ?>
                                    <th style="font-size: 10px; padding: 4px;">Grade</th>
                                    <th style="font-size: 10px; padding: 4px;">Point</th>
                                    <?php if ($marksheet_template['remark'] == 1) { ?>
                                        <th style="font-size: 10px; padding: 4px;">Remark</th>
                                    <?php } ?>
                                <?php } elseif ($getExam['type_id'] == 3) { ?>
                                    <th style="font-size: 10px; padding: 4px;">Total</th>
                                    
                                    <?php if($student['is_third_term'] == 1){ ?>
                                    <th style="font-size: 10px; padding: 4px;">1st Term</br>(100)</th>
                                    <th style="font-size: 10px; padding: 4px;">2nd Term</br>(100)</th>
                                    <th style="font-size: 10px; padding: 4px;">Session</br> Average</th>
                                    <?php }; ?>
                                    <th style="font-size: 10px; padding: 4px;">Grade</th>
                                    <th style="font-size: 10px; padding: 4px;">Point</th>
                                    <?php if ($marksheet_template['subject_position'] == 1) { ?>
                                        <th style="font-size: 10px; padding: 4px;">Subject Position</th>
                                    <?php } ?>
                                    <?php if ($marksheet_template['remark'] == 1) { ?>
                                        <th style="font-size: 10px; padding: 4px;">Remark</th>
                                    <?php } ?>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody class="border border-danger" style="margin: 0 !important;">
                            <?php
                            $colspan = count($markDistribution) + 1;
                            $total_grade_point = 0;
                            $grand_obtain_marks = 0;
                            $grand_full_marks = 0;
                            $result_status = 1;
                            foreach ($getMarksList as $row) {
                            ?>
                                <tr style="border: 1px solid #000 !important">
                                    <td valign="middle" width="22%" style="font-weight: bold; font-size: 10px; padding: 4px;"><?= $row['subject_name'] ?></td>
                                    <?php
                                    $total_obtain_marks = 0;
                                    $total_full_marks = 0;
                                    $fullMarkDistribution = json_decode($row['mark_distribution'], true);
                                    $obtainedMark = json_decode($row['get_mark'], true);
                                    foreach ($fullMarkDistribution as $i => $val) {
                                        $obtained_mark = floatval($obtainedMark[$i]);
                                        $fullMark = floatval($val['full_mark']);
                                        $passMark = floatval($val['pass_mark']);
                                        if ($obtained_mark < $passMark) {
                                            $result_status = 0;
                                        }

                                        $total_obtain_marks += $obtained_mark;
                                        $obtained = $row['get_abs'] == 'on' ? 'Absent' : $obtained_mark;
                                        $total_full_marks += $fullMark;
                                    ?>
                                        <?php if ($getExam['type_id'] == 1 || $getExam['type_id'] == 3) { ?>
                                            <td valign="middle" style="font-size: 10px; padding: 4px;">
                                                <?php
                                                if ($row['get_abs'] == 'on') {
                                                    echo 'Absent';
                                                } else {
                                                    echo $obtained_mark;
                                                }
                                                ?>
                                            </td>
                                        <?php }
                                        if ($getExam['type_id'] == 2) { ?>
                                            <td valign="middle" style="font-size: 10px; padding: 4px;">
                                                <?php
                                                if ($row['get_abs'] == 'on') {
                                                    echo 'Absent';
                                                } else {
                                                    $percentage_grade = ($obtained_mark * 100) / $fullMark;
                                                    $grade = $this->exam_model->get_grade($percentage_grade, $getExam['branch_id']);
                                                    echo $grade['name'];
                                                }
                                                ?>
                                            </td>
                                        <?php } ?>
                                    <?php
                                    }
                                    $grand_obtain_marks += $total_obtain_marks;
                                    $grand_full_marks += $total_full_marks;
                                    ?>
                                    <?php if ($getExam['type_id'] == 1 || $getExam['type_id'] == 3) { ?>
                                        <td valign="middle" style="font-size: 10px; padding: 4px;"><?= $total_obtain_marks ?></td>
                                        
                                        <?php if($student['is_third_term'] == 1){ ?>
                                        <td valign="middle" style="font-size: 10px; padding: 4px;">
                                            <?=$row['first_term_total']; ?>
                                        </td>
                                        <td style="font-size: 10px; padding: 4px;">
                                            <?= $row['second_term_total']; ?>
                                        </td>
                                        <td style="font-size: 10px; padding: 4px;">
                                            <?= $row['session_average']; ?>
                                        </td>
                                        <?php }; ?>
                                    <?php }
                                    if ($getExam['type_id'] == 2) {
                                        $colspan += 1;
                                        $percentage_grade = ($total_obtain_marks * 100) / $total_full_marks;
                                        $grade = $this->exam_model->get_grade($percentage_grade, $getExam['branch_id']);
                                        $total_grade_point += $grade['grade_point'];
                                    ?>
                                        <td valign="middle" style="font-size: 10px; padding: 4px;"><?= $grade['name'] ?></td>
                                        <td valign="middle" style="font-size: 10px; padding: 4px;"><?= number_format($grade['grade_point'], 2, '.', '') ?></td>
                                        <?php if ($marksheet_template['remark'] == 1) { ?>
                                            <td valign="middle" style="font-size: 10px; padding: 4px;"><?= $grade['remark'] ?></td>
                                        <?php } ?>
                                    <?php }
                                    if ($getExam['type_id'] == 3) {
                                        $colspan += 2;
                                        $percentage_grade = ($total_obtain_marks * 100) / $total_full_marks;
                                        $grade = $this->exam_model->get_grade($percentage_grade, $getExam['branch_id']);
                                        $total_grade_point += $grade['grade_point'] ?? 0;
                                    ?>
                                        <td valign="middle" style="font-size: 10px; padding: 4px;"><?= $grade['name'] ?></td>
                                        <td valign="middle" style="font-size: 10px; padding: 4px;"><?= number_format($grade['grade_point'], 2, '.', '') ?></td>
                                        <?php if ($marksheet_template['subject_position'] == 1) { ?>
                                            <td valign="middle" style="font-size: 10px; padding: 4px;"><?php echo $this->exam_progress_model->getSubjectPosition($student['class_id'], [$examID], $sessionID, $row['subject_id'], $total_obtain_marks); ?></td>
                                        <?php } ?>
                                        <?php if ($marksheet_template['remark'] == 1) { ?>
                                            <td valign="middle" style="font-size: 10px; padding: 4px; color:<?php if ($grade['remark'] == 'FAIL') {
                                                                                                                echo 'red';
                                                                                                            } else {
                                                                                                                echo 'green';
                                                                                                            } ?>;"><?= $grade['remark'] ?></td>
                                        <?php } ?>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                <?php endif; ?>

                <table style="width: 100%; margin: 10px 0 !important;" class="section-spacing">
                    <tr>
                        <td style="width: 60%; padding: 0; vertical-align: top;">
                            <table class="table table-condensed table-bordered" style="width:100%; margin: 0 !important;">
                                <tbody>
                                    <tr style="border: 1px solid #000 !important">
                                        <th colspan="2" class="text-center" style="background-color: <?= $headerTextColor ?: '#0F335C' ?> !important;-webkit-print-color-adjust: exact;text-align: center;color: <?= $headerBgColor ?: '#fff' ?> !important;font-weight: bold;font-size: 12px; padding: 6px;">ACADEMIC RECORDS SUMMARY</th>
                                    </tr>

                                    <?php if ($getExam['type_id'] == 1 || $getExam['type_id'] == 3) { ?>
                                        <tr style="border: 1px solid #000 !important">
                                            <td valign="top" style="font-size: 10px; padding: 4px;"><strong>TOTAL SCORE:</strong> <?= $grand_obtain_marks; ?> OF <?= $grand_full_marks ?></td>
                                            <?php
                                            $studentCount = $this->exam_model->searchExamStudentsByRank($class_id, $sessionID, $examID, $branchID);
                                            $totalStudents = count($studentCount);
                                            ?>
                                            <td style="font-size: 10px; padding: 4px;">
                                                <strong>Class Average:</strong>
                                                <?php echo number_format($classAverage, 2, '.', '') . '%'; ?>
                                            </td>
                                            <?php if ($marksheet_template['result'] == 1) { ?>
                                                <td style="font-size: 10px; padding: 4px;"><strong>Result</strong>: <?= $result_status == 0 ? 'Fail' : 'Promoted'; ?></td>
                                            <?php } ?>
                                        </tr>
                                        <tr style="border: 1px solid #000 !important">
                                            <?php if ($extINTL == true) { ?>
                                                <td valign="top" style="font-size: 10px; padding: 4px;"><strong>Learners Average:</strong> <?php $percentage = ($grand_full_marks > 0) ? ($grand_obtain_marks * 100) / $grand_full_marks : 0;
                                                                                                                                            echo number_format($percentage, 2, '.', '') ?>%</td>
                                            <?php } ?>
                                        <?php }
                                    if ($getExam['type_id'] == 2) { ?>
                                            <td style="font-size: 10px; padding: 4px;"><strong>GPA:</strong> <?= number_format(($total_grade_point / count($getMarksList)), 2, '.', '') ?></td>
                                        <?php }
                                    if ($getExam['type_id'] == 3) { ?>
                                            <td style="font-size: 10px; padding: 4px;"><strong>GPA:</strong><?= number_format(($getMarksList && count($getMarksList) > 0) ? ($total_grade_point / count($getMarksList)) : 0, 2, '.', '') ?></td>
                                        <?php } ?>
                                        <?php if ($marksheet_template['position'] == 1) { ?>
                                            <td colspan="2" style="font-size: 10px; padding: 4px;"><strong>Position:</strong> <?php echo (!empty($rankDetail->rank) ? $rankDetail->rank : translate("not_generated")); ?></td>
                                        <?php } ?>
                                        </tr>
                                </tbody>
                            </table>

                            <?php if ($marksheet_template['attendance_percentage'] == 1) {
                                $year = explode('-', $schoolYear);
                                $this->db->select('days_present, total_days');
                                $this->db->where([
                                    'class_id'   => $class_id,
                                    'branch_id'  => $branchID,
                                    'exam_id'    => $examID,
                                    'session_id' => $sessionID,
                                    'student_id' => $student['id'],
                                ]);
                                $manualAttendance = $this->db->get('attendance_update')->row_array();

                                if (!empty($manualAttendance)) {
                                    // Use manual attendance
                                    $totalAttendance = (int)$manualAttendance['days_present'];
                                    $totalWorkingDays = (int)$manualAttendance['total_days'];
                                } else {
                                    // Fallback to student_attendance
                                    $getTotalWorking = $this->db
                                        ->where(['enroll_id' => $student['enrollID']])
                                        ->where('YEAR(date)', $year[1], false)
                                        ->get('student_attendance')
                                        ->num_rows();

                                    $getTotalAttendance = $this->db
                                        ->where(['enroll_id' => $student['enrollID'], 'status' => 'P'])
                                        ->where('YEAR(date)', $year[1], false)
                                        ->get('student_attendance')
                                        ->num_rows();

                                    $totalAttendance = $getTotalAttendance;
                                    $totalWorkingDays = $getTotalWorking;
                                }

                                // Final percentage calculation
                                $attenPercentage = $totalWorkingDays === 0 ? '0.00' : ($totalAttendance * 100) / $totalWorkingDays;
                            ?>
                                <table class="table table-bordered table-condensed" style="width: 100%; margin: 10px 0 !important;" class="section-spacing">
                                    <tbody>
                                        <tr style="border: 1px solid #000 !important">
                                            <th colspan="2" class="text-center" style="background-color: <?= $headerTextColor ?: '#0F335C' ?> !important;-webkit-print-color-adjust: exact;text-align: center;color: <?= $headerBgColor ?: '#fff' ?> !important;font-weight: bold;font-size: 12px; padding: 6px;">ATTENDANCE</th>
                                        </tr>
                                        <tr style="border: 1px solid #000 !important">
                                            <th style="width: 65%; font-size: 10px; padding: 4px;">No. of times school opened</th>
                                            <td style="font-size: 10px; padding: 4px;"><?= $totalWorkingDays ?></td>
                                        </tr>
                                        <tr style="border: 1px solid #000 !important;">
                                            <th style="width: 65%; font-size: 10px; padding: 4px;">No. of days attended</th>
                                            <td style="font-size: 10px; padding: 4px;"><?= $totalAttendance ?></td>
                                        </tr>
                                        <tr style="border: 1px solid #000 !important">
                                            <th style="width: 65%; font-size: 10px; padding: 4px;">Attendance Percentage</th>
                                            <td style="font-size: 10px; padding: 4px;"><?= number_format($attenPercentage, 2, '.', '') ?>%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php } ?>
                        </td>

                        <td style="width: 40%; padding: 0; vertical-align: top;">
                            <?php if ($marksheet_template['grading_scale'] == 1) {
                                if ($getExam['type_id'] != 4) :
                                    if ($getExam['type_id'] != 1) { ?>
                                        <table class="table table-condensed table-bordered" style="width: 100%; margin: 0 !important;">
                                            <tbody>
                                                <tr style="border: 1px solid #000 !important">
                                                    <th colspan="3" class="text-center" style="background-color: <?= $headerTextColor ?: '#0F335C' ?> !important;-webkit-print-color-adjust: exact;text-align: center;color: <?= $headerBgColor ?: '#fff' ?> !important;font-weight: bold;font-size: 12px; padding: 6px;">PERFORMANCE EVALUATION SCALE</th>
                                                </tr>
                                                <tr style="border: 1px solid #000 !important">
                                                    <th style="font-size: 10px; padding: 4px;">Grade</th>
                                                    <th style="font-size: 10px; padding: 4px;">Min Percentage</th>
                                                    <th style="font-size: 10px; padding: 4px;">Max Percentage</th>
                                                </tr>
                                                <?php
                                                $grade = $this->db->where('branch_id', $getExam['branch_id'])->get('grade')->result_array();
                                                foreach ($grade as $key => $row) {
                                                ?>
                                                    <tr style="border: 1px solid #000 !important">
                                                        <td style="font-size: 10px; padding: 4px;"><?= $row['name'] ?></td>
                                                        <td style="font-size: 10px; padding: 4px;"><?= $row['lower_mark'] ?>%</td>
                                                        <td style="font-size: 10px; padding: 4px;"><?= $row['upper_mark'] ?>%</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                            <?php }
                                endif;
                            } ?>
                        </td>
                    </tr>
                </table>

                <table class="table table-condensed table-bordered section-spacing domains-section" style="margin: 10px 0 20px !important;">
                    <tr style="border: 1px solid #000 !important">
                        <td style="width:33.333%; padding: 0; vertical-align: top;">
                            <?php if (!isset($rankDetail)) $rankDetail = new stdClass(); ?>
                            <?php isset($rankDetail->punctualtiy) ? $rankDetail->punctualtiy : '-' ?>
                            <?php isset($rankDetail->neatness) ? $rankDetail->neatness : '-' ?>
                            <?php isset($rankDetail->obedience) ? $rankDetail->obedience : '-' ?>
                            <?php isset($rankDetail->self_control) ? $rankDetail->self_control : '-' ?>
                            <?php isset($rankDetail->participation) ? $rankDetail->participation : '-' ?>
                            <?php isset($rankDetail->use_of_intiative) ? $rankDetail->use_of_intiative : '-' ?>
                            <?php isset($rankDetail->handling) ? $rankDetail->handling : '-' ?>
                            <?php isset($rankDetail->communication) ? $rankDetail->communication : '-' ?>
                            <?php isset($rankDetail->realtionship) ? $rankDetail->realtionship : '-' ?>
                            <?php isset($rankDetail->sports) ? $rankDetail->sports : '-' ?>
                            <table style="width: 100%; margin: 0 !important;">
                                <tr style="border: 1px solid #000 !important">
                                    <th colspan="2" class="text-center" style="background-color: <?= $headerTextColor ?: '#0F335C' ?> !important;-webkit-print-color-adjust: exact;text-align: center;color: <?= $headerBgColor ?: '#fff' ?> !important;font-weight: bold;font-size: 12px; padding: 6px;">AFFECTIVE DOMAIN</th>
                                </tr>
                                <tr style="border: 1px solid #000 !important">
                                    <td style="font-size: 10px; padding: 4px;">Punctuality</td>
                                    <td style="font-size: 10px; padding: 4px;"><?= isset($rankDetail->punctualtiy) ? $rankDetail->punctualtiy : '-' ?></td>
                                </tr>
                                <tr style="border: 1px solid #000 !important">
                                    <td style="font-size: 10px; padding: 4px;">General Neatness</td>
                                    <td style="font-size: 10px; padding: 4px;"><?= isset($rankDetail->neatness) ? $rankDetail->neatness : '-' ?></td>
                                </tr>
                                <tr style="border: 1px solid #000 !important">
                                    <td style="font-size: 10px; padding: 4px;">Obedience</td>
                                    <td style="font-size: 10px; padding: 4px;"><?= isset($rankDetail->obedience) ? $rankDetail->obedience : '-' ?></td>
                                </tr>
                                <tr style="border: 1px solid #000 !important">
                                    <td style="font-size: 10px; padding: 4px;">Self Control</td>
                                    <td style="font-size: 10px; padding: 4px;"><?= isset($rankDetail->self_control) ? $rankDetail->self_control : '-' ?></td>
                                </tr>
                                <tr style="border: 1px solid #000 !important">
                                    <td style="font-size: 10px; padding: 4px;">Participation in Class</td>
                                    <td style="font-size: 10px; padding: 4px;"><?= isset($rankDetail->participation) ? $rankDetail->participation : '-' ?></td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:33.333%; padding: 0; vertical-align: top;">
                            <table style="width: 100%; margin: 0 !important;">
                                <tr style="border: 1px solid #000 !important">
                                    <th colspan="2" class="text-center" style="background-color: <?= $headerTextColor ?: '#0F335C' ?> !important;-webkit-print-color-adjust: exact;text-align: center;color: <?= $headerBgColor ?: '#fff' ?> !important;font-weight: bold;font-size: 12px; padding: 6px;">PSYCHOMOTOR DEVELOPMENT</th>
                                </tr>
                                <tr style="border: 1px solid #000 !important">
                                    <td style="font-size: 10px; padding: 4px;">Use of Intiative</td>
                                    <td style="font-size: 10px; padding: 4px;"><?= isset($rankDetail->use_of_intiative) ? $rankDetail->use_of_intiative : '-' ?></td>
                                </tr>
                                <tr style="border: 1px solid #000 !important">
                                    <td style="font-size: 10px; padding: 4px;">Handling of Tools</td>
                                    <td style="font-size: 10px; padding: 4px;"><?= isset($rankDetail->handling) ? $rankDetail->handling : '-' ?></td>
                                </tr>
                                <tr style="border: 1px solid #000 !important">
                                    <td style="font-size: 10px; padding: 4px;">Communication Skills</td>
                                    <td style="font-size: 10px; padding: 4px;"><?= isset($rankDetail->communication) ? $rankDetail->communication : '-' ?></td>
                                </tr>
                                <tr style="border: 1px solid #000 !important">
                                    <td style="font-size: 10px; padding: 4px;">Relationship with Others</td>
                                    <td style="font-size: 10px; padding: 4px;"><?= isset($rankDetail->realtionship) ? $rankDetail->realtionship : '-' ?></td>
                                </tr>
                                <tr style="border: 1px solid #000 !important">
                                    <td style="font-size: 10px; padding: 4px;">Sports & Games</td>
                                    <td style="font-size: 10px; padding: 4px;"><?= isset($rankDetail->sports) ? $rankDetail->sports : '-' ?></td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:33.333%; padding: 0; vertical-align: middle; text-align: center;">
                            <img width="60" src="<?= base_url('uploads/marksheet/' . $marksheet_template['stamp']) ?>" />
                        </td>
                    </tr>
                </table>

                <!-- Added space before footer content -->
                <div class="footer-content" style="margin-top: 1px; padding-top: 1px;">
                    <?php if (!empty($footer_content)) echo $footer_content; ?>
                </div>
            </div>
        </div>
<?php }
} ?>