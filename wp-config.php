<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'db_blog');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '(AJ?!|JiXS(|.8{gSP:DQ?QkoywtNN4}aE5a})RN^jWL02 Q5V+s[vn:Oe0^tYV{');
define('SECURE_AUTH_KEY',  't|%4eu?+o3&TgSrU6Ox5`bWq+uRZHU|+iLc8|#JK6}RM<g)n@_u!rC)}[@2CcIQv');
define('LOGGED_IN_KEY',    'xG}ze<-AB+a> ;FszM^%flBJ+fe%)._52~HYN8U:V|`5H`oK:p+!tQ!L5wy#NpoI');
define('NONCE_KEY',        '%Z8u8Zjf nbgM*q3TFDYD%cQB?e2(]2Rys~4t8v<BSb>g<p rYfhz>-#*Ioi#U%2');
define('AUTH_SALT',        'og@qsJa+]t)n2KG|g{Ttk)+ >-xuVh#C~mD*RY wB17YXVd2t] zi&B&I&DlPsiX');
define('SECURE_AUTH_SALT', 'EwYm!:YA1@Q%E&-c-d-tg:^a-loV}m&TWhQzNGS6@G_>|8g(?=yM|23w9LfQ>vKZ');
define('LOGGED_IN_SALT',   '`}?2 -+-nFFMA#{C?eSv~Um*?d7x0Q^3?(Je/(.J=Z[=afEGbeAe -Rl2W2|X!zL');
define('NONCE_SALT',       '&6wUJ^-{Yq-q+{o%NZ<J;tkJ-mL]Nfs=UP~gmOgB21.1>kT8q*79]Q|Q>ur_^7$=');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 * 
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
