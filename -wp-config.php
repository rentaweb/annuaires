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
define('DB_NAME', 'mysql');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '#|P3-!b?<&n^mLtfBDvh&Q_{$RFez[EoP2Dr*xJ@j]E?Q8SLvtl$cC*/Z O%uo#(');
define('SECURE_AUTH_KEY',  'M8?`e]xO>e_V cYg~W<<T;LsVBDm0Osn4T}dafDa}(diOC0eM<s%uMW7S.>[IL]q');
define('LOGGED_IN_KEY',    'N$VbOi4@w]_k9l%e7CF<sO*(^X&M9v(UAQw~`t>5Rmv-K.rz(@uJe]G|}kQhZ9=t');
define('NONCE_KEY',        'n`AL/qsT[_;ZZV@yMk/Abw9lnS0$N??N#BSzK;Fg!Ph|9U./c3[D &XBVlUF=@W(');
define('AUTH_SALT',        'g$syF_qM{+Wl8!ZgnESKpqKG(a&>6u9~dLL)7K 8EZ[#~P7b^69N^9]`5mZDc)5z');
define('SECURE_AUTH_SALT', ' ]e>8XpiQmGL?tRY)k/.}H+d|oDLq2RseCFWxE%`waAxTzvx@#sM7IV8<#QP5 df');
define('LOGGED_IN_SALT',   '0V;<g1+E04=G<MTIzaD80?,moI#+or~&<A+L&/ur[W93smg6WC<e~HH/]Xs{H0Ri');
define('NONCE_SALT',       '>Jy{gOL8Ztx^K2]3.]Z0J2IYeL)#Rhy*N7%GM| l)&OJ2QFAz+r{-kiJke;^0Eg2');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'cuisine_';

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