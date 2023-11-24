<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
  */

  $dtNow = date('Y-m-d H:i:s');
  $uuid = uniqid(mt_rand(), true);
  $strURL = $strURL . "EmailUpdate.php?$uuid";
  $strUserID = intval(trim($_POST['UserID']));
  if($strUserID)
  {
    $strQuery = "update tblUsers set vcName = '$strName', vcAddr1 = '$strAddr1', " .
                "vcAddr2 = '$strAddr2', vcCity = '$strCity', vcState = '$strState', vcZip = '$strZip', " .
                "vcCountry = '$strCountry', iPrivLevel = $iLevel, dtUpdated = '$dtNow', vcCell='$strCell' "  .
                " where iUserID='$strUserID'";
    if(UpdateSQL($strQuery,"update"))
    {
      $dtUpdated = $dtNow;
    }

    if($strEmail <> $strOEmail)
    {
      $EmailCount = 0;
      $strQuery = "select count(*) iEmailCount from tblUsers where vcEmail = '$strEmail'";
      $EmailCount = GetSQLValue($strQuery);
      if($EmailCount>0)
      {
        printPg("The new email address specified is registered to a different user","attn");
      }
      else
      {
        $toEmail = "\"$strName\" <$strEmail>";
        $toOldEmail = "\"$strName\" <$strOEmail>";
        $strQuery = "INSERT INTO tblemailupdate (iClientID, vcGUID, vcNewEmail, vcReqIPAdd, dtTimeStamp)"
                        . " VALUES ($iUserID, '$uuid', '$strEmail', '$strRemoteIP', '$dtNow');";
        if(UpdateSQL($strQuery, "insert"))
        {
          $strQuery = "SELECT iChangeID FROM tblemailupdate WHERE vcGUID= '$uuid'";
          $iChangeNum = GetSQLValue($strQuery);
          $strEmailText = "Someone (hopefully you) requested that the email address we have on file for $strName " .
                  "be changed to $strEmail. If you didn't make this request please notify us at $SupportEmail referncing changeID $iChangeNum.\n";
          EmailText($toOldEmail,"Change of email address has been requested",$strEmailText,$FromEmail);
          $strEmailText = "Before your request to update your email address can be processed you need " .
                  "confirm your request by going to $strURL\nIf you no longer wish to make the change " .
                  "or you didn't request this, just delete this message as no action will be taken without you visiting that page.";
          EmailText($toEmail,"Change of email address has been requested",$strEmailText,$FromEmail);
          printPg("Before we can process your change of email address you need to confirm the new email. " .
                  "Please check your new email and follow the instructions in it.<br>\nIf you don't receive the mail " .
                  "please contact $SupportEmail with changeid $iChangeNum.<br>\nPlease note your IP has been recorded.</p>","normal");
        }
      }
    }
  }
  else
  {
    printPg("Can't update without a user ID. Contact $SupportEmail if you have any questions.","error");
    EmailText("$SupportEmail","Automatic Error Report","Failed to update registration for $strName due to missing userid",$FromEmail);
  }
?>
