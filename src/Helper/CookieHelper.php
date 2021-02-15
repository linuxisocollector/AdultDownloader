<?php
namespace App\Helper;
use GuzzleHttp\Cookie\CookieJar;
use KeGi\NetscapeCookieFileHandler\Configuration\Configuration;
use KeGi\NetscapeCookieFileHandler\CookieFileHandler;

class CookieHelper {

    /** @var \GuzzleHttp\Cookie\CookieJar */
    private $cookies;

    private $simpleCookieArray;
    private $domainCookieArray;
    /**
     * Construct the Cookie helper object requires a netscape cookie file
     *
     * @param $string $cookie_file_path
     */
    public function __construct($cookie_file_path,$base_url)
    {
        $configuration = (new Configuration())->setCookieDir(dirname($cookie_file_path));
        $cookieJar = (new CookieFileHandler($configuration))->parseFile(basename($cookie_file_path));
        $domainCookie = $cookieJar->getAll()->toArray();
        $this->domainCookieArray = $domainCookie;
        $cookies = [];
        foreach ( $domainCookie as $key => $cookieSingleDomain) {
            foreach ($cookieSingleDomain as $key => $cookie) {
                $cookies[$cookie['name']] =$cookie['value'];
            }
        }
        $this->simpleCookieArray = $cookies;
        $url = str_replace('https://','',$base_url);
        $url = explode('/',$url);
        $this->cookies = CookieJar::fromArray($cookies,$url[0]);
    }
    /**
     * Returns a String that can be sent directly in the headers
     *
     * @return String
     */
    public function getCookieHeaderString() {
        /** @example Cookie: nats=MC4wLjEuMS4wLjAuMC4wLjA; nats_cookie=https%253A%252F%252Fhookuphotshot.com%252F; nats_sess=0e84835b285106229a7dba17d7ddbc30; nats_landing=No%2BLanding%2BPage%2BURL; Cookie String */
        $cookie_string = "Cookie: ";
        foreach ($this->getCookieArraySimple() as $cookieName => $cookieVal) {
            $cookie_string .= "$cookieName=$cookieVal; ";
        }
        //remove space at end of string
        return substr($cookie_string,0,-1);
    }

    public function getDomainCookieList() {
        return $this->domainCookieArray;
    }

    public function getCookieArraySimple() {
        return $this->simpleCookieArray;
    }
    /**
     * Returns Guzzle Cookie Jar
     *
     * @return \GuzzleHttp\Cookie\CookieJar
     */
    public function getGuzzleCookieJar() {
        return $this->cookies;
    }
}