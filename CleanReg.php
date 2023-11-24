<?php
      /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Part of the User Registration and management system
   Code to ensure all user input is valid, clean and free of injection attemps
  */

  $bSpam = FALSE;
  $strName = substr(trim($_POST["txtName"]),0,49);
  $strAddr1 = substr(trim($_POST["txtAddr1"]),0,49);
  $strAddr2 = substr(trim($_POST["txtAddr2"]),0,49);
  $strCity = substr(trim($_POST["txtCity"]),0,49);
  $strState = substr(trim($_POST["cmbState"]),0,49);
  $strZip = substr(trim($_POST["txtZip"]),0,9);
  $strCountry = substr(trim($_POST["cmbCountry"]),0,99);
  $strEmail = substr(trim($_POST["txtEmail"]),0,49);
  $strOEmail = substr(trim($_POST["txtOEmail"]),0,49);
  $strCell = substr(trim($_POST["txtCell"]),0,19);
  if(SpamDetect($strName))
  {
    printPg("URL detected in Name field","error");
    $bSpam = TRUE;
  }
  if(SpamDetect($strAddr1))
  {
    printPg("URL detected in Address 1 field","error");
    $bSpam = TRUE;
  }
  if(SpamDetect($strAddr2))
  {
    printPg("URL detected in Address 2 field","error");
    $bSpam = TRUE;
  }
  if(SpamDetect($strCity))
  {
    printPg("URL detected in City field","error");
    $bSpam = TRUE;
  }
  if(SpamDetect($strZip))
  {
    printPg("URL detected in Zip field","error");
    $bSpam = TRUE;
  }
  if(SpamDetect($strEmail))
  {
    printPg("URL detected in email field","error");
    $bSpam = TRUE;
  }
  if(SpamDetect($strCell))
  {
    printPg("URL detected in Cell phone field","error");
    $bSpam = TRUE;
  }
  $strName = CleanReg($strName);
  $strAddr1 = CleanReg($strAddr1);
  $strAddr2 = CleanReg($strAddr2);
  $strCity = CleanReg($strCity);
  $strZip = CleanReg($strZip);
  $strEmail = CleanReg($strEmail);
  $strOEmail = CleanReg($strOEmail);
  $strCell = CleanReg($strCell);
  if(strtolower($bUSOnly) == "true")
  {
    $strTemp = format_phone_us($strCell);
    if(substr($strTemp, 0,2) != "+1")
    {
      printPg("$strCell $strTemp. Please leave empty rather than put invalid number.","error");
    }
    else
    {
      $strCell = $strTemp;
    }
  }
  else
  {
    $strTemp = ValidateIntlPhoneNumber($strCell);
    if($strTemp != "")
    {
      printPg("$strCell $strTemp","error");
    }
  }
  if($bSpam)
  {
    printPg("Your update has been flagged as spam as invalid or missing required data was detected in one or more input fields. ","error");
    printPg("Your changes were not saved. Your IP has been logged","error");
  }
?>
