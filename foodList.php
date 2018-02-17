<?php

//session_start();

//Если массив для выбранных элементов отсутствует, то создаем новый, иначе берем из сессии
if (!isset($_SESSION["selectedFood"])) {
    $selectedFood = array();
    $_SESSION["selectedFood"] = $selectedFood;
} else {
    $selectedFood = $_SESSION["selectedFood"];
}

require('config.php');

function getFood($type)
{
    $db = new mysqli('localhost', getLogin(), getPassword(), "id2557632_vkusnodom");
    $db->set_charset("utf8");
    if (mysqli_connect_errno()) {
        echo 'Ошибка подключения к БД';
        exit();
    }

    /*
      Почему то вставка в $result = $db->query($query) строки $query работает
      с ошибками на хостинге, разобраться почему!!!!!
    $query = "SELECT food.title, food.composition, food.previewImage FROM food
          INNER JOIN foodtype ON foodtype.id = food.foodType
          WHERE foodtype.short LIKE ".$type;*/

    $result = $db->query('SELECT food.id, food.title, food.composition, food.previewImage FROM food INNER JOIN foodtype ON foodtype.id = food.foodType 
where foodtype.short LIKE ' . $type);
    while ($row = $result->fetch_assoc()) {
        displayMenuItemList($row['id'], $row['previewImage'], $row['title'], $row['composition']);
    }

    $result->free();
    $db->close();
}

function displayMenuItemList($foodId, $previewImage, $foodTitle, $foodComposition)
{
    $selectedFood = $_SESSION["selectedFood"];
    $checked = "";
    foreach ($selectedFood as $rowSF) {
        if ($foodId == $rowSF['foodId']) {
            $checked = "checked";
        }
    }

    echo '<section class="food-card-item">' .
        '<div class="wrapper-z-index">' .
        '<div class="wrapper-food-img">' .
        '<img src= "img/';
    echo $previewImage;
    echo '"width="235" height="auto">' .
        '</div>' . '<div class="wrapper-food-title">' .
        '<h4 class="food-title">';
    echo $foodTitle;
    echo '</h4>' . '</div>' .
        '<p class="food-composition"><i>Состав</i>: ';
    echo $foodComposition;
    echo '</p>' .
        '</div>' .
        '<div class="wrapper-form-submit">' .
        '<form name="food-card-item-' . $foodId . '"action="offer-steps.html" method="post">' .
        '<button class="eat-title-submit" type="submit">' .
        '<input class="input-checkbox" type="checkbox" name="eat-title-boolean[]"' . ' value = "checked" id="eat-title-' . $foodId . '" onclick="isCookies()" ' . $checked . '>' .
        '<input name="foodId[]" value="' . $foodId . '" hidden>' .
        '<input id="foodImage-' . $foodId . '" name="foodImage" value="' . $previewImage . '" hidden>' .
        '<input id="foodTitle-' . $foodId . '" name="foodTitle" value="' . $foodTitle . '" hidden>' .
        '<div class="wrapper-input-checkbox">' .
        '<label class="button-choose" for="eat-title-' . $foodId . '">Выбрать</label>' .
        '<label class="button-cancel" for="eat-title-' . $foodId . '">Отменить</label>' .
        '</div>' .
        '</button>' .
        '</form>' .
        '</div>' .
        '</section>';
}

?>