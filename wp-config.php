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
define('AUTH_KEY',         'YH9V:B3Ocs.Q r]>|:X+O`YmaeI~[+cWMy-}8-kd5+0p@m|Z6{34zA{8Q&jB|~A=');
define('SECURE_AUTH_KEY',  '>r^~z$%fs)}[4Zkd8Ux-df)#{&3+mgtj7=y5b![e|Q$^(LVc,Z-jx>Y8q|#$-O|1');
define('LOGGED_IN_KEY',    'f;lz |<Ha-aX]kYM;&+Of~AS|ZD(KHAOvhSZy+D|@/X|KdU^3Z<|g[,-S`[_P#`.');
define('NONCE_KEY',        'TM_oLbX;r,:2W,E7~F#0;e!,WVz<G^{x_VNCZwN}qHR*c4v}]9laLXb(^?OG.uKZ');
define('AUTH_SALT',        ' ;; i&iHa/TRjR&7W=_b:dJ]8G-or1c-p6*<5C^+*!j8c  hw:hrgZcaB)kO(zDr');
define('SECURE_AUTH_SALT', ',R`-1V_72 db[)] 15/a6?OI<UoG#aKr|;:aFLTwqYk^.Zk@t60`_ Y|G_Tt$@TV');
define('LOGGED_IN_SALT',   'Asa!x3ELJR|4u}M-SV|iNs?X?+|,gA>F&2iG`nl sT7vFQ7RZeiYsT72yj&.}HcJ');
define('NONCE_SALT',       'n-dr;56$?FtQn8D7r:qy>(1:-^7-Kk<h%vjudNX: ![~.0BN8u;9k_mw:|c4^QAC');

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
