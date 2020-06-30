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
<?php echo $this->Form->create(null, ['url' => ['action' => 'add'], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<fieldset>
	<div class="form-group">
		<label for="Fullname" class="col-lg-3 control-label">Fullname</label>
		<div class="col-lg-9">
			<input name="fullname" class="form-control" id="Fullname" placeholder="Fullname" type="text" required>
		</div>
	</div>
	<div class="form-group">
		<label for="Pjs" class="col-lg-3 control-label">PJ</label>
		<div class="col-lg-9">
            <select class="form-control" name="pj_id" id="Pjs" required>
                <option value="">-- Please Select --</option>
                <?php foreach ($pjs as $val): ?>
                    <option value="<?php echo $val['id']; ?>"><?php echo $val['fullname']; ?></option>
                <?php endforeach; ?>
            </select>
		</div>
	</div>
	<div class="form-group">
		<label for="Gender" class="col-lg-3 control-label">Gender</label>
		<div class="col-lg-9">
			<select class="form-control" id="Gender" name="gender" required>
				<option value="">-- Please Select --</option>
				<option value="Laki-Laki">Laki-Laki</option>
				<option value="Perempuan">Perempuan</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="Years" class="col-lg-3 control-label">Age</label>
		<div class="col-lg-9">
			<input type="text" maxlength="3" id="Years" name="years" class="form-control number" placeholder="Age" required>
		</div>
	</div>
	<div class="form-group">
		<label for="RecomendationFrom" class="col-lg-3 control-label">Recomendation From</label>
		<div class="col-lg-9">
			<input type="text" id="RecomendationFrom" name="recomendation_from" class="form-control" placeholder="Recomendation From" required>
		</div>
	</div>
	<div class="form-group">
		<label for="Height" class="col-lg-3 control-label">Height</label>
		<div class="col-lg-9">
			<input type="text" id="Height" name="height" class="form-control number" placeholder="Height" required>
		</div>
	</div>
	<div class="form-group">
		<label for="Weight" class="col-lg-3 control-label">Weight</label>
		<div class="col-lg-9">
			<input type="text" id="Weight" name="weight" class="form-control number" placeholder="Weight" required>
		</div>
	</div>
	<div class="form-group">
		<label for="Address" class="col-lg-3 control-label">Address</label>
		<div class="col-lg-9">
			<textarea rows="5" id="Address" name="address" class="form-control" required></textarea>
		</div>
	</div>
	<div class="form-group">
		<label for="AttachedTools" class="col-lg-3 control-label">Attached Tools</label>
		<div class="col-lg-9">
			<textarea rows="5" id="AttachedTools" name="attached_tools" class="form-control" required></textarea>
		</div>
	</div>
	<div class="form-group">
		<label for="Diagnosis" class="col-lg-3 control-label">Diagnosis</label>
		<div class="col-lg-9">
			<textarea rows="5" id="Diagnosis" name="diagnosis" class="form-control" required></textarea>
		</div>
	</div>
	<div class="form-group">
		<label for="MainComplaint" class="col-lg-3 control-label">Main Complaint</label>
		<div class="col-lg-9">
			<textarea rows="5" id="MainComplaint" name="main_complaint" class="form-control" required></textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn btn-primary">Add</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>