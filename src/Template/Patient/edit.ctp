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
<?php echo $this->Form->create(null, ['url' => ['action' => 'edit', $patients['id']], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<fieldset>
	<div class="form-group">
		<label for="Fullname" class="col-lg-3 control-label">Nama Lengkap</label>
		<div class="col-lg-9">
			<input name="fullname" class="form-control" id="Fullname" placeholder="Nama Lengkap" type="text" value="<?php echo $patients['fullname']; ?>" required>
		</div>
	</div>
	<div class="form-group">
        <label for="PJS" class="col-lg-3 control-label">PJ</label>
		<div class="col-lg-9">
            <select class="form-control" name="pj_id" id="PJS" required>
                <option value="">-- Please Select --</option>
                <?php foreach ($pjs as $val): ?>
                    <option value="<?php echo $val['id']; ?>" <?php echo ($patients['pj_id'] == $val['id']) ? 'selected' : ''; ?>><?php echo $val['fullname']; ?></option>
                <?php endforeach; ?>
            </select>
		</div>
	</div>
	<div class="form-group">
		<label for="Gender" class="col-lg-3 control-label">Jenis Kelamin</label>
		<div class="col-lg-9">
			<select class="form-control" id="Gender" name="gender" required>
				<option value="">-- Please Select --</option>
				<option value="Laki-Laki" <?php echo ($patients['gender'] == 'Laki-Laki') ? 'selected' : ''; ?>>Laki-Laki</option>
				<option value="Perempuan" <?php echo ($patients['gender'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="Years" class="col-lg-3 control-label">Umur</label>
		<div class="col-lg-9">
			<input type="text" maxlength="3" id="Years" name="years" class="form-control number" placeholder="Umur" value="<?php echo $patients['years']; ?>" required>
		</div>
	</div>
	<div class="form-group">
		<label for="RecomendationFrom" class="col-lg-3 control-label">Rekomendasi Dari</label>
		<div class="col-lg-9">
			<input type="text" id="RecomendationFrom" name="recomendation_from" class="form-control" placeholder="Rekomendasi Dari" value="<?php echo $patients['recomendation_from']; ?>" required>
		</div>
	</div>
	<div class="form-group">
		<label for="Height" class="col-lg-3 control-label">Berat (Kg)</label>
		<div class="col-lg-9">
			<input type="text" id="Height" name="height" class="form-control number" placeholder="Berat (Kg)" value="<?php echo $patients['height']; ?>" required>
		</div>
	</div>
	<div class="form-group">
		<label for="Weight" class="col-lg-3 control-label">Tinggi (CM)</label>
		<div class="col-lg-9">
			<input type="text" id="Weight" name="weight" class="form-control number" placeholder="Tinggi (CM)" value="<?php echo $patients['weight']; ?>" required>
		</div>
	</div>
	<div class="form-group">
		<label for="Address" class="col-lg-3 control-label">Alamat</label>
		<div class="col-lg-9">
			<textarea rows="5" id="Address" name="address" placeholder="Alamat" class="form-control" required><?php echo $patients['address']; ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label for="AttachedTools" class="col-lg-3 control-label">Alat Terpasang</label>
		<div class="col-lg-9">
			<textarea rows="5" id="AttachedTools" name="attached_tools" placeholder="Alat Terpasang" class="form-control" required><?php echo $patients['attached_tools']; ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label for="Diagnosis" class="col-lg-3 control-label">Diagnosa</label>
		<div class="col-lg-9">
			<textarea rows="5" id="Diagnosis" name="diagnosis" placeholder="Diagnosa" class="form-control" required><?php echo $patients['diagnosis']; ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label for="MainComplaint" class="col-lg-3 control-label">Keluhan Utama</label>
		<div class="col-lg-9">
			<textarea rows="5" id="MainComplaint" name="main_complaint" placeholder="Keluhan Utama" class="form-control" required><?php echo $patients['main_complaint']; ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn btn-primary">Ubah</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>