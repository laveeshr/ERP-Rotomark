<?php
    include("GeneralUtil.php");
    $type = filter_input(INPUT_GET, "type");
    $details = json_decode(filter_input(INPUT_GET, "details"));
    $response = array("type"=>$type);
    $details = escapeQuery($details);
    switch($type)
    {
        case PROCESS_MASTER : $query = getQueryForInsertDel(PROCESS_MASTER_DELETEQUERY, $details);
        break;
        case COLOR_MASTER : $query = getQueryForInsertDel(COLOR_MASTER_DELETEQUERY, $details);
        break;
        case MATERIAL_MASTER : $query = getQueryForInsertDel(MATERIAL_MASTER_DELETEQUERY, $details);
        break;
        case LESS_MASTER : $query = getQueryForInsertDel(LESS_MASTER_DELETEQUERY, $details);
        break;
        case OP_MASTER : $query = getQueryForInsertDel(OP_MASTER_DELETEQUERY, $details);
        break;
        case SPARE_CYLINDER : $query = getQueryForInsertDel(SC_MASTER_DELETEQUERY, $details);
        break;
        case TOM_MASTER : $query = getQueryForInsertDel(TOM_MASTER_DELETEQUERY, $details);
        break;
        case PARTY_MASTER : $query = getQueryForInsertDel(PARTY_MASTER_DELETEQUERY, $details);
        break;
		case JOB_SHEET : $query = getQueryForInsertDel(JS_DELETEQUERY, $details);
		break; 
		case ADMIN : $query = getQueryForInsertDel(ADMIN_DELETE_USER, $details);
		break;
		case ISP : $query = getQueryForInsertDel(ISP_DELETE_QUERY, $details);
		break;
    }
    
    //echo $query;
    $result = executeQuery($query, false);
    if(!$result)
    {
        $response["data"] = DELETEROWERROR;
    }
    else
    {
        $response["data"] = DELETEROWSUCCESS;
    }
    echo json_encode($response);
?>