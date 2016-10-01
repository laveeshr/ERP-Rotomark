var GeneralUtil = new function()
{
    this.cleanTableData = function(el, tagName)
    {
    	tagName = !tagName ? 'tr' : tagName;
        $(function(){
            $(el).parent().find(tagName).filter(function(){
                return this != el && $(this).attr("keep") != "true";
            }).remove();
        });
    }
    
    this.checkAll = function(el, parentTagName, elName)
    {
    	elName = !elName ? "deleteRow" : elName;
        $(function(){
            var checked = el.getAttribute("checked");
            checked = checked == "true" ? false : true;
            el.setAttribute("checked", checked);
            $(el).closest(parentTagName).find("input[type='checkbox'][elname='"+elName+"']").filter(function(index){
                return index != 0 && (this.getAttribute("disabled") != "");
            }).prop("checked", checked);
        });
    }
    
    this.disableEl = function(el)
    {
        if(!(el instanceof HTMLElement))
        {
            el = document.getElementById(el);
        }
        if(el)
        {
        	el.setAttribute("disabled", true);
        	$(el).addClass("not-active");
        }
    }
    
    this.enableEl = function(el)
    {
        if(!(el instanceof HTMLElement))
        {
            el = document.getElementById(el);
        }
        if(el)
        {
        	el.removeAttribute("disabled");
        	$(el).removeClass("not-active");
        }
    }
   
    this.enableDisableEl = function(el, elName, tagName, inverse)
    {
    	var value = Number(el.value);
    	var targetEl = $(el).closest("table").find(tagName + "[elname='"+elName+"']")[0];
    	if((value && !inverse) || (!value && inverse))
    	{
    		this.enableEl(targetEl);
    	}
    	else
    	{
    		this.disableEl(targetEl);
    	}
    }
    
    this.enableElAfterSelection = function(el, elname)
    {
    	var parentEl = $(el).closest("tr");
    	el = $(parentEl).find("input[elname='"+elname+"']");
    	for(var i=0; i<el.length; i++)
    	{
    		this.enableEl(el[i]);
    	}
    }
    
    this.cloneNode = function(el, counter)
    {
    	counter = counter ? counter : "";
        var clonedNode = $(el).clone(true);
        $(clonedNode).removeAttr("keep").removeAttr("id").css("display", "");
        var radioEls = $(clonedNode).find("input[type='radio']");
        for(var i=0; i<radioEls.length; i++)
        {
            var radioEl = radioEls[i];
            var elname = $(radioEl).attr("elname");
            $(radioEl).attr("name", elname+""+counter);
        }
        return clonedNode[0];
    }
    
    this.deleteEl = function(el, parentElName)
    {
        $(function(){
           $(el).closest("tr[elname='"+parentElName+"']").remove(); 
        });
    }
    
    this.checkAndSetValidationError = function(parentEl, elVal, limit, isValid)
    { 
        if(!ValidateUtil.validateText(elVal, limit))
        {
            $(parentEl).addClass('form-group has-error');
            isValid = false;
        }
        else
        {
            $(parentEl).removeClass('has-error');
            //isValid = true;
        }
        return isValid;    
    }
    
    this.setElAttribute = function(el, selector, elname, attrName, attrVal)
    {
        $(el).find(selector+"[elname='"+elname+"']").attr(attrName, attrVal);
    }
    
    this.setCurrentDate = function(node, date, elname)
    {
    	var setDate = date ? date : "today";
    	var datePicker = elname ? $(node).find("input[elname='"+elname+"']") : $(node).find("#datePicker");
        datePicker.datepicker({
        	dateFormat: "dd-mm-yy",
        	changeMonth: true,
      		changeYear: true
        }).datepicker("setDate", setDate);
    }
    
    this.getAdvancedDate = function(el, advanceDays)
    {
    	var curDate = $(el).datepicker("getDate");
    	var newDate = new Date();
    	newDate.setDate(curDate.getDate()+Number(advanceDays));
    	return newDate.getTime();
    }
    
    this.addNewRow = function(id, el, elVals, elName)
    {
    	if(elName)
    	{
    		var row = $(el).closest("table").find("tr[elname='"+id+"']")[0];
    	}
    	else
    	{
    		var row = id instanceof HTMLElement ? id : document.getElementById(id);
    	}
    	var clonedNode = GeneralUtil.cloneNode(row);
    	if(elVals)
    	{
    		for(var elName in elVals)
    		{
    			var elVal = elVals[elName];
    			$(clonedNode).find("td[elname='"+elName+"']").val(elVal).html(elVal);
    		}
    	}
        $(clonedNode).insertBefore(el);
        return clonedNode;
    }
    
    this.appendNewEl = function(elName, tagName, insertBeforeEl)
    {
    	var el = $(insertBeforeEl).parent().find(tagName+"[elname='"+elName+"']")[0];
    	var clonedNode = GeneralUtil.cloneNode(el);
    	$(clonedNode).insertBefore(insertBeforeEl);
    	return clonedNode;
    }
    
    this.getDateTimeStamp = function(el)
    {
    	return (el && $(el).datepicker("getDate")) ? ($(el).datepicker("getDate").getTime()) : null;
    }
    
    this.getDate = function(date)
    {
    	return date.getDate()+'-'+(date.getMonth()+1)+'-'+(date.getFullYear().toString().substr(2,2));
    }
    
    this.checkModified = function(newData, oldData)
    {
    	var modified = false;
    	if(!newData || newData.length == 0)
    	{
    		return true;
    	}
    	for(var i=0; i<newData.length; i++)
    	{
    		if(newData[i] instanceof Array)
    		{
    			if(newData.length != oldData.length)
    			{
    				return true;
    			}
    			modified = this.checkModified(newData[i], oldData[i]);
    			if(modified)
    			{
    				return true;
    			}
    		}
    		else if(newData[i] != oldData[i])
    		{
    			return true;
    		}
    	}
    	return false;
    }
    
    this.getStateNameBasedOnId = function(stateId)
    {
    	switch(Number(stateId))
    	{
    		case Constants.BASE_SHELL : return "Base Shell";
    		break;
    		case Constants.SHEET_CUTTING : return "Sheet Cutting";
    		break;
    		case Constants.TIKAL_SIZE : return "Tikal Size";
    		break;
    		case Constants.ROUGH_TURNING : return "Rough Turning";
    		break;
    		case Constants.FINAL_GRINDING : return "Final Grinding";
    		break;
    		case Constants.COPPER_PLATING : return "Copper Plating";
    		break;
    		case Constants.COPPER_CUT : return "Copper Cut";
    		break;
    		case Constants.COPPER_POLISH : return "Copper Polish";
    		break;
    		case Constants.ENGRAVING : return "Engraving";
    		break;
    		case Constants.CHROME_PLATING : return "Chrome Plating";
    		break;
    		case Constants.CHROME_POLISH : return "Chrome Polish";
    		break;
    		case Constants.PROOFING : return "Proofing";
    		break;
    		case Constants.DISPATCH : return "Dispatch";
    		break;
    		case Constants.NONPENDING_LOCAL : return "Non Pending Local Jobs";
    		break;
    		case Constants.NONPENDING_OUTSTATION : return "Non Pending Outstation Jobs";
    		break;
    		case Constants.NONPENDING_ALL : return "All Non Pending Jobs";
    		break;
    		case Constants.PENDING_LOCAL : return "Pending Local Jobs";
    		break;
    		case Constants.PENDING_OUTSTATION : return "Pending Outstation Jobs";
    		break;
    		case Constants.PENDING_ALL : return "All Pending Jobs";
    		break;
    		case Constants.JOBSHEET : return "All Jobs";
    		break;
    		default : return stateId;
    		break;
    	}
    }
    
    this.checkSelectedFieldChangeFromDefault = function(oldFullData, newFullData, oldIndexes)
    {
    	if(oldFullData.length != newFullData.length)
    	{
    		return true;
    	}
    	for(var j=0; j<newFullData.length; j++)
    	{
    		var oldData = oldFullData[j];
    		var newData = newFullData[j];
    		for(var i=0; i<oldIndexes.length; i++)
	    	{
	    		if(oldData[oldIndexes[i]] != newData[oldIndexes[i]])
	    		{
	    			return true;
	    		}
	    	}
    	}
    	return false;
    }
    
    this.setDateRange = function(fromEl, toEl)
    {
    	fromEl = fromEl ? fromEl : $("#fromEl")[0];
    	toEl = toEl ? toEl : $("#toEl")[0];
    	$(function() {
    		var fromSelectedDate = null;
		    $(fromEl).datepicker({
		      dateFormat: "dd-mm-yy",
		      defaultDate : "today",
	          changeMonth: true,
	      	  changeYear: true,
		      numberOfMonths: 3,
		      onClose: function( selectedDate ) {
		        $(toEl).datepicker( "option", "minDate", selectedDate );
		        fromSelectedDate = selectedDate;
		        GeneralUtil.applyDateRange();
		      }
		    });
		    $(toEl).datepicker({
		      defaultDate: "today",
		      dateFormat: "dd-mm-yy",
        	  changeMonth: true,
      		  changeYear: true,
		      numberOfMonths: 3,
		      onClose: function( selectedDate ) {
		        $(fromEl).datepicker( "option", "maxDate", selectedDate );
		        GeneralUtil.applyDateRange();
		      }
		    });
		 });
    }
    
    this.setDateRangeEl = function(dateRange)
    {
    	if(dateRange)
    	{
    		$("#fromEl").datepicker("setDate", new Date(dateRange[0]));
    		$("#toEl").datepicker("setDate", new Date(dateRange[1]));
    	}
    }
    
    this.resetDateRange = function(refreshPage)
    {
    	var fromEl = $("#fromEl");
    	var toEl = $("#toEl");
    	var oldFromDate = $(fromEl).datepicker("getDate");
    	var oldToDate = $(toEl).datepicker("getDate");
    	$(fromEl).datepicker('setDate', null);
		$(toEl).datepicker('setDate', null);
		if(refreshPage && (oldFromDate || oldToDate))
		{
			LoadUtil.refreshView();
		}
	}
    
    this.applyDateRange = function()
    {
    	var dateRange = this.getDateRange();
    	if(dateRange)
    	{
    		LoadUtil.refreshView(null, dateRange);
    		return true;
    	}
    	return false;
    }
    
    this.getDateRange = function()
    {
    	var from = this.getDateTimeStamp(document.getElementById("fromEl"));
    	var to = this.getDateTimeStamp(document.getElementById("toEl"));
    	return (from && to) ? [from, to] : null;
    }
    
    this.handlePrintData = function(resp)
    {
    	var type = resp["type"];
        var data = resp["data"];
        var dateRange = resp["dateRange"];
        var subType = resp["subType"];
        var print = GeneralUtil.cloneNode(document.getElementById("print"));
        if(type == Constants.JOBSHEET || type == Constants.NONPENDING_LOCAL || type == Constants.NONPENDING_OUTSTATION || type == Constants.PENDING_LOCAL || type == Constants.PENDING_OUTSTATION || type == Constants.PENDING_ALL || type == Constants.NONPENDING_ALL)
        {
        	JobSheetUtil.populatePrintDiv(print, data, dateRange, subType);
        }
        else
        {
        	DepartmentUtil.populatePrintDiv(print, data, dateRange, subType);
        }
        $(print).find("h3[elname='printTitle']").html(GeneralUtil.getStateNameBasedOnId(type));
        GeneralUtil.printDiv(print);
    }
    
    this.printDiv = function(printEl)
    {
    	printEl.setAttribute("id", "print");
    	printEl.style.display = "";
    	printEl.style.visibility = "hidden";
    	$("#container").css("display", "none").parent().append(printEl);
         // $(printEl).css("visibility", "visible");
         // exit();
        window.print();
        $("#container").css("display", "");
        $(printEl).remove();
    }
    
    this.formatNumberInINR = function(x)
    {
    	//var x=12345652457.557;
		x=x.toString();
		var afterPoint = '';
		if(x.indexOf('.') > 0)
		   afterPoint = x.substring(x.indexOf('.'),x.length);
		x = Math.floor(x);
		x=x.toString();
		var lastThree = x.substring(x.length-3);
		var otherNumbers = x.substring(0,x.length-3);
		if(otherNumbers != '')
		    lastThree = ',' + lastThree;
		var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
		return res;
    }
}


