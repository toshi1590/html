<?php
$url = $_POST['url'];

if (isset($_POST['xpath_for_ajax'])) {
  $xpath_for_ajax = $_POST['xpath_for_ajax'];
} else {
  $xpath_for_ajax = 'null';
}

$column_numbers_to_scrape_str = implode(', ', $_POST['column_numbers_to_scrape']);
$column_numbers_to_scrape = '[' . $column_numbers_to_scrape_str . ']';

$titles_str = implode('", "', $_POST['titles']);
$titles = '["' . $titles_str . '"]';

$rows = $_POST['rows'];

if (isset($_POST['xpath_of_a']) && isset($_POST['xpaths_to_scrape_in_a_new_page'])) {
  $xpath_of_a = $_POST['xpath_of_a'];
  $xpaths_to_scrape_in_a_new_page_str = implode('", "', $_POST['xpaths_to_scrape_in_a_new_page']);
  $xpaths_to_scrape_in_a_new_page = '["' . $xpaths_to_scrape_in_a_new_page_str . '"]';
} else {
  $xpath_of_a = 'null';
  $xpaths_to_scrape_in_a_new_page = 'null';
}

if ($xpath_of_a != 'null') {
  $number_of_hrefs = intval($rows);
} else {
  $number_of_hrefs = '0';
}

exec("bash create.sh '$url' '$xpath_for_ajax' '$column_numbers_to_scrape' '$titles' '$rows' '$xpath_of_a' '$xpaths_to_scrape_in_a_new_page' '$number_of_hrefs'");

header('Location: scraping.php');
