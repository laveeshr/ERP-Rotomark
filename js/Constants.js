var Constants = new function()
{
	this.ALLMASTERS = 25;
    this.PROCESSMASTER = 1;
    this.COLORMASTER = 2;
    this.MATERIALMASTER = 3;
    this.LESSMASTER = 4;
    this.OPMASTER = 5;
    this.SPARECYLINDER = 6;
    this.TOMMASTER = 7;
    this.PARTYMASTER = 8;
    this.JOBSHEET = 9;
    this.NONPENDING_LOCAL = 91;
    this.NONPENDING_OUTSTATION = 92;
    this.PENDING_LOCAL = 93;
    this.PENDING_OUTSTATION = 94;
    this.NONPENDING_ALL = 95;
    this.PENDING_ALL = 96;
    
    //Department Codes
    this.BASE_SHELL = 10;
    this.ROUGH_TURNING = 11;
    this.FINAL_GRINDING = 12;
	this.COPPER_PLATING = 13;
	this.COPPER_TANK = 131;
	this.COPPER_CUT = 14;
	this.COPPER_POLISH = 15;
	this.ENGRAVING = 16;
	this.CHROME_PLATING = 17;
	this.CHROME_POLISH = 18;
	this.PROOFING = 19;
	this.DISPATCH = 20;
	this.TIKAL_SIZE = 21;
	this.SHEET_CUTTING = 22;
	
	this.DEPARTMENTS = [10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];
	
	this.ADMIN = 23;
	this.ISP = 24;
	
	//Print Sub-Types
	this.PRINT_PARTYWISE = 1;
	this.PRINT_DATEWISE = 2;
	this.PRINT_CHALLANWISE = 3;
    
    //Success Codes
    this.ADDROWSUCCESS = 1000;
    this.DELETEROWSUCCESS = 1100;
    this.UPDATEROWSUCCESS = 1200;
    this.URGENTSUCCESS = 1300;
    this.SEPARATESUCCESS = 1400;
    this.MERGESUCCESS = 1500;
    this.LOGINSUCCESS = 1600;
    this.IPSUCCESS = 1700;
    
    //Error Codes
    this.ADDROWERROR = -1000;
    this.NOROWS = -1;
    this.DELETEROWERROR = -1100;
    this.UPDATEROWERROR = -1200;
    this.URGENTERROR = -1300;
    this.SEPARATEERROR = -1400;
    this.MERGEERROR = -1500;
    this.LOGINERROR = -1600;
    this.IPERROR = -1700;
    
    //OP Vals
    this.ADD = 1;
    this.MUL = 2;
}