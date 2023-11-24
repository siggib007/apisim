<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
  */

  require("header.php");

  $arrMFAOptions = LoadMFAOptions($iUserID);

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

  if($btnSubmit =="Reset Recovery Code")
  {
    GenerateRecovery($iUserID);
  }

  if($btnSubmit =="Delete Account")
  {
    $iRegNum = trim($_POST["iUserID"]);
    $BeenSubmitted = trim($_POST["BeenSubmitted"]);

    if($iRegNum)
    {
      if($BeenSubmitted == "True")
      {
        if(UpdateSQL($strQuery, "delete"))
        {
          $strQuery = "Delete from tblUsers where iUserID='$iRegNum';";
          if(UpdateSQL($strQuery))
          {
            print "Account Deleted successful, please close your browser.<br>\n";
            require_once("KillSession.php");
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
      }
      else
      {
        print "<center>\n<form method=\"post\">\n";
        printPg("Are you sure you want to delete your account? Just leave this page anyway you please ".
                 "if you do not want to delete it. Otherwise press \"Delete Account\" again.</p>\n","error");
        print "<input type=\"submit\" value=\"Delete Account\" name=\"btnSubmit\"><br>\n";
        print "<input type=\"hidden\" name=\"BeenSubmitted\" value=\"True\">\n";
        print "<input type=\"hidden\" name=\"iUserID\" value=\"$iRegNum\">\n";
        print "</form>\n</center>\n";
      }
    }
    else
    {
      printPg("Registration number seems to have gotten lost in transport. Please try again" .
            "<br>Feel free to contact us at $SupportEmail if you have questions.","error");
    }
  }

  if($btnSubmit == "")
  {
    if($_SESSION["bMFA_active"])
    {
      printPg("Reset Recovery Code","tmh2");
      print "<div class=\"MainTextCenter\">\n";
      print "To reset your recovery code, click this button.<br>\n";
      print "<form method=\"post\">\n";
      print "<input type=\"submit\" value=\"Reset Recovery Code\" name=\"btnSubmit\">\n";
      print "</form>\n";
      print "</div>\n";
    }
    printPg("Account deletion","tmh2");
    print "<div class=\"MainTextCenter\">\n";
    printPg("If you wish to completely delete your account you can do that here.","normal");
    print "<form method=\"post\">\n";
    print "<input type=\"submit\" value=\"Delete Account\" name=\"btnSubmit\">\n";
    print "<input type=\"hidden\" name=\"BeenSubmitted\" value=\"false\">\n";
    print "<input type=\"hidden\" name=\"iUserID\" size=\"5\" value=\"$iUserID\">\n";
    print "</form>\n";
    print "</div>\n";
  }
  require("footer.php");
?>
