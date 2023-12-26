<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Page to Manage the option help text
  */

  require("header.php");

  if($strReferer != $strPageURL and $PostVarCount > 0)
  {
    printPg("Invalid operation, Bad Reference!!!","error");
    exit;
  }

  printPg("Option Administration","h1");

  if(($PostVarCount == 1) and ($btnSubmit == "Go Back"))
  {
    header("Location: $strPageURL");
  }

  if(isset($_POST["btnSubmit"]))
  {
    $btnSubmit = $_POST["btnSubmit"];
  }
  else
  {
    $btnSubmit = "";
  }

  if($btnSubmit == "Save")
  {
    $iOptionID = intval(substr(trim($_POST["iOptionID"]),0,49));
    $vcCode = CleanSQLInput(substr(trim($_POST["txtCode"]),0,24));
    $vcDescr = CleanSQLInput(substr(trim($_POST["txtDesc"]),0,999));
    $vcType = substr(trim($_POST["cmbType"]),0,49);

    $strQuery = "update tblOptions set vcValueType ='$vcType', vcOptionCode='$vcCode',vcOptionDescr='$vcDescr' where iOptionID=$iOptionID;";
    UpdateSQL($strQuery,"update");
  }

  if($btnSubmit == "Delete")
  {
    $iOptionID = intval(substr(trim($_POST["iOptionID"]),0,49));

    $strQuery = "delete from tblOptions where iOptionID = $iOptionID;";
    UpdateSQL($strQuery,"delete");
  }

  if($btnSubmit == "Insert")
  {
    $vcCode = CleanSQLInput(substr(trim($_POST["txtCode"]),0,24));
    $vcDescr = CleanSQLInput(substr(trim($_POST["txtDesc"]),0,999));
    if(isset($_POST["cmbType"]))
    {
      $vcType = substr(trim($_POST["cmbType"]),0,49);
    }
    else
    {
      $vcType = "";
    }

    if($vcDescr == "" or $vcCode == "" or $vcType == "")
    {
      printPg("Please provide all the info","error");
    }
    else
    {
      $strQuery = "insert tblOptions (vcValueType, vcOptionDescr, vcOptionCode) values ('$vcType', '$vcDescr', '$vcCode');";
      UpdateSQL($strQuery,"insert");
    }
  }

  //Print the normal form after update is complete.
  print "<form method=\"POST\">\n";
  print "<table>\n";
  print "<tr><td colspan=2 align=center class=lbl>Insert New Option</td></tr>\n";
  print "<tr>\n<td align = right class = lbl>Type: </td>\n";
  print "<td>\n<select size=\"1\" name=\"cmbType\">\n";
  print "<option value=\"int\">Integer</option>\n";
  print "<option value=\"string\">Text String</option>\n";
  print "<option value=\"format\">Text Format</option>\n";
  print "</select>\n</td>";

  print "<tr>\n<td align = right class = lbl>Code: </td>\n";
  print "<td><input type=\"text\" name=\"txtCode\" size=\"7\" ></td>\n</tr>\n";
  print "<tr>\n<td align = right class = lbl>Description: </td>\n";
  print "<td><input type=\"text\" name=\"txtDesc\" size=\"120\" ></td></tr>\n";
  print "<tr><td colspan=2 align=center><input type=\"Submit\" value=\"Insert\" name=\"btnSubmit\"></td></tr>\n";
  print "</table>\n";
  print "</form>\n";

  $strQuery = "SELECT iOptionID, vcOptionCode, vcValueType, vcOptionDescr FROM tblOptions;";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    print "<div class=lbl>Or Update existing Options</th><th width = 100></div>\n";
    print "<table border = 0>\n";
    print "<tr><th></th><th class=lbl>Type</th><th class=lbl>Code</th><th class=lbl>Description</th></tr>\n";
    foreach($QueryData[1] as $Row)
    {
      if($WritePriv <=  $Priv)
      {
        print "<form method=\"POST\">\n";
        print "<tr valign=\"top\">\n";
        print "<td class=\"lbl\"><input type=\"hidden\" value=\"$Row[iOptionID]\" name=\"iOptionID\"> </td>\n";
        print "<td>\n<select size=\"1\" name=\"cmbType\">\n";
        if($Row["vcValueType"] == "int")
        {
          print "<option selected value=\"int\">Integer</option>\n";
        }
        else
        {
          print "<option value=\"int\">Integer</option>\n";
        }
        if($Row["vcValueType"] == "string")
        {
          print "<option selected value=\"string\">Text String</option>\n";
        }
        else
        {
          print "<option value=\"string\">Text String</option>\n";
        }
        if($Row["vcValueType"] == "format")
        {
          print "<option selected value=\"format\">Text Format</option>\n";
        }
        else
        {
          print "<option value=\"format\">Text Format</option>\n";
        }
        print "</select>\n</td>";
        print "<td><input type=\"text\" value=\"$Row[vcOptionCode]\" name=\"txtCode\" size=\"7\" ></td>\n";
        print "<td><input type=\"text\" value=\"$Row[vcOptionDescr]\" name=\"txtDesc\" size=\"120\" ></td>\n";
        print "<td><input type=\"Submit\" value=\"Save\" name=\"btnSubmit\"></td>";
        print "<td><input type=\"Submit\" value=\"Delete\" name=\"btnSubmit\"></td>";
        print "</tr>\n";
        print "</form>\n";
      }
      else
      {
        print "<tr><td>$Row[vcValueType]</td><td>$Row[vcOptionCode]</td><td>$Row[vcOptionDescr]</td></tr>\n";
      }
    }
  }
  else
  {
    if($QueryData[0] < 0)
    {
      $strMsg = Array2String($QueryData[1]);
      error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
      printPg($ErrMsg,"error");
    }
  }
  print "</table>\n";

  require("footer.php");
?>
