<?php

class Sociaqui_Weather_Adminhtml_WeatherController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Weather'))->_title($this->__('Weather'));
        $this->loadLayout();
        $this->_setActiveMenu('sociaqui_weather/archive');
        $this->_addContent($this->getLayout()->createBlock('weather/adminhtml_weather_forecast'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('weather/adminhtml_weather_forecast_grid')->toHtml()
        );
    }

}
