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
    $strFormat = CleanSQLInput(substr(trim($_POST["cmbFormat"]),0,14));


    $strQuery = "update tblResponses set tResponse = '$strContent', vcName = '$strTextName', vcFormat = '$strFormat' WHERE vcResponseID = '$strID';";
    UpdateSQL($strQuery,"update");
	}


	//Print the normal form after update is complete or on initial load
  if($_POST["btnSubmit"] != "Edit" and $_POST["btnSubmit"] != "Insert New")
  {
    print "<div align=\"center\"><form method=\"POST\">\n<input type=\"Submit\" value=\"Insert New\" name=\"btnSubmit\"></form></div>\n";
    printpg("Update existing texts\n","h2");
    print "<div class=SmallCenterBox\n";

    $strQuery = "SELECT vcResponseID, vcName, tResponse FROM tblResponses where iUserID = $iUserID;";
    $QueryData = QuerySQL($strQuery);
    print "<table border = 0>\n";
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
        $strID   = $Row["vcResponseID"];
        $strText = $Row["tResponse"];
        $strName = $Row["vcName"];
        if($WritePriv <=  $Priv)
        {
          print "<tr valign=\"top\">\n";
          print "<form method=\"POST\">\n";
          print "<td class=\"lbl\"><input type=\"hidden\" value=\"$strID\" name=\"ResponseID\"> </td>\n";
          print "<td>$strID</td>\n";
          print "<td>$strName</td>\n";
          print "<td><input type=\"Submit\" value=\"Edit\" name=\"btnSubmit\"></td>";
          print "</form>\n";
          print "</tr>\n";
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
    print "</div>\n";
  }

  if(isset($_POST["ResponseID"]) and $_POST["btnSubmit"] == "Edit")
  {
    printpg("Update existing texts</div>\n","h2");
    print "<div class=CenterBox\n";
    $ResponseID = CleanReg($_POST["ResponseID"]);
    $strQuery = "SELECT vcResponseID, vcName, vcFormat, tResponse FROM tblResponses WHERE vcResponseID = '$ResponseID';";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
        $strName  = $Row["vcName"];
        $strResponse = $Row["tResponse"];
        $strID = $Row["vcResponseID"];
        $strFormat = $Row["vcFormat"];
      }
    }
    else
    {
      if($QueryData[0] == 0)
      {
        $strName  = "";
        $strResponse = "";
        $strID = "";
        $strFormat = "";
      }
      else
      {
        $strMsg = Array2String($QueryData[1]);
        error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
        printPg("$ErrMsg","error");
      }
    }
    print "<form method=\"POST\">\n";
    print "<div class = lbl>ID: \n";
    print "$strID";
    print "<input type=\"hidden\" value=\"$strID\" name=\"ResponseID\"></div>\n";
    print "<div class = lbl>Name: \n";
    print "<input type=\"text\" value=\"$strName\" name=\"TextName\"></div>\n";
    print "<div class = lbl>Format: \n";
    print "<select size=\"1\" name=\"cmbFormat\">\n";
    if($strFormat == "html")
    {
      print "<option selected value=\"html\">HTML</option>\n";
    }
    else
    {
      print "<option value=\"html\">HTML</option>\n";
    }
    if($strFormat == "xml")
    {
      print "<option selected value=\"xml\">XML</option>\n";
    }
    else
    {
      print "<option value=\"xml\">XML</option>\n";
    }
    if($strFormat == "json")
    {
      print "<option selected value=\"json\">json</option>\n";
    }
    else
    {
      print "<option value=\"json\">json</option>\n";
    }
    if($strFormat == "txt")
    {
      print "<option selected value=\"txt\">Text</option>\n";
    }
    else
    {
      print "<option value=\"txt\">Text</option>\n";
    }
    print "</select>\n</div>\n";

    print "<div class=\"lbl\">Response Text:</div>\n";
    print "<textarea name=\"txtDescr\" rows=\"10\" cols=\"90\">$strResponse</textarea>\n<br>\n";
    print "<div align=\"center\"><input type=\"Submit\" value=\"Save\" name=\"btnSubmit\">\n";
    print "</div>";
    print "</form>\n";
    print "<div align=\"center\"><form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form></div>\n";
  }

  if($_POST["btnSubmit"] == "Insert New")
  {
    $strID = "PlaceholderID";
    printpg("Insert New Response Text</div>\n","h2");
    print "<div class=CenterBox\n";
    print "<form method=\"POST\">\n";
    print "<div class = lbl>ID: \n";
    print "$strID";
    print "<input type=\"hidden\" name=\"ResponseID\"></div>\n";
    print "<div class = lbl>Name: \n";
    print "<input type=\"text\" name=\"TextName\"></div>\n";
    print "<div class = lbl>Format: \n";
    print "<select size=\"1\" name=\"cmbFormat\">\n";
    print "<option value=\"html\">HTML</option>\n";
    print "<option value=\"xml\">XML</option>\n";
    print "<option value=\"json\">json</option>\n";
    print "<option value=\"txt\">Text</option>\n";
    print "</select>\n</div>\n";
    print "<div class=\"lbl\">Response Text:</div>\n";
    print "<textarea name=\"txtDescr\" rows=\"10\" cols=\"90\"></textarea>\n<br>\n";
    print "<div align=\"center\"><input type=\"Submit\" value=\"Insert\" name=\"btnSubmit\">\n";
    print "</div>";
    print "</form>\n";
    print "<div align=\"center\"><form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form></div>\n";
  }

  require("footer.php");
?>
