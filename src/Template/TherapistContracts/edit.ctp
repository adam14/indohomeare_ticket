<?php $this->start('script'); ?>
<?php echo $this->Html->script('/vendor/parsley/js/parsley.min'); ?>
<script>
	$(document).ready(function() {
		$('#Code').bind('change keyup input', function() {
			this.value = this.value.toUpperCase();
		});

		var therapist_id = '<?php echo $therapist_contracts['therapist_id']; ?>';
		var therapist_type_id = $('#Therapist option:selected').attr('type-therapist');
		var therapist_session_id = '<?php echo $therapist_contracts['therapist_session_id']; ?>';
		var data_therapist_session = {
			'therapist_id' : therapist_id,
			'therapist_type_id' : therapist_type_id
		};

		$.ajax({
			type: 'GET',
			url: '<?php echo $this->Url->build(['controller' => 'TherapistContracts', 'action' => 'getTherapistType']); ?>',
			dataType: 'json',
			beforeSend: function() {
				$('#TherapistType').empty();
				$('#TherapistType').append(new Option('Loading...', ''));
			},
			success: function(result) {
				console.log(result);
				$('#TherapistType').empty();
				$('#TherapistType').append(new Option('-- Silakan Pilih --', ''));

				for (i = 0; result.data.length; i++) {
					$('#TherapistType').append('<option value="'+ result.data[i].id +'">'+ result.data[i].name +'</option>');
					$('#TherapistType').val(therapist_type_id);
				}
			}
		});

		$.ajax({
			type: 'POST',
			url: '<?php echo $this->Url->build(['controller' => 'TherapistContracts', 'action' => 'getTherapistSessions']) ?>',
			data: data_therapist_session,
			dataType: "json",
			beforeSend: function() {
				$('#TherapistSessions').empty();
				$('#TherapistSessions').append(new Option('Loading...', ''));
			},
			success: function(result) {
				$('#TherapistSessions').empty();
				$('#TherapistSessions').append(new Option('-- Silakan Pilih --', ''));

				for (i = 0; i < result.data.length; i++) {
					$('#TherapistSessions').append('<option value="'+ result.data[i].id +'">'+ result.data[i].name +' [Rp. '+ formatRupiah(result.data[i].price) +']</option>');
					$('#TherapistSessions').val(therapist_session_id);
				}
			}
		});

		$('#TherapistType').on('change', function(e) {
            var therapist_type_id = $(this).val();
            var data_therapist = {
                'therapist_type_id' : therapist_type_id
            };

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Url->build(['controller' => 'TherapistContracts', 'action' => 'getTherapist']); ?>',
                data: data_therapist,
                dataType: 'json',
                beforeSend: function() {
                    $('#Therapist').empty();
                    $('#Therapist').append(new Option('Loading...', ''));
					$('#TherapistSessions').empty();
					$('#TherapistSessions').append(new Option('-- Silakan Pilih --', ''));
                },
                success: function(result) {
                    $('#Therapist').empty();
                    $('#Therapist').append(new Option('-- Silakan Pilih --', ''));

                    for (i = 0; i < result.data.length; i++) {
                        $('#Therapist').append('<option value="'+ result.data[i]['id'] +'" type-therapist="'+ result.data[i]['therapist_type_id'] +'">'+ result.data[i]['name'] +'</option>');
                    }
                }
            })
        });

		$('#Therapist').on('change', function(e) {
			var therapist_id = $(this).val();
			var therapist_type_id = $('#Therapist option:selected').attr("type-therapist");
			var data_therapist_session = {
				'therapist_id' : therapist_id,
				'therapist_type_id' : therapist_type_id
			}

			$.ajax({
				type: 'POST',
				url: '<?php echo $this->Url->build(['controller' => 'TherapistContracts', 'action' => 'getTherapistSessions']) ?>',
				data: data_therapist_session,
				dataType: "json",
                beforeSend: function() {
                    $('#TherapistSessions').empty();
                    $('#TherapistSessions').append(new Option('Loading...', ''));
                },
				success: function(result) {
					$('#TherapistSessions').empty();
					$('#TherapistSessions').append(new Option('-- Silakan Pilih --', ''));

					for (i = 0; i < result.data.length; i++) {
						$('#TherapistSessions').append('<option value="'+ result.data[i].id +'">'+ result.data[i].name +' [Rp. '+ formatRupiah(result.data[i].price) +']</option>');
					}
				}
			});
		});
	});

	function formatRupiah(angka) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }
</script>
<?php $this->end(); ?>
<?php echo $this->Form->create(null, ['url' => ['action' => 'edit', $therapist_contracts['id']], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<fieldset>
	<div class="form-group">
		<label for="TherapistType" class="col-lg-3 control-label">Tipe Terapi</label>
		<div class="col-lg-9">
            <select class="form-control" id="TherapistType" name="therapist_type_id" required>
                <option value="">-- Silakan Pilih --</option>
            </select>
			<input name="contract_id" class="form-control" type="hidden" value="<?php echo $therapist_contracts['contract_id']; ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="Therapist" class="col-lg-3 control-label">Terapi</label>
		<div class="col-lg-9">
            <select class="form-control" id="Therapist" name="therapist_id" required>
                <option value="">-- Silakan Pilih --</option>
                <?php foreach ($therapist as $value): ?>
                    <option value="<?php echo $value['id']; ?>" type-therapist="<?php echo $value['therapist_type_id']; ?>" <?php echo ($therapist_contracts['therapist_id'] == $value['id']) ? 'selected' : ''; ?>><?php echo $value['name']; ?></option>
                <?php endforeach; ?>
            </select>
		</div>
	</div>
	<div class="form-group">
		<label for="TherapistSessions" class="col-lg-3 control-label">Sesi Terapi</label>
		<div class="col-lg-9">
            <select class="form-control" id="TherapistSessions" name="therapist_session_id" required>
                <option value="">-- Silakan Pilih --</option>
            </select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn btn-primary">Ubah</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>