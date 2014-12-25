<?php

// Constants 
$destDir = '/mnt/raid/scanner';

// Detecting scanner
global $scannerFound;
if (preg_match('/No scanners were identified/', shell_exec('scanimage -L')))
	$scannerFound = 0;
else
	$scannerFound = 1;

// Scanning
$convertCmd = 'convert';
if (isset($_GET['depth'])) {
	$destFile = 'scan_' . date('d_m_y_H_i_s');
	system("scanimage --resolution=300 > /tmp/$destFile.ppm");
	switch ($_GET['depth']) {
		case 'color':
			system("$convertCmd -quality 60 /tmp/$destFile.ppm $destDir/$destFile.jpg");
			chmod("$destDir/$destFile.jpg", 0666);
			break;
		case 'gray':
			system("$convertCmd /tmp/$destFile.ppm -colorspace gray $destDir/$destFile.jpg");
			chmod("$destDir/$destFile.jpg", 0666);
			break;
		case 'black':
			system("$convertCmd /tmp/$destFile.ppm -monochrome $destDir/$destFile.jpg");
			chmod("$destDir/$destFile.jpg", 0666);
			break;
	}
	unlink("/tmp/$destFile.ppm");
}

// Getting all the files inside the dest scanner folder
global $previousScans;
$previousScans = array();
if ($handle = opendir($destDir)) {
	while (false != ($entry = readdir($handle))) {
		if ($entry != '.' && $entry != '..' && preg_match('/jpg/', $entry)) {
			array_push($previousScans, $entry);
		}
	}
	closedir($handle);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Scanner</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<!--
	<script src="js/jquery-1.10.1.min.js"></script>
	-->
	<link rel="icon" type="image/png" href="scanner.png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<div class="container">
	<div class="page-header text-center">
		<h1>SCANNER</h1>
	</div>
	<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading text-center">
				<?php
				if($scannerFound) 
					print ('<span class="label label-success">STATUS <span class="glyphicon glyphicon-thumbs-up"></span></span>');
				else
					print ('<span class="label label-danger">STATUS <span class="glyphicon glyphicon-thumbs-down"></span></span>');
				?>
			</div>
  		<div class="panel-body">
				<form role="form" action="index.php" method="get">
					<div class="form-group">
	
						<div class="radio">
							<label>
								<?php 
								if ((isset($_GET['depth']) && $_GET['depth'] == 'color') || (!isset($_GET['color'])))
									print('<input type="radio" name="depth" id="scan-in-color" value="color" checked>');
								else
									print('<input type="radio" name="depth" id="scan-in-color" value="color">');
								?>
								Color
							</label> 
						</div>

						<div class="radio">
							<label>
								<?php 
								if ((isset($_GET['depth']) && $_GET['depth'] == 'gray'))
									print('<input type="radio" name="depth" id="scan-in-gray" value="gray" checked>');
								else
									print('<input type="radio" name="depth" id="scan-in-gray" value="gray">');
								?>
								Grayscale	
							</label> 
						</div>
	
						<div class="radio">
							<label>
								<?php 
								if ((isset($_GET['depth']) && $_GET['depth'] == 'black'))
									print('<input type="radio" name="depth" id="scan-in-black" value="black" checked>');
								else
									print('<input type="radio" name="depth" id="scan-in-black" value="black">');
								?>
								Black &amp; White
							</label> 
						</div>

					</div>
					<div class="container">
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-2">
								<button type="submit" class="btn btn-primary text-center" data-loading-text="SCANNING..."><strong>SCAN</strong> <span class="glyphicon glyphicon-import"></span></button>
							</div>
							<div class="col-md-6"></div>
						</div> <!-- row -->
					</div> <!-- container -->
				</form>
			</div> <!-- panel-body -->
		</div> <!-- panel -->
	</div> <!-- col-md-4 -->
	<div class="col-md-4"></div>
	</div> <!-- row -->
	</div> <!-- container -->
	
	<!-- Displaying previous scans -->
	<?php
	if(count($previousScans) > 0) {
	?>
	<div class="container">
		<div class="text-center">
			<h2>PREVIOUSLY SCANNED...</h2>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<?php
				foreach ($previousScans as $file) {
					echo '<div class="scan-image pull-left">';
   	 			echo "<a href=\"getscan.php?scan=$file\"><img src=\"getscan.php?scan=$file\" height=\"320\" width=\"240\"></a>";
					echo '</div>';
				}
				?>
			</div>
		</div>
	</div>
	<?php
	}
	?>

</body>
</html>	
