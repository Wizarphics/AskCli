<?php

declare(strict_types=1);

namespace Wizarphics\AskCli\Output\Theme;
use Wizarphics\AskCli\Output\CLIColors;


class DaltonTheme extends DefaultTheme
{
    /**
     * get the colors
     *
     * @return array
     */
    public function getThemeColors(): array
    {
        return [
            'default'     => [ CLIColors::$FG_YELLOW ],
            'alt'         => [ CLIColors::$FG_BLACK, CLIColors::$BG_YELLOW ],
            'error'       => [ CLIColors::$FG_RED ],
            'error_alt'   => [ CLIColors::$FG_WHITE, CLIColors::$BG_RED ],
            'success'     => [ CliColors::$FG_CYAN ],
            'success_alt' => [ CLIColors::$FG_BLACK, CLIColors::$BG_CYAN ],
            'info'        => [ CLIColors::$FG_MAGENTA],
            'info_alt'    => [ CLIColors::$FG_WHITE, CLIColors::$BG_MAGENTA ],
            'warning'     => [ CLIColors::$FG_YELLOW],
            'warning_alt' => [ CLIColors::$FG_BLACK, CLIColors::$BG_YELLOW]
        ];
    }
}