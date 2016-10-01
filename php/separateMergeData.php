<?php
	include 'GeneralUtil.php';
	//print_r($_FILES);
    $type = filter_input(INPUT_GET, "type");
	$dateRange = json_decode(filter_input(INPUT_GET, "dateRange"));
	$separate = filter_input(INPUT_GET, "separate");
	$formData = filter_input(INPUT_GET, "formData");
	$curTime = time();
	$queries = array();
	$tables = array("js_process", "js_less", "js_color");
	if($separate)
	{
		for($i=0; $i<3;$i++)
		{
			array_push($queries, getQueryForUpdate(DS_BACKUP, $dateRange[1], array($tables[$i].'-'.$curTime, $tables[$i], $dateRange[0]), true));
		}
		//array_push($queries, getQueryForUpdate(DS_JS_OUTFILE, null, array($curTime, implode(" AND ", $dateRange)), true));
		array_push($queries, DS_JS_OUTFILE.implode(" AND ", $dateRange).';');
		array_push($queries, "Now select all and click on export. Save the file name with name-".$curTime);
		array_push($queries, DS_JS_DELETE.implode(" AND ", $dateRange).';');
		//$result = executeTransaction($queries);
		$dateRange[0] = $dateRange[0]/1000;
		$dateRange[1] = $dateRange[1]/1000;
	}
	else
	{
		//$csvFile = $_FILES['file']['tmp_name'];
		//$fileData = readCSV($csvFile, 1);
		$savedTimestamp = "Enter code";//$fileData[0][0];
		// if($savedTimestamp)
		// {
			//array_push($queries, getQueryForUpdate(DM_FETCH, null, array($csvFile)));
			array_push($queries, "Open job_sheet table and import file. Note down the code at the end of the name.");
			for($i=0; $i<3; $i++)
			{
				array_push($queries, getQueryForUpdate(DM_GET_BACKUP, null, array($tables[$i], $tables[$i].'-'.$savedTimestamp), true));
				array_push($queries, DM_DROP_TABLE.'`'.$tables[$i].'-'.$savedTimestamp.'`;');
			}
			//$result = executeTransaction($queries);
		//}
		// else {
			// $result = false;
		// }
	}
	//print_r($queries);
	
	$response = array("type"=>$type);
	$response["dateRange"] = $dateRange;
	$response["separate"] = true;//$separate;
	foreach($queries as $k => $v) 
	{
	    $out .= ($k+1)."- $v<br>";
	}
	$out = substr($out, 0, -1);
	$response["data"] = $out;
	// if(!$result)
    // {
    	// $response["error"] = $error ? $error : getQueryError();
        // $response["data"] = ($separate) ? SEPARATEERROR : MERGEERROR;
    // }
    // else
    // {
        // $response["data"] = ($separate) ? SEPARATESUCCESS : MERGESUCCESS;
    // }
	echo json_encode($response);
?>