<?php

namespace Tests\Uses\VendorCommand\Vendor;
use Wizarphics\AskCli\Command\CommandController;

class DefaultController extends CommandController
{
    public function handle(): void
    {
        $this->getPrinter()->rawOutput('test vendor');
    }
}