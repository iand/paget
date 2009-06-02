<?php
require_once MORIARTY_DIR . 'store.class.php';

class PAGET_StoreDescribeGenerator {
  var $_store_uri;
  var $_type;
  
  function __construct($store_uri, $type = 'cbd') {
    $this->_store_uri = $store_uri;
    $this->_type = $type;
  }
  
  function add_triples($resource_uri, &$desc) {
    $store = new Store($this->_store_uri);
    $response = $store->describe($resource_uri, $this->_type, 'json');
    if ($response->is_success()) {
      $desc->add_json($response->body);
    }
  }

}
