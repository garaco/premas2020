<?php
defined('BASEPATH')or exit ('ERROR403');

define('URI', $_SERVER['REQUEST_URI']);

define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);

define('FOLDER_PATH', '/premas');

define('ROOT', $_SERVER['DOCUMENT_ROOT']);

$dir = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$explode = explode("/", $dir);
$url = "http://{$explode[0]}/{$explode[1]}/public";
define('PATH_PUBLIC', $url);

define('PATH_VIEWS', FOLDER_PATH . '/app/Views/');

define('SIDERBAR', ROOT . FOLDER_PATH  . '/app/Views/Siderbar.php');

define('SCRIPTS', ROOT . FOLDER_PATH  . '/app/Views/scripts.php');

define('PATH_CONTROLLERS', 'app/Controllers/');

define('PATH_REQUEST', 'app/Request/');

define('PATH_MODELS', 'app/Models/');

define('PATH_FILES', 'app/FilesPDF/');

define('PATH_MANUAL', 'app/Manuales/');

define('HELPER_PATH', 'system/Helpers/');

define('LIBS_ROUTE', ROOT . FOLDER_PATH . '/system/Libs/');

define('REQUEST', ROOT . FOLDER_PATH . '/app/Request/');

define('EXECUTOR', ROOT . FOLDER_PATH . '/system/Core/Executor.php');

define('BACKUP_PATH', ROOT . FOLDER_PATH . '/system/Core/backup.php');


define('CORE', 'system/Core/');
define('DEFAULT_CONTROLLER', 'Login');

define('ERROR_REPORTING_LEVEL', -1);

//hora actual global
ini_set('date.timezone','America/Mexico_city');
$date=date('Y-m-d',time());
define('DATE', $date);

// mes actual
    // $arrayMes = array('Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
    $arrayMes = 'Ene|Feb|Mar|Abr|May|Jun|Jul|Ago|Sep|Oct|Nov|Dic';
    
    $anio_actual = strtotime(DATE);
    $mes = date('m',$anio_actual);
    $m = ($mes == 10) ? $mes: str_replace('0','', $mes);
    $nameMes= explode('|',$arrayMes);
    $mesF = $nameMes[$m-1];
    define('MES',$mesF);
    define('ArrayMes', $arrayMes);