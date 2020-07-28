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
                <h4 class="page-head-line">Daftar Layanan</h4>
                <?php echo $this->Html->link('Tambah Baru', '#', ['class' => 'disable btn btn-sm btn-success', 'data-href' => $this->Url->build(['controller' => 'Services', 'action' => 'add']), 'data-toggle' => 'modal', 'data-target' => '#modal-form', 'data-label' => 'Tambah Data', 'title' => 'Click to Add', 'escape' => false]); ?>
                <div class="row">
                    <div class="col-md-12 margin-bottom-30">
                        <div class="panel panel-primary">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Sesi Terdaftar</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Perawat Pendamping</td>
                                            <td>
                                                <ul>
                                                    <li>2x Sesi</li>
                                                    <li>Mingguan</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning">Edit</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Perawat Ahli</td>
                                            <td>
                                                <ul>
                                                    <li>Mingguan</li>
                                                    <li>Bulanan</li>
                                                    <li>3x Bulanan</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning">Edit</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Dokter</td>
                                            <td>
                                                <ul>
                                                    <li>1x Sesi</li>
                                                    <li>2x Sesi</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning">Edit</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Fisiotherapi</td>
                                            <td>
                                                <ul>
                                                    <li>4x Sesi</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning">Edit</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Terapi Wicara</td>
                                            <td>
                                                <ul>
                                                    <li>2x Sesi</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning">Edit</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <nav class="pull-left">
                                <?php echo 'Showing 1 to 5 of 10 entries'; ?>
                            </nav>
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
