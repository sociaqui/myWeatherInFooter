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
        $apiKey = Mage::getStoreConfig(Sociaqui_Weather_Helper_Data::XML_CONFIG_PATH_WEATHER_API_KEY);
        $location = Mage::getStoreConfig(Sociaqui_Weather_Helper_Data::XML_CONFIG_PATH_WEATHER_LOCATION_CODE);
        $weather = $helper->getWeather($location, $apiKey);

        if(!empty($weather)) {
            $location = Mage::getStoreConfig(Sociaqui_Weather_Helper_Data::XML_CONFIG_PATH_WEATHER_LOCATION);

            $iconUrl = sprintf("/media/weather/icons/%02d-s.png", $weather["WeatherIcon"]);

            /** @var Sociaqui_Weather_Model_Forecast $forecast */
            $forecast = Mage::getModel('weather/forecast');
            $forecast->setData('rawData', serialize($weather));
            $forecast->setData('location', $location);
            $forecast->setData('iconUrl', $iconUrl);
            try {
                $forecast->save();
            }catch (Exception $e){
                Mage::log('An error occurred while trying to save latest weather forecast to Db', null, 'sociaqui_weather.log');
                Mage::log('error: ' . $e, null, 'sociaqui_weather.log');
            }
        }

        return $this;
    }
}
