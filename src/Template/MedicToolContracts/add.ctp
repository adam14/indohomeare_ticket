<?php $this->start('script'); ?>
<?php echo $this->Html->script('/vendor/parsley/js/parsley.min'); ?>
<script>
	$(document).ready(function() {
		$('#Code').bind('change keyup input', function() {
			this.value = this.value.toUpperCase();
		});

		$('#MedicTools').on('change', function(e) {
			var medic_tool_id = $(this).val();
			var data_medic_tool_session = {
				'medic_tool_id' : medic_tool_id
			}

			$.ajax({
				type: 'POST',
				url: '<?php echo $this->Url->build(['controller' => 'MedicToolContracts', 'action' => 'getMedicToolSessions']) ?>',
				data: data_medic_tool_session,
				dataType: "json",
				beforeSend: function() {
					$('#MedicToolsSessions').empty();
					$('#MedicToolsSessions').append(new Option('Loading...', ''));
				},
				success: function(result) {
					$('#MedicToolsSessions').empty();
					$('#MedicToolsSessions').append(new Option('-- Silakan Pilih --', ''));

					for (i = 0; i < result.data.length; i++) {
						$('#MedicToolsSessions').append('<option value="'+ result.data[i].id +'">Rp. '+ formatRupiah(result.data[i].price) +'</option>');
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
<?php echo $this->Form->create(null, ['url' => ['action' => 'add', $id], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<fieldset>
	<div class="form-group">
		<label for="MedicTools" class="col-lg-3 control-label">Alkes</label>
		<div class="col-lg-9">
            <select class="form-control" id="MedicTools" name="medic_tool_id" required>
                <option value="">-- Silakan Pilih --</option>
                <?php foreach ($medic_tools as $value): ?>
                    <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <input name="contract_id" class="form-control" type="hidden" value="<?php echo $id; ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="MedicToolsSessions" class="col-lg-3 control-label">Sesi Alkes</label>
		<div class="col-lg-9">
            <select class="form-control" id="MedicToolsSessions" name="medic_tool_session_id" required>
                <option value="">-- Silakan Pilih --</option>
            </select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn btn-primary">Tambah</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>