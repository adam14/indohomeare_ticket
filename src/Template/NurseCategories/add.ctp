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
<?php echo $this->Form->create(null, ['url' => ['action' => 'add'], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<fieldset>
	<div class="form-group">
		<label for="Name" class="col-lg-3 control-label">Tambah</label>
		<div class="col-lg-9">
			<input name="name" class="form-control" id="Name" placeholder="Tambah" type="text" required>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn btn-primary">Tambah</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>