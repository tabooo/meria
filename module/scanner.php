    <meta http-equiv="X-UA-Compatible" content="requiresActiveX=true" />
   <!-- <link href="css/style.css" type="text/css" rel="stylesheet" />-->
    
<script>
$(window).load(function(){
              onPageLoad();
});
</script>             

            <!--This is where you add the actual buttons to control the component.-->
            <div class="ScanWrapper">
                <div id="div_ScanImage" class="divTableStyle">
                    <ul>
                        <li>
                            <label for="source"><select size="1" id="source" style="position:relative;width: 220px;" onchange="source_onchange()"><option value = ""></option></select></label></li>                             
						<div style="display:none"> <li>
                            <label for = 'ShowUI'><input type='checkbox' id='ShowUI' />Show UI&nbsp;</label>
                            <label for = 'ADF'><input type='checkbox' id='ADF' />ADF&nbsp;</label>
                            <label for = 'Duplex'><input type='checkbox' id='Duplex'/>Duplex</label></li>
                        <li><b>Pixel Type:</b>
                            <label for='BW'><input type='radio' id='BW' name='PixelType'/>B&amp;W </label>
                            <label for='Gray'><input type='radio' id='Gray' name='PixelType'/>Gray</label>
                            <label for='RGB'><input type='radio' id='RGB' name='PixelType' checked />Color</label></li>
                        <li>
                            <label for='Resolution'><b>Resolution:</b><select size='1' id='Resolution'><option value = ''></option></select></label></li>
							<li>
                        <table>
                            <tr>
                                <td><label>HTTP Server:</label></td>
                                <td><input type="text" size="20" id="txtHTTPServer" /></td>
                            </tr>
                            <tr>
                                <td><label>HTTP Port:</label></td>
                                <td><input type="text" size="20" id="txtHTTPPort" /></td>
                            </tr>
                            <tr>
                                <td><label>User Name:</label></td>
                                <td><input type="text" size="20" id="txtUserName" /></td>
                            </tr>
                            <tr>
                                <td><label>Password:</label></td>
                                <td><input type="text" size="20" id="txtPassword" /></td>
                            </tr>
                            <tr>
                                <td><label>Action Page:</label></td>
                                <td><input type="text" size="20" id="txtActionPage" /></td>
                            </tr>
                             <tr>
                                <td><label>File Name:</label></td>
                                <td><input type="text" size="20" id="txtFileName" /></td>
                            </tr>
                        </table>
                    </li>
                    <li>
	                    <label for="imgTypejpeg">
		                    <input type="radio" value="jpg" name="ImageType" id="imgTypejpeg" onclick ="rd_onclick();"/>JPEG</label>
	                    <label for="imgTypetiff">
		                    <input type="radio" value="tif" name="ImageType" id="imgTypetiff" onclick ="rdTIFF_onclick();"/>TIFF</label>
	                    <label for="imgTypepng">
		                    <input type="radio" value="png" name="ImageType" id="imgTypepng" onclick ="rd_onclick();"/>PNG</label>
	                    <label for="imgTypepdf">
		                    <input type="radio" value="pdf" name="ImageType" id="imgTypepdf" onclick ="rdPDF_onclick();"/>PDF</label></li>
                    <li style="padding-left:9px;">
                        <label for="MultiPageTIFF"><input type="checkbox" id="MultiPageTIFF"/>Multi-Page TIFF</label>
                        <label for="MultiPagePDF"><input type="checkbox" id="MultiPagePDF"/>Multi-Page PDF </label></li>
						</div>
						
                    </ul>
					
                    <input class="DWTScanButton btn" type="button" value="დასკანირება" onclick ="acquireImage();"/><input id="btnUpload" class="DWTScanButton btn" type="button" value="Upload Image" onclick ="btnUpload_onclick()"/>
					<div id="uploadresult"></div>
                </div>
                <div id="divInfo"></div>
            </div>
			<!--This is where Dynamic Web TWAIN control will be rendered.-->
            <div id="dwtcontrolContainer"></div>	
        
   
<script src="js/dynamsoft.webtwain.initiate.js"></script>
    <script src="js/DWTSample_CustomScan.js"></script>
