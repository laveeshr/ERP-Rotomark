<?php

    //Process Masster
    define("PROCESS_MASTER", 1);
    define("PROCESS_MASTER_QUERY", "SELECT * FROM process_master");
    define("PROCESS_MASTER_ACQUERY", "SELECT `NAME` AS 'label', `NAME` AS 'value', `ID` AS 'id' FROM `process_master`");
    define("PROCESS_MASTER_ADDQUERY", "INSERT INTO `process_master`(`NAME`, `PROCESS_TYPE`, `REMARKS`) VALUES");
    define("PROCESS_MASTER_DELETEQUERY", "DELETE FROM `process_master` WHERE `ID` IN");
    define("PROCESS_MASTER_UPDATEQUERY", serialize(array("UPDATE `process_master` SET `NAME`=",",`PROCESS_TYPE`=",",`REMARKS`="," WHERE `ID`=")));
    
    //Color Master
    define("COLOR_MASTER", 2);
    define("COLOR_MASTER_ACQUERY", "SELECT `NAME` AS 'label', `NAME` AS 'value', `ID` AS 'id' FROM `color_master`");
    define("COLOR_MASTER_QUERY", "SELECT * FROM color_master");
    define("COLOR_MASTER_ADDQUERY", "INSERT INTO `color_master`(`NAME`, `COLOR_TYPE`, `REMARKS`) VALUES");
    define("COLOR_MASTER_DELETEQUERY", "DELETE FROM `color_master` WHERE `ID` IN");
    define("COLOR_MASTER_UPDATEQUERY", serialize(array("UPDATE `color_master` SET `NAME`=",",`COLOR_TYPE`=",",`REMARKS`="," WHERE `ID`=")));
    
    //Material Master
    define("MATERIAL_MASTER", 3);
    define("MATERIAL_MASTER_ACQUERY", "SELECT `NAME` AS 'label', `NAME` AS 'value', `ID` AS 'id' FROM `material_master`");
    define("MATERIAL_MASTER_QUERY", "SELECT * FROM material_master");
    define("MATERIAL_MASTER_ADDQUERY", "INSERT INTO `material_master`(`NAME`, `MATERIAL_TYPE`, `REMARKS`) VALUES");
    define("MATERIAL_MASTER_DELETEQUERY", "DELETE FROM `material_master` WHERE `ID` IN");
    define("MATERIAL_MASTER_UPDATEQUERY", serialize(array("UPDATE `material_master` SET `NAME`=",",`MATERIAL_TYPE`=",",`REMARKS`="," WHERE `ID`=")));
    
    //Less Master
    define("LESS_MASTER", 4);
    define("LESS_MASTER_QUERY", "SELECT * FROM less_master");
    define("LESS_MASTER_ACQUERY", "SELECT `LESS_TYPE` AS 'label', `LESS_TYPE` AS 'value' ,`ID` AS 'id' FROM `less_master`");
    define("LESS_MASTER_ADDQUERY", "INSERT INTO `less_master`(`LESS_TYPE`, `REMARKS`) VALUES");
    define("LESS_MASTER_DELETEQUERY", "DELETE FROM `less_master` WHERE `ID` IN");
    define("LESS_MASTER_UPDATEQUERY", serialize(array("UPDATE `less_master` SET `LESS_TYPE`=",",`REMARKS`="," WHERE `ID`=")));
    
    //Operator Master
    define("OP_MASTER", 5);
    define("OP_MASTER_QUERY", "SELECT * FROM operator_master");
    define("OP_MASTER_ACQUERY", "SELECT `NAME` AS 'label', `NAME` AS 'value', `ID` AS 'id' FROM `operator_master`");
    define("OP_MASTER_ADDQUERY", "INSERT INTO `operator_master`(`NAME`) VALUES");
    define("OP_MASTER_DELETEQUERY", "DELETE FROM `operator_master` WHERE `ID` IN");
    define("OP_MASTER_UPDATEQUERY", serialize(array("UPDATE `operator_master` SET `NAME`="," WHERE `ID`=")));
    
    //Spare Cylinders
    define("SPARE_CYLINDER", 6);
    define("SC_MASTER_QUERY", "SELECT * FROM spare_cylinders");
    define("SC_MASTER_ADDQUERY", "INSERT INTO `spare_cylinders`(`LENGTH`, `CIRCUM`, `PIECES`, `PLACE`, `REMARKS`) VALUES");
    define("SC_MASTER_DELETEQUERY", "DELETE FROM `spare_cylinders` WHERE `ID` IN");
    define("SC_MASTER_UPDATEQUERY", serialize(array("UPDATE `spare_cylinders` SET `LENGTH`=",",`CIRCUM`=",",`PIECES`=",",`PLACE`=",",`REMARKS`="," WHERE `ID`=")));
	define("SC_MASTER_UPDATE_PIECES", "CALL updateSpareCylinder");
    
    //Type of Material Master
    define("TOM_MASTER", 7);
    define("TOM_MASTER_QUERY", "SELECT * FROM tom_master");
    define("TOM_MASTER_ACQUERY", "SELECT `NAME` AS 'label', `NAME` AS 'value', `ID` AS 'id' FROM `tom_master`");
    define("TOM_MASTER_ADDQUERY", "INSERT INTO `tom_master`(`NAME`, `REMARKS`) VALUES");
    define("TOM_MASTER_DELETEQUERY", "DELETE FROM `tom_master` WHERE `ID` IN");
    define("TOM_MASTER_UPDATEQUERY", serialize(array("UPDATE `tom_master` SET `NAME`=",",`REMARKS`="," WHERE `ID`=")));
    
    //Party Master
    define("PARTY_MASTER", 8);
    define("PARTY_MASTER_QUERY", "SELECT * FROM `party_master`");
    define("PARTY_MASTER_PM", serialize(array("SELECT pm.PL_TYPE, proc.NAME AS NAME, pm.RATE, pm.RATE_TYPE,pm.PLID FROM `pm_pl` pm INNER JOIN `process_master` proc on pm.PLID = proc.ID WHERE pm.PL_TYPE=1 AND pm.PMID="," UNION SELECT pm.PL_TYPE, less.LESS_TYPE AS NAME, pm.RATE, pm.RATE_TYPE,pm.PLID FROM `pm_pl` pm INNER JOIN `less_master` less on pm.PLID = less.ID WHERE pm.PL_TYPE=4 AND pm.PMID=")));
    define("PARTY_MASTER_ACQUERY", "SELECT `NAME` AS 'label', `NAME` AS 'value', `ID` AS 'id' FROM `party_master`");
    define("PARTY_MASTER_ADDQUERY", "INSERT INTO `party_master`(`NAME`, `OUTSTATION`, `BORE`) VALUES");
    define("PARTY_MASTER_PMADD","INSERT INTO `pm_pl`(`PMID`, `PL_TYPE`, `PLID`, `RATE`, `RATE_TYPE`) VALUES");
    define("PARTY_MASTER_DELETEQUERY", "DELETE FROM `party_master` WHERE `ID` IN");
    define("PARTY_MASTER_UPDATEQUERY", serialize(array("UPDATE `party_master` SET `NAME`=",",`OUTSTATION`=",",`BORE`="," WHERE `ID`=")));
    define("PARTY_MASTER_PMUPDATE", serialize(array("UPDATE `pm_pl` SET `PMID`=",",`PL_TYPE`=",",`PLID`=",",`RATE`=",",`RATE_TYPE`="," WHERE `PLID`="," AND `PMID`=")));
    define("PARTY_MASTER_PMDELETE",serialize(array("DELETE FROM `pm_pl` WHERE `PLID`="," AND `PL_TYPE`= "," AND `PMID`=")));
    
    //Job Sheet
    define("JOB_SHEET", 9);
    define("JS_QUERY", "SELECT js.ID, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, SUM(jsp.QUANTITY), pm.BORE FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID GROUP BY jsp.JS_ID ORDER BY js.ID");
    define("JS_QUERY_DATE", serialize(array('SELECT js.ID, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, SUM(jsp.QUANTITY), pm.BORE FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE DATE BETWEEN ',' AND ', ' GROUP BY jsp.JS_ID ORDER BY js.ID')));
    define("JS_FETCHQUERY", "SELECT js.`ID`, js.`DATE`, js.DELIVERY, PM.NAME, js.`NAME`, MAT.NAME, TOM.NAME, js.`PRINT_WID`, js.`PRINT_NUM`, js.`PRINT_TOTAL`, js.`PRINT_PREC`, js.`CY_WIDTH`, js.`CY_CIRCUM`, js.`CY_NUM`, js.`CY_TOTAL`, js.REMARKS, js.`CLEARED`, js.`STATE`, js.PARTY_ID as PARTY_ID, js.MATERIAL_ID as MAT_ID, js.TOM_ID as TOM_ID, PM.BORE as BORE FROM `job_sheet` js, party_master PM, material_master MAT, tom_master TOM WHERE PM.ID = js.PARTY_ID and MAT.ID = js.MATERIAL_ID and TOM.ID = js.TOM_ID and js.ID=");
    define("JS_ADDQUERY", "INSERT INTO `job_sheet`(`DATE`, `DELIVERY`, `PARTY_ID`, `NAME`, `MATERIAL_ID`, `TOM_ID`, `PRINT_WID`, `PRINT_NUM`, `PRINT_TOTAL`, `PRINT_PREC`, `CY_WIDTH`, `CY_CIRCUM`, `CY_NUM`, `CY_TOTAL`, `REMARKS`, `CLEARED`, `STATE`) VALUES");
    define("JS_DELETEQUERY", "DELETE FROM `job_sheet` WHERE `ID` IN");
    define("JS_UPDATEQUERY", serialize(array("UPDATE `job_sheet` SET `DATE`=",",`DELIVERY`=",",`PARTY_ID`=",",`NAME`=",",`MATERIAL_ID`=",",`TOM_ID`=",",`PRINT_WID`=",",`PRINT_NUM`=",",`PRINT_TOTAL`=",",`PRINT_PREC`=",",`CY_WIDTH`=",",`CY_CIRCUM`=",",`CY_NUM`=",",`CY_TOTAL`=",",`REMARKS`=",",`CLEARED`=",",`STATE`="," WHERE `ID`=")));
    define("JS_PROCESS_ADD", "INSERT INTO `js_process`(`JS_ID`, `PID`, `QUANTITY`) VALUES");
    define("JS_PROCESS_FETCH", serialize(array("SELECT jsp.PID, proc.NAME, SUM(jsp.QUANTITY) FROM js_process jsp INNER JOIN process_master proc ON jsp.PID=proc.ID WHERE jsp.JS_ID=", " GROUP BY jsp.PID")));
    define("JS_PROCESS_UPDATE", serialize(array("UPDATE `js_process` SET `JS_ID`=",",`PID`=",",`QUANTITY`="," WHERE `PID`=","AND `JS_ID`=")));
    define("JS_PROCESS_DELETE", serialize(array("DELETE FROM `js_process` WHERE `PID` IN "," AND `JS_ID`=")));
    define("JS_COLOR_ADD", "INSERT INTO `js_color`(`JS_ID`, `CID`) VALUES");
	define("JS_COLOR_FETCH", "SELECT jsc.CID, color.NAME from js_color jsc INNER JOIN color_master color on jsc.CID = color.ID WHERE jsc.JS_ID=");
	define("JS_COLOR_UPDATE", serialize(array("UPDATE `js_color` SET `JS_ID`=",",`CID`="," WHERE `CID`=","AND `JS_ID`=")));
    define("JS_COLOR_DELETE", serialize(array("DELETE FROM `js_color` WHERE `CID` IN "," AND `JS_ID`=")));
    define("JS_LESS_ADD", "INSERT INTO `js_less`(`JS_ID`, `LID`, `QUANTITY`) VALUES");
    define("JS_LESS_FETCH", serialize(array("SELECT jsl.LID, less.less_type, SUM(jsl.QUANTITY) FROM js_less jsl INNER JOIN less_master less ON jsl.LID=less.ID WHERE jsl.JS_ID="," GROUP BY jsl.LID")));
    define("JS_LESS_UPDATE", serialize(array("UPDATE `js_less` SET `JS_ID`=",",`LID`=",",`QUANTITY`="," WHERE `LID`=","AND `JS_ID`=")));
    define("JS_LESS_DELETE", serialize(array("DELETE FROM `js_less` WHERE `LID` IN "," AND `JS_ID`=")));
	define("JS_TRACK", serialize(array("SELECT STATE, COUNT(*) FROM `department_list` WHERE JSID="," GROUP BY STATE UNION SELECT 10, QUANTITY FROM base_shell WHERE JSID=")));
	
	define("NONPENDING_LOCAL", 91);
	define("NONPENDING_LOCAL_QUERY", "SELECT js.ID, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, SUM(jsp.QUANTITY), pm.BORE FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='No' GROUP BY jsp.JS_ID ORDER BY js.ID");
    define("NP_LOCAL_DATE", serialize(array("SELECT js.ID, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, SUM(jsp.QUANTITY), pm.BORE FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='No' AND js.DATE BETWEEN "," AND "," GROUP BY jsp.JS_ID ORDER BY js.ID")));
    define("NONPENDING_OUTSTATION", 92);
    define("NONPENDING_OUT_QUERY", "SELECT js.ID, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, SUM(jsp.QUANTITY), pm.BORE FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='Yes' GROUP BY jsp.JS_ID ORDER BY js.ID");
    define("NP_OUT_DATE", serialize(array("SELECT js.ID, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, SUM(jsp.QUANTITY), pm.BORE FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='Yes' AND js.DATE BETWEEN "," AND "," GROUP BY jsp.JS_ID ORDER BY js.ID")));
    define("NONPENDING_ALL", 95);
    define("NP_ALL_QUERY", "SELECT js.ID, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, SUM(jsp.QUANTITY), pm.BORE FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 GROUP BY jsp.JS_ID ORDER BY js.ID");
    define("NP_ALL_DATE", serialize(array("SELECT js.ID, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, SUM(jsp.QUANTITY), pm.BORE FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND js.DATE BETWEEN "," AND "," GROUP BY jsp.JS_ID ORDER BY js.ID")));
    define("NP_UPDATE_CHALLAN_DATE", serialize(array("UPDATE `job_sheet` SET `CHALLAN_DATE`="," WHERE `ID`=")));
    define("PENDING_LOCAL", 93);
    define("PENDING_LOCAL_QUERY", "SELECT js.ID, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, SUM(jsp.QUANTITY), pm.BORE FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='No' GROUP BY jsp.JS_ID ORDER BY js.ID");
    define("P_LOCAL_DATE", serialize(array("SELECT js.ID, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, SUM(jsp.QUANTITY), pm.BORE FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='No' AND js.DATE BETWEEN "," AND "," GROUP BY jsp.JS_ID ORDER BY js.ID")));
    define("PENDING_OUTSTATION", 94);
    define("PENDING_OUT_QUERY", "SELECT js.ID, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, SUM(jsp.QUANTITY), pm.BORE FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='Yes' GROUP BY jsp.JS_ID ORDER BY js.ID");
    define("P_OUT_DATE", serialize(array("SELECT js.ID, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, SUM(jsp.QUANTITY), pm.BORE FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='Yes' AND js.DATE BETWEEN "," AND "," GROUP BY jsp.JS_ID ORDER BY js.ID")));
    define("PENDING_ALL", 96);
	define("PENDING_ALL_QUERY", "SELECT js.ID, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, SUM(jsp.QUANTITY), pm.BORE FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 GROUP BY jsp.JS_ID ORDER BY js.ID");
    define("P_ALL_DATE", serialize(array("SELECT js.ID, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, SUM(jsp.QUANTITY), pm.BORE FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND js.DATE BETWEEN "," AND "," GROUP BY jsp.JS_ID ORDER BY js.ID")));
	
	//Base Shell
	define("BASE_SHELL", 10);
	define("BS_QUERY", "SELECT bs.ID, bs.`JSID`, js.DATE, party.NAME, js.CY_WIDTH, js.CY_TOTAL, bs.`QUANTITY`, ROUND((js.CY_TOTAL * 7/22), 2) AS FINAL, party.BORE, checkSpareCylinder(js.ID) AS SPARE_COUNT, bs.URGENT FROM `base_shell` bs INNER JOIN job_sheet js ON bs.JSID = js.ID INNER JOIN party_master party ON js.PARTY_ID = party.ID ORDER BY bs.URGENT DESC, bs.ID ASC");
    define("BS_DATE", serialize(array("SELECT bs.ID, bs.`JSID`, js.DATE, party.NAME, js.CY_WIDTH, js.CY_TOTAL, bs.`QUANTITY`, ROUND((js.CY_TOTAL * 7/22), 2) AS FINAL, party.BORE, checkSpareCylinder(js.ID) AS SPARE_COUNT, bs.URGENT FROM `base_shell` bs INNER JOIN job_sheet js ON bs.JSID = js.ID INNER JOIN party_master party ON js.PARTY_ID = party.ID WHERE DATE BETWEEN "," AND "," ORDER BY bs.URGENT DESC, bs.ID ASC")));
    define("BS_SPARECY", "SELECT sc.* FROM spare_cylinders sc JOIN job_sheet js ON sc.CIRCUM BETWEEN js.CY_TOTAL AND js.CY_TOTAL+10 WHERE js.ID=");
    define("BS_URGENT", serialize(array("UPDATE `base_shell` bs SET bs.`URGENT`=", " WHERE bs.ID IN")));
    
    //Rough Turning
    define("ROUGH_TURNING", 11);
    define("RT_QUERY", "SELECT dl.`ID`, dl.`JSID`, js.DATE, pm.NAME, js.CY_WIDTH, js.CY_TOTAL, ROUND((js.CY_TOTAL * 7/22), 2) AS FINAL, dl.URGENT FROM `department_list` dl INNER JOIN job_sheet js ON dl.JSID = js.ID INNER JOIN party_master pm ON pm.ID = js.PARTY_ID WHERE dl.STATE = 11 ORDER BY dl.URGENT DESC, dl.ID ASC");
    define("RT_ADD_QUERY", "CALL deptInput");
    
    //Final Grinding
    define("FINAL_GRINDING", 12);
	define("FG_QUERY", "SELECT dl.`ID`, dl.`JSID`, js.DATE, pm.NAME, js.CY_WIDTH, js.CY_TOTAL, ROUND((js.CY_TOTAL * 7/22), 2) AS FINAL, dl.URGENT FROM `department_list` dl INNER JOIN job_sheet js ON dl.JSID = js.ID INNER JOIN party_master pm ON pm.ID = js.PARTY_ID WHERE dl.STATE = 12 ORDER BY dl.URGENT DESC, dl.ID ASC");
	
	//Copper Plating
	define("COPPER_PLATING", 13);
	define("COPPER_TANK", 131);
	define("CP_QUERY", "SELECT dl.`ID`, dl.`JSID`, js.DATE, pm.NAME, js.CY_WIDTH, js.CY_TOTAL, ROUND((js.CY_TOTAL * 7/22), 2) AS FINAL, CASE WHEN js.CY_WIDTH<=800 THEN ROUND((js.CY_TOTAL * 7/22), 2)-0.3 ELSE ROUND((js.CY_TOTAL * 7/22), 2)-0.4 END AS BS_FINAL, NULL, NULL, NULL, ROUND(getCalculatedVal(getCalculatedVal(js.CY_TOTAL*js.CY_WIDTH, 'CP_AMP', 3), 'CP_AMP_CD', 3)/1000000, 0), NULL, NULL, dl.URGENT FROM `department_list` dl INNER JOIN job_sheet js ON dl.JSID = js.ID INNER JOIN party_master pm ON pm.ID = js.PARTY_ID WHERE dl.STATE = 13 ORDER BY dl.URGENT DESC, dl.ID ASC");
	define("COPPER_PLATING_DEFAULTS", "SELECT VALUE FROM constant_table WHERE ID IN('CP_AMP','CP_AMP_CD')");
	define("COPPER_TANK_QUERY", "SELECT dl.TANK_NO,dl.SHAFT, ROUND(MAX(CASE WHEN js.CY_WIDTH<=800 THEN (((((js.CY_TOTAL * 7/22))+0.1)-dl.BS_ACTUAL)*100) ELSE (((((js.CY_TOTAL * 7/22))+0.15)-dl.BS_ACTUAL)*100) END), 0) AS AVG_LAYER, ROUND(CASE WHEN js.CY_WIDTH<=800 THEN (((((js.CY_TOTAL * 7/22))+0.1)-dl.BS_ACTUAL)*3/4) ELSE (((((js.CY_TOTAL * 7/22))+0.15)-dl.BS_ACTUAL)*3/4) END, 0) AS LAYER_TIME, ROUND(SUM(js.CY_WIDTH *js.CY_TOTAL * 13/20000), 0) AS GIVEN_AMP, ROUND(CASE WHEN js.CY_WIDTH<=800 THEN ((((((js.CY_TOTAL * 7/22))+0.1)-dl.BS_ACTUAL)*3/4)*SUM(js.CY_WIDTH *js.CY_TOTAL * 13/20000)) ELSE ((((((js.CY_TOTAL * 7/22))+0.15)-dl.BS_ACTUAL)*3/4)*SUM(js.CY_WIDTH *js.CY_TOTAL * 13/20000)) END, 0) AS TOTAL_AMP FROM job_sheet js INNER JOIN department_list dl ON dl.JSID = js.ID WHERE dl.STATE = 131 AND SHAFT IS NOT NULL GROUP BY dl.TANK_NO, dl.SHAFT UNION SELECT dl.TANK_NO,dl.SHAFT, NULL, NULL, NULL, NULL FROM department_list dl WHERE dl.STATE=131 GROUP BY dl.TANK_NO HAVING COUNT(SHAFT) = 0");
	define("COPPER_TANK_FETCH", serialize(array("SELECT dl.ID, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL), dl.SHAFT FROM `department_list` dl INNER JOIN job_sheet js ON dl.JSID = js.ID WHERE dl.STATE=131 AND (dl.SHAFT IS NULL OR dl.SHAFT=",") AND dl.TANK_NO=")));
	define("COPPER_TANK_UPDATE", serialize(array("UPDATE `department_list` SET `SHAFT`="," WHERE ID IN"," AND `TANK_NO`=")));
	define("COPPER_TANK_INSERT", "INSERT INTO `copper_tank`(`TANK_NO`, `SHAFT`, `CY_ID`, `VOLT`, `TANK_TEMP`, `DOZ_401`, `DOZ_402`, `DOZ_H2SO4`, `TIME_IN`, `TIME_OUT`) VALUES");
	//define("CP_DEFAULTS_UPDATE", serialize(array("INSERT INTO constant_table (ID, VALUE) VALUES", " ON DUPLICATE KEY UPDATE VALUE=VALUES(VALUE)"));
	
	//Copper Cut
	define("COPPER_CUT", 14);
	define("COPPER_CUT_DESIGN", 141);
	define("CC_QUERY", "SELECT dl.`ID`, dl.`JSID`, js.DATE, pm.NAME, js.CY_WIDTH, js.CY_TOTAL, ROUND((js.CY_TOTAL * 7/22), 2) AS FINAL, dl.TANK_NO, dl.URGENT FROM `department_list` dl INNER JOIN job_sheet js ON dl.JSID = js.ID INNER JOIN party_master pm ON pm.ID = js.PARTY_ID WHERE dl.STATE = 14 ORDER BY dl.URGENT DESC, dl.ID ASC");
	define("CC_UPDATE", serialize(array("UPDATE `department_list` SET `BS_ACTUAL`=",",`TANK_NO`=",",`STATE`=", " WHERE `ID`=")));
	
	//Copper Polish
	define("COPPER_POLISH", 15);
	define("COPPER_POLISH_QUERY", "SELECT dl.`ID`, dl.`JSID`, js.DATE, pm.NAME, js.CY_WIDTH, js.CY_TOTAL, ROUND((js.CY_TOTAL * 7/22), 2) AS FINAL, dl.TANK_NO, dl.URGENT FROM `department_list` dl INNER JOIN job_sheet js ON dl.JSID = js.ID INNER JOIN party_master pm ON pm.ID = js.PARTY_ID WHERE dl.STATE = 15 ORDER BY dl.URGENT DESC, dl.ID ASC");
	
	//Engraving
	define("ENGRAVING", 16);
	define("EG_QUERY", "SELECT dl.`ID`, dl.`JSID`, js.DATE, pm.NAME, js.CY_WIDTH, js.CY_TOTAL, ROUND(js.CY_WIDTH * js.CY_TOTAL/645.16, 2) AS SQ_INCH, om.NAME, dl.TANK_NO, dl.URGENT FROM `department_list` dl INNER JOIN job_sheet js ON dl.JSID = js.ID INNER JOIN party_master pm ON pm.ID = js.PARTY_ID INNER JOIN operator_master om ON om.ID=dl.POLISHER WHERE dl.STATE = 16 ORDER BY dl.URGENT DESC, dl.ID ASC");
	define("EG_UPDATE", serialize(array("UPDATE `department_list` SET `POLISHER`=",",`STATE`=", " WHERE `ID`=")));
	
	//Chrome Plating
	define("CHROME_PLATING", 17);
	define("CHROME_PLATING_QUERY", "SELECT dl.`ID`, dl.`JSID`, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, ROUND(getCalculatedVal ((js.CY_TOTAL * js.CY_WIDTH), 'CHROME_PLATE_AMP', 3)/20000, 0) AS AMP, dl.URGENT FROM `department_list` dl INNER JOIN job_sheet js ON dl.JSID = js.ID INNER JOIN party_master pm ON pm.ID = js.PARTY_ID WHERE dl.STATE = 17 ORDER BY dl.URGENT DESC, dl.ID ASC");
	define("CP_UPDATE", serialize(array("UPDATE `department_list` SET `COLOR`=", ",`TIME`=", ",`STYLUS`=", ",`MACHINE_NO`=", ",`HARDNESS`=", ",`STATE`=", " WHERE `ID`=")));
	define("CHROME_PLATING_DEFAULTS", "SELECT VALUE FROM constant_table WHERE ID IN('CHROME_PLATE_AMP')");
	//define("CHROME_PLATE_DEFAULTS_UPDATE", serialize(array("INSERT INTO constant_table (ID, VALUE) VALUES", " ON DUPLICATE KEY UPDATE VALUE=VALUES(VALUE)"));
	
	//Chrome Polish
	define("CHROME_POLISH", 18);
	define("CHROME_POLISH_QUERY", "SELECT dl.`ID`, dl.`JSID`, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, dl.URGENT FROM `department_list` dl INNER JOIN job_sheet js ON dl.JSID = js.ID INNER JOIN party_master pm ON pm.ID = js.PARTY_ID WHERE dl.STATE = 18 ORDER BY dl.URGENT DESC, dl.ID ASC");
	
	//Proofing
	define("PROOFING", 19);
	define("PROOF_QUERY", "SELECT dl.`ID`, dl.`JSID`, js.DATE, pm.NAME, js.NAME, js.CY_WIDTH, js.CY_TOTAL, cm.NAME, dl.URGENT FROM `department_list` dl INNER JOIN job_sheet js ON dl.JSID = js.ID INNER JOIN party_master pm ON pm.ID = js.PARTY_ID INNER JOIN color_master cm ON cm.ID = dl.COLOR WHERE dl.STATE = 19 ORDER BY dl.URGENT DESC, dl.ID ASC");
	
	//Dispatch
	define("DISPATCH", 20);
	define("DISPATCH_QUERY", "CALL getDispatchDetails()");
	
	//Completed
	define("COMPLETED", 21);
	define("COMPLETED_QUERY", serialize(array("UPDATE `job_sheet` SET `STATE`= 1 WHERE `ID`=","DELETE FROM department_list WHERE `JSID`=")));
	
	//Tikal Size
	define("TIKAL_SIZE", 21);
	define("TIKAL_SIZE_QUERY", "SELECT js.ID, js.DATE, pm.NAME, calcTikalSize(js.CY_TOTAL) AS TIKAL_SIZE, (bs.QUANTITY-bs.SPARE_QUANTITY)*2 AS PIECES, pm.BORE, js.CY_TOTAL, bs.URGENT FROM job_sheet js INNER JOIN base_shell bs ON js.ID = bs.JSID INNER JOIN party_master pm ON js.PARTY_ID = pm.ID ORDER BY bs.URGENT DESC");
	define("TIKAL_SIZE_DATE", serialize(array("SELECT js.ID, js.DATE, pm.NAME, calcTikalSize(js.CY_TOTAL) AS TIKAL_SIZE, (bs.QUANTITY-bs.SPARE_QUANTITY)*2 AS PIECES, pm.BORE, js.CY_TOTAL, bs.URGENT FROM job_sheet js INNER JOIN base_shell bs ON js.ID = bs.JSID INNER JOIN party_master pm ON js.PARTY_ID = pm.ID WHERE js.DATE BETWEEN "," AND "," ORDER BY bs.URGENT DESC")));
	define("TIKAL_SIZE_PRINT", "SELECT js.DATE, pm.NAME, calcTikalSize(js.CY_TOTAL) AS TIKAL_SIZE, (bs.QUANTITY-bs.SPARE_QUANTITY)*2 AS PIECES, pm.BORE, js.CY_TOTAL, bs.URGENT FROM job_sheet js INNER JOIN base_shell bs ON js.ID = bs.JSID INNER JOIN party_master pm ON js.PARTY_ID = pm.ID ORDER BY bs.URGENT DESC");
	define("TIKAL_SIZE_DATE_PRINT", serialize(array("SELECT js.DATE, pm.NAME, calcTikalSize(js.CY_TOTAL) AS TIKAL_SIZE, (bs.QUANTITY-bs.SPARE_QUANTITY)*2 AS PIECES, pm.BORE, js.CY_TOTAL, bs.URGENT FROM job_sheet js INNER JOIN base_shell bs ON js.ID = bs.JSID INNER JOIN party_master pm ON js.PARTY_ID = pm.ID WHERE js.DATE BETWEEN "," AND "," ORDER BY bs.URGENT DESC")));
	
	//Sheet Cutting
	define("SHEET_CUTTING", 22);
	define("SHEET_CUTTING_QUERY", "SELECT js.ID, js.DATE, pm.NAME, js.`CY_WIDTH`, js.`CY_TOTAL`, bs.QUANTITY-bs.SPARE_QUANTITY AS PIECES, getCalculatedVal(0, 'SC_THICKNESS', 1) AS THICKNESS, getNoOfRings(js.`CY_WIDTH`, js.`CY_TOTAL`, bs.QUANTITY-bs.SPARE_QUANTITY) AS RINGS, getCalculatedVal(js.`CY_TOTAL`, 'SC_RING_SIZE', 2) AS RING_SIZE, getCalculatedVal(js.`CY_WIDTH`, 'SC_SHEET_LENGTH', 2) AS SHEET_LEN, getCalculatedVal(js.`CY_TOTAL`, 'SC_SHEET_BREADTH', 2) AS SHEET_BREADTH, bs.URGENT FROM `job_sheet` js INNER JOIN base_shell bs ON js.ID = bs.JSID INNER JOIN party_master pm ON js.PARTY_ID = pm.ID ORDER BY bs.URGENT DESC, bs.ID ASC");
	define("SHEET_CUTTING_DATE", serialize(array("SELECT js.ID, js.DATE, pm.NAME, js.`CY_WIDTH`, js.`CY_TOTAL`, bs.QUANTITY-bs.SPARE_QUANTITY AS PIECES, getCalculatedVal(0, 'SC_THICKNESS', 1) AS THICKNESS, getNoOfRings(js.`CY_WIDTH`, js.`CY_TOTAL`, bs.QUANTITY-bs.SPARE_QUANTITY) AS RINGS, getCalculatedVal(js.`CY_TOTAL`, 'SC_RING_SIZE', 2) AS RING_SIZE, getCalculatedVal(js.`CY_WIDTH`, 'SC_SHEET_LENGTH', 2) AS SHEET_LEN, getCalculatedVal(js.`CY_TOTAL`, 'SC_SHEET_BREADTH', 2) AS SHEET_BREADTH, bs.URGENT FROM `job_sheet` js INNER JOIN base_shell bs ON js.ID = bs.JSID INNER JOIN party_master pm ON js.PARTY_ID = pm.ID WHERE js.DATE BETWEEN "," AND "," ORDER BY bs.URGENT DESC, bs.ID ASC")));
	define("SHEET_CUTTING_PRINT", "SELECT js.DATE, pm.NAME, js.`CY_WIDTH`, js.`CY_TOTAL`, bs.QUANTITY-bs.SPARE_QUANTITY AS PIECES, getCalculatedVal(0, 'SC_THICKNESS', 1) AS THICKNESS, getNoOfRings(js.`CY_WIDTH`, js.`CY_TOTAL`, bs.QUANTITY-bs.SPARE_QUANTITY) AS RINGS, getCalculatedVal(js.`CY_TOTAL`, 'SC_RING_SIZE', 2) AS RING_SIZE, getCalculatedVal(js.`CY_WIDTH`, 'SC_SHEET_LENGTH', 2) AS SHEET_LEN, getCalculatedVal(js.`CY_TOTAL`, 'SC_SHEET_BREADTH', 2) AS SHEET_BREADTH, bs.URGENT FROM `job_sheet` js INNER JOIN base_shell bs ON js.ID = bs.JSID INNER JOIN party_master pm ON js.PARTY_ID = pm.ID ORDER BY bs.URGENT DESC, bs.ID ASC");
	define("SHEET_CUTTING_DATE_PRINT", serialize(array("SELECT js.DATE, pm.NAME, js.`CY_WIDTH`, js.`CY_TOTAL`, bs.QUANTITY-bs.SPARE_QUANTITY AS PIECES, getCalculatedVal(0, 'SC_THICKNESS', 1) AS THICKNESS, getNoOfRings(js.`CY_WIDTH`, js.`CY_TOTAL`, bs.QUANTITY-bs.SPARE_QUANTITY) AS RINGS, getCalculatedVal(js.`CY_TOTAL`, 'SC_RING_SIZE', 2) AS RING_SIZE, getCalculatedVal(js.`CY_WIDTH`, 'SC_SHEET_LENGTH', 2) AS SHEET_LEN, getCalculatedVal(js.`CY_TOTAL`, 'SC_SHEET_BREADTH', 2) AS SHEET_BREADTH, bs.URGENT FROM `job_sheet` js INNER JOIN base_shell bs ON js.ID = bs.JSID INNER JOIN party_master pm ON js.PARTY_ID = pm.ID WHERE js.DATE BETWEEN "," AND "," ORDER BY bs.URGENT DESC, bs.ID ASC")));
	define("SHEET_CUTTING_DEFAULTS", "SELECT VALUE FROM constant_table WHERE ID IN('SC_THICKNESS','SC_RING_SIZE','SC_SHEET_BREADTH','SC_SHEET_LENGTH')");
	
	//Department
	define("DEPARTMENTS", array(BASE_SHELL, TIKAL_SIZE, SHEET_CUTTING, ROUGH_TURNING, FINAL_GRINDING, COPPER_PLATING, COPPER_CUT, COPPER_POLISH, ENGRAVING, CHROME_PLATING, CHROME_POLISH, PROOFING, DISPATCH));
	define("DEPT_UPDATE", serialize(array("UPDATE `department_list` SET `STATE`=", " WHERE `ID`=")));
	define("DEPT_URGENT", serialize(array("UPDATE `department_list` dl SET dl.`URGENT`=", " WHERE dl.ID IN")));
	
	//Operator Count
	define("OP_COUNT_ADD", serialize(array("INSERT INTO `operator_count`(`OP_ID`,`DATE`, `LEN`, `CIRCUM`, `TOTAL`, `STATE`) SELECT ",",UNIX_TIMESTAMP(), js.CY_WIDTH, js.CY_TOTAL, ROUND((js.CY_TOTAL * 7/22), 2), "," FROM job_sheet js INNER JOIN department_list dl on js.ID = dl.JSID WHERE dl.ID=")));
	
	//Re-Process
	define("RE_PROCESS_ADD", serialize(array("INSERT INTO `re_process`(`JSID`, `DATE`, `FROM_STATE`, `TO_STATE`) SELECT dl.JSID, UNIX_TIMESTAMP(), ",", "," FROM department_list dl WHERE dl.ID =")));
	
	//Constant Table
	define("CONSTANT_UPDATE",serialize(array("INSERT INTO constant_table (ID, VALUE) VALUES", " ON DUPLICATE KEY UPDATE VALUE=VALUES(VALUE)")));
    
	//Print Sub-Types
	define("PRINT_PARTYWISE", 1);
	define("PRINT_DATEWISE", 2);
	define("PRINT_CHALLANWISE", 3);
	
    //Print Data
    define("JOBSHEET_PRINT", "SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID GROUP BY pm.NAME ORDER BY PARTY_NAME, DATE");
    define("JOBSHEET_PRINT_DATE", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.DATE BETWEEN "," AND "," GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.DATE BETWEEN ", " AND "," GROUP BY pm.NAME ORDER BY PARTY_NAME, DATE")));
    define("JOBSHEET_PRINT_DATEWISE", "SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID GROUP BY js.ID ORDER BY js.DATE");
    define("JOBSHEET_PRINT_DATEWISE_DATE", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.DATE BETWEEN "," AND "," GROUP BY js.ID ORDER BY js.DATE")));
    define("JOBSHEET_PRINT_CHALLAN", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.CHALLAN_DATE BETWEEN "," AND "," GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.CHALLAN_DATE BETWEEN "," AND "," GROUP BY pm.NAME ORDER BY PARTY_NAME, CHALLAN_DATE, DATE")));
    
    define("NP_LOCAL_PRINT", "SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='No' GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='No' GROUP BY pm.NAME ORDER BY PARTY_NAME, DATE");
    define("NP_LOCAL_PRINT_DATE", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='No' AND js.DATE BETWEEN "," AND "," GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='No' AND js.DATE BETWEEN ", " AND "," GROUP BY pm.NAME ORDER BY PARTY_NAME, DATE")));
    define("NP_LOCAL_PRINT_DATEWISE", "SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='No' GROUP BY js.ID ORDER BY js.DATE");
    define("NP_LOCAL_PRINT_DATEWISE_DATE", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='No' AND js.DATE BETWEEN "," AND "," GROUP BY js.ID ORDER BY js.DATE")));
    define("NP_LOCAL_PRINT_CHALLAN", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='No' AND js.CHALLAN_DATE BETWEEN "," AND "," GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='No' AND js.CHALLAN_DATE BETWEEN "," AND "," GROUP BY pm.NAME ORDER BY PARTY_NAME, CHALLAN_DATE, DATE")));
    
    define("NP_OUT_PRINT", "SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='Yes' GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='Yes' GROUP BY pm.NAME ORDER BY PARTY_NAME, DATE");
    define("NP_OUT_PRINT_DATE", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='Yes' AND js.DATE BETWEEN "," AND "," GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='Yes' AND js.DATE BETWEEN ", " AND "," GROUP BY pm.NAME ORDER BY PARTY_NAME, DATE")));
    define("NP_OUT_PRINT_DATEWISE", "SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='Yes' GROUP BY js.ID ORDER BY js.DATE");
    define("NP_OUT_PRINT_DATEWISE_DATE", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='Yes' AND js.DATE BETWEEN "," AND "," GROUP BY js.ID ORDER BY js.DATE")));
    define("NP_OUT_PRINT_CHALLAN", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='Yes' AND js.CHALLAN_DATE BETWEEN "," AND "," GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND pm.OUTSTATION='Yes' AND js.CHALLAN_DATE BETWEEN "," AND "," GROUP BY pm.NAME ORDER BY PARTY_NAME, CHALLAN_DATE, DATE")));
	
    define("NP_ALL_PRINT", "SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 GROUP BY pm.NAME ORDER BY PARTY_NAME, DATE");
    define("NP_ALL_PRINT_DATE", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND js.DATE BETWEEN "," AND "," GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND js.DATE BETWEEN ", " AND "," GROUP BY pm.NAME ORDER BY PARTY_NAME, DATE")));
    define("NP_ALL_PRINT_DATEWISE", "SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 GROUP BY js.ID ORDER BY js.DATE");
    define("NP_ALL_PRINT_DATEWISE_DATE", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND js.DATE BETWEEN "," AND "," GROUP BY js.ID ORDER BY js.DATE")));
    define("NP_ALL_PRINT_CHALLAN", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND js.CHALLAN_DATE BETWEEN "," AND "," GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=1 AND js.CHALLAN_DATE BETWEEN "," AND "," GROUP BY pm.NAME ORDER BY PARTY_NAME, CHALLAN_DATE, DATE")));
    
    define("P_LOCAL_PRINT", "SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='No' GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='No' GROUP BY pm.NAME ORDER BY PARTY_NAME, DATE");
    define("P_LOCAL_PRINT_DATE", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='No' AND js.DATE BETWEEN "," AND "," GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='No' AND js.DATE BETWEEN ", " AND "," GROUP BY pm.NAME ORDER BY PARTY_NAME, DATE")));
    define("P_LOCAL_PRINT_DATEWISE", "SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='No' GROUP BY js.ID ORDER BY js.DATE");
    define("P_LOCAL_PRINT_DATEWISE_DATE", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='No' AND js.DATE BETWEEN "," AND "," GROUP BY js.ID ORDER BY js.DATE")));
    // define("P_LOCAL_PRINT_CHALLAN", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='No' AND js.CHALLAN_DATE BETWEEN "," AND "," GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='No' AND js.CHALLAN_DATE BETWEEN "," AND "," GROUP BY pm.NAME ORDER BY PARTY_NAME, CHALLAN_DATE, DATE")));
	
    define("P_ALL_PRINT", "SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 GROUP BY pm.NAME ORDER BY PARTY_NAME, DATE");
    define("P_ALL_PRINT_DATE", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND js.DATE BETWEEN "," AND "," GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND js.DATE BETWEEN ", " AND "," GROUP BY pm.NAME ORDER BY PARTY_NAME, DATE")));
    define("P_ALL_PRINT_DATEWISE", "SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 GROUP BY js.ID ORDER BY js.DATE");
    define("P_ALL_PRINT_DATEWISE_DATE", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND js.DATE BETWEEN "," AND "," GROUP BY js.ID ORDER BY js.DATE")));
    // define("P_ALL_PRINT_CHALLAN", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND js.CHALLAN_DATE BETWEEN "," AND "," GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND js.CHALLAN_DATE BETWEEN "," AND "," GROUP BY pm.NAME ORDER BY PARTY_NAME, CHALLAN_DATE, DATE")));
    
    define("P_OUT_PRINT", "SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='Yes' GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='Yes' GROUP BY pm.NAME ORDER BY PARTY_NAME, DATE");
    define("P_OUT_PRINT_DATE", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='Yes' AND js.DATE BETWEEN "," AND "," GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='Yes' AND js.DATE BETWEEN ", " AND "," GROUP BY pm.NAME ORDER BY PARTY_NAME, DATE")));
    define("P_OUT_PRINT_DATEWISE", "SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='Yes' GROUP BY js.ID ORDER BY js.DATE");
    define("P_OUT_PRINT_DATEWISE_DATE", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='Yes' AND js.DATE BETWEEN "," AND "," GROUP BY js.ID ORDER BY js.DATE")));
    // define("P_OUT_PRINT_CHALLAN", serialize(array("SELECT js.ID, js.DATE, js.DATE+(js.DELIVERY*24*60*60*1000) AS DELIVERY_DATE, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME, ROUND(js.CY_WIDTH/25.4, 1) AS INCH, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, SUM(jsp.QUANTITY) AS QUANTITY, js.REMARKS FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='Yes' AND js.CHALLAN_DATE BETWEEN "," AND "," GROUP BY js.ID UNION SELECT -1, NULL, NULL, NULL, pm.NAME AS PARTY_NAME, NULL, ROUND(SUM(js.CY_WIDTH*js.CY_TOTAL*QUANTITY/645.16),2) AS INCH, NULL, SUM(jsp.QUANTITY) AS QUANTITY, NULL FROM `job_sheet` js INNER JOIN `party_master` pm on js.PARTY_ID = pm.ID INNER JOIN `js_process` jsp ON js.ID = jsp.JS_ID WHERE js.STATE=0 AND pm.OUTSTATION='Yes' AND js.CHALLAN_DATE BETWEEN "," AND "," GROUP BY pm.NAME ORDER BY PARTY_NAME, CHALLAN_DATE, DATE")));
	
    define("CHALLAN_PRINT", serialize(array("SELECT js.ID, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME AS JOB_NAME, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL, ' X ') AS SIZE, proc.NAME AS PROCESS_NAME, jsp.QUANTITY AS QUANTITY, CASE WHEN pmpl.RATE_TYPE = 'sqinch' THEN ROUND(pmpl.RATE*js.CY_WIDTH*js.CY_TOTAL/645.16, 2) ELSE ROUND(pmpl.RATE*js.CY_WIDTH*js.CY_TOTAL/100, 2) END AS PER_RATE, (SELECT ROUND(PER_RATE * QUANTITY, 2)) AS TOTAL_RATE, js.REMARKS FROM job_sheet js INNER JOIN js_process jsp ON js.ID = jsp.JS_ID INNER JOIN pm_pl pmpl ON js.PARTY_ID = pmpl.PMID INNER JOIN party_master pm ON js.PARTY_ID = pm.ID INNER JOIN process_master proc ON jsp.PID = proc.ID WHERE pmpl.PL_TYPE = 1 AND pmpl.PLID = jsp.PID AND js.ID = ",
			"UNION SELECT js.ID, js.CHALLAN_DATE, pm.NAME AS PARTY_NAME, js.NAME AS JOB_NAME, CONCAT(js.CY_WIDTH, ' X ', js.CY_TOTAL) AS SIZE, less.LESS_TYPE AS PROCESS_NAME, -1*jsl.QUANTITY AS QUANTITY, CASE WHEN pmpl.RATE_TYPE = 'sqinch' THEN ROUND(-1*pmpl.RATE*js.CY_WIDTH*js.CY_TOTAL/645.16, 2) ELSE ROUND(-1 * pmpl.RATE*js.CY_WIDTH*js.CY_TOTAL/100, 2) END AS PER_RATE, (SELECT ROUND(PER_RATE * QUANTITY, 2)) AS TOTAL_RATE, js.REMARKS FROM job_sheet js INNER JOIN js_less jsl ON js.ID = jsl.JS_ID INNER JOIN pm_pl pmpl ON js.PARTY_ID = pmpl.PMID INNER JOIN party_master pm ON js.PARTY_ID = pm.ID INNER JOIN less_master less ON jsl.LID = less.ID WHERE pmpl.PL_TYPE = 4 AND pmpl.PLID = jsl.LID AND js.ID = ",
			"UNION SELECT js.ID, NULL, color.NAME, NULL, NULL, NULL, NULL, NULL, NULL, NULL FROM job_sheet js INNER JOIN js_color jsc ON js.ID = jsc.JS_ID INNER JOIN color_master color ON jsc.CID = color.ID WHERE js.ID = ")));
    
    //Data Separation
    define("DS_BACKUP", serialize(array("CREATE TABLE `","` AS SELECT temp.* FROM `", "` temp INNER JOIN job_sheet js ON js.ID = temp.JS_ID WHERE js.STATE=1 AND js.DATE BETWEEN ", " AND ")));
    // define("DS_JS_OUTFILE", serialize(array("SELECT ",", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL FROM DUAL 
    		// UNION
			// SELECT * FROM job_sheet WHERE STATE=1 AND DATE BETWEEN ", " INTO OUTFILE 'jobs.csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\\n'")));
    define("DS_JS_OUTFILE", "SELECT * FROM job_sheet WHERE STATE=1 AND DATE BETWEEN ");
    define("DS_JS_DELETE", "DELETE FROM job_sheet WHERE STATE=1 AND DATE BETWEEN ");
    
    //Data Merging
    define("DM_FETCH", serialize(array("load data local infile "," into table job_sheet fields terminated by ',' enclosed by '\"' lines terminated by '\\n' IGNORE 1 LINES")));
    define("DM_GET_BACKUP", serialize(array("INSERT INTO `","` SELECT * FROM `","`")));
    define("DM_DROP_TABLE", "DROP TABLE IF EXISTS ");
    
    //Admin Page
    define("ADMIN", 23);
	define("ADMIN_FETCH", "SELECT `ID`, `NAME`, `ADMIN` FROM `users`");
	define("ADMIN_FETCH_PERM", "SELECT `STATE` FROM `user_permissions` WHERE `USER_ID`=");
	define("ADMIN_PERM_ADD", "INSERT INTO `user_permissions`(`USER_ID`, `STATE`) VALUES");
	define("ADMIN_PERM_DELETE", serialize(array("DELETE FROM `user_permissions` WHERE `STATE` IN"," AND `USER_ID`=")));
	define("ADMIN_ADD_USER", "INSERT INTO `users`(`NAME`, `ADMIN`, `PASSWORD`) VALUES");
	define("ADMIN_UPDATE_USER", serialize(array("UPDATE `users` SET `NAME`=",",`ADMIN`=", " WHERE ID=")));
	define("ADMIN_UPDATE_PASS", serialize(array("UPDATE `users` SET `NAME`="," ,`ADMIN`="," ,`PASSWORD`="," WHERE ID=")));
	define("ADMIN_DELETE_USER", "DELETE FROM `users` WHERE `ID` IN");
    
    //ISPs
    define("ISP", 24);
    define("ISP_FETCH", "SELECT `ID`, `AREA_NAME`, `ISP` FROM `ISP`");
	define("ISP_ADD_QUERY", "INSERT INTO `ISP`(`AREA_NAME`, `ISP`) VALUES");
	define("ISP_UPDATE_QUERY", serialize(array("UPDATE `ISP` SET `AREA_NAME`=",",`ISP`="," WHERE `ID`=")));
	define("ISP_DELETE_QUERY", "DELETE FROM `ISP` WHERE `ID` IN");
	
	//Login
	define("LOGIN_QUERY", serialize(array("SELECT u.ID, u.ADMIN, up.STATE FROM users u LEFT JOIN user_permissions up ON u.ID = up.USER_ID WHERE u.NAME="," AND u.PASSWORD=")));
	define("IP_CHECK", "SELECT `ID`, `AREA_NAME` FROM `ISP` WHERE `ISP` IN");
    
    //Success Message
    define("ADDROWSUCCESS", 1000);
    define("DELETEROWSUCCESS", 1100);
    define("UPDATEROWSUCCESS", 1200);
    define("URGENTSUCCESS", 1300);
    define("SEPARATESUCCESS", 1400);
    define("MERGESUCCESS", 1500);
    define("LOGINSUCCESS", 1600);
    define("IPSUCCESS", 1700);
    
    //Error Messages
    define("ADDROWERROR", -1000);
    define("NOROWS", -1);
    define("DELETEROWERROR", -1100);
    define("UPDATEROWERROR", -1200);
    define("URGENTERROR", -1300);
    define("SEPARATEERROR", -1400);
    define("MERGEERROR", -1500);
    define("LOGINERROR", -1600);
	define("IPERROR", -1700);
?>