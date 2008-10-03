<?php
/*
filegenerator.class.php
Copyright (C) 2008 Ian Davis.

This program is free software; you can redistribute it and/or modify it under the 
terms of the GNU General Public License as published by the Free Software
Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT 
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
for more details.

You should have received a copy of the GNU General Public License along with this 
program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, 
Suite 330, Boston, MA 02111-1307 USA
*/

class PAGET_FileGenerator {
  var $_config = array();
  var $_filename;
  var $_type;
  
  function __construct(&$config, &$params) {
    $this->_config = $config;  
    $this->_filename = $params['file'];
    if (isset($params['type'])) {
      $this->_type = $params['type'];
    }
    else {
      $this->_type = 'rdfxml';
    }
  }
  
  function process(&$desc, $request) {
    $data = file_get_contents($this->_filename);
    if ( $this->_type === 'rdfxml' ) {
      $desc->add_rdfxml($data);
    }
    else if ( $this->_type === 'turtle' ) {
      $desc->add_turtle($data);
    }
    else if ( $this->_type === 'json' ) {
      $desc->add_json($data);
    }
  }

}
