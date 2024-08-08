<?php
/**
 * ABS PHP Framework
 *
 * @created      2023
 * @updated      2024-08-04
 * @version      1.0.7
 * @author       abdursoft <support@abdursoft.com>
 * @authorURI    https://abdursoft.com/author
 * @copyright    2024 abdursoft
 * @license      MIT
 *
 * @Written by Abdur Rahim
*/

namespace ABS\Framework\App\Controller;

use ABS\Framework\App\Model\Items;
use ABS\Framework\DB\DB;
use ABS\Framework\System\Processor\Controller;

use function ABS\Framework\System\Helper\response;
use function ABS\Framework\System\Helper\view;
use function ABS\Framework\System\Helper\with;

class App extends Controller{

    public function __construct()
    {
        parent::__construct();    
    }

    public function index(){
        $model = Items::where('item_id','=',42)->get();
        $item = (new DB())->db->table('items')->where('item_id', '=',38)->get();
        with('errors','Hello Errors');
        return view('register');
    }

    public function join(){
        $model = Items::where('item_id','=',42)->leftJoin('item_category','item_category.item_category_id','=','items.item_category_id')->get();
        response($model,200);
    }
}