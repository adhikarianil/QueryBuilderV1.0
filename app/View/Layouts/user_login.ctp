	<!--@Anil Adhikari codes for login-->
	<html>
     <head>
        <title> Beyond Teaching: Query Builder</title>
       <?php echo $this->Html->css('bootstrap'); ?>
        <link rel="stylesheet" type="text/css" href="webroot/css/bootstrap.css">
        
        
</head>
     </head>   
    <body>
        
   <!-- creating the header of the file-->
   <div class="container-fluid">
   <div class="jumbotron">
        <div id="logo"> <img  id="logo"  alt= "Beyond Teaching " src="/cake_querybuilder/app/webroot/img/logo.png" height="100px" width="90px"></div>
    </div>
   <div class="navbar navbar-default">
                <ul class="nav navbar-nav">
                    
                     <li><a href="#">Home</a></li>
                     <li><a href="#">Support</a></li> 
                     <li><a href="#">About</a></li>

                </ul>               
             </div>
  
    <div id="container">
    <div style="position: relative; margin-top:5px; margin: 20 auto; padding: 12px 12px 12px; width: 500px; background: white; border-radius: 4px; -webkit-box-shadow: 0 0 200px rgba(255, 255, 255, 0.5), 0 1px 2px rgba(0, 0, 0, 0.3);
box-shadow: 0 0 200px rgba(255, 255, 255, 0.5), 0 1px 2px rgba(0, 0, 0, 0.3);">
		<?php echo $this->Form->create('User',array(
												'url' => array(
													'controller' => 'users',
													'action' => 'login'
												)));?>
		<div>
			<h2> User Login <?php //echo Configure::read('Application.name') ?></h2>
		</div>

		<hr>
		  <?php echo $this->Form->input('email', array('label' => __('Email')));?>
		  <?php echo $this->Form->input('password', array('label' => __('Password')));?>
		  <div class="form-group">
		  	<?php echo $this->Html->link(__('Forgot your password?'),array('controller' => 'users','action' => 'remember_password')) ?>
		  </div>
		  <div class="checkbox">
		    <label>
		      <input type="checkbox" name="data[User][remember_me]" value="S"> <?php echo __('Remember me')?>
		    </label>
		  </div>
		  <button type="submit" class="btn btn-default"><?php echo __('Login')?></button>
		</form>


	</div>
   
        <div class="footer">
      <div class="container">
        <p class="text-muted credit">Query Builder Version 1 <a href="http://martinbean.co.uk">Team Binary Websoft</a>.</p>
      </div>
    </div>
    </div>
    </body>
	</html>