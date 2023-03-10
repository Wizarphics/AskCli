<?php

declare(strict_types=1);

namespace Wizarphics\AskCli\Output;

interface OutputFilterInterface
{
    /**
     * output filter
     *
     * @param string $message
     * @param string|null $style
     * @return string
     */
    public function filter(string $message, ?string $style = null): string;
}