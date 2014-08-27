TorrentPier II
======================

TorrentPier II - движок торрент-трекера, написанный на php. Высокая скорость работы, простота модификации, устойчивость к высоким нагрузкам, в том числе и поддержка альтернативных анонсеров (например, Ocelot). Помимо этого, крайне развитый официальный форум поддержки, где помимо прочего можно испытать движок в работе на демо-версии, не устанавливая его, а также получить любую другую интересующую вас информацию и скачать моды.

## Установка

Для установки вам необходимо выполнить несколько простых шагов:

1. Распаковываем на сервер содержимое папки **upload**

2. Создаем базу данных, в которую при помощи phpmyadmin (или любого другого удобного инструмента) импортируем дамп, расположенный в папке **install/sql/mysql.sql**
3. Правим файл конфигурации **config.php**, загруженный на сервер:
> ***$bb_cfg['db']['db1'] = array('localhost', 'dbase', 'user', 'pass', $charset, $pconnect);***    
В данной строке изменяем данные входа в базу данных    
***$domain_name = 'torrentpier.me';***    
В данной строке указываем ваше доменное имя. Остальные правки в файле вносятся по усмотрению, исходя из необходимости из внесения (ориентируйтесь на описания, указанные у полей).

4. Редактируем указанные файлы:
 + **favicon.ico** (меняем на свою иконку, если есть)  
 + **robots.txt** (меняем адреса в строках **Host** и **Sitemap** на свои)
 + **opensearch_desc.xml** (меняем описание и адрес на свои)
 + **opensearch_desc_bt.xml** (меняем описание и адрес на свои)

## Права доступа на папки и файлы

Исходя из настроек вашего сервера, устанавливаем рекомендуемые права доступа (chmod) на указанные папки **777**, а на файлы внутри этих папок (кроме файлов **.htaccess** и **.keep**) **666**:
- ajax/html
- atom
- cache
- cache/filecache
- images
- images/avatars
- images/captcha
- images/ranks
- images/smiles
- log
- old_files
- old_files/thumbs
- sitemap
- triggers

## Необходимые настройки php

    mbstring.internal_encoding = UTF-8
    magic_quotes_gpc = Off
Внести данные настройки необходимо в файл **php.ini**. Их вам может установить ваш хостер по запросу, если у вас возникают какие-либо проблемы с их самостоятельной установкой. Впрочем, эти настройки могут быть установлены на сервере по-умолчанию, поэтому их внесение требуется исключительно по необходимости.

## Необходимые модули php

    php5-tidy
Начиная с версии 2.0.9 (ревизия 592 в старой нумерации) данный модуль не является обязательным, но его установка крайне рекомендуется для повышения качества обработки html-кода тем и сообщений пользователей. 

## Рекомендуемый способ запуска cron.php

Для значительного ускорения работы трекера может потребоваться отвязка встроенного форумного крона. С более подробной информацией об отвязке крона, вы можете ознакомиться в данной теме http://torrentpier.me/threads/52/ на нашем форуме поддержки.

## Полезные ссылки

+ Наш форум http://torrentpier.me/
+ Центр загрузки http://get.torrentpier.me/
+ Часто задаваемые вопросы http://faq.torrentpier.me/
+ Где задать вопрос http://torrentpier.me/forums/10/
