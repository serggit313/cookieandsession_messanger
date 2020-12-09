<?php
session_start();

$login = $_POST['login'];
$password = $_POST['password'];

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    validade($login, $password);
}

function validade($login, $password)
{
    if (!empty($login) && !empty($password)) 
    {
        saveUser('users.txt', $_POST['login'], $_POST['password']);
        return true;
    }
    return false;
}

function saveUser($file, $login, $password)
{
    if (file_exists($file) && is_readable($file)) 
    {
        $data = $login . ':' . $password . "\r\n";
        file_put_contents($file, $data, FILE_APPEND);
        
        return true;
    }
    return false;
}



?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>
<body>
<div class="form_register">
        <h3>Регистрация: </h3>
        <form action="#" method="POST">
            <p>
                <input type="text" name="login" placeholder="Login">
            </p>
            <p>
                <input type="text" name="password" placeholder="Password">
            </p>
            <button type="submit">Отправить</button>
        </form>
    </div>
    <br>
    <p>
        <a href="index.php">На главную</a>
    </p>
    <p>
        <a href="auth.php"></a>
    </p>
   
</body>
</html>