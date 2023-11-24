<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Handles the case where all secrets are in environment variables.
  */

  $DBServerName = getenv("MYSQL_HOST");
  $UID = getenv("MYSQL_USER");
  $PWD = getenv("MYSQL_PASSWORD");
  $MailUser = getenv("EMAILUSER");
  $MailPWD = getenv("EMAILPWD");
  $MailHost = getenv("EMAILSERVER");
  $MailHostPort = getenv("EMAILPORT");
  $UseSSL = getenv("USESSL");
  $UseStartTLS = getenv("USESTARTTLS");
  $TwilioToken = getenv("TWILIO_KEY");
  $FromNumber = getenv("TWILIO_NUM");
  $TwilioSID = getenv("TWILIO_SID");
?>