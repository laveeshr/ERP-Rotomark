var DepartmentUtil = new function()
{
	this.submitDepartment = function()
	{
		var type = $("#container").attr("masterType");
		var jsData = [];
		var sendType = Number(type)+1;
		this.getCompletedData(jsData, type);
		// if(type == Constants.COPPER_PLATING)
		// {
			// sendType = Constants.COPPER_TANK;
		// }
		// else if(type == Constants.COPPER_TANK)
		// {
			// sendType = Constants.COPPER_CUT;
		// }
		MasterUtil.saveMasterRow(null, jsData, sendType, type);
	}
	
	this.getCompletedData = function(jsData, type)
	{
		var elNames = this.getElnamesBasedOnDept(type);
		var deptId = elNames[0];
		var opData = [];
		var reProcess = {};
		jsData.operator = elNames.operator ? true : false;
		$("#container").find("input[elname='submitRow']").filter(function(){
			return this.checked;
			}).each(function(){
				var addReProcessData = true;
				var bsData = [];
				var parentEl = $(this).closest("tr");
				var bsId = $(parentEl).find("td[elname="+deptId+"]").val();
				if(elNames.jsId)
				{
					bsData.push($(parentEl).find("td[elname="+elNames.jsId+"]").val());
				}
				// if(elNames.tankId)
				// {
					// bsData.push($(parentEl).find("td[elname="+deptId+"]").attr("tankid"));
				// }
				bsData.push(bsId);
				if(jsData.operator)
				{
					var opId = $(parentEl).find("input[elname='opId']").attr("id");
					var opDeptIdEl = $(parentEl).find("input[elname='radioSubmitRow']:checked");
					var opDeptId = opDeptIdEl.val();
					opDeptId = opDeptId ? opDeptId : deptId;
					opData.push([opId, opDeptId]);
					if(opDeptIdEl.attr("reprocess") && !$(parentEl).find("select[elname='reProcess']").val())
					{
						elNames.reProcess = true;
						$(parentEl).find("select[elname='reProcess']").val(opDeptIdEl.attr("reprocess"));
						addReProcessData = false;
					}
				}
				if(elNames.reProcess)
				{
					var reProcessState = $(parentEl).find("select[elname='reProcess']").val();
					if(reProcessState)
					{
						reProcess[bsId] = [type, reProcessState, addReProcessData];
					}
				}
				if(elNames.length > 1)
				{
					var valid = true;
					for(var i=1; i<elNames.length; i++)
					{
						var el = $(parentEl).find("input[elname='"+elNames[i]+"']")[0];
						valid = ValidateUtil.checkValid(el, bsData, valid, true);
					}
					if(!valid)
					{
						throw new Error("Invalid inputs!");
					}
				}
				jsData.push(bsData);
			});
			
			if(opData.length > 0)
			{
				jsData.opData = opData;
			}
			if(!jQuery.isEmptyObject(reProcess))
			{
				jsData.reProcessData = reProcess;
			}
	}
	
	this.getElnamesBasedOnDept = function(type)
	{
		var elNames = [];
		if(type == Constants.BASE_SHELL)
		{
			elNames = ['baseShellId'];
			elNames.jsId = 'bsid';
		}
		else if(type == Constants.ROUGH_TURNING)
		{
			elNames = ['rtid'];
			elNames.operator = true;
		}
		else if(type == Constants.FINAL_GRINDING)
		{
			elNames = ['fgid'];
			elNames.operator = true;
			elNames.reProcess = true;
		}
		else if(type == Constants.COPPER_PLATING)
		{
			elNames = ['cpid', 'cpBsActual', 'cpTankNo'];
			elNames.reProcess = true;
		}
		else if(type == Constants.COPPER_TANK)
		{
			elNames = ['ctShaft', 'ctVoltVal', 'ctTankTempVal', 'ctDoz401Val', 'ctDoz402Val', 'ctDozH2SO4Val', 'ctTimeInVal', 'ctTimeOutVal'];
			elNames.tankId = true;
		}
		else if(type == Constants.COPPER_CUT)
		{
			elNames = ['ccid'];
			elNames.operator = true;
			elNames.reProcess = true;
		}
		else if(type == Constants.COPPER_POLISH)
		{
			elNames = ['cpid', 'opId'];
			elNames.operator = true;
			elNames.reProcess = true;
		}
		else if(type == Constants.ENGRAVING)
		{
			elNames = ['egid', 'egColor', 'egTime', 'egStylus', 'egMachineNo', 'egHardness'];
			elNames.operator = true;
			elNames.reProcess = true;
		}
		else if(type == Constants.CHROME_PLATING)
		{
			elNames = ['cpid'];
			elNames.reProcess = true;
		}
		else if(type == Constants.CHROME_POLISH)
		{
			elNames = ['cpid'];
			elNames.operator = true;
			elNames.reProcess = true;
		}
		else if(type == Constants.PROOFING)
		{
			elNames = ['proofId'];
			elNames.operator = true;
			elNames.reProcess = true;
		}
		else if(type == Constants.DISPATCH)
		{
			elNames = ['dispatchId'];
			elNames.jsId = 'dispatchJsid';
		}
		return elNames;
	}
	
	this.markUrgent = function(el, markAllElName)
	{
		var type = $("#container").attr("masterType");
		var details = [];
		var deptIds = [];
		var urgent = $(el).attr("urgent");
		urgent = urgent == 0 ? 1 : 0;
		if(markAllElName)
		{
			$(el).attr("urgent", urgent);
			$("#container").find("td[elname='"+markAllElName+"']").each(function(){
				var deptId = this.value;
				if(deptId)
				{
					details.push(deptId);
				}
			});
		}
		else
		{
			var parentEl = $(el).closest("tr")[0];
			var deptId = $(parentEl).children().first().val();
			details = [deptId];
		}
		details["urgent"] = urgent;
		details.setUrgent = true;
		MasterUtil.saveMasterRow(null, details, type);
	}
	
	this.calculateCopperPlatingDetails = function(el)
	{
		var parentEl = $(el).closest("tr");
		var bsActualVal = $(el).val();
		if(!bsActualVal)
		{
			return;
		}
		var finalSize = Math.round(Number($(parentEl).find("td[elname='cpFinal']").val()));
		var cyLen = Math.round(Number($(parentEl).find("td[elname='cpLen']").val()));
		var cyCircum = Math.round(Number($(parentEl).find("td[elname='cpCyCircum']").val()));
		var cpSizeVal = Math.round(cyLen <= 800 ? finalSize + 0.1 : finalSize + 0.15);
		var cpLayerVal = Math.round((cpSizeVal - bsActualVal) * 1000);
		var timeVal = ((cpLayerVal * 45) / 6000).toFixed(2);
		var ampVal = Math.round(Number($(parentEl).find("td[elname='cpAmp']").val()));
		var totalAmpVal = timeVal * ampVal;
		var copperWtVal = Math.round((cyLen * cyCircum * cpLayerVal * 0.003)/645160);
		$(parentEl).find("td[elname='cpSize']").val(cpSizeVal).html(cpSizeVal);
		$(parentEl).find("td[elname='cpLayer']").val(cpLayerVal).html(cpLayerVal);
		$(parentEl).find("td[elname='cpTime']").val(timeVal).html(timeVal);
		$(parentEl).find("td[elname='cpTotalAmp']").val(totalAmpVal).html(totalAmpVal.toFixed(2));
		$(parentEl).find("td[elname='cpWeight']").val(copperWtVal).html(copperWtVal);
	}
	
	this.checkRow = function(el, elname)
	{
		var checkEl = $(el).closest("tr").find("input[elname='"+elname+"']")[0];
		checkEl.checked = true;
	}
	
	this.populateCopperTank = function(data)
	{
		var parentEl = $("#copperTankWise");
		var headerEl = $(parentEl).find("li[elname='copperTankRowHead']")[0];
		var bodyEl = $(parentEl).find("div[elname='copperTankRowBody']")[0];
		GeneralUtil.cleanTableData(headerEl, "li");
		GeneralUtil.cleanTableData(bodyEl, "div");
		for(var i=0; i<data.length; i++)
		{
			var tankId = data[i]["TANK_NO"];
			var prevTankId = data[i-1] ? data[i-1]["TANK_NO"] : null;
			if(tankId != prevTankId)
			{
				var newHead = GeneralUtil.cloneNode(headerEl);
				var newBody = GeneralUtil.cloneNode(bodyEl);
				$(newHead).find("a").attr("href","#ctTank"+tankId).val(tankId).html("Tank "+ tankId);
				$(newBody).attr("id", "ctTank"+tankId).find("td[elname='ctShaft']").attr("tankId", tankId);
				$(headerEl).parent().append(newHead);
				$(bodyEl).parent().append(newBody);
			}
			else
			{
				var newBody = $("#ctTank"+tankId)[0];
			}
			this.populateCopperTankShaft(newBody, data[i]);
		}
		$(function(){
			$("#copperTankWise").tabs().tabs("refresh");
		});
	}
	
	this.populateCopperTankShaft = function(row, data)
	{
		var insertBeforeEl = $(row).find("tr[elname='ctAddShaft']")[0];
		var newRow = this.addNewShaft("ctShaftRow", insertBeforeEl);
		if(data["SHAFT"])
		{
			newRow = MasterUtil.populateRow(newRow, data, 1);
		}
	}
	
	this.addNewShaft = function(id, el)
	{
		var shaftNo = $(el).closest("table").find("td[elname='ctShaft']").length;
		var elVals = {};
		elVals["ctShaft"] = shaftNo;
		return GeneralUtil.addNewRow(id, el, elVals, true);
	}
	
	this.populateAvailableCylinders = function(row, data, resp)
	{
		$(row).find("div[elname='ctTankId']").val(resp["id"]).html(resp["id"]);
		$(row).find("div[elname='ctShaftId']").val(resp["shaftId"]).html(resp["shaftId"]);
		for(var i=0; i<data.length; i++)
		{
			var optionEl = document.createElement("option");
			optionEl.value = data[i][0];
			optionEl.innerHTML = data[i][1];
			if(data[i]["SHAFT"])
			{
				var newCy = GeneralUtil.addNewRow('ctCylinders', $(row).find("tr[elname='ctAddCy']")[0], null, true);
				optionEl.setAttribute("selected", true);
				$(newCy).find("select").append(optionEl);
			}
			else
			{
				$(row).find("select[elname='cySpecs']").append(optionEl);
			}
		}
	}
	
	this.filterSelectData = function(el, elName)
	{
		var selectedVal = $(el).val();
		$(el).closest("table").find("select[elname='"+elName+"']").filter(function(){
			return this != el;
		}).each(function(){
			$(this).find("option[value='"+selectedVal+"']").remove();
		});
	}
	
	this.login = function(el)
	{
		var parEl = $(el).prev();
		var uname = $(parEl).find("input[elname='username']")[0];
		var pass = $(parEl).find("input[elname='password']")[0];
		var loginData = [];
		var valid = true;
		valid = ValidateUtil.checkValid(uname, loginData, valid);
		valid = ValidateUtil.checkValid(pass, loginData, valid);
		if(!valid)
		{
			throw new Error("Invalid inputs!");
		}
		var params = {};
        var data = {};
        data["details"] = JSON.stringify(loginData);
        this.getParamsForLogin(params, data);
        LoadUtil.sendAjaxRequest(params);
	}
	
	this.getParamsForLogin = function(params, data)
	{
		params["url"] = "php/login.php";
        MasterUtil.getCommonMasterParams(params, data);
        params["type"] = "POST";
        params["success"] = this.checkLogin;
	}
	
	this.checkLogin = function(resp)
	{
		var data = resp["data"];
		if(data == Constants.IPERROR)
		{
			window.location.href = "../cardsforu/index.php";
		}
		else if(data == Constants.IPSUCCESS)
		{
			$("body").css("display", "");
		}
		else if(data == Constants.LOGINSUCCESS)
		{
			window.location.href = 'login.html';
		}
		else if(data == Constants.LOGINERROR)
		{
			alert("Login Failed!");
		}
	}
	
	this.checkIPStatus = function()
	{
		var params = {};
        var data = {};
        data["ip"] = true;
        this.getParamsForLogin(params, data);
        LoadUtil.sendAjaxRequest(params);
	}
	
	this.setPermissions = function()
	{
		var params = {};
        var data = {};
        data["setPerm"] = true;
        params["url"] = "php/login.php";
        params["type"] = "POST";
        params["data"] = data;
        params["dataType"] = "json";
        $("body").css("display", "none");
        params["success"] = this.setPermsForNavbar;
        LoadUtil.sendAjaxRequest(params);
	}
	
	this.setPermsForNavbar = function(resp)
	{
		var user = resp["user"];
		if(user == Constants.NOROWS)
		{
			window.location.href = "index.html";
			exit;
		}
		$("body").css("display", "");
		var admin = resp["admin"];
		var perms =  resp["perms"];
		if(Number(admin))
		{
			$(".noPerm").removeClass("noPerm");
		}
		else
		{
			for(var i=0; i<perms.length; i++)
			{
				$(".noPerm").filter(function(){
					return $(this).attr("type") == perms[i];
				}).removeClass("noPerm").closest("li.noPerm").removeClass("noPerm");
			}
		}
	}
	
	this.populatePrintDate = function(print, dateRange)
	{
		$(print).find("span[elname='dateFrom']").html(GeneralUtil.getDate(new Date(Number(dateRange[0]))));
    	$(print).find("span[elname='dateTo']").html(GeneralUtil.getDate(new Date(Number(dateRange[1])))).closest("div").css("display", "");
	}
	
	this.populatePrintDiv = function(print, data, dateRange, subType)
	{
		if(dateRange)
    	{
    		DepartmentUtil.populatePrintDate(print, dateRange);
    	}
    	var normalRow = $(print).find("tr[elname='printRow']")[0];
    	GeneralUtil.cleanTableData(normalRow);
    	for(var i=0; i<data.length; i++)
    	{
    		var dataNode = data[i];
    		var newNode = GeneralUtil.cloneNode(normalRow);
    		newNode = MasterUtil.populateRow(newNode, dataNode);
    		normalRow.parentElement.appendChild(newNode);
    	}
	}
}
