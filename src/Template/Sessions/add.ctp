<?php $this->start('script'); ?>
<?php echo $this->Html->script('/vendor/parsley/js/parsley.min'); ?>
<script>
	$(document).ready(function() {
		$('#Code').bind('change keyup input', function() {
			this.value = this.value.toUpperCase();
		});

        $('#ButtonCancel').on('click', function() {
            var link = '<?php echo $this->Url->build(['controller' => 'Sessions', 'action' => 'index']); ?>';

            window.location.href = link;
        });

        $('#ButtonSave').on('click', function() {
            if ($('#Layanan').val() == '') {
                if ($('#Name').val() == '') {
                    $('#AlertForm').html(`<div class="alert alert-danger">Field empty. Please try again !</div>`);
                    $('#AlertForm').show();
                } else {
                    var name = $('#Name').val();
                    var data_sesi = {
                        name: name
                    };

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo $this->Url->build(['controller' => 'Sessions', 'action' => 'saveAjax']) ?>',
                        data: data_sesi,
                        dataType: 'json',
                        success: function(result) {
                            if (result.status == 'true') {
                                $('#AlertForm').html(`<div class="alert alert-success">The data has been saved.</div>`);
                                $('#AlertForm').show();
                                $('#Name').attr('disabled', 'disabled');
                                $('#Layanan').attr('disabled', 'disabled');
                                $('#ButtonSave').attr('disabled', 'disabled');
                                $('#ButtonCancel').attr('disabled', 'disabled');

                                setTimeout(
                                    function() {
                                        window.location.href = '<?php echo $this->Url->build(['controller' => 'Sessions', 'action' => 'index']); ?>';
                                    }, 1500
                                );
                            } else {
                                $('#AlertForm').html(`<div class="alert alert-danger">There was an error. Please try again !</div>`);
                                $('#AlertForm').show();
                            }
                        }
                    });
                }
            } else {
                if ($('#Name').val() == '') {
                    $('#AlertForm').html(`<div class="alert alert-danger">Field empty. Please try again !</div>`);
                    $('#AlertForm').show();
                } else {
                    var name = $('#Name').val();
                    var service_id = $('#Layanan').val();
                    var data_sesi = {
                        name: name,
                        service_id: service_id
                    };

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo $this->Url->build(['controller' => 'Sessions', 'action' => 'saveAjax']) ?>',
                        data: data_sesi,
                        dataType: 'json',
                        success: function(result) {
                            console.log(result);
                        }
                    });

                    $('#TableService').show();
                }
            }
        });

        $('#Name').on('keyup', function() {
            if ($(this).val() != '') {
                $('#AlertForm').hide('slow');
            }
        });
	});
</script>
<?php $this->end(); ?>
<div id="AlertForm" hidden="true"></div>
<?php echo $this->Form->create(null, ['url' => ['action' => 'add'], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<fieldset>
    <div class="form-group">
        <label for="Name" class="col-lg-3 control-label">Nama</label>
        <div class="col-lg-9">
            <input type="text" name="name" class="form-control" id="Name" placeholder="Nama Sesi" required>
        </div>
    </div>
    <div class="form-group">
        <label for="Layanan" class="col-lg-3 control-label">Layanan</label>
        <div class="col-lg-9">
            <select name="service_id" class="form-control" id="Layanan">
                <option value="">-- Daftar Layanan --</option>
                <?php if (!empty($services)): ?>
                    <?php foreach ($services as $value): ?>
                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
    </div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<!-- <button type="submit" class="btn btn-primary">Tambah</button> -->
            <button type="button" id="ButtonSave" class="btn btn-primary">Tambah</button>
            <button type="button" id="ButtonCancel" class="btn btn-default">Batal</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>
<div id="TableService" class="table-responsive" hidden="true">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Layanan</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody id="ResultService">
        </tbody>
    </table>
</div>
<!-- <div class="form-group">
    <label for="">Nama Sesi</label>
    <input type="text" placeholder="Nama sesi">
    <label for="">Layanan</label>
    <select name="" id="">
        <option value="">--Daftar Layanan--</option>
    </select>
    <button class="btn btn-primary btn-sm">Tambah</button>
</div>

<div class="table">
    <table class="table">
        <thead>
            <tr>
                <th>Layanan</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Perawat ICU</td>
                <td><button class="btn btn-sm btn-danger">Hapus</button></td>
            </tr>
            <tr>
                <td>Perawat Pendamping</td>
                <td><button class="btn btn-sm btn-danger">Hapus</button></td>
            </tr>
        </tbody>
    </table>
</div> -->
