<?php 
	include('conn.php');
	require_once "log.php";
	session_start();
	//$_SESSION['login_blocked'] = true;
	
	if(isset($_POST['username'])){
		$username=$_POST['username'];
		$password=md5($_POST['password']);

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

		if(count($error)==0){
			$query=$conn->query("select * from user where username='$username' and password='$password'");

			if ($query->num_rows>0){
				$row=$query->fetch_array();
				$_SESSION['user']=$row['userid'];
				$_SESSION['rol']=$row['roles'];
				
				$accion = "Inicio exitoso";
				if($_SESSION['rol']=='user'){
					logs($username, true, $accion);
					header ("Location: user.php");
					exit;
				}elseif($_SESSION['rol']=='admin'){
					logs($username, true, $accion);
					header('location: home.php');
					exit;
				}
			}else{
				$accion = 'Inicio de sesion fallido';
				logs($username, false, $accion);
				header('Location: logout.php');
				exit;
			}
		}else{
			header("Location: index.php");
			exit;
		}
	}
?>