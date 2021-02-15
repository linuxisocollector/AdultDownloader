<?php

namespace App\Downloaders;

interface IBasicAuth {
    public function setBasicAuth($username,$password);
}