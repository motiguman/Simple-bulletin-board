<?php header("Content-type: text/html; charset=Shift-JIS");?>
<!DOCTYPE html>  
 <html lang="ja"> 
<meta charset="utf-8"> 
 <head>
      <title>mission_4-1.php</title>  
 </head>
 <body>

<?php

	$dsn = 'mysql:dbname=データベース名;host=localhost';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
	
$name = ($_POST['name']); 

    $comment = ($_POST['comment']); 

    $postedAt = date('Y/m/d,H:i:s'); 


    $pass = ($_POST['pass']);


    $edit = ($_POST['edit']);

    $num = ($_POST['bango']);

    $password2 = ($_POST['password2']);

    $password3 = ($_POST['password3']);



$sql="CREATE TABLE IF NOT EXISTS tbtest5"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."postedAt DATETIME,"
."pass TEXT"
.");";

$stmt=$pdo->query($sql);



if(!empty($_POST['comment']) &&! empty($_POST['name']) && empty($_POST['bango'])){
if(!empty($_POST['pass'])){
$sql = $pdo->prepare("INSERT INTO tbtest5(id,name,comment,postedAt,pass) VALUES (id,:name,:comment,:postedAt,:pass)");

$sql->bindParam(':name',$name,PDO::PARAM_STR);
$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
$sql->bindParam(':postedAt',$postedAt,PDO::PARAM_STR);
$sql->bindParam(':pass',$pass,PDO::PARAM_STR);

    $name = ($_POST['name']); 

    $comment = ($_POST['comment']); 

    $postedAt = date('Y/m/d,H:i:s'); 


    $pass = ($_POST['pass']);


    $edit = ($_POST['edit']);

    $num = ($_POST['bango']);

    $password2 = ($_POST['password2']);

    $password3 = ($_POST['password3']);


$sql->execute();
}else{
echo "パスワードを入力してください。";
}}


//削除入力されたら

 if(isset($_POST['delno'])){ 

$idx=$_POST["delno"];
//pass呼び込み
$sql='SELECT*FROM tbtest5';
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){
if($idx == $row['id']){

if($row['pass']==$password2){
$sql="delete from tbtest5 where id='$idx'";
$stmt= $pdo->prepare($sql);
$stmt->bindParam('id',$id,PDO::PARAM_INT);
$stmt->execute();
}else{
echo"パスワードが違います。";
}}}}



//編集判別機能
if (!empty($edit)) {
$idx=$_POST["edit"];
//pass呼び込み
$sql='SELECT * FROM tbtest5';
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){

	if($edit == $row['id'] && $row['pass'] == $password3){//パスワードと一致
		$editnum = $row['id'];
		$editname = $row['name'];
		$editcomment = $row['comment'];
	
	}elseif ($edit == $row['id'] && $row['pass'] != $password3){
echo"パスワードが違います。";
    }
}}


//編集実行
	if(!empty($_POST['comment']) &&! empty($_POST['name']) &&! empty($_POST['bango'])){

    $id=($_POST["bango"]);

    $name = ($_POST['name']); 

    $comment = ($_POST['comment']); 

    $postedAt = date('Y/m/d,H:i:s'); 

$sql='update tbtest5 set name=:name,comment=:comment,postedAt=:postedAt where id=:id';
$stmt=$pdo->prepare($sql);

$stmt->bindParam(':name',$name,PDO::PARAM_STR);
$stmt->bindParam(':comment',$comment,PDO::PARAM_STR);
$stmt->bindParam(':postedAt',$postedAt,PDO::PARAM_STR);
$stmt->bindParam(':id',$id,PDO::PARAM_INT);

$stmt->execute();
}
?>
     <form action="mission_4-1.php" method="POST">  
       <input type="text" name="name" placeholder="名前" value="<?php echo $editname;?>"></br> 
       <input type="text" name="comment" placeholder="コメント" value="<?php echo $editcomment;?>">
 <input type="hidden" name="bango" value="<?php echo $editnum;?>"></br>    
       <input type="text" name="pass" placeholder="パスワード"></br>
       <input type="submit" value="送信">
 </form>
 <form action="mission_4-1.php" method="POST">  
	<input type="text" name="delno" placeholder="削除対象番号">
        <input type="text" name="password2" placeholder="パスワード"></br>
	<input type="submit" name="delete" value="削除"></br>
</form>
 <form action="mission_4-1.php" method="POST">  
	<input type="text" name="edit" placeholder="編集対象番号">
	<input type="text" name="password3" placeholder="パスワード"></br>
        <input type="submit"  value="編集"></br>
      </form>

<?php 

$sql='SELECT*FROM tbtest5';
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){

echo $row['id'].',';
echo $row['name'].',';
echo $row['comment'].',';
echo $row['postedAt'].',<br>';
}
?>

</body>  
</html>
