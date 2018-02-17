/*Сделаем так, чтобы при загрузке страницы все ссылки заменялись через JS, для того, чтобы
 * при нажатии на кнопку выбрать, ничего не происходило, а выбранное значение записывалось в localStorage*/
var formMass = document.getElementsByClassName("eat-title-submit");
var checkboxList = document.getElementsByClassName("input-checkbox");

for (var i = 0; i < formMass.length; i++) {
    formMass[i].type = "button";
}

for (var i = 0; i < checkboxList.length; i++) {
    if (sessionStorage.getItem(checkboxList[i].id)) {
        checkboxList[i].checked = sessionStorage.getItem(checkboxList[i].id);
    }
}

/*-------------- ЗАМЕНЯЕМ ТИП ПОЛЯ DATE НА TEXT, ЧТОБЫ СРАБОТАЛ КАЛЕНДАРЬ ----------------*/
var datepickerInput = document.getElementById("date");
if (datepickerInput) datepickerInput.setAttribute("type", "text");

/*$(".datepicker-here").attr("type", "text");
 // $(".datepicker-here").datepicker({timepicker: true});

 $(".datepicker-here").datepicker({multipleDates: false
 });*/

/*--------------ИНИЦИАЛИЗИРУЕМ КОЛИЧЕСТВО ВЫБРАННЫХ ПОЗИЦИЙ ----------------*/
if (sessionStorage.getItem("checkedBoxId")) {
    var selectedCheckbox = [];
    selectedCheckbox = JSON.parse(sessionStorage.getItem("checkedBoxId"));
    displayCountSelected(selectedCheckbox.length);
} else {
    deleteTextDidntChoose();
}

/*--------------- Запоминаем состояние выбранных чекбоксов -----------------*/
function isCookies() {
    sessionStorage.clear();
    var selectedCheckbox = [];
    var position = 0;
    for (var i = 0; i < checkboxList.length; i++) {
        if (checkboxList[i].checked) {
            var o = new Object();
            o.id = checkboxList[i].id;
            o.foodImage = document.getElementById("foodImage-" + checkboxList[i].id.replace("eat-title-", "")).getAttribute("value");
            o.foodTitle = document.getElementById("foodTitle-" + checkboxList[i].id.replace("eat-title-", "")).getAttribute("value");
            selectedCheckbox[position] = o;
            position++;

            sessionStorage.setItem(checkboxList[i].id, o.id); //для обновления состояния чекбоксов в дальнейшем
            sessionStorage.setItem("checkedBoxId", JSON.stringify(selectedCheckbox)); //для отрисовки выбранных позиций на странице offer-steps.html
        }
        if (!checkboxList[i].checked) {
            sessionStorage.removeItem(checkboxList[i].id);
        }
    }
    displayCountSelected(selectedCheckbox.length);
}

/*--------------------------------------------------------------------------*/

function foodListSelected() {
    var displaySelected = [];
    var o2 = new Object();
    if (sessionStorage.getItem("checkedBoxId")) {
        displaySelected = JSON.parse(sessionStorage.getItem("checkedBoxId"));
        for (var key in displaySelected) {
            o2 = displaySelected[key];
            if (o2 != null)
                displayFoodListSelected(o2.id, o2.foodTitle, o2.foodImage);
        }
    }
}

function displayFoodListSelected(foodId, titleFood, imageFood) {
    var section = document.createElement('section');
    var div = document.createElement('div');
    var img = document.createElement('img');
    var divWrapperTitle = document.createElement('div');
    var p = document.createElement('p');
    var input = document.createElement('input');
    var button = document.createElement('button');

    section.className = "menu-item-card";
    section.setAttribute("id", "menu-item-card-" + foodId);
    div.className = "menu-item-card-img";
    img.setAttribute("src", "img/" + imageFood/*"img/soup.jpg"*/);
    img.setAttribute("width", "150");
    img.setAttribute("height", "auto");
    divWrapperTitle.className = "wrapper-card-title";
    p.className = "menu-item-card-title";
    p.innerText = titleFood;//"Суп куриный";
    input.setAttribute("type", "text");
    input.setAttribute("name", "eat-title[]");
    input.setAttribute("hidden", "hidden");
    input.setAttribute("value", titleFood);
    button.className = 'menu-item-card-delete';
    button.setAttribute("id", "delete-" + foodId);
    button.setAttribute("type", "button");
    button.setAttribute("onclick", "deleteSelectedFood(this)");

    var parent = document.getElementsByClassName("wrapper-column-menu");
    div.appendChild(img);
    divWrapperTitle.appendChild(p);
    divWrapperTitle.appendChild(input);
    section.appendChild(div);
    section.appendChild(divWrapperTitle);
    section.appendChild(button);
    parent[0].appendChild(section);
}

function deleteSelectedFood(element) {
    var thisEatTitleId = element.getAttribute("id").replace("delete-", "");
    var itemCard = document.getElementById("menu-item-card-" + thisEatTitleId);
    itemCard.parentNode.removeChild(itemCard);

    // Снимаем выделение чекбокса, для которого удалили блюдо
    var selectedCheckbox = [];
    selectedCheckbox = JSON.parse(sessionStorage.getItem("checkedBoxId"));
    var o = new Object();
    for (var i = 0; i < selectedCheckbox.length; i++) {
        o = selectedCheckbox[i];
        if (o.id == thisEatTitleId) {
            selectedCheckbox.splice(i, 1);
            sessionStorage.setItem("checkedBoxId", JSON.stringify(selectedCheckbox));
            sessionStorage.removeItem(thisEatTitleId);
            break;
        }
    }
    displayCountSelected(selectedCheckbox.length);
}

/*---------- РИСУЕМ КРАСНЫЙ КРУЖОК С ЧИСЛОМ ВЫБРАННЫХ БЛЮД и вставляем надпись о том, что ничего не выбрано--------*/
function displayCountSelected(countCheckedMenu) {
    var entryGuestLink = document.getElementById("entryGuestLink");
    var elementSpan = document.getElementById("offer-count-id");
    //удаляем фразу созданную через php
    var didntChoose = document.getElementById("didnt-choose");
    var imgCry = document.getElementById("imgCry-id");
    if (didntChoose) {
        didntChoose.remove(didntChoose);
    }
    if (imgCry) {
        imgCry.remove(imgCry);
    }
    // если элемент не создан, то создаем его
    if (!elementSpan && countCheckedMenu != 0) {
        var span = document.createElement('span');
        span.setAttribute("id", "offer-count-id");
        span.className = "offer-count";
        span.innerText = countCheckedMenu;
        entryGuestLink.appendChild(span);
    }
    if (countCheckedMenu != 0) {
        elementSpan.innerText = countCheckedMenu;
    }
    //если элемент необходимо удалить
    if (countCheckedMenu == 0) {
        if (elementSpan)
            elementSpan.remove(elementSpan);
        var parent = document.getElementById("wrapper-column-menu-id");
        if (parent) {
            var text = document.createElement('h3');
            var img = document.createElement('img');
            text.setAttribute("id", "didnt-choose");
            text.innerText = "Вы ничего не выбрали";
            img.setAttribute("src", "img/cry.gif");
            img.setAttribute("width", "50");
            img.setAttribute("height", "auto");
            parent.appendChild(text);
            parent.appendChild(img);
            // deleteTextDidntChoose()
        }
    }
}

/*---------------- УДАЛЯЕМ НАДПИСЬ "ВЫ НИЧЕГО НЕ ВЫБРАЛИ" СОЗДАННУЮ ЧЕРЕЗ PHP -------------------*/
function deleteTextDidntChoose() {
    var parent = document.getElementById("wrapper-column-menu-id");
    if (parent) {
        var elementForDelete = document.getElementById("didnt-choose");
        elementForDelete.remove(elementForDelete);
        var text = document.createElement('h3');
        var img = document.createElement('img');
        text.setAttribute("id", "didnt-choose");
        text.innerText = "Вы ничего не выбрали";
        img.setAttribute("id", "imgCry-id");
        img.setAttribute("src", "img/cry.gif");
        img.setAttribute("width", "50");
        img.setAttribute("height", "auto");
        parent.appendChild(text);
        parent.appendChild(img);
    }
}

/*--------------- УДАЛЯЕМ ВСЕ SESSIONSTORAGE СОЗДАННЫЕ В JAVASCRIPT ---------------*/
function removeAllSession() {
    sessionStorage.clear();
}