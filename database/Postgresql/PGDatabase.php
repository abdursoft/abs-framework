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

namespace ABS\Framework\DB\Postgresql;

use PDO;

class PGDatabase extends Postgress {
    private $table, $select, $sql, $query, $all, $where, $order, $limit;

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
                    $this->table .= "`$key` AS `$val`, ";
                } else {
                    $this->table .= " `$val`, ";
                }
            }
        } else {
            $this->table = $table;
        }
        $this->table = trim( $this->table, ', ' );
        return $this;
    }

    /**
     * select content from table
     * @param select name of the data key for table|collection
     * will generate an error if table|key not exist
     */
    public function select( array | string | null $select = null ) {
        if ( is_array( $select ) ) {
            $sql = '';
            for ( $i = 0; $i < count( $select ); $i++ ) {
                $sql .= "`$select[$i]` ,";
            }
            $this->sql = trim( $sql, ',' );
        } elseif ( is_string( $select ) ) {
            $this->sql = "`$select` ";
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
        $this->query = "SELECT $this->sql FROM $this->table $this->where ORDER BY id ASC LIMIT 1";
        $stmt        = $this->buildQuery();
        if ( $stmt->rowCount() > 0 ) {
            return (object) $stmt->fetch( PDO::FETCH_ASSOC );
        } else {
            return false;
        }
    }

    /**
     * read last content of the table
     * @param null
     * will generate false if content not exist
     */
    public function last() {
        $this->query = "SELECT $this->sql FROM $this->table $this->where ORDER BY id DESC LIMIT 1";
        $stmt        = $this->buildQuery();
        if ( $stmt->rowCount() > 0 ) {
            return (object) $stmt->fetch( PDO::FETCH_ASSOC );
        } else {
            return false;
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
     * will generate an error if the condition was faild
     */
    public function where( array $data ) {
        if ( !empty( $data ) && is_array( $data ) ) {
            $this->where = " WHERE ";
            foreach ( $data as $key => $val ) {
                if ( !empty( $key ) && !is_int( $key ) ) {
                    if ( strtolower( $val ) == '!null' ) {
                        $this->where .= " $key != ' ' AND ";
                    } else {
                        $pos = strpos( $val, '!' );
                        if ( $pos === 0 ) {
                            $v = trim( $val, '!' );
                            $this->where .= " $key != '$v' AND ";
                        } else {
                            $this->where .= " $key = '$val' AND ";
                        }
                    }
                }
            }
            $this->where = trim( $this->where, "AND " );
        } else {
            $this->where = ' ';
        }
        return $this;
    }

    /**
     * set orWhere condition
     * @param data array of the dataset $key=>$value
     * will make a OR condition
     * will generate an error if the condition was faild
     */
    public function orWhere( array $data ) {
        if ( !empty( $data ) && is_array( $data ) ) {
            $this->where = " WHERE ";
            foreach ( $data as $key => $val ) {
                if ( !empty( $key ) && !is_int( $key ) ) {
                    if ( strtolower( $val ) == '!null' ) {
                        $this->where .= " $key != ' ' OR ";
                    } else {
                        $pos = strpos( $val, '!' );
                        if ( $pos === 0 ) {
                            $v = trim( $val, '!' );
                            $this->where .= " $key != '$v' OR ";
                        } else {
                            $this->where .= " $key = '$val' OR ";
                        }
                    }
                }
            }
            $this->where = trim( $this->where, "OR " );
        } else {
            $this->where = ' ';
        }
        return $this;
    }

    /**
     * set notWhere condition
     * @param data array of the dataset $key=>$value
     * will make a NOT condition
     * will generate an error if the condition was faild
     */
    public function notWhere( array $data ) {
        if ( !empty( $data ) && is_array( $data ) ) {
            $this->where = " WHERE ";
            foreach ( $data as $key => $val ) {
                if ( !empty( $key ) && !is_int( $key ) ) {
                    $this->where .= " NOT $key = '$val' ";
                }
            }
            $this->where = trim( $this->where, " NOT" );
        } else {
            $this->where = ' ';
        }
        return $this;
    }

    /**
     * set likdeWhere condition
     * @param data array of the dataset $key=>$value
     * will make a LIKE condition
     * will generate an error if the condition was faild
     */
    public function likeWhere( array $data ) {
        if ( !empty( $data ) && is_array( $data ) ) {
            $this->where = " WHERE ";
            foreach ( $data as $key => $val ) {
                if ( !empty( $key ) && !is_int( $key ) ) {
                    $this->where .= " $key  LIKE '%$val%' OR ";
                }
            }
            $this->where = trim( $this->where, "OR " );
        } else {
            $this->where = ' ';
        }
        return $this;
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
        $this->query = "SELECT SUM($key) AS $total FROM $this->table";
        $stmt        = $this->db->prepare( $this->query );
        $stmt->execute();
        $row = $stmt->fetch( PDO::FETCH_ASSOC );
        return $row[$total];
    }

    /**
     * maximum of a key|field
     * @param key name of the key of table|collection
     * @param total name of the total values
     */
    public function max( $key, $total ) {
        $this->query = "SELECT MAX($key) AS $total FROM $this->table";
        $stmt        = $this->db->prepare( $this->query );
        $stmt->execute();
        $row = $stmt->fetch( PDO::FETCH_ASSOC );
        return $row[$total];
    }

    /**
     * minimum of a key|field
     * @param key name of the key of table|collection
     * @param total name of the total values
     */
    public function min( $key, $total ) {
        $this->query = "SELECT MIN($key) AS $total FROM $this->table";
        $stmt        = $this->db->prepare( $this->query );
        $stmt->execute();
        $row = $stmt->fetch( PDO::FETCH_ASSOC );
        return $row[$total];
    }

    /**
     * avarage of a key|field
     * @param key name of the key of table|collection
     * @param total name of the total values
     */
    public function avg( $key, $total ) {
        $this->query = "SELECT AVG($key) AS $total FROM $this->table";
        $stmt        = $this->db->prepare( $this->query );
        $stmt->execute();
        $row = $stmt->fetch( PDO::FETCH_ASSOC );
        return $row[$total];
    }

    /**
     * count of a key|field
     * @param key name of the key of table|collection
     * @param total name of the total values
     */
    public function count( $key, $total ) {
        $this->query = "SELECT COUNT($key) AS $total FROM $this->table";
        $stmt        = $this->db->prepare( $this->query );
        $stmt->execute();
        $row = $stmt->fetch( PDO::FETCH_ASSOC );
        return $row[$total];
    }

    /**
     * select a according table
     * @param table name of the second table|collection
     * @param column name of the foregin key
     */
    public function according( $table, $column ) {
        $this->query = "SELECT $this->sql FROM $this->table $this->where";
        $stmt        = $this->buildQuery();
        if ( $stmt->rowCount() > 0 ) {
            $this->all = $stmt->fetchAll( PDO::FETCH_ASSOC );
        }
        if ( !empty( $this->all ) ) {
            $result = [];
            foreach ( $this->all as $item ) {
                $this->sql   = ' * ';
                $this->table = $table;
                $this->where( [$column => $item[$column]] );
                array_push( $result, $this->last() );
            }
            return (object) $result;
        } else {
            return false;
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
            $this->query = "INSERT INTO $this->table  SET $input";
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
        $this->query = "UPDATE $this->table  SET $input $this->where";
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
        $this->query = "DELETE FROM $this->table $this->where";
        $stmt        = $this->db->prepare( $this->query );
        return $stmt->execute();
    }

    /**
     * join inner tables
     * @param data name of the second table
     * @param foreignkey name of the key of primary table
     * @param primaryKey name of the second table key
     * will return an error if query was bad
     */
    public function joinInner( $table, $foreignKey, $primaryKey ) {
        $this->query = "SELECT $this->sql FROM $this->table
        INNER JOIN $table ON $table.$primaryKey = $this->table.$foreignKey";
        return $this->query();
    }

    /**
     * left join tables
     * @param data name of the second table
     * @param foreignkey name of the key of primary table
     * @param primaryKey name of the second table key
     * will return an error if query was bad
     */
    public function joinLeft( $table, $foreignKey, $primaryKey ) {
        $this->query = "SELECT $this->sql FROM $this->table
        LEFT JOIN $table ON $table.$primaryKey = $this->table.$foreignKey";
        return $this->query();
    }

    /**
     * right join tables
     * @param data name of the second table
     * @param foreignkey name of the key of primary table
     * @param primaryKey name of the second table key
     * will return an error if query was bad
     */
    public function joinRight( $table, $foreignKey, $primaryKey ) {
        $this->query = "SELECT $this->sql FROM $this->table
        RIGHT JOIN $table ON $table.$primaryKey = $this->table.$foreignKey";
        return $this->query();
    }

    /**
     * excecute the query
     * @param null
     * will return an error if query was bad
     */
    public function query() {
        $stmt = $this->buildQuery();
        if ( $stmt->rowCount() > 0 ) {
            $this->all = $stmt->fetchAll( PDO::FETCH_ASSOC );
            return (object) $this->all;
        } else {
            return false;
        }
    }

    /**
     * select all data without limit
     * @param null no data|parameter is required
     * will return an error if query was bad
     */
    public function all() {
        $this->query = "SELECT $this->sql FROM $this->table $this->where";
        $stmt        = $this->buildQuery();
        if ( $stmt->rowCount() > 0 ) {
            $this->all = $stmt->fetchAll( PDO::FETCH_ASSOC );
            return (object) $this->all;
        } else {
            return false;
        }
    }

    /**
     * fetch all data with limit
     * @param null no data|parameter is required
     * will return an error if query was bad
     */
    public function fetch() {
        $this->query = "SELECT $this->sql FROM $this->table $this->where $this->order $this->limit";
        $stmt        = $this->buildQuery();
        if ( $stmt->rowCount() > 0 ) {
            $this->all = $stmt->fetchAll( PDO::FETCH_ASSOC );
            return (object) $this->all;
        } else {
            return false;
        }
    }

    /**
     * select the last id
     * @param null
     * will return the last id of the table|collection
     */
    public function getLastID() {
        return $this->db->lastInsertId( $this->table );
    }

    /**
     * execute the db query
     * @param null
     * will return the result of the query
     */
    public function buildQuery() {
        try {
            $stmt = $this->db->prepare( $this->query );
            $stmt->execute();
            return $stmt;
        } catch ( \Throwable $th ) {
            return $th->getMessage();
        }
    }
}