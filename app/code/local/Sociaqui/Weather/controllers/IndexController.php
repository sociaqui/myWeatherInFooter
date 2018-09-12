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
}
