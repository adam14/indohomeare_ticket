<?php $this->start('style'); ?>
<?php echo $this->Html->css('/vendor/bootstrap-select/css/bootstrap-select'); ?>
<?php echo $this->Html->css('/vendor/select-multiple/css/select-multiple'); ?>
<?php $this->end(); ?>
<?php $this->start('script'); ?>
<script>
	$(document).ready(function() {		
		$('#confirm').on('show.bs.modal', function(e) {
			var link = $(e.relatedTarget).data('href');
			var label = $(e.relatedTarget).data('label');
			var message = $(e.relatedTarget).data('message');
			
			$('#confirm-label').html(label);
			$('.body-confirm').html(message);
			
			$(".btn-ok").on("click", function(e) {
				var form = $('<form action="' + link + '" method="post">' +
				'<input type="text" name="__method" value="post" />' +
                '<input type="hidden" name="_csrfToken" value="<?= $this->request->getParam('_csrfToken'); ?>' +
				'</form>');
				$('body').append(form);
				form.submit();
			});
		});

		$('#modal-form').on('show.bs.modal', function(e) {
			var link = $(e.relatedTarget).data('href');
			var label = $(e.relatedTarget).data('label');

            $('.modal-dialog').attr('style', 'width: 55%;');

			$('#form-label').html(label);
			$($(this).data('remote-target')).load(link);
			$('.body-form').load(link);
		});

		$('#modal-form').on('hidden.bs.modal', function() {
			$('.body-form').html('<p>Loading...</p>');
		});
	});
</script>
<?php echo $this->Html->script('/vendor/parsley/js/parsley.min'); ?>
<?php echo $this->Html->script('/vendor/bootstrap-select/js/bootstrap-select'); ?>
<?php echo $this->Html->script('/vendor/select-multiple/js/jquery.select-multiple'); ?>
<?php $this->end(); ?>
<div class="row" style="width: 100%; height: 100%;">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="page-head-line">Contract No : <?php echo $contracts->contract_no; ?></h4>
                <div class="row">
                    <div class="col-md-12">
                        <div id="AlertUpdate" hidden="true"></div>
                        <div id="AlertForm" hidden="true"></div>

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#detail" class="menu-tab">Detail</a></li>
                            <li><a data-toggle="tab" href="#perawat" class="menu-tab">Perawat</a></li>
                            <li><a data-toggle="tab" href="#therapist" class="menu-tab">Therapist</a></li>
                            <li><a data-toggle="tab" href="#alkes" class="menu-tab">Alkes</a></li>
                            <li><a data-toggle="tab" href="#transport" class="menu-tab">Transport</a></li>
                            <li><a data-toggle="tab" href="#event" class="menu-tab">Event</a></li>
                            <li><a data-toggle="tab" href="#history" class="menu-tab">History</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="detail" class="tab-pane fade in active">
                                <?php echo $this->element('Contract/Detail/index'); ?>
                            </div>
                            
                            <div id="perawat" class="tab-pane fade in">
                                <?php echo $this->element('Contract/Nurses/index'); ?>
                            </div>

                            <div id="therapist" class="tab-pane fade in">
								<?php echo $this->element('Contract/Therapist/index'); ?>
                            </div>

                            <div id="alkes" class="tab-pane fade in">
                                <?php echo $this->element('Contract/MedicTools/index'); ?>
                            </div>

                            <div id="transport" class="tab-pane fade in">
                                <?php echo $this->element('Contract/Transport/index'); ?>
                            </div>

                            <div id="event" class="tab-pane fade in">
                                <?php echo $this->element('Contract/Event/index'); ?>
                            </div>

                            <div id="history" class="tab-pane fade in">
                                <?php echo $this->element('Contract/History/index'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="confirm-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn btn-sm pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="confirm-label">Confirm</h4>
			</div>
			<div class="modal-body body-confirm">
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary btn-ok">Yes</a>
				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="form-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn btn-sm pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="form-label">Form</h4>
			</div>
			<div class="modal-body body-form">
				<p>Loading...</p>
			</div>
		</div>
	</div>
</div>