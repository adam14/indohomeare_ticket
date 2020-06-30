<?php $this->start('style'); ?>
<?php echo $this->Html->css('/vendor/bootstrap-datepicker/css/bootstrap-datepicker'); ?>
<?php $this->end(); ?>
<?php $this->start('script'); ?>
<?php echo $this->Html->script('/vendor/bootstrap-datepicker/js/bootstrap-datepicker'); ?>
<?php echo $this->Html->script('/vendor/parsley/js/parsley.min'); ?>
<script>
	$(document).ready(function() {
        $(".date").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            minView: 2,
            weekStart: 1,
            language: 'en',
            startDate: '',
            endDate: '<?php echo date('Y-m-d'); ?>',
            todayHighlight: true,
	    });

		$('#Code').bind('change keyup input', function() {
			this.value = this.value.toUpperCase();
		});

        $("#PJ").on('change', function() {
            var pj_id = $(this).val();
            var data_pj = {
                'pj_id' : pj_id
            };

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Url->build(['controller' => 'Contracts', 'action' => 'getPatient']); ?>',
                data: data_pj,
                dataType: "json",
                success: function(result) {
                    $('#Patient').empty();
                    $('#Patient').append(new Option('-- Please Select --', ''));

                    for (i = 0; i < result.data.length; i++) {
                        $('#Patient').append('<option value="'+ result.data[i].id +'">'+ result.data[i].fullname +'</option>')
                    }

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo $this->Url->build(['controller' => 'Contracts', 'action' => 'detailPj']); ?>',
                        data: data_pj,
                        dataType: "json",
                        success: function(result) {                            
                            if (result.status == 'true') {
                                $('#NamaLengkap').val(result.data.fullname);
                                $('#NomorTelepon').val(result.data.handphone);
                                $('#KTP').val(result.data.ktp);
                                $('#Email').val(result.data.email);
                                $('#Alamat').val(result.data.address);
                            } else {
                                $('#NamaLengkap').val('');
                                $('#NomorTelepon').val('');
                                $('#KTP').val('');
                                $('#Email').val('');
                                $('#Alamat').val('');
                            }
                        }
                    });
                }
            });
        });

        $('#Patient').on('change', function() {
            var patient_id = $(this).val();
            var data_patient = {
                'patient_id' : patient_id
            };

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Url->build(['controller' => 'Contracts', 'action' => 'detailPatient']); ?>',
                data: data_patient,
                dataType: "json",
                success: function(result) {
                    if (result.status == 'true') {
                        $('#RekomendasiDari').val(result.data.recomendation_from);
                        $('#JenisKelamin').val(result.data.gender);
                        $('#Umur').val(result.data.years);
                        $('#BeratBadan').val(result.data.height);
                        $('#TinggiBadan').val(result.data.weight);
                        $('#AlamatLengkap').val(result.data.address);
                        $('#AlatTerpasang').val(result.data.attached_tools);
                        $('#Diagnosa').val(result.data.diagnosis);
                        $('#KeluhanUtama').val(result.data.main_complaint);
                    } else {
                        $('#RekomendasiDari').val('');
                        $('#JenisKelamin').val('');
                        $('#Umur').val('');
                        $('#BeratBadan').val('');
                        $('#TinggiBadan').val('');
                        $('#AlamatLengkap').val('');
                        $('#AlatTerpasang').val('');
                        $('#Diagnosa').val('');
                        $('#KeluhanUtama').val('');
                    }
                }
            });
        });
	});
</script>
<?php echo $this->element('Contract/contract_script'); ?>
<?php $this->end(); ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
                <h4 class="page-head-line">Form Kontrak</h4>
				<div class="tab-content">
					<div id="Detail" class="tab-pane fade in active">
                        <?php echo $this->Form->create(null, ['url' => ['action' => 'add', $contracts['contract_no']], 'type' => 'file', 'data-parsley-validate']); ?>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 margin-bottom-30">
                                    <h4>Data Kontrak</h4>
                                    <div class="panel panel-primary">
                                        <div class="panel-body">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Nomor Kontrak</label>
                                                    <input type="text" class="form-control input-sm" name="contract_no" id="ContractNo" value="<?php echo $contracts['contract_no'] ?>" readonly>
                                                    <input type="hidden" class="form-control input-sm" name="contract_id" id="ContractID" value="<?php echo $contracts['id']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal Mulai</label>
                                                    <input type="text" name="start_date" id="StartDate" class="form-control input-sm date" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal Berakhir</label>
                                                    <input type="text" name="end_date" id="EndDate" class="form-control input-sm date" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Dibuat Oleh</label>
                                                    <input type="text" class="form-control input-sm" value="<?php echo $contracts['users']['fullname']; ?>" readonly>
                                                    <input type="hidden" class="form-control input-sm" value="<?php echo $contracts['users']['id']; ?>" name="created_by">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="text" class="form-control input-sm" value="<?php echo date('d-m-Y', strtotime($contracts['created_at'])); ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 margin-bottom-30">
                                    <h4>Data PJ</h4>
                                    <div class="panel panel-primary">
                                        <div class="panel-body">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>PJ</label>
                                                    <select name="pj_id" id="PJ" class="form-control input-sm">
                                                        <option value="">--Silahkan Pilih--</option>
                                                        <?php foreach ($pjs as $value): ?>
                                                            <option value="<?php echo $value['id']; ?>"><?php echo $value['fullname']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama Lengkap</label>
                                                    <input type="text" id="NamaLengkap" class="form-control input-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nomor Telepon</label>
                                                    <input type="text" id="NomorTelepon" class="form-control input-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>KTP</label>
                                                    <input type="text" id="KTP" class="form-control input-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" id="Email" class="form-control input-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Alamat</label>
                                                    <textarea id="Alamat" class="form-control input-sm" rows="4" readonly></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 margin-bottom-30">
                                    <h4>Data Layanan</h4>
                                    <div class="panel panel-primary">
                                        <div class="panel-body">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#perawat" class="menu-tab">Perawat</a></li>
                                                <li><a data-toggle="tab" href="#therapist" class="menu-tab">Therapist</a></li>
                                                <li><a data-toggle="tab" href="#alkes" class="menu-tab">Alkes</a></li>
                                                <li><a data-toggle="tab" href="#transport" class="menu-tab">Transport</a></li>
                                                <li><a data-toggle="tab" href="#event" class="menu-tab">Event</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div id="perawat" class="tab-pane fade in active">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="panel panel-default">
                                                                <div class="panel-body">
                                                                    <h4 class="page-head-line">Nurses</h4>
                                                                    <?php echo $this->Html->link('Add New', 'javascript:;', ['class' => 'disable btn btn-sm btn-success', 'id' => 'ButtonAddContractNurse', 'title' => 'Click to Add', 'escape' => false]); ?>
                                                                    <div class="row">
                                                                        <div id="NurseAdd" class="col-md-12 margin-bottom-30">
                                                                            <div class="panel panel-primary">
                                                                                <div class="panel-body">
                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label>Nurses</label>
                                                                                                <select id="Nurses" class="form-control input-sm">
                                                                                                    <option value="">-- Please Select --</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label>Nurse Sessions</label>
                                                                                                <select id="NurseSessions" class="form-control input-sm">
                                                                                                    <option value="">-- Please Select --</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <button type="button" class="btn btn-sm btn-success" id="SaveAddContractNurse">Save</button>
                                                                                            <button type="button" class="btn btn-sm btn-default" id="CancelAddContractNurse">Cancel</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div id="NurseList" class="col-md-12 margin-bottom-30">
                                                                            <div class="panel panel-primary">
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-striped table-hover">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Nurse Name</th>
                                                                                                <th>Nurse Session</th>
                                                                                                <th>Price</th>
                                                                                                <th>Action</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody id="bodyNurse">
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="therapist" class="tab-pane fade in">
                                                    <h4>form therapist</h4>
                                                </div>

                                                <div id="alkes" class="tab-pane fade in">
                                                    <h4>form alkes</h4>
                                                </div>

                                                <div id="transport" class="tab-pane fade in">
                                                    <h4>form transport</h4>
                                                </div>

                                                <div id="event" class="tab-pane fade in">
                                                    <h4>form event</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 margin-bottom-30">
                                    <h4>Data Pasien</h4>
                                    <div class="panel panel-primary">
                                        <div class="panel-body">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <select name="patient_id" id="Patient" class="form-control input-sm">
                                                        <option value="">--Silahkan Pilih--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Rekomendasi Dari</label>
                                                    <input type="text" id="RekomendasiDari" class="form-control input-sm"readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Jenis Kelamin</label>
                                                    <input type="text" id="JenisKelamin" class="form-control input-sm"readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Umur</label>
                                                    <input type="number" id="Umur" class="form-control input-sm"readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Berat Badan (kg)</label>
                                                    <input type="number" id="BeratBadan" class="form-control input-sm"readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Tinggi Badan (cm)</label>
                                                    <input type="number" id="TinggiBadan" class="form-control input-sm"readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Alamat Lengkap</label>
                                                    <textarea class="form-control input-sm" id="AlamatLengkap" rows="4" readonly></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Alat Yang Terpasang</label>
                                                    <textarea class="form-control input-sm" id="AlatTerpasang" rows="4" readonly></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Diagnosa</label>
                                                    <textarea class="form-control input-sm" id="Diagnosa" rows="4" readonly></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Keluhan Utama</label>
                                                    <textarea class="form-control input-sm" id="KeluhanUtama" rows="4" readonly></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-offset-6">
                                    <div class="col-md-12">
                                        <div class="form-group text-right">
                                            <button type="submit" class="btn btn-primary" id="submit_ticket">Simpan</button>
                                            <?php echo $this->Html->link('Kembali', ['controller' => 'Contracts', 'action' => 'index'], ['class' => 'btn btn-danger', 'escape' => false]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php echo $this->Form->end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
