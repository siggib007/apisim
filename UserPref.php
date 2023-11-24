<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
  */

  require("header.php");
  if($strReferer != $strPageURL and $PostVarCount > 0)
  {
    printPg("Invalid operation, Bad Reference!!!","error");
    exit;
  }

  if(isset($_POST["btnSubmit"]))
  {
    $btnSubmit = $_POST["btnSubmit"];
  }
  else
  {
    $btnSubmit = "";
  }

  if($btnSubmit == "Validate")
  {
    if(isset($_POST["txtCode"]))
    {
      $strCode =  CleanReg($_POST["txtCode"]);
    }
    else
    {
      $strCode = "";
    }
    if(isset($_SESSION["ConfCode"]))
    {
      $ConfCode = $_SESSION["ConfCode"];
    }
    else
    {
      $ConfCode = "";
    }

    if($strCode == $ConfCode)
    {
      $strQuery = "update tblUsrPrefValues set vcValue = 'True' where iUserID = $iUserID and iTypeID = 1 ;";
      if(UpdateSQL($strQuery, "update"))
      {
        printPg("Update for Enable Sending SMS Messages successful","note");
      }
      else
      {
        printPg("failed to update Enable Sending SMS Messages","note");
      }
    }
    else
    {
      printPg("Invalid code, please try again","error");
    }
    unset($_SESSION["ConfCode"]);
    $btnSubmit = "";
  }

  if($btnSubmit =="Disabled")
  {
    if(isset($_POST["txtKey"]))
    {
      $strKey =  CleanReg($_POST["txtKey"]);
    }
    else
    {
      $strKey = "";
    }
    if(isset($_POST["txtLabel"]))
    {
      $strLabel = CleanReg($_POST["txtLabel"]);
    }
    else
    {
      $strLabel = "";
    }
    $bSMSOK = True;

    if($strKey == 1 and $strCell != "")
    {
      $ConfCode = bin2hex(random_bytes(4));
      $response = SendTwilioSMS("Your confirmation code is: $ConfCode",$strCell);
      if($response[0])
      {
        $_SESSION["ConfCode"]=$ConfCode;
        print "<form method=\"POST\">\n";
        print "<div>Please enter the confirmation code we just sent you:\n";
        print "<input type=\"text\" name=\"txtCode\" size=\"10\">\n";
        print "<input type=\"Submit\" value=\"Validate\" name=\"btnSubmit\">\n";
        print "<input type=\"Submit\" value=\"Cancel\" name=\"btnSubmit\">\n";
        print "</div>\n";
        print "</form>\n";
        $bSMSOK = False;
      }
      else
      {
        $arrResponse = json_decode($response[1], TRUE);
        $errmsg = "";
        if(array_key_exists("message",$arrResponse))
        {
          $errmsg .= $arrResponse["message"];
        }
        printPg("A failure occured: $errmsg","error");
        $bSMSOK = False;
        $btnSubmit = "";
      }
    }

    if($strKey == 1 and $strCell == "")
    {
      printPg("You have to provide your cell number before you can enable SMS Notifications","error");
      $btnSubmit = "";
      $bSMSOK = False;
    }
    if(stripos($strLabel,"mfa")!== false)
    {
      printPg("Make sure you have a recovery code for MFA failures.<br>\nIf you need a new recovery code, ".
                "head over to the <a href=UserProfileOther.php>Other tab</a> to reset your recovery code and get a new one.","note");
    }

    if(stripos($strLabel,"sms")!== false and $strKey != 1)
    {
      $strQuery = "SELECT vcValue FROM tblUsrPrefValues WHERE iUserID = $iUserID AND iTypeID = 1;";
      $strValue = GetSQLValue($strQuery);
      if(strtolower($strValue) == "true")
      {
        $bSMSOK = True;
      }
      else
      {
        $bSMSOK = False;
      }
    }

    if($bSMSOK)
    {
      $strQuery = "update tblUsrPrefValues set vcValue = 'True' where iUserID = $iUserID and iTypeID = $strKey ;";
      if(UpdateSQL($strQuery, "update"))
      {
        printPg("Update for $strLabel successful","note");
      }
      else
      {
        printPg("failed to update $strLabel","note");
      }
      $btnSubmit = "";
    }
    else
    {
      if($strKey != 1)
      {
        printPg("Please enable sending SMS Messages before enabling any SMS functions","error");
        $btnSubmit = "";
      }
    }
  }

  if($btnSubmit =="Enabled")
  {
    if(isset($_POST["txtKey"]))
    {
      $strKey =  CleanReg($_POST["txtKey"]);
    }
    else
    {
      $strKey = "";
    }
    if(isset($_POST["txtLabel"]))
    {
      $strLabel = CleanReg($_POST["txtLabel"]);
    }
    else
    {
      $strLabel = "";
    }

    $arrTypeIDs = array();
    if($strKey == 1)
    {
      $strQuery = "SELECT iID FROM tblUsrPrefTypes WHERE vcCode LIKE '%sms%';";
      $QueryData = QuerySQL($strQuery);
      if($QueryData[0] > 0)
      {
        foreach($QueryData[1] as $Row)
        {
          $arrTypeIDs[] = $Row["iID"];
        }
      }
      else
      {
        if($QueryData[0] < 0)
        {
          $strMsg = Array2String($QueryData[1]);
          error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
          printPg($ErrMsg,"error");
        }
      }
    }
    else
    {
      $arrTypeIDs[] = $strKey;
    }
    $strTypeList = implode(",",$arrTypeIDs);
    $strQuery = "update tblUsrPrefValues set vcValue = 'False' where iUserID = $iUserID and iTypeID IN ($strTypeList) ;";
    if(UpdateSQL($strQuery, "update"))
    {
      printPg("Update for $strLabel successful","note");
    }
    else
    {
      printPg("failed to update $strLabel","note");
    }
    $btnSubmit = "";
  }

  $arrMFAOptions = LoadMFAOptions($iUserID);
  printPg("Account Preferences","h2");
  print "<div class=\"MainTextCenter\">\n";
  $btnValue = "";
  $strQuery = "SELECT t.*,v.vcValue,v.iUserID ".
  "FROM tblUsrPrefTypes t JOIN tblUsrPrefValues v ON t.iID = v.iTypeID ".
  "WHERE v.iUserID = $iUserID OR v.iUserID IS NULL ORDER BY iSortOrder;";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $Key = $Row["iID"];
      $Value = $Row["vcValue"];
      $ValueDescr = $Row["vcLabel"];
      $ValueType = $Row["vcType"];
      print "<form method=\"POST\">\n";
      print "<input type=\"hidden\" value=\"$Key\" name=\"txtKey\">";
      print "<input type=\"hidden\" value=\"$ValueDescr\" name=\"txtLabel\">";
      print "<div>$ValueDescr: ";
      switch($ValueType)
      {
        case "Boolean":
          if(strtolower($Value)=="true")
          {
            $btnValue = "Enabled";
          }
          else
          {
            $btnValue = "Disabled";
          }
          break;
        case "int":
        case "text":
          print "<input type=\"text\" value=\"$Value\" name=\"txtValue\" size=\"30\" >";
          $btnValue = "Save";
          break;
      }
      print "<input type=\"Submit\" value=\"$btnValue\" name=\"btnSubmit\"></div>\n";
      print "</form>\n";
    }
  }
  else
  {
    if($QueryData[0] == 0)
    {
      printPg("No Records","note");
    }
    else
    {
      $strMsg = Array2String($QueryData[1]);
      error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
      printPg($ErrMsg,"error");
    }
  }

  print "</div>\n";
  require("footer.php");
?>
