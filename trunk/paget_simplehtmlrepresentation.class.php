<?php
class PAGET_SimpleHtmlRepresentation {
  var $_config = array();
  var $labels = array(
                      'http://www.w3.org/1999/02/22-rdf-syntax-ns#type' => array('singular' => 'type', 'plural' => 'types', 'inverse' => 'is type of'),
                      'http://www.w3.org/2000/01/rdf-schema#label' => array('singular' => 'label', 'plural' => 'labels', 'inverse' => 'is label of'),
                      'http://www.w3.org/2000/01/rdf-schema#comment' => array('singular' => 'comment', 'plural' => 'comments', 'inverse' => 'is comment of'),
                      'http://www.w3.org/2000/01/rdf-schema#seeAlso' => array('singular' => 'see also', 'plural' => 'see also', 'inverse' => 'is see also of'),
                      'http://www.w3.org/2000/01/rdf-schema#isDefinedBy' => array('singular' => 'is defined by', 'plural' => 'is defined by', 'inverse' => 'defines'),
                      'http://www.w3.org/2000/01/rdf-schema#range' => array('singular' => 'range', 'plural' => 'ranges', 'inverse' => 'is range of'),
                      'http://www.w3.org/2000/01/rdf-schema#domain' => array('singular' => 'domain', 'plural' => 'domains', 'inverse' => 'is domain of'),
                      'http://xmlns.com/foaf/0.1/isPrimaryTopicOf' => array('singular' => 'is the primary topic of', 'plural' => 'is the primary topic of', 'inverse' => 'primary topic'),
                      'http://xmlns.com/foaf/0.1/primaryTopic' => array('singular' => 'primary topic', 'plural' => 'primary topics', 'inverse' => 'is the primary topic of'),
                      'http://xmlns.com/foaf/0.1/name' => array('singular' => 'name', 'plural' => 'names', 'inverse' => 'is name of'),
                      'http://xmlns.com/foaf/0.1/homepage' => array('singular' => 'homepage', 'plural' => 'homepages', 'inverse' => 'is homepage of'),
                      'http://xmlns.com/foaf/0.1/weblog' => array('singular' => 'weblog', 'plural' => 'weblog', 'inverse' => 'is weblog of'),
                      'http://xmlns.com/foaf/0.1/knows' => array('singular' => 'knows', 'plural' => 'knows', 'inverse' => 'knows'),
                      'http://xmlns.com/foaf/0.1/interest' => array('singular' => 'interest', 'plural' => 'interests', 'inverse' => 'is interest of'),
                      'http://xmlns.com/foaf/0.1/firstName' => array('singular' => 'first name', 'plural' => 'first names', 'inverse' => 'is first name of'),
                      'http://xmlns.com/foaf/0.1/surname' => array('singular' => 'surname', 'plural' => 'surnames', 'inverse' => 'is surname of'),
                      'http://purl.org/dc/elements/1.1/title' => array('singular' => 'title', 'plural' => 'titles', 'inverse' => 'is the title of'),
                      'http://www.w3.org/2003/01/geo/wgs84_pos#lat' => array('singular' => 'latitude', 'plural' => 'latitudes', 'inverse' => 'is latitude of'),
                      'http://www.w3.org/2003/01/geo/wgs84_pos#long' => array('singular' => 'longitude', 'plural' => 'longitudes', 'inverse' => 'is longitude of'),
                      'http://www.w3.org/2002/07/owl#sameAs' => array('singular' => 'same as', 'plural' => 'same as', 'inverse' => 'same as'),
                      'http://purl.org/vocab/bio/0.1/olb' => array('singular' => 'one line bio', 'plural' => 'one line bios', 'inverse' => 'is one line bio of'),
                      'http://purl.org/vocab/relationship/parentOf' => array('singular' => 'is parent of', 'plural' => 'is parent of', 'inverse' => 'is child of'),
                      'http://purl.org/vocab/relationship/childOf' => array('singular' => 'is child of', 'plural' => 'is child of', 'inverse' => 'is parent of'),
                    );


  var $prefixes = array (
                      'http://www.w3.org/1999/02/22-rdf-syntax-ns#' => 'rdf',
                      'http://www.w3.org/2000/01/rdf-schema#' => 'rdfs',
                      'http://www.w3.org/2002/07/owl#' => 'owl',
                      'http://purl.org/vocab/changeset/schema#' => 'cs',
                      'http://schemas.talis.com/2006/bigfoot/configuration#' => 'bf',
                      'http://schemas.talis.com/2006/frame/schema#' => 'frm',
                      'http://schemapedia.com/terms/' => 'sp',

                      'http://purl.org/dc/elements/1.1/' => 'dc',
                      'http://purl.org/dc/terms/' => 'dct',
                      'http://purl.org/dc/dcmitype/' => 'dctype',

                      'http://xmlns.com/foaf/0.1/' => 'foaf',
                      'http://purl.org/vocab/bio/0.1/' => 'bio',
                      'http://www.w3.org/2003/01/geo/wgs84_pos#' => 'geo',
                      'http://purl.org/vocab/relationship/' => 'rel',
                      'http://purl.org/rss/1.0/' => 'rss',
                      'http://xmlns.com/wordnet/1.6/' => 'wn',
                      'http://www.daml.org/2001/10/html/airport-ont#' => 'air',
                      'http://www.w3.org/2000/10/swap/pim/contact#' => 'contact',
                      'http://www.w3.org/2002/12/cal/ical#' => 'ical',
                      'http://purl.org/vocab/frbr/core#' => 'frbr',
                      'http://www.w3.org/2006/time#' => 'time',

                      'http://schemas.talis.com/2005/address/schema#' => 'ad',
                      'http://schemas.talis.com/2005/library/schema#' => 'lib',
                      'http://schemas.talis.com/2005/dir/schema#' => 'dir',
                      'http://schemas.talis.com/2005/user/schema#' => 'user',
                      'http://schemas.talis.com/2005/service/schema#' => 'sv',
                    );

  
  function __construct(&$config) {
    $this->_config = $config; 
    if (isset($config['prefixes'])) {
      foreach ($config['prefixes'] as $uri => $prefix) {
        $this->prefixes[$uri] = $prefix;  
      }
    }

    $this->_config['groups']['labelling'] = array( 'label' => 'Key Information',
                                                   'properties' => array(RDFS_LABEL, DC_TITLE, FOAF_NAME, RDFS_COMMENT, DC_DESCRIPTION, 'http://purl.org/vocab/bio/0.1/olb', RDF_TYPE),
                                                  );
    $this->_config['groups']['links'] = array( 'label' => 'Links',
                                                   'properties' => array( RDFS_SEEALSO, OWL_SAMEAS, 'http://xmlns.com/foaf/0.1/homepage', 'http://xmlns.com/foaf/0.1/weblog', ),
                                                  );


    $this->_config['groups']['naming'] = array( 'label' => 'Full Name',
                                                'properties' => array('http://xmlns.com/foaf/0.1/title', 'http://xmlns.com/foaf/0.1/firstName', 'http://xmlns.com/foaf/0.1/surname'),
                                                  );
                                                  
    $this->_config['view']['http://xmlns.com/foaf/0.1/depiction'] = array ('appearance' => 'image' );                                                  

  }
  
  function emit($desc, $request) {
    $resource_uri = $desc->uri;
    
    $title = $desc->get_label();
    header('Content-type: text/html');
    echo "<?";

?>
xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" >
<head>
    <title><?php e($title); e(' '. $this->_config['page_title_suffix']);?></title>
    <link rel="alternate" type="application/rdf+xml" href="<?php e($this->remote_to_local($resource_uri)); e($this->_config['format_delimiter']);?>rdf" />
    <link rel="alternate" type="application/xml" href="<?php e($this->remote_to_local($resource_uri)); e($this->_config['format_delimiter']);?>xml" />
    <link rel="alternate" type="application/json" href="<?php e($this->remote_to_local($resource_uri)); e($this->_config['format_delimiter']);?>json" />
    <link rel="alternate" type="text/plain" href="<?php e($this->remote_to_local($resource_uri)); e($this->_config['format_delimiter']);?>turtle" />
    

    <style media="screen" type="text/css">
    /* <!-- */
    /* General styles */
    body {
        margin:0;
        padding:0;
        border:0;     /* This removes the border around the viewport in old versions of IE */
        width:100%;
        background:#fff;
        min-width:600px;    /* Minimum width of layout - remove line if not required */
              /* The min-width property does not work in old versions of Internet Explorer */
    font-size:90%;
    }
  a {
      color:#369;
  }
  a:hover {
    color:#fff;
    background:#369;
    text-decoration:none;
  }
    h1, h2, h3 {
        margin:.8em 0 .2em 0;
        padding:0;
    }
    p {
        margin:.4em 0 .8em 0;
        padding:0;
    }
    th {
      text-align: left;
    }
  img {
    margin:10px 0 5px;
  }
  /* Header styles */
    #header {
        clear:both;
        float:left;
        width:100%;
    }
  #header {
    border-bottom:1px solid #ccc;
  }
  #header p,
  #header h1,
  #header h2 {
      padding:.4em 15px 0 15px;
        margin:0;
  } 
  #header ul {
      clear:left;
      float:left;
      width:100%;
      list-style:none;
      margin:10px 0 0 0;
      padding:0;
  }
  #header ul li {
      display:inline;
      list-style:none;
      margin:0;
      padding:0;
  }
  #header ul li a {
      display:block;
      float:left;
      margin:0 0 0 1px;
      padding:3px 10px;
      text-align:center;
      background:#eee;
      color:#000;
      text-decoration:none;
      position:relative;
      left:15px;
    line-height:1.3em;
  }
  #header ul li a:hover {
      background:#369;
    color:#fff;
  }
  #header ul li a.active,
  #header ul li a.active:hover {
      color:#fff;
      background:#000;
      font-weight:bold;
  }
  #header ul li a span {
      display:block;
  }
  /* 'widths' sub menu */
  #layoutdims {
    clear:both;
    background:#eee;
    border-top:4px solid #ccc;
    margin:0;
    padding:6px 15px !important;
    text-align:right;
  }
  /* column container */
  .colmask {
    position:relative;    /* This fixes the IE7 overflow hidden bug and stops the layout jumping out of place */
      clear:both;
      float:left;
        width:100%;     /* width of whole page */
    overflow:hidden;  /* This chops off any overhanging divs */
  }
  /* 2 column right menu settings */
  .rightmenu {
      background:#F0F0F0;
  }
  .rightmenu .colleft {
        float:left;
        width:200%;
        margin-left:-28em;
        position:relative;
        right:100%;
        background:#fff;
    }
    .rightmenu .col1wrap {
      float:left;
      width:50%;
      position:relative;
      left:50%;
      padding-bottom:1em;
  }
  .rightmenu .col1 {
        margin:0 1em 0 29em;
        overflow:hidden;
  }
  .rightmenu .col2 {
    float:right;
    width:25em;
    position:relative;
    left:26em;
  }

  /* Footer styles */
  #footer {
    clear:both;
    float:left;
    width:100%;
    border-top:1px solid #ccc;
  }
  #footer p {
    padding:10px;
    margin:0;
  }
    /* --> */
    </style>
    <!--[if lt IE 7]>
    <style media="screen" type="text/css">
    .col1 {
      width:100%;
  }
    </style>
    <![endif]-->
</head>
<body>

<div id="header">
    <h1><?php e($title);?></h1>
  <p id="layoutdims">
    This data in other formats:
    <a href="<?php e($this->remote_to_local($resource_uri)); e($this->_config['format_delimiter']); ?>rdf" rel="alternate" title="RDF/XML description of data" type="application/rdf+xml">RDF/XML</a> |
    <a href="<?php e($this->remote_to_local($resource_uri)); e($this->_config['format_delimiter']); ?>xml" rel="alternate" title="XML description of data" type="application/xml">XML</a> |
    <a href="<?php e($this->remote_to_local($resource_uri)); e($this->_config['format_delimiter']); ?>json" rel="alternate" title="JSON description of data" type="application/json">JSON</a> |
    <a href="<?php e($this->remote_to_local($resource_uri)); e($this->_config['format_delimiter']); ?>turtle" rel="alternate" title="Turtle description of data" type="text/plain">Turtle</a>
    
  </p>


</div>
<div class="colmask rightmenu">
    <div class="colleft">
        <div class="col1wrap">
            <div class="col1">
              <!-- Column 1 start -->
                <h2>About <?php e($resource_uri);?></h2>
                <?php
                
                  $this->emit_group('labelling', $resource_uri, $desc);
                  $this->emit_group('links', $resource_uri, $desc);
                  $this->emit_group('naming', $resource_uri, $desc);
                
                  $this->emit_ungrouped_properties($resource_uri, $desc);
                  $this->emit_inverse_properties($resource_uri, $desc);
                
                ?>
                
                <!-- Column 1 end -->
            </div>
        </div>
        <div class="col2">
            <!-- Column 2 start -->
            <h2>About this page</h2>
            <?php 
              $this->emit_group('labelling', $request->request_uri, $desc);
              $this->emit_group('links', $request->request_uri, $desc);
              $this->emit_group('naming', $request->request_uri, $desc);
            
              $this->emit_ungrouped_properties($request->request_uri, $desc); 
            ?>
            <!-- Column 2 end -->
        </div>
    </div>
</div>
<div id="footer">
    <!-- Page template based on Ultimate 'Right Menu' 2 column Liquid Layout by Matthew James Taylor See http://matthewjamestaylor.com/blog/ultimate-2-column-right-menu-ems.htm -->
  <?php echo($this->_config['credits_html']); ?>

</div>
<?php
  if (isset($this->_config['google_analytics_code'])) {
?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("<?php e($this->_config['google_analytics_code']); ?>");
pageTracker._trackPageview();
</script>
<?php   
  }
?>
</body>
</html>
<?php
  }

  function e($text) {
    echo(htmlspecialchars($text));  
  } 
  
  function link_uri($uri, $label = '') {
    if (preg_match('/^https?:\/\//', $uri) ) {
      $ret = '<a href="' . htmlspecialchars($this->remote_to_local($uri)) . '" class="uri">';
      if ($label !== '') {
        $ret .= $label;
      }
      else {
        $ret .= $this->make_formatted_qname($uri);
      }
      $ret .= '</a>';
      return $ret;
    }
    else {
      return htmlspecialchars($uri);
    }
  }

  function make_formatted_qname($uri) {

    if (preg_match('/^(.*[\/\#])([a-z0-9\-\_]+)$/i', $uri, $m)) {
      if ( array_key_exists($m[1], $this->prefixes)) {
        return '<span title="' . htmlspecialchars($uri) . '"><span class="prefix">' . htmlspecialchars($this->prefixes[$m[1]]) . ':</span><span class="localname">' . htmlspecialchars($m[2]) . '</span></span>';
      }  
    }
    return $uri;
  }
  
  function remote_to_local($uri) {
    if (preg_match('~http://([^/]+)/~i', $uri, $m)) {
      if ( $_SERVER["HTTP_HOST"] == $m[1] . '.local' ) {
        return str_replace($m[1], $_SERVER["HTTP_HOST"], $uri);
      }
      else {
        return $uri;
      }
    }
  }

  function emit_group($groupname, $resource_uri, &$desc) {
    if ( isset($this->_config['groups'][$groupname]) && isset($this->_config['groups'][$groupname]['properties']) && is_array($this->_config['groups'][$groupname]['properties']) ) {
      $data = $this->prepare_data($this->_config['groups'][$groupname]['properties'], $desc, $resource_uri);
      $this->emit_table($data);
    }
  }

  function emit_ungrouped_properties($resource_uri, &$desc) {
    $index = $desc->get_index();
    $remaining_properties = array_keys($index[$resource_uri]);
    foreach( $this->_config['groups'] as $group ) {
      $remaining_properties = array_diff($remaining_properties, $group['properties']);
    }
    $data = $this->prepare_data($remaining_properties, $desc, $resource_uri);
    $this->emit_table($data);
  }  
  
  
  function emit_inverse_properties($resource_uri, &$desc) {
                    
    $index = $desc->get_index();
    $inverse_property_index = array();
    foreach ($index as $s => $p_list) {
      foreach ($p_list as $p => $v_list) {
        foreach ($v_list as $v_info) {
          if ( $v_info['type'] == 'uri' ) {
            if ( $v_info['value'] === $resource_uri) {
              $inverse_property_index[$resource_uri][$p][] = array('type'=>'uri', 'value'=>$s);
            }
          } 
        }
      }
    }

    $data = array();
    
    $inverse_properties = array_keys($inverse_property_index[$resource_uri]);
    foreach ($inverse_properties as $property) {
      $label = ucfirst($desc->get_first_literal($property, 'http://purl.org/net/vocab/2004/03/label#inverseSingular'));
      if (strlen($label) > 0) {
        $formatted_label = $this->format_property_label($property, $label);
        $formatted_value = $this->format_property_values($property, $inverse_property_index[$resource_uri][$property]);
        $data[] = array('label' => $formatted_label, 'value' => $formatted_value );
      }
    }
    $this->emit_table($data);
  }                
  
  
  function prepare_data(&$properties, $desc, $resource_uri = null) {
    $data = array();
    if ($resource_uri == null ) {
      $resource_uri = $desc->uri; 
    }
    
    foreach ( $properties as $property) {
      $property_values = $desc->get_subject_property_values($resource_uri, $property);
      if ( count($property_values) > 0) {
    
        if ( count($property_values) == 1) {
          $label = ucfirst($desc->get_first_literal($property, RDFS_LABEL));
        }
        else {
          $label = ucfirst($desc->get_first_literal($property, 'http://purl.org/net/vocab/2004/03/label#plural'));
        }         
        
        
        $formatted_label = $this->format_property_label($property, $label);
        $formatted_value = $this->format_property_values($property, $property_values);

        $data[] = array('label' => $formatted_label, 'value' => $formatted_value );
      }
    }
   
    return $data; 
  }
  
  function format_property_label($property, $label) {
    return '<span title="' .htmlspecialchars($property) . '">' . $this->link_uri($property, $label) . '</span>';
  }
  function format_property_values($property, &$property_values) {
    $formatted_value = '';
    $appearance = 'text';
    
    if ( array_key_exists( $property, $this->_config['view'] ) && isset($this->_config['view'][$property]['appearance']) ) {
      $appearance = $this->_config['view'][$property]['appearance'];
    }
    if ( $appearance == 'image' ) {
      for ($i = 0; $i < count($property_values); $i++) {
        if ($property_values[$i]['type'] == 'uri') {
          $formatted_value .= '<img src="' . htmlspecialchars($property_values[$i]['value']). '" />';
        }
        else {
          $formatted_value .= htmlspecialchars($property_values[$i]['value']); 
        }
      }
    }
    else {
      for ($i = 0; $i < count($property_values); $i++) {
        if ($i > 0) {
          if ($i < count($property_values) - 1) {
            $formatted_value .= ', ';
          }
          else {
            $formatted_value .= ' and ';
          }
        }
        if ($property_values[$i]['type'] == 'uri') {
          
          $formatted_value .= $this->link_uri($property_values[$i]['value']);
          }
        else {
          $formatted_value .= htmlspecialchars($property_values[$i]['value']); 
        }
      }   
    }
    return $formatted_value;
  }
  
  function emit_table(&$data) {
    return $this->emit_key_value($data);
    if ( count($data) > 0 ) {
      echo '<table width="100%">';
      foreach ($data as $item) {
        echo '<tr><th valign="top" width="18%">' . $item['label'] . '</th><td valign="top">' . $item['value'] . '</td></tr>' . "\n";
      }   
      echo '</table>';
    }
  }

  function emit_key_value(&$data) {
    if ( count($data) > 0 ) {
      foreach ($data as $item) {
        echo '<p><strong>' . $item['label'] . '</strong>: ' . $item['value'] . '</p>' . "\n";
      }   
    }
  }
}
