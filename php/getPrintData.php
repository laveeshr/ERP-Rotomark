<?php
	include 'GeneralUtil.php';
    $type = filter_input(INPUT_GET, "type");
	$subType = filter_input(INPUT_GET, "subType");
    $dateRange = json_decode(filter_input(INPUT_GET, "dateRange"));
	$data = array("type" => $type, "subType" => $subType);
	
	if($dateRange)
	{
		$data["dateRange"] = $dateRange;
		if($subType == PRINT_CHALLANWISE || $subType == PRINT_PARTYWISE)
		{
			array_push($dateRange, $dateRange[0]);
			array_push($dateRange, $dateRange[1]);
		}
	}
	
	switch ($type) 
	{
		case JOB_SHEET:
			if($subType == PRINT_PARTYWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(JOBSHEET_PRINT_DATE, null, $dateRange), ";") : JOBSHEET_PRINT;
			}
			else if($subType == PRINT_DATEWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(JOBSHEET_PRINT_DATEWISE_DATE, null, $dateRange), ";") : JOBSHEET_PRINT_DATEWISE;
			}
			else if($subType == PRINT_CHALLANWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(JOBSHEET_PRINT_CHALLAN, null, $dateRange), ";") : JOBSHEET_PRINT;
			}
			break;
		
		case NONPENDING_LOCAL:
			if($subType == PRINT_PARTYWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(NP_LOCAL_PRINT_DATE, null, $dateRange), ";") : NP_LOCAL_PRINT;
			}
			else if($subType == PRINT_DATEWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(NP_LOCAL_PRINT_DATEWISE_DATE, null, $dateRange), ";") : NP_LOCAL_PRINT_DATEWISE;
			}
			else if($subType == PRINT_CHALLANWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(NP_LOCAL_PRINT_CHALLAN, null, $dateRange), ";") : NP_LOCAL_PRINT;
			}
			break;
			
		case NONPENDING_ALL:
			if($subType == PRINT_PARTYWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(NP_ALL_PRINT_DATE, null, $dateRange), ";") : NP_ALL_PRINT;
			}
			else if($subType == PRINT_DATEWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(NP_ALL_PRINT_DATEWISE_DATE, null, $dateRange), ";") : NP_ALL_PRINT_DATEWISE;
			}
			else if($subType == PRINT_CHALLANWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(NP_ALL_PRINT_CHALLAN, null, $dateRange), ";") : NP_ALL_PRINT;
			}
			break;
		
		case NONPENDING_OUTSTATION:
			if($subType == PRINT_PARTYWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(NP_OUT_PRINT_DATE, null, $dateRange), ";") : NP_OUT_PRINT;
			}
			else if($subType == PRINT_DATEWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(NP_OUT_PRINT_DATEWISE_DATE, null, $dateRange), ";") : NP_OUT_PRINT_DATEWISE;
			}
			else if($subType == PRINT_CHALLANWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(NP_OUT_PRINT_CHALLAN, null, $dateRange), ";") : NP_OUT_PRINT;
			}
			break;	
		
		case PENDING_LOCAL:
			if($subType == PRINT_PARTYWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(P_LOCAL_PRINT_DATE, null, $dateRange), ";") : P_LOCAL_PRINT;
			}
			else if($subType == PRINT_DATEWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(P_LOCAL_PRINT_DATEWISE_DATE, null, $dateRange), ";") : P_LOCAL_PRINT_DATEWISE;
			}
			else if($subType == PRINT_CHALLANWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(P_LOCAL_PRINT_CHALLAN, null, $dateRange), ";") : P_LOCAL_PRINT;
			}
			break;
			
		case PENDING_OUTSTATION:
			if($subType == PRINT_PARTYWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(P_OUT_PRINT_DATE, null, $dateRange), ";") : P_OUT_PRINT;
			}
			else if($subType == PRINT_DATEWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(P_OUT_PRINT_DATEWISE_DATE, null, $dateRange), ";") : P_OUT_PRINT_DATEWISE;
			}
			else if($subType == PRINT_CHALLANWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(P_OUT_PRINT_CHALLAN, null, $dateRange), ";") : P_OUT_PRINT;
			}
			break;
			
		case PENDING_ALL:
			if($subType == PRINT_PARTYWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(P_ALL_PRINT_DATE, null, $dateRange), ";") : P_ALL_PRINT;
			}
			else if($subType == PRINT_DATEWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(P_ALL_PRINT_DATEWISE_DATE, null, $dateRange), ";") : P_ALL_PRINT_DATEWISE;
			}
			else if($subType == PRINT_CHALLANWISE)
			{
				$query = $dateRange ? rtrim(getQueryForUpdate(P_ALL_PRINT_CHALLAN, null, $dateRange), ";") : P_ALL_PRINT;
			}
			break;
		case SHEET_CUTTING :
			$query = $dateRange ? rtrim(getQueryForUpdate(SHEET_CUTTING_DATE_PRINT, null, $dateRange), ";") : SHEET_CUTTING_PRINT;
			break;
		case TIKAL_SIZE :
			$query = $dateRange ? rtrim(getQueryForUpdate(TIKAL_SIZE_DATE_PRINT, null, $dateRange), ";") : TIKAL_SIZE_PRINT;
			break;
		default:
			break;
	}
	
	$query .= ";";
	//echo $query;
	$result = executeQuery($query, true); 
	checkError($result, $data);
	if(sizeof($result) > 0)
    {
        $data["data"] = $result;
    }
    else
    {
        $data["data"] = NOROWS;
    }
	
	echo json_encode($data);
?>