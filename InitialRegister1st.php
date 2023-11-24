<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Page for initial setup. Only valid if setup hasn't been done, 
  should self destruct once successful. 
  */

  require("header.php");
  if(isset($_POST["btnSubmit"]))
  {
    $btnSubmitValue = $_POST["btnSubmit"];
  }
  else
  {
    $btnSubmitValue = "";
  }
  if($strReferer != $strPageURL and $PostVarCount > 0)
  {
    printPg("Invalid operation, Bad Reference!!!","error");
    exit;
  }

  if(!isset($GLOBALS["ConfArray"]["InitSetup"]) )
  {
    printPg("Setup Mode isn't enable so you can't use this page","error");
    exit;
  }
  require("FileInv.php");
  $strQuery = "UPDATE tblmenu SET iReadPriv='300' WHERE vcLink = 'FileInv.php';";
  UpdateSQL($strQuery,"update");

  $RegHeader = $TextArray["RegForm"];

  $strQuery = "SELECT iPrivLevel FROM tblprivlevels WHERE vcPrivName LIKE '%admin%';";
  $iLevel = GetSQLValue($strQuery);
  if($iLevel < 1)
  {
    $iLevel = 300;
  }

  $strName = "";
  $strAddr1 = "";
  $strAddr2 = "";
  $strCity = "";
  $strState = "";
  $strZip = "";
  $strCountry = "";
  $iPrivLevel = "";
  $strEmail = "";
  $strUserID = "";
  $strCell = "";
  $bSuccess = FALSE;
  $bRegOK = FALSE;

  if($btnSubmitValue == "Submit")
  {
    require_once("CleanReg.php");
    if($strEmail)
    {
      $strNameParts = explode(" ",$strName);
      $HowMany = count($strNameParts);
      if($HowMany==1)
      {
        printPg("Please provide both first and last name","error");
      }
      else
      {
        if(!$bSpam)
        {
          require("UserAdd.php");
        }
      }
    }
    else
    {
      printPg("Can't create new admin account without an email..","error");
    }
  }
  $bSuccess = $bRegOK;
  if($bSuccess)
  {
    $strQuery = "DELETE FROM tblconf WHERE vcValueName='InitSetup' LIMIT 1;";
    UpdateSQL($strQuery,"delete");
    $strQuery = "DELETE FROM tblPageTexts WHERE vcTextName='SetupReg' LIMIT 1;";
    UpdateSQL($strQuery,"delete");
    $strQuery = "DELETE FROM tblmenu WHERE vcLink='$strPageName' LIMIT 1;";
    UpdateSQL($strQuery,"delete");
    if(strtolower($DevEnvironment) != "true")
    {
      unlink($strPageName);
    }
    printPg("<a href='index.php'>Setup completed. Click here to go home</a>","note");
  }
  else
  {
    printPg("$RegHeader","note");
    print "<form method=\"POST\">\n";
    require("UserRegForm.php");
    print "<tr>\n<td colspan=\"2\" align=\"center\"><input type=\"Submit\" value=\"Submit\" name=\"btnSubmit\"></td>\n</tr>\n";
    print "</table>\n</form>\n";
  }
  require("footer.php");
?>