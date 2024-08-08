<?php
/**
 * ABS PHP Framework
 *
 * @created      2023
 * @updated      2024-08-08
 * @version      1.0.8
 * @author       abdursoft <support@abdursoft.com>
 * @authorURI    https://abdursoft.com/author
 * @copyright    2024 abdursoft
 * @license      MIT
 *
 * @Written by Abdur Rahim
 */

namespace ABS\Framework\DB\Mysql;

use ABS\Framework\DB\Mysql\MyDb;
use PDO;

class Database extends MyDb {
    protected $tables, $selects, $sql = '*', $query, $all, $where = [], $order, $limit,$wheres,$joinQuery=false;

    public function __construct() {
        parent::__construct();
    }

    /**
     * get table name
     * @param table name of the data table|collection
     * will generate an error if table not exist
     */
    public function table( array | string | null $table ) {
        if ( is_array( $table ) ) {
            foreach ( $table as $key => $val ) {
                if ( !empty( $key ) && !is_int( $key ) ) {
                    $this->tables .= "`$key` AS `$val`, ";
                } else {
                    $this->tables .= " `$val`, ";
                }
            }
        } else {
            $this->tables = $table;
        }
        $this->tables = trim( $this->tables, ', ' );
        return $this;
    }

    /**
     * select content from table
     * @param select name of the data key for table|collection
     * will generate an error if table|key not exist
     */
    public function select( array | string | null $selects = null ) {
        if ( is_array( $selects ) ) {
            $sql = '';
            for ( $i = 0; $i < count( $selects ); $i++ ) {
                $sql .= "`$selects[$i]` ,";
            }
            $this->sql = trim( $sql, ',' );
        } elseif ( is_string( $selects ) ) {
            $this->sql = "`$selects` ";
        } else {
            $this->sql = ' * ';
        }
        return $this;
    }

    /**
     * read first content of the table
     * @param null
     * will generate false if content not exist
     */
    public function first() {
        $wheres = $this->buildWhere();
        $this->query = "SELECT $this->sql FROM $this->tables $wheres ORDER BY id ASC LIMIT 1";
        $stmt        = $this->buildQuery();
        try {
            if ( $stmt->rowCount() > 0 ) {
                return (object) $stmt->fetch( PDO::FETCH_ASSOC );
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            $this->dbError($th,$stmt);
        }
    }

    /**
     * read last content of the table
     * @param null
     * will generate false if content not exist
     */
    public function last() {
        $wheres = $this->buildWhere();
        $this->query = "SELECT $this->sql FROM $this->tables $wheres ORDER BY id DESC LIMIT 1";
        $stmt        = $this->buildQuery();
        try {
            if ( $stmt->rowCount() > 0 ) {
                return (object) $stmt->fetch( PDO::FETCH_ASSOC );
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            $this->dbError($th,$stmt);
        }
    }

    /**
     * get distinct data from tables
     * @param column name of the data key of table|collection
     * will generate an error if table|key not exist
     */
    public function distinct( string $column = null ) {
        if ( $column == null ) {
            $this->sql .= ' DISTINCT ';
        } else {
            $this->sql .= " DISTINCT (`$column`) ";
        }
        return $this;
    }

    /**
     * set where condition
     * @param data array of the dataset $key=>$value
     * will make a AND condition
     * will generate an error if the condition was failed
     */
    public function where( $column, $operator, $value ) {
        $this->wheres[] = [
            'type' => 'AND',
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];
        return $this;
    }

    /**
     * set orWhere condition
     * @param data array of the dataset $key=>$value
     * will make a OR condition
     * will generate an error if the condition was failed
     */
    public function orWhere( $column, $operator, $value ) {
        $this->wheres[] = [
            'type' => 'OR',
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];
        return $this;
    }

    public function buildWhere(){
        if(!empty($this->wheres)){
            $query = ' WHERE ';
            foreach($this->wheres as $index=> $where){
                if($index > 0){
                    $query .= $where['type']." ";
                }
                $query .= $where['column']. ' ';
                $query .= $where['operator']. ' ';
                $query .= ' ? ';
            }
            return $query;
        }
    }

    /**
     * set between condition with two data
     * @param key name of the key of table|collection
     * @param to start|first|small value
     * @param from end|last|larger value
     */
    public function betWeen( $key, $to, $from ) {
        $this->where = " WHERE $key BETWEEN $to AND $from";
        return $this;
    }

    /**
     * set the  queue order
     * @param key name of the key of table|collection
     * @param mode order mode ASC|DESC
     */
    public function orderBy( $key, $mode ) {
        $this->order = " ORDER BY $key $mode";
        return $this;
    }

    /**
     * limit for the query data
     * @param number initial number|end limit
     * @param end number of the limit ended
     */
    public function limit( $number, $end = null ) {
        if ( $end != null ) {
            $this->limit = " LIMIT $number,$end";
        } else {
            $this->limit = " LIMIT $number";
        }
        return $this;
    }

    /**
     * summation of a key|field
     * @param key name of the key of table|collection
     * @param total name of the total values
     */
    public function sum( $key, $total ) {
        $wheres = $this->buildWhere();
        $this->query = "SELECT SUM($key) AS $total FROM $this->tables $wheres";
        $stmt = $this->buildQuery();
        try {
            if ( $stmt->rowCount() > 0 ) {
                return $stmt->fetchAll( PDO::FETCH_OBJ );
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            $this->dbError($th,$stmt);
        }
    }

    /**
     * maximum of a key|field
     * @param key name of the key of table|collection
     * @param total name of the total values
     */
    public function max( $key, $total ) {
        $wheres = $this->buildWhere();
        $this->query = "SELECT MAX($key) AS $total FROM $this->tables $wheres";
        $stmt = $this->buildQuery();
        try {
            if ( $stmt->rowCount() > 0 ) {
                return $stmt->fetchAll( PDO::FETCH_OBJ );
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            $this->dbError($th,$stmt);
        }
    }

    /**
     * minimum of a key|field
     * @param key name of the key of table|collection
     * @param total name of the total values
     */
    public function min( $key, $total ) {
        $wheres = $this->buildWhere();
        $this->query = "SELECT MIN($key) AS $total FROM $this->tables $wheres";
        $stmt = $this->buildQuery();
        try {
            if ( $stmt->rowCount() > 0 ) {
                return $stmt->fetchAll( PDO::FETCH_OBJ );
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            $this->dbError($th,$stmt);
        }
    }

    /**
     * average of a key|field
     * @param key name of the key of table|collection
     * @param total name of the total values
     */
    public function avg( $key, $total ) {
        $wheres = $this->buildWhere();
        $this->query = "SELECT AVG($key) AS $total FROM $this->tables $wheres";
        $stmt = $this->buildQuery();
        try {
            if ( $stmt->rowCount() > 0 ) {
                return $stmt->fetchAll( PDO::FETCH_OBJ );
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            $this->dbError($th,$stmt);
        }
    }

    /**
     * count of a key|field
     * @param key name of the key of table|collection
     * @param total name of the total values
     */
    public function count( $key, $total ) {
        $wheres = $this->buildWhere();
        $this->query = "SELECT COUNT($key) AS $total FROM $this->tables $wheres";
        $stmt = $this->buildQuery();
        try {
            if ( $stmt->rowCount() > 0 ) {
                return $stmt->fetchAll( PDO::FETCH_OBJ );
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            $this->dbError($th,$stmt);
        }
    }

    /**
     * create new record
     * @param data a set of array data
     * will return an error if query was bad
     */
    public function create( array $data = null ) {
        if ( !empty( $data ) ) {
            $input = NULL;
            foreach ( $data as $k => $v ) {
                $input .= "$k=:$k,";
            }
            $input       = rtrim( $input, ',' );
            $this->query = "INSERT INTO $this->tables  SET $input";
            $stmt        = $this->db->prepare( $this->query );
            foreach ( $data as $k => &$v ) {
                $stmt->bindValue( ":$k", $v, PDO::PARAM_STR );
            }
            return $stmt->execute();
        }
    }

    /**
     * update record
     * @param data a set of array data
     * will return an error if query was bad
     */
    public function update( array $data ) {
        $input = NULL;
        foreach ( $data as $k => $v ) {
            $input .= "$k=:$k,";
        }
        $input       = rtrim( $input, ',' );
        $this->query = "UPDATE $this->tables  SET $input $this->where";
        $stmt        = $this->db->prepare( $this->query );
        foreach ( $data as $k => &$v ) {
            $stmt->bindValue( ":$k", $v, PDO::PARAM_STR );
        }
        return $stmt->execute();
    }

    /**
     * delete record
     * @param null
     * will return an error if query was bad
     */
    public function delete() {
        $this->query = "DELETE FROM $this->tables $this->where";
        $stmt        = $this->db->prepare( $this->query );
        return $stmt->execute();
    }

    /**
     * join inner tables
     * @param data name of the second table
     * will return select SQl
     */
    public function buildJoin( ) {
        if(!$this->joinQuery){
            $this->joinQuery = true;
            $this->query = "SELECT $this->sql FROM $this->tables ";
        }
    }

    /**
     * join inner tables
     * @param data name of the second table
     * @param foreignKey name of the key of primary table
     * @param primaryKey name of the second table key
     * will return an error if query was bad
     */
    public function join( $table, $primaryKey, $operator, $foreignKey ) {
        $this->buildJoin();
        $this->query .= " INNER JOIN $table ON $primaryKey $operator $foreignKey";
        return $this;
    }

    /**
     * left join tables
     * @param data name of the second table
     * @param foreignKey name of the key of primary table
     * @param primaryKey name of the second table key
     * will return an error if query was bad
     */
    public function leftJoin( $table,$primaryKey,$operator, $foreignKey ) {
        $this->buildJoin();
        $wheres = $this->buildWhere();
        $this->query .= " LEFT JOIN $table ON $primaryKey $operator $foreignKey $wheres";
        return $this;
    }

    /**
     * right join tables
     * @param data name of the second table
     * @param foreignKey name of the key of primary table
     * @param primaryKey name of the second table key
     * will return an error if query was bad
     */
    public function rightJoin( $table, $primaryKey, $operator, $foreignKey ) {
        $this->buildJoin();
        $wheres = $this->buildWhere();
        $this->query .= " RIGHT JOIN $table ON $primaryKey $operator $foreignKey $wheres";
        return $this;
    }

    /**
     * cross join tables
     * @param data name of the second table
     * @param foreignKey name of the key of primary table
     * @param primaryKey name of the second table key
     * will return an error if query was bad
     */
    public function crossJoin( $table, $primaryKey, $operator, $foreignKey ) {
        $this->buildJoin();
        $wheres = $this->buildWhere();
        $this->query .= " CROSS JOIN $table ON $primaryKey $operator $foreignKey $wheres";
        return $this;
    }
    
    /**
     * execute the query
     * @param null
     * will return an error if query was bad
     */
    public function get() {
        if(!$this->query){
            $wheres = $this->buildWhere();
            $this->query = "SELECT $this->sql FROM $this->tables $wheres";
        }
        $stmt = $this->buildQuery();
        try {
            if ( $stmt->rowCount() > 0 ) {
                return $stmt->fetchAll( PDO::FETCH_OBJ );
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            $this->dbError($th,$stmt);
        }
    }

    /**
     * execute the query
     * @param null
     * will return an error if query was bad
     */
    public function find(int $id,$column='id') {
        $this->query = "SELECT  * FROM $this->tables WHERE $column='$id'";
        $stmt = $this->buildQuery();
        try {
            if ( $stmt->rowCount() > 0 ) {
                return $stmt->fetch( PDO::FETCH_OBJ );
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            $this->dbError($th,$stmt);
        }
    }

    /**
     * select all data without limit
     * @param null no data|parameter is required
     * will return an error if query was bad
     */
    public function all() {
        $this->query = "SELECT $this->sql FROM $this->tables $this->where";
        $stmt = $this->buildQuery();
        try {
            if ( $stmt->rowCount() > 0 ) {
                return $stmt->fetchAll( PDO::FETCH_OBJ );
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            $this->dbError($th,$stmt);
        }
    }

    /**
     * fetch all data with limit
     * @param null no data|parameter is required
     * will return an error if query was bad
     */
    public function fetch() {
        $this->query = "SELECT $this->sql FROM $this->tables $this->where $this->order $this->limit";
        $stmt = $this->db->prepare( $this->query );
        try {
            if(!empty($this->wheres)){
                $bindValues = array_column($this->wheres,'value');
                $stmt->execute($bindValues);
            }else{
                $stmt->execute();
            }
            return $stmt;
        } catch ( \Throwable $th ) {
            $this->dbError($th,$stmt);
        }
    }

    /**
     * select the last id
     * @param null
     * will return the last id of the table|collection
     */
    public function getLastID() {
        return $this->db->lastInsertId( $this->tables );
    }

    /**
     * execute the db query
     * @param null
     * will return the result of the query
     */
    public function buildQuery() {
        $stmt = $this->db->prepare( $this->query );
        try {
            if(!empty($this->wheres)){
                $bindValues = array_column($this->wheres,'value');
                $stmt->execute($bindValues);
            }else{
                $stmt->execute();
            }
            return $stmt;
        } catch ( \Throwable $th ) {
            $this->dbError($th,$stmt);
        }
    }

    private function dbError($th,$stmt){
        if(is_bool($stmt) | is_object($stmt) | is_array($stmt)){
            $tr = '';
        }else{
            $tr = '<h3>'.$stmt.'</h3>';
        }
        echo '<!DOCTYPE html><html lang="en"><head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>DB Query Build Error</title> <style> body{ width: 100vw; height: 100vh; background: #000; display: flex; align-items: start; justify-content: center; overflow: hidden;flex-direction:column; } h3{ font-size: 1.9em; font-weight: 500; color: #fff;background:#333; padding:20px 16px; border-radius:10px;margin:20px 0px; } </style></head><body> <h3>'.$th->getMessage().'</h3>'.$tr.'</body></html>';
        die;
    }
}