<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_resourcedescription.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_simplepropertylabeller.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_storedescribegenerator.class.php';

class PAGET_StoreBackedResourceDescription extends PAGET_ResourceDescription {   
  var $_store_uri;
  
  function __construct($desc_uri, $resource_uri, $type, $store_uri) {
    $this->_store_uri = $store_uri; 
    parent::__construct($desc_uri, $resource_uri, $type);
  }

  function get_augmentors() {
    if ($this->_type == 'html') {
      return  array( new PAGET_SimplePropertyLabeller()  );
    }
    else {
      return array();
    }
  }

  function get_generators() {
    return array( new PAGET_StoreDescribeGenerator($this->_store_uri, 'lcbd') );
  }
  
}
