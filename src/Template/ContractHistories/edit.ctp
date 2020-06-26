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
<?php echo $this->Form->create(null, ['url' => ['action' => 'edit', $contract_histories['id']], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<fieldset>
<div class="form-group">
		<label for="Description" class="col-lg-3 control-label">Description</label>
		<div class="col-lg-9">
        <textarea rows="5" class="form-control" id="Description" name="description" placeholder="Description" required><?php echo $contract_histories['description']; ?></textarea>
            <input name="contract_id" class="form-control" type="hidden" value="<?php echo $contract_histories['contract_id']; ?>">
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn btn-primary">Edit</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>