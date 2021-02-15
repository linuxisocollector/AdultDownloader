<?php
namespace App\Helper;

use App\Downloaders\IBasicAuth;
use App\Downloaders\ICookie;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use KeGi\NetscapeCookieFileHandler\Configuration\Configuration;
use KeGi\NetscapeCookieFileHandler\CookieFileHandler;

class DownloadHelper implements ICookie, IBasicAuth {

    private $client = null;
    private $cookies = null;
    private $base_url = null;
    private $basic_username = false;
    private $basic_password = false;

    public function __construct($base_url)
    {
        $this->base_url = $base_url;
        $this->client = new Client([
            'base_uri' => $base_url,
            'timeout'  => 20.0,
        ]);
    }

    private function Init() {
        $params = [
                'base_uri' => $this->base_url,
                'timeout'  => 20.0,
        ];
        if($this->cookies !== null) {
            $params['cookies'] = $this->cookies;
        }
        if($this->basic_username !== false && $this->basic_password !== false) {
            $params['auth'] = [
                $this->basic_username,
                $this->basic_password
            ];
        }
        if($this->client !== null) {
            unset($this->client);
        }
        $this->client = new Client($params);
    }
    public function setCookies(CookieHelper $cookies) {
        $this->cookies = $cookies->getGuzzleCookieJar();
        $this->Init(); 
    }

    public function setBasicAuth($username, $password) {
        $this->basic_username = $username;
        $this->basic_password = $password;
        $this->Init(); 
    }

    /**
     * Undocumented function
     *
     * @return GuzzleHttp\Client
     */
    public function getClient() {
        return $this->client;
    }

}