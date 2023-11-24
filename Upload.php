<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Page to allow for upload of files to the system
  */

  require("header.php");
  if($WritePriv <=  $Priv)
  {
    $DocRoot = "lib/";
    $PageHeader = "File uploads";
    $ConfirmationMsg = "The following files were uploaded";
  }
  else
  {
    $DocRoot = "upload/";
    $PageHeader = "Contribute your photo's here";
    $ConfirmationMsg = "Thank you $UsersName for your contribution of the following files";
  }
  $MaxConLen = return_bytes(ini_get("post_max_size"));
  $MaxSize = ini_get("post_max_size");
  $MaxFileSize = ini_get("upload_max_filesize");
  $MaxFileCount = ini_get("max_file_uploads");
  if(isset($_FILES["Docfile"]))
  {
    $FilesVarCount = count($_FILES["Docfile"]["name"]);
    if($FilesVarCount == 1 and $_FILES["Docfile"]["name"][0]=="")
    {
      printPg("You didn't select any files.","error");
      $_POST["btnSubmit"] = "Go Back";
    }
  }
  if(isset($_SERVER["CONTENT_LENGTH"]))
  {
    $ContLen = $_SERVER["CONTENT_LENGTH"];
    if($ContLen > $MaxConLen)
    {
      $strMsg = "Your upload was " . with_unit($ContLen ) . ". ";
      $strMsg .= "This exceeds the content limit of $MaxSize. Please do your upload in smaller chunks.";
      printPg($strMsg,"error");
      $_POST["btnSubmit"] = "Go Back";
    }
  }
  $dtNow = date('Y-m-d H:i:s');
  $PostVarCount = count($_POST);
  if(!is_dir($DocRoot))
  {
    mkdir($DocRoot);
  }


  if($strReferer != $strPageURL and $PostVarCount > 0)
  {
    printPg("Invalid operation, Bad Reference!!!","error");
    exit;
  }

  if($PostVarCount == 0 or ($_POST["btnSubmit"] == "Go Back"))
  {
    printPg("$PageHeader","h1");
    printPg("Please note the following limits in place:<br>\n" .
            "Total upload limit $MaxSize.<br>\n" .
            "Each file limit $MaxFileSize.<br>\n" .
            "If you exceed either of those limits you'll be returned to this screen without anything uploaded.<br>\n" .
            "In this case try uploading fewer smaller files.<br>\n" .
            "If you try to upload more than $MaxFileCount files, only $MaxFileCount of them will be uploaded.</p>\n","note");

    print "<form enctype=\"multipart/form-data\" method=\"POST\">\n";
    print "<div class=\"MainTextCenter\">File name: \n";
    print "<input type=\"file\" name=\"Docfile[]\" size=\"50\" multiple><br><br>\n";
    print "<input type=\"Submit\" value=\"Upload\" name=\"btnSubmit\">\n";
    print "</form></div>\n";
  }
  else
  {
    if($_POST["btnSubmit"] == "Upload")
    {
      if(isset($_FILES["Docfile"]))
      {
        $arrRet = FileUpload($_FILES["Docfile"],$DocRoot);
        $FileList = $arrRet["Files"];
        $SizeTotal = $arrRet["size"];
        $arrErrors = $arrRet["err"];
        $arrMsg = $arrRet["msg"];
      }
      else
      {
        $FileList = "";
        $SizeTotal = 0;
        $arrErrors = array();
        $arrMsg = array();
      }
      foreach($arrErrors as $strErr)
      {
        print $strErr;
      }
      foreach($arrMsg as $strMsg)
      {
        print $strMsg;
      }
      print "<div class=\"MainTextCenter\">$ConfirmationMsg. <br>\n";
      print $FileList;
      print "Total size uploaded " .with_unit($SizeTotal) . "</div>\n";
      if($WritePriv >  $Priv)
      {
        $strEmailBody = "$UsersName has submitted the following files for the photo gallary\n";
        $strEmailBody .= str_replace("<br>","",$FileList);
        $strEmailBody .= "Total size uploaded " .with_unit($SizeTotal) . "\n";
        if(EmailText("$SupportEmail","File upload Notification",$strEmailBody,$FromEmail))
        {
          printPg("We have been notified of your contribution","normal");
        }
        else
        {
          printPg("Unable to send notification, please notify us so that we can approve your submission","error");
        }
      }
      print "<div class=\"MainTextCenter\"><form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form></div>";
    }
  }
  require("footer.php");
?>