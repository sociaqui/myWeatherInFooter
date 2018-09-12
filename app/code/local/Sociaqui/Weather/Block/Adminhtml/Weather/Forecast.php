<?php

class Sociaqui_Weather_Block_Adminhtml_Weather_Forecast extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'weather';
        $this->_controller = 'adminhtml_weather_forecast';
        $this->_headerText = Mage::helper('weather')->__('Weather Forecast data Archive');

        parent::__construct();
        $this->_removeButton('add');
    }
}
