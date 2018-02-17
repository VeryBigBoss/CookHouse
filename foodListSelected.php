<?php
//session_start();

if (isset($_SESSION["selectedFood"])) {
    $selectedFood = $_SESSION["selectedFood"];
}

if (isset($_POST['foodId'])) {
    $foodId = $_POST['foodId'];
    $foodImage = $_POST['foodImage'];
    $foodTitle = $_POST['foodTitle'];

    if (isset($_POST['eat-title-boolean'])) {
        $eatTitleBoolean = $_POST['eat-title-boolean'];
        if ($eatTitleBoolean[0] == "checked") {
            $eatTitleBoolean = "true";
        } else {
            $eatTitleBoolean = "false";
        }
    } else $eatTitleBoolean = "false";

    $selectedFood[$foodId[0]] = array("foodId" => $foodId[0],
        "eatTitleBoolean" => $eatTitleBoolean,
        "foodImage" => $foodImage,
        "foodTitle" => $foodTitle);

    // Удаляем из нашего массива все элементы, у которых значение чекбокса = false
    foreach ($selectedFood as $row) {
        if ($row['eatTitleBoolean'] == "true") {
            echo '<section class="menu-item-card">
                        <div class="menu-item-card-img">
                            <img src="img/' . $row['foodImage'] . '" width="150" height="auto">' .
                        '</div>
                        <div class="wrapper-card-title">
                            <p class="menu-item-card-title">' . $row['foodTitle'] . '</p>
                            <input type="text" name="eat-title[]" hidden>
                        </div>' .
//                '<button type="button" class="menu-item-card-delete"></button>' .
                '</section>';
        } else {
            unset($selectedFood[$row['foodId']]);
        }
    }
} else {
    foreach ($selectedFood as $row) {
        if ($row['eatTitleBoolean'] == "true") {
            echo '<section class="menu-item-card">
                        <div class="menu-item-card-img">
                            <img src="img/' . $row['foodImage'] . '" width="150" height="auto">' .
                        '</div>
                        <div class="wrapper-card-title">
                            <p class="menu-item-card-title">' . $row['foodTitle'] . '</p>
                            <input type="text" name="eat-title[]" hidden>
                        </div>' .
//                '<button type="button" class="menu-item-card-delete"></button>' .
                '</section>';
        } else {
            unset($selectedFood[$row['foodId']]);
        }
    }
}

if (count($selectedFood) == 0) {
    echo '<h3 id="didnt-choose">Вы ничего не выбрали :(</h3>';
}

$_SESSION["selectedFood"] = $selectedFood;
?>