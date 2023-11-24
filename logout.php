<?php 
  /*
  Copyright © 2009,2015,2022  Siggi Bjarnason.
  Licensed under GNU GPL v3 and later. Check out LICENSE.TXT for details   
  or see <https://www.gnu.org/licenses/gpl-3.0-standalone.html>
  */

  $strReferer = $_SERVER["HTTP_REFERER"];
  $strPageNameParts = explode("/",$strReferer);
  $HowMany = count($strPageNameParts);
  $LastIndex = $HowMany - 1;
  $strReferPage = $strPageNameParts[$LastIndex];	

  if($strReferPage=="register.php")
  {
    $strReferPage = "index.php";
  }	
  if($strReferPage=="delete.php")
  {
    $strReferPage = "index.php";
  }
  if($strReferPage=="update.php")
  {
    $strReferPage = "index.php";
  }
  if($strReferPage=="recover.php")
  {
    $strReferPage = "index.php";
  }		
  if($strReferPage=="")
  {
    $strReferPage = "index.php";
  }
  if($strReferPage=="myprofile.php")
  {
    $strReferPage = "index.php";
  }
  require_once("DBCon.php");
  require_once("KillSession.php");
  $strReferPage = $ROOTPATH . $strReferPage;
  header("Location: $strReferPage");
  printPg("You have been successfully logged out.","h1");
  require("footer.php");
?>