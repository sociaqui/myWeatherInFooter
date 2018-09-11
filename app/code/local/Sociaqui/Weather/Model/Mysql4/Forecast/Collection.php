<?php

class Sociaqui_Weather_Model_Mysql4_Forecast_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('weather/forecast');
    }
}