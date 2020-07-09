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
	});
</script>
<?php $this->end(); ?>
<?php echo $this->Form->create(null, ['url' => ['action' => 'edit', $therapist_session['id']], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<fieldset>
	<div class="form-group">
		<label for="Name" class="col-lg-3 control-label">Nama</label>
		<div class="col-lg-9">
			<input name="name" class="form-control" id="Name" placeholder="Nama" value="<?php echo $therapist_session['name']; ?>" type="text" required>
		</div>
	</div>
	<div class="form-group">
		<label for="Price" class="col-lg-3 control-label">Harga</label>
		<div class="col-lg-9">
			<input name="price" class="number form-control" id="Price" placeholder="Harga" value="<?php echo $therapist_session['price']; ?>" type="text" required>
		</div>
	</div>
	<div class="form-group">
		<label for="TherapistType" class="col-lg-3 control-label">Tipe Terapi</label>
		<div class="col-lg-9">
			<select class="form-control" name="therapist_type_id" id="TherapistType" required>
				<option value="">-- Silakan Pilih --</option>
				<?php foreach ($therapist_types as $value): ?>
					<option value="<?php echo $value['id']; ?>" <?php echo ($therapist_session['therapist_type_id'] == $value['id']) ? 'selected' : ''; ?>><?php echo $value['name']; ?></option>
				<?php endforeach; ?>
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