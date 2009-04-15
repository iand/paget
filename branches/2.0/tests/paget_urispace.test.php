<?php
require_once PAGET_DIR . 'paget_urispace.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_fakerequest.class.php';

class PAGET_UriSpaceTest extends PHPUnit_Framework_TestCase {

  function test_is_ir() {
    $urispace = new PAGET_UriSpace();
    
    $this->assertTrue( $urispace->is_ir('http://example.com/foo.html') );  
    $this->assertTrue( $urispace->is_ir('http://example.com/foo.rdf') ); 
    $this->assertTrue( $urispace->is_ir('http://example.com/foo.turtle') );  
    $this->assertTrue( $urispace->is_ir('http://example.com/foo.json') );  
    $this->assertTrue( $urispace->is_ir('http://example.com/foo.xml') ); 
    $this->assertFalse( $urispace->is_ir('http://example.com/foo') );  
  }  
  
}



