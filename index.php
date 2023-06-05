<?php
	require_once "log.php";
	session_start();
	
	$block='';
	require_once "log.php";
	$ipv4 = $_SERVER['REMOTE_ADDR'];
	$i = contador($ipv4, 1);
	if($i >= 3){
		$block = 'disabled';
	}
	if(isset($_SESSION['user'])){
		if($_SESSION['rol']=='admin'){
			header ("Location: home.php");
			exit;
		}else{
			header('location: user.php');
			exit;
		}
	}

?>
<?php include('header.php'); ?>
<body>
<div class="container" style="background-image: url('ruta_de_la_imagen.jpg'); background-size: cover; background-position: center;">
	<div style="height:100px;">
	</div> 
<div class="container">
	<div style="height:100px;">
	</div> 
    <div class="row" id="loginform">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-lock"></span> Inicio de sesión
                    	<span class="pull-right"><span class="glyphicon glyphicon-pencil"></span> <a style="text-decoration:none; cursor:pointer; color:white;" id="singnup" href="sing.php">Sign up</a></span>
                    </h3>
                </div>
            	<div class="panel-body">
                	<form role="form" id="logform" method="post" action="login.php">
                    	<fieldset>
                        	<div class="form-group">
                            	<input class="form-control" placeholder="Username" name="username" id="username" type="email" autofocus>
                        	</div>
                        	<div class="form-group">
                            	<input class="form-control" placeholder="Password" name="password" id="password" type="password">
                        	</div>
							<div class= "form-group">
								<div class="g-recaptcha" data-sitekey="6LfZ_9IlAAAAAC4QIgUNs_jhUuFGBZQqyYOrilMZ">
>
								
								</div>
							  
							
                        	<button id="loginbutton" class="btn btn-lg btn-primary btn-block" <?php echo $block ?>>
								<span class="glyphicon glyphicon-log-in"></span> <span id="logtext">Login</span></button>
                    	</fieldset>
                	</form>
					 <?php
						if(isset($error)){
							?>
							<div class="alert alert-danger" role="alert">
								<?php foreach($error as $e){
									echo $e.'<br>';
									}?>
							</div>
						<?php
						}
					 ?>
            	</div>
            </div>
        </div>
    </div>

    <div id="myalert" style="display:none;">
    	<div class="col-md-4 col-md-offset-4">
    		<div class="">
    			<center><span id="alerttext"></span></center>
    		</div>
   	 	</div>
    </div>
</div>

</body>
</html>