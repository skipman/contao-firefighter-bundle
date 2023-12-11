:: Run easy-coding-standard (ecs) via this batch file inside your IDE e.g. PhpStorm (Windows only)
:: Install inside PhpStorm the  "Batch Script Support" plugin
cd..
cd..
cd..
cd..
cd..
cd..
php vendor\bin\ecs check vendor/skipman/contao-firefighter-bundle/src --fix --config vendor/skipman/contao-firefighter-bundle/tools/ecs/config.php
php vendor\bin\ecs check vendor/skipman/contao-firefighter-bundle/contao --fix --config vendor/skipman/contao-firefighter-bundle/tools/ecs/config.php
php vendor\bin\ecs check vendor/skipman/contao-firefighter-bundle/config --fix --config vendor/skipman/contao-firefighter-bundle/tools/ecs/config.php
php vendor\bin\ecs check vendor/skipman/contao-firefighter-bundle/templates --fix --config vendor/skipman/contao-firefighter-bundle/tools/ecs/config.php
php vendor\bin\ecs check vendor/skipman/contao-firefighter-bundle/tests --fix --config vendor/skipman/contao-firefighter-bundle/tools/ecs/config.php
