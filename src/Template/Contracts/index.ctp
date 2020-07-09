<?php $page = $this->PagingInfo->data($total_data, $data_limit, $paging); ?>
<?php $this->start('style'); ?>
<?php echo $this->Html->css('/vendor/bootstrap-datepicker/css/bootstrap-datepicker'); ?>
<?php $this->end(); ?>
<?php $this->start('script'); ?>
<?php echo $this->Html->script('/vendor/bootstrap-datepicker/js/bootstrap-datepicker'); ?>
<script>
	$(document).ready(function() {
		$(".date").datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			minView: 2,
			weekStart: 1,
			language: 'en',
			startDate: '',
			endDate: '<?php echo date('Y-m-d'); ?>',
			todayHighlight: true,
		});

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

		$('#DisableDate').on('change', function() {
			if ($(this).prop('checked')) {
				$('#FromDate').attr('disabled', 'disabled');
				$('#ToDate').attr('disabled', 'disabled');
			} else {
				$('#FromDate').removeAttr('disabled');
				$('#ToDate').removeAttr('disabled');
			}
		});

		if ($('#DisableDate').is(':checked')) {
			$('#FromDate').attr('disabled', 'disabled');
			$('#ToDate').attr('disabled', 'disabled');
		} else {
			$('#FromDate').removeAttr('disaled');
			$('#ToDate').removeAttr('disabled');
		}

		$("#PJ").on('change', function() {
            var pj_id = $(this).val();
            var data_pj = {
                'pj_id' : pj_id
            };

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Url->build(['controller' => 'Contracts', 'action' => 'getPatient']); ?>',
                data: data_pj,
                dataType: "json",
				beforeSend: function() {
					$('#Patient').empty();
					$('#Patient').append(new Option('Loading...'));
				},
                success: function(result) {
                    $('#Patient').empty();
                    $('#Patient').append(new Option('-- Silakan Pilih --', ''));

                    for (i = 0; i < result.data.length; i++) {
                        $('#Patient').append('<option value="'+ result.data[i].id +'">'+ result.data[i].fullname +'</option>')
                    }
                }
            });
        });
	});
</script>
<?php $this->end(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="page-head-line">Kontrak</h4>
				<div class="row">
					<div class="col-md-12 col-sm-12 margin-bottom-30">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6">
										Pencarian Data
									</div>
									<div class="col-md-6" align="right">
										<?php echo $this->Html->link('Tambah Baru', ['controller' => 'Contracts', 'action' => 'progressContract'], ['class' => 'disable btn btn-sm btn-success', 'title' => 'Click to Add', 'escape' => false]); ?>
									</div>
								</div>
								<hr>
								<?php echo $this->Form->create(null, ['url' => ['action' => 'index'], 'type' => 'get', 'data-parsley-validate']); ?>
									<div class="row">
										<div class="form-group col-sm-2" style="margin-bottom: 10px;">
											<label for="DisableDate">Non Aktifkan Tanggal</label>
											<br>
											<span class="btn btn-sm btn-default">
												<input type="checkbox" name="disable_date" class="" id="DisableDate" value="1" <?php echo ($this->request->query('disable_date') == 1) ? 'checked' : ''; ?>>
												<input type="hidden" name="action_contract" value="<?php echo ($this->request->query('action_contract')) ? $this->request->query('action_contract') : 'search'; ?>" class="form-control input-sm">
											</span>
										</div>
										<div class="form-group col-sm-2">
											<label for="FromDate">Dari Tanggal:</label>
											<input type="text" name="start_date" class="form-control input-sm date" id="FromDate" value="<?php echo (!empty($this->request->query('start_date'))) ? $this->request->query('start_date') : date('Y-m-d'); ?>" required>
										</div>
										<div class="form-group col-sm-2">
											<label for="ToDate">Sampai Tanggal:</label>
											<input type="text" name="end_date" class="form-control input-sm date" id="ToDate" value="<?php echo (!empty($this->request->query('end_date'))) ? $this->request->query('end_date') : date('Y-m-d'); ?>">
										</div>
										<div class="form-group col-sm-2">
											<label for="NoContract">Nomor Kontrak:</label>
											<input type="text" name="no_contract" class="form-control input-sm" id="NoContract" value="<?php echo (!empty($this->request->query('no_contract'))) ? $this->request->query('no_contract') : ''; ?>">
										</div>
										<div class="form-group col-sm-4">
											<label for="PJ">PJ:</label>
											<select name="pj_id" class="form-control input-sm" id="PJ">
												<option value="">-- Silakan Pilih --</option>
												<?php foreach ($pjs as $value): ?>
													<option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $this->request->query('pj_id')) ? 'selected' : ''; ?>><?php echo $value['fullname']; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
										<div class="form-group col-sm-4">
											<label for="Patient">Nama Pasien:</label>
											<!-- <input type="text" name="name_patient" class="form-control input-sm" id="Patient" value="<?php echo (!empty($this->request->query('name_patient'))) ? $this->request->query('name_patient') : ''; ?>"> -->
											<select name="patient_id" class="form-control input-sm" id="Patient">
												<option value=""> -- Silakan Pilih --</option>
											</select>
										</div>
										<div class="form-group col-sm-3">
											<label for="StatusContract">Status Kontrak:</label>
											<select name="status_contract" class="form-control input-sm" id="StatusContract">
												<option value="">-- Silakan Pilih --</option>
												<option value="Draft" <?php echo ($this->request->query('status_contract') == 'Draft') ? 'selected' : ''; ?>>Draft</option>
												<option value="No Response" <?php echo ($this->request->query('status_contract') == 'No Response') ? 'selected' : ''; ?>>No Response</option>
												<option value="Deal" <?php echo ($this->request->query('status_contract') == 'Deal') ? 'selected' : ''; ?>>Deal</option>
												<option value="Cancel" <?php echo ($this->request->query('status_contract') == 'Cancel') ? 'selected' : ''; ?>>Cancel</option>
											</select>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-sm-6">
											<button type="submit" class="btn btn-sm btn-primary" name="submit_search_contract" id="SubmitSearchContract">Proses</button>
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
                                            <th>Nomor Kontrak</th>
											<th>Status</th>
											<th>PJ</th>
											<th>Pasien</th>
											<th>Tanggal Mulai</th>
											<th>Tanggal Akhir</th>
											<th>Total Biaya</th>
                                            <!-- <th>Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($contracts)): ?>
                                            <?php $i = $page['lowest']; ?>
                                            <?php foreach ($contracts as $value): ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td>
														<?php if ($value['status'] == 'Draft'): ?>
															<a href="<?php echo $this->Url->build(['controller' => 'Contracts', 'action' => 'add']); ?>/<?php echo $value['contract_no']; ?>"><?php echo $value['contract_no']; ?></a>
														<?php else: ?>
															<a href="<?php echo $this->Url->build(['controller' => 'Contracts', 'action' => 'detail']); ?>/<?php echo $value['id']; ?>"><?php echo $value['contract_no']; ?></a>
														<?php endif; ?>
													</td>
													<td><?php echo $value['status'] ?></td>
													<td><?php echo $value['pjs']['fullname'] ?></td>
													<td><?php echo $value['patients']['fullname'] ?></td>
													<td><?php echo $value['start_date'] ?></td>
													<td><?php echo $value['end_date'] ?></td>
													<td><?php echo $value['total_price'] ?></td>
                                                    <!-- <td>
                                                        <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', '#', ['class' => 'btn btn-sm btn-info', 'data-href' => $this->Url->build(['controller' => 'Contracts', 'action' => 'edit', $value['id']]), 'data-toggle' => 'modal', 'data-target' => '#modal-form', 'data-label' => 'Edit Data', 'title' => 'Click to Edit', 'escape' => false]); ?>
                                                        <?php echo $this->Html->link('<i class="fa fa-trash"></i>', '#', ['class' => 'confirm btn btn-sm btn-danger', 'data-href' => $this->Url->build(['controller' => 'Contracts', 'action' => 'delete', $value['id']]), 'data-toggle' => 'modal', 'data-target' => '#confirm', 'data-label' => 'Confirm Delete', 'data-message' => 'Are you sure you want to delete?', 'title' => 'Click to Delete', 'escape' => false]); ?>
                                                    </td> -->
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
									<?php echo $this->PagingInfo->paginate($data_limit, $paging['current'], $total_data, $paging['last'], $this->Url->build(['controller' => 'Contracts', 'action' => 'index'])); ?>
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
