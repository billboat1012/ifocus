<style type="text/css">

	.mark-container {

		height: 100%;

		min-width: 1000px;

	    position: relative;

	    z-index: 2;

	    margin: 0 auto;

	    padding: <?=$marksheet_template['top_space'] . 'px ' . $marksheet_template['right_space'] . 'px ' . $marksheet_template['bottom_space'] . 'px ' . $marksheet_template['left_space'] . 'px'?>;

	}



	.mark-container  table {

		border-collapse: collapse;

		width: 100%;

	}



	@page {

		margin: -2px;

		size: A4 <?php echo $marksheet_template['page_layout'] == 1 ? 'portrait' : 'landscape'; ?>;

	}



	.mark-container .table > thead:first-child > tr:first-child > th,

	.mark-container .table-bordered > thead > tr > th,

	.mark-container .table-bordered > tbody > tr > th,

	.mark-container .table-bordered > tfoot > tr > th,

	.mark-container .table-bordered > thead > tr > td,

	.mark-container .table-bordered > tbody > tr > td,

	.mark-container .table-bordered > tfoot > tr > td {

	    border: 1px solid #000;

	    background: transparent !important;

	}



	.background {

		position: absolute;

		z-index: 0;

		width: 100%;

		height: 100%;

	<?php if (empty($marksheet_template['background'])) { ?>

		background: #fff;

	<?php } else { ?>

		background-image: url("<?=base_url('uploads/marksheet/' . $marksheet_template['background'])?>") !important;

		background-repeat: no-repeat !important;

		background-size: 100% 100% !important;

	<?php } ?>

	}

</style>

	<div style="position: relative; width: 100%; height: 100%;"> 

		<div class="background"></div>

		<div class="mark-container">

			<?=$marksheet_template['header_content']?>

<?php  if($marksheet_template['playgroup'] == 0) { ?>

            
			<table class="table table-condensed table-bordered mt-lg">

				<thead>

					<tr>

						<th>Subject</th>

						<th>First Term Examination</th>

						<th>Second Term Examination</th>

						<th>Third Term Examination</th>

<?php if ($marksheet_template['cumulative_average'] == 1) { ?>

					<th>Cumulative Average</th>

<?php } ?>

					<th>Grade</th>

<?php if ($marksheet_template['remark'] == 1) { ?>

					<th>Remark</th>

<?php } if ($marksheet_template['class_average'] == 1) { ?>				

					<th>Class Average</th>

<?php } if ($marksheet_template['subject_position'] == 1) { ?>

					<th>Subject Position</th>

<?php } ?>

					</tr>

				</thead>

				<tbody>

					<tr>

						<td valign="middle" width="20%">Einglish</td>

						<td valign="middle">19 / 40</td>

						<td valign="middle">0 / 0</td>

						<td valign="middle">80 / 200</td>

<?php if ($marksheet_template['cumulative_average'] == 1) { ?>

						<td valign="middle">41.3%</td>

<?php } ?>

						<td valign="middle">C</td>

<?php if ($marksheet_template['remark'] == 1) { ?>

						<td valign="middle">Adequate</td>

<?php } if ($marksheet_template['class_average'] == 1) { ?>	

						<td valign="middle">44.00</td>

<?php } if ($marksheet_template['subject_position'] == 1) { ?>

						<td valign="middle">2nd</td>

<?php } ?>

					</tr>

					<tr>

						<td valign="middle" width="20%">Physics</td>

						<td valign="middle">34 / 100</td>

						<td valign="middle">0 / 0</td>

						<td valign="middle">80 / 200</td>

<?php if ($marksheet_template['cumulative_average'] == 1) { ?>

						<td valign="middle">38.0%</td>

<?php } ?>

						<td valign="middle">D</td>

<?php if ($marksheet_template['remark'] == 1) { ?>

						<td valign="middle">Poor</td>

<?php } if ($marksheet_template['class_average'] == 1) { ?>	

						<td valign="middle">57.71</td>

<?php } if ($marksheet_template['subject_position'] == 1) { ?>

						<td valign="middle">1st</td>

<?php } ?>

					</tr>

					<tr>

						<td valign="middle" width="20%">Mathematic</td>

						<td valign="middle">45 / 100</td>

						<td valign="middle">0 / 0</td>

						<td valign="middle">80 / 200</td>

<?php if ($marksheet_template['cumulative_average'] == 1) { ?>

						<td valign="middle">41.7%</td>

<?php } ?>

						<td valign="middle">C</td>

<?php if ($marksheet_template['remark'] == 1) { ?>

						<td valign="middle">Adequate</td>

<?php } if ($marksheet_template['class_average'] == 1) { ?>	

						<td valign="middle">52.20</td>

<?php } if ($marksheet_template['subject_position'] == 1) { ?>

						<td valign="middle">1st</td>

<?php } ?>

					</tr>

					<tr>

						<td valign="middle" width="20%">Chimistry</td>

						<td valign="middle">43 / 100</td>

						<td valign="middle">0 / 0</td>

						<td valign="middle">80 / 200</td>

<?php if ($marksheet_template['cumulative_average'] == 1) { ?>

						<td valign="middle">41.0%</td>

<?php } ?>

						<td valign="middle">C</td>

<?php if ($marksheet_template['remark'] == 1) { ?>

						<td valign="middle">Adequate</td>

<?php } if ($marksheet_template['class_average'] == 1) { ?>	

						<td valign="middle">51.40</td>

<?php } if ($marksheet_template['subject_position'] == 1) { ?>	

						<td valign="middle">1st</td>

<?php } ?>

					</tr>

					<tr>

						<td valign="middle" width="20%">Biology</td>

						<td valign="middle">40 / 100</td>

						<td valign="middle">0 / 0</td>

						<td valign="middle">0 / 0</td>

<?php if ($marksheet_template['cumulative_average'] == 1) { ?>

						<td valign="middle">40.0%</td>

<?php } ?>

						<td valign="middle">C</td>

<?php if ($marksheet_template['remark'] == 1) { ?>

						<td valign="middle">Adequate</td>

<?php } if ($marksheet_template['class_average'] == 1) { ?>	

						<td valign="middle">40.25</td>

<?php } if ($marksheet_template['subject_position'] == 1) { ?>

						<td valign="middle">2nd</td>

<?php } ?>

					</tr>

						<tr class="text-weight-semibold">

						<td valign="top">GRAND TOTAL :</td>

						<td valign="top" colspan="8">501/1240, Average : 40.40%</td>

					</tr>

						<tr class="text-weight-semibold">

						<td valign="top">GRAND TOTAL IN WORDS :</td>

						<td valign="top" colspan="8">Five Hundred One</td>

					</tr>

						<tr class="text-weight-semibold">

						<td valign="top">GPA :</td>

						<td valign="top" colspan="8">2.40%</td>

					</tr>

<?php if ($marksheet_template['result'] == 1) { ?>

					<tr class="text-weight-semibold">

						<td valign="top">RESULT :</td>

						<td valign="top" colspan="13">Pass</td>

					</tr>

<?php } if ($marksheet_template['position'] == 1) { ?>

					<tr class="text-weight-semibold">

						<td valign="top">Position :</td>

						<td valign="top" colspan="13"> 1</td>

					</tr>

<?php } ?>

				</tbody>

			</table>



		<div style="width: 100%; display: flex;">

<?php if ($marksheet_template['attendance_percentage'] == 1) { ?>

			<div style="width: 50%; padding-right: 15px;">

				<table class="table table-bordered table-condensed">

					<tbody>

						<tr>

							<th colspan="2" class="text-center">Attendance</th>

						</tr>

						<tr>

							<th style="width: 65%;">No. of school days</th>

							<td>100</td>

						</tr>

						<tr>

							<th style="width: 65%;">No. of days attended</th>

							<td>75</td>

						</tr>

						<tr>

							<th style="width: 65%;">Attendance Percentage</th>

							<td>75.00%</td>

						</tr>

					</tbody>

				</table>

			</div>

<?php } ?>

<?php if ($marksheet_template['grading_scale'] == 1) { ?>

			<div style="width: 50%; padding-left: 15px;">

				<table class="table table-condensed table-bordered">

					<tbody>

						<tr>

							<th colspan="3" class="text-center">Grading Scale</th>

						</tr>

						<tr>

							<th>Grade</th>

							<th>Min Percentage</th>

							<th>Max Percentage</th>

						</tr>

						<tr>

							<td style="width: 30%;">A+</td>

							<td style="width: 30%;">80%</td>

							<td style="width: 30%;">100%</td>

						</tr>

						<tr>

							<td style="width: 30%;">A</td>

							<td style="width: 30%;">70%</td>

							<td style="width: 30%;">79%</td>

						</tr>

						<tr>

							<td style="width: 30%;">A-</td>

							<td style="width: 30%;">60%</td>

							<td style="width: 30%;">69%</td>

						</tr>

						<tr>

							<td style="width: 30%;">B</td>

							<td style="width: 30%;">50%</td>

							<td style="width: 30%;">59%</td>

						</tr>

						<tr>

							<td style="width: 30%;">C</td>

							<td style="width: 30%;">40%</td>

							<td style="width: 30%;">49%</td>

						</tr>

						<tr>

							<td style="width: 30%;">D</td>

							<td style="width: 30%;">33%</td>

							<td style="width: 30%;">39%</td>

						</tr>

						<tr>

							<td style="width: 30%;">F</td>

							<td style="width: 30%;">0%</td>

							<td style="width: 30%;">32%</td>

						</tr>

						<tr>

							<td style="width: 30%;">D</td>

							<td style="width: 30%;">33%</td>

							<td style="width: 30%;">39%</td>

						</tr>

					</tbody>

				</table>

			</div>

<?php } ?>

<?php }elseif($marksheet_template['playgroup'] == 1){ ?>

    <style>
        td{
       width: 20px !important;
       }
       
       .student-info{
         display: flex;
         flex-direction: column;
         justify-content: center;
         align-items: center;
         padding: 10px;
       }

       .student-info span{
        padding: 25px;
        margin-bottom: 5px;
       }

.grading-distribution {
            text-align: center;
            margin: 5px 0 20px;
        }
        .grading-distribution span {
            display: inline-block;
            width: 24%; /* Adjust the width as needed */
            box-sizing: border-box;
        }

        td{
            text-align: center;
        }
       </style>

<div style="width: 100%;">
	<div style="width: 80%; float: left;">
		<table class="table table-bordered" style="margin-top: 20px; background: transparent; font-size: 13px;">
			<tbody>
				<tr>
					<th>Name
					</th><td>{name}</td>
					<th>Register No
					</th><td>{register_no}</td>
					<th>Roll Number
					</th><td>{roll}</td>
				</tr>
				<tr>
					<th>Father Name
					</th><td>{father_name}</td>
					<th>Admission Date
					</th><td>{admission_date}</td>
					<th>Date of Birth
					</th><td>{birthday}</td>
				</tr>
				<tr>
					<th>Mother Name
					</th><td>{mother_name}</td>
					<th>Class
					</th><td>{class} ({section})</td>
					<th>Gender
					</th><td>{gender}</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="width: 20%; float: left; text-align: right; margin-top: 20px;">
		{student_photo}
	</div>
</div>
       
               
               
               <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                       <tbody><tr>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">LITERACY</th>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">1</th>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">2</th>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">3</th>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">4</th>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Communicates effectively with the teacher</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Can sound lower case letters from a – j</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Can identify lower case letters from a – j</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Has a good pincer grip on writing tools (pencil, crayon etc.)</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Can write lower case letters from a – e</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                   </tbody></table>
                   <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                       <tbody><tr>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">NUMERACY</th>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">1</th>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">2</th>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">3</th>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">4</th>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Communicates effectively with the teacher</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Can count numbers from 1 – 10</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Can identify numbers from 1 – 10</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Has a good pincer grip on writing tools (pencil, crayon etc.)</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Can write numbers from 1 – 5</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                   </tbody></table>
                   <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                       <tbody><tr>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">SELF/ENVIRONMENTAL AWARENESS</th>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">1</th>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">2</th>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">3</th>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">4</th>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Communicates effectively with the teacher</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Can identify parts of the body</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Can identify objects in the classroom</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Can identify every member of the class</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Responds effectively to classroom errands</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                   </tbody></table>
                   <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                       <tbody><tr>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">ART/CRAFT/COLOURS</th>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">1</th>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">2</th>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">3</th>
                           <th style="border: 1px solid #000; padding: 5px; text-align: center;">4</th>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Communicates effectively with the teacher</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Can identify different colours</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Can identify objects from pictures/drawings</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Has a good pincer grip on writing/colouring tools (pencil, crayon etc.)</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                       <tr>
                           <td style="border: 1px solid #000; padding: 5px;">Can scribble with different writing tools</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                           <td style="border: 1px solid #000; padding: 5px;">{section}</td>
                       </tr>
                   </tbody></table>
              
                   <div style="display: flex; align-items: center; flex-direction: row; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
                    <table border="1" style="width: 45%; border-collapse: collapse; text-align: center;">
                        <thead>
                            <tr>
                                <td colspan="4" style="padding: 10px; border: 1px solid black;">FINE MOTOR SKILLS</td>
                            </tr>
                            <tr>
                                <th style="border: 1px solid #000; padding: 5px; text-align: center;">1</th>
                                <th style="border: 1px solid #000; padding: 5px; text-align: center;">2</th>
                                <th style="border: 1px solid #000; padding: 5px; text-align: center;">3</th>
                                <th style="border: 1px solid #000; padding: 5px; text-align: center;">4</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid #000; padding: 15px;">{section}</td>
                                <td style="border: 1px solid #000; padding: 15px;">{section}</td>
                                <td style="border: 1px solid #000; padding: 15px;">{section}</td>
                                <td style="border: 1px solid #000; padding: 15px;">{section}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table border="1" style="width: 45%; border-collapse: collapse; text-align: center;">
                        <thead>
                            <tr>
                                <td colspan="4" style="padding: 10px; border: 1px solid black;">GROSS MOTOR SKILLS</td>
                            </tr>
                            <tr>
                                <th style="border: 1px solid #000; padding: 5px; text-align: center;">1</th>
                                <th style="border: 1px solid #000; padding: 5px; text-align: center;">2</th>
                                <th style="border: 1px solid #000; padding: 5px; text-align: center;">3</th>
                                <th style="border: 1px solid #000; padding: 5px; text-align: center;">4</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid #000; padding: 15px;">{section}</td>
                                <td style="border: 1px solid #000; padding: 15px;">{section}</td>
                                <td style="border: 1px solid #000; padding: 15px;">{section}</td>
                                <td style="border: 1px solid #000; padding: 15px;">{section}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table border="1" style="width: 45%; border-collapse: collapse; text-align: center;">
                        <thead>
                            <tr>
                                <td colspan="4" style="padding: 10px; border: 1px solid black;">RELATIONSHIP WITH PEERS</td>
                            </tr>
                            <tr>
                                <th style="border: 1px solid #000; padding: 5px; text-align: center;">1</th>
                                <th style="border: 1px solid #000; padding: 5px; text-align: center;">2</th>
                                <th style="border: 1px solid #000; padding: 5px; text-align: center;">3</th>
                                <th style="border: 1px solid #000; padding: 5px; text-align: center;">4</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid #000; padding: 15px;">{section}</td>
                                <td style="border: 1px solid #000; padding: 15px;">{section}</td>
                                <td style="border: 1px solid #000; padding: 15px;">{section}</td>
                                <td style="border: 1px solid #000; padding: 15px;">{section}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table border="1" style="width: 45%; border-collapse: collapse; text-align: center;">
                        <thead>
                            <tr>
                                <td colspan="4" style="padding: 10px; border: 1px solid black;">EMOTIONAL CONTROL</td>
                            </tr>
                            <tr>
                                <th style="border: 1px solid #000; padding: 5px; text-align: center;">1</th>
                                <th style="border: 1px solid #000; padding: 5px; text-align: center;">2</th>
                                <th style="border: 1px solid #000; padding: 5px; text-align: center;">3</th>
                                <th style="border: 1px solid #000; padding: 5px; text-align: center;">4</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid #000; padding: 15px;">{section}</td>
                                <td style="border: 1px solid #000; padding: 15px;">{section}</td>
                                <td style="border: 1px solid #000; padding: 15px;">{section}</td>
                                <td style="border: 1px solid #000; padding: 15px;">{section}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

<?php } ?>

		</div>

		<?=$marksheet_template['footer_content']?>

		</div>

	</div>

