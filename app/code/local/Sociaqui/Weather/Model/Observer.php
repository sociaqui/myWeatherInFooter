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

        if(!empty($weather)) {
            $location = 'Lublin'; // TODO: make hardcoded value settable

            /** @var Sociaqui_Weather_Model_Forecast $forecast */
            $forecast = Mage::getModel('weather/forecast');
            $forecast->setData('rawData', serialize($weather));
            $forecast->setData('location', $location);
            $forecast->setData('iconUrl', $weather['WeatherIcon']);
            $forecast->save();
        }

        return $this;
    }
}
