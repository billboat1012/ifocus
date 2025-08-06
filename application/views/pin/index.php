<section class="panel">
    <div class="tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="fas fa-list-ul"></i> Pin List</a>
            </li>
            <?php if (get_permission('pin', 'is_add')) : ?>
                <li>
                    <a href="<?=base_url('pin')?>" data-toggle="tab"><i class="far fa-edit"></i> <?= translate('create_exam') ?></a>
                </li>
            <?php endif; ?>
        </ul>
        <div class="tab-content">
            <div id="list" class="tab-pane active">
                <table class="table table-bordered table-hover mb-none table-export">
                    <thead>
                        <tr>
                            <th><?= translate('pin') ?></th>
                            <th><?= translate('use_time') ?></th>
                            <th><?= translate('status') ?></th>
                            <th><?= translate('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;
                        foreach ($pinlist as $row) : ?>
                            <tr>
                                <td><?php echo (empty($row['pin']) ? 'N/A' : $row['term_id']); ?></td>
                                <td><?php echo (empty($row['use_time']) ? 'N/A' :  $row['use_time']); ?></td>
                                <td><?php echo (empty($row['end_terms']) ? 'N/A' :  $row['term_id']); ?></td>
                                <td class="min-w-xs">
									 <?php if (get_permission('pin', 'is_delete')) : ?>
										<!-- delete link -->
										<?php echo btn_delete('pin/delete/' . $row['id']); ?>
									<?php endif; ?>
								</td>?></td>
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>