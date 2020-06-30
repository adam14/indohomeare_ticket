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
		<label for="Handphone" class="col-lg-3 control-label">No. Handphone</label>
		<div class="col-lg-9">
			<input name="handphone" class="form-control number" id="Handphone" placeholder="No. Handphone" type="text" required>
		</div>
	</div>
	<div class="form-group">
		<label for="Email" class="col-lg-3 control-label">Email</label>
		<div class="col-lg-9">
			<input name="email" class="form-control" id="Email" placeholder="Email" type="email" required>
		</div>
	</div>
	<div class="form-group">
		<label for="KTP" class="col-lg-3 control-label">No. KTP</label>
		<div class="col-lg-9">
			<input name="ktp" class="form-control number" id="KTP" placeholder="No. KTP" type="text" required>
		</div>
	</div>
	<div class="form-group">
		<label for="Address" class="col-lg-3 control-label">Address</label>
		<div class="col-lg-9">
			<textarea rows="5" name="address" class="form-control" id="Address" placeholder="Address" required></textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn btn-primary">Add</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>