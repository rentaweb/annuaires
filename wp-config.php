<?php
/**
* La configuration de base de votre installation WordPress.
*
* Ce fichier contient les réglages de configuration suivants : réglages MySQL,
* préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
* Vous pouvez en savoir plus à leur sujet en allant sur
* {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
* wp-config.php}. C'est votre hébergeur qui doit vous donner vos
* codes MySQL.
*
* Ce fichier est utilisé par le script de création de wp-config.php pendant
* le processus d'installation. Vous n'avez pas à utiliser le site web, vous
* pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
* valeurs.
*
* @package WordPress
*/

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', '');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', '');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', '');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données.
* N'y touchez que si vous savez ce que vous faites.
*/
define('DB_COLLATE', '');

/**#@+
* Clefs uniques d'authentification et salage.
*
* Remplacez les valeurs par défaut par des phrases uniques !
* Vous pouvez générer des phrases aléatoires en utilisant
* {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
* Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
* Cela forcera également tous les utilisateurs à se reconnecter.
*
* @since 2.6.0
*/
define('AUTH_KEY',         'i=EyF,a9_!@+:J?mL8<g<gC;m;w; -C6)+=#6TwS~9L*)D|ZT||GRJ8fSP=3GEHH');
define('SECURE_AUTH_KEY',  'S^@!30obA.A^|:|fWK|hOY;w5=nbX;K;xUK;)oECBD.?M[K?m-QR+59k*T|9$5A|');
define('LOGGED_IN_KEY',    ':scD<d5tw!+cl9HRzTDsxP-P7p-E.xp@h$f%~u 7d9Q@IY6:EjfP:u|tmad1NDm/');
define('NONCE_KEY',        'eziagm!iN<@4 !FElVnhw&%Bmy<.QLuH_=9{Dqlbe@m(:-v;&];06?Qs~0h ra<]');
define('AUTH_SALT',        'm]qp>|P660j;o4rQYA-9*Bf~5H/}*}3.F3d1F3ik*L9%5QJD+u!}sr+UWl9Le>Xh');
define('SECURE_AUTH_SALT', '6h{D6q>{|$B?O,5vKx(vsg+q#nWW[tS1Y9B!hCWQsqa{XqK/ @{8V:<S-+.!R-7Q');
define('LOGGED_IN_SALT',   ')Y_!8Wl/`<v%3?EX$*TFv.V|d#uwsZm|1kzcy#4iir]LK4H]G!`;(q3*C4F!)|nd');
define('NONCE_SALT',       '`5T}>QI7FUCI&GN]XY|&I9 uE0Ya^T[=JAIbkb6|Fi?8iMhfXyD`-j%VH>2pd<ec');
/**#@-*/

/**
* Préfixe de base de données pour les tables de WordPress.
*
* Vous pouvez installer plusieurs WordPress sur une seule base de données
* si vous leur donnez chacune un préfixe unique.
* N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
*/
$table_prefix  = 'imp_';

/**
* Langue de localisation de WordPress, par défaut en Anglais.
*
* Modifiez cette valeur pour localiser WordPress. Un fichier MO correspondant
* au langage choisi doit être installé dans le dossier wp-content/languages.
* Par exemple, pour mettre en place une traduction française, mettez le fichier
* fr_FR.mo dans wp-content/languages, et réglez l'option ci-dessous à "fr_FR".
*/
define('WPLANG', 'fr_FR');

/**
* Pour les développeurs : le mode deboguage de WordPress.
*
* En passant la valeur suivante à "true", vous activez l'affichage des
* notifications d'erreurs pendant votre essais.
* Il est fortemment recommandé que les développeurs d'extensions et
* de thèmes se servent de WP_DEBUG dans leur environnement de
* développement.
*/
define('WP_DEBUG', false);

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
