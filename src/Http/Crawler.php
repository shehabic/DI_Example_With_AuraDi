<?php

namespace Http;

class Crawler
{
    /** @var \Aura\Http\Manager */
    protected $httpClient;

    /** @var string */
    protected $username = "aura";

    /** @var string */
    protected $password = "tester";

    /**
     * @param $httpClient
     * @param string $username
     * @param string $password
     */
    public function __construct($httpClient, $username = null, $password = null)
    {
        if ($username !== null) {
            $this->username = $username;
        }
        if ($password !== null) {
            $this->password = $password;
        }
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $url
     * @return mixed
     * @throws \Aura\Http\Exception\InvalidUsername
     */
    public function crawl($url)
    {
        return "Crawling {$url} with username: {$this->username} and pass: {$this->password} \n";
    }
}
