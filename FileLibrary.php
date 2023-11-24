<?php
    /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>

  Display content of upload directory with option to delete one, many or all
  */

  require("header.php");
  $DocRoot = $ConfArray["AdminUploadDir"];
	if(isset($_POST["btnSubmit"]))
	{
    $btnSubmit = $_POST["btnSubmit"];
	}
	else
	{
    $btnSubmit = "";
	}

  if($btnSubmit == "")
  {
    printPg("Here are the files in the folder $DocRoot","note");
    $arrFiles = scandir($DocRoot);
    print "<div class=\"CenterBox\">\n";
    print "<form method=\"POST\">\n";
    $iNum = 1;
    foreach($arrFiles as $strFileName) 
    {
      if(substr($strFileName,0,1) != ".")
      {
        $strBoxName = "File$iNum";
        $strLink = "<a href=\"$DocRoot/$strFileName\" target=_blank>$strFileName</a>";
        print "<input type=\"checkbox\" name=\"$strBoxName\" value=\"$strFileName\">$strLink<br>\n";
        $iNum++;
      }
    }
    printPg("Delete is permanent and there is no undo.<br>\n There is no confirmation either!!!","alert");
    print "<div class=\"BlueNote\">\n";
    print "<input type=\"submit\" value=\"Delete\" name=\"btnSubmit\">\n";
    print "<input type=\"submit\" value=\"Delete ALL\" name=\"btnSubmit\">\n";
    print "</div>\n";
    print "</form>\n";
    print "</div>\n";
  }

  if($btnSubmit == "Delete")
  {
    print "<div class=\"CenterBox\">\n";
    foreach($_POST as $key => $value) 
    {
      if(substr($key,0,4)=="File")
      {
        $FileName = "$DocRoot/$value";
        print "Deleting $FileName<br>\n";
        unlink($FileName);
      }
    }
    print "</div>\n";
  }

  if($btnSubmit == "Delete ALL")
  {
    print "<div class=\"CenterBox\">\n";
    printPg("Deleting everything","alert");
    $arrFiles = scandir($DocRoot);
    foreach($arrFiles as $strFileName)
    {
      if(substr($strFileName,0,1) != ".")
      {
        unlink("$DocRoot/$strFileName");
      }
    }
    printPg("Done","note");
    print "</div>\n";
  }
  require("footer.php");
?>
