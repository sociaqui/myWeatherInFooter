<?php

/** @var Sociaqui_Weather_Model_Resource_Mysql4_Setup $installer */
$installer = $this;
$installer->startSetup();

// Drop old table

$sql = "DROP TABLE `{$installer->getTable('weather/forecast')}`;";

$installer->run($sql);

// Create new table structure

$tableSql = "CREATE TABLE `{$installer->getTable('weather/forecast')}` (
    `id` int(11) NOT NULL auto_increment,
    `iconUrl` varchar(65) NOT NULL,
    `location` varchar(85) NOT NULL,
    `rawData` text NOT NULL,
    `parsedData` text,
    `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$installer->run($tableSql);

// Populate new table with new, more accurate initial data

$dataSql = "INSERT INTO `{$installer->getTable('weather/forecast')}` (`rawData`,`iconUrl`,`location`) VALUES
('a:2:{s:12:\"LocationName\";s:6:\"DbInit\";s:11:\"WeatherText\";s:11:\"placeholder\";}', 'https://developer.accuweather.com/sites/default/files/04-s.png', 'DbInit'),
('a:2:{s:12:\"LocationName\";s:6:\"DbIni2\";s:11:\"WeatherText\";s:11:\"placeholder\";}', 'https://developer.accuweather.com/sites/default/files/14-s.png', 'DbIni2'),
('a:2:{s:12:\"LocationName\";s:6:\"Lublin\";s:11:\"WeatherText\";s:11:\"placeholder\";}', 'https://developer.accuweather.com/sites/default/files/21-s.png', 'Lublin');";

$installer->run($dataSql);

$installer->endSetup();
