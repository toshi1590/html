<?php
require './vendor/autoload.php';

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;


//
$host = 'http://localhost:4444/wd/hub';
$options = new ChromeOptions();
// $options->addArguments(['--headless']);
$capabilities = Facebook\WebDriver\Remote\DesiredCapabilities::chrome();
$capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
$driver = Facebook\WebDriver\Remote\RemoteWebDriver::create($host, $capabilities);


//
$driver->get($_POST['url']);
$driver->wait()->until(WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::tagName('td')));
sleep(10);

$ths = $driver->findElements(WebDriverBy::xpath("//tr/th")); //Element
echo 'number of ths: ' . count($ths);

$column_numbers_to_scrape = $_POST['column_numbers_to_scrape'];
for ($i=0; $i < count($column_numbers_to_scrape); $i++) {
  $th = $driver->findElement(WebDriverBy::xpath("//tr/th[$column_numbers_to_scrape[$i]]")); //Element
  echo $th->getText() . ' / ';
}

$driver->close();
