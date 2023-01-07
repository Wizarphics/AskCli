<?php

namespace Tests\Uses\Command\Test;
use Wizarphics\AskCli\Command\CommandController;

class ParamsController extends CommandController
{
    public function handle(): void
    {
        $print = count($this->getArgs());

        if ($this->hasFlag('--count-params')) {
            $print = count($this->getParams());
        }

        $this->getPrinter()->rawOutput($print);
    }
}