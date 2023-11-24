<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
  */

  $PostVarCount = count($_POST);

  if(isset($_POST["btnSubmit"]))
  {
    $btnSubmitValue = $_POST["btnSubmit"];
  }
  else
  {
    $btnSubmitValue = "";
  }
  if($btnSubmitValue == "Export user to CSV file")
  {
    require_once("DBCon.php");
    $SiteURL = $ConfArray["SecureURL"];
    $filename = "{$SiteURL}_Users_".date('Y-m-d_Hi',time()).".csv";
    header("Content-type: text/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename=\"$filename\"; charset=utf-8");
    print "Name,Unit,Phone,Email,Addr1,Addr2,City,State,Zip,Country,AuthCode,UserType,UnitUse\n";
    $strQuery = "SELECT * FROM tblUsers;";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
        print "$Row[vcName],$Row[vcCell],$Row[vcEmail],$Row[vcAddr1],$Row[vcAddr2],$Row[vcCity],$Row[vcState],$Row[vcZip],$Row[vcCountry]\n";
      }
    }
    else
    {
      if($QueryData[0] < 0)
      {
        $strMsg = Array2String($QueryData[1]);
        error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
        print "$ErrMsg\n";
      }
    }
    exit;
  }

  require("header.php");

  if($strReferer != $strPageURL and $PostVarCount > 0)
  {
    printPg("Invalid operation, Bad Reference!!!","error");
    exit;
  }

  printPg("User Maintenance","h1");

  if($btnSubmitValue == "Go Back")
  {
    $PostVarCount = 0;
  }

  if($PostVarCount == 0)
  {
    print "<div class=\"Submit\">";
    print "<form method=\"POST\">\n";
    print "<input type=\"Submit\" value=\"Add New User\" name=\"btnSubmit\">\n";
    print "</form>\n";
    print "</div>";
    printPg("Lookup Existing user","h2");
    print "<div class=\"Submit\">";
    print "<form method=\"POST\">";
    print "Search by name:<input type=\"text\" name=\"txtName\" size=\"25\">";
    print "<input type=\"Submit\" value=\"Search\" name=\"btnSubmit\">";
    print "</form>";
    print "</div>";
    print "<div class=\"Submit\">";
    print "<form method=\"POST\">\n";
    print "<input type=\"Submit\" value=\"Export user to CSV file\" name=\"btnSubmit\">\n";
    print "</form>\n";
    print "</div>";
  }

  if($btnSubmitValue == "Search")
  {
    $strName = CleanReg(substr(trim($_POST["txtName"]),0,49));
    $strQuery = "select iUserID, vcName, vcEmail, vcMFASecret from tblUsers ";
    $strQuery .= "where vcName like '%$strName%' order by vcName;";
    $crit = "name contains $strName";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      print "<table class=\"MainText\" border=\"0\" cellPadding=\"4\" cellSpacing=\"0\">\n";
      foreach($QueryData[1] as $Row)
      {
        print "<tr valign=\"top\">\n";
        print "<td>$Row[vcName]</td>\n";
        print "<td>$Row[vcEmail]</td>\n";
        if($Row["vcMFASecret"] == "")
        {
          print "<td>No MFA</td>\n";
          print "<td><form method=\"POST\">\n<input type=\"Submit\" value=\"View\" name=\"btnSubmit\">";
          print "<input type=\"hidden\" value=\"$Row[iUserID]\" name=\"UserID\"></form>\n</td>\n";
        }
        else
        {
          print "<td>MFA Enabled!!!</td>\n";
          print "<td><form method=\"POST\">\n<input type=\"Submit\" value=\"View\" name=\"btnSubmit\">";
          print "<input type=\"hidden\" value=\"$Row[iUserID]\" name=\"UserID\"></form>\n</td>\n";
          print "<td><form method=\"POST\">\n<input type=\"Submit\" value=\"Reset MFA\" name=\"btnSubmit\">";
          print "<input type=\"hidden\" value=\"$Row[iUserID]\" name=\"UserID\"></form>\n</td>\n";
        }
        print "</tr>\n";
      }
      print "</table>\n";
    }
    else
    {
      if($QueryData[0] == 0)
      {
        print "<tr><td>No registration found where $crit</td></tr>";
      }
      else
      {
        $strMsg = Array2String($QueryData[1]);
        error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
        printPg($ErrMsg,"error");
      }
    }
  }

  if($btnSubmitValue == "View")
  {
    $strUserID = intval(substr(trim($_POST["UserID"]),0,9));
    print "<div class=\"SmallCenterBox\">\n";
    print "RegistrationID: $strUserID<br>\n";
    $strQuery = "select * from tblUsers where iUserID = $strUserID;";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
        print "{$Row['vcName']}<br>\n";
        print "{$Row['vcAddr1']}<br>\n";
        print "{$Row['vcAddr2']}<br>\n";
        print "{$Row['vcCity']}, {$Row['vcState']} {$Row['vcZip']}<br>\n";
        print "{$Row['vcCountry']}<br>\n";
        print "{$Row['vcEmail']}<br>\n";
        print "{$Row['vcCell']}<br>\n";
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

    if($Row["vcMFASecret"] == "")
    {
      print "No MFA<br>\n";
      $bMFA = false;
    }
    else
    {
      print "MFA Enabled!!!<br>\n";
      $bMFA = true;
    }

    $strQuery = "SELECT vcPrivName FROM tblprivlevels where iPrivLevel = {$Row['iPrivLevel']};";
    $PrivName = GetSQLValue($strQuery);
    if($PrivName == "")
    {
      $PrivName = $Row["iPrivLevel"];
    }

    printPg("Authorization level is set to $PrivName","normal");

    if($Row["dtLastLogin"])
    {
      $LastLogin = "on " . date('l F jS Y \a\t G:i',strtotime($Row["dtLastLogin"]));
    }
    else
    {
      $LastLogin = "never";
    }
    printPg("Last logged in $LastLogin\n","normal");
    if($WritePriv <=  $Priv)
    {
      print "<form method=\"POST\">\n";
      print "<div class=\"Submit\"><input type=\"Submit\" value=\"Edit\" name=\"btnSubmit\"></div>\n";
      print "<div class=\"Submit\"><input type=\"Submit\" value=\"Delete Account\" name=\"btnSubmit\"></div>\n";
      if($bMFA)
      {
        print "<input type=\"Submit\" value=\"Reset MFA\" name=\"btnSubmit\">";
      }
      print "<input type=\"hidden\" name=\"BeenSubmitted\" value=\"false\">\n";
      print "<input type=\"hidden\" value=\"$strUserID\" name=\"UserID\"></form>\n";
    }
    print "</div>\n";
  }

  if($btnSubmitValue == "Edit")
  {
    $strUserID = intval(substr(trim($_POST["UserID"]),0,9));
    require("UserDBVar.php");
    printPg("RegistrationID: $strUserID","center");
    print "<form method=\"POST\" accept-charset=\"utf-8\">\n";
    require("UserRegForm.php");
    print "<tr>\n";
    print "<td width=\"280\" align=\"right\" class=\"lbl\">Priviledge Level:</td>\n";
    print "<td>\n";
    $strQuery = "select * from tblprivlevels where iPrivLevel <= $Priv;";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      print "<select size=\"1\" name=\"cmbPrivLevel\">\n";
      foreach($QueryData[1] as $Row2)
      {
        if($Row2["iPrivLevel"] == $iPrivLevel)
        {
          print "<option selected value=\"{$Row2['iPrivLevel']}\">{$Row2['vcPrivName']}</option>\n";
        }
        else
        {
          print "<option value=\"{$Row2['iPrivLevel']}\">{$Row2['vcPrivName']}</option>\n";
        }
      }
      print "</select>\n";
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

    print "</td>\n";
    print "</tr>\n";
    print "<tr><td colspan=\"2\" align=\"center\">\n";
    print "<div class=\"Submit\"><input type=\"submit\" value=\"Submit\" name=\"btnSubmit\"></div>\n";
    print "</td></tr>";
    print "<tr><td colspan=\"2\" align=\"center\">";
    print "<div class=\"Submit\"><input type=\"submit\" value=\"Delete Account\" name=\"btnSubmit\">";
    print "<input type=\"hidden\" name=\"BeenSubmitted\" value=\"false\">\n";
    print "<input type=\"hidden\" name=\"UserID\" size=\"5\" value=\"$strUserID\"></div>\n";
    print "</td></tr>";
    print "</table></form>\n";
  }

  if($btnSubmitValue == "Add New User")
  {
    $strName = "";
    $strAddr1 = "";
    $strAddr2 = "";
    $strCity = "";
    $strState = "";
    $strZip = "";
    $strCountry = "";
    $strPhone = "";
    $iPrivLevel = "";
    $strEmail = "";
    $strUserID ="";
    $strCell = "";
    $strBdate = "";
    $strWedAnn = "";
    $strHealth = "";
    $strLocate = "";

    print "<form method=\"POST\" accept-charset=\"utf-8\">\n";
    require("UserRegForm.php");
    print "<tr>\n";
    print "<td width=\"280\" align=\"right\" class=\"lbl\">Priviledge Level:</td>\n";
    print "<td>\n";
    $strQuery = "select * from tblprivlevels where iPrivLevel <= $Priv;";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      print "<select size=\"1\" name=\"cmbPrivLevel\">\n";
      foreach($QueryData[1] as $Row2)
      {
        print "<option value=\"{$Row2['iPrivLevel']}\">{$Row2['vcPrivName']}</option>\n";
      }
      print "</select>\n";
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

    print "</td>\n";
    print "</tr>\n";
    print "<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"Add User\" name=\"btnSubmit\"></td></tr>";
    print "</table></form>\n";
  }

  if($btnSubmitValue == "Reset MFA")
  {
    $iRegNum = intval(trim($_POST["UserID"]));
    $strQuery = "UPDATE tblUsers SET vcMFASecret='' WHERE iUserID=$iRegNum;";
    if(UpdateSQL($strQuery,"update"))
    {
      printPg("MFA Successfully removed","note");
    }
    else
    {
      printPg("Failed to remove MFA","error");
    }
    $strQuery = "UPDATE tblUsrPrefValues SET vcValue='True' WHERE iUserID = $iRegNum AND iTypeID = 3;";
    if(UpdateSQL($strQuery,"update"))
    {
      printPg("Email MFA successfully enabled","note");
    }
    else
    {
      printPg("Failed to enable Email MFA","error");
    }
  }

  if($btnSubmitValue =="Delete Account")
  {
    $iRegNum = intval(trim($_POST["UserID"]));
    $BeenSubmitted = trim($_POST["BeenSubmitted"]);

    if($iRegNum)
    {
      if($BeenSubmitted == "True")
      {
        $strQuery = "Delete from tblUsers where iUserID='$iRegNum';";
        if(UpdateSQL($strQuery,"delete"))
        {
          print "Account Deleted successful<br>\n";
        }
        else
        {
          $strError = "Database update failed. \n";
          $strError .= "$strQuery\n";
          error_log($strError);
          if(EmailText("$SupportEmail","Automatic Error Report", $strError . "\n\n\n" . $strQuery ,"From:$SupportEmail"))
          {
            printPg("We seem to be experiencing technical difficulties. " .
                  "We have been notified. Please try again later. If you have any " .
                  "questions you can contact us at $SupportEmail.","error");
          }
          else
          {
            printPg("We seem to be experiencing technical difficulties. " .
                  "Please send us a message at $SupportEmail with information about " .
                  "what you were doing.","error");
          }
        }
      }
      else
      {
        $strQuery = "select vcName from tblUsers where iUserID = $iRegNum;";
        $strUserName = GetSQLValue($strQuery);
        print "<center>\n<form method=\"post\">\n";
        printPg("Are you sure you want to delete the account for $strUserName? <br>\n".
                "Just leave this page anyway you please if you do not want to delete it. ".
                "Otherwise press \"Delete Account\" again.","error");
        print "<input type=\"submit\" value=\"Delete Account\" name=\"btnSubmit\"><br>\n";
        print "<input type=\"hidden\" name=\"BeenSubmitted\" value=\"True\">\n";
        print "<input type=\"hidden\" name=\"UserID\" value=\"$iRegNum\">\n";
        print "</form>\n</center>\n";
      }
    }
    else
    {
      printPg("Registration number seems to have gotten lost in transport. Please try again" .
            "<br>Feel free to contact us at $SupportEmail if you have questions.","error");
    }
  }

  if($btnSubmitValue == "Add User")
  {
    require_once("CleanReg.php");
    $iLevel = intval($_POST["cmbPrivLevel"]);

    if($strEmail)
    {
      $strNameParts = explode(" ",$strName);
      $HowMany = count($strNameParts);
      if($HowMany==1)
      {
        print "Please provide both first and last name";
        print "<form method=\"POST\">\n";
        require_once("UserRegForm.php");
        print "<tr>\n";
        print "<td width=\"280\" align=\"right\" class=\"lbl\">Priviledge Level:</td>\n";
        print "<td>\n";
        $strQuery = "select * from tblprivlevels where iPrivLevel <= $Priv;";
        $QueryData = QuerySQL($strQuery);
        if($QueryData[0] > 0)
        {
          print "<select size=\"1\" name=\"cmbPrivLevel\">\n";
          foreach($QueryData[1] as $Row2)
          {
            print "<option value=\"{$Row2['iPrivLevel']}\">{$Row2['vcPrivName']}</option>\n";
          }
          print "</select>\n";
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
        print "</td>\n";
        print "</tr>\n";
        print "<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"Add User\" name=\"btnSubmit\"></td></tr>";
        print "</table></form>\n";
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
      print "Can't create new user without an email. Contact $SupportEmail if you have any questions.";
    }
    print "<form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form>";
  }
  if($btnSubmitValue == "Submit")
  {
    require_once("CleanReg.php");
    $iLevel = intval($_POST["cmbPrivLevel"]);
    if(!$bSpam)
    {
      require("UserUpdate.php");
      printPg("Update Successful","note");
    }
  }
  print "<div class=\"Submit\"><form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form></div>";
  require("footer.php");
?>