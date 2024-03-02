<html>
<head>
<title>keiziban</title>
<meta charset= "utf-8">
</head>

<body>

 <?php

    //データベース接続設定
    $dsn = 'mysql:dbname=tb250671db;host=localhost';
    $user = 'tb-250671';
    $password = 'HgxTvTFnc9';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));



      //テーブルの作成
    $sql = "CREATE TABLE IF NOT EXISTS tech_text"
    ."("
    ."id INT AUTO_INCREMENT PRIMARY KEY,"
    ."name char(32),"
    ."comment TEXT,"
    ."date char(32)"
    ."pass char(32),"
    .");";
    $stmt = $pdo->query($sql);


    
      //編集選択機能
if(!empty($_POST["editNo"]) && !empty($_POST["editpass"])){
    $id = $_POST["editNo"];
    $editpass = $_POST["editpass"];
    $sql = 'SELECT * FROM tech_text';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
        
    foreach ($results as $row){
        if($row['id'] == $id){
        $ename = $row['name'];
        $ecomment = $row['comment'];
        $pass = $row['pass'];
        $editnumber = $row['id'];     
        }
    }
}

?>  



<form method = "POST" action = keiziban.php>
<input type = "text"  name = "name"  value = "<?php if(!empty($pass)){echo $ename;}?>"  placeholder = "<?php if(empty($pass)){echo "名前";}?>">
<input type = "text"  name = "comment"  value = "<?php if(!empty($pass)){echo $ecomment;}?>"  placeholder = "<?php if(empty($pass)){echo "コメント";}?>">		
<input id="pass" type = "text" name = "password" value ="<?php if(!empty($pass)){echo $pass;}?>"  placeholder = "<?php if(empty($pass)){echo "パスワード";}?>">
<input type = "hidden"  name = "edit-number" value = "<?php if(!empty($pass)){echo $editnumber;}?>" >
<input type = "submit"  name = "btn"value = "送信"><br>
	
<input type = "text" name = "deleteNo"  placeholder = "削除対象番号" placeholder="編集番号を入力してください">
<input id="pass" type = "text" name = "delpass"  placeholder = "パスワード">
<input type = "submit"  name = "delete" value = "削除"><br>
	
<input type = "text" name = "editNo" placeholder = "編集対象番号" placeholder="編集番号を入力してください">
<input id="pass" type = "text" name = "editpass"  placeholder = "パスワード">
<input type =  "submit" name = "edit" value = "編集"><br> 




<?php


      //編集実行機能
if(!empty($_POST["edit-number"]) && !empty($_POST["editNo"])){
    $id = $_POST["edit-number"];      //ここで編集対象番号の値の受け取りを行う
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $password = $_POST["password"]; 
    $date = date("Y年m月d日 H時i分s秒");
    $sql = 'update tech_text set name=:name,comment=:comment,pass=:pass,date=date where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $password, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
}



        //新規投稿
if(!empty($_POST["name"]) && !empty($_POST["comment"]) and !empty($_POST["password"]) and empty($_POST["edit-number"])){
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $password = $_POST["password"];
    $date = date("Y年m月d日 H時i分s秒");
    $sql = $pdo -> prepare("INSERT INTO tech_text (name, comment, pass,date) VALUES(:name, :comment, :pass,:date)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);        
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':pass', $password, PDO::PARAM_STR);
    $sql -> execute();              //実行する
}



         // 削除機能
 if(!empty($_POST['deleteNo']) && !empty($_POST['delpass'])){
    $delete=$_POST['deleteNo']; 
    $delpassword=$_POST['delpass'] ;
    $sql = 'delete from tech_text where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $delete, PDO::PARAM_INT);
	$stmt->execute();
  }
  

          //表示機能

    $sql = 'SELECT * FROM tech_text';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    
    foreach ($results as $row){
        //配列の中で使うのはテーブルのカラム名の物
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].',';
        echo "<hr>";
    }



?>