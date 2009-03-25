<?php
require_once MORIARTY_DIR . 'moriarty.inc.php';
require_once MORIARTY_DIR . 'changeset.class.php';
require_once PAGET_DIR . 'paget_resourcedescription.class.php';

class PAGET_Form {
  var $_desc;
  var $_uri;
  var $_resources = array( );
  var $_fields = array( );

  function __construct($uri, &$desc) {
    $this->_uri = $uri;
    $this->_desc = $desc;
  }

  function get_label() {
    return 'Edit ' . $this->_desc->get_label(); 
  }
  
  function get_primary_resource_uri() {
    return $this->_desc->get_primary_resource_uri(); 
  }
  
  function get_index() {
    return $this->_desc->get_index(); 
  }

  function get_triples() {
    return $this->_desc->get_triples(); 
  }

  function has_triples_about($s) {
    return $this->_desc->has_triples_about($s); 
  }

  function get_subresource_uri($name) {
    $primary_resource_uri = $this->get_primary_resource_uri();
    $pos = strpos($primary_resource_uri, '#');
    if ($pos === false) {
      return $primary_resource_uri . '#' . $name;
    }
    else {
      return substr($primary_resource_uri, 0, $pos) . '#' . $name;
    }
  }

  function define_subresource($resource_name, $relation_to_primary) {
    $this->_resources[$resource_name] = array('uri' => $this->get_subresource_uri($resource_name), 'relation' => $relation_to_primary);
  }

  /**
   * Predefined field types:
   * <ul>
   * <li>note - a long text field, typically rendered as a textarea</li>
   * <li>resource - a field for entering URIs</li>
   * </ul>
   **/
  function define_field($field_name, $property, $resource = 'this', $type = '') {
    $this->_fields[$field_name] = array('resource' => $resource, 'property' => $property, 'type' => $type);
  }

  function add_type($resource_name, $uri) {
    if ($resource_name == 'this' ) {
      $this->_desc->add_resource_triple($this->get_primary_resource_uri(), RDF_TYPE, $uri);    
    }
    else {
      $this->_desc->add_resource_triple($this->get_subresource_uri($resource_name), RDF_TYPE, $uri);    
    }
  }

  function get_fields() {
    return $this->_fields;
  }

  function get_field_literal($field_name) {
    if ($this->_fields[$field_name]['resource'] == 'this' ) {
      return $this->_desc->get_first_literal(
        $this->_desc->get_primary_resource_uri(),
        $this->_fields[$field_name]['property'] );
    }
    else {
      return $this->_desc->get_first_literal(
        $this->_resources[ $this->_fields[$field_name]['resource'] ]['uri'],
        $this->_fields[$field_name]['property'] );
    }
  }

  function set_field_literal($field_name, $value) {
    if ($this->_fields[$field_name]['resource'] == 'this' ) {
      $this->_desc->add_literal_triple( $this->_desc->get_primary_resource_uri(),
                                $this->_fields[$field_name]['property'],
                                $value);
    }
    else {
      $this->_desc->add_resource_triple( $this->_desc->get_primary_resource_uri(),
                                  $this->_resources[ $this->_fields[$field_name]['resource'] ]['relation'],
                                  $this->_resources[ $this->_fields[$field_name]['resource'] ]['uri'] );
      $this->_desc->add_literal_triple( $this->_resources[ $this->_fields[$field_name]['resource'] ]['uri'],
                                $this->_fields[$field_name]['property'],
                                $value);
    }
  }


  function from_form_data($data) {
    foreach ($data as $key => $value ) {
      if (array_key_exists($key, $this->_fields)) {
        if ($this->_fields[$key]['resource'] == 'this' ) {
          $this->_desc->remove_property_values($this->_desc->get_primary_resource_uri(), $this->_fields[$key]['property']);
        }
        $this->set_field_literal($key, $value);
      }
    }
  }

  function get_input_field($field_name) {
    if ( $this->_fields[$field_name]['type'] && $this->_fields[$field_name]['type'] == 'note') {
      $html = '<textarea rows="4" cols="120"';
      $html .= ' name="' . htmlspecialchars($field_name) . '"';
      $html .= ' id="' . htmlspecialchars($field_name) . '"';
      $html .= '>';
      $html .= htmlspecialchars($this->get_field_literal($field_name));
      $html .= '</textarea>';
    }
    else {
      $html = '<input type="text"';
      $html .= ' class="text';
      if ( $this->_fields[$field_name]['type'] ) {
        $html .= ' ' . htmlspecialchars($this->_fields[$field_name]['type']);
      }
      $html .= '"';
      $html .= ' name="' . htmlspecialchars($field_name) . '"';
      $html .= ' id="' . htmlspecialchars($field_name) . '"';
      $html .= ' value="' . htmlspecialchars($this->get_field_literal($field_name)) . '"';
      $html .= '/>';
    }
    return $html;
  }

  function get_form() {
    $html = '<form method="post" action="' . htmlspecialchars($this->_uri) .'"><input type="hidden" name="uri" value="' . htmlspecialchars($this->_desc->get_primary_resource_uri()) . '"/><fieldset>' . "\n";
    foreach ($this->_fields as $field_name => $field_data) {
      $html .= '<label for="' . htmlspecialchars($field_name) . '">' .  htmlspecialchars($field_name) .'</label>: ';
      $html .= $this->get_input_field($field_name);
      $html .= "<br />\n";
    }   
    $html .= "</fieldset><br />\n";
    $html .= '<fieldset>' . "\n";
    $html .= '  <input type="submit" class="submit" value="Save Changes" accesskey="s"/> or <a href="' . htmlspecialchars($this->_desc->get_primary_resource_uri()) . '" accesskey="c">cancel</a>' . "\n";
    $html .= '</fieldset>' . "\n";
    $html .= '</form>' . "\n";
    return $html;
  }

  function get(&$urispace,&$request) {

    $response = new PAGET_Response(200);
    $tmpl = $urispace->get_template($request);
    if ( null == $tmpl ) {
      $tmpl = PAGET_DIR . 'templates' .  DIRECTORY_SEPARATOR . 'plain.tmpl.html';
    }

    ob_start();
    try {
      include($tmpl);
      $buffer = ob_get_clean();
      $response->set_body($buffer);
    } 
    catch (Exception $ex) {
      ob_end_clean();
      throw $ex;
    }

    $response->configure($this, $request);
    return $response;
  }

  function post(&$urispace,&$request) {
    $orig = $this->_desc->get_triples();
    $this->from_form_data($request->data);
    
    $cs = new ChangeSet(
                          array(
                            'subjectOfChange' => $this->_desc->get_primary_resource_uri(), 
                            'createdDate' => 'date', 
                            'creatorName' => 'anon', 
                            'changeReason' => 'na', 
                            'before' => $orig, 
                            'after' => $this->_desc->get_triples() , 
                          )
                          
                        );
    
    
    echo(htmlspecialchars($cs->to_turtle()));


    $response = new PAGET_Response(200);
    $response->configure($this, $request);
    return $response;
    
  }

}

?>
