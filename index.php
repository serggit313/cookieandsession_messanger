<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	validade();
}

function validade()
{
	if (!empty($_POST['name']) && !empty($_POST['comment'])) 
	{
		saveComment('comments.txt', $_POST['name'], $_POST['comment']);
		return true;
	}
	return false;
}

function saveComment($file, $name, $comment)
{
	if (file_exists($file)) 
	{
		$data = $name . ':' . $comment . "\r\n";
		file_put_contents($file, $data, FILE_APPEND);
		return true;
	}
	return false;
}

function getComment($file)
{
	if (file_exists($file) && is_readable($file)) 
	{
		$comment_arr = file($file);
		return $comment_arr;
	}
	return false;
}

function showComment($file)
{
	if(file_exists($file))
	{
		$comments = getComment($file);
		if(!empty($comments))
		{
			foreach ($comments as $comment) 
			{?>
				<p>
					<?php echo $comment; ?>
				</p>
			<?php }
		}
	}
}

function is_user()
{
	if($_SESSION['user'] || $_COOKIE['user'])
	{
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
    <title>Главная</title>
</head>
<body>
    <?php if(is_user()):?>
    <form action="#" method="POST">
        <div>
            <input type="text" placeholder="Имя" name="name">
        </div>
        <div>
            <textarea name="comment" id="comment" cols="30" rows="10" placeholder="Комментарий: "></textarea>
        </div>
        <button type="submit">Отправить</button>
    </form>
    <div class="comments">
		<?php showComment('comments.txt'); ?>
	</div>
    <div class="exit">
        <a href="exit.php">Выйти</a>
    </div>
    <?php else:?>
    <h1>Только авторезированные пользователи могут оставлять комментарии</h1><br/>
    <div class="reg_links">
        <a href="auth.php" style="margin-right: 30px;">Авторизация</a> 
        <a href="reg.php">Регистрация</a>
    </div>
    <?php endif;?>
</body>
</html>