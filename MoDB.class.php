<?php
/**
 * Created by PhpStorm.
 * User: Dengchengfu
 * Date: 17/2/17
 * Time: 下午3:53
 */
require_once 'DatabaseMongo.class.php';
class MoDB{
    public static $mongo;   //数据库对象
    public static function init($dbname){  //初始化方法
        self::$mongo = new DatabaseMongo($dbname);
    }
    public static function findAll($table,$where=array()){  //查找所有数据
        return self::$mongo->getAll($table,$where);
    }
    public static function findOne($table,$where=array()){   //查找单条数据
        return self::$mongo->getOne($table,$where);
    }
    public static function insert($table,$data){    //插入数据
        return self::$mongo->toInsert($table,$data);
    }
    public static function update($table,$where,$data,$opt){     //更新数据
        return self::$mongo->toUpdate($table,$where,$data,$opt);
    }
    public static function delete($table,$where=array()){       //删除数据
        return self::$mongo->toDelete($table,$where);
    }
    public static function execute($sql){       //执行mongoDB的sql语句
        return self::$mongo->toExcute($sql);
    }
}