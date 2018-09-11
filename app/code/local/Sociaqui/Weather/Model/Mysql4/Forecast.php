<?php

class Sociaqui_Weather_Model_Mysql4_Forecast extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('weather/forecast', 'id');
    }
}