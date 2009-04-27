<?php
require_once MORIARTY_DIR . 'store.class.php';


/// Gets history of changesets for a resource
class PAGET_StoreHistoryGenerator {
  var $_store_uri;
  
  function __construct($store_uri) {
    $this->_store_uri = $store_uri;
  }
  
  function add_triples($resource_uri, &$desc) {

    $cs_query =  "prefix cs: <http://purl.org/vocab/changeset/schema#>
                  describe ?cs ?a ?r
                  where {
                    ?cs cs:subjectOfChange <" . $resource_uri . "> .
                    optional { ?cs cs:addition ?a }
                    optional { ?cs cs:removal ?r }
                  }";
 
    $store = new Store($this->_store_uri);
    $sparql = $store->get_sparql_service();

    $response = $sparql->graph($cs_query);
    if ($response->is_success()) {
      $desc->add_rdfxml($response->body);
    }
  }

}
