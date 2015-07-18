[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a32fc8c5-0bc8-4daa-8b8d-eb2696de949c/big.png)](https://insight.sensiolabs.com/projects/a32fc8c5-0bc8-4daa-8b8d-eb2696de949c)
======================
[![Build Status](https://travis-ci.org/dariuszwrzesien/DwrGlobalWeatherBundle.svg?branch=master)](https://travis-ci.org/dariuszwrzesien/DwrGlobalWeatherBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dariuszwrzesien/DwrGlobalWeatherBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dariuszwrzesien/DwrGlobalWeatherBundle/?branch=master)
[![Coverage Status](https://coveralls.io/repos/dariuszwrzesien/DwrGlobalWeatherBundle/badge.svg?branch=master&service=github)](https://coveralls.io/github/dariuszwrzesien/DwrGlobalWeatherBundle?branch=master)

# **DwrGlobalWeather**

This bundle creates weather widget in your application.

## **Installation**

Installation is a quick 4 steps process:

1. Download DwrAvatarBundle using composer
2. Enable the Bundle
3. Add locations where you would like to check current weather
4. Add routing to routing.yml in order to can open example in your browser

### Step 1: Download DwrAvatarBundle using composer

Add DwrGlobalWeatherBundle in your composer.json:

``` js
{
    "require": {
        "dwr/globalweather-bundle": "1.0"
    }
}
```

Download the bundle by running the command:

``` bash
$ php composer.phar update dwr/globalweather-bundle
```

Composer will install the bundle into your project's `vendor/dwr/globalweather-bundle` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
//app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Dwr\GlobalWeatherBundle\DwrGlobalWeatherBundle(),
    );
}
```

### Step 3: Add locations where you would like to check current weather

In order to add your own locations assign example code to **parameters** attribute in your **app/config/config.yml**.

**Example:**
``` yml
parameters:                             # You should have had 'parameters' attribute in your app/config/config.yml if not, feel free to add it.
    dwr_global_weather_locations:       # dwr_global_weather_location overwrites default location defined in bundle
        Poland: [Katowice, Krakow]      # add your location e.g Country: [City1, City2]
        Russian Federation: [Moscow]
        United States: [New York]
```
#### Find supported locations

For more locations you will need to check official Global Weather site where you can find supported location.

Global Weather Webservice: [Global Weather](http://www.webservicex.net/ws/WSDetails.aspx?CATID=12&WSID=56)

If you want get cities by country try this: [GetCitiesByCountry](http://www.webservicex.net/globalweather.asmx?op=GetCitiesByCountry)

Try to get Weather by city and country: [GetWeather](http://www.webservicex.net/globalweather.asmx?op=GetWeather)  

#### Hint

Default locations are defined in *vendor/dwr/globalweather-bundle/Dwr/GlobalWeatherBundle/Resources/config/services.yml*
and they look like that:

``` yml
dwr_global_weather_locations:
      Australia: [Sydney Airport]
      Germany: [Berlin]
      Japan: [Tokyo]
      Poland: [Katowice, Krakow, Warszawa-Okecie]
      Russian Federation: [Moscow]
      Spain: [Barcelona, Fuerteventura, Las Palmas De Gran Canaria / Gando]
      United States: [New York]
```

### Step 4: Add routing to routing.yml in order to can open example in your browser

``` yml
dwr_global_weather:
    resource: "@DwrGlobalWeatherBundle/Controller/"
    type:     annotation
    prefix:   /dwr_globalweather
```

**Congratulations!** You're ready to embed weather widget in your symfony2 application.
Example how this widget works you can find on: **yours-application-url/dwr_globalweather/globalweather**.

## **Usage**

### **Create weather widget on your website**

Add this in your controller

``` php

// ...

use Dwr\GlobalWeatherBundle\Entity\Location;
use Dwr\GlobalWeatherBundle\Form\Type\GlobalWeatherType;
use Symfony\Component\HttpFoundation\Request;

// ...

    public function indexAction(Request $request)
    {
        $weather  = null;
        $location = new Location();

        $form = $this->createForm(
            $this->get('dwr_global_weather_form_type'),
            $location
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $globalWeather = $this->get('dwr_global_weather');
            $weather = $globalWeather->getCurrentWeather($location);
        }

        return $this->render('DwrGlobalWeatherBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
            'weather' => $weather
        ));
    }

```

View (twig) (e.g *AppBundle:Default:index.html.twig*)


``` jinja
{{ form(form) }}
{% if weather %}
    <ul>
        <li>Location: {{ weather.Location|default('') }}</li>
        <li>Time: {{ weather.Time|default('') }}</li>
        <li>Wind: {{ weather.Wind|default('') }}</li>
        <li>Visibility: {{ weather.Visibility|default('') }}</li>
        <li>SkyConditions: {{ weather.SkyConditions|default('') }}</li>
        <li>Temperature: {{ weather.Temperature|default('') }}</li>
        <li>DewPoint: {{ weather.DewPoint|default('') }}</li>
        <li>RelativeHumidity: {{ weather.RelativeHumidity|default('') }}</li>
        <li>Pressure: {{ weather.Pressure|default('') }}</li>
        <li>Status: {{ weather.Status|default('') }}</li>
    </ul>
{% endif %}
```

If everything went good you should see form with drop-down list (contains cities) and submit button.
When you choose city and submit form, you should see something like that

![Widget example #1](Resources/doc/dwr_global_weather_result.jpg)
