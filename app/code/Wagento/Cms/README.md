Wagento Cms Module for MeetMagento
======================

This Module for Magento® 2 allows to pdf types files to upload in wysiwyg editor

Facts
-----
* version: 2.0.0

Description
-----------
10/01/18

* This module allow pdf types files to upload in wysiwyg editor

Requirements
------------
* PHP >= 5.6.5

Compatibility
-------------
* Magento >= 2.1.4

Installation Instructions
-------------------------
The Wagento Cms module for Magento® 2 is distributed in three formats:
* Drop-In
* [Composer VCS](https://getcomposer.org/doc/05-repositories.md#using-private-repositories)

### Install Source Files ###

The following sections describe how to install the module source files,
depending on the distribution format, to your Magento® 2 instance.


Then navigate to the project root directory and run the following commands:

    composer config repositories.meetmagento-module-cms vcs git@bitbucket.org:wagento-global/meetmagento-module-cms.git
    composer require wagento/module-cms:dev-master

#### VCS ####
If you prefer to install the module using [git](https://git-scm.com/), run the
following commands in your project root directory:

     composer config repositories.meetmagento-module-cms vcs git@bitbucket.org:wagento-global/meetmagento-module-cms.git
     composer require wagento/module-cms:dev-master

### Enable Module ###
Once the source files are available, make them known to the application:

    ./bin/magento module:enable Wagento_Cms
    ./bin/magento setup:upgrade

Last but not least, flush cache and compile.

    ./bin/magento cache:flush
    ./bin/magento setup:di:compile

Uninstallation
--------------

The following sections describe how to uninstall the module, depending on the
distribution format, from your Magento® 2 instance.

#### Composer Git ####

To unregister the shipping module from the application, run the following command:

    ./bin/magento module:uninstall --remove-data Wagento_Cms

This will automatically remove source files and clean up the database.

#### Drop-In ####

To uninstall the module manually, run the following commands in your project
root directory:

    ./bin/magento module:disable Wagento_cms
    rm -r app/code/Wagento/Cms

Developer
---------
* Rohit Dave | [Wagento](https://www.wagento.com/) | rohit@wagento.com

License
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)