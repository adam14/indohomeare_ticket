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
		<label for="Fullname" class="col-lg-3 control-label">Fullname</label>
		<div class="col-lg-9">
			<input name="fullname" class="form-control" id="Fullname" placeholder="Fullname" type="text" required>
		</div>
	</div>
	<div class="form-group">
		<label for="NursesCategory" class="col-lg-3 control-label">Nurse Category</label>
		<div class="col-lg-9">
            <select class="form-control" name="nurse_category_id" id="NursesCategory" required>
                <option value="">-- Please Select --</option>
                <?php foreach ($nurses_categories as $val): ?>
                    <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                <?php endforeach; ?>
            </select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn btn-primary">Add</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>