<?php $this->start('style'); ?>
<?php echo $this->Html->css('/vendor/bootstrap-datepicker/css/bootstrap-datepicker'); ?>
<?php $this->end(); ?>
<?php $this->start('script'); ?>
<?php echo $this->Html->script('/vendor/bootstrap-datepicker/js/bootstrap-datepicker'); ?>
<script>
    $(document).ready(function() {
        $(".date").datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			minView: 2,
			weekStart: 1,
			language: 'en',
			startDate: '',
			endDate: '',
			todayHighlight: true,
		});

        $('#DisableDate').on('change', function() {
            if ($(this).prop('checked')) {
                $('#FromDate').attr('disabled', 'disabled');
                $('#ToDate').attr('disabled', 'disabled');
            } else {
                $('#FromDate').removeAttr('disabled');
                $('#ToDate').removeAttr('disabled');
            }
        });
    });
</script>
<?php $this->end(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="page-head-line">Laporan</h4>
				<div class="row">
					<div class="col-md-12 col-sm-12 margin-bottom-30">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        Pencarian Data
                                    </div>
                                </div>
                                <hr>
                                <?php echo $this->Form->create(null, ['url' => ['controller' => 'Exports', 'action' => 'index'], 'target' => '_blank', 'type' => 'post', 'data-parsley-validate']); ?>
                                    <div class="row">
                                        <div class="form-group col-sm-2" style="margin-bottom: 10px;">
                                            <label for="DisableDate">Non Aktifkan Tanggal</label>
                                            <br>
                                            <span class="btn btn-sm btn-default">
                                                <input type="checkbox" name="disable_date" class="" id="DisableDate" value="1">
                                            </span>
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <label for="FromDate">Dari Tanggal:</label>
                                            <input type="text" name="start_date" class="form-control input-sm date" id="FromDate" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <label for="ToDate">Sampai Tanggal:</label>
                                            <input type="text" name="end_date" class="form-control input-sm date" id="ToDate" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <button type="submit" class="btn btn-sm btn-primary" id="SubmitReport">Proses</button>
                                        </div>
                                    </div>
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>