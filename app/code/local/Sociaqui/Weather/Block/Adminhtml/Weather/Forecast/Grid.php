<?php

class Sociaqui_Weather_Block_Adminhtml_Weather_Forecast_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('adminhtml_weather_forecast_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('weather/forecast_collection');
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        /** @var Sociaqui_Weather_Helper_Data $helper */
        $helper = Mage::helper('weather');

        $this->addColumn('id', array(
            'header' => $helper->__('Forecast #'),
            'index'  => 'id'
        ));

        $this->addColumn('timestamp', array(
            'header' => $helper->__('timestamp'),
            'index'  => 'timestamp'
        ));

        $this->addColumn('location', array(
            'header' => $helper->__('location'),
            'index'  => 'location'
        ));

        $this->addColumn('iconUrl', array(
            'header'       => $helper->__('icon url'),
            'index'        => 'iconUrl',
        ));

        $this->addColumn('rawData', array(
            'header'       => $helper->__('raw data'),
            'index'        => 'rawData',
        ));
//      TODO: add columns for all parameters displayed in footer; restrict raw data default view size

//        TODO: add exporting capabilities
//        $this->addExportType('*/*/exportWeatherCsv', $helper->__('CSV'));
//        $this->addExportType('*/*/exportWeatherExcel', $helper->__('Excel XML'));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}