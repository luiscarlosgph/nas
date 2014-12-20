<?php
	$destDir = '/mnt/raid/scanner';
	$fileName = urldecode($_GET['scan']);
	if (preg_match('/[a-zA-Z0-9]+[.]jpg/', $fileName, $matches)) {
		$filePath = "$destDir/$fileName";
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: image/jpg');
		header("Content-Disposition: attachment; filename=\"" . basename($fileName) . "\";");
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($filePath));
		readfile($filePath);
	}
?>
