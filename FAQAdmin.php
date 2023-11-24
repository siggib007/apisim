<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
  
  Page where you enter and manages your FAQs
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

	printPg("FAQ Administration<","h1");

	if($btnSubmit == "Save")
	{
		$iFAQID = CleanSQLInput(substr(trim($_POST["iFAQid"]),0,49));
		$strQuestion = CleanSQLInput(substr(trim($_POST["txtQuestion"]),0,49));
		$strAnswer = CleanSQLInput($_POST["txtAnswer"]);


		$strQuery = "update tblFAQ set vcQuestion = '$strQuestion', tAnswer = '$strAnswer' where iFAQid = $iFAQID;";
		UpdateSQL($strQuery,"update");
	}

	if($btnSubmit == "Delete")
	{
		$iFAQID = CleanSQLInput(substr(trim($_POST["iFAQid"]),0,49));

		$strQuery = "delete from tblFAQ where iFAQid = $iFAQID;";
		UpdateSQL($strQuery,"delete");
	}

	if($btnSubmit == "Insert")
	{

    $strQuestion = CleanSQLInput(substr(trim($_POST["txtQuestion"]),0,49));
		$strAnswer = CleanSQLInput($_POST["txtAnswer"]);
    
		if($strQuestion == "" or $strAnswer = "")
		{
			printPg("Please provide both a Question and answer to insert","alert");
		}
		else
		{
			$strQuery = "insert tblFAQ (vcQuestion, tAnswer) values ('$strQuestion','$strAnswer');";
			UpdateSQL($strQuery,"insert");
		}
	}

	//Print the normal form after update is complete.
	print "<table>\n<tr><th class=lbl>Update existing FAQ</th>";
  print "<th width = 100></th>";
  if(!isset($_POST["iFAQid"]))
  {
    print "<th class=lbl>Or Insert New one</th>";
  }
	print "</tr>\n<tr>\n<td valign=\"top\">\n<table border = 0>\n";
	$strQuery = "select iFAQid, vcQuestion, tAnswer from tblFAQ;";

  $QueryData = QuerySQL($strQuery);

  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $vcQuestion = $Row["vcQuestion"];
      $iFAQid = $Row["iFAQid"];
      if($WritePriv <=  $Priv)
      {
        print "<form method=\"POST\" accept-charset=\"utf-8\">\n";
        print "<tr valign=\"top\">\n";
        print "<td class=\"lbl\"><input type=\"hidden\" value=\"$iFAQid\" name=\"iFAQid\"> </td>\n";
        print "<td>$vcQuestion</td>\n";
        print "<td><input type=\"Submit\" value=\"Edit\" name=\"btnSubmit\"></td>";
                          print "<td><input type=\"Submit\" value=\"Delete\" name=\"btnSubmit\"></td>";
        print "</tr>\n";
        print "</form>\n";
      }
      else
      {
        print "<tr><td>$vcQuestion</td></tr>\n";
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
      printPg($ErrMsg,"error");
    }
  }

	print "</table>\n";
  print "<form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form>";
	print "</td>\n<td>\n</td>\n<td valign=\"top\">\n";
  
  if(isset($_POST["iFAQid"]) and $_POST["btnSubmit"] == "Edit")
  {
    $iFAQid = intval($_POST["iFAQid"]);
    $strQuery = "select iFAQid, vcQuestion, tAnswer from tblFAQ where iFAQid = $iFAQid;";

    $QueryData = QuerySQL($strQuery);

    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
        $strQuestion = $Row["vcQuestion"];
        $strAnswer = $Row["tAnswer"];
        $strBtnLabel = "Save";
      }
    }
    else
    {
      if($QueryData[0] == 0)
      {
        $strQuestion = "";
        $strAnswer = "";
        $iFAQid = "";
        $strBtnLabel = "Insert";
      }
      else
      {
        $strMsg = Array2String($QueryData[1]);
        error_log("Query of $strQuery did not return data. Rowcount: $QueryData[0] Msg:$strMsg");
        printPg($ErrMsg,"error");
      }
    }
  }
  else
  {
    $strQuestion = "";
    $strAnswer = "";
    $iFAQid = "";
    $strBtnLabel = "Insert";
  }
	print "<form method=\"POST\">\n";
  print "<input type=\"hidden\" value=\"$iFAQid\" name=\"iFAQid\">";
	print "<span class=\"lbl\">Question:</span>\n";
	print "<input type=\"text\" name=\"txtQuestion\" size=\"70\" value=\"$strQuestion\"><br>\n";
	print "<div class=\"lbl\">Answer:</div>\n";
  print "<textarea name=\"txtAnswer\" rows=\"20\" cols=\"80\">$strAnswer</textarea>\n<br>\n";
	print "<div align=\"center\"><input type=\"Submit\" value=\"$strBtnLabel\" name=\"btnSubmit\"></div>\n";
	print "</form>\n";
  if(isset($_POST["iFAQid"]))
  {
    print "<form method=\"POST\">\n<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\"></form>";
  }
	print "</td>\n";
  print "</tr>\n";
  print "</table>";

	require("footer.php");
?>
