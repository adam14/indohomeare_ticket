<?php
$subtotal_nurse = 0;
$subtotal_therapist = 0;
$subtotal_medic_tool = 0;
$subtotal_transport = 0;
$subtotal_event = 0;
$total = 0;

if (!empty($nurse_contracts)) {
    foreach ($nurse_contracts as $value) {
        $subtotal_nurse = $subtotal_nurse + $value['nurse_sessions']['price'];
    }
    $total += $subtotal_nurse;
}

if (!empty($therapist_contracts)) {
    foreach ($therapist_contracts as $value) {
        $subtotal_therapist = $subtotal_therapist + $value['therapist_sessions']['price'];
    }
    $total += $subtotal_therapist;
}

if (!empty($medic_tool_contracts)) {
    foreach ($medic_tool_contracts as $value) {
        $subtotal_medic_tool = $subtotal_medic_tool + $value['total_price'];
    }
    $total += $subtotal_medic_tool;
}

if (!empty($transport_contracts)) {
    foreach ($transport_contracts as $value) {
        $subtotal_transport = $subtotal_transport + $value['transport_times']['price'];
    }
    $total += $subtotal_transport;
}

if (!empty($event_contracts)) {
    foreach ($event_contracts as $value) {
        $subtotal_event = $subtotal_event + $value['price'];
    }
    $total += $subtotal_event;
}
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
                <h4 class="page-head-line">Detail</h4>
				<div class="tab-content">
					<div id="Detail" class="tab-pane fade in active">
						<div class="row">
							<div class="col-md-6 col-sm-12 margin-bottom-30">
                                <h4>Data Kontrak</h4>
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nomor Kontrak</label>
                                                <input type="text" class="form-control input-sm" value="<?php echo $contracts->contract_no; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Mulai</label>
                                                <input type="text" class="form-control input-sm" value="<?php echo (!empty($contracts->start_date)) ? date('d-m-Y', strtotime($contracts->start_date)) : ''; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Berakhir</label>
                                                <input type="text" class="form-control input-sm" value="<?php echo (!empty($contracts->end_date)) ? date('d-m-Y', strtotime($contracts->end_date)) : ''; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Dibuat Oleh</label>
                                                <input type="text" class="form-control input-sm" value="<?php echo $contracts->users['fullname']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal</label>
                                                <input type="text" class="form-control input-sm" value="<?php echo (!empty($contracts->created_at)) ? date('d-m-Y', strtotime($contracts->created_at)) : ''; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Jumlah Biaya</label>
                                                <input type="text" class="form-control input-sm" value="<?php echo $this->Number->currency($total, 'Rp '); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <p>Subtotal Perawat : <?php echo $this->Number->currency($subtotal_nurse, 'Rp '); ?></p>
                                            <p>Subtotal Terapi : <?php echo $this->Number->currency($subtotal_therapist, 'Rp '); ?></p>
                                            <p>Subtotal Alkes : <?php echo $this->Number->currency($subtotal_medic_tool, 'Rp '); ?></p>
                                            <p>Subtotal Transport : <?php echo $this->Number->currency($subtotal_transport, 'Rp '); ?></p>
                                            <p>Subtotal Event : <?php echo $this->Number->currency($subtotal_event, 'Rp '); ?></p>
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
                                                <select class="form-control input-sm" id="ContractPJ" disabled>
                                                    <option value="">--Silahkan Pilih--</option>
                                                    <?php foreach ($pjs as $value): ?>
                                                        <option value="<?php echo $value['id']; ?>" <?php echo ($contracts->pj_id == $value['id']) ? 'selected' : ''; ?>><?php echo $value['fullname']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Lengkap</label>
                                                <input type="text" id="ContractPJNamaLengkap" class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nomor Telepon</label>
                                                <input type="text" id="ContractPJNomorTelepon" class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>KTP</label>
                                                <input type="text" id="ContractPJKTP" class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" id="ContractPJEmail" class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Alamat</label>
                                                <textarea id="ContractPJAlamat" class="form-control input-sm" rows="4" readonly></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							</div>
                            <div class="col-md-6 col-sm-12 margin-bottom-30">
                                <a target="_blank" href="<?php echo $this->Url->build(['controller' => 'Contracts', 'action' => 'print']); ?>/<?php echo $contracts->id; ?>" class="btn btn-primary btn-sm">Print Invoice</a>
                            </div>
                            <div class="col-md-12 col-sm-12 margin-bottom-30">
                                <h4>Data Pasien</h4>
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <select id="ContractPatient" class="form-control input-sm">
                                                    <option value="">--Silahkan Pilih--</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Rekomendasi Dari</label>
                                                <input type="text" id="ContractPatientRekomendasiDari" class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Jenis Kelamin</label>
                                                <input type="text" id="ContractPatientJenisKelamin" class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Umur</label>
                                                <input type="text" id="ContractPatientUmur" class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Berat Badan (kg)</label>
                                                <input type="text" id="ContractPatientBeratBadan" class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Tinggi Badan (cm)</label>
                                                <input type="text" id="ContractPatientTinggiBadan" class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Alamat Lengkap</label>
                                                <textarea id="ContractPatientAlamatLengkap" class="form-control input-sm" rows="4" readonly></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Alat Yang Terpasang</label>
                                                <textarea id="ContractPatientAlatTerpasang" class="form-control input-sm" rows="4" readonly></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Diagnosa</label>
                                                <textarea id="ContractPatientDiagnosa" class="form-control input-sm" rows="4" readonly></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Keluhan Utama</label>
                                                <textarea id="ContractPatientKeluhanUtama" class="form-control input-sm" rows="4" readonly></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
