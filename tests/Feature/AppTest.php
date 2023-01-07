<?php

namespace Tests\Feature;
use PHPUnit\Framework\TestCase;
use Wizarphics\AskCli\App;
use Wizarphics\AskCli\Command\CommandRegistry;
use Wizarphics\AskCli\Config;
use Wizarphics\AskCli\Exception\CommandNotFoundException;
use Wizarphics\AskCli\Output\Adapter\DefaultPrinterAdapter;
use Wizarphics\AskCli\Output\OutputHandler;

class AppTest extends TestCase
{
    /**
     * @test
     * @dataProvider basicConfig
     */
    public function appCanBeInitialized($basicConfig)
    {

        // Given that we have a basic configuration array
        $config = $basicConfig;
        // When we initialize the app with the configuration array
        $app = new App($config);

        // Then we assert that an instance of the app was created
        $this->assertInstanceOf(App::class, $app);
    }

    /**
     * @test
     * @dataProvider basicConfig
     */
    public function appSetsGetsAndPrintsSignature(array $basicConfig)
    {
        // Given that we have a basic configuration array and we initialized the app
        $config = $basicConfig;

        $app = new App($config);

        // When we call the setOutputHandler method with the outputhandler
        $app->setOutputHandler(new OutputHandler(new DefaultPrinterAdapter()));

        // Then we assert that the the signature contains "minicli"
        $this->assertStringContainsString('minicli', $app->getSignature());

        // When we call the setSignature method with a new signature
        $app->setSignature('Testing minicli signature');

        // Then we assert that the the signature equals "Testing minicli signature"
        $this->assertEquals('Testing minicli signature', $app->getSignature());

        // When we call the printSignature method
        $app->printSignature();

        // Then we assert that the the signature equals "\nTesting minicli signature\n"
        $this->expectOutputString("\nTesting minicli signature\n");
    }

    /**
     * @test
     * @dataProvider basicConfig
     */
    public function appHasConfigService(array $basicConfig)
    {
        // Given that we have a basic configuration array and we initialized the app
        $config = $basicConfig;

        $app = new App($config);

        // Then we assert that the config service is initialized as an instance of Config
        $this->assertInstanceOf(Config::class, $app->config);
    }

    /**
     * @test
     * @dataProvider basicConfig
     */
    public function appHasCommandRegistryService(array $baseConfig)
    {
        // Given that we have a basic configuration array and we initialized the app
        $config = $baseConfig;

        $app = new App($config);

        // Then we assert that the commandRegistry service is initialized as an instance of CommandRegistry
        $this->assertInstanceOf(CommandRegistry::class, $app->commandRegistry);
    }
    
    /**
     * @test
     */
    public function appParsesCommandPathWithVendorTag()
    {
        // Given that we have created an instance of App with @namspace/command as app_path
        $app = new App([
            'app_path' => '@namespace/command'
        ]);
 
        // When we get the commandsPath from the app->commandRegistry
        $registry = $app->commandRegistry;
        $paths = $registry->getCommandsPath();

        // Then we assert that the path is an array and count is equal to 1
        $this->assertIsArray($paths);
        $this->assertCount(1, $paths);
        var_dump($paths);
        $this->assertStringEndsWith('namespace/command/Command', $paths[0]);
    }

    /**
     * @test
     * @dataProvider basicConfig
     */
    public function appHasPrinterService(array $basicConfig)
    {
        // Given that we have a basic configuration array and we initialized the app
        $config = $basicConfig;

        $app = new App($config);

        // Then we assert that the printer service is initialized as an instance of OutputHandler
        $this->assertInstanceOf(OutputHandler::class, $app->printer);
    }

    /**
     * @test
     * @dataProvider basicConfig
     */
    public function appReturnsNullForMissingService(array $config)
    {
        // Given that we have the base configuration array and we initialized the app
        $app = new App($config);

        // When we try get a non-existence service
        $nonExistence = $app->printers_404_service;

        // Then we assert that the  non-existence service is null
        $this->assertNull($nonExistence);
    }

    /**
     * @test
     * @dataProvider basicConfig
     */
    public function appHandlesAClosureAsAService(array $config)
    {
        // Given that we have the base configuration array and we initialized the app
        $app = new App($config);

        // When we try to add a service using a closure as callback
        $app->addService('closure', function(){
            return 'Hello World From Closure!';
        });

        // Then we assert that the service was added to the app and that it is equal to "Hello World From Closure!"
        $this->assertEquals('Hello World From Closure!', $app->closure);
    }

    /**
     * @test
     * @dataProvider basicConfig
     */
    public function appInstanceIsPassedToTheClosure(array $config)
    {
        // Given that we have the base configuration array and we initialized the app
        $app = new App($config);

        // When we try to add a service using a closure as callback and accept $app as argument
        $app->addService('closure', function($app){
            return $app;
        });

        // Then we assert that the service was added to the app and that it is given the instance of the app
        $this->assertEquals($app, $app->closure);
    }

    /**
     * @test
     * @dataProvider basicConfig
     */
    public function appRegistersAndHandleSingleCommand(array $config)
    {
        // Given that we have the base configuration array and we initialized the app
        $app = new App($config);

        // When we try to register a new single command
        $app->registerCommand('foo', function () use ($app): void {
            $app->getPrinter()->rawOutput('Testing foo');
        });

        // Then we assert that the command was registered and is callable
        $command = $app->commandRegistry->getCallable('foo');
        $this->assertIsCallable($command);

        // Then we assert that the app runs the command
        $app->runCommand(['minicli', 'foo']);
        $this->expectOutputString('Testing foo');
    }

    /**
     * @test
     * @dataProvider basicConfig
     */
    public function appExecuteNamspacedCommand(array $config)
    {
        // Given that we have the base configuration array and we initialized the app
        $app = new App($config);
        
        // When we run the command minicli test
        $app->runCommand(['minicli', 'test']);

        // Then we assert that the command was executed and that the output="Test Default"
        $this->expectOutputString('Test Default');
    }

    /**
     * @test
     * @dataProvider basicConfig
     */
    public function appPrintSignatureWhenNoCommandIsSpecified(array $config): void
    {
        // Given that we have the base configuration array and we initialized the app
        $app = new App($config);

        // When we set the OutputHandler and run the command minicli with no arguments
        $app->setOutputHandler(new OutputHandler(new DefaultPrinterAdapter()));
        $app->runCommand(['minicli']);

        // Then we assert that the command was executed and that the signature is printed
        $this->expectOutputString("\n./minicli help\n");
    }

    /**
     * @test
     * @dataProvider basicConfig
     */
    public function appThrowsExceptionWhenSingleCommandIsNotFound(array $config): void
    {
        // Given that we have the base configuration array and we initialized the app
        $app = new App($config);

        // When we try to run a single command
        $this->expectException(CommandNotFoundException::class);
        $app->runCommand(['minicli', 'foo']);
    }

    /**
     * @test
     * @dataProvider basicConfig
     */
    public function appThrowsExceptionWhenCommandIsNotCallable(array $config): void
    {
        // Given that we have the base configuration array and we initialized the app
        $app = new App($config);

        // When we try to register a not callable command
        $this->expectException(\TypeError::class);
        $app->registerCommand('miniclip', 'miniclip not callable');
    }

    /**
     * @test
     * @dataProvider productionConfig
     */
    public function appShowsErrorWhenDebugIsDisabledAndCommandIsMissing(array $config): void
    {
        $app = new App();
        $expected = $app->getPrinter()->filterOutput("Command \"foo\" not found.", 'error');

        // Given that we have the base configuration array and we initialized the app
        $app = new App($config);

        // When we run the non-existence command minicli foo
        $app->runCommand(['minicli', 'foo']);
        $this->expectOutputString("\n$expected\n");
    }

    public function basicConfig()
    {
        return [
            [ ['app_path' => COMMANDS_PATH ]]
        ];
    }

    public function productionConfig(): array
    {
        return [
            [['app_path' => COMMANDS_PATH, 'debug' => false]]
        ];
    }
}