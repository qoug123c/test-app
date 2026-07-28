<?php
require_once('config.php');

// PDOクラスのインスタンス化
function connectPdo()
{
    try {
        return new PDO(DSN, DB_USER, DB_PASSWORD);
    } catch (PDOException $e) {
        echo $e->getMessage(); //SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost' (using password: YES)とか
        exit();
    }
}

function createTodoData($todoText) //データの登録処理(sc12)
{
    $dbh = connectPdo();
    $sql = 'INSERT INTO todos (content) VALUES (:todoText)'; //プレースホルダーを設定(sc20)
    $stmt = $dbh->prepare($sql); //(sc20)
    $stmt->bindValue(':todoText', $todoText, PDO::PARAM_STR); //プレースホルダーに値をセット(sc20)
    $stmt->execute(); //(sc20)
}

function getAllRecords() //データの取得処理(sc13)
{
    $dbh = connectPdo();
    $sql = 'SELECT * FROM todos WHERE deleted_at IS NULL';
    return $dbh->query($sql)->fetchAll();
}

function updateTodoData($post)// 更新処理(sc15)
{
    $dbh = connectPdo();
    $sql = 'UPDATE todos SET content = :todoText WHERE id = :id'; //(sc20)
    $stmt = $dbh->prepare($sql); //(sc20)
    $stmt->bindValue(':todoText', $post['content'], PDO::PARAM_STR); //(sc20)
    $stmt->bindValue(':id', (int) $post['id'], PDO::PARAM_INT); //(sc20)
    $stmt->execute(); //(sc20)
}

function getTodoTextById($id)// 更新したいTODOの現在保存されているデータを取得する処理(sc15)
{
    $dbh = connectPdo();
    $sql = 'SELECT * FROM todos WHERE deleted_at IS NULL AND id = :id' ;
    $stmt = $dbh->prepare($sql); //ここでは配列にできないのでfetchはまだ使用しない
    $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT); //(sc20)
    $stmt->execute(); //(sc20)
    $data = $stmt->fetch();//ここで配列にする
    return $data['content'];
}

function deleteTodoData($id)//論理削除のDB処理(sc16)
{
    $dbh = connectPdo();
    $now = date('Y-m-d H:i:s');
    $sql = 'UPDATE todos SET deleted_at = :now WHERE id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':now', $now, PDO::PARAM_STR); //$nowはstring
    $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT); //(sc20)
    $stmt->execute(); //(sc20)
}