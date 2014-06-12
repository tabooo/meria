var _dwtParam = {
'productKey': 'CA5BE893B55B997011BDAEA1BE3290AC03E19878183ABF158BCB98483E25C74B10000000',
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
     'onTopImageInTheViewChanged':Dynamsoft_OnTopImageInTheViewChanged                                
};


var gWebTwain;
(function() {
	gWebTwain = new Dynamsoft.WebTwain(_dwtParam);
})();

var seed;
function onPageLoad() {
    initInfo();            //Add guide info
	initPara();

    seed = setInterval(initControl, 500);
}

function initControl() {
    var DWObject = gWebTwain.getInstance();
    if (DWObject) {
        if (DWObject.ErrorCode == 0) {
            clearInterval(seed);
            DWObject.BrokerProcessType = 1;

            var vDWTSource = document.getElementById("source");
            if (vDWTSource) {
                vDWTSource.options.length = 0;
                // fill in the source items.
                for (var i = 0; i < DWObject.SourceCount; i++) {
                    vDWTSource.options.add(new Option(DWObject.GetSourceNameItems(i), i));
                }

                if (DWObject.SourceCount > 0) {
                    source_onchange();
                }
            }

            // Fill the init data for preview mode selection
            var vResolution = document.getElementById("Resolution");
            if (vResolution) {
                vResolution.options.length = 0;
                vResolution.options.add(new Option("100", 100));
                vResolution.options.add(new Option("150", 150));
                vResolution.options.add(new Option("200", 200));
                vResolution.options.add(new Option("300", 300));
            }

            var RGB = document.getElementById("RGB");
            if (RGB)
                RGB.checked = true;
        }
    }
}

function source_onchange() {
    var DWObject = gWebTwain.getInstance();
    if (DWObject) {
        var vDWTSource = document.getElementById("source");
        if (vDWTSource) {

            if (vDWTSource)
                DWObject.SelectSourceByIndex(vDWTSource.selectedIndex);
            else
                DWObject.SelectSource();
        }

        DWObject.CloseSource();
    }
}



function acquireImage() {
    var DWObject = gWebTwain.getInstance();
    if (DWObject) {
        if (DWObject.SourceCount > 0) {
            var vDWTSource = document.getElementById("source");
            if (vDWTSource) {

                if (vDWTSource)
                    DWObject.SelectSourceByIndex(vDWTSource.selectedIndex);
                else
                    DWObject.SelectSource();
            }
            DWObject.CloseSource();
            DWObject.OpenSource();

            DWObject.IfShowUI = document.getElementById("ShowUI").checked;
            var i;
            for (i = 0; i < 3; i++) {
                if (document.getElementsByName("PixelType").item(i).checked == true)
                    DWObject.PixelType = i;
            }
            DWObject.Resolution = Resolution.value;
            DWObject.IfFeederEnabled = document.getElementById("ADF").checked;
            DWObject.IfDuplexEnabled = document.getElementById("Duplex").checked;

            DWObject.IfDisableSourceAfterAcquire = true;
            DWObject.AcquireImage();
			$('#btnUpload').css("visibility", "visible");
        } 
        else
            alert("No TWAIN compatible drivers detected.");
    }
}


function Dynamsoft_OnTopImageInTheViewChanged(index) {
    var DWObject = gWebTwain.getInstance();
    if (DWObject) {
        DWObject.CurrentImageIndexInBuffer = index;
    }
}

//--------------------------------------------------------------------------------------
//************************** Upload Image***********************************
//--------------------------------------------------------------------------------------
function btnUpload_onclick() {
     var DWObject = gWebTwain.getInstance();
     if (DWObject) {
         if (DWObject.HowManyImagesInBuffer == 0) {
             return;
         }
         var i, strHTTPServer, strActionPage, strImageType;
         varFileName.className = "";

         strHTTPServer = document.getElementById("txtHTTPServer").value;
         DWObject.HTTPPort = document.getElementById("txtHTTPPort").value;
         var varUserName = document.getElementById("txtUserName");
         if (varUserName) {
             if (varUserName.value != "") {
                 DWObject.HTTPUserName = varUserName.value;

                 var varPassword = document.getElementById("txtPassword");
                 if (varPassword) {
                     DWObject.HTTPPassword = varPassword.value;
                 }
             }
             else {
                 DWObject.HTTPUserName = "";
                 DWObject.HTTPPassword = "";
             }        
         }
		 //alert(document.getElementById("docid").value);
         strActionPage = document.getElementById("txtActionPage").value+"?docid="+document.getElementById("docid").value; //the ActionPage's file path
         for (i = 0; i < 4; i++) {
             if (document.getElementsByName("ImageType").item(i).checked == true) {
                 strImageType = i + 1;
                 break;
             }
         }
         
         var uploadfilename = varFileName.value + "." + document.getElementsByName("ImageType").item(i).value;
         if (strImageType == 2 && varMultiPageTIFF.checked) {
             if ((DWObject.SelectedImagesCount == 1) || (DWObject.SelectedImagesCount == DWObject.HowManyImagesInBuffer)) {
                 DWObject.HTTPUploadAllThroughPostAsMultiPageTIFF(
                strHTTPServer,
                strActionPage,
                uploadfilename);
             }
             else {
                 DWObject.HTTPUploadThroughPostAsMultiPageTIFF(
                strHTTPServer,
                strActionPage,
                uploadfilename);
             }
         }
         else if (strImageType == 4 && varMultiPagePDF.checked) {
             if ((DWObject.SelectedImagesCount == 1) || (DWObject.SelectedImagesCount == DWObject.HowManyImagesInBuffer)) {
                 DWObject.HTTPUploadAllThroughPostAsPDF(
                strHTTPServer,
                strActionPage,
                uploadfilename);
             }
             else {
                 DWObject.HTTPUploadThroughPostAsMultiPagePDF(
                strHTTPServer,
                strActionPage,
                uploadfilename);
             }
         }
         else {
             DWObject.HTTPUploadThroughPostEx(
            strHTTPServer,
            DWObject.CurrentImageIndexInBuffer,
            strActionPage,
            uploadfilename,
            strImageType);
         }

         //alert(DWObject.ErrorString + DWObject.HTTPPostResponseString);
		 document.getElementById("uploadresult").innerHTML=DWObject.HTTPPostResponseString;
		// var photos=DWObject.HTTPPostResponseString.split("|");
		 //var ii=1;
		 //alert(DWObject.HTTPPostResponseString);
		 //document.getElementById("uploadresult").innerHTML="";
		 //for(ii=1;ii<photos.length;ii++){
		//	 document.getElementById("uploadresult").innerHTML += "<img src='module/uploadedimages/"+photos[ii]+"' width='100'>";
		 //}
		 document.getElementById("filename").value = DWObject.HTTPPostResponseString;
		 //window.location.href = '?cat=edit_document&documentid='+document.getElementById("docid").value;
     }
}


//--------------------------------------------------------------------------------------
//*********************************radio response***************************************
//--------------------------------------------------------------------------------------
var varFileName, varMultiPageTIFF, varMultiPagePDF;
function initPara() {
    var varHTTPServer = document.getElementById("txtHTTPServer");
    if (varHTTPServer)
        varHTTPServer.value = location.hostname;
        
    var varHTTPPort = document.getElementById("txtHTTPPort");
    if (varHTTPPort)
        varHTTPPort.value = location.port == "" ? 80 : location.port;

    var varActionPage = document.getElementById("txtActionPage");
    if (varActionPage) {
        if (location.hostname != "") {
            var CurrentPathName = unescape(location.pathname); // get current PathName in plain ASCII
            varActionPage.value = CurrentPathName.substring(0, CurrentPathName.lastIndexOf("/") + 1) + "filesave.php"; //the ActionPage's file path
        }
        else
            varActionPage.value = "filesave.php"; //the ActionPage's file path
    }
    
    var varImgTypejpeg = document.getElementById("imgTypejpeg");
    if (varImgTypejpeg)
        varImgTypejpeg.checked = true;

    varFileName = document.getElementById("txtFileName");
    if (varFileName)
        varFileName.value = "WebTWAINImage";

    varMultiPageTIFF = document.getElementById("MultiPageTIFF");
    if (varMultiPageTIFF)
        varMultiPageTIFF.disabled = true;
    varMultiPagePDF = document.getElementById("MultiPagePDF");
    if (varMultiPagePDF)
        varMultiPagePDF.disabled = true;
}


function rdTIFF_onclick() {
    varMultiPageTIFF.disabled = false;

    varMultiPageTIFF.checked = false;
    varMultiPagePDF.checked = false;
    varMultiPagePDF.disabled = true;
}
function rdPDF_onclick() {
    varMultiPagePDF.disabled = false;

    varMultiPageTIFF.checked = false;
    varMultiPagePDF.checked = true;
    varMultiPageTIFF.disabled = true;
}
function rd_onclick() {
    varMultiPageTIFF.checked = false;
    varMultiPagePDF.checked = false;

    varMultiPageTIFF.disabled = true;
    varMultiPagePDF.disabled = true;
}
//******************Instructions*******************//
function initInfo() {
    var MessageBody = document.getElementById("divInfo");
    if (MessageBody) {
        var ObjString = "<div>";
        ObjString += "This sample demonstrates how to scan documents with customized settings using Dynamic Web TWAIN.<br />";
        ObjString += "<br />";
        ObjString += "<b>Steps to try:</b><br />";
        ObjString += "1. Connect your scanner<br />";
        ObjString += "2. Select your scanner for the source<br />";
        ObjString += "3. Set the attributes: Pixel type, Resolution, etc. <br />";
        ObjString += "4. Click the \"Scan\" button<br/>";
        ObjString += "<br />";
        ObjString += "<b>Note:</b>";
        ObjString += "<br />";
        ObjString += "1. By ticking \"Show UI\", you are able to use the scanner's user interface for scan settings.";
        ObjString += "<br />";
        ObjString += "2. Settings like ADF, Duplex depend on whether your scanner supports it or not.";
        ObjString += "<br />";
        ObjString += "<br />";
        ObjString += "Any questions? <a target='blank' href='mailto:support@dynamsoft.com'>Please let us know!</a>";
        ObjString += "<br />";
        ObjString += "</div>";
       // MessageBody.innerHTML = ObjString;
    }
}




