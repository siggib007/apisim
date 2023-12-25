<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Page to manage Response text cache.
  */
	require("header.php");

	if($strReferer != $strPageURL and $PostVarCount > 0)
	{
		printPg("Invalid operation, Bad Operator!!!","error");
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

	printPg("API Simulated Response Admin","h1");

	if($btnSubmit == "Save")
	{
    $strID = CleanSQLInput(substr(trim($_POST["ResponseID"]),0,14));
    $strTextName = CleanSQLInput(substr(trim($_POST["TextName"]),0,94));
    $strContent = CleanSQLInput($_POST["txtDescr"]);

    $strQuery = "update tblResponses set tResponse = '$strContent', vcName = '$strTextName' WHERE vcResponseID = '$strID';";
    UpdateSQL($strQuery,"update");
	}


	//Print the normal form after update is complete.
	print "<table>\n<tr><th class=lbl>Update existing texts</th>";
  print "<th width = 100></th>";

	print "</tr>\n<tr>\n<td valign=\"top\">\n<table border = 0>\n";
	$strQuery = "SELECT vcResponseID, vcName, tResponse FROM tblResponses where iUserID = $iUserID;";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $strID   = $Row["vcResponseID"];
      $strText = $Row["tResponse"];
      $strName = $Row["vcName"];
      if($WritePriv <=  $Priv)
      {
        print "<form method=\"POST\">\n";
        print "<tr valign=\"top\">\n";
        print "<td class=\"lbl\"><input type=\"hidden\" value=\"$strID\" name=\"ResponseID\"> </td>\n";
        print "<td>$strID</td>\n";
        print "<td>$strName</td>\n";
        print "<td><input type=\"Submit\" value=\"Edit\" name=\"btnSubmit\"></td>";
        print "</tr>\n";
        print "</form>\n";
      }
      else
      {
        print "<tr><td>$strText</td></tr>\n";
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
  if(isset($_POST["ResponseID"]) and $_POST["btnSubmit"] == "Edit")
  {
    $ResponseID = CleanReg($_POST["ResponseID"]);
    $strQuery = "SELECT vcResponseID, vcName, tResponse FROM tblResponses WHERE vcResponseID = '$ResponseID';";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
        $strName  = $Row["vcName"];
        $strResponse = $Row["tResponse"];
        $strID = $Row["vcResponseID"];
      }
    }
    else
    {
      if($QueryData[0] == 0)
      {
        $strName  = "";
        $strResponse = "";
      }
      else
      {
        $strMsg = Array2String($QueryData[1]);
        error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
        printPg("$ErrMsg","error");
      }
    }
    print "<form method=\"POST\">\n";
    print "<p class = lbl>ID: \n";
    print "$strID";
    print "<input type=\"hidden\" value=\"$strID\" name=\"ResponseID\"></p>\n";
    print "<p class = lbl>Name: \n";
    print "<input type=\"text\" value=\"$strName\" name=\"TextName\"></p>\n";
    print "<div class=\"lbl\">Response Text:</div>\n";
    print "<textarea name=\"txtDescr\" rows=\"10\" cols=\"90\">$strResponse</textarea>\n<br>\n";
    print "<div align=\"center\"><input type=\"Submit\" value=\"Save\" name=\"btnSubmit\"></div>\n";
    print "</form>\n";
  }
	print "</td>\n";
  print "</tr>\n";
  print "</table>";

	require("footer.php");
?>
