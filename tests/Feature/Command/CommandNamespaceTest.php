<?php

namespace Tests\Feature\Command;
use PHPUnit\Framework\TestCase;
use Wizarphics\AskCli\Command\CommandController;
use Wizarphics\AskCli\Command\CommandNamespace;

class CommandNamespaceTest extends TestCase{

    /**
     * @test
     */
    public function nameIsSetCorrectly(): void
    {
        // When we create a new namespace "Test"
        $namespace = new CommandNamespace('Test');

        // Then we assert that the namespace property name is set correctly
        $this->assertEquals('Test', $namespace->getName());
    }

    /**
     * @test
     */
    public function controllersAreLoadedSuccessfully(): void{
        // When we create a new namespace "Test"
        $namespace = new CommandNamespace('Test');

        //Then we load the controllers
        $controllers = $namespace->loadControllers(COMMANDS_PATH);

        // Then assert that the controllers is a non-empty array and contains only CommandController instances
        $this->assertIsArray($controllers);
        $this->assertNotEmpty($controllers);
        $this->assertContainsOnlyInstancesOf(CommandController::class, $controllers);
    }

    /**
     * @test
     */
    public function noControllersReturnedIfNamespaceIsEmpty(): void
    {
        // When we create a new namespace "Empty"
        $namespace = new CommandNamespace('Empty');

        //Then we load the controllers
        $controllers = $namespace->loadControllers(COMMANDS_PATH);

        // Then assert that the controllers return an empty array
        $this->assertCount(0, $controllers);
    }
}