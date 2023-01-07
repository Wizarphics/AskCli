<?php

namespace Tests\Feature;
use PHPUnit\Framework\TestCase;
use Wizarphics\AskCli\Config;

class ConfigTest extends TestCase
{
    /**
     * @test
     */
    public function configSetsPropertiesFromConstructor(): void
    {
        // Given config array od ['foo'=>'bar', 'bar'=>'baz']
        // When we initialize the config with array
        $config = new Config([
            'foo' => 'bar',
            'bar' => 'baz',
        ]);

        // Then we assert that the config contains foo and bar
        $this->assertTrue($config->has('foo'));
        $this->assertTrue($config->has('bar'));        
    }

    /**
     * @test
     */
    public function configSetsAndGetsProperties(): void
    {
        // Given config array od ['foo'=>'bar', 'bar'=>'baz']
        // When we initialize the config with array
        $config = new Config([
            'foo' => 'bar',
            'bar' => 'baz',
        ]);

        // When we assign a new property "boo" with value of "3" to the config object
        $config->boo = '3';

        // Then we assert that the config contains boo="3"
        $this->assertTrue($config->has('boo'));
        $this->assertEquals('3', $config->boo);
    }
}
