<?php
    include 'GeneralUtil.php';
    $type = filter_input(INPUT_GET, "type");
    $id = filter_input(INPUT_GET, "id");
    $autocomp = filter_input(INPUT_GET, "ac");
	$dateRange = json_decode(filter_input(INPUT_GET, "dateRange"));
	$challan = json_decode(filter_input(INPUT_GET, "challan"));
    $asscArr = $autocomp ? true : false;
    $includeWhere = true;
	$data = array("type" => $type);
	
	if($challan)
	{
		$query = rtrim(getQueryForUpdate(CHALLAN_PRINT, null, array($id, $id)), ";");
		$includeWhere = false;
		$data["challan"] = $challan;
	}
	else 
	{
		switch($type)
	    {
	        case PROCESS_MASTER: $query = $autocomp ? PROCESS_MASTER_ACQUERY : PROCESS_MASTER_QUERY;
	        break;
	        case COLOR_MASTER : $query = $autocomp ? COLOR_MASTER_ACQUERY : COLOR_MASTER_QUERY;
	        break;
	        case MATERIAL_MASTER : $query = $autocomp ? MATERIAL_MASTER_ACQUERY : MATERIAL_MASTER_QUERY;
	        break;
	        case LESS_MASTER : $query = $autocomp ? LESS_MASTER_ACQUERY : LESS_MASTER_QUERY;
	        break;
	        case OP_MASTER : $query = $autocomp ? OP_MASTER_ACQUERY : OP_MASTER_QUERY;
	        break;
	        case SPARE_CYLINDER : $query =  SC_MASTER_QUERY;
	        break;
	        case TOM_MASTER : $query = $autocomp ? TOM_MASTER_ACQUERY : TOM_MASTER_QUERY;
	        break;
	        case PARTY_MASTER : $query = $autocomp ? PARTY_MASTER_ACQUERY : PARTY_MASTER_QUERY;
	        break;
			case JOB_SHEET : $query = $id ? (rtrim(getQueryForUpdate(JS_TRACK, null, array($id)), ";")) : (($dateRange ? rtrim(getQueryForUpdate(JS_QUERY_DATE, null, $dateRange), ";") : JS_QUERY)) ;
				$includeWhere = false;
			break;
			case NONPENDING_LOCAL : $query = ($dateRange ? rtrim(getQueryForUpdate(NP_LOCAL_DATE, null, $dateRange), ";") : NONPENDING_LOCAL_QUERY);
				$includeWhere = false;
			break;
			case NONPENDING_ALL : $query = ($dateRange ? rtrim(getQueryForUpdate(NP_ALL_DATE, null, $dateRange), ";") : NP_ALL_QUERY);
				$includeWhere = false;
			break;
			case NONPENDING_OUTSTATION : $query = ($dateRange ? rtrim(getQueryForUpdate(NP_OUT_DATE, null, $dateRange), ";") : NONPENDING_OUT_QUERY);
				$includeWhere = false;
			break;
			case PENDING_LOCAL : $query = $id ? (rtrim(getQueryForUpdate(JS_TRACK, null, array($id)), ";")) : ($dateRange ? rtrim(getQueryForUpdate(P_LOCAL_DATE, null, $dateRange), ";") : PENDING_LOCAL_QUERY);
				$includeWhere = false;
			break;
			case PENDING_OUTSTATION : $query = $id ? (rtrim(getQueryForUpdate(JS_TRACK, null, array($id)), ";")) : ($dateRange ? rtrim(getQueryForUpdate(P_OUT_DATE, null, $dateRange), ";") : PENDING_OUT_QUERY);
				$includeWhere = false;
			break;
			case PENDING_ALL : $query = $id ? (rtrim(getQueryForUpdate(JS_TRACK, null, array($id)), ";")) : ($dateRange ? rtrim(getQueryForUpdate(P_ALL_DATE, null, $dateRange), ";") : PENDING_ALL_QUERY);
				$includeWhere = false;
			break;
			case BASE_SHELL : $query = $id ? BS_SPARECY : $dateRange ? rtrim(getQueryForUpdate(BS_DATE, null, $dateRange), ";") :  BS_QUERY;
				$includeWhere = false;
			break;
			case ROUGH_TURNING : $query = RT_QUERY;
			break;
			case FINAL_GRINDING : $query = FG_QUERY;
			break;
			case COPPER_PLATING : $query = $id ? COPPER_PLATING_DEFAULTS : CP_QUERY;
				if($id)
				{
					$fakeId = $id;
					$id = null;
				}
			break;
			case COPPER_TANK : 
				$data["shaftId"] = filter_input(INPUT_GET, "shaftId");
				$query = $id ? rtrim(getQueryForUpdate(COPPER_TANK_FETCH, null, array($data["shaftId"])), ";") : COPPER_TANK_QUERY;
				$includeWhere = false;
				break;
			case COPPER_CUT : $query  =CC_QUERY;
			break;
			case COPPER_POLISH : $query = COPPER_POLISH_QUERY;
			break;
			case ENGRAVING : $query = EG_QUERY;
			break;
			case CHROME_PLATING : $query = $id ? CHROME_PLATING_DEFAULTS : CHROME_PLATING_QUERY;
				if($id)
					{
						$fakeId = $id;
						$id = null;
					}
			break;
			case CHROME_POLISH : $query = CHROME_POLISH_QUERY;
			break;
			case PROOFING : $query = PROOF_QUERY;
			break;
			case DISPATCH : $query = DISPATCH_QUERY;
			break;
			case SHEET_CUTTING : $query = $id ? SHEET_CUTTING_DEFAULTS : $dateRange ? rtrim(getQueryForUpdate(SHEET_CUTTING_DATE, null, $dateRange), ";") : SHEET_CUTTING_QUERY;
				if($id)
				{
					$fakeId = $id;
					$id = null;
				}
			break;
			case TIKAL_SIZE : $query = $dateRange ? rtrim(getQueryForUpdate(TIKAL_SIZE_DATE, null, $dateRange), ";") : TIKAL_SIZE_QUERY;
			break;
			
			case ADMIN : $query = ADMIN_FETCH;
			break;
			
			case ISP : $query = ISP_FETCH;
			break;
	    }
	}
    
    $query = includeWhereInQuery($query, $id, $includeWhere);
    //echo $query;
    $jsonResp = executeQuery($query, true, $asscArr);
    
    if($type == PARTY_MASTER && $id)
    {
        $pmid = $jsonResp[0]["ID"];
        $pm_query = getQueryForUpdate(PARTY_MASTER_PM, $pmid, array($pmid));
		$jsonResp["PM_DATA"] = executeQuery($pm_query, true, false);
    }
	else if($type == ADMIN && $id)
	{
		$jsonResp["PERMISSIONS"] = executeQuery(includeWhereInQuery(ADMIN_FETCH_PERM, $id, false), true);
	}
    
    if(sizeof($jsonResp) > 0)
    {
        $data["data"] = $jsonResp;
    }
    else
    {
        $data["data"] = NOROWS;
    }
    
	$id = !$id && $fakeId ? $fakeId : $id;
	
    if($id)
    {
        $data["id"] = $id;
    }
    
    echo json_encode($data);
?>