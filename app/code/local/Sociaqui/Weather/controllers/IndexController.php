<?php

class Sociaqui_Weather_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Index action
     */
    public function indexAction()
    {
        /** @var Sociaqui_Weather_Model_Forecast $forecast */
        $forecast = Mage::getModel('weather/forecast')->getCollection()->getLastItem();

        $data = $forecast->getData('data');
        $weather = unserialize($data);

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

}
