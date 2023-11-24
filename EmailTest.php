<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Simple email compose page to test email sending functionality.
  Be careful about leaving this page on a production system
  Strongly advice you only have this on a local dev machine for testing
  */

	require("header.php");
	if($strReferer != $strPageURL and $PostVarCount > 0)
	{
    printPg("Invalid operation, Bad Reference!!!","error");
    exit;
	}
	$strFileName = "";
	$strAttach = "";
  if(isset($_POST["btnSubmit"]))
  {
    $btnSubmit = $_POST["btnSubmit"];
  }
  else
  {
    $btnSubmit = "";
  }
  $TestWarn = $TextArray["TestWarn"];
	printPg("Custom Email Composer","h1");
	printPg("Do not expose this site to the internet","alert");
	printPg("$TestWarn","note");

	print "<center>\n";
	printPg("Fill out this form and hit send and your message will be sent through your configured email service","normal");
	if($btnSubmit == "Send")
	{
		$strFromName = CleanReg(substr(trim($_POST["txtFromName"]),0,25));
		$strToName = CleanReg(substr(trim($_POST["txtToName"]),0,25));
		$strFromEmail = CleanReg(substr(trim($_POST["txtFromEmail"]),0,25));
		$strToEmail = CleanReg(substr(trim($_POST["txtToEmail"]),0,25));
		$strSubject = CleanReg(substr(trim($_POST["txtSubject"]),0,75));
		$FromEmail = "$strFromName|$strFromEmail";
		$toEmail = "$strToName|$strToEmail";

		$strAddHeader = CleanReg($_POST["txtHeader"]);
		$strHTMLMsg = $_POST["txtBody"];

		$arrAddHeader = explode("\n",$strAddHeader);

		print "<h2>About to send the following email:</h2>\n";
		print "<b>From:</b> $FromEmail <br>\n";
		print "<b>To:</b> $toEmail <br>\n";
		print "<b>Subject:</b> $strSubject <br>\n";
		print "<b>Additional Email Headers:</b> $strAddHeader <br>\n";
		print "<h3>Body:</h3>\n$strHTMLMsg<br>\n";
    print "<h3>Sending via:</h3>\n";
		print "<b>Host:</b>$GLOBALS[MailHost] <br>\n";
		print "<b>Port:</b> $GLOBALS[MailHostPort] <br>\n";
		print "<b>TLS:</b> $GLOBALS[UseSSL] <br>\n";

		$response = SendHTMLAttach($strHTMLMsg, $FromEmail, $toEmail, $strSubject, $strFileName, $strAttach,$arrAddHeader);
		print "<h3>$response</h3>\n";
  }
  else
  {
    print "<form method=\"POST\">\n";
    print "<span class=\"lbl\">From Name:</span>\n";
    print "<input type=\"text\" name=\"txtFromName\" size=\"25\">\n";
    print "<span class=\"lbl\">From email:</span>\n";
    print "<input type=\"text\" name=\"txtFromEmail\" size=\"25\"></br>\n";
    print "<span class=\"lbl\">To Name:</span>\n";
    print "<input type=\"text\" name=\"txtToName\" size=\"25\">\n";
    print "<span class=\"lbl\">To email:</span>\n";
    print "<input type=\"text\" name=\"txtToEmail\" size=\"25\"></br>\n";
    print "<span class=\"lbl\">Subject:</span>\n";
    print "<input type=\"text\" name=\"txtSubject\" size=\"75\">\n<br>\n";
    print "<span class=\"lbl\">Additional Custom Headers:<br><i>Put each header on their own line in the format of name:value</i></span><br>\n";
    print "<textarea name=\"txtHeader\" rows=\"5\" cols=\"75\"></textarea>\n<br>\n";
    print "<span class=\"lbl\"><br>Message body HTML:</br></span>\n";
    print "<textarea name=\"txtBody\" rows=\"20\" cols=\"120\"></textarea>\n<br>\n";
    print "<div align=\"center\"><input type=\"Submit\" value=\"Send\" name=\"btnSubmit\"></div>\n";
    print "</form>\n";
  }
  print "</center>";

	require("footer.php");
?>