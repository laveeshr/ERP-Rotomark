var JobSheetUtil = new function()
{
    this.initializeDatePicker = function(el)
    {
        $(function(){
            var date = new Date();
            var currentDate = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
            $(el).datepicker();
        });
        
    }
    
    this.autoFillPartyMasterEls = function(id)
    {
        var data = {};
        var params = {};
        data["type"] = Constants.PARTYMASTER;
        data["id"] = id;
        MasterUtil.getCommonMasterParams(params, data);
        params["success"] = this.autoFillData;
        params["url"] = "php/fetchdata.php";
        LoadUtil.sendAjaxRequest(params);
    }
    
    this.autoFillData = function(resp)
    {
        var type = resp["type"];
        var data = resp["data"];
        var id = resp["id"];
        if(type == Constants.PARTYMASTER)
        {
            var pmData = data["PM_DATA"];
            var boreDetails = data[0]["BORE"];
            var processIds = [];
            var lessIds = [];
            for(var i=0; i<pmData.length; i++)
            {
                var plType = pmData[i]["PL_TYPE"];
                var pId = pmData[i]["PLID"];
                if(plType == Constants.PROCESSMASTER)
                {
                    processIds.push(pId);
                }
                else if(plType == Constants.LESSMASTER)
                {
                    lessIds.push(pId);
                }
            }
            if(boreDetails)
            {
                $("#container").find("strong[elname='jsBoreDetails']").html(boreDetails);
            }
            if(processIds)
            {
            	AutoCompleteUtil.setAllowedVals('processName', processIds);
                //$("#container").find("input[elname='processName']").data("allowedVals", processIds);
            }
            if(lessIds)
            {
            	AutoCompleteUtil.setAllowedVals('lessName', lessIds);
                //$("#container").find("input[elname='lessName']").data("allowedVals", lessIds);
            }
        }
    }
    
    this.autoCalcData = function(el, source, target, opVal, printCylSize)
    {
        var parEl = $(el).closest('.table-inline')[0];
        var totalVal = 0;
        for(var i=0; i<source.length; i++)
        {
            var elVal = $(parEl).find("input[elname='"+source[i]+"']").val();
            totalVal = this.calcVal(totalVal, elVal, opVal);
        }
        
        for(var i=0; i<target.length; i++)
        {
            $(parEl).find("input[elname='"+target[i]+"']").val(totalVal);
        }
        
        if(printCylSize)
        {
            this.printCylSize($("#container")[0]);
        }
    }
    
    this.calcVal = function(totalVal, elVal, opVal)
    {
        if(opVal == Constants.ADD)
        {
            totalVal = parseFloat(totalVal) + parseFloat(elVal);
        }
        else if(opVal == Constants.MUL)
        {
            totalVal = totalVal == 0 ? 1 : parseFloat(totalVal);
            totalVal = totalVal * parseFloat(elVal);
        }
        return totalVal.toFixed(2);
    }
    
    this.printCylSize = function(el)
    {
    	if(!(el instanceof HTMLElement))
    	{
    		el = $("#container")[0];
    	}
        var cw = $(el).find("input[elname='jsCylinderWid']").val();
        var cc = $(el).find("input[elname='jsCylCircumTotal']").val();
        var quantity = 0;
        $(el).find("input[elname='processQuantity']").each(function(){
        	quantity += Number($(this).val());
        });
        $(el).find("strong[elname='jsCylinderSize']").html(cw+" X "+cc+" X "+quantity);
    }
    
    this.deleteProcessEl = function(el)
	{
		GeneralUtil.deleteEl(el, 'jsProcessRow');
		this.printCylSize();
	}
    
    this.submitJobSheet = function()
    {
    	var data = $("#container").data("jsDataObject");
    	var modified = true;
    	var els = $("#container").find(".form-control").filter(function(){
    		return $(this).closest("tr").attr("keep") != "true" && $(this).closest("div[elname='processColorLessTables']").length == 0;
    	});
    	var cleared = $("#container").find("input[elname='jsCleared']")[0];
        els.push(cleared);
        var completed = $("#container").find("input[elname='jsCompleted']")[0];
    	els.push(completed);
    	
    	var elsVal = [], jsProcessVal = [], jsColorVal = [], jsLessVal = [];
    	var valid = true;
    	for(var i=0; i<els.length; i++)
    	{
    		var el = els[i];
            valid = ValidateUtil.checkValid(el, elsVal, valid, true);
    	}
    	
    	var jsProcElNames = [["processName","processQuantity"], "colorName", ["lessName", "lessPieces"]];
    	var selectors = ["jsProcessRow","jsColorRow","jsLessRow"];
    	var selectorVals = [jsProcessVal, jsColorVal, jsLessVal];
    	for(var i=0; i<selectors.length; i++)
    	{
    		// selectors[i] instanceof Array ? ("input[elname='"+selectors[i][0]+"'],input[elname='"+selectors[i][1]+"']") : ("input[elname='"+selectors[i]+"']");
	    	var selector = "tr[elname='"+selectors[i]+"']";
	    	var jsEls = $("#container").find(selector).filter(function(){
	    		return $(this).closest("tr").attr("keep") != "true" && $(this).attr("keep") != "true";
	    	});
	    	for(var j=0; j<jsEls.length; j++)
	    	{
	    		var rowEl = jsEls[j];
	    		var selectorName = jsProcElNames[i] instanceof Array ? "input[elname='"+jsProcElNames[i][0]+"']" : "input[elname='"+jsProcElNames[i]+"']";
	    		var selectorQuantity = jsProcElNames[i] instanceof Array ? "input[elname='"+jsProcElNames[i][1]+"']" : null;
	    		
	    		if(selectorQuantity)
	    		{
	    			var elName = $(rowEl).find(selectorName)[0];
	    			var elNameId = elName.getAttribute("id");
		    		var elVals = [elNameId];
		    		valid = ValidateUtil.checkValid(elName, elVals, valid);
	    			var elQuantity = $(rowEl).find(selectorQuantity)[0];
	    			valid = ValidateUtil.checkValid(elQuantity, elVals, valid);
	    			elVals.loadid = (elName.getAttribute("loadid"));
	    			if(elNameId)
	    			{
	    				selectorVals[i].push(elVals);
	    			}
	    		}
	    		else 
	    		{
	    			var elName = $(rowEl).find(selectorName);
	    			var elVals = [];
	    			if(elName[0].getAttribute("id"))
	    			{
	    				elVals = [elName[0].getAttribute("id")];
			    		valid = ValidateUtil.checkValid(elName[0], elVals, valid);
			    		elVals.loadid = (elName[0].getAttribute("loadid"));
			    		selectorVals[i].push(elVals);
	    			}
		    		if(elName[1].getAttribute("id"))
		    		{
		    			elVals = [elName[1].getAttribute("id")];
		    			valid = ValidateUtil.checkValid(elName[1], elVals, valid);
		    			elVals.loadid = (elName[1].getAttribute("loadid"));
		    			selectorVals[i].push(elVals);
		    		}
	    		}
	    	}
    	}
    	
    	if (!valid) {
            throw new Error("Invalid inputs!");
        }
        
        if(data)
        {
        	var jsData = data["jsData"][0];
	    	var jsProcesses = data["jsProcess"];
	    	var jsColors = data["jsColor"];
	    	var jsLess = data["jsLess"];
	    	var id = elsVal[0];
			elsVal = !GeneralUtil.checkModified(elsVal, jsData) ? null : elsVal;
			jsProcessVal = !GeneralUtil.checkModified(jsProcessVal, jsProcesses) ? null : jsProcessVal;
			jsColorVal = !GeneralUtil.checkModified(jsColorVal, jsColors) ? null : jsColorVal;
			jsLessVal = !GeneralUtil.checkModified(jsLessVal, jsLess) ? null : jsLessVal;
			modified = elsVal || jsProcessVal || jsColorVal || jsLessVal;
        }
        if(modified)
        {
        	if(jsProcessVal)
        	{
        		jsProcessVal.deleteIds = this.checkDeleted(jsProcessVal, jsProcesses);
        	}
        	if(jsColorVal)
        	{
        		jsColorVal.deleteIds = this.checkDeleted(jsColorVal, jsColors);
        	}
        	if(jsLessVal)
        	{
        		jsLessVal.deleteIds = this.checkDeleted(jsLessVal, jsLess);
        	}
        	this.parseAndSaveJS(elsVal, this.pruneDataForStore(jsProcessVal), this.pruneDataForStore(jsColorVal), this.pruneDataForStore(jsLessVal), id);
        }
    }
    
    this.checkDeleted = function(newData, oldData)
    {
    	if(!newData || !oldData || (newData.length >= oldData.length))
    	{
    		return false;
    	}
    	var deleteIds = [];
    	for(var i=0, j=0; i<oldData.length; i++, j++)
    	{
    		if(newData[j] && newData[j][0] != oldData[i][0])
    		{
    			deleteIds.push(oldData[i][0]);
    			j--;
    		}
    		else if(!newData[j])
    		{
    			deleteIds.push(oldData[i][0]);
    		}
    	}
    	return deleteIds;
    }
    
    this.pruneDataForStore = function(dataArr)
    {
    	if(!dataArr)
    	{
    		return;
    	}
    	for(var i=0; i<dataArr.length; i++)
    	{
    		dataArr[i].splice(1,1);	//Remove the array el that contains name then pass to server for storing
    		dataArr[i].push(dataArr[i].loadid) ;
    	}
    	return dataArr;
    }
    
    this.addJobSheet = function(type)
    {
    	LoadUtil.loadHtmlFile("addJobSheet.html", true);
    	MasterUtil.showHideMasterTable(true, false);
    }
    
    this.parseAndSaveJS = function(jsData, jsProcessList, jsColorsList, jsLessList, id)
    {
    	var id = jsData ? jsData.splice(0,1)[0] : id;
    	var params = {};
    	var data = {};
    	data["type"] = Constants.JOBSHEET;
    	if(jsData)
    	{
    		data["details"] = JSON.stringify(jsData);
    	}
    	if(jsProcessList && jsProcessList.length > 0)
    	{
    		data["jsProcesses"] = JSON.stringify(jsProcessList);
    	}
    	if(jsProcessList && jsProcessList.deleteIds)
    	{
    		data["jsDeleteProcesses"] = JSON.stringify(jsProcessList.deleteIds);
    	}
    	if(jsColorsList && jsColorsList.length > 0)
    	{
    		data["jsColors"] = JSON.stringify(jsColorsList);
    	}
    	if(jsColorsList && jsColorsList.deleteIds)
    	{
    		data["jsDeleteColors"] = JSON.stringify(jsColorsList.deleteIds);
    	}
    	if(jsLessList && jsLessList.length > 0)
    	{
    		data["jsLess"] = JSON.stringify(jsLessList);
    	}
    	if(jsLessList && jsLessList.deleteIds)
    	{
    		data["jsDeleteLess"] = JSON.stringify(jsLessList.deleteIds);
    	}
    	if(id)
        {
        	data["id"] = id;
        }
        MasterUtil.getCommonMasterParams(params, data);
        params["url"] = "php/addJobSheet.php";
        LoadUtil.loadJSONResp('jobsheet.html');
        LoadUtil.sendAjaxRequest(params);
    }
    
    this.setJobSheetParams = function(params)
    {
    	params["url"] = "php/fetchJobSheet.php";
    	params["success"] = JobSheetUtil.handleData;
    	return params;
    }
    
    this.handleData = function(resp)
    {
    	var type = resp["type"];
        var data = resp["data"];
        var id = resp["id"];
        LoadUtil.loadAndSetHtmlFile("addJobSheet.html", type, data);
    }
    
    this.populateJobSheet = function(data, jsEl)
    {
    	$(jsEl).data("jsDataObject",data);
    	var jsData = data["jsData"][0];
    	var jsProcesses = data["jsProcess"];
    	var jsColors = data["jsColor"];
    	var jsLess = data["jsLess"];
    	
    	this.populateJobSheetData(jsData, jsEl);
    	JobSheetUtil.autoFillPartyMasterEls(jsData["PARTY_ID"]);
    	if(jsProcesses.length > 0)
    	{
    		var inserBeforeEl = $(jsEl).find("tr[elname='addjsProcessRow']")[0];
    		this.populateJSProcesses(jsProcesses, jsEl, "jsProcessRow", inserBeforeEl);
    	}
    	if(jsLess.length > 0)
    	{
    		var inserBeforeEl = $(jsEl).find("tr[elname='addjsLessRow']")[0];
    		this.populateJSProcesses(jsLess, jsEl, "jsLessRow", inserBeforeEl);
    	}
    	if(jsColors.length > 0)
    	{
    		var inserBeforeEl = $(jsEl).find("tr[elname='jsAddNewColor']")[0];
    		this.populateJSColors(jsColors, jsEl, "jsColorRow", inserBeforeEl);
    	}
    	this.printCylSize(jsEl[0]);
    }
    
    this.populateJSColors = function(jsColors, jsEl, cloneId, insertBeforeEl)
    {
    	var colorRow = $(jsEl).find("#"+cloneId)[0];
    	GeneralUtil.cleanTableData(colorRow);
    	for(var i=0; i<jsColors.length; i=i+2)
    	{
    		var color1 = jsColors[i];
    		var color2 = jsColors[i+1];
    		var newColorRowEl = GeneralUtil.cloneNode(colorRow);
    		var inputEls = $(newColorRowEl).find("input");
    		inputEls[0].setAttribute("id", color1["CID"]);
    		inputEls[0].setAttribute("loadid", color1["CID"]);
    		inputEls[0].value = color1["NAME"];
    		if(color2)
    		{
    			inputEls[1].setAttribute("id", color2["CID"]);
	    		inputEls[1].setAttribute("loadid", color2["CID"]);
	    		inputEls[1].value = color2["NAME"];
    		}
    		$(newColorRowEl).insertBefore(insertBeforeEl);
    	}
    }
    
    this.populateJSProcesses = function(jsProcesses, jsEl, cloneNodeId, insertBeforeEl)
    {
    	var processRow = $(jsEl).find("#"+cloneNodeId)[0];
    	GeneralUtil.cleanTableData(processRow);
    	for(var i=0; i<jsProcesses.length; i++)
    	{
    		var process = jsProcesses[i];
    		var newProcessRow = GeneralUtil.cloneNode(processRow);
    		var id = process[0];
    		var newProcessEls = $(newProcessRow).find("input");
    		newProcessEls[0].setAttribute("id", id);
    		newProcessEls[0].setAttribute("loadid", id);
    		for(var j=0; j<newProcessEls.length; j++)
    		{
    			newProcessEls[j].value = process[j+1];
    		}
    		$(newProcessRow).insertBefore(insertBeforeEl);
    	}
    }
    
    this.populateJobSheetData = function(data, jsEl)
    {
    	var els = $(jsEl).find(".form-control").filter(function(){
    		return $(this).closest("tr").attr("keep") != "true" && $(this).closest("div[elname='processColorLessTables']").length == 0;
    	});
    	els.push($(jsEl).find("input[elname='jsCleared']")[0]);
    	els.push($(jsEl).find("input[elname='jsCompleted']")[0]);
    	for(var i=0; i<els.length; i++)
    	{
    		var el = els[i];
    		var storeVal= data[i];
    		if(el.getAttribute("date") == "date")
    		{
    			var date = new Date(Number(data[i]));
    			GeneralUtil.setCurrentDate(el.parentElement, date);
    			date = GeneralUtil.getDate(date);
    			storeVal = null;
    		}
    		else if(el.getAttribute("elname") == "partyName")
    		{
    			el.setAttribute("id",data["PARTY_ID"]);
    			data[i] = data["PARTY_ID"];
    		}
    		else if(el.getAttribute("elname") == "materialName")
    		{
    			el.setAttribute("id",data["MAT_ID"]);
    			data[i] = data["MAT_ID"];
    		}
    		else if(el.getAttribute("elname") == "tomName")
    		{
    			el.setAttribute("id",data["TOM_ID"]);
    			data[i] = data["TOM_ID"];
    		}
    		else if(el.getAttribute("elname") == "jsCleared" || el.getAttribute("elname") == "jsCompleted")
    		{
    			el.checked = storeVal == 0 ? false : true;
    		}
    		if(storeVal)
    		{
    			el.value = storeVal;
    		}
    	}
    	var boreDetails = data["BORE"];
    	$(jsEl).find("strong[elname='jsBoreDetails']").html(boreDetails);
    }
    
    this.loadRequiredData = function(type, el)
    {
    	$(el).removeClass("btn-default").addClass("btn-active");
    	$(el).parent().find("button").filter(function(){
    		return this != el;
    	}).removeClass("btn-active").addClass("btn-default");
    	$("#container").attr("masterType", type);
    	if(type == Constants.NONPENDING_LOCAL || type == Constants.NONPENDING_OUTSTATION || type == Constants.NONPENDING_ALL)
    	{
    		$("#container").find("th[elname='trackHead']").html("Challan Print");
    		$("#container").find("button[elname='trackJob']").removeClass('glyphicon-search').addClass('glyphicon-list-alt').attr('onclick', 'MasterUtil.fetchRowData(this, null, true, true);');
    		$("#container").find("button[elname='dataSeparation'], button[elname='dataMerging'], button[elname='printChallanWise']").css("display", "");
    	}
    	else
    	{
    		$("#container").find("th[elname='trackHead']").html("Track Job");
    		$("#container").find("button[elname='trackJob']").removeClass('glyphicon-list-alt').addClass('glyphicon-search').attr('onclick', 'MasterUtil.fetchRowData(this, null, true);');
    		$("#container").find("button[elname='dataSeparation'], button[elname='dataMerging'], button[elname='printChallanWise']").css("display", "none");
    	}
    	var dateRangeApplied = GeneralUtil.applyDateRange();
    	if(!dateRangeApplied)
    	{
    		LoadUtil.refreshView(type);
    	}
    }
    
    this.populatePrintDiv = function(print, data, dateRange, subType)
    {
    	if(dateRange)
    	{
    		DepartmentUtil.populatePrintDate(print, dateRange);
    	}
    	var normalRow = $(print).find("tr[elname='printRow']")[0];
    	var summaryRow = $(print).find("tr[elname='summaryRow']")[0];
    	var gtRow = $(print).find("tr[elname='grandSummaryRow']")[0];
    	var gtSqInch = 0;
    	var gtQuant = 0;
    	GeneralUtil.cleanTableData(normalRow);
    	GeneralUtil.cleanTableData(summaryRow);
    	GeneralUtil.cleanTableData(gtRow);
    	for(var i=0; i<data.length; i++)
    	{
    		var dataNode = data[i];
    		var newNode = null;
    		if(dataNode[0] == -1)
    		{
    			newNode = GeneralUtil.cloneNode(summaryRow);
    			$(newNode).find("span[elname='pName']").html(dataNode["PARTY_NAME"]);
    			$(newNode).find("span[elname='totalQuant']").html(dataNode["QUANTITY"]);
    			$(newNode).find("span[elname='totalSqInch']").html(dataNode["INCH"]);
    			gtQuant += Number(dataNode["QUANTITY"]);
    			gtSqInch += Number(dataNode["INCH"]);
    		}
    		else
    		{
    			newNode = GeneralUtil.cloneNode(normalRow);
    			newNode = MasterUtil.populateRow(newNode, dataNode);
    		}
    		normalRow.parentElement.appendChild(newNode);
    	}
    	if(subType && subType != Constants.PRINT_DATEWISE)
    	{
    		newNode = GeneralUtil.cloneNode(gtRow);
	    	$(newNode).find("span[elname='gtSqInch']").html(gtSqInch.toFixed(2));
	    	$(newNode).find("span[elname='gtQuant']").html(gtQuant);
	    	normalRow.parentElement.appendChild(newNode);
    	}
    }
    
    this.populateChallan = function(row, data, date, amountReqd)
    {
    	row = GeneralUtil.cloneNode(document.getElementById("printChallan"));
    	//$(row).find("table[elname='challanJobTable']").css({'height':($(window).height() - 100)+'px'});
    	$(row).find("span[elname='partyName']").html(data[0]["PARTY_NAME"]);
    	$(row).find("span[elname='jobName']").html(data[0]["JOB_NAME"]);
    	$(row).find("span[elname='challanRemarks']").html(data[0]["REMARKS"]);
    	$(row).find("span[elname='jobId']").html(data[0]["ID"]);
    	$(row).find("span[elname='date']").html(date);
    	var totalQuant=0, totalRate=0, colors = [];
    	var oldChallanRow =$(row).find("div[elname='challanRow']")[0];
    	var summaryRow = $(row).find("div[elname='summaryRow']");
    	var cySize = (data[0]["SIZE"]);
    	//var rowHeight = ($(window).height()*2/3)/data.length;
    	for(var i=0; i<data.length; i++)
    	{
    		if(data[i]["TOTAL_RATE"])
    		{
    			var challanRow = GeneralUtil.cloneNode(oldChallanRow);
	    		$(challanRow).find("div[elname='procName']").html(data[i]["PROCESS_NAME"]);	//css("height", rowHeight+"px").
	    		$(challanRow).find("div[elname='procQuant']").html(data[i]["QUANTITY"]);
	    		if(amountReqd)
	    		{
	    			$(challanRow).find("div[elname='procRate']").html(data[i]["PER_RATE"]);
	    			$(challanRow).find("div[elname='totalRate']").html(data[i]["TOTAL_RATE"]);
	    		}
	    		$(challanRow).insertBefore(summaryRow);
	    		if(data[i]["PER_RATE"] > 0)
	    		{
	    			totalQuant += Number(data[i]["QUANTITY"]);
	    		}
	    		totalRate += Number(data[i]["TOTAL_RATE"]);
    		}
    		else
    		{
    			colors.push(data[i]["PARTY_NAME"]);
    		}
    	}
    	cySize = cySize + totalQuant;
    	$(row).find("span[elname='cySize']").html(cySize);
    	$(summaryRow).find("div[elname='procQuant']").html(totalQuant);
    	$(row).find("span[elname='challanColors']").html(colors.join());
    	if(amountReqd)
    	{
    		$(summaryRow).find("div[elname='totalRate']").html("Rs. "+GeneralUtil.formatNumberInINR(totalRate.toFixed(0)));
    	}
    	return row;
    }
    
    this.printChallan = function(row, data)
    {
    	var date = GeneralUtil.getDate($(row).find("input[elname='jsDate']").datepicker( "getDate" ));
    	var amountReqd = $(row).find("input[elname='billType']:checked").val();
    	row = this.populateChallan(row, data, date, Number(amountReqd));
    	GeneralUtil.printDiv(row);
    }
    
    this.separateData = function(separateData, el)
    {
    	var dateRange = GeneralUtil.getDateRange();
    	dateRange = !dateRange ? [1, 2000000000000] : dateRange;
    	var type = $("#container").attr("masterType");
    	var data = {};
    	
    	if(separateData)
    	{
    		data["separate"] = separateData;
    	}
    	var params = MasterUtil.getParams(type, dateRange, data);
    	params['url'] = "php/separateMergeData.php";
        // if(el)
    	// {
    		// var file_data = $(el).prop('files')[0];   
		    // data = new FormData();                  
		    // data.append('file', file_data);
		    // params["data"] = data;
		    // params["cache"] = false;
		    // params["processData"] = false;
		    // params["contentType"] = false;
		    // params["type"] = "POST";
    	// }
        LoadUtil.sendAjaxRequest(params);
    }
    
    this.clearProcesses = function(el, clearData)
    {
    	var parentEl = $(el).closest(".jobsheet");
    	for(var i=0; i<clearData.length; i++)
    	{
    		var cleanEl = $(parentEl).find("tr[elname='"+clearData[i]+"']")[0];
    		GeneralUtil.cleanTableData(cleanEl);
    		var newRow = GeneralUtil.addNewRow(clearData[i], $(parentEl).find("tr[elname='add"+clearData[i]+"']")[0]);
    		$(newRow).find("input[setRequired='true']").attr("required", true).removeAttr("setRequired");
    	}
    }
}