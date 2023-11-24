<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
  */

  $RegCol1 = 400;
  $RegCol2 = 500;
  $iNumCol = 3;
  $Preamble = $TextArray["RegForm"];
  printPg("$Preamble","center");
  print "<table border=\"0\" width=\"900\" class=\"center\">\n";
  print "<tr>\n<td width=\"$RegCol1\" align=\"right\" class=\"lbl\">Name: </td>\n";
  print "<td width=\"$RegCol2\"><input type=\"text\" name=\"txtName\" size=\"50\" value=\"$strName\">\n";
  print "<span class=\"Attn\">Required</span>\n";
  print "<input type=\"hidden\" name=\"UserID\" size=\"5\" value=\"$strUserID\"></td>\n</tr>\n";
  print "<tr>\n<td colspan=2 align=center class=\"lbl\">Postal Address</td>\n</tr>\n";
  print "<tr>\n<td width=\"$RegCol1\" align=\"right\" class=\"lbl\">Street: </td>\n";
  print "<td><input type=\"text\" name=\"txtAddr1\" size=\"50\" value=\"$strAddr1\"></td>\n</tr>\n";
  print "<tr>\n<td width=\"$RegCol1\" align=\"right\" class=\"lbl\">Street2: </td>\n";
  print "<td><input type=\"text\" name=\"txtAddr2\" size=\"50\" value=\"$strAddr2\"></td>\n</tr>\n";
  print "<tr>\n<td width=\"$RegCol1\" align=\"right\" class=\"lbl\">City:</td>\n";
  print "<td><input type=\"text\" name=\"txtCity\" size=\"50\" value=\"$strCity\"> </td>\n</tr>\n";
  print "<tr>\n";
  if(strtolower($bUSOnly) == "true")
  {
    print "<td width=\"$RegCol1\" align=\"right\" class=\"lbl\">State:</td>\n";
    print "<td>";
    $strQuery = "select * from US_States;";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      print "<select size=\"1\" name=\"cmbState\">\n";
      print "<option>Please Select State</option>\n";
      print "<option>N/A</option>\n";
      foreach($QueryData[1] as $Row2)
      {
        if($Row2["vcStateAbr"] == $strState)
        {
          print "<option selected value=\"{$Row2["vcStateAbr"]}\">{$Row2["vcStateName"]}</option>\n";
        }
        else
        {
          print "<option value=\"{$Row2["vcStateAbr"]}\">{$Row2["vcStateName"]}</option>\n";
        }
      }
      print "</select>";
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
    print "</td>\n";
  }
  else
  {
    print "<td width=\"$RegCol1\" align=\"right\" class=\"lbl\">State/Province/Region:</td>\n";
    print "<td> <input type=\"text\" name=\"cmbState\" size=\"10\" value=\"$strState\"></td>\n";
  }
  print "</tr>\n";
  print "<tr>\n";
  print "<td width=\"$RegCol1\" align=\"right\" class=\"lbl\">Zip:</td>\n";
  print "<td> <input type=\"text\" name=\"txtZip\" size=\"10\" value=\"$strZip\"></td>\n";
  print "</tr>\n";
  print "<tr>\n";
  print "<td width=\"$RegCol1\" align=\"right\" class=\"lbl\">Country:</td>\n";
  print "<td>";
  if($strCountry == "")
  {
    $strCountry = "UNITED STATES";
  }
  $strQuery = "select * from CountryCodes;";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    print "<select size=\"1\" name=\"cmbCountry\">\n";
    foreach($QueryData[1] as $Row2)
    {
      if($Row2["vcCountryName"] == $strCountry)
      {
        print "<option selected value=\"{$Row2["vcCountryName"]}\">{$Row2["vcCountryName"]}</option>\n";
      }
      else
      {
        print "<option value=\"{$Row2["vcCountryName"]}\">{$Row2["vcCountryName"]}</option>\n";
      }
    }
    print "</select>";
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

  print "</td>\n";
  print "</tr>\n";
  print "<tr>\n";
  print "<td align=\"right\" class=\"lbl\">Cell Phone Number, internation format please: </td>\n";
  print "<td><input type=\"text\" name=\"txtCell\" size=\"15\" value=\"$strCell\"> </td>\n";
  print "</tr>\n";
  print "<tr>\n<td width=\"$RegCol1\" align=\"right\" class=\"lbl\">Email address: </td>\n";
  print "<td><input type=\"text\" name=\"txtEmail\" size=\"50\" value=\"$strEmail\">\n<span class=\"Attn\">Required</span>\n";
  print "<input type=\"hidden\" name=\"txtOEmail\" size=\"50\" value=\"$strEmail\"> </td>\n</tr>\n";

  print "<tr><td>&nbsp</td></tr>";
?>
