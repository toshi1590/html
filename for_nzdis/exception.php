<?php
require './vendor/autoload.php';

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;


//
use Facebook\WebDriver\Support\Events\EventFiringWebDriver;
use Facebook\WebDriver\Support\Events\EventFiringWebElement;
use Facebook\WebDriver\Exception\WebDriverException;
use Facebook\WebDriver\WebDriverDispatcher;
use Facebook\WebDriver\WebDriverEventListener;

// important
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\UnrecognizedExceptionException;

//
class EventListener implements WebDriverEventListener {
   public function beforeNavigateTo($url, EventFiringWebDriver $driver){}
   public function afterNavigateTo($url, EventFiringWebDriver $driver){}
   public function beforeNavigateBack(EventFiringWebDriver $driver){}
   public function afterNavigateBack(EventFiringWebDriver $driver){}
   public function beforeNavigateForward(EventFiringWebDriver $driver){}
   public function afterNavigateForward(EventFiringWebDriver $driver){}
   public function beforeFindBy(WebDriverBy $by, $element, EventFiringWebDriver $driver){}
   public function afterFindBy(WebDriverBy $by, $element, EventFiringWebDriver $driver){}
   public function beforeScript($script, EventFiringWebDriver $driver){}
   public function afterScript($script, EventFiringWebDriver $driver){}
   public function beforeClickOn(EventFiringWebElement $element){
     echo "before\n";
   }
   public function afterClickOn(EventFiringWebElement $element){
     echo "after\n";
   }
   public function beforeChangeValueOf(EventFiringWebElement $element){}
   public function afterChangeValueOf(EventFiringWebElement $element){}
   public function onException(WebDriverException $exception, EventFiringWebDriver $driver = null){
     echo "exception\n";
   }
}


//
$host = 'http://localhost:4444/wd/hub';
$options = new ChromeOptions();
$capabilities = Facebook\WebDriver\Remote\DesiredCapabilities::chrome();
$capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
$driver = Facebook\WebDriver\Remote\RemoteWebDriver::create($host, $capabilities);


//
$event_listener = new EventListener();
$web_driver_dispatcher = new WebDriverDispatcher();
$web_driver_dispatcher->register($event_listener);
$event_firing_web_driver = new EventFiringWebDriver($driver, $web_driver_dispatcher);
$event_firing_web_driver->get("https://sciencelatvia.lv/#/pub/eksperti/list");
sleep(10);


//
try {
  // $element = $event_firing_web_driver->findElement(WebDriverBy::xpath('/html/body/div/div/div[1]/section[2]/div/div/div/div[4]/div/div/div/div[1]/div/table/tbody/tr[1]/td[4]/span'));
  $element = $event_firing_web_driver->findElement(WebDriverBy::xpath('aaaaa'));
  $element->click();
}
// catch (Exception $e) {
//   echo "Exception was caught.\n";
// }
// catch (NoSuchElementException $e) {
//   // echo $e->getMessage();
//   echo "NoSuchElementException was caught.\n";
// }
// catch (UnrecognizedExceptionException $e) {
//   // echo $e->getMessage();
//   echo "UnrecognizedExceptionException was caught.\n";
// }
catch (Exception $e) {
  echo "Exception was caught.\n";
}



echo "done\n";


//
$driver->close();
