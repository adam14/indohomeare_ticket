<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<p><?php echo h($message) ?></p>
	<?php if (!empty($params['number'])): ?>
	<p>Nomor yang sudah tidak tersedia</p>
	<ul>
	<?php for($i = 0; $i < count($params['number']); $i++): ?>
		<li><?php echo $params['number'][$i]['mobile_number']; ?></li>
	<?php endfor; ?>
	</ul>
	<?php endif; ?>
</div>
