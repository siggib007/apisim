<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
  
  Code to be insterted at the bottom of every page.
  */

	print "<br>\n";
	print "<center>\n";

	print "<p class=\"footer\">\n|&nbsp;&nbsp;";
  $strQuery = "SELECT * FROM tblContactInfo WHERE vcType = 'Address' ORDER BY iSequence";
  $QueryData = QuerySQL($strQuery);

  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      print $Row["vcValue"] . "&nbsp;&nbsp;|&nbsp;&nbsp;";
    }
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

  print "&nbsp;&nbsp;<a href=\"contact.php\">Contact Us</a>&nbsp;&nbsp;|\n";
  print "&nbsp;&nbsp;Copyright &copy; 2012 <a href=\"http://www.supergeek.us\" target=\"_blank\">"
  . "Siggi Bjarnason</a>&nbsp;&nbsp;|\n";
	print "&nbsp;&nbsp;Your IP is $strRemoteIP $strHost&nbsp;&nbsp;|\n";
	print "</p>\n";
	print "</center>\n";
	print "</body>\n";
	print "</html>\n";
?>