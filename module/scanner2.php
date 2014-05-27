﻿<script language="Javascript" type="text/javascript">
//<![CDATA[

  var Success

window.onload = function() {
    document.form1.selectbutton.disabled = false
    document.form1.scanbutton.disabled = true
    document.form1.uploadbutton.disabled = true
    document.form1.rectbutton.disabled = true
    document.form1.cropbutton.disabled = true
    document.form1.leftbutton.disabled = true
    document.form1.rightbutton.disabled = true
  }

  function SelectClick()
  {
    csxi.SelectTwainDevice();
    if (csxi.TwainConnected)
    {
      document.form1.scanbutton.disabled = false
    }
  }

  function ScanClick()
  {
    csxi.Acquire();
    if (csxi.ImageHeight != 0)
    {
      document.form1.uploadbutton.disabled = false
      document.form1.rectbutton.disabled = false
      document.form1.leftbutton.disabled = false
      document.form1.rightbutton.disabled = false
    }
    else
    {
      document.form1.uploadbutton.disabled = true
      document.form1.rectbutton.disabled = true
      document.form1.cropbutton.disabled = true
      document.form1.leftbutton.disabled = true
      document.form1.rightbutton.disabled = true
    }
  }

  function UploadClick()
  {
    //Add the URL to the file saving script, including the http:// prefix.
    Success = csxi.PostImage('http://localhost/meria/test/filesave.php', 'scan.jpg', 'userfile', 2);
    if (Success)
    {
      alert('Image Uploaded')
    }
    else
    {
      alert('Upload Failed')
    } 
  }

  function RectClick()
  {
    csxi.MouseSelectRectangle();
    document.form1.cropbutton.disabled = false;
  }

  function CropClick()
  {
    csxi.CropToSelection();
    document.form1.cropbutton.disabled = true;
  }

  function LeftClick()
  {
    csxi.Rotate(90);
  }

  function RightClick()
  {
    csxi.Rotate(270);
  }

//]]>
</script>
<form name="form1" action="">
<table>
<tr>
  <td><input type="button" name="selectbutton" value="Select Device" onclick="SelectClick()" /></td>
  <td><input type="button" name="scanbutton" value="Scan Image" onclick="ScanClick()" /></td>
  <td><input type="button" name="uploadbutton" value="Upload Image" onclick="UploadClick()" /></td>
</tr>
<tr>
  <td><input type="button" name="rectbutton" value="Select Area" onclick="RectClick()" /></td>
  <td><input type="button" name="cropbutton" value="Crop" onclick="CropClick()" /></td>
  <td><input type="button" name="leftbutton" value="Rotate Left" onclick="LeftClick()" /></td>
  <td><input type="button" name="rightbutton" value="Rotate Right" onclick="RightClick()" /></td>
</tr>
</table>
</form>

<object classid="clsid:5220cb21-c88d-11cf-b347-00aa00a28331">
  <param name="LPKPath" value="csximagetrial.lpk" />
</object>
<object id="csxi" classid="CLSID:D7EC6EC3-1CDF-11D7-8344-00C1261173F0" codebase="csximagetrial.ocx" width="800" height="600"></object>