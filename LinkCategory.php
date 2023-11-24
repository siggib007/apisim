<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Page to create and maintain link categories used in Link Admin
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

	printPg("Link Categories","h1");

	if(($PostVarCount == 1) and ($btnSubmit == "Go Back"))
	{
		header("Location: $strPageURL");
	}

	if($btnSubmit == "Save")
	{
		$iSortNum = CleanSQLInput(substr(trim($_POST["iSortNum"]),0,49));
		$strLinkCat = CleanSQLInput(substr(trim($_POST["txtLinkCat"]),0,49));
		$iLinkCatID = CleanSQLInput(substr(trim($_POST["iLinkCatID"]),0,49));

		if($iSortNum == "")
		{
			$iSortNum = 0;
		}

		$strQuery = "update tbllinkcategory set vcCategory = '$strLinkCat', iSortNum = $iSortNum where iCatID = $iLinkCatID;";
		UpdateSQL($strQuery,"update");
	}

	if($btnSubmit == "Delete")
	{
		$iLinkCatID = intval(substr(trim($_POST["iLinkCatID"]),0,49));

		$strQuery = "delete from tbllinkcategory where iCatID = $iLinkCatID;";
		UpdateSQL($strQuery,"delete");
	}

	if($btnSubmit == "Insert")
	{
		$iSortNum = CleanSQLInput(substr(trim($_POST["iSortNum"]),0,49));
		$strLinkCat = CleanSQLInput(substr(trim($_POST["txtLinkCat"]),0,49));

		if($iSortNum == "")
		{
			$iSortNum = 0;
		}

		if($strLinkCat == "")
		{
			printPg("Please provide a document catergory name to insert","note");
		}
		else
		{
			$strQuery = "insert tbllinkcategory (vcCategory, iSortNum) values ('$strLinkCat',$iSortNum);";
			UpdateSQL($strQuery,"insert");
		}
	}

	//Print the normal form after update is complete.
	$strQuery = "SELECT vcCategory, iSortNum, iCatID FROM tbllinkcategory order by iSortNum;";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    print "<table class=center>\n";
    print "<tr>\n";
    print "<th class=lbl>Update existing Category</th>\n";
    print "<th width = 100></th>\n";
    print "<th class=lbl>Or Insert New one</th>\n";
    print "</tr>\n";
    print "<tr>\n";
    print "<td>\n";
    print "<table border = 0>\n";
    print "<tr><th></th><th class=lbl>Category Name</th><th class=lbl>Sort order</th></tr>\n";
    foreach($QueryData[1] as $Row)
    {
      $vcLinkCat = $Row["vcCategory"];
      $iSortNum = $Row["iSortNum"];
      $iLinkCatID = $Row["iCatID"];
      if($WritePriv <=  $Priv)
      {
        print "<form method=\"POST\">\n";
        print "<tr valign=\"top\">\n";
        print "<td class=\"lbl\"><input type=\"hidden\" value=\"$iLinkCatID\" name=\"iLinkCatID\"> </td>\n";
        print "<td><input type=\"text\" value=\"$vcLinkCat\" name=\"txtLinkCat\" size=\"30\" ></td>\n";
        print "<td><input type=\"text\" value=\"$iSortNum\" name=\"iSortNum\" size=\"13\" ></td>\n";
        print "<td><input type=\"Submit\" value=\"Save\" name=\"btnSubmit\"></td>";
        print "<td><input type=\"Submit\" value=\"Delete\" name=\"btnSubmit\"></td>";
        print "</tr>\n";
        print "</form>\n";
      }
      else
      {
        print "$vcLinkCat : $iSortNum<br>\n";
      }
    }
    print "</table>\n";
    print "</td>\n<td>\n</td>\n<td>\n";
  }
  else
  {
    if($QueryData[0] == 0)
    {
      print "<table class=center>\n";
      print "<tr>\n";
      print "<th class=lbl>Insert New Category</th>\n";
      print "</tr>\n";
      print "<tr>\n";
      print "<td>\n";
    }
    if($QueryData[0] < 0)
    {
      $strMsg = Array2String($QueryData[1]);
      error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
      printPg($ErrMsg,"error");
    }
  }

	print "<form method=\"POST\">\n";
	print "<table>\n";
	print "<tr>\n";
  print "<td align = right class = lbl>Category: </td>\n";
	print "<td><input type=\"text\" name=\"txtLinkCat\" size=\"30\" ></td>\n";
  print "</tr>\n";
	print "<tr>\n";
  print "<td align = right class = lbl>Sort Order: </td>\n";
	print "<td><input type=\"text\" name=\"iSortNum\" size=\"13\" ></td>\n";
  print "</tr>\n";
	print "<tr>\n";
  print "<td colspan=2 align=center><input type=\"Submit\" value=\"Insert\" name=\"btnSubmit\"></td>\n";
  print "</tr>\n";
	print "</table>\n";
	print "</form>\n</td>\n</tr>\n</table>\n";
	require("footer.php");
?>
