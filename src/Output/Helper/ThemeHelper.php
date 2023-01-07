<?php

declare(strict_types=1);

namespace Wizarphics\AskCli\Output\Helper;
use Wizarphics\AskCli\Output\Filter\ColorOutputFilter;

class ThemeHelper
{
    /**
     * theme
     *
     * @var string
     */
    protected string $theme = '';

    private string $themeNamespace = '\\Wizarphics\AskCli\\Output\\Theme';

    /**
     * ThemeHelper constructor. Takes in the App theme config value
     *
     * @param string $themeConfig
     */
    public function __construct(string $themeConfig = '')
    {
        $this->theme = $this->parseThemeSetting($themeConfig);
        //return $this;
    }

    /**
     * Initialize and return an OutputFilter based on our theme class
     *
     * @return ColorOutputFilter
     */
    public function getOutputFilter(): ColorOutPutFilter
    {
        if (class_exists($this->theme)) {
            return new ColorOutputFilter(new $this->theme());
        }

        return new ColorOutputFilter();
    }

    /**
     * Parses the theme config setting and returns a namespaced class name.
     *
     * @param string $themeConfig
     * @return string
     */
    protected function parseThemeSetting(string $themeConfig): string
    {
        if (!$themeConfig) {
            return '';
        }

        if ($themeConfig[0] == '\\') {
            return $this->themeNamespace . $themeConfig . 'Theme';  // Built-in theme.
        }

        return $themeConfig . 'Theme'; // User-defined theme.
    }
}