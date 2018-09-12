<?php

/** @var Sociaqui_Weather_Model_Resource_Mysql4_Setup $installer */
$installer = $this;
$installer->startSetup();

// Create table structure

$tableSql = "CREATE TABLE `{$installer->getTable('weather/forecast')}` (
    `id` int(11) NOT NULL auto_increment,
    `iconUrl` varchar(65) NOT NULL,
    `location` varchar(85) NOT NULL,
    `rawData` text NOT NULL,
    `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$installer->run($tableSql);

// Populate table a single, initial, test entry

$dataSql = "INSERT INTO `{$installer->getTable('weather/forecast')}` (`rawData`,`iconUrl`,`location`) VALUES
('a:2:{s:12:\"LocationName\";s:11:\"Footer Test\";s:11:\"WeatherText\";s:7:\"unknown\";}', '/media/weather/icons/14-s.png', 'Footer Test');";

$installer->run($dataSql);

$installer->endSetup();

// Run the observer update forecasts method once to get a fresh forecast

$observer = new Sociaqui_Weather_Model_Observer;
$observer->updateForecasts();
