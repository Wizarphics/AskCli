<?php

namespace Tests\Uses\Command\Test;
use Wizarphics\AskCli\Command\CommandController;

class HelpController extends CommandController{
    
	/**
	 * handle command.
	 * @return void
	 */
	public function handle(): void {
        $name = "default";

        // Test for arguments
        if($this->hasParam('name')){
            $name = $this->getParam('name');
        }

        //Test for flags
        $shout = false;

        if ($this->hasFlag('--shout')) {
            $shout = true;
        }

        $this->getPrinter()->rawOutput($shout?strtoupper("Hello $name"):"Hello $name");
	}
}