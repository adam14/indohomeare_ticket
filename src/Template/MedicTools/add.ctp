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
		<label for="Name" class="col-lg-3 control-label">Nama</label>
		<div class="col-lg-9">
			<input name="name" class="form-control" id="Name" placeholder="Name" type="text" required>
		</div>
	</div>
	<div class="form-group">
		<label for="MedicToolsCategory" class="col-lg-3 control-label">Kategori Alkes</label>
		<div class="col-lg-9">
            <select class="form-control" name="medic_tool_category" id="MedicToolsCategory" required>
                <option value="">-- Silakan Pilih --</option>
                <option value="Sewa">Sewa</option>
                <option value="Beli">Beli</option>
            </select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn btn-primary">Tambah</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>