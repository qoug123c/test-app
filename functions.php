<?php
require_once('connection.php');//データの受け取り処理(sc12)

function getTodoList()//取得したデータを画面に表示させる(sc13)
{
    return getAllRecords();
}

function getSelectedTodo($id)//(sc15)
{
    return getTodoTextById($id); 
}
function savePostedData($post) //処理の振り分けとリダイレクト設定(sc15)
{
    $path = getRefererPath();
    switch ($path) {
        case '/new.php':
            createTodoData($post['content']); //新規作成ページからPOSTされたなら、createTodoData関数 を実行（INSERT処理）
            break;
        case '/edit.php':
            updateTodoData($post); //編集ページからPOSTされたなら、updateTodoData関数 を実行（UPDATE処理）
            break;
         case '/index.php': //(sc16)
            deleteTodoData($post['id']); //削除処理
            break; 
        default:
            break;
    }
}

function getRefererPath()//処理の振り分けとリダイレクト設定(sc15)
{
    $urlArray = parse_url($_SERVER['HTTP_REFERER']);
    return $urlArray['path'];
}
