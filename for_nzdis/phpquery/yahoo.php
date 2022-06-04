<?php
$start = microtime(true);

require_once("./phpQuery-onefile.php");

$urls = [
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=1",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=2",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=3",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=4",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=5",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=6",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=7",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=8",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=9",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=10",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=11",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=12",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=13",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=14",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=15",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=16",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=17",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=18",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=19",
  "https://finance.yahoo.co.jp/stocks/ranking/up?market=all&term=daily&page=20"
];
$hrefs = [];


for ($i = 0; $i < $_POST['pages']; $i++) {
  $html = file_get_contents($urls[$i]);
  $doc = phpQuery::newDocument($html);

  foreach ($doc->find('td') as $td){
    echo $td->nodeValue . PHP_EOL;
  }

 foreach ($doc->find('/a') as $a){
   $a = $a->getAttribute('href');

   if (preg_match("/[0-9]+\.T/", $a)) {
     array_push($hrefs, $a);
   }
 }
}


for ($i = 0; $i < count($hrefs); $i++) {
 $html = file_get_contents($hrefs[$i]);
 $doc = phpQuery::newDocument($html);

 $j = 1;
 foreach ($doc->find('._38iJU1zx') as $data) {
   if ($j == 1 || $j == 2) {
     echo $data->nodeValue . PHP_EOL;
   } else {
     break;
   }
   $j++;
 }
}


$end = microtime(true);
$time = ($end - $start);
echo "time: " . $time . PHP_EOL;
?>
