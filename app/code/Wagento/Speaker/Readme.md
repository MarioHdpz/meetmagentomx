# Speaker Product Type Extention

Speaker Module Provide us to new **Speaker** Product type.

## Installation Via composer

To install this Speaker Module with composer you need access to the command line of your server and you need to have Composer.(https://getcomposer.org).

* cd <your magento path>
* composer config repositories.wagento-speaker git git@bitbucket.org:wagento-global/speaker.git
* composer require wagento/speaker:2.0.0
* Enable the extension: `php bin/magento --clear-static-content module:enable Wagento_Speaker`
* Clear cache
