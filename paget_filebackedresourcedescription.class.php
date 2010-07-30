<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_resourcedescription.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_simplepropertylabeller.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_filegenerator.class.php';

class PAGET_FileBackedResourceDescription extends PAGET_ResourceDescription {   
  var $_store_uri;
  
  function __construct($desc_uri, $resource_uri, $type, $filename, $filetype) {
    $this->_filename = $filename; 
    $this->_filetype = $filetype; 
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
    return array( new PAGET_FileGenerator($this->_filename, $this->_filetype) );
  }
  
}
