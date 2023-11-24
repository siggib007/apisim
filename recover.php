<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Page to help reset lost password. Required by LoginIncl.php
  */

  $PostVarCount = count($_POST);
  if($PostVarCount == 0 )
  {
    header("Location: index.php" );
  }

  require("header.php");

  $strEmail = CleanReg(trim($_POST["txtRecEmail"]));

  $RecoverAck = $TextArray["RecoverAck"];

  if($strEmail)
  {
    printPg("Recovering the password for $strEmail","normal");
    $strQuery = "select * from tblUsers where vcEmail = '$strEmail'";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
        $iUserID = $Row["iUserID"];
        $strUID =  $Row["vcUID"];
        $strName =  $Row["vcName"];
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

    if($PWDLength%2>0)
    {
      $PWDLength = $PWDLength + 1;
    }

    $Password = bin2hex(random_bytes($PWDLength/2));
    $PWD = password_hash($Password, PASSWORD_DEFAULT);
    $strQuery = "update tblUsers set vcPWD = '$PWD', bChangePWD=1 where iUserID='$iUserID'";
    $bUpdate = UpdateSQL($strQuery,"update");
    if($bUpdate)
    {
      $StrMsg = "Per your request login for our site is {$Row['vcUID']} and the new password is $Password";
      if($OSEnv == "win")
      {
        $toEmail = "$strEmail";
        $fromEmail = "From:$eFromAddr";
      }
      else
      {
        $toEmail = "\"$strName\" <$strEmail>";
        $fromEmail = "From:$eFromName <$eFromAddr>";
      }

      if(EmailText($toEmail,"Your Password request",$StrMsg,$fromEmail))
      {
        printPg($RecoverAck,"normal");
      }
    }
    else
    {
      printPg("There was an unknown error when attempting to email your password. Please let us know at $SupportEmail","error");
    }
  }
  else
  {
    printPg("Email is required to look up your password.","error");
  }

  require("footer.php");
?>
