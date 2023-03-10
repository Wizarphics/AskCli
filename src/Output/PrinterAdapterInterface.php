<?php

declare(strict_types=1);

namespace Wizarphics\AskCli\Output;

interface PrinterAdapterInterface
{
    /**
     * output method
     *
     * @param string $message
     * @return string
     */
    public function out(string $message): string;
}