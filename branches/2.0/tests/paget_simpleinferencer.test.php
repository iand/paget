<?php
require_once PAGET_DIR. "paget_simpleinferencer.class.php";
require_once PAGET_DIR. "paget_request.class.php";
require_once MORIARTY_DIR. "simplegraph.class.php";

class PAGET_SimpleInferencerTest extends PHPUnit_Framework_TestCase {
  
  function test_type_inference_from_range() {
    $inferencer = new PAGET_SimpleInferencer();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/s', 'http://example.org/p', 'http://example.org/o');
    $g->add_resource_triple('http://example.org/p', RDFS_RANGE, 'http://example.org/class');
    $inferencer->process($g);
    
    $this->assertTrue( $g->has_resource_triple('http://example.org/o', RDF_TYPE, 'http://example.org/class') );
  }  
  
  function test_type_inference_from_domain() {
    $inferencer = new PAGET_SimpleInferencer();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/s', 'http://example.org/p', 'http://example.org/o');
    $g->add_resource_triple('http://example.org/p', RDFS_DOMAIN, 'http://example.org/class');
    $inferencer->process($g);
    
    $this->assertTrue( $g->has_resource_triple('http://example.org/s', RDF_TYPE, 'http://example.org/class') );
  }    

  function test_type_inference_from_subclass() {
    $inferencer = new PAGET_SimpleInferencer();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/s', RDF_TYPE, 'http://example.org/dog');
    $g->add_resource_triple('http://example.org/dog', RDFS_SUBCLASSOF, 'http://example.org/animal');
    $inferencer->process($g);
    
    $this->assertTrue( $g->has_resource_triple('http://example.org/s', RDF_TYPE, 'http://example.org/animal') );
  }  

  function test_property_inference_from_subproperty() {
    $inferencer = new PAGET_SimpleInferencer();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/s', 'http://example.org/p', 'http://example.org/o');
    $g->add_resource_triple('http://example.org/p', RDFS_SUBPROPERTYOF, 'http://example.org/p2');
    $inferencer->process($g);
    
    $this->assertTrue( $g->has_resource_triple('http://example.org/s', 'http://example.org/p2', 'http://example.org/o') );
  } 
  
  function test_property_inference_from_subproperty_infers_new_range() {
    $inferencer = new PAGET_SimpleInferencer();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/s', 'http://example.org/p', 'http://example.org/o');
    $g->add_resource_triple('http://example.org/p', RDFS_SUBPROPERTYOF, 'http://example.org/p2');
    $g->add_resource_triple('http://example.org/p2', RDFS_RANGE, 'http://example.org/class');
    $inferencer->process($g);
    
    $this->assertTrue( $g->has_resource_triple('http://example.org/o', RDF_TYPE, 'http://example.org/class') );
  } 

  function test_property_inference_from_subproperty_infers_new_domain() {
    $inferencer = new PAGET_SimpleInferencer();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/s', 'http://example.org/p', 'http://example.org/o');
    $g->add_resource_triple('http://example.org/p', RDFS_SUBPROPERTYOF, 'http://example.org/p2');
    $g->add_resource_triple('http://example.org/p2', RDFS_DOMAIN, 'http://example.org/class');
    $inferencer->process($g);
    
    $this->assertTrue( $g->has_resource_triple('http://example.org/s', RDF_TYPE, 'http://example.org/class') );
  }      
  
  function test_symmetric_properties() {
    $inferencer = new PAGET_SimpleInferencer();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/s', 'http://example.org/p', 'http://example.org/o');
    $g->add_resource_triple('http://example.org/p', RDF_TYPE, OWL_SYMMETRICPROPERTY);
    $inferencer->process($g);
    
    $this->assertTrue( $g->has_resource_triple('http://example.org/o', 'http://example.org/p', 'http://example.org/s') );
  }     


  function test_symmetric_property_infers_new_range() {
    $inferencer = new PAGET_SimpleInferencer();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/s', 'http://example.org/p', 'http://example.org/o');
    $g->add_resource_triple('http://example.org/p', RDF_TYPE, OWL_SYMMETRICPROPERTY);
    $g->add_resource_triple('http://example.org/p', RDFS_RANGE, 'http://example.org/class');
    $inferencer->process($g);
    
    $this->assertTrue( $g->has_resource_triple('http://example.org/s', RDF_TYPE, 'http://example.org/class') );
  }  
  
  function test_symmetric_property_infers_new_domain() {
    $inferencer = new PAGET_SimpleInferencer();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/s', 'http://example.org/p', 'http://example.org/o');
    $g->add_resource_triple('http://example.org/p', RDF_TYPE, OWL_SYMMETRICPROPERTY);
    $g->add_resource_triple('http://example.org/p', RDFS_DOMAIN, 'http://example.org/class');
    $inferencer->process($g);
    
    $this->assertTrue( $g->has_resource_triple('http://example.org/o', RDF_TYPE, 'http://example.org/class') );
  }  
  
  function test_transitive_properties() {
    $inferencer = new PAGET_SimpleInferencer();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/s', 'http://example.org/p', 'http://example.org/o');
    $g->add_resource_triple('http://example.org/o', 'http://example.org/p', 'http://example.org/o2');
    $g->add_resource_triple('http://example.org/p', RDF_TYPE, OWL_TRANSITIVEPROPERTY);
    $inferencer->process($g);
    
    $this->assertTrue( $g->has_resource_triple('http://example.org/s', 'http://example.org/p', 'http://example.org/o2') );
  }   
  
  function test_transitive_properties_long_chain() {
    $inferencer = new PAGET_SimpleInferencer();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/s', 'http://example.org/p', 'http://example.org/o1');
    $g->add_resource_triple('http://example.org/o1', 'http://example.org/p', 'http://example.org/o2');
    $g->add_resource_triple('http://example.org/o2', 'http://example.org/p', 'http://example.org/o3');
    $g->add_resource_triple('http://example.org/o3', 'http://example.org/p', 'http://example.org/o4');
    $g->add_resource_triple('http://example.org/o4', 'http://example.org/p', 'http://example.org/o5');
    $g->add_resource_triple('http://example.org/o5', 'http://example.org/p', 'http://example.org/o6');
    $g->add_resource_triple('http://example.org/o6', 'http://example.org/p', 'http://example.org/o7');
    $g->add_resource_triple('http://example.org/o7', 'http://example.org/p', 'http://example.org/o8');
    $g->add_resource_triple('http://example.org/p', RDF_TYPE, OWL_TRANSITIVEPROPERTY);
    $inferencer->process($g);
    
    $this->assertTrue( $g->has_resource_triple('http://example.org/s', 'http://example.org/p', 'http://example.org/o8') );
  }       
    
  function test_transitive_properties_loop() {
    $inferencer = new PAGET_SimpleInferencer();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/s', 'http://example.org/p', 'http://example.org/o1');
    $g->add_resource_triple('http://example.org/o1', 'http://example.org/p', 'http://example.org/o2');
    $g->add_resource_triple('http://example.org/o2', 'http://example.org/p', 'http://example.org/o3');
    $g->add_resource_triple('http://example.org/o3', 'http://example.org/p', 'http://example.org/o4');
    $g->add_resource_triple('http://example.org/o4', 'http://example.org/p', 'http://example.org/o5');
    $g->add_resource_triple('http://example.org/o5', 'http://example.org/p', 'http://example.org/o6');
    $g->add_resource_triple('http://example.org/o6', 'http://example.org/p', 'http://example.org/o7');
    $g->add_resource_triple('http://example.org/o7', 'http://example.org/p', 'http://example.org/s');
    $g->add_resource_triple('http://example.org/p', RDF_TYPE, OWL_TRANSITIVEPROPERTY);
    $inferencer->process($g);
    
    $this->assertTrue( $g->has_resource_triple('http://example.org/s', 'http://example.org/p', 'http://example.org/o7') );
  }       
    
}
