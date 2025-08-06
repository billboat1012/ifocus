<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-user-clock"></i> <?=translate('leaderboard')?></h4>
	</header>
	<div class="panel-body">
		<table class="table table-bordered table-hover table-condensed table-export mt-md">
			<thead>
				<tr>
					<th>#</th>
					<th><?=translate('student')?></th>
					<th><?=translate('class')?></th>
					<th><?=translate('total score')?></th>
					<!--<th><?=translate('total time')?></th>-->
				</tr>
			</thead>
			<tbody>
			<?php $count = 1; foreach($ranks as $row): ?>
				<tr>
					<td><?php echo $count++ ?></td>
				
					<td><?=$row->last_name;?></td>
					<td><?=$row->class_name;?></td>
					<td><?=$row->max_score;?></td>
					
					<!--<td>-->
					<?php
					
                    //$seconds = $row->duration;
                    //$minutes = floor($seconds / 60);
                    //$remainingSeconds = $seconds % 60;
                    ///$formattedTime = sprintf('%02d:%02d', $minutes, $remainingSeconds);
                    // echo $formattedTime;
					
					?>
					<!--</td>-->
				</tr>
			<?php endforeach;  ?>
			</tbody>
		</table>
	</div>
</section>