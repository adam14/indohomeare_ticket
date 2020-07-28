<?php $this->start('style'); ?>
<?php echo $this->Html->css('/vendor/bootstrap-datepicker/css/bootstrap-datepicker'); ?>
<?php $this->end(); ?>
<?php $this->start('script'); ?>
<?php echo $this->Html->script('/vendor/bootstrap-datepicker/js/bootstrap-datepicker'); ?>
<script>
</script>
<?php $this->end(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="page-head-line">Otorisasi</h4>
				<div class="row">
					<div class="col-md-12 col-sm-12 margin-bottom-30">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6">
										Validasi Permintaan Pelanggan
									</div>
								</div>
								<hr>
								<?php echo $this->Form->create(null, ['url' => ['action' => 'index'], 'type' => 'get', 'data-parsley-validate']); ?>
									<div class="row">
										<div class="form-group col-sm-2">
											<label for="FromDate">Dari Tanggal:</label>
											<input type="text" name="start_date" class="form-control input-sm date" id="FromDate" value="" required>
										</div>
										<div class="form-group col-sm-2">
											<label for="ToDate">Sampai Tanggal:</label>
											<input type="text" name="end_date" class="form-control input-sm date" id="ToDate" value="">
										</div>
									</div>
									<div class="row">
										<div class="form-group col-sm-6">
											<button type="submit" class="btn btn-sm btn-primary" name="submit_search_contract" id="SubmitSearchContract">Cari</button>
										</div>
									</div>
								<?php echo $this->Form->end(); ?>
							</div>
						</div>
					</div>
				</div>
                <!-- <?php echo $this->Html->link('Add New', ['controller' => 'Contracts', 'action' => 'progressContract'], ['class' => 'disable btn btn-sm btn-success', 'title' => 'Click to Add', 'escape' => false]); ?> -->
                <div class="row">
                    <div class="col-md-12 margin-bottom-30">
                        <div class="panel panel-primary">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Pelanggan</th>
											<th>Nama</th>
											<th>Permintaan</th>
											<th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>PJ.20.7.24.001</td>
                                            <td>Nama Dummy</td>
                                            <td>
                                                <ul>
                                                    <li>Perawat Pendamping</li>
                                                    <li>Perawat ICU</li>
                                                    <li>Alkes</li>
                                                    <li>...</li>
                                                </ul>
                                            </td>
                                            <td>
                                            <a href="#">Deal</a> | <a href="#">Cancel</a> | <a href="#">Tidak Merespon</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <nav class="pull-left">
                                <?php echo 'Showing 1 to 20 of 100 entries'; ?>
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
