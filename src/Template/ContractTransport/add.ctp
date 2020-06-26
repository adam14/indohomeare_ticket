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
<?php echo $this->Form->create(null, ['url' => ['action' => 'add', $id], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<fieldset>
	<div class="form-group">
		<label for="TransportTime" class="col-lg-3 control-label">Transport Time</label>
		<div class="col-lg-9">
            <select class="form-control" id="TransportTime" name="transport_time_id" required>
                <option value="">-- Please Select --</option>
                <?php foreach ($transport_times as $value): ?>
                    <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?> [<?php echo $this->Number->currency($value['price'], 'Rp '); ?>]</option>
                <?php endforeach; ?>
            </select>
            <input name="contract_id" class="form-control" type="hidden" value="<?php echo $id; ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="Distance" class="col-lg-3 control-label">Distance</label>
		<div class="col-lg-9">
			<input name="distance" class="number form-control" id="Distance" placeholder="Distance" type="text" required>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn btn-primary">Add</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>