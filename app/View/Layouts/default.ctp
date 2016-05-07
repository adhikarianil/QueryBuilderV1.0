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
<!-- added code for the class jumbotorn-->
<div class="jumbotron">
       <div id="logo"><?php echo $this->Html->link(
			Configure::read('Application.name'),
			AuthComponent::user('id') ? "/home" : "/"
			, array('class' => 'navbar-brand')) ?>
			
   </div>
</div>

<![endif]-->


<div id="wrapper">

	<?php echo $this->element('nav')?>
	<div class="navbar navbar-default">
                <ul class="nav navbar-nav">
                
                     <li><a href="">Home</a></li>
					  <li><?= $this->Html->link('About', array('controller'=>'Pages','action'=>'about')) ?> </li>
					 <li><a href="#">Tools</a></li>
                     <li><?= $this->Html->link('Support', array('controller'=>'Pages','action'=>'support')) ?> </li> 
                     <li><a href="">Help</a></li>
					 
					
					 

                </ul>               
             </div>

	<div id="page-wrapper">

		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>

	</div>
	<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo $this->params->webroot ?>js/lib/jquery.min.js"><\/script>')</script>
<?php echo $this->Html->script(array('lib/bootstrap.min', 'src/scripts.js')); ?>
<?php echo $this->CakeStrap->automaticScript(); ?>

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
	var _gaq = [
		['_setAccount', 'UA-XXXXX-X'],
		['_trackPageview']
	];
	(function (d, t) {
		var g = d.createElement(t), s = d.getElementsByTagName(t)[0];
		g.src = ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g, s)
	}(document, 'script'));
</script>

</body>
</html>
