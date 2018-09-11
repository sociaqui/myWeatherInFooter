<?php

/** @var Sociaqui_Weather_Model_Resource_Mysql4_Setup $installer */
$installer = $this;
$installer->startSetup();

// Create table structure

$tableSql = "CREATE TABLE `{$installer->getTable('weather/forecast')}` (
    `id` int(11) NOT NULL auto_increment,
    `data` text NOT NULL,
    `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$installer->run($tableSql);

// Populate table with initial, placeholder data

$dataSql = "INSERT INTO `{$installer->getTable('weather/forecast')}` (`data`) VALUES
('a:2:{s:12:\"LocationName\";s:6:\"DbInit\";s:11:\"WeatherText\";s:11:\"placeholder\";}'),
('a:2:{s:12:\"LocationName\";s:6:\"DbIni2\";s:11:\"WeatherText\";s:10:\"placetaker\";}');";

$installer->run($dataSql);

$installer->endSetup();
