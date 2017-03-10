<?php
/**
 * Created by PhpStorm.
 * User: Dengchengfu
 * Date: 17/2/19
 * Time: 上午11:28
 */
require_once 'MoDB.class.php';
$dbname = 'testDB';
MoDB::init($dbname);
$res = MoDB::findAll('mvc');
print_r($res);