<?php
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Manages links to review sites where you want to be reviewed
  */

	require("header.php");

  $DocRoot = "ReviewMedia/";

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

	printPg("Review Site link Administration","h1");

	if($btnSubmit == "Save")
	{
		$iSiteID = CleanSQLInput(substr(trim($_POST["iSiteID"]),0,9));
		$strSiteName = CleanSQLInput(substr(trim($_POST["txtSiteName"]),0,99));
		$strSiteURL = CleanSQLInput(substr(trim($_POST["txtSiteURL"]),0,99));
		$strLogoURL= CleanSQLInput(substr(trim($_POST["txtLogoURL"]),0,99));
    $strImgPath="";

    if(isset($_FILES["fPict"]))
    {
      if($_FILES["fPict"]["name"] != "")
      {
        error_log(json_encode($_FILES));
        $arrRet = FileUpload($_FILES["fPict"],$DocRoot);
        error_log(json_encode($arrRet));
        foreach($arrRet["err"] as $strErr)
        {
          print "$strErr<br>\n";
        }
        foreach($arrRet["msg"] as $strMsg)
        {
          print "$strMsg<br>\n";
        }
        $strImgPath = $arrRet["FileList"][0];
      }
    }

    if($strImgPath == "")
    {
      $strImgPath = $strLogoURL;
    }

		$strQuery = "update tblReviewSiteURL set vcSiteName = '$strSiteName', "
              . "vcImgPath = '$strImgPath', vcSiteURL = '$strSiteURL' where iSiteID = $iSiteID;";
    UpdateSQL($strQuery,"update");
	}

	if($btnSubmit == "Delete")
	{
		$iSiteID = CleanSQLInput(substr(trim($_POST["iSiteID"]),0,9));

		$strQuery = "delete from tblReviewSiteURL where iSiteID = $iSiteID;";
		UpdateSQL($strQuery,"delete");
	}

	if($btnSubmit == "Insert")
	{
		$strSiteName = CleanSQLInput(substr(trim($_POST["txtSiteName"]),0,99));
		$strSiteURL = CleanSQLInput(substr(trim($_POST["txtSiteURL"]),0,99));
		$strLogoURL= CleanSQLInput(substr(trim($_POST["txtLogoURL"]),0,99));
    $strImgPath="";

    if((isset($_FILES["fPict"])) && ($_FILES["fPict"]["name"]!=""))
    {
      $arrRet = FileUpload($_FILES["fPict"],$DocRoot);
      error_log(json_encode($arrRet));
      foreach($arrRet["err"] as $strErr)
      {
        print "$strErr<br>\n";
      }
      foreach($arrRet["msg"] as $strMsg)
      {
        print "$strMsg<br>\n";
      }
      $strImgPath = $arrRet["FileList"][0];
    }
    else
    {
      $strImgPath = $strLogoURL;
    }

		if($strSiteName == "")
		{
			printPg("Please provide a Site name to insert","error");
		}
		else
		{
			$strQuery = "insert tblReviewSiteURL (vcSiteName, vcImgPath, vcSiteURL) "
                . "values ('$strSiteName', '$strImgPath', '$strSiteURL ');";
			UpdateSQL($strQuery,"insert");
		}
	}

	//Print the normal form after update is complete.
	print "<table>\n";
  print "<tr>\n";
  print "<th>Update existing Review Site link</th>\n";
  print "<th width = 100></th>\n";
  if($btnSubmit != "Edit")
  {
    print "<th class=lbl>Or Insert New one</th>";
  }
	print "</tr>\n";
  print "<tr>\n";
  print "<td valign=\"top\">\n";
  print "<table border = 0>\n";
	$strQuery = "select iSiteID, vcSiteName from tblReviewSiteURL;";
  $QueryData = QuerySQL($strQuery);
  if($QueryData[0] > 0)
  {
    foreach($QueryData[1] as $Row)
    {
      $vcSiteName = $Row["vcSiteName"];
      $iSiteID = $Row["iSiteID"];
      if($WritePriv <=  $Priv)
      {
        print "<form method=\"POST\">\n";
        print "<tr valign=\"top\">\n";
        print "<td class=\"lbl\"><input type=\"hidden\" value=\"$iSiteID\" name=\"iSiteID\"></td>\n";
        print "<td>$vcSiteName</td>\n";
        print "<td><input type=\"Submit\" value=\"Edit\" name=\"btnSubmit\"></td>";
        print "<td><input type=\"Submit\" value=\"Delete\" name=\"btnSubmit\"></td>";
        print "</tr>\n";
        print "</form>\n";
      }
      else
      {
        print "<tr><td>$vcSiteName</td></tr>\n";
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
  print "<form method=\"POST\">\n";
  print "<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\">\n";
  print "</form>";
	print "</td>\n";
  print "<td>\n";
  print "</td>\n";
  print "<td valign=\"top\">\n";
  if(isset($_POST["iSiteID"]) and $btnSubmit == "Edit")
  {
    $iSiteID = $_POST["iSiteID"];
    $strQuery = "select iSiteID, vcSiteName, vcSiteURL, vcImgPath from tblReviewSiteURL where iSiteID = $iSiteID;";
    $QueryData = QuerySQL($strQuery);
    if($QueryData[0] > 0)
    {
      foreach($QueryData[1] as $Row)
      {
        $strSiteName = $Row["vcSiteName"];
        $strSiteURL = $Row["vcSiteURL"];
        $strLogoURL = $Row["vcImgPath"];
        $strBtnLabel = "Save";
      }
    }
    else
    {
      if($QueryData[0] == 0)
      {
        $strSiteName = "";
        $iSiteID = "";
        $strSiteURL = "";
        $strLogoURL ="";
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
    $strSiteName = "";
    $iSiteID = "";
    $strSiteURL = "";
    $strLogoURL ="";
    $strBtnLabel = "Insert";
  }
	print "<form method=\"POST\" enctype=\"multipart/form-data\">\n";
  print "<input type=\"hidden\" value=\"$iSiteID\" name=\"iSiteID\">";
	print "<span class=\"lbl\">Review Site Name:</span>\n";
	print "<input type=\"text\" name=\"txtSiteName\" size=\"70\" value=\"$strSiteName\"><br>\n";
	print "<span class=\"lbl\">Review Site URL:</span>\n";
	print "<input type=\"text\" name=\"txtSiteURL\" size=\"70\" value=\"$strSiteURL\"><br>\n";
  print "<span class=\"lbl\">Attach logo: </span>\n";
  print "<input type=\"File\" name=\"fPict\" size=\"30\" >\n<br>\n";
  print "<span class=\"lbl\">Or specify a URL to logo:</span>\n";
	print "<input type=\"text\" name=\"txtLogoURL\" size=\"47\" value=\"$strLogoURL\"><br>\n";
	print "<div align=\"center\"><input type=\"Submit\" value=\"$strBtnLabel\" name=\"btnSubmit\"></div>\n";
	print "</form>\n";
  if(isset($_POST["iSiteID"]))
  {
    print "<form method=\"POST\">\n";
    print "<input type=\"Submit\" value=\"Go Back\" name=\"btnSubmit\">\n";
    print "</form>\n";
  }
	print "</td>\n";
  print "</tr>\n";
  print "</table>\n";

	require("footer.php");
?>
