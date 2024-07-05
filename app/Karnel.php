<?php
/**
 * ABS PHP Framework
 *
 * @created      2023
 * @updated      2024-06-20
 * @version      1.0.5
 * @author       abdursoft <support@abdursoft.com>
 * @authorURI    https://abdursoft.com/author
 * @copyright    2024 abdursoft
 * @license      MIT
 *
 * @Written by Abdur Rahim
 */

namespace ABS\Framework\App;

class Karnel {

    public static function csrf() {
        return [
            'csrf'    => false,
            'encrypt' => true,
        ];
    }

    public static function layout() {
        return [
            'minify' => false,
            'mime'   => ['php', 'html', 'htm', 'blade.php', 'abs'],
        ];
    }
}