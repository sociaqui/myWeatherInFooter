<?php

class Sociaqui_Weather_Block_Footer extends Mage_Core_Block_Template
{
    /**
     * Retrieve last weather forecast data from Db
     *
     * @return array
     */
    protected function getWeatherData()
    {
        /** @var Sociaqui_Weather_Model_Forecast $forecast */
        $forecast = Mage::getModel('weather/forecast')->getCollection()->getLastItem();
        $data = $forecast->getData();

        return $data;
    }

    /**
     * Parse the raw forecast weather data for the footer
     *
     * @param array $data
     * @return array
     */
    protected function getParsedData($data)
    {
        /** @var Sociaqui_Weather_Helper_Data $helper */
        $helper = Mage::helper('weather');
        $parsedData = $helper->parseWeatherData($data);

        return $parsedData;
    }

    /**
     * Generate wind direction snippet (has to be added after data load from Db - the arrow symbol wouldn't encode properly)
     *
     * @param array $data
     * @return string
     */
    protected function getWindDirection($data)
    {
        $directionLetter = $data['Wind']['Direction']['Localized'];
        $snippet = ' ' . Sociaqui_Weather_Helper_Data::WIND_ARROW_ARRAY[$directionLetter];
        $snippet .= ' ' . $directionLetter;

        return $snippet;
    }

}
