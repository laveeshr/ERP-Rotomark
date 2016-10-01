<?php
    include("GeneralUtil.php");
    $type = filter_input(INPUT_GET, "type");
    $details = json_decode(filter_input(INPUT_GET, "details"));
	$jsProcesses = json_decode(filter_input(INPUT_GET, "jsProcesses"));
	$jsColors = json_decode(filter_input(INPUT_GET, "jsColors"));
	$jsLess = json_decode(filter_input(INPUT_GET, "jsLess"));
	$jsDeleteProcesses = json_decode(filter_input(INPUT_GET, "jsDeleteProcesses"));
	$jsDeleteColors = json_decode(filter_input(INPUT_GET, "jsDeleteColors"));
	$jsDeleteLess = json_decode(filter_input(INPUT_GET, "jsDeleteLess"));
    $id = filter_input(INPUT_GET, "id");
    $response = array("type"=>$type);
    $details = escapeQuery($details);
	
    $query = ($id) ? getQueryForUpdate(JS_UPDATEQUERY, $id, $details, false, true) : getQueryForInsertDel(JS_ADDQUERY, $details);
    //echo $query;
    $result = $details ? executeQuery($query, false) : true;
    
	$last_insert_id = $id ? $id : getLastInsertId();
	if($result && ($jsProcesses || $jsColors || $jsLess || $jsDeleteProcesses || $jsDeleteColors || $jsDeleteLess))
	{
		$allData = array($jsProcesses, $jsColors, $jsLess);
		$allDataQuery = array(JS_PROCESS_ADD, JS_COLOR_ADD, JS_LESS_ADD);
		$allDataUpdateQuery = array(JS_PROCESS_UPDATE, JS_COLOR_UPDATE, JS_LESS_UPDATE);
		$allDeleteData = array($jsDeleteProcesses, $jsDeleteColors, $jsDeleteLess);
		$allDeleteDataQueries = array(JS_PROCESS_DELETE, JS_COLOR_DELETE, JS_LESS_DELETE);
		for($j=0; $j<3; $j++)
		{
			$curData = $allData[$j];
			if((!$curData || sizeof($curData) <= 0) && !$allDeleteData[$j])
			{
				continue;
			}
			$queryVals = "";
			
			$insertJSProc = false;
			for($i=0; $i<sizeof($curData); $i++)
	        {
	            array_unshift($curData[$i], $last_insert_id);
				//print_r($curData[$i]);
				$loadid = $id ? end($curData[$i]) : null; 
				//echo $loadid;
				if(!$loadid)
				{
					array_pop($curData[$i]);
					$insertJSProc = true;
					$continue_query = ($i==sizeof($curData)-1) ? false : true;
					$curData[$i] = escapeQuery($curData[$i]);
		            $queryVals = getQueryForInsertDel($queryVals, $curData[$i], $continue_query);
				}
				else if($id && $loadid)	//update data
				{
					$query = getQueryForUpdate($allDataUpdateQuery[$j], $id, $curData[$i]);
					//echo $query;
	                $resultPm = executeQuery($query, false, false);
	                if(!$resultPm)
	                {
	                   break;
	                }
				}
				
	        }
	        
			if($insertJSProc)
			{
				$query = $allDataQuery[$j] . $queryVals;
				//echo $query;
	        	$resultPm = executeQuery($query, false, false);
			}
			
			if($allDeleteData[$j])
			{
				$allDeleteData[$j] = implode(",", $allDeleteData[$j]);
				$deleteVals = "({$allDeleteData[$j]})";
				$query = getQueryForUpdate($allDeleteDataQueries[$j], $id, array($deleteVals), true);
				//echo $query;
				$resultPm = executeQuery($query, false, false);
			}
			
			if(!$resultPm)
	        {
	        	if(!$id)
				{
					$error = getQueryError();
		            $query = getQueryForInsertDel(JS_DELETEQUERY, array($last_insert_id));
		            executeQuery($query, false);
		            $result = false;
				}
	        	break;
	        }
		}  
	}
	
    if(!$result)
    {
    	$response["error"] = $error ? $error : getQueryError();
        $response["data"] = ($id) ? UPDATEROWERROR : ADDROWERROR;
    }
    else
    {
        $response["data"] = ($id) ? UPDATEROWSUCCESS : ADDROWSUCCESS;
    }
	$response["lastid"] = $last_insert_id;
    echo json_encode($response);
?>