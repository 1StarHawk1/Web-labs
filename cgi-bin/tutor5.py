#вывод в таблицу
import cgi, sys
form = cgi.FieldStorage() # извлечь данные из формы
print("Contenttype: text/html") # плюс пустая строка
html1 = """
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таблица с анкетой</title>
    <link rel="stylesheet" href="../styles/2lab.css"> <!-- Подключение CSS стиля -->
    <style>
        td{
            width: 100px;
        }
        tr:hover{
            background-color: initial;
        }
    </style>
</head>
<body>
    <div class="cont" style="width:800px">
            <header>
                <img src="../images/logo.png" alt="Логотип сайта" width="100" height="100">
                <h1>Источники</h1>
            </header>
            <hr>
            <nav>
                <ul>
                    <li><a href = ../index.html>Главная страница</a></li>
                    <li><a href = ../secondPage.html>Больше информации о компьютерной графике</a></li>
                    <li><a href = "../form.html">Форма посетителя сайта</a></li>
                    <li><a href = ../source.html>Использованные источники</a></li>
                </ul>
            </nav>
            <hr>
            <main>
                <h1>Анкета пользователя</h1>
                <table border="2">
                    <tr>
"""
print (html1)
# печать заголовка таблицы
ll = ['Фамилия', 'Имя', 'Отчество','Вид деятельности','Знакомые типы CG', 'Предпочтительный редактор', 'Тематика анкеты']
for head in ll:
    if(head == ll[-1]):
        ss = '<td style="background-color: yellow">'+head+'</td>'
    else:
        ss = '<td>'+head+'</td>'
    print ( ss)
print ('</tr> <tr>')
data = ['secondname','firstname','patronymic','job', 'CGtype', 'redactor', 'page_theme']; i=0
for field in ('secondname','firstname','patronymic','job', 'CGtype', 'redactor', 'page_theme'):
    if not field in form:
        data[i] = '(Не указано)'
    else:
        if not isinstance(form[field], list):
            data[i] = form[field].value
        else:
            values = [x.value for x in form[field]]
            data[i] = ' \n '.join(values)
    i+=1
for el in data:
    if el == data[-1]:
        print ('<td style="background-color: yellow"> %s </td>'% el)
    else:
        print ('<td> %s </td>'% el)
print ('</tr> </table>\
       </main>\
            <hr>\
            <footer>\
                <p>Компьютерная графика 2024</p>\
                <address>\
                    По вопросам писать: <a href="mailto:pr@guap.ru">pr@guap.ru</a><br>\
                </address>\
            </footer>\
        </div>\
    </body>\
</html>')