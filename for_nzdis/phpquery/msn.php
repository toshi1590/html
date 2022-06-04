<?php
  // read phpQuery-onefile.php
  require_once("./phpQuery-onefile.php");
  // get the web page of https://www.msn.com/en-us/sports/mlb/player-stats
  $html = file_get_contents("https://www.msn.com/en-us/sports/mlb/player-stats");
  // DOM analysis
  $doc = phpQuery::newDocument($html);
  // indicate td tag, get the data and display the data
  echo $doc->find("td")->text();
?>
