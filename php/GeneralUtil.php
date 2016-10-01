<?php

include_once("dbConnect.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GeneralUtil
 *
 * @author laveesh
 */
function executeQuery($query, $getData, $asscArr, $clearDb) 
{
    global $con;
    $result = $con->query($query);
	if($clearDb && $result)
	{
		//$result->close();
		$con->next_result();
	}
    if(!$getData)
    {
        return $result;
    }
    $jsonResp = array();
    $result_type = $asscArr ? MYSQLI_ASSOC : MYSQLI_BOTH;
    while($row = mysqli_fetch_array($result, $result_type))
    {
        array_push($jsonResp, $row);
    }
    return $jsonResp;
}

function escapeQuery($details)
{
    global $con;
    foreach($details as $val)
    {
        if($val instanceof ArrayObject)
        {
            $val = escapeQuery($val);
        }
        else
        {
            $val = mysqli_real_escape_string($con, $val);
        }
    }
    return $details;
}

function getQueryForUpdate($queryArr, $id, $data, $noQuotes, $allowedEmptyVals)
{
	$queryArr = is_array($queryArr) ? $queryArr : unserialize($queryArr);
    $query = "";
    if($id)
    {
    	$data[sizeof($queryArr)-1] = $id;
	}
    for($i=0; $i<sizeof($queryArr); $i++)
    {
        $query .= (!$data[$i] && !$allowedEmptyVals) ? $queryArr[$i] : $queryArr[$i].($noQuotes ? "$data[$i]" : "'$data[$i]'");
    }
    $query .= ";";
    return $query;
}

function getQueryForInsertDel($query, $details, $continueQuery)
{
    $details = implode("','" , $details);
    $query .= "('$details')";
    $query .= !$continueQuery ? ";" : ",";
    return $query;
}

function getQueryForUrgent($details, $query, $urgentVal)
{
	$queryVals = getQueryForInsertDel("", $details, true);
	$queryVals = trim($queryVals, ",");
	return getQueryForUpdate($query, $queryVals, array($urgentVal), true, true);
}

function includeWhereInQuery($query, $id, $includeWhere)
{
	$query .= (($id) ? ($includeWhere ? (" WHERE ID=".$id) : $id) : "").";";
	return $query;
}

function getLastInsertId()
{
    global $con;
    return mysqli_insert_id($con);
}

function responseHandle($result, $response, $refreshType, $id, $setUrgent)
{
	if($refreshType)
	{
		$response["refreshType"] = $refreshType;
	}
	if(!$result)
    {
    	$response["error"] = getQueryError();
        $response["data"] = $setUrgent ? URGENTERROR : (($id) ? UPDATEROWERROR : ADDROWERROR);
    }
    else
    {
        $response["data"] = $setUrgent ? URGENTSUCCESS : (($id) ? UPDATEROWSUCCESS : ADDROWSUCCESS);
    }
	return $response;
}

function getQueryError()
{
    global $con;
    return mysqli_error($con);
}

function checkError($result, $response, $refreshType, $id, $setUrgent)
{
	if(!$result)
	{
		$response = responseHandle($result, $response, $refreshType, $id, $setUrgent);
		echo json_encode($response);
		exit();
	}
}

function getDeptUpdateQuery($type, $data, $reProcessType)
{
	$deptId = array_shift($data);
	$reProcessType = !$reProcessType ? $type : $reProcessType;
	array_push($data, $reProcessType);
	switch($type)
	{
		case FINAL_GRINDING :
		case COPPER_POLISH :
		case CHROME_POLISH :
		case PROOFING :
		case DISPATCH :
		case COPPER_PLATING : $query = getQueryForUpdate(DEPT_UPDATE, $deptId, $data);
		break;
		case COPPER_CUT : $query = getQueryForUpdate(CC_UPDATE, $deptId, $data);
		break;
		case ENGRAVING : $query = getQueryForUpdate(EG_UPDATE, $deptId, $data);
		break;
		case CHROME_PLATING : $query = getQueryForUpdate(CP_UPDATE, $deptId, $data);
		break;
		case COMPLETED : $query = getQueryForUpdate(COMPLETED_UPDATE, $deptId, $data);
		break;
	}
	return $query;
}

function executeTransaction($queries)
{
	global $con;
	if(sizeof($queries) <= 0)
	{
		return true;
	}
	$con->begin_transaction();
	$con->autocommit(false);	//transaction start
	for($i=0; $i<sizeof($queries); $i++)
	{
		$result = $con->query($queries[$i]);
		if(!$result)
		{
			//echo $queries[$i]."   ".$con->error;
			$con->rollback();
			return $result;
		}
	}
	$con->commit();	//tranaction stop
	return $result;
}

function getQueryForConstantTableUpdate($keys, $details, $type)
{
	$queryVals = "";
	$query = CONSTANT_UPDATE;
	for($i=0; $i<sizeof($keys); $i++)
	{
		$queryVals .= getQueryForInsertDel("", array($keys[$i], $details[$i]), true);
	}
	$queryVals = trim($queryVals, ",");
	return getQueryForUpdate($query, $id, array($queryVals), true, true);
}

function readCSV($csvFile, $limit)
{
	$file_handle = fopen($csvFile, 'r');
	$row = 0;
	while (!feof($file_handle)  && $row < $limit) {
		$line_of_text[] = fgetcsv($file_handle, 1024);
		$row++;
	}
	fclose($file_handle);
	return $line_of_text;
}

function checkPermValid($admin, $perms, $type)
{
	$returnVal = "";
	if($admin)
	{
		$returnVal = "";
	}
	else if($type && is_array($type))
	{
		$parentSet = false;
		for($i=0; $i<sizeof($perms); $i++)
		{
			if(in_array($perms[$i], $type))
			{
				$parentSet = true;
				break;
			}
		}
		if(!$parentSet)
		{
			$returnVal = "'display: none;'";
		}
	}
	else if($type && !is_array($type) && in_array($type, $perms))
	{
		$returnVal = "";
	}
	else
	{
		$returnVal = "'display: none;'";
	}
	return $returnVal;
}
