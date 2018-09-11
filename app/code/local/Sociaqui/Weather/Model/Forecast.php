<?php

class Sociaqui_Weather_Model_Forecast extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('weather/forecast');
    }
}