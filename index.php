<?php
/**
 * ABS MVC Framework
 *
 * @created      2023
 * @version      1.0.1
 * @author       abdursoft <support@abdursoft.com>
 * @copyright    2024 abdursoft
 * @license      MIT
 *
 * @noinspection PhpComposerExtensionStubsInspection
*/

use System\Route\App;

require 'vendor/autoload.php';
require 'core/Config/config.php';

// set 1 for showing errors 0 for no errors 
ini_set('display_errors',1);

new App();
?>