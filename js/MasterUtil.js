var MasterUtil = new function()
{
    this.getParams = function(type, dateRange, data)
    {
        var params = {};
        data = data ? data : {};
        if(dateRange)
        {
        	data["dateRange"] = JSON.stringify(dateRange);
        }
        params =  this.getMasterParams(params, data, type);
        return params;
    }
    
    this.getMasterParams = function(params, data, type)
    {
        data["type"] = type;
        params["url"] = "php/fetchdata.php";
        params["data"] = data;
        this.getCommonMasterParams(params, data);
        return params;
    }
    
    this.handleMasterData = function(resp)
    {
    	var ignoreSuccess = (resp["ignoreSuccess"]);
    	if(ignoreSuccess)
    	{
    		return;
    	}
        var type = resp["type"];
        var data = resp["data"];
        var id = resp["id"];
        var lastId = resp["lastid"];
        var refreshType = resp["refreshType"];
        var dataSeparate = resp['separate'];
        var el = MasterUtil.getRowBasedOnType(type);
        
        GeneralUtil.enableEl('delete');
        GeneralUtil.enableEl('printParty');
        GeneralUtil.enableEl('printDateWise');
        GeneralUtil.enableEl('completeDept');
        
        // if(dataSeparate)
        // {
        	// window.location = 'php/downloadFile.php?dateRange='+JSON.stringify(resp["dateRange"]);
        // }
        
        if(!id)
        {
            GeneralUtil.cleanTableData(el);
        }
        
        if(id)
        {
            MasterUtil.addMasterRow(type, data, id, resp);
        }
        
        else if(data == Constants.NOROWS)
        {
            GeneralUtil.disableEl('delete');
            GeneralUtil.disableEl('printParty');
            GeneralUtil.disableEl('printDateWise');
            GeneralUtil.disableEl('completeDept');
            MasterUtil.showHideMasterTable(false, true);
        }
        else if (dataSeparate || data == Constants.ADDROWSUCCESS || data == Constants.DELETEROWSUCCESS || data == Constants.ADDROWERROR || data == Constants.DELETEROWERROR || data == Constants.UPDATEROWERROR || data == Constants.UPDATEROWSUCCESS || data == Constants.URGENTERROR || data == Constants.SEPARATESUCCESS || data == Constants.SEPARATEERROR || data == Constants.MERGESUCCESS || data == Constants.MERGEERROR)
        {
            var message = MasterUtil.getResponseMessage(data);
            $(function(){
            	$("#masterRowMessage").find("p").html(message);
            	if(lastId)
            	{
            		$("#masterRowMessage").find("span[elname='idTag']").html(lastId).parent().css("display","");	
            	}
            	else
            	{
            		$("#masterRowMessage").find("span[elname='idTag']").parent(). css("display","none");	
            	}
                $("#masterRowMessage").dialog({
                    resizable : false,
                    modal : true,
                    buttons : {
                        Ok : function(){
                            $(this).dialog("close");
							LoadUtil.refreshView(refreshType ? refreshType : type);
                    	}
                    }
                });
            });
        }
        else if(data == Constants.URGENTSUCCESS)
        {
        	LoadUtil.refreshView(refreshType ? refreshType : type);
        }
        else
        {
            //var el;
            MasterUtil.showHideMasterTable(true);
            if(type == Constants.COPPER_TANK)
            {
            	DepartmentUtil.populateCopperTank(data);
            }
            else
            {
            	MasterUtil.populateMasterTable(el, data, type);
            }
        }
    }
    
    this.getRowBasedOnType = function(type, addRowType, challan)
    {
        var id = null;
        if(challan)
        {
        	id = "printChallanRequirements";
        }
        else if(type == Constants.PROCESSMASTER)
        {
            id = addRowType ? "processMasterAddRow": "processMasterRow";
        }
        else if(type == Constants.COLORMASTER)
        {
            id = addRowType ? "colorMasterAddRow" : "colorMasterRow";
        }
        else if(type == Constants.MATERIALMASTER)
        {
            id = addRowType ? "materialMasterAddRow" : "materialMasterRow";
        }
        else if(type == Constants.LESSMASTER)
        {
            id = addRowType ? "lessMasterAddRow" : "lessMasterRow";
        }
        else if(type == Constants.OPMASTER)
        {
            id = addRowType ? "opMasterAddRow" : "opMasterRow";
        }
        else if(type == Constants.SPARECYLINDER)
        {
            id = addRowType ? "cylinderMasterAddRow" : "cylinderMasterRow";
        }
        else if(type == Constants.TOMMASTER)
        {
            id = addRowType ? "tomMasterAddRow" : "tomMasterRow";
        }
        else if(type == Constants.PARTYMASTER)
        {
            id = addRowType ? "partyMasterAddRow" : "partyMasterRow";
        }
        else if(type == Constants.JOBSHEET || type == Constants.NONPENDING_LOCAL  || type == Constants.NONPENDING_OUTSTATION || type == Constants.NONPENDING_ALL || type == Constants.PENDING_LOCAL || type == Constants.PENDING_OUTSTATION || type == Constants.PENDING_ALL)
        {
        	id = addRowType ? "jobTrack" : "jobSheetRow";
        }
        else if(type == Constants.BASE_SHELL)
        {
        	id = addRowType ? "bsSpareCyTable" : "baseShellRow";
        }
        else if(type == Constants.ROUGH_TURNING)
        {
        	id = "roughTurningRow";
        }
        else if(type == Constants.FINAL_GRINDING)
        {
        	id = "finalGrindingRow";
        }
        else if(type == Constants.COPPER_PLATING)
        {
        	id = addRowType ? "copperPlatingDefault" : "copperPlatingRow";
        }
        else if(type == Constants.COPPER_TANK)
        {
        	id = addRowType ? "copperTankShaft" : "";
        }
        else if(type == Constants.COPPER_CUT)
        {
        	id = "copperCutRow";
        }
        else if(type == Constants.COPPER_POLISH)
        {
        	id = "copperPolishRow";
        }
        else if(type == Constants.ENGRAVING)
        {
        	id = "engravingRow";
        }
        else if(type == Constants.CHROME_PLATING)
        {
        	id = addRowType ? "chromePlatingDefault" : "chromePlatingRow";
        }
        else if(type == Constants.CHROME_POLISH)
        {
        	id = "chromePolishRow";
        }
        else if(type == Constants.PROOFING)
        {
        	id = "proofingRow";
        }
        else if(type == Constants.DISPATCH)
        {
        	id = "dispatchRow";
        }
        else if(type == Constants.SHEET_CUTTING)
        {
        	id = addRowType ? "sheetCuttingDefault" : "sheetCuttingRow";
        }
        else if(type == Constants.TIKAL_SIZE)
        {
        	id = "tikalSizeRow";
        }
        else if(type == Constants.ADMIN)
        {
        	id = addRowType ? "usersAddRow" : "usersRow";
        }
        else if(type == Constants.ISP)
        {
        	id = addRowType ? "ispAddRow" : "ispRow";
        }
        return document.getElementById(id);
    }
    
    this.showHideMasterTable = function(tableShow, noRowShow)
    {
        var tableDisp = tableShow ? "" : "none";
        var noRowDisp = noRowShow ? "": "none";
        var tableEl = document.getElementsByTagName("table")[0];
        var noRowEl =  document.getElementById("noRow");
        if(tableEl)
        {
        	tableEl.style.display = tableDisp;
        }
        if(noRowEl)
        {
        	noRowEl.style.display = noRowDisp;
        }
    }
    
    this.getResponseMessage = function(data)
    {
        var message = data;
        if (data == Constants.ADDROWSUCCESS)
        {
            message = "Row Added Successfully!";
        }
        else if(data == Constants.DELETEROWSUCCESS)
        {
            message = "Row/Rows deleted Successfully!";
        }
        else if(data == Constants.ADDROWERROR)
        {
            message = "Error occured during Row Addition!";
        }
        else if(data == Constants.DELETEROWERROR)
        {
            message = "Error occured during Row/Rows Deletion!";
        }
        else if(data == Constants.UPDATEROWERROR)
        {
            message = "Row Updation Error!";
        }
        else if(data == Constants.UPDATEROWSUCCESS)
        {
            message = "Row/Rows Updated Successfully!";
        }
        else if(data == Constants.URGENTERROR)
        {
        	message = "Cannot mark Urgent!";
        }
        else if(data == Constants.SEPARATESUCCESS)
        {
        	message = "Data Separation Successful!";
        }
        else if(data == Constants.MERGESUCCESS)
        {
        	message = "Data Merging Successful!";
        }
        else if(data == Constants.SEPARATEERROR)
        {
        	message = "Data Separation Failed!";
        }
        else if(data == Constants.MERGEERROR)
        {
        	message = "Data Merging Failed!";
        }
        return message;
    }
    
    this.populateMasterTable = function(el, data, type)
    {
    	var urgentCount = 0;
        for(var i=0; i<data.length; i++)
        {
            var dataNode = data[i];
            var row = GeneralUtil.cloneNode(el, i);
           
            row = MasterUtil.populateRow(row, dataNode);
            $(row).find("input[elname='deleteRow']").val(dataNode[0]);
            if(type == Constants.BASE_SHELL)
            {
            	MasterUtil.setSpareCylinders(row, dataNode);
            }
            else if(type == Constants.JOBSHEET || type == Constants.NONPENDING_LOCAL  || type == Constants.NONPENDING_OUTSTATION || type == Constants.PENDING_LOCAL || type == Constants.PENDING_OUTSTATION || type == Constants.NONPENDING_ALL || type == Constants.PENDING_ALL)
            {
            	$(row).find("button[elname='trackJob']").val(dataNode[0]);
            }
            if(Number(dataNode["URGENT"]))
	        {
	        	$(row).addClass("alert alert-warning").find("button[elname='urgentRow']").attr("urgent", 1);
	        	urgentCount++;
	        }
	        else
	        {
	        	$(row).removeClass("alert alert-warning").find("button[elname='urgentRow']").attr("urgent", 0);
	        }
            $(el).parent().append(row);
        }
        if(urgentCount == data.length)
        {
        	$("#container").find("button[elname='urgentAll']").attr("urgent", 1);
        }
    }
    
    this.populateRow = function(row, dataNode, dataStartIndex)
    {
    	var cells = $(row).find("td").filter(function(){
            	return this.children.length == 0;
            });
        for(var j=0, z=dataStartIndex; j<cells.length; j++, z++)
        {
        	z = !dataStartIndex ? j : z;
        	if(cells[j].getAttribute("date"))
        	{
        		var dateVal = dataNode[z] ? GeneralUtil.getDate(new Date(Number(dataNode[z]))) : null;
        		cells[j].innerHTML = dateVal;
        		cells[j].value = dateVal;
        	}
        	else if(cells[j].getAttribute("stateType"))
        	{
        		cells[j].innerHTML = GeneralUtil.getStateNameBasedOnId(dataNode[z]);
        		cells[j].value = dataNode[z];
        	}
        	else if(cells[j].getAttribute("booleanPrint"))
        	{
        		cells[j].innerHTML = Number(dataNode[z]) ? "Yes" : "No";
        		cells[j].value = dataNode[z] ? dataNode[z] : "";
        	}
        	else if(cells[j].getAttribute("ignoreEl") == "true")
        	{
        		continue;
        	}
        	else
        	{
        		cells[j].innerHTML = dataNode[z] ? dataNode[z] : "";
            	cells[j].value = dataNode[z] ? dataNode[z] : "";
        	}
        }
        return row;
    }
    
    this.setSpareCylinders = function(row, data)
    {
    	if(data["SPARE_COUNT"] == 0)
    	{
    		return;
    	}
    	var idVal = $(row).find("td[elname='bsid']").addClass("alert alert-danger").css("cursor", "pointer").removeClass("not-active");
    }
    
    this.populateMasterRow = function(row, data)
    {
    	if(!data || data == -1)
    	{
    		return;
    	}
        var cells = $(row).find(".form-control").filter(function(){
        	return this.getAttribute("ignoreEl") != "true";
        });
        for(var j=0,k=0; j<cells.length; j++, k++)   //j for els, k for data
        {
            if((cells[j].tagName == "INPUT" && (cells[j].type == "text" || cells[j].type == "number")) || cells[j].tagName == "TEXTAREA" || cells[j].tagName == "SELECT")
            {
                cells[j].value = data[k];
            }
            else
            {
                var name = cells[j].name;
                var formData = data[k];
                while(cells[j].name == name)
                {
                    if(cells[j].value == formData)
                    {
                        cells[j].checked = true;
                    }
                    else
                    {
                        cells[j].checked = false;
                        cells[j].removeAttribute("checked");
                    }
                    if(cells[j+1] && cells[j+1].name == name)
                    {
                        j++;
                    }
                    else
                    {
                        break;
                    }
                }
            }
        }
    }
    
    this.addMasterRow = function(masterType, data, id, resp)
    {
    	if(resp)
    	{
    		var challan = resp["challan"];
    	}
    	//var buttonSubmit = ;
        var newMasterRow = MasterUtil.getRowBasedOnType(masterType, true, challan);
        newMasterRow = GeneralUtil.cloneNode(newMasterRow);
        
        if(data)
        {
            this.populateMasterRow(newMasterRow, data[0]);
        }
        
        if(challan)
        {
        	GeneralUtil.setCurrentDate(newMasterRow, data[0]['CHALLAN_DATE'] ? new Date(Number(data[0]['CHALLAN_DATE'])) : null, 'jsDate');
        }
        else if(masterType == Constants.COPPER_TANK)
        {
        	DepartmentUtil.populateAvailableCylinders(newMasterRow, data, resp);
        }
        else if(masterType == Constants.PARTYMASTER)
        {
            var addProcessRow = $(newMasterRow).find("tr[elname='pmAddProcessRow']")[0];
            MasterUtil.addPartyMasterProcessRow(addProcessRow, data);
        }
        else if(masterType == Constants.BASE_SHELL)
        {
        	MasterUtil.populateBaseShellSpareCy(newMasterRow, data);
        }
        else if(masterType == Constants.SHEET_CUTTING || masterType == Constants.COPPER_PLATING || masterType == Constants.CHROME_PLATING)
        {
        	data = MasterUtil.populateConstantTable(newMasterRow, data);
        	var startIndex = 0;
        }
        else if(masterType == Constants.JOBSHEET || masterType == Constants.NONPENDING_LOCAL || masterType == Constants.NONPENDING_OUTSTATION || masterType == Constants.PENDING_LOCAL || masterType == Constants.PENDING_OUTSTATION || masterType == Constants.NONPENDING_ALL || masterType == Constants.PENDING_ALL)
        {
        	MasterUtil.populateTrackJobs(newMasterRow, data, id);
        }
        else if(masterType == Constants.ADMIN && id)
        {
        	var checkedEl = $(newMasterRow).find("input[elname='uadmin']:checked")[0];
        	GeneralUtil.enableDisableEl(checkedEl, 'userPermEl', 'td', true);
        	MasterUtil.populatePermissions(newMasterRow, data["PERMISSIONS"]);
        }
        
        $(newMasterRow).dialog({
            resizable : true,
            width : "50%",
            height : "auto",
            modal : true,
            buttons : {
                "Submit" : function(){
                	if(challan)
                	{
                		JobSheetUtil.printChallan(newMasterRow, data);
                		var dateEl = $(newMasterRow).find("input[elname='jsDate']")[0];
                		var details = [GeneralUtil.getDateTimeStamp(dateEl)];
                		MasterUtil.saveMasterRow(id, details, masterType);
                	}
                	else if(masterType == Constants.BASE_SHELL)
                	{
                		MasterUtil.modifySpareCy(newMasterRow, data, id);
                	}
                	else
                	{
                		MasterUtil.ValidateRow(newMasterRow, data, masterType, startIndex);
                	}
                    $(this).dialog("close");
                },
                "Cancel" : function(){
                    $(this).dialog("close");
                }
            }
        });
    }
    
    this.populatePermissions = function(row, data)
    {
    	if(!data)
    	{
    		return;
    	}
    	var permRow = $(row).find("tr[elname='userPermRow']")[0];
    	var insertBefore = $(row).find("tr[elname='addMorePerm']")[0];
    	for(var i=0; i<data.length; i++)
    	{
    		var clonedNode = GeneralUtil.cloneNode(permRow);
    		$(clonedNode).find('select').val(data[i][0]);
    		$(clonedNode).insertBefore(insertBefore);
    	}
    }
    
    this.populateTrackJobs = function(row, data, id)
    {
    	$(row).find("input[elname='jsid']").val(id);
    	var jobTrackRow = $(row).find("tr[elname='jobTrackRow']")[0];
    	for(var i=0; i<data.length; i++)
    	{
    		var newJobTrackRow = GeneralUtil.cloneNode(jobTrackRow);
    		newJobTrackRow = this.populateRow(newJobTrackRow, data[i]);
    		jobTrackRow.parentElement.appendChild(newJobTrackRow);
    	}
    }
    
    this.populateConstantTable = function(row, data)
    {
    	var totalData = [];
    	for(var i=0; i<data.length; i++)
    	{
    		totalData.push(data[i][0]);
    	}
    	this.populateMasterRow(row, totalData);
    	return [totalData];
    }
    
    this.modifySpareCy = function(row, data, bsId)
    {
    	var bsscid = $(row).find("td[elname='bsscid']").filter(function(index){
    		return index > 0;
    	});
    	var bsscpieces = $(row).find("input[elname='bsscpieces']").filter(function(index){
    		return index > 0;
    	});
    	var valid = true;
    	var bsScIdVal = [];
    	var bsScIdUpdatedVal = [];
    	var modified = false;
    	for(var i=0; i<bsscid.length; i++)
    	{
    		var el = bsscpieces[i];
    		var checkElsVal =[bsscid[i].value];
    		valid = ValidateUtil.checkValid(el, checkElsVal, valid);
    		if(checkElsVal[1] != 0)
    		{
    			modified = true;
    		}
    		checkElsVal[1] = Number(checkElsVal[1]);	//(Number(el.getAttribute("max"))-
    		bsScIdUpdatedVal.push(checkElsVal);
    	}
    	if(!valid)
    	{
    		throw new Error("Invalid inputs!");
    	}
    	if(modified)
    	{
    		bsScIdUpdatedVal.updateSpare = true;
    		MasterUtil.saveMasterRow(bsId, bsScIdUpdatedVal, Constants.SPARECYLINDER, Constants.BASE_SHELL);
    	}
    }
    
    this.populateBaseShellSpareCy = function(tableEl, data)
    {
    	var bsSpareRow = $(tableEl).find("tr[elname='bsSpareCyRow']")[0];
    	for(var i=0; i<data.length; i++)
    	{
    		var dataNode = data[i];
    		var row = GeneralUtil.cloneNode(bsSpareRow);
    		var cells = $(row).find("td");
    		for(var j=0; j<cells.length; j++)
    		{
    			if(cells[j].children.length > 0)
    			{
    				continue;
    			}
    			cells[j].innerHTML = dataNode[j];
    			cells[j].value = dataNode[j];
    		}
    		$(row).find("input[elname='bsscpieces']").val(dataNode["PIECES"]).attr("max", dataNode["PIECES"]);
    		$(bsSpareRow).parent().append(row);
    	}
    }
    
    this.addPartyMasterProcessRow = function(el, data)
    {
        data = data && data["PM_DATA"] ? data["PM_DATA"] : null; 
        //var row = document.getElementById("pmProcessRow");
        var i= 0;
        do
        {
            var clonedNode = GeneralUtil.addNewRow("pmProcessRow", el, true);
            //$(clonedNode).insertBefore(el);
            var dataLen = data ? data.length : 0;
            if(dataLen && data[i])
            {
                MasterUtil.populateMasterRow(clonedNode, data[i]);
                GeneralUtil.setElAttribute(clonedNode, "input", "pmProcessName", "ac", data[i]["PL_TYPE"]);
                GeneralUtil.setElAttribute(clonedNode, "input", "pmProcessName", "id", data[i]["PLID"]);
                GeneralUtil.setElAttribute(clonedNode, "input", "pmProcessName", "loadid", data[i]["PLID"]);
            }
            i++;
        }while(i<dataLen);
    }
    
    this.ValidateRow = function(masterRow, data, type, startIndex)
    {
        var valid = true;
        var checkEls = this.getTypeElsToCheck(masterRow, type);
        var checkElsVal = [];
        
        if(checkEls["pmProcessRows"])
        {
            checkElsVal["pmProcessRows"] = checkEls["pmProcessRows"];
        }
        else if(checkEls["pmProcessRows"] === false)
        {
            valid = false;
        }
        
        for(var i=1; i<checkEls.length; i++)    //1st el will always be the ID element
        {
            var el = checkEls[i];
            valid = ValidateUtil.checkValid(el, checkElsVal, valid);
        }
        
        if(checkEls.password)
        {
        	checkElsVal.password = [];
        	valid = ValidateUtil.checkValid(checkEls.password, checkElsVal.password, valid);
        }
        if(checkEls.permissions && checkEls.permissions.length >0)
        {
        	checkElsVal.permissions = MasterUtil.setPermissions(checkEls.permissions, data);
        }

        if (!valid) {
            throw new Error("Invalid inputs!");
        }
        var modified = MasterUtil.checkIfChangedFromDefault(masterRow, data, startIndex) || checkElsVal.permissions;
        if(modified)
        {
            if(modified instanceof Array)
            {
                checkElsVal["pmDeleteRows"] = modified;
            }
            var id = checkEls[0] ? checkEls[0].value : null; 
            MasterUtil.saveMasterRow(id, checkElsVal, type);
        }
    }
    
    this.getTypeElsToCheck = function(row, type)
    {
        var els = [];
        if(type == Constants.PROCESSMASTER)
        {
            var pId = $(row).find("input[elname='pid']")[0];
            var pname = $(row).find("input[elname='pname']")[0];
            var ptype = $(row).find("select[elname='ptype']")[0];
            var premarks = $(row).find("textarea")[0];
            els = [pId, pname, ptype, premarks];
        }
        else if(type == Constants.COLORMASTER)
        {
            var cId = $(row).find("input[elname='cid']")[0];
            var cname = $(row).find("input[elname='cname']")[0];
            var ctype = $(row).find("input[elname='ctype']")[0];
            var cremarks = $(row).find("textarea")[0];
            els = [cId, cname, ctype, cremarks];
        }
        else if(type == Constants.MATERIALMASTER)
        {
            var mId = $(row).find("input[elname='mid']")[0];
            var mname = $(row).find("input[elname='mname']")[0];
            var mtype = $(row).find("input[elname='mtype']")[0];
            var mremarks = $(row).find("textarea")[0];
            els = [mId, mname, mtype, mremarks];
        }
        else if(type == Constants.LESSMASTER)
        {
            var lId = $(row).find("input[elname='lid']")[0];
            var ltype = $(row).find("input[elname='ltype']")[0];
            var lremarks = $(row).find("textarea")[0];
            els = [lId, ltype, lremarks];
        }
        else if(type == Constants.OPMASTER)
        {
            var opId = $(row).find("input[elname='opid']")[0];
            var opname = $(row).find("input[elname='opname']")[0];
            els = [opId, opname];
        }
        else if(type == Constants.SPARECYLINDER)
        {
            var scId = $(row).find("input[elname='scid']")[0];
            var sclen = $(row).find("input[elname='sclen']")[0];
            var sccir = $(row).find("input[elname='sccir']")[0];
            var scpieces = $(row).find("input[elname='scpieces']")[0];
            var scplace = $(row).find("input[elname='scplace']")[0];
            var scremarks = $(row).find("textarea")[0];
            els = [scId, sclen, sccir, scpieces, scplace, scremarks];
        }
        else if(type == Constants.TOMMASTER)
        {
            var tomId = $(row).find("input[elname='tomid']")[0];
            var tomname = $(row).find("input[elname='tomname']")[0];
            var tomremarks = $(row).find("textarea")[0];
            els = [tomId, tomname, tomremarks];
        }
        else if(type == Constants.PARTYMASTER)
        {
            var pId = $(row).find("input[elname='pid']")[0];
            var pname = $(row).find("input[elname='pname']")[0];
            var pout = $(row).find("input[name='pout']:checked")[0];
            var pbore = $(row).find("input[elname='pbore']")[0];
            var pmProcessRows = MasterUtil.validatePMProcessRows(row);
            els = [pId, pname, pout, pbore];
            els["pmProcessRows"] = pmProcessRows;
        }
        else if(type == Constants.SHEET_CUTTING)
        {
        	var scRingSize = $(row).find("input[elname='scRingSize']")[0];
        	var scSheetLen = $(row).find("input[elname='scSheetLen']")[0];
        	var scSheetBr = $(row).find("input[elname='scSheetBr']")[0];
        	var scSheetThickness = $(row).find("input[elname='scSheetThick']")[0];
        	els = [0, scRingSize, scSheetBr, scSheetLen, scSheetThickness];
        }
        else if(type == Constants.COPPER_PLATING)
        {
        	var cpAmp = $(row).find("input[elname='cpAmp']")[0];
        	var cpAmpCd = $(row).find("input[elname='cpAmpCd']")[0];
        	var tempTag = document.createElement("p");
        	tempTag.value = 1001;
        	els = [tempTag, cpAmp, cpAmpCd];
        }
        else if(type == Constants.CHROME_PLATING)
        {
        	var chromePlateAmp = $(row).find("input[elname='chromePlateAmp']")[0];
        	var tempTag = document.createElement("p");
        	tempTag.value = 1001;
        	els = [tempTag, chromePlateAmp];
        }
        else if(type == Constants.COPPER_TANK)
        {
        	var tankId = $(row).find("div[elname='ctTankId']")[0];
        	var shaftId = $(row).find("div[elname='ctShaftId']")[0];
        	els = [tankId, shaftId];
        	$(row).find("select[elname='cySpecs']").filter(function(){
        		return ($(this).closest("tr").attr("keep") != "true");
        	}).each(function(){
        		els.push(this);
        	});
        }
        else if(type == Constants.ADMIN)
        {
        	var uid = $(row).find("input[elname='uid']")[0];
        	var uname = $(row).find("input[elname='uname']")[0];
        	var upass = $(row).find("input[elname='upass']")[0];
        	var uadmin = $(row).find("input[elname='uadmin']:checked")[0];
        	els = [uid, uname, uadmin];
        	if(upass.value)
        	{
        		els.password = upass;
        	}
        	els.permissions = [];
        	$(row).find("select[elname='userPerm']").filter(function(){
        		return ($(this).closest("tr").attr("keep") != "true" && $(this).closest("td[elname='userPermEl']").hasClass("not-active") == false);
        	}).each(function(){
        		els.permissions.push(this.value);
        	});
        }
        else if(type == Constants.ISP)
        {
        	var ispid = $(row).find("input[elname='ispid']")[0];
        	var ispname = $(row).find("input[elname='ispname']")[0];
        	var isp = $(row).find("input[elname='isp']")[0];
        	els = [ispid, ispname, isp];
        }
        return els;
    }
    
    this.setPermissions = function(newPermissions, data)
    {
    	var oldPermissions = data ? data["PERMISSIONS"] : [];
    	newPermissions.sort();
    	oldPermissions.sort();
    	var len = newPermissions.length > oldPermissions.length ? newPermissions.length : oldPermissions.length;
    	var updatedPerm = [];
    	var deletedPerm = [];
    	for(var i=0; i<len; i++)
    	{
    		if(newPermissions[i] && oldPermissions[i] && newPermissions[i] == oldPermissions[i][0])
    		{
    			continue;
    		}
    		else if(newPermissions[i] && oldPermissions[i] && newPermissions[i] != oldPermissions[i][0])
    		{
    			updatedPerm.push(newPermissions[i]);
    			deletedPerm.push(oldPermissions[i][0]);
    		}
    		else if(newPermissions[i] && !oldPermissions[i])
    		{
    			updatedPerm.push(newPermissions[i]);
    		}
    		else if(!newPermissions[i] && oldPermissions[i])
    		{
    			deletedPerm.push(oldPermissions[i][0]);
    		}
    	}
    	return updatedPerm.length > 0 || deletedPerm.length > 0 ? [updatedPerm, deletedPerm] : null;
    }
    
    this.validatePMProcessRows = function(row)
    {
        var valid = true;
        var pmProcessRows = $(row).find("tr[elname='pmProcessRow']");
        var pmProcessRowsVal = [];
        for(var i=1; i<pmProcessRows.length; i++)  //1st one is the orig one which we are cloning
        {
            var pmProcessRowVal = [];
            var pmProcessRow = pmProcessRows[i];
            
            var pmProcessType = $(pmProcessRow).find("select[elname='pmProcessType']")[0].value;
            var pmProcessName = $(pmProcessRow).find("input[elname='pmProcessName']")[0];
            var pmProcessRate = $(pmProcessRow).find("input[elname='pmProcessRate']")[0];
            var pmProcessRateType = $(pmProcessRow).find("select[elname='pmProcessRateType']")[0].value;

            valid = GeneralUtil.checkAndSetValidationError(pmProcessName.parentElement, pmProcessName.getAttribute("id"), 1, valid);
            valid = GeneralUtil.checkAndSetValidationError(pmProcessRate.parentElement, pmProcessRate.value, 1, valid);
            pmProcessRowVal = [pmProcessType, pmProcessName.getAttribute("id"), pmProcessRate.value, pmProcessRateType, pmProcessName.getAttribute("loadid")];
            pmProcessRowsVal.push(pmProcessRowVal);
        }
        if(!valid)
        {
            return false;
        }
        return pmProcessRowsVal.length>0 ? pmProcessRowsVal : false;
    }
    
    this.getPMIDForDelete = function(rows, data)
    {
        var length = data.length;
        var deleteIDs = [];
        for(var i=0, j=1; i<length; i++, j++)   //i is for Data, j for Rows
        {
            var plId, plType;
            var pmData = data[i];
            var pmRow = rows[j];
            
            if(pmData && pmRow)
            {
                plId = $(pmRow).find("input[elname='pmProcessName']").attr("id");
                plType = $(pmRow).find("select[elname='pmProcessType']").val();
                if(plId == pmData["PLID"] && plType == pmData["PL_TYPE"])
                {
                    continue;
                }
                else
                {
                    plId = pmData["PLID"];
                    plType = pmData["PL_TYPE"];
                    j--;
                }
            }
            else if(!pmRow)
            {
                plId = pmData["PLID"];
                plType = pmData["PL_TYPE"];
            }
            if(plId && plType)
            {
                deleteIDs.push([plId, plType]);
            }
        }
        return deleteIDs;
    }
    
    this.checkIfChangedFromDefault = function(row, data, startIndex)
    {
        if(!data)
        {
            return true;
        }
        if(data && data["PM_DATA"])
        {
            var pmData = data["PM_DATA"];
            var pmRows = $(row).find("tr[elname='pmProcessRow']");
            if(pmRows.length-1 < pmData.length)
            {
                return this.getPMIDForDelete(pmRows, pmData);
            }
            for(var i=1; i<pmRows.length; i++)
            {
                if(!pmData[i-1] || this.checkIfChangedFromDefault(pmRows[i], [pmData[i-1]]))
                {
                    return true;
                }
            }
            row = $(row).find("table")[0];
        }
        data = data[0];
        var inputCells = $(row).find(".form-control");
        startIndex = (!startIndex && startIndex != 0) ? 1 : startIndex;
        for(var i=startIndex, k=startIndex; i<inputCells.length; i++, k++)
        {
            var val = inputCells[i].value;
            var formData = data[k];
            
            if(((inputCells[i].tagName == "INPUT" && (inputCells[i].type == "text" || inputCells[i].type == "number")) || inputCells[i].tagName == "TEXTAREA" || inputCells[i].tagName == "SELECT"))
            {
                if(val != formData)
                {
                   return true;
                }
            }
            else
            {
                var name = inputCells[i].name;
                while(inputCells[i].name == name)
                {
                    if(inputCells[i].checked && inputCells[i].value != formData)
                    {
                        return true;
                    }
                    
                    if(inputCells[i+1] && inputCells[i+1].name == name)
                    {
                        i++;
                    }
                    else
                    {
                        break;
                    }
                }
            }
            
        }
        return false;
    }
    
    this.saveMasterRow = function(masterId, details, type, refreshType)
    {
        var params = {};
        var data = {};
        data["details"] = JSON.stringify(details);
        data["type"] = type;
        
        if(refreshType)
        {
        	data["refreshType"] = refreshType;
        }
        
        if(details.pmProcessRows)
        {
            data["pmProcessRows"] = JSON.stringify(details.pmProcessRows);
        }
        if(details.pmDeleteRows)
        {
            data["pmDeleteRows"] = JSON.stringify(details.pmDeleteRows);
        }
        if(details.updateSpare)
        {
        	data["updateSpare"] = true;
        }
        if(details.setUrgent)
        {
        	data["setUrgent"] = true;
        	data["urgentVal"] = details.urgent;
        }
        if(details.opData)
        {
        	data["opData"] = JSON.stringify(details.opData);
        }
        if(details.reProcessData)
        {
        	data["reProcessData"] = JSON.stringify(details.reProcessData);
        }
        if(details.password)
        {
        	data["upass"] = details.password[0];
        }
        if(details.permissions)
        {
        	data["permissions"] = JSON.stringify(details.permissions);
        }
        
        if(masterId)
        {
            data["id"] = masterId;
        }
        params["url"] = "php/addMasterData.php";
        this.getCommonMasterParams(params, data);
        LoadUtil.sendAjaxRequest(params);
    }
    
    this.handleError = function(xhr, status, error)
    {
        alert(error.message);
    }
    
    this.deleteMasterRows = function()
    {
        $(function(){
            var rows = $("#container").find("input[elname='deleteRow']").filter(function(){
                return (this).checked;
            });
            if(rows.length <= 0)
            {
                return;
            }
            var ids = [];
            for(var i=0; i<rows.length; i++)
            {
                ids.push(rows[i].value);
            }
            var masterType = $("#container").attr("masterType");
            MasterUtil.deleteRows(ids, masterType);
        });
    }
    
    this.deleteRows = function(ids, type)
    {
        var data = {};
        var params = {};
        data["details"] = JSON.stringify(ids);
        data["type"] = type;
        params["url"] = "php/deleteMasterData.php";
        this.getCommonMasterParams(params, data);
        LoadUtil.sendAjaxRequest(params);
    }
    
    this.getCommonMasterParams = function(params, data)
    {
        params["data"] = data;
        params["type"] = "GET";
        params["dataType"] = "json";
        params["success"] = this.handleMasterData;
        params["error"] = this.handleError;
    }
    
    this.fetchRowData = function(el, id, fetchNormal, challan)
    {
        id = id ? id : el ? el.value : null;
        var type = document.getElementById("container").getAttribute("masterType");
        var params = {};
        var data = {};
        data["type"] = type;
        if(id)
        {
        	data["id"] = id;
        }
        if(challan)
        {
        	data["challan"] = true;
        }
        if(type == Constants.COPPER_TANK)
        {
        	var shaftId = el.value ? el.value : el.getAttribute("value");
        	data["shaftId"] = shaftId;
        }
        this.getCommonMasterParams(params, data);
        params["url"] = "php/fetchdata.php";
        
        if((type == Constants.JOBSHEET || type == Constants.NONPENDING_LOCAL  || type == Constants.NONPENDING_OUTSTATION || type == Constants.PENDING_LOCAL || type == Constants.PENDING_OUTSTATION  || type == Constants.NONPENDING_ALL || type == Constants.PENDING_ALL) && !fetchNormal)
        {
        	params = JobSheetUtil.setJobSheetParams(params);
        }
        
        LoadUtil.sendAjaxRequest(params);
    }
}