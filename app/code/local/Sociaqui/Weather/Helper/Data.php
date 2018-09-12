<?php

class Sociaqui_Weather_Helper_Data extends Mage_Core_Helper_Data
{
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
    public function getWeather($locationCode = 274231, $apiKey = 'elbFGXDtVANeARtejGztyukgXomEIRBy')  // TODO: add inputs to override these defaults
    {
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
}