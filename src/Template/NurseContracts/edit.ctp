<?php $this->start('script'); ?>
<?php echo $this->Html->script('/vendor/parsley/js/parsley.min'); ?>
<script>
	$(document).ready(function() {
		$('#Code').bind('change keyup input', function() {
			this.value = this.value.toUpperCase();
		});

        $('.number').keyup(function() {
            this.value = this.value.replace(/[^0-9\.]/g,'');
        });

		var nurse_id = "<?php echo $nurse_contracts['nurse_id'] ?>";
		var nurse_category_id = $('#Nurses option:selected').attr('category');
		var nurse_session_id = "<?php echo $nurse_contracts['nurse_session_id']; ?>";
		var data_nurse_session = {
			'nurse_id' : nurse_id,
			'nurse_category_id' : nurse_category_id
		}

		$.ajax({
			type: 'GET',
			url: '<?php echo $this->Url->build(['controller' => 'NurseContracts', 'action' => 'getNurseCategories']); ?>',
			dataType: 'json',
			beforeSend: function() {
				$('#NurseCategory').empty();
				$('#NurseCategory').append(new Option('Loading...', ''));
			},
			success: function(result) {
				$('#NurseCategory').empty();
				$('#NurseCategory').append(new Option('-- Silakan Pilih --', ''));

                for (i = 0; i < result.data.length; i++) {
                    $('#NurseCategory').append('<option value="'+ result.data[i].id +'">'+ result.data[i].name +'</option>');
					$('#NurseCategory').val(nurse_category_id);
                }
			}
		});

		$.ajax({
			type: 'POST',
			url: '<?php echo $this->Url->build(['controller' => 'NurseContracts', 'action' => 'getNurseSessions']) ?>',
			data: data_nurse_session,
			dataType: "json",
			beforeSend: function() {
				$('#NurseSessions').empty();
				$('#NurseSessions').append(new Option('Loading...', ''));
			},
			success: function(result) {
				$('#NurseSessions').empty();
				$('#NurseSessions').append(new Option('-- Silakan Pilih --', ''));

				for (i = 0; i < result.data.length; i++) {
					if (nurse_session_id == result.data[i].id) {
						$('#NurseSessions').append('<option value="'+ result.data[i].id +'">'+ result.data[i].name +' [Rp. '+ formatRupiah(result.data[i].price) +']</option>');
						$('#NurseSessions').val(nurse_session_id);
					} else {
						$('#NurseSessions').append('<option value="'+ result.data[i].id +'">'+ result.data[i].name +' [Rp. '+ formatRupiah(result.data[i].price) +']</option>');
					}
				}
			}
		});

		$('#NurseCategory').on('change', function(e) {
            var nurse_category_id = $(this).val();
            var data_nurse = {
                'nurse_category_id' : nurse_category_id
            };

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Url->build(['controller' => 'NurseContracts', 'action' => 'getNurse']); ?>',
                data: data_nurse,
                dataType: 'json',
				beforeSend: function() {
					$('#Nurses').empty();
					$('#Nurses').append(new Option('Loading...', ''));
					$('#NurseSessions').empty();
					$('#NurseSessions').append(new Option('-- Silakan Pilih --'));
				},
                success: function(result) {
                    $('#Nurses').empty();
                    $('#Nurses').append(new Option('-- Silakan Pilih --', ''));

                    for (i = 0; i < result.data.length; i++) {
                        $('#Nurses').append('<option value="'+ result.data[i]['id'] +'" category="'+ result.data[i]['nurse_category_id'] +'">'+ result.data[i]['fullname'] +'</option>');
                    }
                }
            });
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
				beforeSend: function() {
					$('#NurseSessions').empty();
					$('#NurseSessions').append(new Option('Loading...', ''));
				},
				success: function(result) {
					$('#NurseSessions').empty();
					$('#NurseSessions').append(new Option('-- Silakan Pilih --', ''));

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
<?php echo $this->Form->create(null, ['url' => ['action' => 'edit', $nurse_contracts['id']], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<input name="contract_id" class="form-control" type="hidden" value="<?php echo $nurse_contracts['contract_id']; ?>">
<fieldset>
	<div class="form-group">
		<label for="NurseCategory" class="col-lg-3 control-label">Kategori Perawat</label>
		<div class="col-lg-9">
            <select class="form-control" id="NurseCategory" name="nurse_category_id" required>
                <option value="">-- Silakan Pilih --</option>
				<!-- <?php foreach ($nurse_categories as $value): ?>
					<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
				<?php endforeach; ?> -->
            </select>
		</div>
	</div>
	<div class="form-group">
		<label for="Nurses" class="col-lg-3 control-label">Perawat</label>
		<div class="col-lg-9">
            <select class="form-control" id="Nurses" name="nurse_id" required>
                <option value="">-- Silakan Pilih --</option>
                <?php foreach ($nurses as $value): ?>
                    <option value="<?php echo $value['id']; ?>" <?php echo ($nurse_contracts['nurse_id'] == $value['id']) ? 'selected' : ''; ?> category="<?php echo $value['nurse_category_id']; ?>"><?php echo $value['fullname']; ?></option>
                <?php endforeach; ?>
            </select>
		</div>
	</div>
	<div class="form-group">
		<label for="NurseSessions" class="col-lg-3 control-label">Sesi Perawat</label>
		<div class="col-lg-9">
            <select class="form-control" id="NurseSessions" name="nurse_session_id" required>
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