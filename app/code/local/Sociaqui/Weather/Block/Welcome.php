<?php

class Sociaqui_Weather_Block_Welcome extends Mage_Core_Block_Template
{
    /**
     * Prepare the welcome text for module index page
     *
     * @return string
     */
    protected function getText()
    {
        $table = 'sociaqui_weather_forecasts'; //TODO: get value programmatically
        $version = '0.1.0'; //TODO: get value programmatically

        $text = "<h3>Thank you for installing the Sociaqui Weather in Footer module!</h3>";
        $text .= "<p>Initial installation process complete.</p>";
        $text .= "<p>Database table: {$table}</p>";
        $text .= "<p>Module ver. {$version}</p>";
        $text .= "<p>The new footer section should now be visible on every page. Even this one! ";
        $text .= "(try refreshing the page and if the new section doesn't appear consult the ";
        $text .= "<strong>Debugging</strong> section in the README file</p>";

        return $text;
    }
}
