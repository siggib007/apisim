<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Page to manage static texts that are shown throughout the site.
  */
	require("header.php");

	if($strReferer != $strPageURL and $PostVarCount > 0)
	{
		printPg("Invalid operation, Bad Reference!!!","error");
		exit;
	}
	if(isset($_POST["btnSubmit"]))
	{
		$btnSubmit = $_POST["btnSubmit"];
	}
	else
	{
		$btnSubmit = "";
	}

	printPg("Miscelaneous text administration","h1");

	if($btnSubmit == "Save")
	{
    $strTextName = CleanSQLInput(substr(trim($_POST["TextName"]),0,49));
    $strContent = CleanSQLInput($_POST["txtDescr"]);

    $strQuery = "update tblPageTexts set tPageTexts = '$strContent' WHERE vcTextName = '$strTextName';";
    UpdateSQL($strQuery,"update");
	}


	//Print the normal form after update is complete.
	print "<table>\n<tr><th class=lbl>Update existing texts</th>";
  print "<th width = 100></th>";

	print "</tr>\n<tr>\n<td valign=\"top\">\n<table border = 0>\n";
	$strQuery = "SELECT vcTextName, vcTextDescr, tPageTexts FROM tblPageTexts;";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $strTextDescr = $Row["vcTextDescr"];
      $strTextName = $Row["vcTextName"];
      if($WritePriv <=  $Priv)
      {
        print "<form method=\"POST\">\n";
        print "<tr valign=\"top\">\n";
        print "<td class=\"lbl\"><input type=\"hidden\" value=\"$strTextName\" name=\"TextName\"> </td>\n";
        print "<td>$strTextDescr</td>\n";
        print "<td><input type=\"Submit\" value=\"Edit\" name=\"btnSubmit\"></td>";
        print "</tr>\n";
        print "</form>\n";
      }
      else
      {
        print "<tr><td>$strTextDescr</td></tr>\n";
      }
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
      printPg("$ErrMsg","error");
    }
  }

	print "</table>\n";
  print "<form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form>";
	print "</td>\n<td>\n</td>\n<td valign=\"top\">\n";
  if(isset($_POST["TextName"]) and $_POST["btnSubmit"] == "Edit")
  {
    $TextName = CleanReg($_POST["TextName"]);
    $strQuery = "SELECT tPageTexts, vcTextDescr FROM tblPageTexts WHERE vcTextName = '$TextName';";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
        $strPageText  = $Row["tPageTexts"];
        $strPageDescr = $Row["vcTextDescr"];
      }
    }
    else
    {
      if($QueryData[0] == 0)
      {
        $strPageText  = "";
        $strPageDescr = "";
      }
      else
      {
        $strMsg = Array2String($QueryData[1]);
        error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
        printPg("$ErrMsg","error");
      }
    }
    print "<form method=\"POST\">\n";
    print "<input type=\"hidden\" value=\"$TextName\" name=\"TextName\">";
    print "<div class=\"lbl\">$strPageDescr</div>\n";
    print "<textarea name=\"txtDescr\" rows=\"20\" cols=\"90\">$strPageText</textarea>\n<br>\n";
    print "<div align=\"center\"><input type=\"Submit\" value=\"Save\" name=\"btnSubmit\"></div>\n";
    print "</form>\n";
    if(isset($_POST["iClassid"]))
    {
        print "<form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form>";
    }
  }
	print "</td>\n";
  print "</tr>\n";
  print "</table>";

	require("footer.php");
?>
