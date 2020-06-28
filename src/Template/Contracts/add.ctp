<?php $this->start('script'); ?>
<?php echo $this->Html->script('/vendor/parsley/js/parsley.min'); ?>
<script>
	$(document).ready(function() {
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
                }
            });
        });
	});
</script>
<?php $this->end(); ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
                <h4 class="page-head-line">Form Kontrak</h4>
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
                                                <input type="text" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Mulai</label>
                                                <input type="date" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Berakhir</label>
                                                <input type="date" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Dibuat Oleh</label>
                                                <input type="text" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal</label>
                                                <input type="text" class="form-control input-sm">
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
                                                <select name="" id="" class="form-control input-sm">
                                                    <option value="">--Silahkan Pilih--</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Lengkap</label>
                                                <input type="text" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nomor Telepon</label>
                                                <input type="text" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>KTP</label>
                                                <input type="text" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Alamat</label>
                                                <textarea name="" class="form-control input-sm" id="" cols="30" rows="3"></textarea>
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
                                                <h4>form perawat</h4>
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
                                                <select name="" id="" class="form-control input-sm">
                                                    <option value="">--Silahkan Pilih--</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Rekomendasi Dari</label>
                                                <input type="text" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Jenis Kelamin</label>
                                                <input type="text" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Umur</label>
                                                <input type="number" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Berat Badan (kg)</label>
                                                <input type="number" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Tinggi Badan (cm)</label>
                                                <input type="number" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Alamat Lengkap</label>
                                                <textarea class="form-control input-sm" id="TicketDetail" name="ticket_detail" rows="2" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Alat Yang Terpasang</label>
                                                <textarea class="form-control input-sm" id="TicketDetail" name="ticket_detail" rows="2" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Diagnosa</label>
                                                <textarea class="form-control input-sm" id="TicketDetail" name="ticket_detail" rows="2" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Keluhan Utama</label>
                                                <textarea class="form-control input-sm" id="TicketDetail" name="ticket_detail" rows="2" required></textarea>
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
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
