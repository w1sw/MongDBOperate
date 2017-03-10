<?php
/**
 * PHP操作mongodb数据库操作类
 */
class DatabaseMongo {
    public static $database = '';
    public static $mo;

    /**
     * 构造方法
     */
    public function __construct($dbname) {
        // $server = 127.0.0.1;
        // $user = DBUSER;  暂时不知道账号密码
        // $password = DBPASS;
        // $port = 12345;
        // $database = testDB;
        $dbhost = '127.0.0.1:12345';
//        $dbname = 'testDB';
        $m = new MongoClient("mongodb://$dbhost");
        // $mongo = $this->getInstance($server, $user, $password, $port);
        $mongo = $m->$dbname;      //数据库对象
        self::$database = $mongo;

    }

    /**
     * 数据库单例方法
     * @param $server
     * @param $user
     * @param $password
     * @param $port
     * @return Mongo
     */
    public function getInstance($server, $user, $password, $port) {
        if (isset($this->mo)) {
            return $this->mo;
        } else {

            if (!empty($server)) {
                if (!empty($port)) {

                    if (!empty($user) && !empty($password)) {
                        $this->mo = new Mongo("mongodb://{$user}:{$password}@{$server}:{$port}");
                    } else {
                        $this->mo = new Mongo("mongodb://{$server}:{$port}");
                    }
                } else {
                    $this->mo = new Mongo("mongodb://{$server}");
                }
            } else {
                $this->mo = new Mongo();
            }
            return $this->mo;
        }
    }

    /**
     * 查询表中所有数据
     * @param $table
     * @param array $where
     * @param array $sort
     * @param string $limit
     * @param string $skip
     * @return array|int
     */
    public static function getAll($table, $where = array(), $sort = array(), $limit = '', $skip = '') {
        if (!empty($where)) {
            $data = self::$database->$table->find($where);
        } else {
            $data = self::$database->$table->find();
        }

        if (!empty($sort)) {
            $data = $data->sort($sort);
        }

        if (!empty($limit)) {
            $data = $data->limit($limit);
        }

        if (!empty($skip)) {
            $data = $data->skip($skip);
        }

        $newData = array();
        while ($data->hasNext()) {
            $newData[] = $data->getNext();
        }
        if (count($newData) == 0) {
            return 0;
        }
        return $newData;
    }

    /**
     * 查询指定一条数据
     * @param $table
     * @param array $where
     * @return int
     */
    public static function getOne($table, $where = array()) {
        if (!empty($where)) {
            $data = self::$database->$table->findOne($where);
        } else {
            $data = self::$database->$table->findOne();
        }
        return $data;
    }

    /**
     * 统计个数
     * @param $table
     * @param array $where
     * @return mixed
     */
    public static function getCount($table, $where = array()) {
        if (!empty($where)) {
            $data = self::$database->$table->find($where)->count();
        } else {
            $data = self::$database->$table->find()->count();
        }
        return $data;
    }

    /**
     * 直接执行mongo命令
     * @param $sql
     * @return array
     */
    public static function toExcute($sql) {
        $result = self::$database->execute($sql);
        return $result;
    }

    /**
     * 分组统计个数
     * @param $table
     * @param $where
     * @param $field
     */
    public static function groupCount($table, $where, $field) {
        $cond = array(
            array(
                '$match' => $where,
            ),
            array(
                '$group' => array(
                    '_id' => '$' . $field,
                    'count' => array('$sum' => 1),
                ),
            ),
            array(
                '$sort' => array("count" => -1),
            ),
        );
        self::$database->$table->aggregate($cond);
    }

    /**
     * 删除数据
     * @param $table
     * @param $where
     * @return array|bool
     */
    public static function toDelete($table, $where) {
        $re = self::$database->$table->remove($where);
        return $re;
    }

    /**
     * 插入数据
     * @param $table
     * @param $data
     * @return array|bool
     */
    public static function toInsert($table, $data) {
        $re = self::$database->$table->insert($data);
        return $re;
    }

    /**
     * 更新数据
     * @param $table
     * @param $where
     * @param $data
     * @return bool
     */
    public static function toUpdate($table, $where, $data , $opt=array()) {
        $re = self::$database->$table->update($where, array('$set' => $data),$opt);
        return $re;
    }

    /**
     * 获取唯一数据
     * @param $table
     * @param $key
     * @return array
     */
    public static function distinctData($table, $key, $query = array()) {
        if (!empty($query)) {
            $where = array('distinct' => $table, 'key' => $key, 'query' => $query);
        } else {
            $where = array('distinct' => $table, 'key' => $key);
        }

        $data = self::$database->command($where);
        return $data['values'];
    }
}

