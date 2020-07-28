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
		<label for="PhoneNo" class="col-lg-3 control-label">Nomor Telepon</label>
		<div class="col-lg-9">
			<input name="phone_no" class="form-control" id="PhoneNo" placeholder="Nomor Telepon" type="text">
		</div>
	</div>
    <div class="form-group">
		<label for="Name" class="col-lg-3 control-label">Deskripsi</label>
		<div class="col-lg-9">
			<textarea name="description" id="Description" class="form-control" rows="3"></textarea>
		</div>
	</div>
    <div class="form-group">
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
                                            &nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="therapist" class="tab-pane fade in">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            &nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="alkes" class="tab-pane fade in">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            &nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="transport" class="tab-pane fade in">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            &nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="event" class="tab-pane fade in">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            &nbsp;
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
    <div class="form-group">
        <!-- <label for="Name" class="col-lg-3 control-label">Status</label> -->
		<div class="col-lg-12">
        	<div class="btn-group" data-toggle="buttons" title="Click to change ticket status">
				<input type="hidden" id="StatusUpdated" value="Note" class="form-control input-sm">
				<label class="btn btn-sm btn-primary active">
					<input type="radio" name="ticket_status" id="Note" value="Note" checked> Deal
				</label>

                <label class="btn btn-sm btn-primary">
					<input type="radio" name="ticket_status" id="NoResponse" value="No Response"> Menunggu Kabar
				</label>

                <label class="btn btn-sm btn-primary">
					<input type="radio" name="ticket_status" id="NoResponse" value="No Response"> Tidak Memilih
				</label>

				<label class="btn btn-sm btn-primary">
					<input type="radio" name="ticket_status" id="Cancelled" value="Cancelled"> Cancelled
				</label>
			</div>
        </div>
	</div>
	<div class="form-group">
		<div class="col-lg-12 pull-right">
			<button type="submit" class="btn btn-primary pull-right">Tambah</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>