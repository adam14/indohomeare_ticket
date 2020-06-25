<?php $this->start('style'); ?>
<?php echo $this->Html->css('/vendor/bootstrap-select/css/bootstrap-select'); ?>
<?php echo $this->Html->css('/vendor/select-multiple/css/select-multiple'); ?>
<?php $this->end(); ?>
<?php $this->start('script'); ?>
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
                                Detail
                            </div>
                            
                            <div id="perawat" class="tab-pane fade in">
                                Perawat
                            </div>

                            <div id="therapist" class="tab-pane fade in">
                                Therapist
                            </div>

                            <div id="alkes" class="tab-pane fade in">
                                Alkes
                            </div>

                            <div id="transport" class="tab-pane fade in">
                                Transports
                            </div>

                            <div id="event" class="tab-pane fade in">
                                Event
                            </div>

                            <div id="history" class="tab-pane fade in">
                                History
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>