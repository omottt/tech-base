<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
</head>
<body>
    
    <?php
        $filename="mission_3-5.txt";//ファイルの指定
        $date=date("Y/m/d H:i:s");
        $rename="";
        $recom="";
        $edit="";
        $pass_edit="";

        //新規投稿フォーム
            if((!empty($_POST["name"])) && (!empty($_POST["comment"])) && (empty($_POST["edit_id"])) && (!empty($_POST["pass"]))){
            $name=$_POST["name"];
            $com=$_POST["comment"];
            $pass=$_POST["pass"];
        
         //投稿番号の取得 ファイルの存在がある場合は投稿番号+1、なかったら1を指定する
            if (file_exists($filename)) {
                $data = (file($filename));
                $max=0;
                foreach($data as $line){
                    $items=explode("<>",$line);
                        $num=$items[0];
                        if(intval($num)>$max){
                            $max=intval($num);
                        }
                    }
                    $num=$max+1;
                }else{
                    $num = 1;
                }
                
            $fp = fopen($filename,"a");//ファイルを開く
                fwrite($fp, $num."<>".$name."<>".$com."<>".$date."<>".$pass."<>"."/n");//ファイルに記入する
                fclose($fp);//ファイルを閉じる
            }
    
        
    
        //削除フォーム    
        if((!empty($_POST["delete"])) && (!empty($_POST["pass_delete"]))){
            $delete=$_POST["delete"];//削除番号
            $pass_del=$_POST["pass_delete"];//削除パス
            $lines=file($filename,FILE_IGNORE_NEW_LINES);//ファイルの中身を1行1要素として配列変数に代入
            $fp=fopen($filename,"w");//削除対象ではない投稿だけを上書きすることで削除を実現    
            //投稿番号の取得 ファイルの存在がある場合は投稿番号+1、なかったら1を指定する
           
            for($i=0; $i<count($lines); $i++){ //ループ処理を行う
                $line=explode("<>",$lines[$i]); //<>で分割抽出
                if(($delete != $line[0]) && ($pass_del == $line[4])){ //削除番号と行番号が一致しない∩パスが一致する場合↓
                    fwrite($fp,$lines[$i].PHP_EOL); //行内容をファイルに書き込む
                
                
            }
            fclose($fp); //ファイルを閉じる
        }
      
        //編集番号選択
         if((!empty($_POST["edit"])) && (!empty($_POST["pass_edit"]))){
            $lines=file($filename,FILE_IGNORE_NEW_LINES);
            foreach($lines as $line){
                $items=explode("<>",$line);
                if(($_POST["edit"] == $items[0]) && ($_POST["pass_edit"] == $items[4])){
                    $edit=$_POST["edit"];
                    $rename=$items[1];
                    $recom=$items[2];
                    $pass_edit=$items[4];
                }
            }
         }
       
        //編集実行機能
        if((!empty($_POST["name"])) && (!empty($_POST["comment"])) && (!empty($_POST["edit_id"])) &&(!empty($_POST["pass"]))){
            $name=$_POST["name"];
            $com=$_POST["comment"];
            $edit_id=$_POST["edit_id"];
            $pass=$_POST["pass"];
            $lines=file($filename,FILE_IGNORE_NEW_LINES);
            $fp=fopen($filename,"w"); 
            
            foreach($lines as $line){ //ループ処理を行う
                $items=explode("<>",$line);//<>で分割抽出
                if(($edit_id == $items[0]) && ($pass == $items[4])){//編集番号と投稿番号が一致∩パスワードが一致する場合↓
                    fwrite($fp,$edit_id."<>".$name."<>".$com."<>".$date."<>".$pass."<>".PHP_EOL);
                }else{
                    fwrite($fp,$line.PHP_EOL);
                }
            }
            fclose($fp); //ファイルを閉じる
            $pass="";
            $edit="";
        }
    ?>
    
     <form action="" method="post">
    【投稿フォーム】<p>
        <input type="text" name="name"placeholder="名前を入力"  value="<?php echo $rename ;?>">
        <br>
        <input type="text" name="comment"placeholder="コメントを入力" value="<?php echo $recom ;?>">
        <br>
        <input type="text" name="pass" placeholder="パスワード" value="<?php echo $pass_edit ?>">
        <br>
        <input type="text" name="edit_id"  value="<?php echo $edit ;?>">
        <input type="submit" name="submit">
        </p>
    【削除フォーム】<p>
        <input type="number" name="delete" placeholder="削除対象番号を入力">
        <br>
        <input type="text" name="pass_delete" placeholder="パスワード">
        <br>
        <input type="submit" name="submit" value="削除">
        </p>
    【編集フォーム】<p>
        <input type="number" name="edit" placeholder="編集対象番号を入力">
        <br>
        <input type="text" name="pass_edit" placeholder="パスワード" >
        <br>
        <input type="submit" name="edit_f" value="編集">
        </p>
    </form>
    
    <!--テキストファイルの内容をブラウザに反映-->
    <?php
        $filename="mission_3-5.txt";
        $date=date("Y/m/d H:i:s");
        $lines=file($filename,FILE_IGNORE_NEW_LINES);
        
        foreach ($lines as $line) {
            $items= explode("<>", $line);
            $num = $items[0];
            $name = $items[1];
            $com = $items[2];
            $date = $items[3];
        print_r($num." ".$name." ".$com." ".$date."<br>");
        }
    ?>
    
</body>
</html>