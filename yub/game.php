




<?php 


if(isset( $_GET["username" ] )   && isset($_GET["email"] ) )  
	

	{
		
		$username = $_GET["username" ];
		$email = $_GET["email"];
	}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>  frostly || <?php  echo  $email ?></title>
	<link rel="stylesheet"  href="./game.css" />
    <script src="https://badasstechie.github.io/frosty/lib/sweetalert.min.js"></script>
    <script src="https://badasstechie.github.io/frosty/lib/86/three.min.js"></script>
</head>
<body>

  <?php  echo $username; ?>



<script src="./game.js"></script>



<script>

<?php   echo localStorage.getItem("score");  ?>

</script>

</body>
</html>