<div class="panel panel-primary">
	<div class="panel-body">
        <h4 class="page-head-line">Contract Note</h4>
		<?php echo $this->Form->create(null, ['url' => ['controller' => 'TicketNotes', 'action' => 'add', '?' => ['ticket' => 'xx', 'media' => $this->request->query('media')]], 'type' => 'post', 'id' => 'AddNote', 'data-parsley-validate']); ?>
		<div class="form-group">
			<label>Note</label>
			<textarea class="form-control input-sm" id="TicketNote" name="ticket_note" rows="5" placeholder="Please fill ticket note here..." required></textarea>
		</div>
		<div class="form-group">
			<label>Status</label>
			<br>
			<div class="btn-group" data-toggle="buttons" title="Click to change ticket status">
				<label class="btn btn-sm btn-default active">
					<input type="radio" name="ticket_status" id="Note" value="note"> Note
				</label>

                <label class="btn btn-sm btn-default">
					<input type="radio" name="ticket_status" id="Assign" value="assign"> No Response
				</label>

				<label class="btn btn-sm btn-default">
					<input type="radio" name="ticket_status" id="Assign" value="assign"> Done
				</label>

				<label class="btn btn-sm btn-default">
					<input type="radio" name="ticket_status" id="Process" value="process"> Cancelled
				</label>
			</div>
		</div>

		<div class="form-group text-right">
			<button type="submit" class="btn btn-primary" id="submit_ticket">Add Note</button>
			<button type="reset" class="btn btn-danger" id="submit_ticket">Reset</button>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		Ticket Notes
	</div>
	<div class="panel-body" style="overflow-y:scroll; height:300px;">
	</div>
</div>
