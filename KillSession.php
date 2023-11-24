<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Destroys the session and thus logs user out
  */

  unset($_SESSION["auth_username"]);
  unset($_SESSION["dtLogin"]);
  unset($_SESSION["iPrivLevel"]);
  unset($_SESSION["LastActivity"]);
  unset($_SESSION["LoginTime"]);
  unset($_SESSION["LogoutReason"]);
  unset($_SESSION["LogoutReasonCount"]);
  unset($_SESSION["UID"]);
  unset($_SESSION["Reason"]);
  unset($_SESSION["ReturnPage"]);
  unset($_SESSION["2FASecret"]);
  $_SESSION = array();
  unset($_SESSION);
  session_destroy();
?>