<?php

namespace Tests\Feature\Command;

use PHPUnit\Framework\TestCase;
use Wizarphics\AskCli\Command\CommandCall;

class CommandCallTest extends TestCase{
    
    /**
     * @test
     */
    public function argumentsAreLoadedAndPropertiesAreSet(): void
    {
        // Given that we create a new call minicli help test
        $call = new CommandCall(['mincli', 'help', 'test']);

        // Then we assert that the raw arguments are parsed correctly
        $this->assertCount(3, $call->getRawArgs());

        // Then we assert that the properties command=help and subcommand=test are set correctly
        $this->assertEquals('help', $call->command);
        $this->assertEquals('test', $call->subcommand);
    }

    /**
     * @test
     */
    public function flagsAreSetCorrectly(): void
    {
        // Given that we create a new call minicli help test with a flag --flag
        $call = new CommandCall(['mincli', 'help', 'test', "--flag"]);

        // Then we assert that the flag exists and is set correctly
        $this->assertTrue($call->hasFlag('--flag'));
        $this->assertContains("--flag", $call->getFlags());
    }

    /**
     * @test
     */
    public function flagsCanBeObtainedWithoutTheDashes(): void
    {
        // Given that we create a new call minicli help test with a flag --flag
        $call = new CommandCall(['mincli', 'help', 'test', "--flag"]);

        // Then we assert that the flag exists and can be obtained without the "--"
        $this->assertTrue($call->hasFlag('flag'));
    }

    /**
     * @test
     */
    public function paramsAreSetCorrectly(): void
    {
        // Given that we create a new call minicli help test with a key=value params
        $call = new CommandCall(['mincli', 'help', 'test', "name=valentina"]);

        // Then we assert that the params are set correctly
        $this->assertTrue($call->hasParam('name'));
        $this->assertEquals("valentina", $call->getParam('name'));
    }

    /**
     * @test
     */
    public function paramsAreCorrectlySetIfValueContainsEqualsTo(): void
    {
        // Given that we create a new call minicli help test with a key=value=valen&value2=dominic params
        $call = new CommandCall(['mincli', 'help', 'test', "name=girlfriend=valentina&name=dominic"]);

        // Then we assert that the params are set correctly
        $this->assertTrue($call->hasParam('name'));
        $this->assertEquals("girlfriend=valentina&name=dominic", $call->getParam('name'));
    }
}