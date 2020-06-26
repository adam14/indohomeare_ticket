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
<?php echo $this->Form->create(null, ['url' => ['action' => 'edit', $medic_tool_sessions['id']], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<fieldset>
	<div class="form-group">
		<label for="MedicTools" class="col-lg-3 control-label">Medic Tools</label>
		<div class="col-lg-9">
			<select class="form-control" id="MedicTools" name="medic_tool_id" required>
                <option value="">-- Please Select --</option>
                <?php foreach ($medic_tools as $value): ?>
                    <option value="<?php echo $value['id']; ?>" <?php echo ($medic_tool_sessions['medic_tool_id'] == $value['id']) ? 'selected' : ''; ?>><?php echo $value['name']; ?></option>
                <?php endforeach; ?>
            </select>
		</div>
	</div>
	<div class="form-group">
		<label for="Price" class="col-lg-3 control-label">Price</label>
		<div class="col-lg-9">
			<input name="price" class="number form-control" id="Price" placeholder="Price" value="<?php echo $medic_tool_sessions['price']; ?>" type="text" required>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn btn-primary">Add</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>