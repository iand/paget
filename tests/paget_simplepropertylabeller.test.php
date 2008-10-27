<?php
require_once PAGET_DIR. "paget_simplepropertylabeller.class.php";
require_once PAGET_DIR. "paget_request.class.php";
require_once MORIARTY_DIR. "simplegraph.class.php";

class PAGET_SimplePropertyLabellerTest extends PHPUnit_Framework_TestCase {
  
  function test_no_labels_added_for_empty_graph() {
    $labeller = new PAGET_SimplePropertyLabeller();
    $g = new SimpleGraph();
    $this->assertTrue( $g->is_empty() );
    $labeller->process($g);
    $this->assertTrue( $g->is_empty() );
  }

  function test_rdf_type_is_labelled() {
    $labeller = new PAGET_SimplePropertyLabeller();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/subj', RDF_TYPE, 'http://example.org/obj');
    $labeller->process($g);
    $this->assertTrue( $g->has_literal_triple(RDF_TYPE, RDFS_LABEL, 'type') );
    $this->assertTrue( $g->has_literal_triple(RDF_TYPE, 'http://purl.org/net/vocab/2004/03/label#plural', 'types') );
    $this->assertTrue( $g->has_literal_triple(RDF_TYPE, 'http://purl.org/net/vocab/2004/03/label#inverseSingular', 'is type of') );
  }  

  function test_no_label_is_added_if_one_already_exists() {
    $labeller = new PAGET_SimplePropertyLabeller();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/subj', RDF_TYPE, 'http://example.org/obj');
    $g->add_resource_triple(RDF_TYPE, RDFS_LABEL, 'scooby');
    $labeller->process($g);
    $this->assertFalse( $g->has_literal_triple(RDF_TYPE, RDFS_LABEL, 'type') );
  } 

  function test_no_plural_label_is_added_if_one_already_exists() {
    $labeller = new PAGET_SimplePropertyLabeller();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/subj', RDF_TYPE, 'http://example.org/obj');
    $g->add_resource_triple(RDF_TYPE, 'http://purl.org/net/vocab/2004/03/label#plural', 'scooby');
    $labeller->process($g);
    $this->assertFalse( $g->has_literal_triple(RDF_TYPE, 'http://purl.org/net/vocab/2004/03/label#plural', 'types') );
  } 

  function test_no_inverse_label_is_added_if_one_already_exists() {
    $labeller = new PAGET_SimplePropertyLabeller();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/subj', RDF_TYPE, 'http://example.org/obj');
    $g->add_resource_triple(RDF_TYPE, 'http://purl.org/net/vocab/2004/03/label#inverseSingular', 'scooby');
    $labeller->process($g);
    $this->assertFalse( $g->has_literal_triple(RDF_TYPE, 'http://purl.org/net/vocab/2004/03/label#inverseSingular', 'is type of') );
  } 
  
  function test_label_is_added_even_if_plural_already_exists() {
    $labeller = new PAGET_SimplePropertyLabeller();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/subj', RDF_TYPE, 'http://example.org/obj');
    $g->add_resource_triple(RDF_TYPE, 'http://purl.org/net/vocab/2004/03/label#plural', 'scooby');
    $labeller->process($g);
    $this->assertTrue( $g->has_literal_triple(RDF_TYPE, RDFS_LABEL, 'type') );
  }   

  function test_plural_is_added_even_if_label_already_exists() {
    $labeller = new PAGET_SimplePropertyLabeller();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/subj', RDF_TYPE, 'http://example.org/obj');
    $g->add_resource_triple(RDF_TYPE, RDFS_LABEL, 'scooby');
    $labeller->process($g);
    $this->assertTrue( $g->has_literal_triple(RDF_TYPE, 'http://purl.org/net/vocab/2004/03/label#plural', 'types') );
  }   

  function test_inverse_is_added_even_if_label_already_exists() {
    $labeller = new PAGET_SimplePropertyLabeller();
    $g = new SimpleGraph();
    $g->add_resource_triple('http://example.org/subj', RDF_TYPE, 'http://example.org/obj');
    $g->add_resource_triple(RDF_TYPE, RDFS_LABEL, 'scooby');
    $labeller->process($g);
    $this->assertTrue( $g->has_literal_triple(RDF_TYPE, 'http://purl.org/net/vocab/2004/03/label#inverseSingular', 'is type of') );
  }   
}
