<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 transitional//EN"
        "http://www.w3.org/TR/HTML4.01/loose.dtd">
<html>
    <head>
        <title>Применение XMLHttpRequest</title>
        <meta charset="UTF-8">
        <script type="text/javascript">
            var req=false;
            if(window.XMLHttpRequest) {
                req=new XMLHttpRequest();
            } else {
                try { req=new ActiveXObject('Msxml2.XMLHTTP');
                } catch (e)
                { req=new ActiveXObject('Microsoft.XMLHTTP'); } }
            if (! req) // если объект XMLHttpRequest не поддерживается
                alert('Объект XMLHttpRequest не поддерживается данным браузером');
            function Load() {
                if (!req) return;
                req.onreadystatechange = receive;

                var sRedactor = document.getElementsByName("redactor")[0].value;
                var sFunctionality = document.getElementsByName("functionality")[0].value;
                var sDescription = document.getElementsByName("description")[0].value;
                var sType = document.getElementsByName("type")[0].value;

                var data = {
                    redactor: sRedactor,
                    functionality: sFunctionality,
                    description: sDescription,
                    type: sType
                }

                req.open("POST", "myajaxprimer.php", true);
                req.setRequestHeader("Content-type", "application/json");
                req.send(JSON.stringify(data)); // посылаем запрос серверу
            }
            function receive() { // получение данных от сервера
                if (req.readyState == 4){ // если запрос завершен
                    if (req.status == 200) { // если запрос завершен без ошибок
                        document.getElementById('content').innerHTML = req.responseText;
                    }
                    else {
                        alert('Ошибка '+ req.status+': \n' + req.statustext);
                    }
                }
            }
        </script>
        <style>
            .message {
                border: 1px solid #ccc;
                padding: 10px;
                margin-bottom: 10px;
            }
            table td th{
                border: none;
            }
            body{
                background-image: linear-gradient(white, rgb(152, 152, 152));
                margin: 0; /* Убрать отступы по умолчанию */
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh; /* Чтобы центрировать по вертикали на всю высоту окна */
            }
            .cont{
                width: 800px;
                padding: 20px;
                background-color: white;
            }
            td {
                vertical-align: top;
            }
        </style>
    </head>

    <body>
        <div class="cont">
            <header>
                <img src="./images/logo.png" alt="Логотип сайта" width="100" height="100">
                <h1>Источники</h1>
            </header>
            <hr>
            <nav>
                <ul>
                    <li><a href = index.html>Главная страница</a></li>
                    <li><a href = secondPage.html>Больше информации о компьютерной графике</a></li>
                    <li><a href = "form.html">Форма посетителя сайта</a></li>
                    <li><a href = source.html>Использованные источники</a></li>
                    <li><a href="6lab.php">Информация о функциях графических редакторов</a></li>
                    <li><a href="indexajax.php">Добавлление функций графических редакторов</a></li>
                    <li><a href="clientxml.html">Информация о графических редакторах</a></li>
                </ul>
            </nav>
            <hr>

            <main>
                Демонстрация технологии AJAX. Запрос post <br><br>
                <table>
                    <tr>
                        <td>Редактор</td>
                        <td>Функционал</td>
                        <td>Описание</td>
                        <td>Тип</td>

                    </tr>
                    <tr>

                        <td>
                            <?php
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

                                /* Посылаем запрос серверу */
                                if ($result = mysqli_query($link, 'SELECT ID, Name FROM redactors')) {
                                        echo "<select name='redactor'>";
                                    /* Выборка результатов запроса */
                                    while( $row = mysqli_fetch_assoc($result) ){
                                        printf("<option value='%s'>%s</option>", $row['ID'], $row['Name']);
                                    }
                                    echo "</select>";
                                    /* Освобождаем используемую память */
                                    mysqli_free_result($result);
                                }

                            ?>
                        </td>
                        <td><input type="text" name="functionality" value="3D моделирование"> </td>
                        <td><textarea cols="40" rows="3" type="text" name="description" value="Создание 3D моделей"></textarea> </td>
                        <td><input type="text" name="type" value="Основная"> </td>
                    </tr>
                </table>
                <br>
                <br>
                <input type="button" value="Послать запрос на сервер" onclick="Load()"/>
                <br><br>

                <?php
                    echo "<div id=\"content\">";
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
                    echo "</div>";
                ?>

            </main>
            <hr>
            <footer>
                <p>Компьютерная графика 2024</p>
                <address>
                    По вопросам писать: <a href="mailto:pr@guap.ru">pr@guap.ru</a><br>
                </address>
            </footer>
        </div>
    </body>
</html>