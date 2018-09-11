<?php

class Sociaqui_Weather_Block_Footer extends Mage_Core_Block_Template
{
    /**
     * Retrieve last weather forecast data from Db
     *
     * @return array
     */
    public function getWeatherData()
    {
        /** @var Sociaqui_Weather_Model_Forecast $forecast */
        $forecast = Mage::getModel('weather/forecast')->getCollection()->getLastItem();

        $data = $forecast->getData();

        return $data;
    }

}
