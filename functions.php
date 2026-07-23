<?php
require_once('connection.php');//データの受け取り処理(sc12)

function createData($post)
{
    createTodoData($post['content']);  
}

function getTodoList()//取得したデータを画面に表示させる(sc13)
{
    return getAllRecords();
}