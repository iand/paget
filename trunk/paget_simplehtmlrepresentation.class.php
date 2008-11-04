<?php
include_once "paget_termwidget.class.php";
include_once "paget_datawidget.class.php";
include_once "paget_historywidget.class.php";
include_once "paget_ontologywidget.class.php";

class PAGET_SimpleHtmlRepresentation {
  var $_config;
  function __construct($config = array()) {
    $this->_config = $config;
  }
  
  function emit(&$desc) {
    $resource_uri = $desc->get_primary_resource_uri();
    $document_base = $resource_uri;
    if ( preg_match('~^(.+)' . preg_quote($this->_config['format_delimiter']) . 'html$~', $desc->get_uri(), $m)) {
      $document_base = $m[1];
    }
    
    $title = $desc->get_label();

    $widgets = array();
    if ( $desc->has_resource_triple($resource_uri, RDF_TYPE, RDF_PROPERTY) || $desc->has_resource_triple($resource_uri, RDF_TYPE, RDFS_CLASS) ) {
      $widgets[] = new PAGET_TermWidget($desc);
    }
    else if ( $desc->has_resource_triple($resource_uri, RDF_TYPE, 'http://www.w3.org/2002/07/owl#Ontology')  ) {
      $widgets[] = new PAGET_OntologyWidget($desc);
    }
    else {
      $widgets[] = new PAGET_DataWidget($desc);
    }    

    header('Content-type: text/html');
    echo "<?";

?>
xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
  <head>
    <title><?php e($widgets[0]->get_title($resource_uri));?></title>

<?php
  $formats = $desc->get_resource_triple_values($desc->get_uri(), 'http://purl.org/dc/terms/hasFormat');
  foreach ($formats as $format_uri) {
    $media_type = $desc->get_first_literal($format_uri, 'http://purl.org/dc/elements/1.1/format');  
    $label = $desc->get_first_literal($format_uri, RDFS_LABEL, $media_type);  
    echo '    <link rel="alternate" type="' . htmlspecialchars($media_type) . '" href="' . htmlspecialchars($format_uri) . '" title="' . htmlspecialchars($label) . ' version of this document"/>' . "\n";
  }
?>
    <style media="screen" type="text/css">
      /* <!-- */
      body {margin:0; padding:0; border:0; width:100%; background:#fff;font-size:90%;}
      a {color:#369;}
      a:hover {color:#fff; background:#369; text-decoration:none;}
      h1, h2, h3 {margin:.8em 0 .2em 0; padding:0;}
      p {margin:.4em 0 .8em 0; padding:0;}
      img { margin:10px 0 5px;}
      #header {clear:both; float:left; width:100%;}
      #header {border-bottom:1px solid #000;}
      #header p, #header h1, #header h2 {padding:.4em 15px 0 15px; margin:0;}
      #header ul {clear:left; float:left; width:100%; list-style:none; margin:10px 0 0 0; padding:0;}
      #header ul li {display:inline; list-style:none; margin:0; padding:0;}
      #header ul li a {display:block; float:left; margin:0 0 0 1px; padding:3px 10px; text-align:center; background:#eee; color:#000; text-decoration:none; position:relative; left:15px; line-height:1.3em;}
      #header ul li a:hover { background:#369; color:#fff;}
      #header ul li a.active, #header ul li a.active:hover {color:#fff; background:#000; font-weight:bold;}
      #header ul li a span {display:block;}
      #layoutdims { clear:both; background:#eee; border-top:4px solid #000; margin:0; padding:6px 15px !important; text-align:right;}
      .colmask { position:relative; clear:both; float:left; width:100%; overflow:hidden;}
      .fullpage {background:#fff;}
      .fullpage .col1 {margin:0 1em;}
      #footer {clear:both;float:left; width:100%; border-top:1px solid #000;}
      #footer p { padding:10px; margin:0;}
          code.xml .text {
      color: #000000;
      background: transparent;
    }
    code.xml .elem {
      color: #000080; 
      background: transparent;
    }
    code.xml .attr {
      color: #008080;
      background: transparent;
    }
    code.xml .attrVal {
      color: #666666;
      background: transparent;
    }
    code.xml .highlight {
      background: #ffff00;
    }
  pre {
    border: 1px #999999 dotted;
    background-color: #eeeeee;
    color: #000000;
  }
  

      /* --> */
    </style>
  </head>
  <body>

  <div id="header">
    <h1><?php echo(htmlspecialchars($widgets[0]->get_title($resource_uri))) ?></h1>
    <p id="layoutdims">This data in other formats:
    <?php
      $formats = $desc->get_resource_triple_values($desc->get_uri(), 'http://purl.org/dc/terms/hasFormat');
      $done_first = false;
      foreach ($formats as $format_uri) {
        $media_type = $desc->get_first_literal($format_uri, 'http://purl.org/dc/elements/1.1/format');  
        $label = $desc->get_first_literal($format_uri, RDFS_LABEL, $media_type);  
        
        if ($done_first) {
          echo ' | ';
        }
        echo '<a href="' . htmlspecialchars($format_uri) . '" rel="alternate" title="' . htmlspecialchars($label) . ' version of this document" type="' . htmlspecialchars($media_type) . '">' . htmlspecialchars($label) . '</a>' . "\n";
        $done_first = true;
      }
    
    ?>
    </p>
  </div>
    <div class="colmask fullpage">
      <div class="col1">
      <?php
        foreach ($widgets as $widget) {
          $widget->render($resource_uri);
        }  
      ?>
      </div>
    </div>

    <div id="footer">
      <!-- Page template based on http://matthewjamestaylor.com/blog/ultimate-1-column-full-page-ems.htm -->
      <p><?php echo($this->_config['credits_html']); ?></p>
    </div>
<?php
  if (isset($this->_config['google_analytics_code'])) {
?>
    <script type="text/javascript">var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));</script>
    <script type="text/javascript">var pageTracker = _gat._getTracker("<?php e($this->_config['google_analytics_code']); ?>");pageTracker._trackPageview();</script>
<?php   
  }
?>

  </body>
</html>
<?php
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
  

}





