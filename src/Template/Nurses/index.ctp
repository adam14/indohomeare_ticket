<?php $page = $this->PagingInfo->data($total_data, $data_limit, $paging); ?>
<?php $this->start('script'); ?>
<script>
	$(document).ready(function() {
		$('#confirm').on('show.bs.modal', function(e) {
			var link = $(e.relatedTarget).data('href');
			var label = $(e.relatedTarget).data('label');
			var message = $(e.relatedTarget).data('message');

			$('#confirm-label').html(label);
			$('.body-confirm').html(message);

			$(".btn-ok").on("click", function(e) {
				var form = $('<form action="' + link + '" method="post">' +
				'<input type="text" name="__method" value="post" />' +
                '<input type="hidden" name="_csrfToken" value="<?= $this->request->getParam('_csrfToken'); ?>' +
				'</form>');
				$('body').append(form);
				form.submit();
			});
		});

		$('#modal-form').on('show.bs.modal', function(e) {
			var link = $(e.relatedTarget).data('href');
			var label = $(e.relatedTarget).data('label');

            $('.modal-dialog').attr('style', 'width: 55%;');

			$('#form-label').html(label);
			$($(this).data('remote-target')).load(link);
			$('.body-form').load(link);
		});

		$('#modal-form').on('hidden.bs.modal', function() {
			$('.body-form').html('<p>Loading...</p>');
		});
	});
</script>
<?php $this->end(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="page-head-line">Perawat</h4>
                <?php echo $this->Html->link('Tambah Baru', '#', ['class' => 'disable btn btn-sm btn-success', 'data-href' => $this->Url->build(['controller' => 'Nurses', 'action' => 'add']), 'data-toggle' => 'modal', 'data-target' => '#modal-form', 'data-label' => 'Tambah Data', 'title' => 'Click to Add', 'escape' => false]); ?>
                <?php echo $this->Html->link('Kategori Perawat', ['controller' => 'NurseCategories', 'action' => 'index'], ['class' => 'disable btn btn-sm btn-primary', 'title' => 'Nurse Category', 'escape' => false]); ?>
				<?php echo $this->Html->link('Sesi Perawat', ['controller' => 'NurseSessions', 'action' => 'index'], ['class' => 'disable btn btn-sm btn-info', 'title' => 'Nurse Session', 'escape' => false]); ?>
                <div class="row">
                    <div class="col-md-12 margin-bottom-30">
                        <div class="panel panel-primary">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($nurses)): ?>
                                            <?php $i = $page['lowest']; ?>
                                            <?php foreach ($nurses as $value): ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $value['fullname']; ?></td>
                                                    <td><?php echo $value['nurse_categories']['name']; ?></td>
                                                    <td>
                                                        <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', '#', ['class' => 'btn btn-sm btn-info', 'data-href' => $this->Url->build(['controller' => 'Nurses', 'action' => 'edit', $value['id']]), 'data-toggle' => 'modal', 'data-target' => '#modal-form', 'data-label' => 'UBah Data', 'title' => 'Click to Edit', 'escape' => false]); ?>
                                                        <?php echo $this->Html->link('<i class="fa fa-trash"></i>', '#', ['class' => 'confirm btn btn-sm btn-danger', 'data-href' => $this->Url->build(['controller' => 'Nurses', 'action' => 'delete', $value['id']]), 'data-toggle' => 'modal', 'data-target' => '#confirm', 'data-label' => 'Konfirmasi Hapus', 'data-message' => 'Yakin ingin menghapus data ini?', 'title' => 'Click to Delete', 'escape' => false]); ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <nav class="pull-left">
                                <?php echo 'Showing '.$page['lowest'].' to '.$page['highest'].' of '.$page['total'].' entries'; ?>
                            </nav>
							<?php if ($total_data > $data_limit): ?>
								<nav class="pull-right">
									<?php echo $this->PagingInfo->paginate($data_limit, $paging['current'], $total_data, $paging['last'], $this->Url->build(['controller' => 'Nurses', 'action' => 'index'])); ?>
								</nav>
							<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="confirm-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn btn-sm pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="confirm-label">Konfirmasi</h4>
			</div>
			<div class="modal-body body-confirm">
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary btn-ok">Ya</a>
				<button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="form-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn btn-sm pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="form-label">Form</h4>
			</div>
			<div class="modal-body body-form">
				<p>Loading...</p>
			</div>
		</div>
	</div>
</div>
