<?php
/*
if(array_key_exists('tunnel', $_GET)) {
	$FSCRIPT = './ssh_tunnel.php';
}
else {
	$FSCRIPT = './failover.php';
}
*/
$FSCRIPT = './failover.php';
exec("sudo $FSCRIPT");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>NAS Services</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<div class="container">
		<div class="row text-center">
		<?		
		if ($FSCRIPT == './ssh_tunnel.php')
			echo '<h1>Connected to mobile access point</h1>';
		else
			echo '<h1>Connected to WiFi access point</h1>';
		?>
		<a href="/">Return to NAS</a>
		</div>
	</div>
</body>
</html>
