<?php

class Sociaqui_Weather_Helper_Data extends Mage_Core_Helper_Data
{
    const XML_CONFIG_PATH_WEATHER_API_KEY = 'weather_setup/api/key';
    const XML_CONFIG_PATH_WEATHER_LOCATION = 'weather_setup/api/location';
    const XML_CONFIG_PATH_WEATHER_LOCATION_CODE = 'weather_setup/api/location_code';

    const WIND_ARROW_ARRAY = array(
        'W' => '⇐',
        'E' => '⇒',
        'N' => '⇑',
        'S' => '⇓',
        'NW' => '⇖',
        'NE' => '⇗',
        'SE' => '⇘',
        'SW' => '⇙',
        'NNW' => '⇖',
        'NNE' => '⇗',
        'SSE' => '⇘',
        'SSW' => '⇙',
        'WNW' => '⇖',
        'WSW' => '⇙',
        'ENE' => '⇗',
        'ESE' => '⇘',
    );

    /**
     * Gets the current weather from AccuWeather for the given numeric location code (Lublin by default)
     * use https://developer.accuweather.com/accuweather-locations-api/apis/get/locations/v1/cities/search to find other cities
     *
     * @param int $locationCode
     * @param string $apiKey
     * @return array
     */
    public function getWeather($locationCode = 274231, $apiKey = 'elbFGXDtVANeARtejGztyukgXomEIRBy')
    {
//      if provided API key doesn't pass validation use default one anyway
        if(!$this->validateApiKey($apiKey)){
            $apiKey = 'elbFGXDtVANeARtejGztyukgXomEIRBy';
        }

        $template = 'http://dataservice.accuweather.com/currentconditions/v1/%s.json?apikey=%s&details=true';
        $url = sprintf($template, $locationCode, $apiKey);

        /** @var resource $curl */
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_ENCODING => 'gzip,deflate',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FAILONERROR => true,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $weather = [];

        if (empty($err)) {
            $weather = json_decode(utf8_encode($response), true)[0];
        } else {
            Mage::log('An error occurred while trying to access API endpoint', null, 'sociaqui_weather.log');
            Mage::log('url: ' . $url, null, 'sociaqui_weather.log');
            Mage::log('error: ' . $err, null, 'sociaqui_weather.log');
        }

        return $weather;
    }

    /**
     * Creates an orderly array with data stored under keys that work as labels on the display
     *
     * @param array $rawData
     * @return array
     */
    public function parseWeatherData($rawData)
    {
        $url = '<a href="' . $rawData['Link'] . '" title="Superior Accuracy in Action">AccuWeather APIs</a>';
        $formattedTime = date('H:i:s \o\n D jS \of F Y', strtotime($rawData['LocalObservationDateTime']));

        $data = array(
            'General conditions: ' => $rawData["WeatherText"],
            'Temperature: ' => $rawData['Temperature']['Metric']['Value']
                . ' ' .
                $rawData['Temperature']['Metric']['Unit'],
            'Wind: ' => $rawData['Wind']['Speed']['Metric']['Value']
                . ' ' .
                $rawData['Wind']['Speed']['Metric']['Unit'],
            'Pressure: ' => $rawData['Pressure']['Metric']['Value']
                . ' ' .
                $rawData['Pressure']['Metric']['Unit'],
            'last updated at: ' => $formattedTime,
            'Source: ' => $url,
        );

        return $data;
    }

    /**
     * 'validates' the provided API key (actually just checks if it's a 32 alphanumeric characters long string, not
     * really a working key - but it's a start)
     *
     * @param string $apiKey
     * @return bool
     */
    public function validateApiKey($apiKey)
    {
        if (preg_match('/^[\w\d]{32}$/i', $apiKey)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}