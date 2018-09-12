# Weather in Footer

A simple module to display some weather news in the footer of your Magento based store.

## Requirements

A working Magento 1.9.3 install

- [Magento](https://magento.com/tech-resources/download) itself requires a working php installation, a web-server (i.e. nginx, apache), a working database, etc.
- you can try [this](https://github.com/andreaskoch/dockerized-magento) dockerized version of ["Magento Community Edition 1.9.x"](https://github.com/andreaskoch/dockerized-magento) with a complete stack in multiple containers run with [docker-compose](https://docs.docker.com/compose/) (1.7 or higher).

An AccuWeather API key

- (my free Limited Trial AccuWeather API key is hardcoded as the default value in the data getter but it's limited to 50 calls per day, so not really good for anything more than just testing if the Module works).

## Installation

1. Clone / copy the repository INTO your magento root directory.
1. Visit the Module index page ('/weather' relative path on your Magento Frontend) to initialize database setup process.
1. Set up some basic options. Log into your Magento Admin Backend. Go to System -> Configuration -> Sociaqui Weather -> General Options. Expand the only section (API). Input your API key. Change the rest of the options or leave the default values.
1. This module uses Magento Scheduler to run repeated tasks in the background (namely, getting fresh weather data every 10 minutes). Make sure you have cronjobs enabled in Magento. Log into your Magento Admin Backend. Go to System -> Configuration -> System. Expand the "Cron (Scheduled Tasks)..." section and review the settings. Go to System -> Scheduler -> Job Configuration. Make sure 'update_forecasts_in_database' is enabled. Generate a fresh schedule with 'Generate Schedule'. Go to System -> Scheduler -> List View. Make sure 'update_forecasts_in_database' is scheduled every 10 minutes. You can also manually run the job (Actions->Run now) from the System -> Scheduler -> Job Configuration view.

## Usage

- the module will add a new section to footer, that should be visible on every page (unless you customized layout heavily).
- the module runs a cron job that should fetch fresh data every 10 minutes.
- all raw data retrieved from API is stored in the database for future use (only a small part is actually displayed). Archived data can be viewed on Admin Panel, under Sociaqui Weather -> Forecasts Archive or directly in database in 'sociaqui_weather_forecasts' table.

## Debugging

If you are having any problems with this module on production it is strongly recommended that you disable it and test it / debug it in some staging / local environment.

1. Make sure you have enabled Magento logging. Log into your Magento Admin Backend. Go to System -> Configuration -> Developer. Expand the "Log Settings" section. Make sure the "Enabled" option is set to "Yes". Don't forget to click "Save Config". Aside from system errors and exceptions look into /var/log/sociaqui_weather.log for problems specifically logged by this module.
1. Make sure your API key works. You can test it independently - directly on their [page](https://developer.accuweather.com/accuweather-locations-api/apis/get/locations/v1/cities/search).
1. Check the cron job in Magento Scheduler. See if it's on the list and if it got properly scheduled for the near future.
1. See if any data gets written to the database. You can run the cron job manually from System -> Scheduler -> Job Configuration.
1. Try to invalidate cache or even completely turn it off temporarily.




