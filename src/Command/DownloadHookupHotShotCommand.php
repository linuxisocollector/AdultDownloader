<?php

namespace App\Command;

use App\Downloaders\Aria2;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use App\Exceptions\InvalidChannelsException;
use App\Exceptions\VideoExceptionInterface;
use App\Helper\DirectoryHelper;
use App\Helper\ProgressHelper;
use App\Entity\Page;
use App\Entity\Video;
use App\Helper\EntityManager;
use DateTime;
use App\Helper\DownloadHelper;
use App\Parser\HookupHotshot;
use Exception;
use Psr\Log\LoggerInterface;

class DownloadHookupHotShotCommand extends AbstractDownloadCommand
{
    protected static $defaultName = 'download:hookuphotshot';

    protected function getPageName() {
        return 'HookupHotshot';
    }

    protected function getPageId() {
        return 1;
    }

    protected function getBaseUrl() {
        return 'https://hookuphotshot.com/';
    }

    protected function getFirstPage() { 
        return 0;
    }

    protected function getVideoPath() {
        return '/the-dates/page/{num}/';
    }

    protected function lastPageReached($response) {
        if(str_contains($response->getBody(),'Sorry... there are no more dates. Click ')) {
            throw new Exception('Reached end');
        }
    }

    protected function getOverviewParser() {
        return new HookupHotshot();
    }


    protected function getVideoDownloadClient(ProgressHelper $progressHelper) {
        return new Aria2($progressHelper);
    }
}


