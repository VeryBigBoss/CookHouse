<?php
    $date = $_POST['date'];
    $time = $_POST['time'];
    $masSoup = $_POST['eat-title'];
	$firstName = $_POST['first-name'];
	$firstName = htmlspecialchars($firstName);
	$firstName = urldecode($firstName);
	$firstName = trim($firstName);
	$mail = $_POST['email'];
    $mail = htmlspecialchars($mail);
    $mail = urldecode($mail);
    $mail = trim($mail);

    $selectMenu = "";

	if (!empty($masSoup))
    {
        $count = count($masSoup);
        for ($i = 0; $i < $count; $i++)
        {
            $selectMenu = $selectMenu.'\r\n'.($i + 1).")".$masSoup[$i];
        }
    }

    $resultMessage = "Кто: ".$firstName.'\r\n'
                     ."Почтовый ящик: ".$mail.'\r\n'
                     ."Дата и время посещения: ".$date." в ".$time.'\r\n'
                     ."Меню: ".$selectMenu;


    if (mail("petiayari@yandex.ru", "Заявка с сайта", str_replace('\r\n',"\r\n", $resultMessage) /*,"From: example2@mail.ru \r\n"*/))
    {
        include 'order.html';
        unset($_SESSION["selectedFood"]);
    } else {
        echo "при отправке сообщения возникли ошибки";
    }
?>