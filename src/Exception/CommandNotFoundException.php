<?php

namespace Wizarphics\AskCli\Exception;

class CommandNotFoundException extends \Exception
{
    /**
	 * @var int
	 */
	protected $code = 404;
}