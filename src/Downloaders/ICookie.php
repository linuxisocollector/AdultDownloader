<?php

namespace App\Downloaders;

use App\Helper\CookieHelper;

interface ICookie {
    public function setCookies(CookieHelper $cookies);    
}