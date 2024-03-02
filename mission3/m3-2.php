<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-2</title>
</head>
<body>
    <form action="" method="post">
        <label for="name">名前：</label>
        <input type="text"  name="name" id="name">
        <br>
        <label for="comment">コメント：</label>
        <textarea name="comment" id="comment"></textarea>
        <input type="submit" name="submit">
    </form>
    <?php
        if(!empty($_POST["comment"])){
            $name=$_POST["name"];
            $comment=$_POST["comment"];
            $time = date("Y/m/d H:i:s");
            $filename="mission_3-2.txt";
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
    ?>
</body>
</html>