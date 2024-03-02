<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>m5-1</title>
</head>
<body>
    <?php
        //エラー文が代入されないように
        $newname = "";
        $newcomment = "";
        $newid="";
        
        //データベース接続設定
        $dsn = 'mysql:dbname=データベース名;host=ホスト名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        //テーブル作成
        $sql = "CREATE TABLE IF NOT EXISTS tbdata"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name CHAR(32),"
        . "comment TEXT,"
        . "pass char(32),"
        . "time char(32)"
        .");";
        $stmt = $pdo->query($sql);
        
        //新規投稿
        if(!empty($_POST["comment"]) && !empty($_POST["name"]) && !empty($_POST["submit"]) && !empty($_POST["s_pass"]) && empty($_POST["edit"])){
            $name = $_POST["name"];
            $comment = $_POST["comment"];
            $pass = $_POST["s_pass"];
            $date = date("Y/m/d H:i:s");
            $sql = "INSERT INTO tbdata (name, comment, pass, time) VALUES(:name, :comment, :pass, :time)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
            $stmt->bindParam(':time', $date, PDO::PARAM_STR);
            $stmt->execute();
        }

        //削除機能
        if(!empty($_POST["deleteb"]) && !empty($_POST["delete"]) && !empty($_POST["d_pass"])){
            $delete = $_POST["delete"];
            $d_pass = $_POST["d_pass"];
            $sql = 'delete from tbdata where id=:id and pass=:pass';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $delete, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $d_pass, PDO::PARAM_STR);
            $stmt->execute();
        }

        //編集対象の投稿を取得
        if(!empty($_POST["edit2"]) && !empty($_POST["editb"]) && empty($_POST["name"]) && empty($_POST["comment"]) && !empty($_POST["e_pass"])){
            $enum = $_POST["edit2"];
            $e_pass = $_POST["e_pass"];
            $sql = 'SELECT * FROM tbdata';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            
            foreach($results as $row){
                if($row["id"] == $enum && $row["pass"] == $e_pass){
                    $newname = $row["name"];
                    $newcomment = $row["comment"];
                    $newid = $row["id"];
                }
            }
        }
        
        //編集機能の実行
        if(!empty($_POST["comment"]) && !empty($_POST["name"]) && empty($_POST["deleteb"]) && !empty($_POST["edit"])){
            $enum = $_POST["edit"];
            $name = $_POST["name"];
            $comment = $_POST["comment"];
            $sql = 'update tbdata set name=:name,comment=:comment where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $enum, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->execute();
            $enum="";
        }

        ?>
    <form action="" method="post">
        <!--名前入力フォーム-->
        <input type="text" name="name" id="name" placeholder="名前" value="<?php echo $newname ; ?>">
        <br>
        <input type="text" name="comment" id="comment" placeholder="コメント" value="<?php echo $newcomment ; ?>">
        <br>
        <input type="text" name="s_pass" placeholder="パスワード">
        <input type="submit" name="submit">
        <br>
        <!-- hidden編集用番号 -->
        <input type="hidden" name="edit" placeholder="編集用" value="<?php echo $newid ; ?>">
        <br>
        <!-- 削除対象番号入力フォーム -->
        <input type="number" name="delete" placeholder="削除対象番号">
        <br>
        <!--パスワード入力フォーム-->
        <input type="text" name="d_pass" placeholder="パスワード">
        <!-- 削除ボタン -->
        <input type="submit" name="deleteb" value="削除">
        <br>
        <br>
        <!-- 編集対象番号入力フォーム -->
        <input type="number" name="edit2" placeholder="編集対象番号">
        <br>
        <!-- パスワード入力フォーム -->
        <input type="text" name="e_pass" placeholder="パスワード">
        <!-- 編集ボタン -->
        <input type="submit" name="editb" value="編集">
        <br>
        <br>
        <br>
    </form>
    <?php
        //表示機能
        $sql = 'SELECT * FROM tbdata';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchALL();
    
        foreach($results as $line){
            echo $line['id'].",";
            echo $line['name'].",";
            echo $line['comment'].",";
            echo $line['time'].",";
            echo "<hr>";
        }
    ?>
</body>
</html>