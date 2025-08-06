<section class="panel" style="padding: 20px;">
		<?php echo validation_errors(); ?>
		<?php echo form_open('subject/add_sub_subject'); ?>
		<div class="row"  style="margin-bottom: 50px;">
		    <div class="col-md-3">
		        <div class="form-group">
					<label class="control-label"><?=translate('branch')?> <span class="required">*</span></label>
					<?php
						$arrayBranch = $this->app_lib->getSelectList('branch');
						echo form_dropdown("branch_id", $arrayBranch, set_value('branch_id'), "class='form-control' required id='branch_id'
						data-width='100%' data-plugin-selectTwo data-minimum-results-for-search='Infinity'");
					?>
			    </div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label>Subject</label>
					<?php
					echo form_dropdown("subject_id", $subject, set_value('subject_id'), "class='form-control' id='subject_id', data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
					?>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label>Sub Subject</label>
					<input type="text" class="form-control" name="sub_subject" />
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label></label>
					<input type="submit" class="btn btn-default btn-block" value="add" />
				</div>
			</div>
		</div>
	</form>

	<table class="table table-bordered table-hover table-condensed mb-none tbr-top table-export">

		<thead>

			<tr>

				<th><?=translate('sl')?></th>

				<th><?=translate('subject')?></th>

				<th><?=translate('sub_subject')?></th>

				<th><?=translate('action')?></th>

			</tr>

		</thead>

		<tbody>

			<?php 	

				$count = 1;

				$subSubjects = $query = $this->db->get('sub_subject')->result();
				//echo '<pre>'; print_r($subSubjects); echo '</pre>';

				if (count($subSubjects)){

					foreach ($subSubjects as $row):
						$subjectName = $this->db->get_where('subject', array('id' => $row->subject_id))->row();
						?>

			<tr>

				<td><?php echo $count++;?></td>

				<td><?php echo $subjectName->name;?></td>

				<td><?php echo $row->sub_subject_text; ?></td>

				<td><a class="btn btn-danger icon btn-circle" href="<?php echo site_url(); ?>subject/sub_subject_delete/<?php echo $row->id; ?>"><i class="fas fa-trash-alt"></i></a></td>

			</tr>

			<?php endforeach; }?>

		</tbody>

	</table>

</section>
<script>
    $(document).ready(function(){
        
        $("#branch_id").on('change',function(){
            var branchID = $(this).val();
            getSubjectByBranch(branchID)
            
        })
        
    })
</script>