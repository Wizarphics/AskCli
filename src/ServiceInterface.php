<?php

declare(strict_types=1);

namespace Wizarphics\AskCli;

interface ServiceInterface
{
    /**
     * load application
     *
     * @param App $app
     * @return void
     */
    public function load(App $app): void;
}