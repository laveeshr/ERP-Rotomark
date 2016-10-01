<?php
    include("GeneralUtil.php");
    $type = filter_input(INPUT_GET, "type");
    $refreshType = filter_input(INPUT_GET, "refreshType");
    $details = json_decode(filter_input(INPUT_GET, "details"));
    $id = filter_input(INPUT_GET, "id");
	$setUrgent = filter_input(INPUT_GET, "setUrgent");
	$urgentVal = filter_input(INPUT_GET, "urgentVal");
	$opData = json_decode(filter_input(INPUT_GET, "opData"));
	$reProcess = json_decode(filter_input(INPUT_GET, "reProcessData"), true);
	$password = filter_input(INPUT_GET, "upass");
	$permissions = json_decode(filter_input(INPUT_GET, 'permissions'));
	$response = array("type"=>$type);
    $details = escapeQuery($details);
	
	
    switch($type)
    {
        case PROCESS_MASTER : $query = ($id) ? getQueryForUpdate(PROCESS_MASTER_UPDATEQUERY, $id, $details, false, true) : 
                getQueryForInsertDel(PROCESS_MASTER_ADDQUERY, $details);
        break;
        case COLOR_MASTER : $query = ($id) ? getQueryForUpdate(COLOR_MASTER_UPDATEQUERY, $id, $details, false, true) : 
                getQueryForInsertDel(COLOR_MASTER_ADDQUERY, $details);
        break;
        case MATERIAL_MASTER : $query = ($id) ? getQueryForUpdate(MATERIAL_MASTER_UPDATEQUERY, $id, $details, false, true) : 
                getQueryForInsertDel(MATERIAL_MASTER_ADDQUERY, $details);
        break;
        case LESS_MASTER : $query = ($id) ? getQueryForUpdate(LESS_MASTER_UPDATEQUERY, $id, $details, false, true) : 
                getQueryForInsertDel(LESS_MASTER_ADDQUERY, $details);
        break;
        case OP_MASTER : $query = ($id) ? getQueryForUpdate(OP_MASTER_UPDATEQUERY, $id, $details, false, true) : 
                getQueryForInsertDel(OP_MASTER_ADDQUERY, $details);
        break;
        case SPARE_CYLINDER : 
					$updateSpare = filter_input(INPUT_GET, "updateSpare");
        					if($updateSpare)
							{
								$deleteSpareCyIds = array();
								for($i=0; $i<sizeof($details); $i++)
								{
									$spareCyData = $details[$i];
									$scId = $spareCyData[0];
									$spareCyPieces = $spareCyData[1];
									if($spareCyPieces == 0)
									{
										array_push($deleteSpareCyIds, $scId);
									}
									else 
									{
										$query = getQueryForInsertDel(SC_MASTER_UPDATE_PIECES, array($scId, $id, $spareCyPieces));
										if($i != sizeof($details)-1)
										{
											$result = executeQuery($query, false, false, true);
											checkError($result, $response, $refreshType, $id, $setUrgent);
										}
									}
								}
								if(sizeof($deleteSpareCyIds) > 0)
								{
									$spareDelQuery = getQueryForInsertDel(SC_MASTER_DELETEQUERY, $deleteSpareCyIds, false);
									if(!$query)
									{
										$query = $spareDelQuery;
									}
									else
									{
										$result = executeQuery($spareDelQuery, false);
										checkError($result, $response, $refreshType, $id, $setUrgent);	
									}
								}
							}
							else
							{
								$query = $id ? getQueryForUpdate(SC_MASTER_UPDATEQUERY, $id, $details, false, true) : getQueryForInsertDel(SC_MASTER_ADDQUERY, $details);
							}
        break;
        case TOM_MASTER:  $query = ($id) ? getQueryForUpdate(TOM_MASTER_UPDATEQUERY, $id, $details, false, true) : 
                getQueryForInsertDel(TOM_MASTER_ADDQUERY, $details);
        break;
        case PARTY_MASTER :
                $pm_data = json_decode(filter_input(INPUT_GET, "pmProcessRows"));
                $pm_delete_rows = json_decode(filter_input(INPUT_GET, "pmDeleteRows"));
                $query = ($id) ? getQueryForUpdate(PARTY_MASTER_UPDATEQUERY, $id, $details) : 
                getQueryForInsertDel(PARTY_MASTER_ADDQUERY, $details);
		break;
		case BASE_SHELL :
			if($setUrgent)
			{
				$query = getQueryForUrgent($details, BS_URGENT, $urgentVal);
			}
		break;
		case ROUGH_TURNING :
			if($setUrgent)
			{
				$query = getQueryForUrgent($details, DEPT_URGENT, $urgentVal);
			} 
			else
			{
				for($i=0; $i<sizeof($details)-1; $i++)
				{
					$query = getQueryForInsertDel(RT_ADD_QUERY, array($details[$i][0], $details[$i][1]));
					$result = executeQuery($query, false, false, true);
					checkError($result, $response, $refreshType, $id, $setUrgent);
				}
				$query = getQueryForInsertDel(RT_ADD_QUERY, array($details[sizeof($details)-1][0], $details[sizeof($details)-1][1]));
			}
		break;
		
		case SHEET_CUTTING : 
			$keys = array("SC_RING_SIZE", "SC_SHEET_BREADTH", "SC_SHEET_LENGTH", "SC_THICKNESS");
			$query = getQueryForConstantTableUpdate($keys, $details, $type);
		break;
		
		// case COPPER_TANK : $shaftId = array_shift($details);
			// $queryVals = getQueryForInsertDel("", $details);
			// $query = getQueryForUpdate(COPPER_TANK_UPDATE, $id, array($shaftId, rtrim($queryVals, ";")), true, true); 
			// break;
		
		case COMPLETED : 
			for($i=0; $i<sizeof($details); $i++)
			{
				$transactionQueries = array();
				array_push($transactionQueries, getQueryForUpdate(array(COMPLETED_QUERY[0]), null, $details[$i]));
				array_push($transactionQueries, getQueryForUpdate(array(COMPLETED_QUERY[1]), null, $details[$i]));
				$result = executeTransaction($transactionQueries);
				$query = null;
			}
		break;
		
		case NONPENDING_LOCAL : 
		case NONPENDING_OUTSTATION :
		case NONPENDING_ALL :
			$query = getQueryForUpdate(NP_UPDATE_CHALLAN_DATE, $id, $details);
			$response["ignoreSuccess"] = true;
		break;
		
		case FINAL_GRINDING :
		case COPPER_PLATING :
		case COPPER_CUT :
		case COPPER_POLISH :
		case ENGRAVING :
		case CHROME_PLATING :
		case CHROME_POLISH :
		case COPPER_TANK :
		case PROOFING :
		case DISPATCH :
			if($setUrgent)
			{
				$query = getQueryForUrgent($details, DEPT_URGENT, $urgentVal);
			}
			else if($id)
			{
				switch($type)
				{
					case COPPER_PLATING:
						$keys = array("CP_AMP", "CP_AMP_CD");
						$query = getQueryForConstantTableUpdate($keys, $details, $type);
						break;
					case CHROME_PLATING:
						$query = getQueryForConstantTableUpdate(array("CHROME_PLATE_AMP"), $details, $type);
						break;
					case COPPER_TANK:
						$shaftId = array_shift($details);
						$queryVals = getQueryForInsertDel("", $details);
						$query = getQueryForUpdate(COPPER_TANK_UPDATE, $id, array($shaftId, rtrim($queryVals, ";")), true, true); 
						break;
				}
			}
			else
			{
				for($i=0; $i<sizeof($details); $i++)
				{
					$transactionQueries = array();
					$deptId = $details[$i][0];
					$reProcessedType = null;
					if($reProcess && $reProcess[$deptId])
					{
						$reProcessedType = $reProcess[$deptId][1];
						if(array_pop($reProcess[$deptId]))
						{
							$query = getQueryForUpdate(RE_PROCESS_ADD, $deptId, $reProcess[$deptId]);
							array_push($transactionQueries, $query);
						}
					}
					if($opData)
					{
						$query = getQueryForUpdate(OP_COUNT_ADD, $deptId, $opData[$i]);
						array_push($transactionQueries, $query);
					}
					array_push($transactionQueries,getDeptUpdateQuery($type, $details[$i], $reProcessedType));
					$result = executeTransaction($transactionQueries);
					$query = null;
				}
			}
		break;
		
		case ADMIN :
					$transactionQueries = array(); 
					if($password)
					{
						$password = hash("sha256", $password);
						array_push($details,$password);
					}
					$query = $id ? (getQueryForUpdate($password ? ADMIN_UPDATE_PASS : ADMIN_UPDATE_USER, $id, $details, false, true)) : getQueryForInsertDel(ADMIN_ADD_USER, $details);
					if(!$id)
					{
						$result = executeQuery($query);
						//echo $query;
						checkError($result, $response, $refreshType, $id, $setUrgent);
					}
					else
					{
						array_push($transactionQueries, $query);
					}
					
					if($permissions)
					{
						$id = $id ? $id : getLastInsertId();
						if(sizeof($permissions[1])>0)	//Deleted Permissions
						{
							$query = "";
							$query = rtrim(getQueryForInsertDel($query, $permissions[1]),";");
							array_push($transactionQueries, getQueryForUpdate(ADMIN_PERM_DELETE, $id, array($query), true));
							
						}
						if(sizeof($permissions[0])>0)	//Added Permissions
						{
							$query = ADMIN_PERM_ADD;
							for($i=0; $i<sizeof($permissions[0]); $i++)
							{
								$query .= getQueryForInsertDel("", array($id, $permissions[0][$i]), true);
							}
							array_push($transactionQueries, rtrim($query, ",").";");
						}
					}
			$query = null;
			//print_r($transactionQueries);
			$result = executeTransaction($transactionQueries); 
		break;
		
		case ISP :  $query = ($id) ? getQueryForUpdate(ISP_UPDATE_QUERY, $id, $details, false, true) : 
                getQueryForInsertDel(ISP_ADD_QUERY, $details);
        break;
	}
    
    //echo $query;
    if($query)
    {
    	$result = executeQuery($query, false);
	}
    if($pm_data && $result)
    {
        $last_insert_id = $id ? $id : getLastInsertId();
        $queryVals = "";
        $insertPMRow = false;
        for($i=0; $i<sizeof($pm_data); $i++)
        {
            array_unshift($pm_data[$i], $last_insert_id);
            if($id && $pm_data[$i][5])   //New IDs and Old Ids are different	 && $pm_data[$i][2] != $pm_data[$i][5]
            {
                $query = getQueryForUpdate(PARTY_MASTER_PMUPDATE, $id, $pm_data[$i]);
                $resultPm = executeQuery($query, false, false);
                if(!$resultPm)
                {
                   $result = false;
                   break;
                }
            }
            else if(!$pm_data[$i][5])
            {
                $insertPMRow = true;
                $continue_query = ($i==sizeof($pm_data)-1) ? false : true;
                array_pop($pm_data[$i]);
                $queryVals = getQueryForInsertDel($queryVals, $pm_data[$i], $continue_query);
            }
        }
        
        if($insertPMRow)
        {
            $query = PARTY_MASTER_PMADD . $queryVals;
            $resultPm = executeQuery($query, false, false);
        }
        //echo $query;
        
        if($pm_delete_rows)
        {
            for($i=0; $i<sizeof($pm_delete_rows); $i++)
            {
                $query = getQueryForUpdate(PARTY_MASTER_PMDELETE, $id, $pm_delete_rows[$i]);
                //echo $query;
                $resultPm = executeQuery($query, false, false);
                if(!$resultPm)
                {
                   $result = false;
                   break;
                }
            }
        }
        
        if(!$resultPm  && !$id)
        {
            //echo getQueryError();
            $query = getQueryForInsertDel(PARTY_MASTER_DELETEQUERY, array($last_insert_id));
            executeQuery($query, false);
            $result = false;
        }
    }

	$response = responseHandle($result, $response, $refreshType, $id, $setUrgent);
    echo json_encode($response);
?>