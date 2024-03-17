import os, sys
from http.server import HTTPServer, CGIHTTPRequestHandler
webdir = '..' # каталог с файлами HTML и подкаталогом cgibin для сценариев
port = 80 # http://servername/ если 80, иначе http://servername:xxxx/
if len(sys.argv) > 1: webdir = sys.argv[1] # аргументы командной строки
if len(sys.argv) > 2: port = int(sys.argv[2]) # иначе по умолчанию ., 80
print('webdir "%s", port %s' % (webdir, port))
os.chdir(webdir) # перейти в корневой вебкаталог
srvraddr = ('', port) # имя хоста, номер порта
srvrobj = HTTPServer(srvraddr, CGIHTTPRequestHandler)
srvrobj.serve_forever() # обслуживать клиентов до завершения