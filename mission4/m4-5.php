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
    $name = 'yamada';
    $comment = 'tokabe';

    $sql = "INSERT INTO tbtest (name, comment) VALUES (:name, :comment)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->execute();
?>
</body>
</html>