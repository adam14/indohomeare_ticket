<?php $this->start('script'); ?>
<?php echo $this->Html->script('/vendor/parsley/js/parsley.min'); ?>
<script>
	$(document).ready(function() {
		$('#Code').bind('change keyup input', function() {
			this.value = this.value.toUpperCase();
		});

		$('#Nurses').on('change', function(e) {
			var nurse_id = $(this).val();
			var nurse_category_id = $('#Nurses option:selected').attr("category");
			var data_nurse_session = {
				'nurse_id' : nurse_id,
				'nurse_category_id' : nurse_category_id
			}

			$.ajax({
				type: 'POST',
				url: '<?php echo $this->Url->build(['controller' => 'NurseContracts', 'action' => 'getNurseSessions']) ?>',
				data: data_nurse_session,
				dataType: "json",
				success: function(result) {
					$('#NurseSessions').empty();
					$('#NurseSessions').append(new Option('-- Please Select --', ''));

					for (i = 0; i < result.data.length; i++) {
						$('#NurseSessions').append('<option value="'+ result.data[i].id +'">'+ result.data[i].name +' [Rp. '+ formatRupiah(result.data[i].price) +']</option>');
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
		<label for="Nurses" class="col-lg-3 control-label">Nurses</label>
		<div class="col-lg-9">
            <select class="form-control" id="Nurses" name="nurse_id" required>
                <option value="">-- Please Select --</option>
                <?php foreach ($nurses as $value): ?>
                    <option value="<?php echo $value['id']; ?>" category="<?php echo $value['nurse_category_id']; ?>"><?php echo $value['fullname']; ?></option>
                <?php endforeach; ?>
            </select>
            <input name="contract_id" class="form-control" type="hidden" value="<?php echo $id; ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="NurseSessions" class="col-lg-3 control-label">Nurse Sessions</label>
		<div class="col-lg-9">
            <select class="form-control" id="NurseSessions" name="nurse_session_id" required>
                <option value="">-- Please Select --</option>
            </select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn btn-primary">Add</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>
