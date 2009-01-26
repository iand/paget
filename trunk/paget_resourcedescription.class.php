<?php
require_once MORIARTY_DIR . 'simplegraph.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_response.class.php';
class PAGET_ResourceDescription extends SimpleGraph {   
  var $_uri;
  var $_primary_resource;
  var $_is_valid;
  var $_media_types = array(
                          'rdf' => array('type' => 'application/rdf+xml', 'label' => 'RDF/XML'), 
                          'html' => array('type' => 'text/html',  'label' => 'HTML'),
                          'xml' => array('type' => 'application/xml',  'label' => 'XML'),
                          'json' => array('type' => 'application/json',  'label' => 'JSON'),
                          'turtle' => array('type' => 'text/plain', 'label' => 'Turtle'),
                      );  
  function __construct($uri) {
    $this->_uri = $uri;


    if ( preg_match('~\.(html|rdf|xml|turtle|json)$~', $this->_uri, $m) ) {
      $this->_media_type = $this->_media_types[$m[1]]['type'];
    }
    else {
      $this->_media_type = $this->_media_types['rdf'];
    }

    $this->read_triples();

  } 
  
  function get_media_type() {
    return $this->_media_type;  
  }

  function get_prefix_mappings() {
    return array_flip($this->_ns);  
  }

  function is_valid() {
    return $this->_is_valid;
  }

  function read_triples() {
    $resources = $this->get_resources();
    $this->_primary_resource = $this->_uri;
    if (count($resources) > 0) {
      $this->_primary_resource = $resources[0];
    }
    
    $this->add_resource_triple( $this->_uri, RDF_TYPE, FOAF_DOCUMENT );
    $this->add_resource_triple( $this->_uri, RDF_TYPE, 'http://purl.org/dc/dcmitype/Text' );
    $this->add_resource_triple( $this->_uri, FOAF_PRIMARYTOPIC, $this->_primary_resource );

    foreach ($this->_media_types as $extension => $type_info) {
      if ( $type_info['type'] != $this->_media_type) {
        $this->add_resource_triple( $this->_uri, 'http://purl.org/dc/terms/hasFormat', $this->map_uri($this->_primary_resource) . '.' . $extension );
        $this->add_resource_triple( $this->map_uri($this->_primary_resource) . '.' . $extension, RDF_TYPE, 'http://purl.org/dc/dcmitype/Text' );
        $this->add_resource_triple( $this->map_uri($this->_primary_resource) . '.' . $extension, RDF_TYPE, FOAF_DOCUMENT );
        $this->add_literal_triple( $this->map_uri($this->_primary_resource) . '.' . $extension , 'http://purl.org/dc/elements/1.1/format', $type_info['type'] );
        $this->add_literal_triple( $this->map_uri($this->_primary_resource) . '.' . $extension , RDFS_LABEL, $type_info['label'] );
      }
    }
    
    
    $this->_is_valid = false;
    foreach ($resources as $resource_uri) {
      $this->add_resource_triple( $this->_uri, FOAF_TOPIC, $resource_uri );

      $generators = $this->get_generators();
      foreach ($generators as $generator) {
        $generator->add_triples($resource_uri, $this);  
      }
      
      if ( array_key_exists($resource_uri, $this->get_index())) {
        $this->_is_valid = true;  
      }
    }

    $augmentors = $this->get_augmentors();
    foreach ($augmentors as $augmentor) {
      $augmentor->process($this);  
    }    
  }

  function get_resources() {
    $resources = array();
    if ( preg_match('~^(.+)\.(html|rdf|xml|turtle|json)$~', $this->_uri, $m) ) {
      $uri = preg_replace("~\.local/~", "/", $m[1]);
      $resources[] = $uri;  
    }
    return $resources;
  }

  
  function get_generators() {
    return  array( );
  }
  
  function get_augmentors() {
    return  array( new PAGET_SimplePropertyLabeller() );
  }
  
  function get_primary_resource_uri() {
    return $this->_primary_resource;
  }
  
  function get_uri() {
    return $this->_uri; 
  }

  function get_label() {
    $label = $this->get_first_literal($this->_primary_resource,RDFS_LABEL, '');
    if ( strlen($label) == 0) {
      $label = $this->get_first_literal($this->_primary_resource,DC_TITLE, '');
    }
    if ( strlen($label) == 0) {
      $label = $this->get_first_literal($this->_primary_resource,FOAF_NAME, '');
    }
    if ( strlen($label) == 0) {
      $label = $this->_primary_resource;
    }    
   
    return $label;
  }
  
  function get(&$urispace,&$request) {

    $response = new PAGET_Response(200);

    switch ($this->_media_type) {
      case 'application/xml':
      case 'application/rdf+xml':
        $response->set_body($this->to_rdfxml());
        break;
      case 'application/json':
        $response->set_body($this->to_json());
        break;
      case 'text/plain':
        $response->set_body($this->to_turtle());
        break;
      case 'text/html':
        $response->set_body($this->get_html($urispace, $request));
        break;
      default:    
         $response->set_body($this->to_rdfxml());
    }    
    $response->configure($this, $request);
    return $response;
  }

  function get_html(&$urispace, &$request) {
    $tmpl = $urispace->get_template($request);
    if ( null == $tmpl ) {
      $tmpl = PAGET_DIR . 'templates' .  DIRECTORY_SEPARATOR . 'plain.tmpl.html';
    }

    ob_start();
    try {
      include($tmpl);
      $buffer = ob_get_clean();
      return $buffer;
    } 
    catch (Exception $ex) {
      ob_end_clean();
      throw $ex;
    }
  }


  function get_inverse_index() {
    $g = new SimpleGraph();
    
    foreach ($this->_index as $s => $p_list) {
      foreach ($p_list as $p => $v_list) {
        foreach ($v_list as $v_info) {
          if ( $v_info['type'] == 'uri' ) {
            $g->add_resource_triple($v_info['value'], $p, $s);
          } 
        }
      }
    }
    
    return $g->get_index();
    
  }
  
  function consume_first_literal($s, $p, $def = '') {
    return $this->get_first_literal($s, $p, $def);
  }
  
  
  // This function maps a URI to a local equivalent
  // Override this when you want the link in your HTML output to point to somewhere other than the URI itself, e.g. a proxy
  // The default implementation rewrites URIs to the domain name suffixed with .local for assisting with testing
  // For example http://example.com/foo might map to http://example.com.local/foo if the application is being accessed from example.com.local
  function map_uri($uri) {
    if (isset($_SERVER["HTTP_HOST"])) {
      if (preg_match('~http://([^/]+)/~i', $uri, $m)) {
        if ( $_SERVER["HTTP_HOST"] == $m[1] . '.local' ) {
          return str_replace($m[1], $_SERVER["HTTP_HOST"], $uri);
        }
        else {
          return $uri;
        }
      }
    }
  }

}
