var _dwtParam = {
'productKey': '2D1C1C608AE516828F6DD59A9078F83E1A6BAFF0146D8013663F3F72E48DD7DD1A6BAFF0146D80137DB5187E816757771A6BAFF0146D80134DADACF12928027230000000',
    'containerID': 'dwtcontrolContainer',   //The ID of Dynamic Web TWAIN control div in HTML.This value is required.
    /*
    'isTrial': 'true',  
    isTrial is used to judge whether Dynamic Web TWAIN control is trial or full. This value is optional.
    The default value is 'TRUE', which means the control is a trial one. The value of isTrial is 'TRUE' or 'FALSE'.
    */

    /*
    'version': '9,2',   
    The version of Dynamic Web TWAIN control, which is used to judge the version when downloading CAB.
    This value is optional. The default value is '9,2'.
    */                      
    
    /*
    'resourcesPath': 'Resources',   
    The relative path of MSI, CAB and PKG.
    This value is optional. The default value is 'Resources'.
    */

    'width': 120,  
    /*
    'width': 580,       //The width of Dynamic Web TWAIN control
     This value is optional. The default value is '580'.
     */  
       
    /*
    'height': 600       //The height of  Dynamic Web TWAIN control
    This value is optional. The default value is '600'.
     */   
      
    /*  These are events. The name of 'OnPostAllTransfer' shouldn't be changed, but the name of 'Dynamsoft_OnPostAllTransfers' can be modified. 
        Please pay attention, the name of 'Dynamsoft_OnPostAllTransfers' and 'function Dynamsoft_OnPostAllTransfers()' event must be coincident.
        
        Events are as follows. You can choose one or many according to you needs.
        Once an event is added, you must make sure the corresponding function is defined in your code.
        
        'onPostTransfer':Dynamsoft_OnPostTransfer,
        'onPostAllTransfers':Dynamsoft_OnPostAllTransfers,  
        'onMouseClick':Dynamsoft_OnMouseClick,   
        'onPostLoad':Dynamsoft_OnPostLoadfunction,    
        'onImageAreaSelected':Dynamsoft_OnImageAreaSelected,   
        'onMouseDoubleClick':Dynamsoft_OnMouseDoubleClick,   
        'onMouseRightClick':Dynamsoft_OnMouseRightClick,   
        'onTopImageInTheViewChanged':Dynamsoft_OnTopImageInTheViewChanged,   
        'onImageAreaDeSelected':Dynamsoft_OnImageAreaDeselected,    
        'onGetFilePath':Dynamsoft_OnGetFilePath  
    */
    'onPostTransfer': Dynamsoft_OnPostTransfer,
     'onMouseClick':Dynamsoft_OnMouseClick,
     'onTopImageInTheViewChanged':Dynamsoft_OnTopImageInTheViewChanged
};

var _dwtParam2 = {
    'containerID': 'dwtcontrolContainer2',   
    'width': 440,      
    'height': 600      
};


var gWebTwain;
var gWebTwain2;
(function() {
    gWebTwain = new Dynamsoft.WebTwain(_dwtParam);
    gWebTwain2 = new Dynamsoft.WebTwain(_dwtParam2);
})();

var seed;
function onPageLoad() {
    initInfo();            //Add guide info
    seed = setInterval(initControl, 500);
 }

 function initControl() {
     var DWObject = gWebTwain.getInstance();
     if (DWObject) {
         if (DWObject.ErrorCode == 0) {
             DWObject.BrokerProcessType = 1;

             DWObject.SetViewMode(1, 3);
             DWObject.MouseShape = true;
         }
     }
     
      var DWObject2 = gWebTwain2.getInstance();
      if (DWObject2) {
          if (DWObject.ErrorCode == 0) {
         clearInterval(seed);
         DWObject2.BrokerProcessType = 1;
         
         DWObject2.SetViewMode(1, 1);
         }
     }
 }

function acquireImage() {
    var DWObject = gWebTwain.getInstance();
    if (DWObject) {
        if (DWObject.SourceCount > 0) {
            DWObject.SelectSource();
            DWObject.AcquireImage();
        }
        else
            alert("No TWAIN compatible drivers detected.");
    }
}

function Dynamsoft_OnPostTransfer() {
    UpdateImage();
}

function Dynamsoft_OnMouseClick()
{
    UpdateImage();
}

function UpdateImage() {
    var DWObject = gWebTwain.getInstance();
    if (DWObject) {
        var DWObject2 = gWebTwain2.getInstance();
        if (DWObject2) {
            DWObject.CopyToClipboard(DWObject.CurrentImageIndexInBuffer);
            DWObject2.RemoveAllImages();
            DWObject2.LoadDibFromClipboard();
        }
    }
}


function Dynamsoft_OnTopImageInTheViewChanged(index) {
    var DWObject = gWebTwain.getInstance();
    if (DWObject) {
        DWObject.CurrentImageIndexInBuffer = index;
    }
}


//******************Instructions*******************//
function initInfo() {
    var MessageBody = document.getElementById("divInfo");
    if (MessageBody) {
        var ObjString = "<div>";
        ObjString += "This sample demonstrates how to use web scan with thumbnails. <br />";
        ObjString += "<br />";
        ObjString += "<b>Steps to try:</b><br />";
        ObjString += "1. Connect your scanner<br />";
        ObjString += "2. Click the \"Scan\" button<br />";
        ObjString += "<br />";
        ObjString += "<b>Note:</b><br />";
        ObjString += "1. The highlighted image in the thumbnail window is displayed in the main viewer. <br />";
        ObjString += "2. You can switch images when more than one image are scanned.";
        ObjString += "<br />";
        ObjString += "<br />";
        ObjString += "Any questions? <a target='blank' href='mailto:support@dynamsoft.com'>Please let us know!</a>";
        ObjString += "<br />";
        ObjString += "</div>";
        MessageBody.innerHTML = ObjString;
    }
}
