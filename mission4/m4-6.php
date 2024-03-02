<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>m4-1</title>
</head>
<body>
<?php
    $dsn = 'mysql:dbname=データベース名;host=ホスト名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].'<br>';
        echo "<hr>";
    }
?>
</body>
</html>