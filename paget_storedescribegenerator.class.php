<?php
/*
storedescribegenerator.class.php
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

class PAGET_StoreDescribeGenerator {
  var $_config = array();
  var $_storename;
  
  function __construct(&$config, &$params) {
    $this->_config = $config;  
    $this->_storename = $params['store'];
  }
  
  function process(&$desc, $request) {

    $store = new Store($this->_storename);
    $mb = $store->get_metabox();
    $response = $mb->describe($desc->uri);
    if ($response->is_success()) {
      $desc->add_rdfxml($response->body);
    }
  }

}
