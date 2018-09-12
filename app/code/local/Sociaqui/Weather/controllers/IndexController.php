<?php

class Sociaqui_Weather_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->loadLayout();

        /** @var Mage_Core_Model_Layout $layout */
        $layout = $this->getLayout();

        /** @var Mage_Core_Block_Text_List $content */
        $content = $layout->getBlock('content');

        /** @var Mage_Core_Block_Template $newBlock */
        $newBlock = $layout->createBlock('weather/welcome', 'welcome_text');

        $newBlock->setTemplate('weather/welcome.phtml');
        $content->append($newBlock);

        $this->renderLayout();
    }

    public function testModelAction()
    {
        $params = $this->getRequest()->getParams();

        $forecast = Mage::getModel('weather/forecast');
        $forecast->load($params['id']);

        $data = $forecast->getData();
        $rawData = unserialize($data['rawData']);

        var_dump($rawData);

    }

    public function showAllForecastsAction()
    {
        $forecasts = Mage::getModel('weather/forecast')->getCollection();
        $output = '<h2> All forecasts saved to Db: </h2>';
        $output .= '<br>';

        foreach ($forecasts as $forecast) {
            $output .= '<h3>' . $forecast->getTimestamp() . '</h3>';
            $output .= $forecast->getData()['location'];
            $output .= '<br>';
            $output .= 'RAW: ';
            $output .= $forecast->getData()['rawData'];
            $output .= '<br>';
            $output .= 'PARSED: ';
            $output .= $forecast->getData()['parsedData'];
            $output .= '<br>';
            $output .= $forecast->getData()['iconUrl'];
            $output .= '<br>';
        }

        $this->getResponse()->setBody($output);
    }

}
