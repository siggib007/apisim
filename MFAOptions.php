<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Incorporate into the Auth routine to handle different MFA options
  */

  require_once("header.php");
  if($strTOTP == "" or $strMFAType == "smsemail")
  {
    # Generate and send code
    $ConfCode = bin2hex(random_bytes(4));
    $_SESSION["ConfCode"] = $ConfCode;
    $strMsg = "Your confirmation code is: $ConfCode";
    $strQuery = "SELECT iTypeID, vcValue FROM tblUsrPrefValues WHERE iUserID = $iUserID AND iTypeID IN (2,3);";
    $QueryData = QuerySQL($strQuery);

    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
        if(strtolower($Row["vcValue"]) == "true" && strtolower($Row["iTypeID"]) == "2")
        {
          SendUserSMS($strMsg,$iUserID);
        }
        if(strtolower($Row["vcValue"]) == "true" && strtolower($Row["iTypeID"]) == "3")
        {
          EmailText($strEmail,"Login Verification Code",$strMsg,$FromEmail);
        }
      }
    }
  }
  elseif($_SESSION["bSMSemail"])
  {
    printPg("To use SMS or email MFA, change the dropdown make sure the value field is empty and hit submit","note");
  }
  print "<form method=\"POST\">";
  print "Select your MFA Type: ";
  print "<select size=\"1\" name=\"cmbMFA\">\n";
  foreach($arrMFAOptions as $key => $value)
  {
    if($key == $strMFAType)
    {
      print "<option value=$key selected>$value</option>\n";
    }
    else
    {
      print "<option value=$key>$value</option>\n";
    }
  }
  print "</select>";
  print "<INPUT TYPE=\"HIDDEN\" NAME=\"txtLogin\" VALUE=\"$strLogin\">";
  print "<INPUT TYPE=\"HIDDEN\" NAME=\"txtPwd\" VALUE=\"$strPWD\">";
  print "&nbsp;&nbsp;Please provide your code: ";
  print "<input type=\"text\" name=\"txtCode\" size=\"30\">";
  print "&nbsp;&nbsp;<input type=\"submit\" value=\"Submit\" name=\"btnLogin\">";
  print "</form>";
  require_once("footer.php");
?>