<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
  */

	$PostVarCount = count($_POST);
	if($PostVarCount == 0 )
	{
		header("Location: index.php" );
	}	
	require_once("DBCon.php");
	$strReferer = $_SERVER["HTTP_REFERER"];
	$strPageNameParts = explode("/",$strReferer);
	$strRefServer = "$strPageNameParts[2]";

	$bUpdate = "n/a";
	$strName = substr(trim($_POST["txtName"]),0,49);
	$strNameParts = explode(" ",$strName);
	$strEmail = substr(trim($_POST["txtEmail"]),0,49);
	$strAddr1 = substr(trim($_POST["txtAddr1"]),0,49);
	$strAddr2 = substr(trim($_POST["txtAddr2"]),0,49);
	$strCity = substr(trim($_POST["txtCity"]),0,49);
	$strState = substr(trim($_POST["cmbState"]),0,49);
	$strZip = substr(trim($_POST["txtZip"]),0,10);
	$strPhone = substr(trim($_POST["txtPhone"]),0,19);
	$strCountry = substr(trim($_POST["cmbCountry"]),0,99);

	$strReason = "";
	$strURLRegx = "#(http://)|(a href)#i";
	if($strHost != $strRefServer)
	{
		$bSpam = "Yes";
		$strReason .= "\n<br>Bad reference";
		$arrReason["Ref"]["Spam"]="Bad reference. Posting server isn't this server, denied!";
		$strContent = "";
	}
	if(preg_match($strURLRegx,$strName))
	{
		$bSpam = "Yes";
		$strReason .= "\n<br>URL in Name";
		$strContent = $strName;
		$arrReason["Name"]["Spam"]="URL in Name";
		$arrReason["Name"]["Cont"]=$strName;
		error_log("URL in Name: $strName");
	}
	if(preg_match($strURLRegx,$strEmail))
	{
		$bSpam = "Yes";
		$strReason .= "\n<br>URL in email";
		$strContent = $strEmail;
		$arrReason["email"]["Spam"]="URL in email";
		$arrReason["email"]["Cont"]=$strEmail;
	}
	if(preg_match($strURLRegx,$strPhone))
	{
		$bSpam = "Yes";
		$strReason .= "\n<br>URL in phone";
		$strContent = $strPhone;
		$arrReason["phone"]["phone"]="URL in phone";
		$arrReason["phone"]["Cont"]=$strPhone;
	}
	if(preg_match($strURLRegx,$strAddr1))
	{
		$bSpam = "Yes";
		$strReason .= "\n<br>URL in Street 1";
		$strContent = $strAddr1;
		$arrReason["Street1"]["Spam"]="URL in Street 1";
		$arrReason["Street1"]["Cont"]=$strAddr1;
	}
	if(preg_match($strURLRegx,$strAddr2))
	{
		$bSpam = "Yes";
		$strReason .= "\n<br>URL in Street 2";
		$strContent = $strAddr2;
		$arrReason["Street2"]["Spam"]="URL in Street 2";
		$arrReason["Street2"]["Cont"]=$strAddr2;
	}

	if(preg_match($strURLRegx,$strCity))
	{
		$bSpam = "Yes";
		$strReason .= "\n<br>URL in Cisty";
		$strContent = $strCity;
		$arrReason["city"]["Spam"]="URL in City";
		$arrReason["city"]["Cont"]=$strCity;
	}
	
	if(preg_match($strURLRegx,$strZip))
	{
		$bSpam = "Yes";
		$strReason .= "\n<br>URL in Zip";
		$strContent = $strZip;
		$arrReason["zip"]["Spam"]="URL in Zip";
		$arrReason["zip"]["Cont"]=$strZip;
	}
	if(preg_match($strURLRegx,$strPhone))
	{
		$bSpam = "Yes";
		$strReason .= "\n<br>URL in Phone";
		$strContent = $strPhone;
		$arrReason["zip"]["Spam"]="URL in Zip";
		$arrReason["zip"]["Cont"]=$strZip;
	}
	
	if($strState == "Please Select State")
	{
		$bValid = "no";
		$strReason = "You failed to select proper value for State.";	
		$arrReason["State"]["invalid"]="You failed to select proper value for State.";
		$arrReason["State"]["Cont"]=$strState;
	}
	if(!$strName)
	{
		$bValid = "no";
		$strReason .= "\n<br>You failed to provide name.";
		$arrReason["Name"]["invalid"]="Name is required";
		$arrReason["Name"]["Cont"]=$strName;		
	}
	if(!$strEmail)
	{
		$bValid = "no";
		$strReason .= "\n<br>You failed to provide email address.";
		$arrReason["email"]["invalid"]="Email is required";
		$arrReason["email"]["Cont"]=$strEmail;		
	}
	if(!$strAddr1)
	{
		$bValid = "no";
		$strReason .= "\n<br>You failed to provide Street.";
		$arrReason["Street1"]["invalid"]="Address is required";
		$arrReason["Street1"]["Cont"]=$strAddr1;		
	}
	if(!$strCity)
	{
		$bValid = "no";
		$strReason .= "\n<br>You failed to provide city.";
		$arrReason["city"]["invalid"]="City is required";
		$arrReason["city"]["Cont"]=$strCity;		
	}

	if(!$strZip)
	{
		$bValid = "no";
		$strReason .= "\n<br>You failed to provide Zip.";
		$arrReason["zip"]["invalid"]="Zip is required";
		$arrReason["zip"]["Cont"]=$strZip;
	}
	$strName = str_replace("\\","",$strName);
	$strName = strip_tags($strName);
	$strName = str_replace("'","\'",$strName);
	$strName = str_replace('"',"&quot;",$strName);
	$strAddr1 = str_replace("\\","",$strAddr1);
	$strAddr1 = strip_tags($strAddr1);
	$strAddr1 = str_replace("'","\'",$strAddr1);
	$strAddr1 = str_replace('"',"&quot;",$strAddr1);
	$strAddr2 = str_replace("\\","",$strAddr2);			
	$strAddr2 = strip_tags($strAddr2);
	$strAddr2 = str_replace("'","\'",$strAddr2);
	$strAddr2 = str_replace('"',"&quot;",$strAddr2);
	$strCity = str_replace("\\","",$strCity);			
	$strCity = strip_tags($strCity);
	$strCity = str_replace("'","\'",$strCity);
	$strCity = str_replace('"',"&quot;",$strCity);
	$strZip = str_replace("\\","",$strZip);
	$strZip = strip_tags($strZip);
	$strZip = str_replace("'","\'",$strZip);
	$strZip = str_replace('"',"&quot;",$strZip);
	$strPhone = str_replace("\\","",$strPhone);
	$strPhone = strip_tags($strPhone);
	$strPhone = str_replace("'","\'",$strPhone);
	$strPhone = str_replace('"',"&quot;",$strPhone);
	$strEmail = str_replace("'","",$strEmail);
	$strEmail = strip_tags($strEmail);
	$strEmail = str_replace("\\","",$strEmail);
	$strEmail = str_replace('"',"&quot;",$strEmail);
	$_SESSION["POSTArray"] = $_POST;

?>