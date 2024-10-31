=== Q2W3 Yandex Speller ===
Contributors: Max Bond
Tags: post, comments, tinymce, spellchecker, yandex speller, russian spelling, ukrainian spelling
Requires at least: 3.6
Tested up to: 3.6
Stable tag: trunk

This plugin enables Russian, Ukrainian and English spelling for standard TinyMCE editor.

== Description ==

This plugin enables Russian, Ukrainian and English spelling for standard TinyMCE editor.  

Плагин заменяет стандартный набор языков для спел-чекера TinyMCE. 
После установки для проверки правописания будут доступны 3 языка: русский, украинский и английский (см. скриншот).
С версии 1.0 доступна опция проверки правописания при написании комментариев.

Плагин использует сервис проверки правописания Яндекс.Спеллер

Известные проблемы:
1. Если в проверяемом тексте содержится отформатированный текст (`<pre>`), то включение проверки правописания сбивает форматирование.

Из-за этих проблем рекомендую производить проверку правописания после написания всего поста. 
Сохранять пост после проверки только, когда вы убедились, что форматирование не испорчено.

== Installation ==

1. Проверить системные требования: веб-сервер Apache с модулями proxy_module и proxy_http_module, файл .htaccess в корневой директории WordPress доступен для чтения и записи.  
2. Разархивировать и загрузить папку `q2w3-yandex-speller` на сервер в директорию `/wp-content/plugins/`.
2. Активировать плагин в панели управления WordPress.

== Changelog ==

= 1.1 =
* Совместимость с WordPress 3.6. 

= 1.0 =
* Модификация .htaccess теперь не требуется.
* Добавлена опция отключения украинского и английского языков.
* Добавлена опция включения редактора TinyMCE с проверкой правописания для комментариев (спасибо [mk](http://wordpress.org/extend/plugins/profile/mk_is_here) и его плагину [TinyMCEComments](http://wordpress.org/extend/plugins/tinymcecomments/))

= 0.9.1 =
* Первый релиз