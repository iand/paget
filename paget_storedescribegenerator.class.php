<?php
require_once MORIARTY_DIR . 'store.class.php';

class PAGET_StoreDescribeGenerator {
  var $_store_uri;
  
  function __construct($store_uri) {
    $this->_store_uri = $store_uri;
  }
  
  function add_triples($resource_uri, &$desc) {
    $store = new Store($this->_store_uri);
    $response = $store->describe($resource_uri);
    if ($response->is_success()) {
      $desc->add_rdfxml($response->body);
    }
  }

}
