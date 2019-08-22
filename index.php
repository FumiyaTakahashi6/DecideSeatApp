<?php
    try {
        $pdo = new PDO("mysql:host=db;dbname=test;charset=utf8", 'root', 'root',
        array(PDO::ATTR_EMULATE_PREPARES => false));
        $sql = "SELECT * FROM hoge_table";
 
        // SQLステートメントを実行し、結果を変数に格納
        $stmt = $pdo->query($sql);
        var_dump($stmt->fetch(PDO::FETCH_ASSOC));
 
        foreach ($stmt as $row) {
 
            echo $row['id'].'：'.$row['name'].'人';
 
        echo '<br>';
        }
    } catch (PDOException $e) { 
        echo $e->getMessage();
    }
?>