<?php
require_once('connection.php');//データの受け取り処理(sc12)
session_start(); //(sc19)

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
    checkToken($post['token']); // (sc19)
    validate($post);//バリデーションチェック(sc20)
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
function validate($post)//バリデーションチェック(sc21)
{
    if (isset($post['content']) && $post['content'] === '') {
        $_SESSION['err'] = '入力がありません';
        redirectToPostedPage();
    }
}

function getRefererPath()//処理の振り分けとリダイレクト設定(sc15)
{
    $urlArray = parse_url($_SERVER['HTTP_REFERER']);
    return $urlArray['path'];
}

function e($text)// エスケープ処理(sc18)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function setToken()// SESSIONにtokenを格納する(sc19)
{
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
}

function checkToken($token)// SESSIONに格納されたtokenのチェックを行い、SESSIONにエラー文を格納する(sc19)
{
    if (empty($_SESSION['token']) || ($_SESSION['token'] !== $token)) {
        $_SESSION['err'] = '不正な操作です';
        redirectToPostedPage();
    }
}

function unsetError()
{
    $_SESSION['err'] = '';
}

function redirectToPostedPage()
{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

