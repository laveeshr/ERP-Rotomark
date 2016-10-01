var ValidateUtil = new function()
{
    this.validateText = function(val, limit)
    {
        if(limit == 1 && (val == null))
        {
            return false;
        }
        var regex = new RegExp('^[A-Za-z0-9. ]|[\r\n]{'+limit+',20}$');
        return regex.test(val);
    }
    
    this.checkValid = function(el, checkElsVal, valid, autoCompIdOrVal)
    {
    	var requiredAttr = $(el).attr("required");
        var limit = 0;
        if (typeof requiredAttr !== typeof undefined && requiredAttr !== false) 
        {
            limit = 1;
        }
        var elVal = el ? el.value : null;
        if($(el).hasClass("hasDatepicker"))
        {
        	elVal = GeneralUtil.getDateTimeStamp(el);//($(el).datepicker("getDate").getTime());
        }
        else if(el.getAttribute("ac"))
        {
        	var autoCompVal = elVal;
        	elVal = el.getAttribute("id");	
        }
        else if(el.type == "checkbox")
		{
			elVal = el.checked ? 1 : 0;
		}
		else if(el.getAttribute("max") && Number(elVal) > Number(el.getAttribute("max")))
		{
			elVal = null;
			limit = 1;
		}
		
        var parentEl = $(el).closest("td");
        if(parentEl.length == 0)
        {
        	parentEl = $(el).parent();
        }
        valid = GeneralUtil.checkAndSetValidationError(parentEl, elVal, limit, valid);
        elVal = !autoCompIdOrVal && autoCompVal ? autoCompVal : elVal;
        checkElsVal.push(elVal);
        return valid;
    }
}