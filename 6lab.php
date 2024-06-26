<?php
    echo "<html>";
    echo "<head>";
    echo "<title>Информация о графических редакторах</title>";
    echo "<link rel=\"stylesheet\" href=\"./styles/2lab.css\">";
    echo "<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>";
    echo "<script>
        $(document).ready(function() {
            $('.delete-button').click(function() {
                var id = $(this).data('id');
                var row = $(this).closest('tr');
                $.ajax({
                    url: '6lab.php',
                    type: 'DELETE',
                    data: {
                        'delete_id': id
                    },
                    success: function(response) {
                        row.remove();
                    },
                    error: function() {
                        alert('Ошибка при удалении');
                    }
                });
            });
        });
    </script>";
    echo "</head>";
    echo "<body>";
    echo "<div class=\"cont\">";
    echo "<header>
              <img src=\"./images/logo.png\" alt=\"Логотип сайта\" width=\"100\" height=\"100\">
              <h1>Источники</h1>
          </header>
          <hr>
          <nav>
              <ul>
                  <li><a href = index.html>Главная страница</a></li>
                  <li><a href = secondPage.html>Больше информации о компьютерной графике</a></li>
                  <li><a href = \"form.html\">Форма посетителя сайта</a></li>
                  <li><a href = source.html>Использованные источники</a></li>
                  <li><a href=\"6lab.php\">Информация о функциях Blender и Photoshop</a></li>
                  <li><a href=\"indexajax.php\">Добавлление функций Blender и Photoshop</a></li>
                  <li><a href=\"clientxml.html\">Информация о графических редакторах</a></li>
              </ul>
          </nav>
          <hr>
          <main>";


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

    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        parse_str(file_get_contents("php://input"),$post_vars);
        $id = $post_vars['delete_id'];

        // Удаление записи из базы
        $query = "DELETE FROM functionality WHERE ID = $id";
        mysqli_query($link, $query);
    }

    /* Посылаем запрос серверу */
    if ($result = mysqli_query($link, 'SELECT ID, Name, Last_version, Developer, Description FROM redactors')) {
        print("<h3>Графические редакторы:</h3>\n");
        echo "<table>
                <tr>
                    <th>Название</th>
                    <th>Последняя версия</th>
                    <th>Разработчик</th>
                    <th>Описание</th>
                </tr>";
        /* Выборка результатов запроса */
        while( $row = mysqli_fetch_assoc($result) ){
            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['Name'], $row['Last_version'], $row['Developer'], $row['Description']);
        }
        echo "</table>";
    /* Освобождаем используемую память */
        mysqli_free_result($result);
    }

    if ($result = mysqli_query($link, 'SELECT functionality.id as id_fun, functionality.Name, functionality.Description, Type, redactors.name as redactors_name FROM functionality left join redactors
                                        on functionality.redactor_id = redactors.id')) {
            print("<h3>Функции редактора:</h3>\n");
            echo "<table>
                    <tr>
                        <th>Функция</th>
                        <th>Описание</th>
                        <th>Тип</th>
                        <th>Наименование редактора</th>
                        <th>Действие</th>
                    </tr>";
            /* Выборка результатов запроса */
            while( $row = mysqli_fetch_assoc($result) ){
                printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><button class='delete-button' data-id='%s'>Удалить</button></td></tr>",
                    $row['Name'], $row['Description'], $row['Type'], $row['redactors_name'], $row['id_fun']);

                //printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><a href='6lab.php?delete_id=%s'>Удалить</a></td></tr>",
                //                $row['Name'], $row['Description'], $row['Type'], $row['redactors_name'], $row['id_fun']);
            }
            echo "</table>";
        /* Освобождаем используемую память */
            mysqli_free_result($result);
        }
    /* Закрываем соединение */
    mysqli_close($link);

    echo "</main>";
    echo "<hr>
          <footer>
              <p>Компьютерная графика 2024</p>
              <address>
                  По вопросам писать: <a href=\"mailto:pr@guap.ru\">pr@guap.ru</a><br>
              </address>
          </footer>";

    echo "</div>";
    echo "</body>";
    echo "</html>";
?>