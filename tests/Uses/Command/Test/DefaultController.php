<?php

namespace Tests\Uses\Command\Test;
use Wizarphics\AskCli\Command\CommandController;

class DefaultController extends CommandController{
    
	/**
	 * handle command.
	 * @return void
	 */
	public function handle(): void {
        // $this->output->write('handle');
        $this->getPrinter()->rawOutput('Test Default');
	}
}