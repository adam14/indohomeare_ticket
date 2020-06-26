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
<?php echo $this->Form->create(null, ['url' => ['action' => 'edit', $therapist_contracts['id']], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<fieldset>
	<div class="form-group">
		<label for="Therapist" class="col-lg-3 control-label">Therapist</label>
		<div class="col-lg-9">
            <select class="form-control" id="Therapist" name="therapist_id" required>
                <option value="">-- Please Select --</option>
                <?php foreach ($therapist as $value): ?>
                    <option value="<?php echo $value['id']; ?>" <?php echo ($therapist_contracts['therapist_id'] == $value['id']) ? 'selected' : ''; ?>><?php echo $value['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <input name="contract_id" class="form-control" type="hidden" value="<?php echo $therapist_contracts['contract_id']; ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="TherapistSessions" class="col-lg-3 control-label">Therapist Sessions</label>
		<div class="col-lg-9">
            <select class="form-control" id="TherapistSessions" name="therapist_session_id" required>
                <option value="">-- Please Select --</option>
                <?php foreach ($therapist_session as $value): ?>
                    <option value="<?php echo $value['id']; ?>" <?php echo ($therapist_contracts['therapist_session_id'] == $value['id']) ? 'selected' : ''; ?>><?php echo $value['name']; ?> [<?php echo $this->Number->currency($value['price'], 'Rp '); ?>]</option>
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