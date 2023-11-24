<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
  */

  $LastIndex = $HowMany - 1;
  $FName = $strNameParts[0];
  $FName = preg_replace("/[^a-z0-9]*/i", "", $FName);
  $LName = $strNameParts[$LastIndex];
  $LName = preg_replace("/[^a-z0-9]*/i", "", $LName);
  $strUID = CleanReg(strtolower(substr($FName,0,1).substr($LName,0,9)));
  $strUID = preg_replace("/[^a-z0-9]*/i", "", $strUID);
  if($PWDLength%2>0)
  {
    $PWDLength = $PWDLength + 1;
  }

  $Password = bin2hex(random_bytes($PWDLength/2));
  $EmailCount = 0;
  $strQuery = "select count(*) iEmailCount from tblUsers where vcEmail = '$strEmail'";
  $EmailCount = GetSQLValue($strQuery);
  if($EmailCount>0)
  {
    printPg("The email address specified is already registered","attn");
  }
  else
  {
    $strQuery = "select count(*) iRowCount from tblUsers where vcUID = '$strUID'";
    $RowCount = GetSQLValue($strQuery);

    $i = 1;
    $strUID2 = $strUID;
    while($RowCount>0)
    {
      $strUID2 = $strUID.$i;
      $strQuery = "select count(*) iRowCount from tblUsers where vcUID = '$strUID2'";
      $RowCount = GetSQLValue($strQuery);
      $i += 1;
    }
    $strUID   = $strUID2;
    $strURL   = "http://" . $strHost . $ROOTPATH . "Login.php";
    $StrMsg   = "You have been given an account on $strHost.\n\n";
    $StrMsg2  = "Your username is $strUID and your Password is: $Password\n\n";
    $StrMsg2 .= "Please login into your account at $strURL ";
    $StrMsg2 .= "and confirm your account to activate it.\n";
    $strNotification  = "$strName has registered for a new account on $strHost.\n";
    $strNotification .= "They provided $strCell as their cell.\n";
    $strNotification .= "The email they provided is $strEmail and they listed their address as:\n";
    $strNotification .= " $strAddr1\n $strAddr2\n $strCity, $strState $strZip";
    $PWD = password_hash($Password, PASSWORD_DEFAULT);
    $strQuery = "INSERT INTO tblUsers (vcName, vcEmail, vcAddr1, vcAddr2, vcCity, vcState, vcZip, " .
                            "vcCountry, vcUID, vcPWD, dMailSent, tMailSent, iPrivLevel,vcCell,bChangePWD) " .
                            "VALUES ('$strName', '$strEmail', '$strAddr1', '$strAddr2', '$strCity', '$strState', " .
                            "'$strZip','$strCountry', '$strUID', '$PWD', CURDATE(), CURTIME(), '$iLevel', '$strCell',1)";
    if(UpdateSQL($strQuery,"insert"))
    {
      EmailText($ProfileNotify, "New user registration notification",$strNotification, $FromEmail);
      $toEmail = "\"$strName\" <$strEmail>";
      $StrMsg = str_replace("\\'","'",$StrMsg);
      $StrMsg = str_replace("&quot;",'"',$StrMsg);
      if(EmailText($toEmail,"Your new account at $strHost",$StrMsg . $StrMsg2,$FromEmail))
      {
        printPg("The account was created successful and an confirmation email was sent to $strEmail.","note");
        $bRegOK = TRUE;
      }
      else
      {
        printPg("Signup was successful but Failed to send the confirmation email","error");
        printPg("Please notify us at $SupportEmail, including the email address you used to sign up with.","error");
      }
      $bSuccess = TRUE;
    }
    else
    {
      $strError = "Database insert failed.\n";
      $strError .= "$strQuery\n";
      printPg("Database insert failed:","error");
      error_log($strError);
      if(EmailText("$SupportEmail","Automatic Error Report",$strError,$FromEmail))
      {
        printPg("We seem to be experiencing technical difficulties. We have been notified. Please try again later. Thank you.","error");
      }
      else
      {
        printPg("We seem to be experiencing technical difficulties. " .
              "Please send us a message at $SupportEmail with information about " .
              "what you were doing.</p>","error");
      }
      $bSuccess = FALSE;
    }
  }
?>
