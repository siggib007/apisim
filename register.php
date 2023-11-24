<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
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
  if(isset($_SESSION["auth_username"] ) )
  {
    printPg("You're already registered, what are you trying to do????","error");
    exit;
  }

  $RegFoot = $TextArray["RegFoot"];
  $RegHeader = $TextArray["RegHead"];

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
  if(isset($GLOBALS["ConfArray"]["minRegLevel"]) )
  {
    $iLevel = $GLOBALS["ConfArray"]["minRegLevel"];
  }
  else
  {
    $iLevel = 1;
  }
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
      printPg("Can't create new user without an email. Contact $SupportEmail if you have any questions.","error");
    }
  }
  if(!$bSuccess)
  {
    printPg("$RegHeader","center");
    print "<form method=\"POST\">\n";
    require("UserRegForm.php");
    print "<tr>\n<td colspan=\"2\" align=\"center\">$RegFoot</td>\n</tr>\n";
    print "<tr>\n<td colspan=\"2\" align=\"center\"><input type=\"Submit\" value=\"Submit\" name=\"btnSubmit\"></td>\n</tr>\n";
    print "</table>\n";
    print "</form>\n";
  }
  require("footer.php");
?>