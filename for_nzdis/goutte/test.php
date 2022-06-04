<?php
require_once './vendor/autoload.php';

use Goutte\Client;

$client = new Client();

$crawler = $client->request('GET','https://stats.areppim.com/listes/list_billionairesx21xwor.htm');
// $crawler = $client->request('GET','https://sciencelatvia.lv/#/pub/eksperti/list');

$tr = $crawler->filter('table')->eq(0)->filter('tr')->each(function($element){
  if(count($element->filter('td'))){
    echo $element->filter('td')->eq(1)->text()." / ";
  }
});
?>
