<?php
$start = microtime(true);

require_once("./phpQuery-onefile.php");
$html = file_get_contents("https://stats.areppim.com/listes/list_billionairesx21xwor.htm");
$doc = phpQuery::newDocument($html);

$i = 1;
foreach ($doc->find("td") as $td) {
  if (($i % 7) == 2 || ($i % 7) == 3 || ($i % 7) == 4 || ($i % 7) == 6) {
    echo $td->nodeValue . ' / ';
  } elseif (($i % 7) == 0) {
    echo PHP_EOL;
  }
  $i++;
}

$end = microtime(true);
$time = ($end - $start);
echo "time: " . $time . PHP_EOL; 
?>
