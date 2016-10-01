var LoadUtil = new function()
{
    this.loadHtmlFile = function(fileName, setDate)
    {
        $(function(){
        	$("#container").load(fileName, function(data){
                    var node = $(data).clone();
                    if(setDate)
                    {
                    	GeneralUtil.setCurrentDate(node);
                    }
                    $(this).replaceWith(node);
                });
             MasterUtil.showHideMasterTable();
        });
    }
    
    this.loadAndSetHtmlFile = function(fileName, type, loadData)
    {
    	$(function(){
            $("#container").load(fileName, function(data){
                    var node = $(data).clone();
                    if(type == Constants.JOBSHEET || type == Constants.NONPENDING_LOCAL  || type == Constants.NONPENDING_OUTSTATION || type == Constants.PENDING_LOCAL || type == Constants.PENDING_OUTSTATION || type == Constants.PENDING_ALL || type == Constants.NONPENDING_ALL)
                    {
                    	JobSheetUtil.populateJobSheet(loadData, node);
                    }
                    $(this).replaceWith(node);
                });
                MasterUtil.showHideMasterTable();
        });
    }
    
    this.loadJSONResp = function(fileName, type)
    {
        var newNode = this.loadHtmlFile(fileName);
        GeneralUtil.resetDateRange();
        this.refreshView(type);
    }
    
    this.refreshView = function(type, dateRange)
    {
    	if(!type)
    	{
    		type = $("#container").attr("masterType");
    	}
    	MasterUtil.showHideMasterTable();
    	var dateRange = !dateRange ? GeneralUtil.getDateRange() : dateRange;
        var params = MasterUtil.getParams(type, dateRange);
        this.sendAjaxRequest(params);
    }
    
    this.getPrintData = function(el, type)
    {
    	if(!type)
    	{
    		type = $("#container").attr("masterType");
    	}
    	var subType = el.getAttribute("subtype");
    	var dateRange = GeneralUtil.getDateRange();
    	var params = MasterUtil.getParams(type, dateRange, {'subType':subType});
    	params['url'] = "php/getPrintData.php";
        params['success'] = GeneralUtil.handlePrintData;
        this.sendAjaxRequest(params);
    }
    
    this.sendAjaxRequest = function(params)
    {
    	params["beforeSend"] = function() { $('body').addClass("loading"); };
    	params["complete"] = function() { $('body').removeClass("loading"); };
        $(function(){
            $.ajax(params);
        });
    }
}