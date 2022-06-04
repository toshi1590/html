<?php
// 1, 6, 11
// 2, 7, 12
// 3, 8, 13
// 4, 9, 14
// 5, 10, 15

$pages = 13;
$shou = floor(($pages / 5));
$amari = ($pages % 5);
$page_moving_times_in_5_threads = [];

for ($i = 1; $i <= 5; $i++) {
  if ($amari >= $i) {
    array_push($page_moving_times_in_5_threads, $shou);
  } else {
    array_push($page_moving_times_in_5_threads, ($shou - 1));
  }
}


//thread 1
echo 'thread 1' . PHP_EOL;

for ($i = 0; $i < (1 + $page_moving_times_in_5_threads[0]); $i++) {
  if ($i == 0) {
    echo 'no click'. PHP_EOL;
  } else {
    for ($j = 0; $j < 5; $j++) {
      echo 'clicked' . PHP_EOL;
    }
  }

  echo 'scraped' . PHP_EOL;
  echo PHP_EOL;
}


//thread 2
echo 'thread 2' . PHP_EOL;

for ($i = 0; $i < (1 + $page_moving_times_in_5_threads[1]); $i++) {
  if ($i == 0) {
    echo '1 click'. PHP_EOL;
  } else {
    for ($j = 0; $j < 5; $j++) {
      echo 'clicked' . PHP_EOL;
    }
  }

  echo 'scraped' . PHP_EOL;
  echo PHP_EOL;
}
?>
