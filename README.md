## Descarga e instala la última versión de XAMMP para Windows
https://www.apachefriends.org/es/index.html
- En Select Components, selecciona todos.
- En ruta de instalación, selecciona C:/web/xampp (debes crear la carpeta web)
- Después de instalarlo, crea la carpeta sitios dentro de web. Ahí dentro guardaremos la copia del repositorio
- Para comprobar que funciona, abre XAMPP desde el icono correspondiente, abre los servicios de Apache y MySQL y en tu navegador accede a localhost. Si entra, enhorabuena.

## Descarga la última versión de xdebug
- Antes, entra en http://localhost/dashboard/phpinfo.php desde tu navegador, y fíjate en el dato PHP Extension Build. Al final aparecerá la versión que tienes de PHP (que tiene que ser VS16, fíjate si a la izquierda pone también TS)
- Ahora descárgate la dll aquí
https://xdebug.org/download
Busca la versión de Windows más avanzada de la versión que tienes y si tiene TS.
- Copiar el archivo dll descargado en C:\web\xampp\php\ext y dejar el nombre como php_xdebug.dll
- Ahora ve al documento C:\web\xampp\php\php.ini y al final del mismo escribe las siguientes lineas:
[xdebug]
xdebug.remote_enable=1
xdebug.remote_host="127.0.0.1"
xdebug.remote_port=9000
xdebug.remote_handler="dbgp"
zend_extension ="C:\web\xampp\php\ext\php_xdebug.dll"
- Reinicia el servidor apache. Si todo sale bien, al ir a http://localhost/dashboard/phpinfo.php aparecerá un banner que dice que hacemos uso del Zend Engine.

## Descarga el plugin PHP Debug para Visual Studio Code
Permite depurar código en PHP. Para configurarlo:
- Ve al documento C:\web\xampp\php\php.ini y al final del mismo escribe las siguientes lineas:
	xdebug.mode = debug
	xdebug.start_with_request = yes
	xdebug.client_port = 9003
- En Visual Studio Code, ve a esta ruta ⮕ C:\Users\[tu user]\AppData\Roaming\Code\User\settings.json. Escribe esto en las variables correspondientes:
"php.validate.executablePath": "C:\\web\\xampp\\php\\php.exe"
"php.debug.executablePath": "C:\\web\\xampp\\php\\php.exe"  


## Configurar los sitios virtuales
- Ve al archivo C:\Windows\System32\drivers\etc\hosts y añade las siguientes lineas
127.0.0.1 www.safeplace.com
127.0.0.1 www.spmanager.com

- Ve al archivo Archivo C:\web\xampp\apache\conf\extra\httpd-vhosts.conf y escribe el siguiente código:

<VirtualHost *:80>
	 DocumentRoot "C:\web\xampp\htdocs"
	 ServerName localhost
</VirtualHost>

<VirtualHost *:80>
	 DocumentRoot "C:\web\sitios\00-safeplace"
	 ServerName www.safeplace.com
	 <Directory "C:\web\sitios\00-safeplace">
		 Options FollowSymLinks
		 AllowOverride All
		 Order allow,deny
		 Allow from all
		 Require all granted
	 </Directory>
</VirtualHost>

<VirtualHost *:80>
	 DocumentRoot "C:\web\sitios\00-spmanager"
	 ServerName www.spmanager.com
	 <Directory "C:\web\sitios\00-spmanager">
		 Options FollowSymLinks
		 AllowOverride All
		 Order allow,deny
		 Allow from all
		 Require all granted
	 </Directory>
</VirtualHost>
