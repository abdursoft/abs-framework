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

namespace ABS\Framework\DB\Mongodb;

use ABS\Framework\DB\Mongodb\Mongo;

class MNDatabase extends Mongo {
    private $table, $select, $sql, $query, $all, $where, $order, $limit;

    public function __construct() {
        parent::__construct();
    }

    /**
     * get table name
     * @param table name of the data table|collection
     * will generate an error if table not exist
     */
    public function table( string $table ) {
        if ( !empty( $table ) && $table != null ) {
            $this->table = $table;
        }
        return $this;
    }

    /**
     * select content from table
     * @param select name of the data key for table|collection
     * will generate an error if table|key not exist
     */
    public function select( array $select = null ) {
        if ( is_array( $select ) ) {
            $this->sql = $select;
        }
        return $this;
    }

    /**
     * read first content of the table
     * @param null
     * will generate false if content not exist
     */
    public function first() {
        $table  = $this->table;
        try {
            return $this->db->$table->findOne( $this->where, [
                'sort' => [
                    '_id' => 1,
                ],
            ] );
        } catch (\Throwable $th) {
            $this->dbError($th);
        }
    }

    /**
     * read last content of the table
     * @param null
     * will generate false if content not exist
     */
    public function last() {
        $table  = $this->table;
        try {
            return $this->db->$table->findOne( $this->where, [
                'sort' => [
                    '_id' => -1,
                ],
            ] );
        } catch (\Throwable $th) {
            $this->dbError($th);
        }
    }

    /**
     * set where condition
     * @param data array of the dataset $key=>$value
     * will make a AND condition
     * will generate an error if the condition was failed
     */
    public function where( string|array $data ) {
        if ( !empty( $data ) && is_array( $data ) ) {
            $this->where = $data;
        } else {
            $this->where = [];
        }
        return $this;
    }

    /**
     * get distinct data from tables
     * @param column name of the data key of table|collection
     * will generate an error if table|key not exist
     */
    public function distinct( string $column = null ) {
        $table = $this->table;
        try {
            return $this->db->$table->distinct( $column, $this->where );
        } catch (\Throwable $th) {
            $this->dbError($th);
        }
    }

    /**
     * set the  queue order
     * @param key name of the key of table|collection
     * @param mode order mode ASC|DESC
     */
    public function orderBy( $key, $mood = 1 ) {
        $this->order = [
            'sort' => [
                $key => $mood,
            ],
        ];
        return $this;
    }

    /**
     * limit for the query data
     * @param number initial number|end limit
     * @param end number of the limit ended
     */
    public function limit( $number, $end = null ) {
        if ( $end != null ) {
            $this->order = array_merge( $this->order, [
                'limit' => $end,
                'skip'  => $number,
            ] );
        } else {
            $this->order = array_merge( $this->order, [
                'limit' => $number,
            ] );
        }
        return $this;
    }

    /**
     * summation of a key|field
     * @param key name of the key of table|collection
     * @param total name of the total values
     */
    public function sum( $key, $total ) {
        $table = $this->table;
        try {
            return $this->db->$table->aggregate( [
                [
                    '$match' => $this->where,
                ],
                [
                    '$group' => [
                        '_id'  => null,
                        $total => [
                            '$sum' => "$$key",
                        ],
                    ],
                ],
            ] );
        } catch (\Throwable $th) {
            $this->dbError($th);
        }
    }

    /**
     * maximum of a key|field
     * @param key name of the key of table|collection
     * @param total name of the total values
     */
    public function max( $key, $total ) {
        $table = $this->table;
        try {
            return $this->db->$table->aggregate( [
                [
                    '$match' => $this->where,
                ],
                [
                    '$group' => [
                        '_id'  => null,
                        $total => [
                            '$max' => "$$key",
                        ],
                    ],
                ],
            ] );
        } catch (\Throwable $th) {
            $this->dbError($th);
        }
    }

    /**
     * minimum of a key|field
     * @param key name of the key of table|collection
     * @param total name of the total values
     */
    public function min( $key, $total ) {
        $table = $this->table;
        try {
            return $this->db->$table->aggregate( [
                [
                    '$match' => $this->where,
                ],
                [
                    '$group' => [
                        '_id'  => null,
                        $total => [
                            '$min' => "$$key",
                        ],
                    ],
                ],
            ] );
        } catch (\Throwable $th) {
            $this->dbError($th);
        }
    }

    /**
     * average of a key|field
     * @param key name of the key of table|collection
     * @param total name of the total values
     */
    public function avg( $key, $total ) {
        $table = $this->table;
        try {
            return $this->db->$table->aggregate( [
                [
                    '$match' => $this->where,
                ],
                [
                    '$group' => [
                        '_id'  => null,
                        $total => [
                            '$avg' => "$$key",
                        ],
                    ],
                ],
            ] );
        } catch (\Throwable $th) {
            $this->dbError($th);
        }
    }

    /**
     * count of a key|field
     * @param key name of the key of table|collection
     * @param total name of the total values
     */
    public function count() {
        $table = $this->table;
        try {
            $rows  = $this->db->$table->count( $this->where );
            return $rows;
        } catch (\Throwable $th) {
            $this->dbError($th);
        }
    }

    /**
     * fetch all data with limit
     * @param null no data|parameter is required
     * will return an error if query was bad
     */
    public function fetch() {
        $table = $this->table;
        try {
            if ( !empty( $this->order ) ) {
                $rows = $this->db->$table->find( $this->where, $this->order );
            } else {
                $rows = $this->db->$table->find( $this->where );
            }
            return $rows;
        } catch (\Throwable $th) {
            $this->dbError($th);
        }
    }

    /**
     * fetch all data with limit
     * @param null no data|parameter is required
     * will return an error if query was bad
     */
    public function get() {
        $table = $this->table;
        try {
            if ( !empty( $this->order ) ) {
                $rows = $this->db->$table->find( $this->where, $this->order );
            } else {
                $rows = $this->db->$table->find( $this->where );
            }
            return $rows;
        } catch (\Throwable $th) {
            $this->dbError($th);
        }
    }

    public function find($id,$column='_id') {
        $table  = $this->table;
        try {
            $result = $this->db->$table->findOne([
                $column => $id,
            ] );
            return ( $result );
        } catch (\Throwable $th) {
            $this->dbError($th);
        }
    }

    /**
     * select a according table
     * @param table name of the second table|collection
     * @param column name of the foreign key
     */
    public function according( $table, $primary_Key, $secondary_key, $lookup_as, $condition ) {
        $table = $this->table;
        return $this->db->$table->aggregate( [
            $condition,
            [
                '$lookup' => [
                    'from'         => $table,
                    'localField'   => $secondary_key,
                    'foreignField' => $primary_Key,
                    'as'           => $lookup_as,
                ],
            ],
            [
                '$unwind' => "$$lookup_as",
            ],
        ] );
    }

    /**
     * create new record
     * @param data a set of array data
     * will return an error if query was bad
     */
    public function create( array $data = null ) {
        if ( !empty( $data ) ) {
            $table           = $this->table;
            $insertOneResult = $this->db->$table->insertOne( $data );
            return ( $insertOneResult->getInsertedId() );
        }
    }

    /**
     * update record
     * @param data a set of array data
     * will return an error if query was bad
     */
    public function update( array $data, $mood = 'single' ) {
        $table = $this->table;
        if ( $mood == 'single' ) {
            $mn = "findOneAndUpdate";
        } else {
            $mn = "updateMany";
        }
        return $this->db->$table->$mn( $this->where, [
            '$set' => $data,
        ] );
    }

    /**
     * delete record
     * @param null
     * will return an error if query was bad
     */
    public function delete( $mood = "single" ) {
        $table = $this->table;
        if ( $mood == 'single' ) {
            $mn = "findOneAndDelete";
        } else {
            $mn = "deleteMany";
        }
        return $this->db->$table->$mn( $this->where );
    }

    /**
     * select the last id
     * @param null
     * will return the last id of the table|collection
     */
    public function getLastID() {
        $table = $this->table;
        if ( !empty( $this->order ) ) {
            $rows = $this->db->$table->find( $this->where, $this->order );
        } else {
            $rows = $this->db->$table->find( $this->where );
        }
        return $rows;
    }

    private function dbError($th){
        echo '<!DOCTYPE html><html lang="en"><head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>DB Query Build Error</title> <style> body{ width: 100vw; height: 100vh; background: #000; display: flex; align-items: start; justify-content: center; overflow: hidden;flex-direction:column; } h3{ font-size: 1.9em; font-weight: 500; color: #fff;background:#333; padding:20px 16px; border-radius:10px;margin:20px 0px; } </style></head><body> <h3>'.$th->getMessage().'</h3></body></html>';
        die;
    }
}