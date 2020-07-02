<div class="panel panel-primary">
	<div class="panel-body">
        <h4 class="page-head-line">Contract History</h4>
		<?php echo $this->Form->create(null, ['url' => ['controller' => 'TicketNotes', 'action' => 'add', '?' => ['ticket' => 'xx', 'media' => $this->request->query('media')]], 'type' => 'post', 'id' => 'AddNote', 'data-parsley-validate']); ?>
		<div class="form-group">
			<label>Note</label>
			<textarea class="form-control input-sm" id="Description" name="description" rows="5" placeholder="Please fill history note here..." required></textarea>
		</div>
		<div class="form-group">
			<label>Status</label>
			<br>
			<div class="btn-group" data-toggle="buttons" title="Click to change ticket status">
				<input type="hidden" id="StatusUpdated" value="Note" class="form-control input-sm">
				<label class="btn btn-sm btn-default active">
					<input type="radio" name="ticket_status" id="Note" value="Note" checked> Note
				</label>

                <label class="btn btn-sm btn-default">
					<input type="radio" name="ticket_status" id="NoResponse" value="No Response"> No Response
				</label>

				<label class="btn btn-sm btn-default">
					<input type="radio" name="ticket_status" id="Done" value="Done"> Done
				</label>

				<label class="btn btn-sm btn-default">
					<input type="radio" name="ticket_status" id="Cancelled" value="Cancelled"> Cancelled
				</label>
			</div>
		</div>

		<div class="form-group text-right">
			<button type="button" class="btn btn-sm btn-primary" id="AddHistory">Add Note</button>
			<button type="reset" class="btn btn-sm btn-danger" id="ResetHistory">Reset</button>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		Ticket Notes
	</div>
	<div class="panel-body" id="ResultNote" style="overflow-y:scroll; height:300px;">
	</div>
</div>
