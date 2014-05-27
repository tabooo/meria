<?PHP

//PHP Auto Scanning Script

//Developed by Matthew Pulis (http://matthewpulis.info) 
//For support: http://scanphp.googlecode.com/issues/list
//Email: mpulis@matthewpulis.info
//[based on phpSane by David Froumlhlich]
//Downloaded from http://scanphp.googlecode.com
//Public Beta 0.9.0
//May 2009

// ======= Change the below section to your needs

$device = "FULL_Printer_Name"; //Full qualified Printer name for example: $device= "hpaio:/usb/psc_1200_series?serial=UA51CGB2DMT0";
$jpg_quality = "100";   //Change to the desired JPG quality
$keep_file = false;  //Change to true if you want to keep the scanned file after serving it to the user. If you don't want your hard disk on the server to end up clogged with files you may want to keep it false
$sound = true; //Change to false if you do not want the computer to beep before scanning


//========= Do not Edit unless you know what you are doing :)

//Declaring constants
define ("DEVICE", $device);
define ("JPG_QUALITY", $jpg_quality);
define ("KEEP_FILE", $keep_file);
define ("SOUND", $sound);


//Function exec shell
function sexec($CMD, $beep){
                  if (SOUND == true){
                     exec ('beep'); //To notify that scanning is about to start
                  }

                  //Opening a log file
                  $fl = fopen("scanner.log", 'a') or die("can't open file") ;
                  fwrite($fl, "Command Sent @ " . time() . " " . $CMD . "\n"); // writing to log file the command
                  
                  //Execing the command
                  exec ($CMD , $output , $return_var);

                  if ($beep == 0) {   // writing output only on scanner messages and not when beeping only
                    for ($i = 0; $i < sizeof($output); $i++){
  
                        fwrite($fl, "Command Response (Output) @ " . time() . " " . $output[$i] . "\n\n");
                    }
                  
                    fwrite($fl, "Command Response @ (Return Var)" . time() . " " . $return_var . "\n\n");
                  }
                  
                  //Closing the log file
                  fclose ($fl);
}

//Function for OCR Scan

function give_ocr($mode , $resolution, $FILENAME, DEVICE) {
         

         $CMD = "/usr/bin/scanimage -L 2> check_scan.log";

         sexec($CMD, 0);

         $CMD = "/usr/bin/scanimage -vvv --mode ".$mode." --device ".DEVICE." --resolution ". $resolution."dpi | /usr/bin/gocr -o " . $FILENAME . " 2> scanocr.log";

         sexec($CMD, 0);
}

//Function for JPG Scan
function give_jpg($mode , $resolution, $FILENAME, DEVICE, JPG_QUALITY) {
         
         $CMD = "/usr/bin/scanimage -L 2> check_scan.log";

         sexec($CMD, 0);

         $CMD = "/usr/bin/scanimage --mode ".$mode." --device ".DEVICE." --resolution ". $resolution."dpi | /usr/bin/pnmtojpeg --quality=" . JPG_QUALITY . " >" . $FILENAME. " 2> scanimage.log"; ;
         sexec($CMD, 0);
}


//Form Submitted

if(isset($_GET['scan'])) {

                  //Beeping to notify that the scanner is going to be used
                  
                   if (SOUND == true){ 
                     sexec ('beep -n -f 1000 -l 300 -n 200 -l 150', 1);   //to notify that the preparations for scanning are about to start
                   }
                   
                   
                  //Preparing the Filename
                  
                  $FILENAME = $_GET['filename'] . "_" . time() ;

                  if(isset($_GET['ocr'])) {
                                     $FILENAME .=  ".txt";
                                     give_ocr ( $_GET['mode'], $_GET['resolution'], $FILENAME , DEVICE);
                                     $CONTENT_TYPE = "text/plain";
                                   }
                  else {
                     $FILENAME .= ".jpg" ;
                     give_jpg ( $_GET['mode'], $_GET['resolution'], $FILENAME , DEVICE, JPG_QUALITY);
                     $CONTENT_TYPE = "image/jpeg";
                  }

                  //Preparing the Header Type
                  header ("Content-Type: $CONTENT_TYPE");
                  header ("Content-Disposition: attachment; filename=$FILENAME");

                  //Reading the file - without it even if there is a file at the server waiting it will not be forwarded to the user
                  readfile($FILENAME);
                  
                  //Beeping to notify that the scanner was used and is now finisehd
                  if (SOUND == true){ 
                    sexec ('beep -f 330 -l 100 -d1 -n -f 277 -l 100 -d1 -n -f 330 -l 100 -d 1 -n -f 440 -l 330', 1);  //to notify scanning has finished
                   }

                  //Deleting the created file- to save spac
                  sexec ('rm ' . $FILENAME , 0);

                  exit();
}

//Form Not Submitted

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
    <meta name="author" content="Matthew Pulis">
    <meta name="robots" content="noindex">
    <title>PHP Scanning (based on phpSANE)</title>

    <script language="JavaScript" type="text/javascript">;
            function changeText(){
                     var ocb = document.preview.ocr;
                     var textContent = document.getElementById("nm");
                     if (ocb.checked == true){
                        textContent.innerHTML= ".txt";
                     }
                     if (ocb.checked == false) {
                         textContent.innerHTML= ".jpg";
                     }
            }

            

     </script>

</head>
<body bgcolor="#FFFFFF">
      <h1>PHP Scanning Software</h1>
      <h3>Easily Scan your Documents / Images from your web-browser</h3>
      <h5>Software (c) Matthew Pulis</h5>
      <hr>
          <br>
              <form name="preview" action="<?=$_SERVER['PHP_SELF'];?>" method=get>
                <table>
                       <tr>
                           <td>
                               <b>Resolution:</b>
                           </td>
                           <td>
                               <input type=text name="resolution" value="300" size=4 maxlength=3 />&nbsp;DPI
                           </td>
                       </tr>
                       <tr>
                           <td>
                               <b>File Name:</b>
                           </td>
                           <td>
                               <input type=text name="filename" value="" size=8 maxlength=8 /><span id="nm">.jpg</span>
                           </td>
                       </tr>
                       <tr>
                           <td>
                               <b>Scanning Type:</b>
                           </td>
                           <td>
                               <select name="mode" size=1>
                                 <option value="Lineart">Black and White</option>
                                 <option value="Gray">Gray</option>
                                 <option value="Color" selected>Color</option>
                              </select>

                           </td>
                       </tr>
                       <tr>
                           <td>
                               <b>OCR:</b>
                           </td>
                           <td>
                               <input type=checkbox name="ocr" onClick="javascript:changeText()" value="0" />&nbsp;
                           </td>
                       </tr>
                       <tr>
                           <td>
                               <input type=submit value="Submit Scanning Job" name="submit">&nbsp;
                           </td>
                           <td>
                                <input type=reset value="Reset All Changes" name="reset">
                                <input type=hidden name="scan" value="true">
                           </td>
                       </tr>
               </table>
           </form>
        </body>
    </html>




