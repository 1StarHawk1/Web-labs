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

                var params = 'redactor=' + sRedactor + '&functionality=' + sFunctionality + '&description=' + sDescription + '&type=' + sType;

                req.open("POST", "myajaxprimer.php", true);
                req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                req.send(params); // посылаем запрос серверу
            }
            function receive() { // получение данных от сервера
                if (req.readyState == 4){ // если запрос завершен
                    if (req.status == 200) { // если запрос завершен без ошибок
                        document.getElementById('content').innerHTML = req.responseText;
                    }
                    else {
                        alert('Ошибка '+ req.status+': \n' + req.statustext);
                    }}}
        </script>
    </head>

    <body>
        Демонстрация технологии AJAX. Запрос get <br><br>
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

                        /* Закрываем соединение */
                        mysqli_close($link);
                    ?>
                </td>
                <td><input type="text" name="functionality" value="3D моделирование"> </td>
                <td><input type="text" name="description" value="Создание 3D моделей"> </td>
                <td><input type="text" name="type" value="Основная"> </td>
            </tr>
        </table>
        <br>
        <br>
        <input type="button" value="Послать запрос на сервер" onclick="Load()"/>
        <br><br>
        <div id='content' style="color:#ff0000">здесь будет ответ сервера</div>
    </body>
</html>