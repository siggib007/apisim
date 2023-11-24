<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
  */

  require_once("header.php");

  $strUserID = $_SESSION["UID"];
  require("UserDBVar.php");

  if($strReferer != $strPageURL and $PostVarCount > 0)
  {
    printPg("Invalid operation, Bad Reference!!!","error");
    exit;
  }

  printPg("My Profile","h1");
  if(isset($_POST["btnSubmit"]))
  {
    $btnSubmit = $_POST["btnSubmit"];
  }
  else
  {
    $btnSubmit = "";
  }

  if($btnSubmit =="Submit")
  {
    //Saving updates to my profile to database
    require_once("CleanReg.php");
    $iLevel = $Priv;
    if(!$bSpam)
    {
      require("UserUpdate.php");
      if($iUserID)
      {
        if($strCell == "")
        {
          $arrTypeIDs = array();
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

          $strTypeList = implode(",",$arrTypeIDs);
          $strQuery = "update tblUsrPrefValues set vcValue = 'False' where iUserID = $iUserID and iTypeID IN ($strTypeList) ;";
          if(UpdateSQL($strQuery, "update"))
          {
            printPg("Since you haven't provided a cell phone, all SMS functionality has been disabled","note");
          }
          else
          {
            printPg("Disabling all SMS functions failed","error");
          }
        }
        $strUID = substr(trim($_POST["txtUID"]),0,19);
        $strOUID = substr(trim($_POST["txtOUID"]),0,19);
        $Password = trim($_POST["txtPWD"]);
        $PWDConf = trim($_POST["txtPWDConf"]);
        $strCleanUID = preg_replace("/[^a-z0-9]*/i", "", $strUID);
        if($strCleanUID != $strUID)
        {
          printPg("New Username contains illegal characters, only a-z and 0-9 are allowed in usernames. ".
                "Nothing was changed, please specify a valid username if you want to change it","error");
        }
        else 
        {
          CleanReg($strUID);
          CleanReg($strOUID);
          CleanReg($Password);
          Cleanreg($PWDConf);
          if($Password !="" or $strOUID != $strUID)
          {
            $strQuery = "select count(*) iRowCount from tblUsers where vcUID = '$strUID' and iUserID <> $iUserID";
            $RowCount = GetSQLValue($strQuery);
            $i = 1;
            $strUID2 = $strUID;
            while($RowCount>0)
            {
              $strUID2 = $strUID.$i;
              $strQuery = "select count(*) iRowCount from tblUsers where vcUID = '$strUID2' and iUserID <> $iUserID";
              $RowCount = GetSQLValue($strQuery);
              $i += 1;
            }

            if(strlen($Password) < $MinPWDLen)
            {
              printPg("Passwords is too short, please supply a password that is at least $MinPWDLen char long.","error");
            }
            else
            {
              $PWD = password_hash($Password, PASSWORD_DEFAULT);
              $strQuery = "";
              if($Password == $PWDConf and $strUID == $strUID2 and $Password != "")
              {
                $strQuery = "UPDATE tblUsers SET vcUID = '$strUID', vcPWD = '$PWD', bChangePWD = 0 WHERE iUserID = '$iUserID'";
              }
              if($Password =="" and $strOUID != $strUID and $strUID == $strUID2)
              {
                printPg("Please change your password when you change your user name.","error");
              }
              if($Password != $PWDConf and $strUID == $strUID2)
              {
                printPg("Passwords do not match so password and username was not changed.","error");
              }
              if($Password == $PWDConf and $strUID != $strUID2)
              {
                printPg("Requested username is already in use could not be changed, however the password will been changed. " .
                      "To change the username use a different username that is not in use. For example $strUID2 is available.","error");
                $strQuery = "UPDATE tblUsers SET vcPWD = '$PWD', bChangePWD = 0 WHERE iUserID = '$iUserID'";
              }
              if($Password != $PWDConf and $strUID != $strUID2)
              {
                printPg("Passwords do not match so password was not changed. Requested username is already in use could not be changed. " .
                      "To change the username Try again and use a different username that is not in use. " .
                      "For example $strUID2 is available. When changing the password make sure you type the same one twice.","error");
              }
              if($strQuery)
              {
                if(UpdateSQL($strQuery, "update"))
                {
                  printPg("Update successful!!","note");
                  $bChangePWD = 0;
                }
              }
            }
          }
        }
      }
    }
    $btnSubmit = "";
  }

  if($btnSubmit == "")
  {
    $strQuery = "SELECT vcPrivName FROM tblprivlevels where iPrivLevel = $Priv;";
    $PrivName = GetSQLValue($strQuery);
    if($PrivName == "")
    {
      $PrivName = $Priv;
    }

    print "<div class=\"MainTextCenter\">\n";
    if($bChangePWD == 1)
    {
      printPg("You are required to change your password. Please provide new password and hit submit.","error");
    }

    if($dtUpdated=="")
    {
      printPg("This account has not been verified. Please verify the information, " .
      "make any needed changes, then submit to verify your information.","error");
    }
    if($strTOTP == "")
    {
      printPg("You do not have MFA setup, to increase the security of your account " .
      "please setup a MFA on the <a href=MFASetup.php>MFA Setup</a> page","note");
    }
    printPg("General Info","h2");
    printPg("RegistrationID: $iUserID","normal");
    $strQuery = "SELECT vcPrivName FROM tblprivlevels where iPrivLevel = $iPrivLevel;";
    $PrivName = GetSQLValue($strQuery);
    if($PrivName == "")
    {
      $PrivName = $Row["iPrivLevel"];
    }

    printPg("Authorization level is set to $PrivName","normal");
    print "</div>\n";
    print "<form method=\"POST\">\n";
    require("UserRegForm.php");
    print "<tr>";
    print "<td colspan=2 align=\"center\" >";
    printPg("Change username and password","h2");
    print "You can change your username and password here,<br>\n";
    print "Only letters a-z and numbers 0-9 are allowed in usernames!<br>\n";
    print "To change your username you have to change your password too<br>";
    print "Also the following characters are stripped out of the password = \ \" '";
    print "</td>";
    print "</tr>";
    print "<tr><td align=\"right\" class=\"lbl\">UserName:</td>\n";
    print "<input type=\"hidden\" name=\"txtOUID\" value=\"$strUID\">";
    print "<td><input type=\"text\" name=\"txtUID\" size=\"50\" value=\"$strUID\"><span class=\"Attn\">Required</span></td></tr>\n";
    print "<tr><td align=\"right\" class=\"lbl\">New Password:</td>\n";
    print "<td><input type=\"password\" name=\"txtPWD\" size=\"50\"><span class=\"Attn\">Required</span></td></tr>\n";
    print "<tr><td align=\"right\" class=\"lbl\">Confirm Password:</td>\n";
    print "<td><input type=\"password\" name=\"txtPWDConf\" size=\"50\"><span class=\"Attn\">Required</span></td></tr>\n";
    print "<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"Submit\" name=\"btnSubmit\"></td></tr>";
    print "</table></form>\n";
  }
  require_once("footer.php");
  ?>
