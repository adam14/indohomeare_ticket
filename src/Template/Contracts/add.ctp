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
<?php echo $this->Form->create(null, ['url' => ['action' => 'add'], 'type' => 'file', 'class' => 'form-horizontal', 'data-parsley-validate']); ?>
<fieldset>
	<div class="form-group">
		<label for="PJ" class="col-lg-3 control-label">PJ</label>
		<div class="col-lg-9">
			<select class="form-control" name="pj_id" id="PJ" required>
                <option value="">-- Please Select --</option>
                <?php foreach ($pjs as $value): ?>
                    <option value="<?php echo $value['id'] ?>"><?php echo $value['fullname']; ?></option>
                <?php endforeach; ?>
            </select>
		</div>
	</div>
	<div class="form-group">
		<label for="Patient" class="col-lg-3 control-label">Patient</label>
		<div class="col-lg-9">
            <select class="form-control" name="patient_id" id="Patient" required>
                <option value="">-- Please Select --</option>
            </select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="submit" class="btn btn-primary">Add</button>
		</div>
	</div>
</fieldset>
<?php echo $this->Form->end(); ?>