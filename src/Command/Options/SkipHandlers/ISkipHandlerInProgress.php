<?php
namespace App\Command\Options\SkipHandlers;
use App\Entity\Video;

Interface ISkipHandlerInProgress {
    /**
     * Skip Handler while in the download loop (will fuck up estimated time)
     *
     * @param [type] $video
     * @return void
     */
    public function handle_in_progress(Video $video);
} 