var AutoCompleteUtil = new function()
{
    this.changeTagValueBasedOnSelect = function(el, elNameOfSource, elNameOfTarger)
    {
        $(function(){
            var val = el.value;
            var parent = $(el).closest("tr");   //considering in general all input tags are inside a tr tag
            $(parent).find("input[elname='"+elNameOfSource+"']").attr("ac", val);
            var autoCompEl = $(parent).find("input[elname='"+elNameOfTarger+"']")[0];
            autoCompEl.autoCompData = null;
        });
    }
    
    this.loadData = function(el, elname, cleanDataEl)	//elname of the element to enable after selection only!
    {
        var masterType = el.getAttribute("ac");
        $(el).autocomplete({
            source : function(request, response){
                var allowedVals = $(el).data("allowedVals");
                var acData = el.autoCompData;
                if(acData)
                {
                    acData = AutoCompleteUtil.filterData(request.term, acData, allowedVals);
                    response(acData);
                    return;
                }
                var data = {};
                data["type"] = masterType;
                data["ac"] = true;
                $.get("php/fetchdata.php",data, function(data){
                    var acData = data.data;
                    el.autoCompData = acData;
                    acData = AutoCompleteUtil.filterData(request.term, acData, allowedVals);
                    response(acData);
                }, "json");
        },
        minLength: 0,
        select: function(event, ui){
        	var loadId = $(el).attr("id");
            $(el).val(ui.item.label).attr("id", ui.item.id);
            if(elname)
            {
            	GeneralUtil.enableElAfterSelection(el, elname);
            }
            if(cleanDataEl && loadId != ui.item.id)
            {
            	JobSheetUtil.clearProcesses(el, cleanDataEl);
            }
            if(masterType == Constants.PARTYMASTER)
            {
                JobSheetUtil.autoFillPartyMasterEls(ui.item.id);
            }
            return false;
          }
        });
    }
    
    this.filterData = function(term, data, allowedVals)
    {
        var regEx = new RegExp(".*"+term+".*", "ig");
        var returnedData = $.grep(data, function (element) {
            var checkFilter = element.label.match(regEx);
            if(allowedVals)
            {
                checkFilter = checkFilter && allowedVals.indexOf(element.id) > -1;
            }
            return checkFilter;
        });
        return returnedData;
    }
    
    this.setAllowedVals = function(elname, allowedVals, el)
    {
    	if(!el)
    	{
    		el = $("#container");
    	}
    	$(el).find("input[elname='"+elname+"']").data("allowedVals", allowedVals);
    }
}

