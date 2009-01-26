<?php
if (!defined('STORE_URI')) define('STORE_URI', 'http://api.talis.com/stores/iand');
define('LIB_DIR', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/lib/');
define('PAGET_DIR', LIB_DIR . 'paget' . DIRECTORY_SEPARATOR);
define('MORIARTY_DIR', LIB_DIR . 'moriarty' . DIRECTORY_SEPARATOR);
define('MORIARTY_ARC_DIR', LIB_DIR . 'arc_2008_08_04' . DIRECTORY_SEPARATOR);

if (!defined('MORIARTY_HTTP_CACHE_DIR')  && file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.'cache')) {
  define('MORIARTY_HTTP_CACHE_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR.'cache');
}
define('MORIARTY_HTTP_CACHE_READ_ONLY', TRUE);
define('MORIARTY_HTTP_CACHE_USE_STALE_ON_FAILURE', TRUE ); // use a cached response if network fails

require_once PAGET_DIR . 'paget_urispace.class.php';
require_once PAGET_DIR . 'paget_simplepropertylabeller.class.php';
require_once PAGET_DIR . 'paget_storedescribegenerator.class.php';



class StoreBackedUriSpace extends PAGET_UriSpace {
  function get_description($uri) {
    return new StoreBackedResourceDescription($uri); 
  } 
}

class StoreBackedResourceDescription extends PAGET_ResourceDescription {   

  function get_generators() {
    return array( new PAGET_StoreDescribeGenerator(STORE_URI) );
  }
  
  function get_augmentors() {
    return array( new PAGET_SimplePropertyLabeller() );
  }
  
  function get_html() {
    $config = array();
    $config['rights_text'] = 'All text and data in this document are in the Public Domain.';
    $config['credits_html'] = 'Built with <a href="http://code.google.com/p/paget/">paget</a>.';
   
    $repr = new PAGET_SimpleHtmlRepresentation($config);
    $repr->emit($this);
  }
  
}


$space = new StoreBackedUriSpace();
$space->dispatch();

?>
