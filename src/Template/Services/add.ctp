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
        <label for="NamaLayanan" class="col-lg-3 control-label">Nama Layanan</label>
        <div class="col-lg-9">
            <input type="text" name="nama_layanan" class="form-control" id="NamaLayanan" placeholder="Nama Layanan" required>
        </div>
    </div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn bnt-sm btn-primary">Tambah</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>   
<br>
<!--
<div class="form-group">
    <label for="">Nama Layanan</label>
    <input type="text" placeholder="Nama sesi">
    <label for="">Sesi</label>
    <select name="" id="">
        <option value="">--Daftar Sesi--</option>
    </select>
    <button class="btn btn-primary btn-sm">Tambah</button>
</div>

<div class="table">
    <table class="table">
        <thead>
            <tr>
                <th>Sesi</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>2x Sesi</td>
                <td><button class="btn btn-sm btn-danger">Hapus</button></td>
            </tr>
            <tr>
                <td>Bulanan</td>
                <td><button class="btn btn-sm btn-danger">Hapus</button></td>
            </tr>
        </tbody>
    </table>
</div>
-->