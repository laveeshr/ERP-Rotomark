<?php
	include 'GeneralUtil.php';
    $type = filter_input(INPUT_GET, "type");
    $id = filter_input(INPUT_GET, "id");
    //$autocomp = filter_input(INPUT_GET, "ac");
    //$asscArr = $autocomp ? true : false;
    
    $query = JS_FETCHQUERY."{$id};";
	$resp["jsData"] = executeQuery($query, true, false);
	$query = getQueryForUpdate(JS_PROCESS_FETCH, null, array($id), false, FALSE);
	//echo $query;
	$resp["jsProcess"] = executeQuery($query, true, false);
	$query = getQueryForUpdate(JS_LESS_FETCH, null, array($id), false, false);
	$resp["jsLess"] = executeQuery($query, true, false);
	$query = JS_COLOR_FETCH."{$id};";
	$resp["jsColor"] = executeQuery($query, true, false);
	
	$data = array("type" => $type);
    
    if(sizeof($resp) > 0)
    {
        $data["data"] = $resp;
    }
    else
    {
        $data["data"] = NOROWS;
    }
    
    if($id)
    {
        $data["id"] = $id;
    }
    
    echo json_encode($data);
?>