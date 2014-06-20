<?php

class App
{
    /**
     * @var \Aura\Di\Container
     */
    protected $di;

    public function __construct()
    {
        $this->di = new \Aura\Di\Container(new \Aura\Di\Forge(new \Aura\Di\Config()));
        $this->init();
        $this->initParams();
        $this->initCrawler();
    }

    protected function init()
    {
        $di = $this->getDi();
        $di->set('phpFunc',     $di->lazyNew('\Aura\Http\PhpFunc'));
        $di->set('httpClient',  $di->lazyNew('\Aura\Http\Manager'));
        $di->set('transport',   $di->lazyNew('\Aura\Http\Transport'));
        $di->set('curl',        $di->lazyNew('\Aura\Http\Adapter\Curl'));
        $di->set('factory',     $di->lazyNew('\Aura\Http\Message\Factory'));
        $di->set('options',     $di->lazyNew('\Aura\Http\Transport\Options'));
        $di->set('stack',       $di->lazyNew('\Aura\Http\Message\Response\StackBuilder'));
    }

    protected function initParams()
    {
        $di = $this->getDi();

        $di->params['\Aura\Http\Message\Response\StackBuilder'] = [
            'message_factory'   => $di->lazyGet('factory')
        ];

        $di->params['\Aura\Http\Adapter\Curl'] = [
            'stack_builder'     => $di->lazyGet('stack')
        ];

        $di->params['\Aura\Http\Manager'] = [
            'message_factory'   => $di->lazyGet('factory'),
            'transport'         => $di->lazyGet('transport')
        ];

        $di->params['\Aura\Http\Transport'] = [
            'adapter'           => $di->lazyGet('curl'),
            'options'           => $di->lazyGet('options'),
            'phpfunc'           => $di->lazyGet('phpFunc')
        ];
    }

    protected function initCrawler()
    {
        $di = $this->getDi();

        $di ->params['\Http\Crawler'] = [
            'password'          => 'injectedPassword',
            'httpClient'        => $di->lazyGet('httpClient')
        ];

        $di ->set('crawler', $di->lazyNew('\Http\Crawler'));
    }

    /**
     * @return \Aura\Di\Container
     */
    protected function getDi()
    {
        return $this->di;
    }

    /**
     * @return \Aura\Http\Manager
     * @throws Aura\Di\Exception\ServiceNotFound
     */
    public function getHttpClient()
    {
        return $this->getDi()->get('httpClient');
    }

    /**
     * @return \Http\Crawler
     * @throws Aura\Di\Exception\ServiceNotFound
     */
    public function getCrawler()
    {
        return $this->getDi()->get('crawler');
    }

    /**
     * @param string|array $mixed
     * @return \Http\Crawler
     */
    public function getSpecialCrawler($mixed)
    {
        if (!is_array($mixed)) {
            $mixed = ['username' => $mixed];
        }
        $params = array_merge(
            $this->getDi()->params['\Http\Crawler'],
            $mixed
        );

        return $this->getDi()->newInstance('\Http\Crawler', $params);
    }
}
