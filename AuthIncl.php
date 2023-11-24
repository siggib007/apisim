<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
  
  Part of the authentication routine, required in auth.php
  */
  
  $_SESSION["auth_username"] = $Row["vcName"];
  $_SESSION["auth_UID"] = $Row["vcUID"];
  $_SESSION["UID"] = $iUserID;
  $_SESSION["dtLogin"] = $dtNow;
  $_SESSION["iPrivLevel"] = $iPrivlvl;
  $_SESSION["LastActivity"] = time();
  $_SESSION["LoginTime"] = $dtNow;

  $strActivity = "Login";
  $arrTypes = array("SMS"=>"5","email"=>"4");

  NotifyActivity($strActivity,$arrTypes);

  if($strLastUpdated=="")
  {
    $strReturn = "myprofile.php";
  }

  $strQuery = "update tblUsers set dtLastLogin = '$dtNow' where iUserID='$iUserID'";
  if(UpdateSQL($strQuery,"update"))
  {
    header("Location: " . $strReturn );
  }
?>
