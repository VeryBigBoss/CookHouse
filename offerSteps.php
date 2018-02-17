<?php

session_start();

function getFoodList($type)
{
    $db = new mysqli('127.0.0.1', 'root', "", "vkusnodom");
    $db->set_charset("utf8");
    if (mysqli_connect_errno())
    {
        echo 'Ошибка подключения к БД';
        exit();
    }

    /*$query = "SELECT food.id, food.title, food.previewImage
              FROM food  
              INNER JOIN foodType ON foodType.id = food.foodType
              WHERE foodType.short LIKE ".$type;*/
    $result = $db->query('SELECT food.id, food.title, food.previewImage 
              FROM food  
              INNER JOIN foodType ON foodType.id = food.foodType
              WHERE foodType.short LIKE '.$type);
    //$result_count = $result->num_rows;
    while ($row = $result->fetch_assoc())  {
        echo '<section class="menu-item-card">' .
            '<div class="menu-item-card-img">' .
            '<img src= "img/';
        echo $row['previewImage'];
        echo '"width="150" height="auto">'.
            '</div>' . '<div class="wrapper-card-title">' .
            '<p class="menu-item-card-title">';
        echo $row['title'];
        echo '</p>' . '</div>' .
            '<div class="wrapper-input-checkbox">' .
            '<input class="input-checkbox" type="checkbox" name="eat-title['.
//            $row['id'].
            ']"'.'id="eat-title-'.$row['id'].'" value="'.$row['title'].'"';
        echo '"><label class="button-choose" for="eat-title-'.$row['id'].
            '">Выбрать</label>'.
            '<label class="button-cancel" for="eat-title-'.$row['id'];
        echo '">Отменить</label>'.
            '</div>'.
            '</section>';
    }
    $result->free();
    $db->close();
}
?>