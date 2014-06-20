<?php

include_once __DIR__ . "/vendor/autoload.php";
include_once __DIR__ . "/src/App.php";
include_once __DIR__ . "/src/Http/Crawler.php";

//------------------------------------------------------------------------------------------------

$app = new \App();

//------------------------------------------------------------------------------------------------

$crawler = new \Http\Crawler($app->getHttpClient());
echo $crawler->crawl('http://shehabic.com/aura/');

//------------------------------------------------------------------------------------------------

$crawler = new \Http\Crawler($app->getHttpClient(), null, "specialPassword");
echo $crawler->crawl('http://shehabic.com/aura/');
echo $app->getCrawler()->crawl('http://shehabic.com/aura/');

//------------------------------------------------------------------------------------------------

$user = "SomeUsername";
echo $app->getSpecialCrawler($user)->crawl('http://shehabic.com/aura/');

//------------------------------------------------------------------------------------------------

$crawler = $app->getSpecialCrawler(["username" => "New-User-Name", "password" => "New-Password"]);
echo $crawler->crawl('http://shehabic.com/aura/');