<?php
	include('conn.php');
	if(isset($_POST['susername'])){
		$username=$_POST['susername'];
		$password=$_POST['spassword'];
		$rool=$_POST['select'];

		$ip = $_SERVER['REMOTE_ADDR'];
		$captcha = $_POST['g-recaptcha-response']; 
		$secretkey = "6LfZ_9IlAAAAAHn5zA_n1SA4nWnIaVVYWAvbo56z";
        $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");
		$atributos = json_decode($respuesta, TRUE);

        $error = array();
		if(empty($username)){ 
         $error[]= "El campo de correo es obligatorio";
		}
		if (!filter_var($username, FILTER_VALIDATE_EMAIL)){
			$error[]= "este no es un correo";
  				
		}
		if(empty($password)){ 
			$error[]= "contraseña obligatoria";
		   }

		if(!$atributos['success']){
			$error[]= "validar captcha";

		}


		$query=$conn->query("select * from user where username='$username'");

		if ($query->num_rows>0){
			$error[]= "este usuario ya existe";

		}
		else{
			if(count($error)==0){
				$mpassword=md5($password);
			    $conn->query("insert into user (username, password, roles) values ('$username', '$mpassword', '$rool')");
				$success='Registro exitoso';
			}
			else{
				$error[]='Error de registro';
			}
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
<div class="row" id="signupform">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-pencil"></span> Sign Up
						<span class="pull-right"><span class="glyphicon glyphicon-log-in"></span>
						<a style="text-decoration:none; cursor:pointer; color:white;" id="login" href="index.php">login</a> </span>
                    </h3>
                </div>
            	<div class="panel-body">
                	<form role="form" id="signform" method="post" action="#">
                    	<fieldset>
                        	<div class="form-group">
                            	<input class="form-control" placeholder="Username" name="susername" id="susername" type="email" autofocus>
                        	</div>
                        	<div class="form-group">
                            	<input class="form-control" placeholder="Password" name="spassword" id="spassword" type="password">
                        	</div>
							<div class= "form-group">
							<select id = "select" name="select" class="form-select" aria-label="Default select example">
							<option selected >Seleccione el rool</option>
							<option value="admin">Administrador</option>
							<option value="user">Usuario</option>
							
							</select>
                            </div>
							<div class= "form-group">
								<div class="g-recaptcha" data-sitekey="6LfZ_9IlAAAAAC4QIgUNs_jhUuFGBZQqyYOrilMZ"></div>
							</div>
							<div>
								
							</div>
                        	<button id="signupbutton" class="btn btn-lg btn-primary btn-block"><span class="glyphicon glyphicon-check"></span> <span id="signtext">Sign Up</span></button>
                    	</fieldset>
                	</form>
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