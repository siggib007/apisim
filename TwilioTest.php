<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Page for testing Twilio SMS functionality
  */

  require("header.php");
 	if($strReferer != $strPageURL and $PostVarCount > 0)
	{
    printPg("Invalid operation, Bad Reference!!!","error");
    exit;
	}

  if(isset($_POST["txtNumber"]))
	{
    $strNumber = CleanReg(trim($_POST["txtNumber"]));
	}
	else
	{
    $strNumber ="";
	}

	if(isset($_POST["txtmsg"]))
	{
    $strMsg = CleanReg(trim($_POST["txtmsg"]));
	}
	else
	{
    $strMsg ="";
	}

	if(isset($_POST["btnSubmit"]))
	{
    $btnSubmit = $_POST["btnSubmit"];
	}
	else
	{
    $btnSubmit = "";
	}

	if($btnSubmit == "Submit")
	{
    $msg = $strMsg;
    $number = $strNumber;
    $response = SendTwilioSMS($msg,$number);
    if($response[0])
    {
      printPg("Message successfully queued for sending","note");
    }
    else
    {
      printPg("A failure occured:","error");
      $arrResponse = json_decode($response[1], TRUE);
      $errmsg = "";
      if(array_key_exists("message",$arrResponse))
      {
        $errmsg .= $arrResponse["message"];
      }
      if(array_key_exists("more_info",$arrResponse))
      {
        $errmsg .= " For more information see " . $arrResponse["more_info"];
      }
      printPg("$errmsg","error");
    }
  }
  
  printPg("Twilio SMS test page","h1");
  $TestWarn = $TextArray["TestSMS"];
	printPg("Do not expose this page to the internet","alert");
	printPg("$TestWarn","note");

  print "<div class=SmallCenterBox>\n";
  print "<form method=\"POST\">\n";
  print "Phone number to send to:";
  print "<input type=\"text\" name=\"txtNumber\" size=\"30\"><br>\n";
  print "Message to send:";
  print "<input type=\"text\" name=\"txtmsg\" size=\"30\"><br>\n";
  print "<input type=\"submit\" value=\"Submit\" name=\"btnSubmit\">\n";
  print "</form>\n";
  print "</div>";

  require("footer.php");
?>
