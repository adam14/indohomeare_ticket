<?php use Cake\Core\Configure; ?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<title><?php echo Configure::read('app'); ?> - <?php echo Configure::read('company'); ?></title>  
	<?php echo $this->Html->css('login') ?>
	<?php echo $this->Html->css('/vendor/parsley/css/parsley') ?>
</head>
<body>
    <div class="container">
        <div class="col-lg-12 col-md-12 col-sm-12 cols-xs-12">
            <div class="container-login center-block">
                <?php echo $this->Html->image('logo-3.jpeg', ['width' => 320, 'atl' => 'Ticketing', 'class' => 'front-logo img-responsive center-block client-logo']); ?>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 cols-xs-12">
            <?php echo $this->fetch('content'); ?>
        </div>
    </div>

    <?php echo $this->Html->script('/vendor/jquery/jquery.min'); ?>
	<?php echo $this->Html->script('/vendor/bootstrap/js/bootstrap.min'); ?>
	<?php echo $this->Html->script('/vendor/parsley/js/parsley.min'); ?>
	<?php echo $this->fetch('script'); ?>
</body>
</html>