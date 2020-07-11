<?php $this->start('style'); ?>
<?php echo $this->Html->css('/vendor/bootstrap-select/css/bootstrap-select'); ?>
<?php echo $this->Html->css('/vendor/select-multiple/css/select-multiple'); ?>
<?php $this->end(); ?>
<?php $this->start('script'); ?>
<script>
	$(document).ready(function() {
		var contract_pj_id = $('#ContractPJ').val();
		var data_contract_pj = {
			'pj_id' : contract_pj_id
		}

		$.ajax({
			type: 'POST',
			url: '<?php echo $this->Url->build(['controller' => 'Contracts', 'action' => 'getPatient']); ?>',
			data: data_contract_pj,
			dataType: "json",
			success: function(result) {
                    $('#ContractPatient').empty();
                    $('#ContractPatient').append(new Option('-- Please Select --', ''));

                    for (i = 0; i < result.data.length; i++) {
                        $('#ContractPatient').append('<option value="'+ result.data[i].id +'">'+ result.data[i].fullname +'</option>')
						$('#ContractPatient').val('<?php echo $contracts->patient_id; ?>');
                    }
					
					$('#ContractPatient').attr('disabled', true);

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo $this->Url->build(['controller' => 'Contracts', 'action' => 'detailPj']); ?>',
                        data: data_contract_pj,
                        dataType: "json",
                        success: function(result) {                            
                            if (result.status == 'true') {
                                $('#ContractPJNamaLengkap').val(result.data.fullname);
                                $('#ContractPJNomorTelepon').val(result.data.handphone);
                                $('#ContractPJKTP').val(result.data.ktp);
                                $('#ContractPJEmail').val(result.data.email);
                                $('#ContractPJAlamat').val(result.data.address);
                            } else {
                                $('#ContractPJNamaLengkap').val('');
                                $('#ContractPJNomorTelepon').val('');
                                $('#ContractPJKTP').val('');
                                $('#ContractPJEmail').val('');
                                $('#ContractPJAlamat').val('');
                            }
                        }
                    });

					var patient_id = '<?php echo $contracts->patient_id ?>';
					var contract_data_patient = {
						'patient_id' : patient_id
					}

					$.ajax({
						type: 'POST',
						url: '<?php echo $this->Url->build(['controller' => 'Contracts', 'action' => 'detailPatient']); ?>',
						data: contract_data_patient,
						dataType: "json",
						success: function(result) {
							if (result.status == 'true') {
								$('#ContractPatientRekomendasiDari').val(result.data.recomendation_from);
								$('#ContractPatientJenisKelamin').val(result.data.gender);
								$('#ContractPatientUmur').val(result.data.years);
								$('#ContractPatientBeratBadan').val(result.data.height);
								$('#ContractPatientTinggiBadan').val(result.data.weight);
								$('#ContractPatientAlamatLengkap').val(result.data.address);
								$('#ContractPatientAlatTerpasang').val(result.data.attached_tools);
								$('#ContractPatientDiagnosa').val(result.data.diagnosis);
								$('#ContractPatientKeluhanUtama').val(result.data.main_complaint);
							} else {
								$('#ContractPatientRekomendasiDari').val('');
								$('#ContractPatientJenisKelamin').val('');
								$('#ContractPatientUmur').val('');
								$('#ContractPatientBeratBadan').val('');
								$('#ContractPatientTinggiBadan').val('');
								$('#ContractPatientAlamatLengkap').val('');
								$('#ContractPatientAlatTerpasang').val('');
								$('#ContractPatientDiagnosa').val('');
								$('#ContractPatientKeluhanUtama').val('');
							}
						}
					});
                }
		})

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

		/** History */
		$('#HistoryNav').on('click', function() {
			var contract_id = '<?php echo $contracts->id; ?>';

			$.ajax({
				type: 'POST',
				url: '<?php echo $this->Url->build(['controller' => 'Contracts', 'action' => 'getHistory']); ?>',
				data: {
					'contract_id' : contract_id
				},
				dataType: 'json',
				success: function(result) {
					console.log(result);

					$('#ResultNote').html('');

					if (result.status == 'true') {
						$.each(result.data.data, function(i, result) {
							$('#ResultNote').append(`<i>` + result.created_at + `</i> <b>`+result.users.fullname+`</b> <p>[Status : <?php echo $contracts->status; ?>] `+ result.description +`</p>`);
						});
					}
				}
			});
		});

		$('input:radio[name="ticket_status"]').on('change', function() {
			var value = $('input:radio[name="ticket_status"]:checked').val();

			$('#StatusUpdated').val(value);
		});

		$('#AddHistory').on('click', function() {
			var status = '';
			var contract_id = '<?php echo $contracts->id; ?>';
			var status_updated = $('#StatusUpdated').val();

			if (status_updated == 'Note') {
				addHistory(status_updated);
			} else {
				addHistory(status_updated);
				
				var data_contract = {
					'id' : contract_id,
					'status' : status_updated
				};

				$.ajax({
					type: 'POST',
					url: '<?php echo $this->Url->build(['controller' => 'Contracts', 'action' => 'updateStatus']); ?>',
					data: data_contract,
					dataType: 'json',
					success: function(result) {
						console.log(result);
					}
				});
			}
		});

		$('#ResetHistory').on('click', function() {
			$('#Description').val('');
		});
		/** End */
	});

	function addHistory(status_updated) {
		var contract_id = '<?php echo $contracts->id ?>';
		var description = $('#Description').val();
		var data_contract_histories = {
			'contract_id' : contract_id,
			'description' : description
		};
		var status_last = '';

		$.ajax({
			type: 'POST',
			url: '<?php echo $this->Url->build(['controller' => 'ContractHistories', 'action' => 'saveHistory']); ?>',
			data: data_contract_histories,
			dataType: 'json',
			success: function(result) {
				if (result.status == 'true') {
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$('#Description').val('');
					$('#AlertUpdate').html(`<div class="alert alert-success">History contract has been saved !</div>`);
					$('#AlertUpdate').show('slow');

					if (status_updated == 'Note') {
						status_last = '<?php echo $contracts->status; ?>';
					} else {
						status_last = status_updated;
					}

					$('#ResultNote').append(`<i><?php echo date('Y-m-d H:i:s'); ?></i> <b>`+"<?php echo $this->request->session()->read('Auth.User.fullname') ?>"+`</b> <p>[Status : `+ status_last +`] `+ data_contract_histories.description +`</p>`);
					$('#StatusContract').html('Status: '+ status_last);
				} else {
					$('#AlertUpdate').html(`<div class="alert alert-error">`+ result.error_msg +`</div>`);
					$('#AlertUpdate').show('slow');
				}
			}
		});
	}
</script>
<?php echo $this->Html->script('/vendor/parsley/js/parsley.min'); ?>
<?php echo $this->Html->script('/vendor/bootstrap-select/js/bootstrap-select'); ?>
<?php echo $this->Html->script('/vendor/select-multiple/js/jquery.select-multiple'); ?>
<?php $this->end(); ?>
<div class="row" style="width: 100%; height: 100%;">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="page-head-line">No Kontrak : <?php echo $contracts->contract_no; ?> <span class="pull-right" id="StatusContract">Status: <?php echo $contracts->status; ?></span></h4>
                <div class="row">
                    <div class="col-md-12">
                        <div id="AlertUpdate" hidden="true"></div>
                        <div id="AlertForm" hidden="true"></div>

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#detail" class="menu-tab">Detail</a></li>
                            <li><a data-toggle="tab" href="#perawat" class="menu-tab">Perawat</a></li>
                            <li><a data-toggle="tab" href="#therapist" class="menu-tab">Terapi</a></li>
                            <li><a data-toggle="tab" href="#alkes" class="menu-tab">Alkes</a></li>
                            <li><a data-toggle="tab" href="#transport" class="menu-tab">Transport</a></li>
                            <li><a data-toggle="tab" href="#event" class="menu-tab">Event</a></li>
                            <li><a data-toggle="tab" href="#history" id="HistoryNav" class="menu-tab">History</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="detail" class="tab-pane fade in active">
                                <?php echo $this->element('Contract/Detail/index'); ?>
                            </div>

                            <div id="perawat" class="tab-pane fade in">
                                <?php echo $this->element('Contract/Nurses/index'); ?>
                            </div>

                            <div id="therapist" class="tab-pane fade in">
								<?php echo $this->element('Contract/Therapist/index'); ?>
                            </div>

                            <div id="alkes" class="tab-pane fade in">
                                <?php echo $this->element('Contract/MedicTools/index'); ?>
                            </div>

                            <div id="transport" class="tab-pane fade in">
                                <?php echo $this->element('Contract/Transport/index'); ?>
                            </div>

                            <div id="event" class="tab-pane fade in">
                                <?php echo $this->element('Contract/Event/index'); ?>
                            </div>

                            <div id="history" class="tab-pane fade in">
                                <?php echo $this->element('Contract/History/index'); ?>
                            </div>
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
				<h4 class="modal-title" id="confirm-label">Confirm</h4>
			</div>
			<div class="modal-body body-confirm">
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary btn-ok">Yes</a>
				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
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
