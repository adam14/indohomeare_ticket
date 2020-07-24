<?php use Cake\Core\Configure; ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<!--[if IE]>
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<![endif]-->
		<title><?php echo Configure::read('app'); ?> - <?php echo Configure::read('company'); ?></title>
		<?php echo $this->Html->css('style'); ?>
		<?php echo $this->Html->css('/vendor/parsley/css/parsley'); ?>
		<?php echo $this->fetch('style'); ?>
	</head>
	<body>
		<header>
			<div class="container">
				<div class="row">
					<div class="col-md-12 hidden-xs header-custom">
						<span class="pull-left"><?php echo $this->Html->image('logo-3.jpeg', ['alt' => 'Ticketing', 'url' => '/', 'class' => 'img-rounded header-logo']); ?></span>
                        <span class="user hidden-xs">Welcome, <?php echo $this->request->session()->read('Auth.User.email'); ?>.
							<a href="#" class="btn btn-sm btn-primary" title="New Form Order" data-toggle="modal" data-target="#NotificationModal" id="TicketNotificationModal">
								<i class="fa fa-tags" aria-hidden="true"></i> <span class="badge" id="TicketNotification">0</span>
							</a>
							<a href="#" class="btn btn-sm btn-primary" title="New Ticket Note" data-toggle="modal" data-target="#NotificationModal" id="TicketNoteNotificationModal">
								<i class="fa fa-comment" aria-hidden="true"></i> <span class="badge" id="TicketNoteNotification">0</span>
							</a>
							<a href="<?php echo $this->request->webroot; ?>users/logout" class="btn btn-sm btn-danger">Logout here</a>
						</span>
					</div>
					<div class="navbar-inner visible-xs">
						<div class="nav-center">
							<?php echo $this->Html->image('logo-3.jpeg', ['alt' => 'Ticketing', 'url' => '/', 'class' => 'img-rounded', 'width' => '100']); ?>
						</div>
					</div>
				</div>
			</div>
		</header>

        <div class="navbar navbar-inverse set-radius-zero visible-xs">
			<div class="container">
				<div class="navbar-header">
					<div class="user-settings-wrapper">
						<span class="user">Welcome, <?php echo $this->request->session()->read('Auth.User.email'); ?>. <a href="<?php echo $this->request->webroot; ?>users/logout" class="btn btn-sm btn-primary">Logout here</a></span>
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>
				</div>
			</div>
		</div>

        <section class="menu-section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="navbar-collapse collapse ">
							<?php echo $this->element('menu'); ?>
						</div>
					</div>
				</div>
			</div>
		</section>

        <div class="content-wrapper">
			<div class="container">
				<?php echo $this->Flash->render() ?>
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>

        <footer>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						&copy; <?php echo Configure::read('year'); ?> <?php echo Configure::read('copyright'); ?>
					</div>
				</div>
			</div>
		</footer>

        <?php echo $this->Html->script('jquery-1.11.1'); ?>
		<?php echo $this->Html->script('bootstrap'); ?>
        <?php echo $this->Html->script('pending'); ?>
		<?php echo $this->Html->script('jquery.dynamiclist.min'); ?>
		<?php echo $this->fetch('script'); ?>
    </body>
</html>