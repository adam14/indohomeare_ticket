<?php $this->start('script'); ?>
<script>
	$(function (){
		/* Bootstrap */
		$('#top-bar a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		});
		
		$('.subnavbar').find ('li').each (function (i) {
			var mod = i % 3;
			if (mod === 2) {
				$(this).addClass ('subnavbar-open-right');
			}
		});
		
		$('#myTab a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		});
		
		$('#loading-example-btn').click(function () {
			var btn = $(this);
			btn.button('loading');
		});
		
	});
</script>
<?php $this->end(); ?>
<div class="container-login center-block">
	<section>
		<?php echo $this->Flash->render() ?>
		<ul id="top-bar" class="nav nav-tabs nav-justified">
			<li class="active"><a href="#login-access">Login</a></li>
			<li><a href="#forgot-password">Forgot Password</a></li>
		</ul>
		<div class="tab-content tabs-login col-lg-12 col-md-12 col-sm-12 cols-xs-12">
			<div id="login-access" class="tab-pane fade active in">
				<div class="col-md-6">
					<h2><i class="fa fa-sign-in"></i> Login</h2>
				</div>
				<div class="col-md-6 hidden-sm hidden-xs">
					<?php echo $this->Html->image('logo-3.jpeg', ['width' => 80,'alt' => 'Ticketing', 'class' => 'pull-right']); ?>
				</div>
				<?php echo $this->Form->create(null, ['url' => '', 'class' => 'form-horizontal', 'autocomplete' => 'off', 'role' => 'form', 'data-parsley-validate']); ?>
				<div class="form-group">
					<label for="Email" class="sr-only">Email</label>
					<input type="email" class="form-control" name="email" id="Email" placeholder="Email" tabindex="1" value="" required>
				</div>
				<div class="form-group">
					<label for="password" class="sr-only">Password</label>
					<input type="password" class="form-control" name="password" id="password" placeholder="Password" value="" tabindex="2" required>
				</div>
				<br/>
				<div class="form-group">
					<button type="submit" id="submit" tabindex="5" class="btn btn-block btn-primary">Enter</button>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
			<div id="forgot-password" class="tab-pane fade">
				<h2><i class="fa fa-question-circle"></i> Forgot Password</h2>
				<?php echo $this->Form->create(null, ['url' => ['controller' => 'Password', 'action' => 'request'], 'class' => 'form-horizontal', 'autocomplete' => 'off', 'role' => 'form', 'data-parsley-validate']); ?>
				<div class="form-group">
					<label for="email" class="sr-only">Email</label>
					<input type="email" class="form-control" name="email" id="email" placeholder="Email" tabindex="1" value="" required/>
				</div>
				<br/>
				<div class="form-group">
					<button type="submit" id="submit" tabindex="5" class="btn btn-block btn-primary">Send</button>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</section>
</div>