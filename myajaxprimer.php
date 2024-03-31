<?php
header('Content-Type: text/html; charset=utf-8');
setlocale(LC_ALL, 'ru_RU.65001', 'rus_RUS.65001', 'Russian_Russia. 65001', 'russian');

$zRedactor = $_POST["redactor"];
$zFunctionality = $_POST["functionality"];
$zDescription = $_POST["description"];
$zType = $_POST["type"];

/* Подключение к серверу MySQL */
$link = mysqli_connect(
    'localhost', /* Хост, к которому мы подключаемся */
    'root', /* Имя пользователя */
    '', /* Используемый пароль */
    'web_lab6'); /* База данных для запросов по умолчанию */

if (!$link) {
    printf("Невозможно подключиться к базе данных. Код ошибки: %s\n",
    mysqli_connect_error());
    exit;
}

$query = "INSERT INTO functionality (Name, Description, Type, redactor_id) VALUES ('$zFunctionality', '$zDescription', '$zType', '$zRedactor')";

if (mysqli_query($link, $query)) {
    echo "Новая запись успешно добавлена";
} else {
    echo "Ошибка: " . $query . "<br>" . mysqli_error($link);
}

/* Посылаем запрос серверу */
if ($result = mysqli_query($link, 'SELECT functionality.id as id_fun, functionality.Name, functionality.Description, Type, redactors.name as redactors_name FROM functionality left join redactors
                                    on functionality.redactor_id = redactors.id ORDER BY functionality.id DESC')) {
    /* Выборка результатов запроса */
    while( $row = mysqli_fetch_assoc($result) ){
        echo "<div class='message'>";
        echo "<h2>" . $row['Name'] . "</h2>";
        echo $row['Description'] . "<hr>";
        echo $row['Type'] . "<br>";
        echo  $row['redactors_name'];
        echo "</div>";
    }
    /* Освобождаем используемую память */
    mysqli_free_result($result);
}

/* Закрываем соединение */
mysqli_close($link);
?>