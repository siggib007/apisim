<?php 
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Page to handle email updates after user confirms it.
  */

  require("header.php"); 
  $uuid = $_SERVER["QUERY_STRING"];
  $strQuery = "SELECT * FROM tblemailupdate WHERE vcGUID= '$uuid' and dtConfirmed is null";
  $QueryData = QuerySQL($strQuery);

  if($QueryData[0] == 1)
  {
    foreach($QueryData[1] as $Row)
    {
      $strEmail = $Row["vcNewEmail"];
      $iUserID = $Row["iClientID"];
      print "Updating email in record $iUserID to $strEmail<br>\n";
      $strQuery = "update tblUsers set vcEmail = '$strEmail' where `iUserID`= $iUserID";
      if(UpdateSQL($strQuery, "update"))
      {
        $strQuery = "update tblemailupdate set dtConfirmed = now() where vcGUID= '$uuid';";
        UpdateSQL($strQuery, "update");
      }
    }
  }
  else
  {
    if($QueryData[0] < 0)
    {
      $strMsg = Array2String($QueryData[1]);
      error_log("Query of $strQuery failed to return data. Rowcount: $QueryData[0] Msg:$strMsg");
      printPg($ErrMsg,"error");
    }
    else 
    {
      printPg("Invalid Confirmation string provided. Please check your email to ensure that you are using the entire URL " .
              "If you need assistance please contact $SupportEmail.","alert");
    }
  }  
  require("footer.php"); 
?>