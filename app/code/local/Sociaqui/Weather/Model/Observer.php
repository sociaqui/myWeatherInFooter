<?php

class Sociaqui_Weather_Model_Observer
{

    /**
     * Update forecasts data collection in database
     *
     * @return Sociaqui_Weather_Model_Observer
     */
    public function updateForecasts()
    {
        /** @var Sociaqui_Weather_Helper_Data $helper */
        $helper = Mage::helper('weather');
        $weather = $helper->getWeather();

        /** @var Sociaqui_Weather_Model_Forecast $forecast */
        $forecast = Mage::getModel('weather/forecast');
        $forecast->setData('data', serialize($weather));
        $forecast->save();

        return $this;
    }

}
