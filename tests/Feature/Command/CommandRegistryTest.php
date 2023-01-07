<?php

namespace Tests\Feature\Command;

use PHPUnit\Framework\TestCase;
use Wizarphics\AskCli\Command\CommandNamespace;
use Wizarphics\AskCli\Exception\CommandNotFoundException;

class CommandRegistryTest extends TestCase
{
    /**
     * @test
     */
    public function autoloadsCommandNamespaces(): void
    {
        // Given the command registry
        $register = getRegistry();

        // When we try to get the namespace "test"
        $namespace = $register->getNamespace('test');

        // Then we assert that the namespace is not null and is an instance of CommandNamespace
        $this->assertNotNull($namespace);
        $this->assertInstanceOf(CommandNamespace::class, $namespace);
    }

    /**
     * @test
     */
    public function autoloadCommandNamespaceFromMultiSourcePaths(): void
    {
        // Given the command registry with multiple paths
        $register = getRegistry(true);

        // When we try to get the namespace "test" and "vendor"
        $namespace = $register->getNamespace('test');
        $namespace2 = $register->getNamespace('vendor');

        // Then we assert that the namespaces are not null and are an instance of CommandNamespace
        $this->assertNotNull($namespace);
        $this->assertInstanceOf(CommandNamespace::class, $namespace);

        $this->assertNotNull($namespace2);
        $this->assertInstanceOf(CommandNamespace::class, $namespace2);
    }

    /**
     * @test
     */
    public function returnsNullIfNamespaceIsMissing(): void
    {
        // Given the command registry
        $register = getRegistry();

        // When we try to get the namespace "dashed"
        $namespace = $register->getNamespace('dashed');

        // Then we assert that the namespace returns null
        $this->assertNull($namespace);
    }

    /**
     * @test
     */
    public function returnsDefaultControllerFromNamespaceIfNoSubCommandIsPassed(): void
    {
        // Given the command registry
        $register = getRegistry();

        // When we try to get the callableController for "test" namespace
        $callableController = $register->getCallableController('test');

        // Then we assert that the callableController is an instance of \Tests\Uses\Command\Test\DefaultController
        $this->assertInstanceOf(\Tests\Uses\Command\Test\DefaultController::class, $callableController);
    }

    /**
     * @test
     */
    public function returnsCorrectControllerFromNamespaceIfSubCommandIsPassed(): void
    {
        // Given the command registry
        $register = getRegistry();

        // When we try to get the callableController for "test" namespace
        $callableController = $register->getCallableController('test', 'help');

        // Then we assert that the callableController is an instance of \Tests\Uses\Command\Test\HelpController
        $this->assertInstanceOf(\Tests\Uses\Command\Test\HelpController::class, $callableController);
    }

    /**
     * @test
     */
    public function returnsNullWhenANamespaceControllerIsMissing(): void
    { 
        // Given the command registry
        $register = getRegistry();

        // When we try to get the callableController for "dashed" namespace
        $callableController = $register->getCallableController('dashed');

        // Then we assert that the callableController is null
        $this->assertNull($callableController);
    }

    /**
     * @test
     */
    public function returnsCorrectCallable(): void
    {
        // Given the command registry
        $register = getRegistry();

        // When we try to get the callable for "minicli-test"
        $callable = $register->getCallable('minicli-test');

        // Then we assert that the callable is callable
        $this->assertIsCallable($callable);
    }

    /**
     * @test
     */
    public function throws_CommandNotFoundException_if_command_Is_missing(): void
    {
        // Given the command registry
        $register = getRegistry();

        // When we try to get the callable for "jhgfd"
        $this->expectException(CommandNotFoundException::class);
        $register->getCallable('jhgfd');
    }

    /**
     * @test
     */
    public function returnsFullCommandList(): void
    {
        // Given the command registry
        $register = getRegistry();

        // When we try to get the full list of commands
        $commands = $register->getCommandMap();

        // Then we assert that the list is not empty
        $this->assertCount(2, $commands);
        $this->assertArrayHasKey('test', $commands);
    }

    /**
     * @test
     */
    public function returnsFullCommandListWithMultipleCommandSource(): void
    {
        // Given the command registry
        $register = getRegistry(true);

        // When we try to get the full list of commands
        $commands = $register->getCommandMap();
        // Then we assert that the list is not empty and that it contains commands from the defined sources
        $this->assertCount(2, $commands);
        $this->assertCount(4, $commands['test']);
        $this->assertCount(1, $commands['vendor']);
    }
}