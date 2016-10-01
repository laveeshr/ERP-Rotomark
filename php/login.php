<?php
	include "GeneralUtil.php";
	$details = json_decode(filter_input(INPUT_POST, "details"));
	$ipCheck = filter_input(INPUT_POST, "ip");
	$setPerm = filter_input(INPUT_POST, "setPerm");
	$response = array();
	session_start();
	
	if($setPerm)
	{
		if(!isset($_SESSION["user"]) && !isset($_COOKIE["user"]))
		{
			$response["user"] = NOROWS;
		}
		else if(!isset($_SESSION["user"]) && isset($_COOKIE["user"]))
		{
			$response["user"] = $_COOKIE["user"];
			$response["admin"] = TRUE;
		}
		else 
		{
			$response["user"] = $_SESSION["user"];
			$response["admin"] = $_SESSION["admin"];
			$response["perms"] = $_SESSION["PERMISSIONS"];
		}
	}
	else if($ipCheck && !isset($_SESSION["user"]) && !isset($_COOKIE["user"]))
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
		{
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		} 
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
		{
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} 
		else 
		{
		    $ip = $_SERVER['REMOTE_ADDR'];
		}
		$result = executeQuery(getQueryForInsertDel(IP_CHECK, array($ip)), true);
		if(($result && sizeof($result) > 0))
		{
			$response["data"] = IPSUCCESS;
		}
		else 
		{
			$response["data"] = IPERROR;
		}
	}
	else if($ipCheck && (isset($_SESSION["user"]) || isset($_COOKIE["user"])))
	{
		$response["data"] = LOGINSUCCESS;
	}
	else
	{
		$pass = hash("sha256", $details[1]);
		$query = getQueryForUpdate(LOGIN_QUERY, $pass, array($details[0]));
		//echo $query;
		$result = executeQuery($query, true);
		if($result && sizeof($result) > 0)
		{
			$perms = array();
			for($i=0; $i<sizeof($result); $i++)
			{
				if($result[$i]["STATE"])
				{
					array_push($perms, $result[$i]["STATE"]);
				}
			}
			$_SESSION["user"] = $result[0]["ID"];
			$_SESSION["admin"] = $result[0]["ADMIN"];
			if($result[0]["ADMIN"])
			{
				$_COOKIE["user"] = $result[0]["ID"];
			}
			$_SESSION["PERMISSIONS"] = $perms;
			$response["data"] = LOGINSUCCESS;
		}
		else
		{
			$response["error"] = getQueryError();
			$response["data"] = LOGINERROR;
		}
	}
	echo json_encode($response);
?>