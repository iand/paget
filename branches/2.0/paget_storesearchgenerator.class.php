<?php
require_once MORIARTY_DIR . 'store.class.php';

class PAGET_StoreSearchGenerator {
  var $_store_uri;
  var $_query;
  
  function __construct($store_uri, $query) {
    $this->_store_uri = $store_uri;
    $this->_query = $query;
  }
  
  function add_triples($resource_uri, &$desc) {
    $store = new Store($this->_store_uri);
    $cb = $store->get_contentbox();
    $response = $cb->search($query);
    if ($response->is_success()) {
      $desc->add_rdfxml($response->body);
    }
  }

}
