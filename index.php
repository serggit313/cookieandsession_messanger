<?php
session_start();
// Функция валидации
function validate()
{
    if(!empty($_POST['name']) && !empty($_POST['comment']))
    {
        saveComment('Database.txt', $_POST['name'], $_POST['comment']);
    }
}

validate();

function saveComment($document, $name, $comment)
{
    if(file_exists($document))
    {
        $w = $name . ': '. $comment . "\n"; 
        file_put_contents($document, $w, FILE_APPEND);
    }
}

function showComment($document)
{
    if(file_exists($document))
    {
       $data_arr = file($document);
       $revers = array_reverse($data_arr);
       foreach($revers as $key=>$value)
       {?>
        <p>
            <span>
                <?php echo $value;?>
            </span>
        </p>
       <?php }
    }
}

// Проверяем пользователя гость ли он или уже открыта сессия
function is_guest()
{
    if(!empty($_SESSION['user'] || !empty($_COOKIE['remember'])))
    {
        return false;
    }
    else
    {
        return true;
    }
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
    <?php if(is_guest() == true):?>
    <h1>Только авторезированные пользователи могут оставлять комментарии</h1><br/>
    <div class="reg_links">
        <a href="auth.php" style="margin-right: 30px;">Авторизация</a> 
        <a href="reg.php">Регистрация</a>
    </div>
    <?php else:?>
    <form action="" method="POST">
        <div>
            <input type="text" placeholder="Имя" name="name">
        </div>
        <div>
            <textarea name="comment" id="comment" cols="30" rows="10" placeholder="Комментарий: "></textarea>
        </div>
        <button type="submit">Отправить</button>
    </form>

    <div class="comments">
        <?php showComment('Database.txt'); ?>
    </div>

    <div class="exit">
        <a href="#">Выйти</a>
    </div>
    <?php endif;?>

</body>
</html>