<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Modular code to insert contact information into any page
  */

  print "<div class=\"SmallCenterBox\">\n";
  $strQuery = "SELECT * FROM tblContactInfo WHERE vcType = 'Address' ORDER BY iSequence";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    printPg("Address","tmh2");
    foreach($QueryData[1] as $Row)
    {
      print $Row["vcValue"] . "<br>\n";
    }
  }
  else
  {
    $strMsg = Array2String($QueryData[1]);
    error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
    printPg($ErrMsg,"error");
  }

  $strQuery = "SELECT * FROM tblContactInfo WHERE vcType = 'Email' ORDER BY iSequence";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    printPg("Electronic mail","tmh2");
    foreach($QueryData[1] as $Row)
    {
      print $Row["vcLabel"] . ": <a href=\"mailto:" . $Row["vcValue"] . "\">" .
            $Row["vcValue"] . "</a><br>\n";
    }
  }
  else
  {
    $strMsg = Array2String($QueryData[1]);
    error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
    printPg($ErrMsg,"error");
  }

  $strQuery = "SELECT * FROM tblContactInfo WHERE vcType = 'Phone' ORDER BY iSequence";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    printPg("Phone Numbers","tmh2");
    foreach($QueryData[1] as $Row)
    {
      print $Row["vcLabel"] . ": " . $Row["vcValue"] . "<br>\n";
    }
  }
  else
  {
    $strMsg = Array2String($QueryData[1]);
    error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
    printPg($ErrMsg,"error");
  }
  print "</div>\n";
?>
