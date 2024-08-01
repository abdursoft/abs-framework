<?php
/**
 * ABS PHP Framework
 *
 * @created      2023
 * @updated      2024-08-01
 * @version      1.0.6
 * @author       abdursoft <support@abdursoft.com>
 * @authorURI    https://abdursoft.com/author
 * @copyright    2024 abdursoft
 * @license      MIT
 *
 * @Written by Abdur Rahim
*/


use ABS\Framework\System\Route\App;

require 'vendor/autoload.php';
require 'core/Config/config.php';

// set 1 for showing errors 0 for no errors 
ini_set('display_errors',1);

new App();
?>