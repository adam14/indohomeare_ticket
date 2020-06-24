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
<?php echo $this->Form->create(null, ['url' => ['action' => 'edit', $medic_tools['id']], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<fieldset>
	<div class="form-group">
		<label for="Name" class="col-lg-3 control-label">Name</label>
		<div class="col-lg-9">
			<input name="name" class="form-control" id="Name" placeholder="Name" type="text" value="<?php echo $medic_tools['name']; ?>" required>
		</div>
	</div>
	<div class="form-group">
		<label for="MedicToolsCategory" class="col-lg-3 control-label">Medic Tools Category</label>
		<div class="col-lg-9">
            <select class="form-control" name="medic_tool_category" id="MedicToolsCategory" required>
                <option value="">-- Please Select --</option>
                <option value="Sewa" <?php echo ($medic_tools['medic_tool_category'] == 'Sewa') ? 'selected' : ''; ?>>Sewa</option>
                <option value="Beli" <?php echo ($medic_tools['medic_tool_category'] == 'Beli') ? 'selected' : ''; ?>>Beli</option>
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