<?php

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;
class OutputIntermediary implements OutputInterface {

    private $output;
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }
    public function write($messages, bool $newline = false, int $options = 0) {
        return $this->output->write($messages, $newline,$options);
    }

    public function writeln($messages, int $options = 0) {
        return $this->output->writeln($messages,$options);
    }

    public function setVerbosity(int $level) {
        return $this->output->setVerbosity($level);
    }

    public function getVerbosity() {
        return $this->output->getVerbosity();
    }

    public function isQuiet() {
        return $this->output->isQuiet();
    }

    public function isVerbose() {
        return $this->output->isVerbose();
    }

    public function isVeryVerbose() {
        return $this->output->isVeryVerbose();
    }

    public function isDebug() {
        return $this->output->isDebug();
    }

    public function setDecorated(bool $decorated) {
        return $this->output->setDecorated($decorated);
    }

    public function isDecorated() {
        return $this->output->isDecorated();
    }

    public function setFormatter(OutputFormatterInterface $formatter) { 
        $this->output->setFormatter($formatter);
    }

    public function getFormatter() {
        $this->output->getFormatter();
    }
    
}