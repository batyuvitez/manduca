<?php
/** 
 * A WordPress fő konfigurációs állománya
 *
 * Ebben a fájlban a következő beállításokat lehet megtenni: MySQL beállítások
 * tábla előtagok, titkos kulcsok, a WordPress nyelve, és ABSPATH.
 * További információ a fájl lehetséges opcióiról angolul itt található:
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php} 
 *  A MySQL beállításokat a szolgáltatónktól kell kérni.
 *
 * Ebből a fájlból készül el a telepítési folyamat közben a wp-config.php
 * állomány. Nem kötelező a webes telepítés használata, elegendő átnevezni 
 * "wp-config.php" névre, és kitölteni az értékeket.
 *
 * @package WordPress
 */

  define('WP_HOME', 'http://kronika.edelenyizsolt.hu');
define('WP_SITEURL', 'http://kronika.edelenyizsolt.hu');


// ** MySQL beállítások - Ezeket a szolgálatótól lehet beszerezni ** //
/** Adatbázis neve */
define('DB_NAME', 'edelenyi_kronika');

/** MySQL felhasználónév */
define('DB_USER', 'edelenyi_kronika');

/** MySQL jelszó. */
define('DB_PASSWORD', 'cPW71-f3');

/** MySQL  kiszolgáló neve */
define('DB_HOST', 'localhost');

/** Az adatbázis karakter kódolása */
define('DB_CHARSET', 'utf8mb4');

/** Az adatbázis egybevetése */
define('DB_COLLATE', '');

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');

/**#@+
 * Bejelentkezést tikosító kulcsok
 *
 * Változtassuk meg a lenti konstansok értékét egy-egy tetszóleges mondatra.
 * Generálhatunk is ilyen kulcsokat a {@link http://api.wordpress.org/secret-key/1.1/ WordPress.org titkos kulcs szolgáltatásával}
 * Ezeknek a kulcsoknak a módosításával bármikor kiléptethető az összes bejelentkezett felhasználó az oldalról. 
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'y@ryT/O!GGE(&Yd-1~P9=*kA}CpT~.ml36[bMp>ZqI76;KZ`p}hKxfUjKvaz O:y');
define('SECURE_AUTH_KEY', 'hho:_7d|DoM*;uCFi#5IS.2?ayAj8D-lSQ;T0:B}]iZnplbda|xP8h}ue5e:6fy/');
define('LOGGED_IN_KEY', 'vr?6oeRMyGd`2T.;|k^w}iR`xUO$_qE+1OtToV`b5ZXHMv4`ew(B:fb9?.oZ%!6u');
define('NONCE_KEY', 'z{aC2H0V~#]aju|eCpXb9X,x&F(-2SKqyt.04pA,;7?8/<WZ[BKhE7S%1[[Xdm:L');
define('AUTH_SALT',        'K44SII?hg.h`iC/lo-]CH@2yz2jg[A7Ia%qJ?%l }?YzHl`g,OI9t.:Lw }uEF6F');
define('SECURE_AUTH_SALT', '.VBkq/Z$iFCyXut#_IeZL/.:22.%WHUBfDCZmKAvr,E5R__3~f^*?Ji%kY3=r3|v');
define('LOGGED_IN_SALT',   'J}rc8*<C*%p+gRlD;/3;)Ib5d[4IOmv<d8~ie>:SB/Nz~bI#gB?l)ARWf^up86Ut');
define('NONCE_SALT',       ':e ,=}(wtdh)X{O[,g[TTf?hSF.3GL|YvLW]J}lt`S<oV`4ljlkiy}6[D/L%#.qF');

/**#@-*/

/**
 * WordPress-adatbázis tábla előtag.
 *
 * Több blogot is telepíthetünk egy adatbázisba, ha valamennyinek egyedi
 * előtagot adunk. Csak számokat, betűket és alulvonásokat adhatunk meg.
 */
$table_prefix  = 'kron_';

/**
 * Fejlesztőknek: WordPress hibakereső mód.
 *
 * Engedélyezzük ezt a megjegyzések megjelenítéséhez a fejlesztés során. 
 * Erősen ajánlott, hogy a bővítmény- és sablonfejlesztők használják a WP_DEBUG
 * konstansot.
 */
define('WP_DEBUG', false);

/* Ennyi volt, kellemes blogolást! */

/** A WordPress könyvtár abszolút elérési útja. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Betöltjük a WordPress változókat és szükséges fájlokat. */
require_once(ABSPATH . 'wp-settings.php');
