<?php $this->start('script'); ?>
<?php echo $this->Html->script('/vendor/parsley/js/parsley.min'); ?>
<script>
	$(document).ready(function() {
		$('#Code').bind('change keyup input', function() {
			this.value = this.value.toUpperCase();
		});
	});
</script>
<?php $this->end(); ?>
<?php echo $this->Form->create(null, ['url' => ['action' => 'edit', $therapist['id']], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<fieldset>
	<div class="form-group">
		<label for="Name" class="col-lg-3 control-label">Name</label>
		<div class="col-lg-9">
			<input name="name" class="form-control" id="Name" placeholder="Name" type="text" value="<?php echo $therapist['name']; ?>" required>
		</div>
	</div>
	<div class="form-group">
		<label for="TherapistType" class="col-lg-3 control-label">Therapist Type</label>
		<div class="col-lg-9">
			<select class="form-control" id="TherapistType" name="therapist_type_id" required>
				<option value="">-- Please Select --</option>
				<?php foreach ($therapist_types as $value): ?>
					<option value="<?php echo $value['id']; ?>" <?php echo ($therapist['therapist_type_id'] == $value['id']) ? 'selected' : ''; ?>><?php echo $value['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn btn-primary">Edit</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>