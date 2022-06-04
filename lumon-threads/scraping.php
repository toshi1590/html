<?php
require './vendor/autoload.php';

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\UnrecognizedExceptionException;
use Facebook\WebDriver\Exception\UnexpectedJavascriptException;
use Facebook\WebDriver\Exception\StaleElementReferenceException;
use Facebook\WebDriver\Exception\WebDriverCurlException;

$host = 'http://localhost:4444/wd/hub';
$options = new ChromeOptions();
$width  = 960;
$height = 1024;
$options->addArguments( [ "window-size={$width},{$height}" ] );
$capabilities = Facebook\WebDriver\Remote\DesiredCapabilities::chrome();
$capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
$driver = Facebook\WebDriver\Remote\RemoteWebDriver::create($host, $capabilities);


$url = 'https://www.lumonpay.com/live-exchange-rates/';
$xpath_for_ajax = 'null';
$column_numbers_to_scrape = [1];
$titles = ["a"];
$xpath_of_a = 'null';
$xpaths_to_scrape_in_a_new_page = null;
$scraped_data = [];
array_push($scraped_data, $titles);
$hrefs = [];


$driver->get($url);


if ($xpath_for_ajax != 'null') {
  $ajax_btn = $driver->findElement(WebDriverBy::xpath($xpath_for_ajax));
  $ajax_btn->click();
}

$driver->wait()->until(WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::tagName('td')));
sleep(10);

$rows = 4;


for ($i = 1; $i <= $rows; $i++) {
  $scraped_row_data = [];

  for ($j=0; $j < count($column_numbers_to_scrape); $j++) {
    try {
      $Is_this_td_row = 'y';
      $td = $driver->findElement(WebDriverBy::xpath("//tbody/tr[$i]/td[$column_numbers_to_scrape[$j]]")); //Element
      array_push($scraped_row_data, $td->getText());
    }catch (NoSuchElementException $e) {
      $Is_this_td_row = 'n';
      break;
    }
  }

  if ($Is_this_td_row == 'y') {
    if ($xpath_of_a != 'null') {
      $preg_xpath_of_a = preg_replace("/tr\[[0-9]+\]/", "tr[$i]", $xpath_of_a);
      $a = $driver->findElement(WebDriverBy::xpath($preg_xpath_of_a));
      $href = $a->getAttribute('href');
      array_push($hrefs, $href);
    }

    array_push($scraped_data, $scraped_row_data);
  }
}



echo json_encode($scraped_data);
//echo json_encode($hrefs);
//echo json_encode($xpaths_to_scrape_in_a_new_page);
$driver->close();


for ($i = 0; $i < count($scraped_data); $i++) {
  if ($i == 0) {
    array_unshift($scraped_data[$i], 'id');
  } else {
    array_unshift($scraped_data[$i], $i);
  }
}
?>

<script type="text/javascript">
  const data = JSON.parse('<?php echo json_encode($scraped_data); ?>');
</script>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost:81/ssr/index.css">
  </head>
  <body class="m-1">
    <div id="result_table_section"></div>

    <form class="mb-5" id="chart_form">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="condition" id="group_by_a_column_radio">group by a column
        <div id="group_by_a_column_section"></div>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="radio" name="condition" id="range_radio">range
        <div id="range_section"></div>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="radio" name="condition" id="keyword_radio">keyword
        <div id="keyword_section"></div>
      </div>

      <button type="button" class="btn btn-primary" id="see_chart_btn">see chart</button>
    </form>

    <div id="chart_section"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://localhost:81/ssr/paginathing.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
    <script src="http://localhost:81/ssr/background_colors.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <script src="http://localhost:81/ssr/list_chart.js"></script>
  </body>
</html>
