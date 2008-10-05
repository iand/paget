<?php
require_once MORIARTY_DIR . 'store.class.php';

class PAGET_StoreDescribeGenerator {
  var $_config = array();
  var $_storename;
  
  function __construct(&$config, &$params) {
    $this->_config = $config;  
    $this->_storename = $params['store'];
  }
  
  function process(&$desc, $request) {

    $store = new Store($this->_storename);
    $mb = $store->get_metabox();
    $response = $mb->describe($desc->uri);
    if ($response->is_success()) {
      $desc->add_rdfxml($response->body);
    }
  }

}
