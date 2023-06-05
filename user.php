<?php include('session.php');
    if(isset($_SESSION['user'])){
	if($_SESSION['rol']!= 'user'){
            header ("Location: index.php");
	    exit;
	}
    }else{
        header ("Location: index.php");
	exit;
    }
 ?>
<?php include('header.php'); ?>
<body>
<div class="container">
	<div style="height:50px;">
	</div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
        <h2>Bienvenido!! <?php echo $_SESSION['rol'] .'<br>'. $user; ?>!</h2>
           <a href="logout.php" class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
        </div>
    </div>
</div>
</body>
</html>