<?php
namespace App\Downloaders;

use App\Helper\ProgressHelper;
use Cocur\BackgroundProcess\BackgroundProcess;
use Exception;

interface AbstractDownloader {
    public function __construct(ProgressHelper $progressHelper);
    public function downloadFile($url,$dir,$name);

}