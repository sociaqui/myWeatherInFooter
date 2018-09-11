<?php

class Sociaqui_Weather_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $weather = $this->GetWeather();

        $output = 'RIGHT NOW THE WEATHER IN ' . $weather["LocationName"] . ' IS: ';
        $output .= '<br>';
        $output .= '<br>';
        $output .= 'General conditions: ';
        $output .= $weather["WeatherText"];
        $output .= '<br>';
        $output .= 'Temperature: ';
        $output .= $weather['Temperature']['Metric']['Value'];
        $output .= ' ';
        $output .= $weather['Temperature']['Metric']['Unit'];
        $output .= '<br>';
        $output .= 'Wind: ';
        $output .= $weather['Wind']['Speed']['Metric']['Value'];
        $output .= ' ';
        $output .= $weather['Wind']['Speed']['Metric']['Unit'];
        $output .= ' ';
        $output .= $weather['Wind']['Direction']['Localized'];
        $output .= '<br>';
        $output .= 'Pressure: ';
        $output .= $weather['Pressure']['Metric']['Value'];
        $output .= ' ';
        $output .= $weather['Pressure']['Metric']['Unit'];
        $output .= '<br>';
        $output .= 'last updated: ';
        $output .= $weather['LocalObservationDateTime'];
        $output .= '<br>';
        $output .= 'Source: ';
        $output .= $weather['Link'];
        $output .= '<br>';
        $output .= '<img src="https://developer.accuweather.com/sites/default/files/' . sprintf("%02d", $weather["WeatherIcon"]) . '-s.png" width="75" height="45" alt="' . $weather["WeatherText"] . '" title="' . $weather["WeatherText"] . '">';

        $this->getResponse()->setBody($output);

    }

    public function testModelAction()
    {
        $params = $this->getRequest()->getParams();

        $forecast = Mage::getModel('weather/forecast');
        $forecast->load($params['id']);

        $data = $forecast->getData();
//        var_dump($data);

        $weather = unserialize($data['data']);

        $output = 'Loading the forecast with an ID of #' . $params['id'];
        $output .= '<br>';
        $output .= '<br>';
        $output .= 'RIGHT NOW THE WEATHER IN ' . $weather["LocationName"] . ' IS: ';
        $output .= '<br>';
        $output .= '<br>';
        $output .= 'General conditions: ';
        $output .= $weather["WeatherText"];
        $output .= '<br>';
        $output .= 'Temperature: ';
        $output .= $weather['Temperature']['Metric']['Value'];
        $output .= ' ';
        $output .= $weather['Temperature']['Metric']['Unit'];
        $output .= '<br>';
        $output .= 'Wind: ';
        $output .= $weather['Wind']['Speed']['Metric']['Value'];
        $output .= ' ';
        $output .= $weather['Wind']['Speed']['Metric']['Unit'];
        $output .= ' ';
        $output .= $weather['Wind']['Direction']['Localized'];
        $output .= '<br>';
        $output .= 'Pressure: ';
        $output .= $weather['Pressure']['Metric']['Value'];
        $output .= ' ';
        $output .= $weather['Pressure']['Metric']['Unit'];
        $output .= '<br>';
        $output .= 'last updated: ';
        $output .= $weather['LocalObservationDateTime'];
        $output .= '<br>';
        $output .= 'Source: ';
        $output .= $weather['Link'];
        $output .= '<br>';
        $output .= '<img src="https://developer.accuweather.com/sites/default/files/' . sprintf("%02d", $weather["WeatherIcon"]) . '-s.png" width="75" height="45" alt="' . $weather["WeatherText"] . '" title="' . $weather["WeatherText"] . '">';

        $this->getResponse()->setBody($output);
    }

    public function showAllForecastsAction()
    {
        $forecasts = Mage::getModel('weather/forecast')->getCollection();
        $output = '<h2> All forecasts saved to Db: </h2>';
        $output .= '<br>';

        foreach ($forecasts as $forecast) {
            $output .= '<h3>' . $forecast->getTimestamp() . '</h3>';
            $output .= $forecast->getData()['data'];
            $output .= '<br>';
        }

        $this->getResponse()->setBody($output);
    }

    /**
     * Gets the current weather from AccuWeather for the given numeric location code (Lublin by default)
     * use http://dataservice.accuweather.com/locations/v1/cities/search?apikey={key}&q={city} to find other cities
     *
     * @param int $locationCode
     * @param string $location
     * @param string $apiKey
     * @return array
     */
    private function getWeather($locationCode = 274231, $location = 'Lublin', $apiKey = 'elbFGXDtVANeARtejGztyukgXomEIRBy')
    {
        $template = 'http://dataservice.accuweather.com/currentconditions/v1/%s.json?apikey=%s&details=true';
        $url = sprintf($template, $locationCode, $apiKey);

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

        $weather["LocationName"] = $location;
        $weather["WeatherText"] = 'placeholder';

        $test1 = serialize($weather);
        $test2 = unserialize($test1);

        return $weather;
    }

}
