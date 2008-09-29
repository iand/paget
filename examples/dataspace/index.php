<?php
define('PLACETIME_DIR', '/home/iand/web/placetime.com/www/htdocs/technical/src/');
define('PAGET_DIR', '/home/iand/wip/paget/');
define('MORIARTY_DIR', '/home/iand/wip/moriarty/');
define('MORIARTY_ARC_DIR', '/home/iand/web/vocab.org/open/php/lib/arc_2008_08_04/');

if (!defined('MORIARTY_HTTP_CACHE_DIR')  && file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.'cache')) {
  define('MORIARTY_HTTP_CACHE_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR.'cache');
}
define('MORIARTY_HTTP_CACHE_READ_ONLY', TRUE);
define('MORIARTY_HTTP_CACHE_USE_STALE_ON_FAILURE', TRUE ); // use a cached response if network fails

require_once PAGET_DIR . 'paget_storedescribegenerator.class.php';
require_once PAGET_DIR . 'paget_dispatcher.class.php';


$config = array();
$config['page_title_suffix'] = '';
$config['store'] = 'http://api.talis.com/stores/iand';
$config['resources'] = array();
$config['resources'][] = array( 'path' => '^/id/(.+)$', 
                                'generators' => array('PAGET_StoreDescribeGenerator'), 
                                 );

$dispatcher = new PAGET_Dispatcher($config);
$dispatcher->dispatch();


?>
