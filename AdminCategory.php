<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Creates or edits administrative categories.

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

	printPg("Administrative Categories","h1");

	if($btnSubmit == "Save")
	{
    $strAdminCat = CleanSQLInput(substr(trim($_POST["txtAdminCat"]),0,49));
    $iCatID = CleanSQLInput(substr(trim($_POST["iCatID"]),0,49));

    $strQuery = "update tblAdminCategories set vcCatName = '$strAdminCat' where iCatID = $iCatID;";
    UpdateSQL($strQuery,"update");
	}

	if($btnSubmit == "Delete")
	{
    $iCatID = intval(substr(trim($_POST["iCatID"]),0,49));

    $strQuery = "delete from tblAdminCategories where iCatID = $iCatID;";
    UpdateSQL($strQuery,"delete");
	}

	if($btnSubmit == "Insert")
	{
    $strAdminCat = CleanSQLInput(substr(trim($_POST["txtAdminCat"]),0,49));

    if($strAdminCat == "")
    {
      printPg("Please provide a administrative catergory name to insert","note");
    }
    else
    {
      $strQuery = "insert tblAdminCategories (vcCatName) values ('$strAdminCat');";
      UpdateSQL($strQuery,"insert");
    }
	}

	//Print the normal form after update is complete.
	print "<table>\n";
  print "<tr>\n";
  print "<th class=lbl>Update existing Category</th>\n";
  print "<th width=100></th>\n";
  print "<th class=lbl>Or Insert New one</th>\n";
  print "</tr>\n";
	print "<tr>\n";
  print "<td>\n";
  print "<table border=0>\n";
  print "<tr>\n";
  print "<th></th>\n";
  print "<th class=lbl>Category Name</th>\n";
  print "</tr>\n";
	$strQuery = "SELECT vcCatName, iCatID FROM tblAdminCategories WHERE iCatID > 0 ORDER BY iCatID;";

  $QueryData = QuerySQL($strQuery);

  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $vcAdminCat = $Row["vcCatName"];
      $iCatID = $Row["iCatID"];
      if($WritePriv <=  $Priv)
      {
        print "<form method=\"POST\">\n";
        print "<tr valign=\"top\">\n";
        print "<td class=\"lbl\"><input type=\"hidden\" value=\"$iCatID\" name=\"iCatID\"> </td>\n";
        print "<td><input type=\"text\" value=\"$vcAdminCat\" name=\"txtAdminCat\" size=\"30\" ></td>\n";
        print "<td><input type=\"Submit\" value=\"Save\" name=\"btnSubmit\"></td>";
        print "<td><input type=\"Submit\" value=\"Delete\" name=\"btnSubmit\"></td>";
        print "</tr>\n";
        print "</form>\n";
      }
      else
      {
        print "$vcAdminCat<br>\n";
      }
    }
  }
  else
  {
    $strMsg = Array2String($QueryData[1]);
    trigger_error("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
    printPg("Error occured fetching data from DB","error");
  }

	print "</table>\n";
	print "</td>\n";
  print "<td>\n";
  print "</td>\n";
  print "<td valign=top>\n";
	print "<form method=\"POST\">\n";
	print "<table>\n";
	print "<tr>\n<td align = right class = lbl>Category: </td>\n";
	print "<td><input type=\"text\" name=\"txtAdminCat\" size=\"30\" ></td>\n</tr>\n";
	print "<tr><td colspan=2 align=center><input type=\"Submit\" value=\"Insert\" name=\"btnSubmit\"></td></tr>\n";
	print "</table>\n";
	print "</form>\n</td>\n</tr>\n</table>";

	require("footer.php");
?>
