<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
  
  Page to display content of the spam log table
  */

	require("header.php");
	$LimitCount = $ConfArray["MaxSpamLog"];
	printPg("Spam Log","h1");
	printPg("Limited to the most recent $LimitCount records","h2");
	$strQuery = "SELECT iLogID, dtLogDateTime, vcIPAddress, vcContent FROM tblSpamLog order by dtLogDateTime desc limit $LimitCount;";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    print "<table class=OutlineCenter>\n";
    print "<tr>\n";
    print "<th class=OutlineCenter>ID</th>\n";
    print "<th class=OutlineCenter>Time Stamp</th>\n";
    print "<th class=OutlineCenter>Source IP</th>\n";
    print "<th class=OutlineCenter>Content</th>\n";
    print "</tr>\n";
    foreach($QueryData[1] as $Row)
    {
      print "<tr>\n";
      print "<td class=OutlineCenter>$Row[iLogID]</td>\n";
      print "<td class=OutlineCenter>$Row[dtLogDateTime]</td>\n";
      print "<td class=OutlineCenter>$Row[vcIPAddress]</td>\n";
      print "<td class=OutlineCenter>$Row[vcContent]</td>\n";
      print "</tr>\n";
    }
    print "</table>\n";
  }
  else
  {
    if($QueryData[0] == 0)
    {
      printPg("No Records","note");
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
