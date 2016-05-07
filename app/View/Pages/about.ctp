<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $title_for_layout; ?> - <?php echo Configure::read('Application.name') ?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">

	<?php echo $this->Html->css(array('bootstrap', 'font-awesome/css/font-awesome.min', 'sb-admin', 'style')); ?>
	<?php echo $this->CakeStrap->automaticCss(); ?>
	<?php echo $this->Html->script('lib/modernizr') ?>
</head>
<body class="<?php echo $this->params->params['controller'].'_'.$this->params->params['action']?>">
<!--[if lt IE 7]>

<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser
	today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better
	experience this site.</p>
<![endif]-->


<div id="wrapper">

	\

	<div id="page-wrapper">

		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>

	</div>
	<div>
		<h4>About Query Builder</h4>
		<br>Query Builder is an analytical Tools developed for the organization Beyond Teaching.  The application was developed as studnet project by student of ATMC.
			The application expected to be completed on the month of june.
			Kinds Rgards
			Development Team. 
	</div>
	<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->




</body>
</html>
