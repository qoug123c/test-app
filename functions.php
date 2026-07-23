<?php
require_once('connection.php');

function createData($post)
{
    createTodoData($post['content']);  
}