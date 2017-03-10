<?php  
// $user = array(
//                 'first_name' => 'MongoDB',
//                 'last_name' => 'Fan',
//                 'tags' => array('developer','user')
//              );
// // Configuration
// $dbhost = '127.0.0.1:12345';
// $dbname = 'testDB';
// // Connect to test database
// $m = new MongoClient("mongodb://$dbhost");
// $db = $m->$dbname;  	//数据库对象
//$collection='imooc';
//$res = $db->$collection->update(array('z'=>30),array('$set'=>array('z'=>111)),array('upsert'=>0,'multiple'=>1));
//

 // Get the users collection
// $users = $db->users;

// //Insert this new document into the users collection  
// $res = $users->save($user);  
// var_dump($res);  
// $data = $users->findOne();  
// var_dump($data);  


// // $collection = $db->createCollection("php_mongodb");
// // echo "集合创建成功";


// // 插入文档
//  $collection = $db->php_mongodb;	//集合对象
// // $document =array(
// 	"title"=>"mongodb",
// 	"description"=>"database",
// 	"likes"=>100,
// 	"url"=>"ww.baid.com"
// 	);
// $collection->insert($document);

// $cursor = $collection->find();
// // 迭代显示文档标题as
// foreach ($cursor as $document) {
// 	echo $document["title"] . "\n";
// 	echo $document["description"] . "\n";
// 	echo $document["likes"] . "\n";
// 	echo $document["url"] . "\n";
// }
//require_once('DatabaseMongo.class.php');

echo;
//
//

require_once 'MoDB.class.php';
$dbname = 'testDB';
MoDB::init($dbname);
$opt=array('upsert'=>0,'multiple'=>0);
//$res = MoDB::update('imooc',$where,$data,$opt);
//$res = MoDB::delete('imooc',$where);
$userName = $_REQUEST['username'];
$passWord = $_REQUEST['password'];
$data = array(
    "userName" => $userName,
    "passWord" => $passWord
);
$res = MoDB::insert('mvc',$data);
print_r($res);