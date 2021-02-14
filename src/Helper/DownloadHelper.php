<?php
namespace App\Helper;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie;
use GuzzleHttp\Cookie\FileCookieJar;
use GuzzleHttp\Cookie\SetCookie;
use KeGi\NetscapeCookieFileHandler\Configuration\Configuration;
use KeGi\NetscapeCookieFileHandler\CookieFileHandler;

class DownloadHelper {

    private $client = null;
    private $cookies = null;
    public function __construct($base_url)
    {
        $configuration = (new Configuration())->setCookieDir('cookies/');
        $cookieJar = (new CookieFileHandler($configuration))->parseFile('cookies.txt');
        $guzzle_jar = new CookieJar(false,[]);
        $domain_cookie = $cookieJar->getAll()->toArray();
        $cookies = [];
        foreach ( $domain_cookie as $key => $cookie_d) {
            foreach ($cookie_d as $key => $cookie) {
                $cookies[$cookie['name']] =$cookie['value'];
            }
        }
        $this->cookies = CookieJar::fromArray($cookies,'hookuphotshot.com');
        $this->client = new Client([
            'base_uri' => $base_url,
            'timeout'  => 20.0,
            'cookies' => $this->cookies
        ]);

    }

    public function getClient() {
        return $this->client;
    }

    public function getRequest($url) {
        dump($this->getClient()->request('GET',$url));
    }
}