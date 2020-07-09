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
<?php echo $this->Form->create(null, ['url' => ['action' => 'edit', $nurse_sessions['id']], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<fieldset>
    <div class="form-group">
        <label for="NurseCategory" class="col-lg-3 control-label">Kategori Perawat</label>
        <div class="col-lg-9">
            <select class="form-control" id="NurseCategory" name="nurse_category_id" required>
                <option value="">-- Silakan Pilih --</option>
                <?php foreach ($nurse_categories as $value): ?>
                    <option value="<?php echo $value['id']; ?>" <?php echo ($nurse_sessions['nurse_category_id'] == $value['id']) ? 'selected' : ''; ?>><?php echo $value['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
	<div class="form-group">
		<label for="Name" class="col-lg-3 control-label">Nama</label>
		<div class="col-lg-9">
			<input name="name" class="form-control" id="Name" placeholder="Nama" value="<?php echo $nurse_sessions['name']; ?>" type="text" required>
		</div>
	</div>
	<div class="form-group">
		<label for="Price" class="col-lg-3 control-label">Harga</label>
		<div class="col-lg-9">
			<input name="price" class="number form-control" id="Price" placeholder="Harga" value="<?php echo $nurse_sessions['price']; ?>" type="text" required>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn btn-primary">UBah</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>