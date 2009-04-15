<?php
require_once PAGET_DIR. "paget_form.class.php";


class PAGET_FormTest extends PHPUnit_Framework_TestCase {

  // Can be overridden by subclasses
  function make_form($uri) {
    $desc = new PAGET_ResourceDescription($uri . '.rdf');
    return new PAGET_Form('http://example.org/forms/foo', $desc);
  }


  function test_uri() {
    $form = $this->make_form("http://example.org/thing");
    $this->assertEquals( "http://example.org/thing", $form->get_primary_resource_uri() );
  }

  function test_get_subresource_uri_appends_name_as_fragment() {
    $form = $this->make_form("http://example.org/thing");
    $this->assertEquals("http://example.org/thing#scooby",  $form->get_subresource_uri('scooby'));
  }

  function test_get_subresource_uri_replaces_any_fragment() {
    $form = $this->make_form("http://example.org/thing#it");
    $this->assertEquals("http://example.org/thing#scooby",  $form->get_subresource_uri('scooby'));
  }

  function test_set_field_literal_for_primary_resource_adds_triples() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_field('name',  'http://example.org/name', 'this');
    $form->set_field_literal('name', 'scooby');

    $index = $form->get_index();

    $this->assertEquals("scooby",  $form->get_field_literal('name'));
    $this->assertEquals(1,  count($index[$form->get_primary_resource_uri()]['http://example.org/name']));
    $this->assertEquals('literal',  $index[$form->get_primary_resource_uri()]['http://example.org/name'][0]['type']);
    $this->assertEquals("scooby",  $index[$form->get_primary_resource_uri()]['http://example.org/name'][0]['value']);
  }


  function test_set_field_literal_for_subresource_adds_triples() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_subresource('dog',  'http://example.org/pet');
    $form->define_field('name',  'http://example.org/name', 'dog');
    $form->set_field_literal('name', 'scooby');

    $index = $form->get_index();

    $this->assertEquals("scooby",  $form->get_field_literal('name'));
    $this->assertEquals(1,  count($index[$form->get_primary_resource_uri()]['http://example.org/pet']));
    $this->assertEquals('uri',  $index[$form->get_primary_resource_uri()]['http://example.org/pet'][0]['type']);
    $this->assertEquals($form->get_subresource_uri('dog'),  $index[$form->get_primary_resource_uri()]['http://example.org/pet'][0]['value']);

    $this->assertEquals(1,  count($index[$form->get_subresource_uri('dog')]['http://example.org/name']));
    $this->assertEquals('literal',  $index[$form->get_subresource_uri('dog')]['http://example.org/name'][0]['type']);
    $this->assertEquals("scooby",  $index[$form->get_subresource_uri('dog')]['http://example.org/name'][0]['value']);
  }

  function test_from_form_data() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_field('informant_residence',  'http://example.org/name', 'this');
    $form->from_form_data( array('informant_residence' => 'appledore' ) );
    $this->assertTrue($form->has_triples_about("http://example.org/thing"));
    $this->assertEquals('appledore', $form->get_field_literal('informant_residence'));
  }


  function test_from_form_data_ignores_unknown_fields() {
    $form = $this->make_form("http://example.org/thing");
    $form->from_form_data( array('blah_blah' => 'appledore' ) );
    $this->assertFalse($form->has_triples_about("http://example.org/thing"));
  }



  function test_get_input_field_for_text_returns_xhtml_input_tag() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_field('nick', 'http://example.org/nick', 'this');
    $html = $form->get_input_field( 'nick' );
    $this->assertRegExp('/<input.+\/>/', $html);
  }

  function test_get_input_field_for_text_field_contains_type_attribute() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_field('nick', 'http://example.org/nick', 'this');
    $html = $form->get_input_field( 'nick' );
    $this->assertContains('type="text"', $html);
  }

  function test_get_input_field_for_text_field_contains_id_attribute() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_field('nick', 'http://example.org/nick', 'this');
    $html = $form->get_input_field( 'nick' );
    $this->assertContains('id="nick"', $html);
  }

  function test_get_input_field_for_text_field_contains_name_attribute() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_field('nick', 'http://example.org/nick', 'this');
    $html = $form->get_input_field( 'nick' );
    $this->assertContains('name="nick"', $html);
  }

  function test_get_input_field_for_text_field_contains_class_attribute() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_field('nick', 'http://example.org/nick', 'this');
    $html = $form->get_input_field( 'nick' );
    $this->assertContains('class="text"', $html);
  }

  function test_get_input_field_for_text_field_contains_value_attribute() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_field('nick', 'http://example.org/nick', 'this');
    $html = $form->get_input_field( 'nick' );
    $this->assertContains('value=""', $html);
  }

  function test_get_input_field_for_text_field_contains_value_attribute_with_data() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_field('nick', 'http://example.org/nick', 'this');
    $form->set_field_literal('nick', 'doo');
    $html = $form->get_input_field( 'nick' );
    $this->assertContains('value="doo"', $html);
  }

  function test_get_input_field_for_typed_text_field_contains_class_attribute() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_field('nick', 'http://example.org/nick', 'this', 'name');
    $html = $form->get_input_field( 'nick' );
    $this->assertContains('class="text name"', $html);
  }

  function test_get_input_field_for_note_returns_xhtml_textarea_tag() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_field('nick', 'http://example.org/nick', 'this', 'note');
    $html = $form->get_input_field( 'nick' );
    $this->assertRegExp('/<textarea.+<\/textarea>/', $html);
  }

   function test_get_input_field_for_note_contains_text() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_field('nick', 'http://example.org/nick', 'this', 'note');
    $form->set_field_literal('nick', 'doo');
    $html = $form->get_input_field( 'nick' );
    $this->assertContains('>doo<', $html);
  }

   function test_get_input_field_for_note_contains_cols() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_field('nick', 'http://example.org/nick', 'this', 'note');
    $html = $form->get_input_field( 'nick' );
    $this->assertContains('cols="120"', $html);
  }

   function test_get_input_field_for_note_contains_rows() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_field('nick', 'http://example.org/nick', 'this', 'note');
    $html = $form->get_input_field( 'nick' );
    $this->assertContains('rows="4"', $html);
  }

   function test_get_input_field_for_note_contains_id() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_field('nick', 'http://example.org/nick', 'this', 'note');
    $html = $form->get_input_field( 'nick' );
    $this->assertContains('id="nick"', $html);
  }
   function test_get_input_field_for_note_contains_name() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_field('nick', 'http://example.org/nick', 'this', 'note');
    $html = $form->get_input_field( 'nick' );
    $this->assertContains('name="nick"', $html);
  }

  function test_add_type() {
    $form = $this->make_form("http://example.org/thing");
    $form->add_type('this', 'http://example.org/Animal');
    $index = $form->get_index();

    $this->assertEquals(1,  count($index[$form->get_primary_resource_uri()][RDF_TYPE]));
    $this->assertEquals('uri',  $index[$form->get_primary_resource_uri()][RDF_TYPE][0]['type']);
    $this->assertEquals('http://example.org/Animal',  $index[$form->get_primary_resource_uri()][RDF_TYPE][0]['value']);
  }

  function test_add_subresource_type() {
    $form = $this->make_form("http://example.org/thing");
    $form->define_subresource('dog',  'http://example.org/pet');
    $form->add_type('dog', 'http://example.org/Animal');
    $index = $form->get_index();

    $this->assertEquals(1,  count($index[$form->get_subresource_uri('dog')][RDF_TYPE]));
    $this->assertEquals('uri',  $index[$form->get_subresource_uri('dog')][RDF_TYPE][0]['type']);
    $this->assertEquals('http://example.org/Animal',  $index[$form->get_subresource_uri('dog')][RDF_TYPE][0]['value']);
  }


}

?>
