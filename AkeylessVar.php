<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
  */

  $arrname = array();
  $arrname[] = "EMAILPWD";
  $arrname[] = "EMAILSERVER";
  $arrname[] = "EMAILUSER";
  $arrname[] = "EMAILPORT";
  $arrname[] = "USESSL";
  $arrname[] = "USESTARTTLS";
  $arrname[] = "MYSQL_HOST";
  $arrname[] = "MYSQL_DB";
  $arrname[] = "MYSQL_USER";
  $arrname[] = "MYSQL_PASSWORD";
  $arrname[] = "TWILIO_KEY";
  $arrname[] = "TWILIO_NUM";
  $arrname[] = "TWILIO_SID";

  $arrSecretValues = FetchKeylessStatic($arrname);
  if(array_key_exists("error",$arrSecretValues))
  {
    error_log("Failed to fetch secrets from AKEYLESS. ".$arrSecretValues["error"]);
    ShowErrHead();
  }
  else
  {
    $DBServerName = $arrSecretValues["MYSQL_HOST"];
    $DefaultDB = $arrSecretValues["MYSQL_DB"];
    $UID = $arrSecretValues["MYSQL_USER"];
    $PWD = $arrSecretValues["MYSQL_PASSWORD"];
    $MailUser = $arrSecretValues["EMAILUSER"];
    $MailPWD = $arrSecretValues["EMAILPWD"];
    $MailHost = $arrSecretValues["EMAILSERVER"];
    $MailHostPort = $arrSecretValues["EMAILPORT"];
    $UseSSL = $arrSecretValues["USESSL"];
    $UseStartTLS = $arrSecretValues["USESTARTTLS"];
    $TwilioSID = $arrSecretValues["TWILIO_SID"];
    $FromNumber = $arrSecretValues["TWILIO_NUM"];
    $TwilioToken = $arrSecretValues["TWILIO_KEY"];
  }
?>
