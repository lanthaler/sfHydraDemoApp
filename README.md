The Hydra Issue Tracker Demo
============================

Welcome to the Hydra Issue Tracker demo - a fully-functional [Symfony2][1]
application leveraging [Hydra][2] that you can use as the skeleton for your
new applications.

This document contains information on how to download, install, and start
using Hydra with Symfony.


1) Installing the Hydra Issue Tracker Demo
------------------------------------------

The recommended way to install the Hydra Issue Tracker demo is to use
[Composer][3].

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Then, use the `create-project` command to generate a new Hydra application:

    php composer.phar create-project ml/hydra-demo-app path/to/install

Composer will install Symfony, the HydraBundle, and all the dependencies
under the `path/to/install` directory.

Finally you need to create the database (unless it exists already) using

    php app/console doctrine:database:create

and generate the tables used by the Hydra demo app

    php app/console doctrine:schema:create


2) Checking your System Configuration
-------------------------------------

Before starting coding, make sure that your local system is properly
configured for Symfony.

Execute the `check.php` script from the command line:

    php app/check.php

Access the `config.php` script from a browser:

    http://localhost/path/to/symfony/app/web/config.php

If you get any warnings or recommendations, fix them before moving on.


3) Browsing the Demo Application
--------------------------------

Congratulations! You're now ready to use the Hydra demo app.

From the `config.php` page, click the "Bypass configuration and go to the
Welcome page" link to load up the homepage providing more information about
the demo app.

You can also use a web-based configurator by clicking on the "Configure your
Symfony Application online" link of the `config.php` page.

To see Hydra in in action, access the following page:

    http://localhost/path/to/symfony/app/web/app_dev.php/

Please note that it will return JSON-LD so you might wanna access it using
cURL or the [Hydra Console][4].


4) Getting Started
------------------

This distribution is meant to be the starting point for your Hydra-powered
Web APIs, but it also contains some sample code that you can learn from
and play with.

If you are not familiar with Symfony yet, you may wanna get up to speed
with the [Quick Tour][5] that  will take you through all the basic features
of Symfony2. Once you're feeling good, you can move onto reading the
official [Symfony2 book][6].

A default bundle, `MLDemoBundle`, shows you Symfony2 and Hydra in action.
After playing with it, you can remove it by following these steps:

  * delete the `src/MLDemoBundle` directory;

  * remove the routing entries referencing DemoBundle in
    `app/config/routing.yml`;

  * remove the MLDemoBundle from the registered bundles in
    `app/AppKernel.php`;

  * remove the `web/bundles/mldemo` directory;

  * remove the `security.providers` and `security.firewalls.main` entries
    in the `security.yml` file or tweak the security configuration to fit
    your needs.


[1]:  http://symfony.com/
[2]:  http://www.markus-lanthaler.com/hydra/
[3]:  http://getcomposer.org/
[4]:  https://github.com/lanthaler/HydraConsole
[5]:  http://symfony.com/doc/2.1/quick_tour/the_big_picture.html
[6]:  http://symfony.com/doc/2.1/index.html
