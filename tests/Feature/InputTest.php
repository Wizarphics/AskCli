<?php

namespace Tests\Feature;
use PHPUnit\Framework\TestCase;
use Wizarphics\AskCli\Input;

class InputTest extends TestCase{

    /**
     * @test
     *
     * @requires extension readline
     */
    public function inputSetsADefaultPrompt(): void
    {
        if(!extension_loaded('readline')){
            $this->markTestSkipped();
        }
        $input = new Input();
        $this->assertEquals('minicli$> ', $input->getPrompt());
    }
}