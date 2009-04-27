<?php
require_once 'paget_widget.class.php';

class PAGET_LiteralWidget extends PAGET_Widget {

  function render($resource_info, $inline = FALSE, $brief = FALSE) {
    return $this->render_literal($resource_info, $inline, $brief);
  }  

}
