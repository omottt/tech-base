<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-3</title>
</head>
<body>
    <form action="" method="post">
        <label for="name">名前：</label>
        <input type="text"  name="name" id="name">
        <br>
        <label for="comment">コメント：</label>
        <textarea name="comment" id="comment"></textarea>
        <br>
        <label for="delete">削除対象番号：</label>
        <input type="number" name="delete" id="delete">
        <br>
        <input type="submit" name="submit">
        <input type="submit" name="submit" value="削除">
    </form>
    <?php
        if(!empty($_POST["comment"])){
            $name=$_POST["name"];
            $comment=$_POST["comment"];
            $time = date("Y/m/d H:i:s");
            $filename="mission_3-3.txt";
            if(file_exists($filename)){
                $num = count(file($filename)) + 1;
            }else{
                $num = 1;
            }
            $comments ="$num<>$name<>$comment<>$time";
            $fp=fopen($filename,"a");
            fwrite($fp,$comments . PHP_EOL);
            fclose($fp);
            $arrays =file($filename,FILE_IGNORE_NEW_LINES);
            foreach($arrays as $array){
                $arr = explode("<>",$array);
                echo $arr[0],"番/",$arr[1],"/",$arr[2],"/",$arr[3],"<br>";
            }
        }
        if(!empty($_POST["delete"])){
            $delete =$_POST["delete"];
            $filename="mission_3-3.txt";
            $fp = fopen($filename,"a");
            $lines = file($filename,FILE_IGNORE_NEW_LINES);
            for($i = 0; $i < count($lines); $i++){
                $line = explode("<>",$lines);
                $postnum = $line[0];
                if($postnum != $delete){
                    fwrite($fp,$lines.PHP_EOL);
                }
            }
        fclose($fp);
        }
    ?>
</body>
</html>