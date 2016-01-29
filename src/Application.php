<?php

namespace XTheme\Server;

use Silex\Application as SilexApplication;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Parser as YamlParser;

use XTheme\Core\ThemeLoader\XmlThemeLoader;
use XTheme\Core\SiteLoader\XmlSiteLoader;
use XTheme\Core\Renderer;

use RuntimeException;

class Application extends SilexApplication
{
    private $theme;
    private $site;
    
    public function __construct(array $values = array())
    {
        parent::__construct($values);

        $this->configureParameters();
        $this->configureProviders();
        $this->initializeDomain();
        
        $app = $this;
        foreach ($this->site->getPages() as $page) {
            $app->get($page->getUrl(), function () use ($app, $page) {
                $renderer = new Renderer();
                $html = $renderer->renderSitePage($this->theme, $this->site, $page->getName(), 'en');
                return $html;
            });
        }
    }
    
    private function initializeDomain()
    {
        $host = $_SERVER['HTTP_HOST'];
        $part = explode(':', $host);
        $domain = $part[0];
        
        $domainConfigFile = __DIR__ . '/../app/config/domains/' . $domain . '.yml';
        if (!file_exists($domainConfigFile)) {
            throw new RuntimeException("Domain not configured: $domain");
        }
        $parser = new YamlParser();
        $domainConfig = $parser->parse(file_get_contents($domainConfigFile));
        
        // Load the theme
        $themeLoader = new XmlThemeLoader();
        $themePath = $domainConfig['theme']['path'];
        $this->theme = $themeLoader->load($themePath . '/theme.xml');

        // Load the site
        $siteLoader = new XmlSiteLoader();
        $sitePath = $domainConfig['site']['path'];
        $this->site = $siteLoader->load($sitePath . '/site.xml');
    }
    
    private function configureParameters()
    {
        $this['debug'] = true;
        $parser = new YamlParser();
        //$config = $parser->parse(file_get_contents(__DIR__ . '/../app/src/parameters.yml'));
        $config = array();
        //print_r($config);
    }

    private function configureProviders()
    {
        // *** Setup Sessions ***
        $this->register(new \Silex\Provider\SessionServiceProvider(), array(
            'session.storage.save_path' => '/tmp/xtheme_server_sessions'
        ));
    }
}
