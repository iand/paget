<?php

// Some code lifted from Tonic http://tonic.sourceforge.net/
class PAGET_Request {
  /**
   * The request method
   * @var str
   */
  var $method;
  
  /**
   * The full requested URL from the root of the domain
   * @var str
   */
  var $full_path;
  
  /**
   * The requested URL relative to app directory
   * @var str
   */
  var $url;

  /**
   * The full URI of the request
   * @var str
   */
  var $uri;
  
  /**
   * The requested URL with an extension removed
   * @var str
   */
  var $baseUrl;
  
  /**
   * The request representation format accept array in order of preference
   * @var str[]
   */
  var $accept;
  
  /**
   * The request language accept array in order of preference
   * @var str[]
   */
  var $language;
  
  /**
   * The request body mimetype
   * @var str
   */
  var $mimetype;
  
  /**
   * The request body content
   * @var str
   */
  var $body;
  
  /**
   * The resource class to use for creating new resources
   * @var str
   */
  var $class;
  
  /**
   * The match entity tags given in the request
   * @var str[]
   */
  var $ifMatch;
  
  /**
   * The none match entity tags given in the request
   * @var str[]
   */
  var $ifNoneMatch;
  
  /**
   * The modified since date given in the request
   * @var int
   */
  var $ifModifiedSince;
  
  /**
   * The unmodified since date given in the request
   * @var int
   */
  var $ifUnmodifiedSince;
  
  /**
   * Basic auth data
   * @var str[]
   */
  var $basicAuth;
  
  /**
   * Digest auth data
   * @var str[]
   */
  var $digestAuth;
  
  /**
   * Parsed request data
   * @var str[]
   */
  var $data = array();
  
  /**
   * Accept URL extensions in order of preference
   & @var str[]
   */
  var $extensions = array();
  
  
  function __construct()
  {
    $this->method = $this->_get_http_method();
    list($this->full_path, $this->url) = $this->_get_url();
    $this->uri = 'http://' . $_SERVER["SERVER_NAME"]. $this->full_path;
    if ($_SERVER["QUERY_STRING"]) $this->uri .= '?' . $_SERVER["QUERY_STRING"];
    $this->accept = $this->_getAcceptHeader();
    $this->language = $this->_getLanguageHeader();
    $this->encoding = $this->_getRequestAcceptEncoding();
    $this->mimetype = $this->_getRequestBodyMimetype();
    $this->body = $this->_getRequestBody();
    $this->ifNoneMatch = $this->_get_if_none_match();
    $this->ifMatch = $this->_get_if_match();
    $this->ifModifiedSince = $this->_get_if_modified_since();
    $this->ifUnmodifiedSince = $this->_get_if_unmodified_since();
    $this->basicAuth = $this->_get_basic_auth();
    $this->digestAuth = $this->_get_digest_auth();
    $this->cookieAuth = $this->_get_cookie_auth();
    $this->data = $_REQUEST;
  }
  
  function to_string() {
    $ret = "PAGET_Request {\n"; 
    $ret .= "  method: " . $this->method . "\n";
    $ret .= "  full_path: " . $this->full_path . "\n";
    $ret .= "  url: " . $this->url . "\n";
    $ret .= "  uri: " . $this->uri . "\n";
    $ret .= "  accept: " . $this->accept . "\n";
    $ret .= "  body: " . $this->body . "\n";
    $ret .= "  ifNoneMatch: " . $this->ifNoneMatch . "\n";
    $ret .= "  ifMatch: " . $this->ifMatch . "\n";
    $ret .= "  ifModifiedSince: " . $this->ifModifiedSince . "\n";
    $ret .= "  ifUnmodifiedSince: " . $this->ifUnmodifiedSince . "\n";
    $ret .= "  basicAuth: " . $this->basicAuth . "\n";
    $ret .= "  digestAuth: " . $this->digestAuth . "\n";
    $ret .= "  cookieAuth: " . $this->cookieAuth . "\n";
    $ret .= "}";
    return $ret;
  }  


  /**
   * Get the HTTP method of this request
   * @return str
   */
  function _get_http_method()
  {
    if (isset($_SERVER['REQUEST_METHOD'])) {
      return strtolower($_SERVER['REQUEST_METHOD']);
    }
    return NULL;
  }
  
  /**
   * Get the URL of this request. Returns both the full URL and the URL relative
   * to this app.
   * @return str[]
   */
  function _get_url()
  {
    $full_path = NULL;
    if (isset($_SERVER['REDIRECT_URL'])) {
            $full_path = $_SERVER['REDIRECT_URL'];
        } elseif (isset($_SERVER['REQUEST_URI'])) {
            $full_path = $_SERVER['REQUEST_URI'];
        }
    $url = $full_path;
    if (isset($_SERVER['PHP_SELF'])) {
      $baseLength = strlen(dirname($_SERVER['PHP_SELF']));
      if ($baseLength > 1) {
        $url = substr($full_path, $baseLength);
      }
    }
    return array($full_path, $url);
  }
  
  /**
     * Explode the request accept string into an ordered array of content types
     * @return str[] An ordered array of acceptable content types
     */
    function _getAcceptHeader()
    {
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            $accepts = explode(',', $_SERVER['HTTP_ACCEPT']);
            $orderedAccepts = array();
            foreach ($accepts as $key => $accept) {
                $exploded = explode(';', $accept);
                if (isset($exploded[1]) && substr($exploded[1], 0, 2) == 'q=') {
                    $orderedAccepts[substr($exploded[1], 2)][] = trim($exploded[0]);
                } else {
                    $orderedAccepts['1'][] = trim($exploded[0]);
                }
            }
            krsort($orderedAccepts);
            $accepts = array();
            foreach ($orderedAccepts as $q => $acceptArray) {
                foreach ($acceptArray as $mimetype) {
                    $accepts[] = trim($mimetype);
                }
            }
            
            // FIX for IE. if */*, replace with text/html
            $key = array_search('*/*', $accepts);
            if ($key !== FALSE) {
                $accepts[$key] = 'text/html';
            }
            return $accepts;
        }
      return array('*/*');
    }
  
  /**
     * Explode the request language accept string into an ordered array of languages
     * @return str[] An ordered array of acceptable languages
     */
    function _getLanguageHeader()
    {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $accepts = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            $orderedAccepts = array();
            foreach ($accepts as $key => $accept) {
                $exploded = explode(';', $accept);
                if (isset($exploded[1]) && substr($exploded[1], 0, 2) == 'q=') {
                    $q = substr($exploded[1], 2);
                    $orderedAccepts[$q][] = $exploded[0];
                    if ($pos = strpos($exploded[0], '-')) {
                        $orderedAccepts[strval($q - 10)][] = substr($exploded[0], 0, $pos);
                    }
                } else {
                    $orderedAccepts['1'][] = $exploded[0];
                    if ($pos = strpos($exploded[0], '-')) {
                        $orderedAccepts['-9'][] = substr($exploded[0], 0, $pos);
                    }
                }
            }
            krsort($orderedAccepts);
            $accepts = array();
            foreach ($orderedAccepts as $q => $acceptArray) {
                foreach ($acceptArray as $language) {
                    $accepts[] = $language;
                }
            }
            return array_unique($accepts);
        }
        return array();
    }
    
  function _getRequestAcceptEncoding()
  {
    if (isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
            $accepts = explode(',', $_SERVER['HTTP_ACCEPT_ENCODING']);
            foreach ($accepts as $key => $accept) {
        $accepts[$key] = trim($accept);
            }
      return $accepts;
    }
  }
  
  /**
   * Get the request body mimetype from the incoming request
   * @return str
   */
  function _getRequestBodyMimetype()
  {
    if (isset($_SERVER['CONTENT_TYPE'])) {
      return $_SERVER['CONTENT_TYPE']; 
    } 
    elseif (isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
      return 'text/plain';
    }
    return NULL;
  }
  
  /**
   * Get the request body from the incoming request
   * @return str
   */
  function _getRequestBody()
  {
    if (isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
      $requestData = '';
      global $HTTP_RAW_POST_DATA;
      if (isset($HTTP_RAW_POST_DATA)) { // use the magic POST data global if it exists
        return $HTTP_RAW_POST_DATA;
      } else { // other methods
        $requestPointer = fopen('php://input', 'r');
        while ($data = fread($requestPointer, 1024)) {
          $requestData .= $data;
        }
        return $requestData;
      }
    }
    return NULL;
  }
  
  /**
   * Parse entity tags out of a string
   * @param str string
   * @return str[]
   */
  function _getETags($string)
  {
    $eTags = array();
    if (isset($string) && $string != '') {
            $eTags = explode(',', $string);
      foreach ($eTags as $key => $eTag) {
        $eTags[$key] = trim($eTag, '" ');
      }
        }
    return $eTags;
  }
  
  /**
   * Get the none match entity tags from the incoming request
   * @return str[]
   */
  function _get_if_none_match()  {
    if (isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
      return $this->_getETags($_SERVER['HTTP_IF_NONE_MATCH']);
    }
    return array();
  }
  
  /**
   * Get the match entity tags from the incoming request
   * @return str[]
   */
  function _get_if_match() {
    if (isset($_SERVER['HTTP_IF_MATCH'])) {
      return $this->_getETags($_SERVER['HTTP_IF_MATCH']);
    }
    return array();
  }
  
  /**
   * Get the if-modified-since header from the incoming request
   * @return int
   */
  function _get_if_modified_since() {
    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $_SERVER['HTTP_IF_MODIFIED_SINCE'] != '') {
      return strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
    }
    return 0;
  }
  
  /**
   * Get the if-modified-since header from the incoming request
   * @return int
   */
  function _get_if_unmodified_since() {
    if (isset($_SERVER['HTTP_IF_UNMODIFIED_SINCE']) && $_SERVER['HTTP_IF_UNMODIFIED_SINCE'] != '') {
      return strtotime($_SERVER['HTTP_IF_UNMODIFIED_SINCE']);
    }
    return 0;
  }
  
  /**
     * Get the username and password for the HTTP Basic auth given for this request
     * @return str[]
     */
  function _get_basic_auth() {
    if (isset($_SERVER['PHP_AUTH_USER'])) {
      return array(
        'username' => $_SERVER['PHP_AUTH_USER'],
        'password' => $_SERVER['PHP_AUTH_PW']
      );
    }
    return NULL;
  }
  
  /**
     * Get the username and auth details for the HTTP Digest auth given for this request
     * @return str[]
     */ 
  function _get_digest_auth() {
    if (isset($_SERVER['Authorization'])) {
      $authorization = $_SERVER['Authorization'];
    } 
    elseif (isset($_ENV['HTTP_AUTHORIZATION'])) { // for FastCGI suggested by Daniel Patrick <daniel@geekmobile.biz>
      $authorization = stripslashes($_ENV['HTTP_AUTHORIZATION']);
    } 
    elseif (function_exists('apache_request_headers')) {
      $headers = apache_request_headers();
      if (isset($headers['Authorization'])) {
        $authorization = $headers['Authorization'];
      }
    }
    
    if (
      isset($authorization) &&
      preg_match('/username="([^"]+)"/', $authorization, $username) &&
      preg_match('/nonce="([^"]+)"/', $authorization, $nonce) &&
      preg_match('/response="([^"]+)"/', $authorization, $response) &&
      preg_match('/opaque="([^"]+)"/', $authorization, $opaque) &&
      preg_match('/uri="([^"]+)"/', $authorization, $uri)
    ) {
      preg_match('/qop="?([^,\s"]+)/', $authorization, $qop);
      preg_match('/nc=([^,\s"]+)/', $authorization, $nc);
      preg_match('/cnonce="([^"]+)"/', $authorization, $cnonce);
      return array(
        'username' => $username[1],
        'nonce' => $nonce[1],
        'response' => $response[1],
        'opaque' => $opaque[1],
        'uri' => $uri[1],
        'qop' => $qop[1],
        'nc' => $nc[1],
        'cnonce' => $cnonce[1]
      );
    }
    return NULL;
  }
  
  /**
   * Get the username and hash for the HTTP Cookie auth given for this request
   * @return str[]
   */
  function _get_cookie_auth() {
    if (isset($_COOKIE['tonic'])) {
      $parts = explode(':', $_COOKIE['tonic']);
      if (count($parts) == 2 && strlen($parts[1]) == 32) {
        return array(
          'username' => $parts[0],
          'hash' => $parts[1]
        );
      }
    }
    return NULL;
  }
 
  
  /**
   * Take the three accept arrays and create a combined accept array
   * @param str[] extensions
   * @param str[] format
   * @param str[] language
   * @return str[]
   */
  function &_generateAcceptArray(&$mimetypes, &$extensions, &$format, &$language)
  {
    // add extensions to appropriate array
    foreach ($extensions as $extension) {
      if (isset($mimetypes[$extension])) {
        array_unshift($format, $extension);
      } else {
        array_unshift($language, $extension);
      }
    }
    
    $accept = array();
    foreach ($format as $f) {
      foreach ($language as $lang) {
        $accept[] = $lang.'.'.$f;
        $accept[] = $f.'.'.$lang;
      }
    }
    foreach ($format as $f) {
      $accept[] = $f;
    }
    foreach ($language as $lang) {
      $accept[] = $lang;
    }
    $accept = array_unique($accept);
    return $accept;
  }
  
}

