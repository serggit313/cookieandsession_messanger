<?php
session_start(); 

// $login = $_POST['login'];
// $password = $_POST['password'];

function getUsers($file)
{
	if(file_exists($file))
	{
		$userArr = file($file);
		$usersArr2 = [];
		$users = [];
		foreach ($userArr as $userCleanString) {
			$usersArr2[] = str_ireplace("\r\n", "", $userCleanString);
		}
		foreach ($usersArr2 as $user) {
			$users[] = explode(":", $user);
		}
		return $users;
	}
	return false;
}

function checkUser($file)
{
	if(file_exists($file))
	{
		$users = getUsers($file);
		if(!empty($users))
		{
			foreach ($users as $user) {
				if($_POST['login'] == $user[0] && $_POST['password'] == $user[1])
				{
					$_SESSION['user'] = 'ok';
					if($_POST['check'] == 'on')
					{
						setcookie('user','ok', time()+3600, '/');
					}
				}
			}
			return true;
		}
	}
	return false;
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(checkUser('users.txt'))
	{
		header( 'location: index.php' );
		echo "<h1>Вы успешно авторизировались и будете перенаправлены на страницу с комментариями через 2 секунды...</h1>";
	}
	else
	{
		echo "<h1>Данные введены не верно.Попробуйте еще раз...</h1>";
	}

}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация:</title>
</head>
<body>
<div class="form_register">
        <h3>Авторизация: </h3>
        <form action="#" method="POST">
            <p>
                <input type="text" name="login" placeholder="Login">
            </p>
            <p>
                <input type="text" name="password" placeholder="Password">
            </p>
            <p>
                <input type="checkbox" name="check">
            </p>
            <button type="submit">Отправить</button>
        </form>
    </div>
    <br>
    <a href="index.php">На главную</a>
</body>
</html>