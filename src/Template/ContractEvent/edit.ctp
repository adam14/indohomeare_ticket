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
<?php echo $this->Form->create(null, ['url' => ['action' => 'edit', $event_contracts['id']], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<fieldset>
	<div class="form-group">
		<label for="EventName" class="col-lg-3 control-label">Nama Event</label>
		<div class="col-lg-9">
			<input name="event_name" class="form-control" id="EventName" placeholder="Event Name" value="<?php echo $event_contracts['event_name']; ?>" type="text" required>
            <input name="contract_id" class="form-control" type="hidden" value="<?php echo $event_contracts['contract_id']; ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="Price" class="col-lg-3 control-label">Harga</label>
		<div class="col-lg-9">
			<input name="price" class="number form-control" id="Price" placeholder="Price" value="<?php echo $event_contracts['price']; ?>" type="text" required>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn btn-primary">Ubah</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>