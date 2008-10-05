<?php
// This class is the main dispatcher for Paget
require_once MORIARTY_DIR . 'moriarty.inc.php';
require_once MORIARTY_DIR . 'simplegraph.class.php';
require_once dirname(__FILE__) . '/paget_resourcedescription.class.php';
require_once dirname(__FILE__) . '/paget_simplehtmlrepresentation.class.php';
require_once dirname(__FILE__) . '/paget_request.class.php';
require_once dirname(__FILE__) . '/functions.inc.php';

class PAGET_Dispatcher {
  var $_config = array();

  function __construct(&$config) {
    $this->_config = $config;
    $this->set_default_option('rights_text', ''); // a rights statement in plain text
    $this->set_default_option('credits_html', ''); // a credits statement in html
    $this->set_default_option('page_title_suffix', ''); // the suffix appended to each page's title
    $this->set_default_option('format_delimiter', '.'); // the character used to delimit the format name from the resource uri
    $this->set_default_option('default_html_template', 'PAGET_SimpleHtmlRepresentation'); 
//    $this->set_default_option('google_analytics_code', ''); // if set the HTML view will include google analytics code
  }

  function set_default_option($name, $value) {
    if ( !isset($this->_config[$name]) )  $this->_config[$name] = $value;
  }

  function dispatch() {
    $request = new PAGET_Request($this->_config, $_SERVER["SERVER_NAME"], $_SERVER["REQUEST_URI"]);

    $mapping = NULL;
    if (isset($this->_config['resources'])) {
      $mapping = $request->select_mapping($this->_config['resources']);
    }
    
    if ( $mapping === NULL ) {
      $this->send_not_found($request);  
    }
    
    if ( $mapping['file'] ) {
      if ( file_exists($_SERVER['DOCUMENT_ROOT'] . $mapping['file']) ) {
        readfile($_SERVER['DOCUMENT_ROOT'] . $mapping['file']);
        exit;
      }
      else {
        $this->send_not_found($request);
      }
    }

    if ( $mapping['redirect'] ) {
      $this->send_redirect('302', 'Found', $mapping['redirect']);
    }

    $desc = new PAGET_ResourceDescription($this->_config, $request->resource_uri);
    if ( isset($mapping['generators'])) {
      foreach ( $mapping['generators'] as $generator_info) {
        $generator_class = $generator_info['class'];
        if ( ! class_exists($generator_class) && preg_match('~^PAGET_~', $generator_class) ) {
          require_once dirname(__FILE__) . '/' . strtolower($generator_class) . '.class.php';
        }

        $generator = new $generator_class($this->_config, $generator_info);  
        $generator->process($desc, $request);
      }
    }   
          
    if (!$desc->is_valid()) {
      $this->send_not_found($request);
    }

    if ( isset($mapping['augmentors'])) {
      foreach ( $mapping['augmentors'] as $augmentor_info) {
        $augmentor_class = $augmentor_info['class'];
        if ( ! class_exists($augmentor_class) && preg_match('~^PAGET_~', $augmentor_class) ) {
          require_once dirname(__FILE__) . '/' . strtolower($augmentor_class) . '.class.php';
        }
        $augmentor = new $augmentor_class($this->_config, $augmentor_info);  
        $augmentor->process($desc, $request);
      }
    }  


    if ( !$request->representation_type) {
      $guessed_output = 'rdf';

      if ( preg_match("~application/rdf\+xml~i", $_SERVER["HTTP_ACCEPT"]) ) {
        $guessed_output = 'rdf';
      }
      elseif ( preg_match("~text/html~i", $_SERVER["HTTP_ACCEPT"]) ) {
        $guessed_output = 'html';
      }
      elseif ( preg_match("~application/xml~i", $_SERVER["HTTP_ACCEPT"]) ) {
        $guessed_output = 'xml';
      }
      elseif ( preg_match("~application/json~i", $_SERVER["HTTP_ACCEPT"]) ) {
        $guessed_output = 'json';
      }
      elseif ( preg_match("~text/plain~i", $_SERVER["HTTP_ACCEPT"]) ) {
        $guessed_output = 'turtle';
      }   

      $this->send_redirect(303, 'See other', $request->request_uri. $this->_config['format_delimiter'] . $guessed_output);
    }

    // Augment with describing document information
    $desc->add_resource_triple( $request->request_uri, RDF_TYPE, FOAF_DOCUMENT );
    $desc->add_resource_triple( $request->request_uri, FOAF_PRIMARYTOPIC, $request->resource_uri );

    if ( strlen($this->_config['rights_text']) > 0) {
      $desc->add_literal_triple( $request->request_uri, 'http://purl.org/dc/elements/1.1/rights', $this->_config['rights_text'] );
    }

    if ( $request->representation_type === 'html') {
      header("HTTP/1.1 200 OK");

      if ( isset($mapping['template'])) {
        require_once $mapping['template'];
        
      }
      else {
        $template_class = $this->_config['default_html_template'];
        $repr = new $template_class($this->_config);
        $repr->emit($desc, $request);
      }
      exit;
    }
    elseif ( $request->representation_type === 'rdf') {
      $this->send_ok($desc->to_rdfxml(), 'application/rdf+xml');
    }         
    elseif ( $request->representation_type === 'xml') {
      $this->send_ok($desc->to_rdfxml(), 'application/xml');
    }   
    elseif ( $request->representation_type === 'turtle') {
      $this->send_ok($desc->to_turtle(), 'text/plain');
    }         
    elseif ( $request->representation_type === 'json') {
      $this->send_ok($desc->to_json(), 'text/plain');
    }                     

/*
    // No direct mapping found, try adding a slash and looking for a match
    foreach ( $resource_map as $mapping ) {
      if ( isset($mapping['path'])) {
        if (preg_match( '"' . $mapping['path'] . '"', $request->resource_path . '/')) {
          $this->send_redirect(301, 'Moved Permanently', $request->resource_uri . '/');
        }
      }
    }
*/


    $this->send_not_found($request);
  }


  function send_ok($body, $content_type) {
    header("HTTP/1.1 200 OK");
    header('Content-type: ' . $content_type);
    echo($body);     
    exit;   
  }

  function send_not_found($request) {
    $this->send_client_error(404, 'Not Found', 'The requested resource ' . $request->resource_uri . ' was not found on this server');
  }

  function send_redirect($code, $message, $uri) {
    header("HTTP/1.1 $code $message"); 
    header("Location: $uri");
    exit;   
  }

  function send_client_error($code = 400, $message = 'Bad Request', $body = "400 Bad Request") {
    header("HTTP/1.1 $code $message");
    header('Content-type: text/plain');
    echo($body);     
    exit;   
  }

  function send_server_error($code = 500, $message = 'Server Error', $body = "500 Server Error") {
    header("HTTP/1.1 $code $message");
    header('Content-type: text/plain');
    echo($body);     
    exit;   
  }
}


