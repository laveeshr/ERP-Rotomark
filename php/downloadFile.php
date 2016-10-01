<?php
	$dateRange = json_decode(filter_input(INPUT_GET, "dateRange"));
	$name = "//Applications/MAMP/db/mysql/rotomark/jobs.csv";
	$fileName = "jobs-".gmdate("d:m:Y",$dateRange[0]).'-'.gmdate("d:m:Y",$dateRange[1]).".csv";
	//echo $fileName;
	if (file_exists($name))
	{
		header('Content-Description: File Transfer');
	    header('Content-Type: application/force-download');
	    header("Content-Disposition: attachment; filename=\"" . basename($fileName) . "\";");
	    header('Content-Transfer-Encoding: binary');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($name));
	    ob_clean();
	    flush();
	    readfile($name);
	    unlink($name);
	}
?>