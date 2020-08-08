<?php $this->start('style'); ?>
    <?php echo $this->Html->css('/vendor/bootstrap-datepicker/css/bootstrap-datepicker'); ?>
<?php $this->end(); ?>
<?php $this->start('script'); ?>
    <?php echo $this->Html->script('/vendor/bootstrap-datepicker/js/bootstrap-datepicker'); ?>
    <?php echo $this->Html->script("https://code.highcharts.com/highcharts.js"); ?>
    <?php echo $this->Html->script("https://code.highcharts.com/modules/exporting.js"); ?>
    <script>
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

        /**
        Highcharts.chart('done_contract', {
            chart: {type: 'line'},
            title: {text: 'Contract'},
            subtitle: {text: ' '},
            xAxis: {
                categories: [
                    <?php foreach ($date as $value) { ?>
                        "<?php echo $value ?>",
                    <?php } ?>
                ]
            },
            yAxis: {title: {text: 'Jumlah'}},
            plotOptions: {
                line: {
                    dataLabels: {enabled: true},
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Deal',
                data: [
                    <?php foreach ($deal as $value) { ?>
                        <?php echo $value ?>,
                    <?php } ?>
                ]
            }]
        });
        */

        /**
        Highcharts.chart('not_done_contract', {
            chart: {type: 'column'},
            title: {text: 'Contract'},
            subtitle: {text: ' '},
            xAxis: {
                categories: [
                    <?php foreach ($date as $value) { ?>
                        "<?php echo $value ?>",
                    <?php } ?>
                ]
            },
            yAxis: {title: {text: 'Jumlah'}},
            plotOptions: {
                line: {
                    dataLabels: {enabled: true},
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Draft',
                data: [
                    <?php foreach ($draft as $value) { ?>
                        <?php echo $value ?>,
                    <?php } ?>
                ]
            },
            {
                name: 'Done',
                data: [
                    <?php foreach ($done as $value) { ?>
                        <?php echo $value ?>,
                    <?php } ?>
                ]
            },
            {
                name: 'No Response',
                data: [
                    <?php foreach ($no_response as $value) { ?>
                        <?php echo $value ?>,
                    <?php } ?>
                ]
            },
            {
                name: 'Cancel',
                data: [
                    <?php foreach ($cancel as $value) { ?>
                        <?php echo $value ?>,
                    <?php } ?>
                ]
            }
            ]
        });

        Highcharts.chart('service_contract', {
            chart: {type: 'column'},
            title: {text: 'Service'},
            subtitle: {text: ' '},
            xAxis: {
                categories: [
                    <?php foreach ($date_service as $value) { ?>
                        "<?php echo $value ?>",
                    <?php } ?>
                ]
            },
            yAxis: {title: {text: 'Jumlah'}},
            plotOptions: {
                line: {
                    dataLabels: {enabled: true},
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Perawat',
                data: [
                    <?php foreach ($nurse_service as $value) { ?>
                        <?php echo $value ?>,
                    <?php } ?>
                ]
            },
            {
                name: 'Alat Kesehatan',
                data: [
                    <?php foreach ($medic_tool_service as $value) { ?>
                        <?php echo $value ?>,
                    <?php } ?>
                ]
            },
            {
                name: 'Therapist',
                data: [
                    <?php foreach ($therapist_service as $value) { ?>
                        <?php echo $value ?>,
                    <?php } ?>
                ]
            },
            {
                name: 'Event',
                data: [
                    <?php foreach ($event_service as $value) { ?>
                        <?php echo $value ?>,
                    <?php } ?>
                ]
            },
            {
                name: 'Transport',
                data: [
                    <?php foreach ($transport_service as $value) { ?>
                        <?php echo $value ?>,
                    <?php } ?>
                ]
            },
            ]
        });
        */

        $('#DoneFilterBtn').bind('click', function() {
            var chart1 = $('#done_contract').highcharts();
            var start_date = $('#DoneFromDate').val();
            var end_date = $('#DoneToDate').val();
            var data_get = {
                'start_date' : start_date,
                'end_date' : end_date,
            };

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Url->build(['controller' => 'Home', 'action' => 'getByStatus']); ?>',
                data: data_get,
                dataType: "json",
                success: function(result) {
                    chart1.xAxis[0].categories=result.date;
                    chart1.series[0].update({data: result.deal}, false);
                    chart1.redraw();
                }
            });
        });

        $('#NotDoneFilterBtn').bind('click', function() {
            var chart1 = $('#not_done_contract').highcharts();
            var start_date = $('#NotDoneFromDate').val();
            var end_date = $('#NotDoneToDate').val();
            var data_get = {
                'start_date' : start_date,
                'end_date' : end_date,
            };

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Url->build(['controller' => 'Home', 'action' => 'getByStatus']); ?>',
                data: data_get,
                dataType: "json",
                success: function(result) {
                    chart1.xAxis[0].categories=result.date;
                    chart1.series[0].update({data: result.draft}, false);
                    chart1.series[1].update({data: result.done}, false);
                    chart1.series[2].update({data: result.no_response}, false);
                    chart1.series[3].update({data: result.cancel}, false);
                    chart1.redraw();
                }
            });
        });

        $('#ServiceFilterBtn').bind('click', function() {
            var chart1 = $('#service_contract').highcharts();
            var start_date = $('#ServiceFromDate').val();
            var end_date = $('#ServiceToDate').val();
            var data_get = {
                'start_date' : start_date,
                'end_date' : end_date,
            };

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Url->build(['controller' => 'Home', 'action' => 'getByService']); ?>',
                data: data_get,
                dataType: "json",
                success: function(result) {
                    chart1.xAxis[0].categories=result.date_service;
                    chart1.series[0].update({data: result.nurse_service}, false);
                    chart1.series[1].update({data: result.medic_tool_service}, false);
                    chart1.series[2].update({data: result.therapist_service}, false);
                    chart1.series[3].update({data: result.event_service}, false);
                    chart1.series[4].update({data: result.transport_service}, false);
                    chart1.redraw();
                }
            });
        });
    </script>
<?php $this->end(); ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<h4 class="page-head-line">
                    Dashboard
                </h4>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pull-left">
                            <h4><b>Permintaan layanan</b></h4>
                        </div>
                        <div class="pull-right">
                            <div class="form-inline">
                                <div class="form-group">
                                    <label for="FromDate">Dari Tanggal:</label>
                                    <input type="text" name="done_from_date" class="input-sm date" id="DoneFromDate" value="<?php echo date('Y-m-01') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="FromDate">Sampai Tanggal:</label>
                                    <input type="text" name="done_to_date" class="input-sm date" id="DoneToDate" value="<?php echo date('Y-m-d') ?>">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-sm" id="DoneFilterBtn">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-xs-6">
						<div class="dashboard-div-wrapper bk-clr-eight">
                        <a href="<?php echo $this->Url->build(['action' => 'dealStatistic']); ?>">
							<i  class="fa fa-money dashboard-div-icon" ></i>
							<div class="progress progress-striped active">

							</div>
                            </a>
							<h6>Deal: 100</h6>
                            
						</div>
					</div>
					<div class="col-sm-4 col-xs-6">
						<div class="dashboard-div-wrapper bk-clr-two">
							<i  class="fa fa-caret-square-o-left dashboard-div-icon" ></i>
							<div class="progress progress-striped active">

							</div>
							<h6>Menunggu Kabar : 100</h6>
						</div>
					</div>
					<div class="col-sm-4 col-xs-6">
						<div class="dashboard-div-wrapper bk-clr-five">
						<i  class="fa fa-caret-square-o-left dashboard-div-icon" ></i>
							<div class="progress progress-striped active">
							</div>

							<h6>Cancel: 123</h6>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
						<div class="dashboard-div-wrapper bk-clr-nine">
						<i  class="fa fa-caret-square-o-left dashboard-div-icon" ></i>
							<div class="progress progress-striped active">
							</div>

							<h6>Tidak Merespon: 123</h6>
						</div>
					</div>
					<div class="col-sm-6 col-xs-6">
						<div class="dashboard-div-wrapper bk-clr-six">
							<i  class="fa fa-square-o dashboard-div-icon" ></i>
							<div class="progress progress-striped active">
							</div>
							<h6>Total Permintaan: 124</h6>
						</div>
					</div>
                </div>

                <div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
                            <div class="panel-heading">
                                <h4>Kategori Medis</h4>
                            </div>
							<div class="panel-body">
								<div id="done_contract" style="width: 100%; height: 250px; margin: 0 auto;"></div>
							</div>
						</div>
					</div>

                    <div class="col-md-6">
						<div class="panel panel-default">
                            <div class="panel-heading">
                            <h4>Kategori Therapist</h4>
                            </div>
							<div class="panel-body">
								<div id="done_contract" style="width: 100%; height: 250px; margin: 0 auto;"></div>
							</div>
						</div>
					</div>
				</div>
                <div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
                            <div class="panel-heading">
                            <h4>Kategori Visit</h4>
                            </div>
							<div class="panel-body">
								<div id="done_contract" style="width: 100%; height: 250px; margin: 0 auto;"></div>
							</div>
						</div>
					</div>

                    <div class="col-md-6">
						<div class="panel panel-default">
                            <div class="panel-heading">
                            <h4>Kategori Transport</h4>
                            </div>
							<div class="panel-body">
								<div id="done_contract" style="width: 100%; height: 250px; margin: 0 auto;"></div>
							</div>
						</div>
					</div>
				</div>
                <div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
                            <div class="panel-heading">
                            <h4>Kategori Lainnya</h4>
                            </div>
							<div class="panel-body">
								<div id="done_contract" style="width: 100%; height: 250px; margin: 0 auto;"></div>
							</div>
						</div>
					</div>

                    <div class="col-md-6">
						<div class="panel panel-default">
                            <div class="panel-heading">
                            <h4>Kategori Paket Homecare</h4>
                            </div>
							<div class="panel-body">
								<div id="done_contract" style="width: 100%; height: 250px; margin: 0 auto;"></div>
							</div>
						</div>
					</div>
				</div>
                
                
            </div>
        </div>
    </div>
</div>