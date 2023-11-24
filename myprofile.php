<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Main profile page that gives an overview over your profile
  */

  require("header.php");

  $strUserID = $_SESSION["UID"];

  printPg("My Profile","h1");

  $strQuery = "select * from tblUsers where iUserID = $strUserID;";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $strName = $Row["vcName"];
      $strAddr1 = $Row["vcAddr1"];
      $strAddr2 = $Row["vcAddr2"];
      $strCity = $Row["vcCity"];
      $strState = $Row["vcState"];
      $strZip = $Row["vcZip"];
      $strCountry = $Row["vcCountry"];
      $strEmail = $Row["vcEmail"];
      $strCell = $Row["vcCell"];
      $iPrivLevel = $Row["iPrivLevel"];
      $strLastLogin = $Row["dtLastLogin"];
    }
  }
  else
  {
    if($QueryData[0] == 0)
    {
      $strName      = "User with ID of $strUserID not found";
      $strAddr1     = "";
      $strAddr2     = "";
      $strCity      = "";
      $strState     = "";
      $strZip       = "";
      $strCountry   = "";
      $strEmail     = "";
      $strCell      = "";
      $iPrivLevel   = "";
      $strLastLogin = "";
    }
    else
    {
      $strMsg = Array2String($QueryData[1]);
      error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
      printPg("$ErrMsg","error");
    }
  }

  print "<div class=\"MainTextCenter\">\n";
  print "RegistrationID: $strUserID<br>\n";
  print "$strName<br>\n";
  if($strAddr1 != "")
  {
    print "$strAddr1<br>\n";
  }
  if($strAddr2 != "")
  {
    print "$strAddr2<br>\n";
  }
  if($strCity != "")
  {
    print "$strCity, $strState $strZip <br>\n";
  }
  print "$strCountry<br>\n";
  print "$strEmail<br>\n";
  print "$strCell<br>\n";

  $strQuery = "SELECT vcPrivName FROM tblprivlevels where iPrivLevel = $iPrivLevel;";
  $PrivName = GetSQLValue($strQuery);
  if($PrivName == "" or $PrivName == 0)
  {
    $PrivName = $iPrivLevel;
  }

  print "Authorization level is set to $PrivName<br>\n";

  if($strLastLogin)
  {
    $LastLogin = "on " . date('l F jS Y \a\t G:i',strtotime($strLastLogin));
  }
  else
  {
    $LastLogin = "never";
  }
  print "Last logged in $LastLogin";
  print "</div>";

  require("footer.php");
?>
