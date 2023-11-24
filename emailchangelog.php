<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Simple page to display the email change log table
  */

  require("header.php");
  printPg("Email Update Log","h1");
  print "<table border=1>\n";
  print "<tr  class=lbl><th>ID</th><th>User Name</th><th>GUID</th><th>New Email</th><th>Source IP</th><th>Time Stamp</th></tr>\n";
  $strQuery = "SELECT iChangeID, vcName, vcGUID, vcNewEmail, vcReqIPAdd, dtTimeStamp FROM vwemailupdate order by dtTimeStamp desc;";
  $QueryData = QuerySQL($strQuery);

  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      print "<tr><td>$Row[iChangeID]</td><td>$Row[vcName]</td><td>$Row[vcGUID]</td><td>$Row[vcNewEmail]</td>";
      print "<td>$Row[vcReqIPAdd]</td><td>$Row[dtTimeStamp]</td></tr>\n";
    }
    print "</table>\n";
  }
  else
  {
    print "</table>\n";
    if($QueryData[0] == 0)
    {
      printPg("No Data","note");
    }
    else 
    {
      $strMsg = Array2String($QueryData[1]);
      error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
      printPg($ErrMsg,"error");
    }
  }


  require("footer.php");
?>
