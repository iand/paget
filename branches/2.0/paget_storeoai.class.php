<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_resourcedescription.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_simplepropertylabeller.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_storedescribegenerator.class.php';
require_once MORIARTY_DIR . 'store.class.php';
require_once MORIARTY_DIR . 'credentials.class.php';

class PAGET_StoreOAI extends PAGET_ResourceDescription {   
  var $_store_uri;
  var $_token;
  var $_base_uri;
  
  function __construct($desc_uri, $type, $store_uri, $token = null) {
    $this->_store_uri = $store_uri; 
    $this->_token = $token; 


    $store = new Store($this->_store_uri);
    $oai = $store->get_oai_service();

    $parts = parse_url($desc_uri);
    $this->_base_uri = $parts['scheme'] . '://' . $parts['host'];
    if ( preg_match('~^(.+)\.(.+)$~', $parts['path'], $m)) {
      $this->_base_uri .= $m[1];
    }
    else {
      $this->_base_uri .= $parts['path'];
    }
    $resource_uri = $this->_base_uri;
    if (strlen($parts['query']) > 0) $resource_uri .= '?' . $parts['query']; 

    parent::__construct($desc_uri, $resource_uri, $type);
  }

  function read_triples() {
    $this->add_literal_triple($this->get_primary_resource_uri(), RDFS_LABEL, "Browse Resources");
    $this->add_literal_triple($this->get_primary_resource_uri(), RDFS_COMMENT, "This is one page of a browseable list of all resources in this dataset.");

    $store = new Store($this->_store_uri, new Credentials(AUTH_USER, AUTH_PWD));
    $oai = $store->get_oai_service();
    $response = $oai->list_records($this->_token);
    if ($response->is_success()) {
      $res = $oai->parse_oai_xml($response->body);

      $this->add_resource_triple($this->get_primary_resource_uri(), RDFS_SEEALSO, $this->_base_uri . '?token=' . urlencode($res['token']));
      
      $items_uri = 'urn:uuid:' . md5(uniqid());
      $this->add_resource_triple($this->get_primary_resource_uri(), 'http://purl.org/rss/1.0/items', $items_uri);
      $this->add_resource_triple($items_uri, RDF_TYPE, 'http://www.w3.org/1999/02/22-rdf-syntax-ns#Seq');
      $index = 1;
      foreach ($res['items'] as $item) {
        $this->add_resource_triple($items_uri, 'http://www.w3.org/1999/02/22-rdf-syntax-ns#_' . $index++ , $item['uri']);
      }
    }
    $this->add_representation_triples();  

  }

  
}
