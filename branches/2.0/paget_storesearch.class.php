<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_resourcedescription.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_simplepropertylabeller.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_storedescribegenerator.class.php';
require_once MORIARTY_DIR . 'store.class.php';

class PAGET_StoreSearch extends PAGET_ResourceDescription {   
  var $_store_uri;
  var $_query;
  
  function __construct($desc_uri, $type, $store_uri, $query, $max=30, $offset=0) {
    $this->_store_uri = $store_uri; 
    $this->_query = $query; 
    $this->_max = $max; 
    $this->_offset = $offset; 

    $store = new Store($this->_store_uri);
    $cb = $store->get_contentbox();
    $resource_uri = $cb->make_search_uri($this->_query, $this->_max, $this->_offset);
    parent::__construct($desc_uri, $resource_uri, $type);
  }

  function read_triples() {
    $store = new Store($this->_store_uri);
    $cb = $store->get_contentbox();
    $response = $cb->search($this->_query, $this->_max, $this->_offset);
    if ($response->is_success()) {
      $this->add_rdfxml($response->body);
    }
    $this->add_representation_triples();  

  }

  
}
