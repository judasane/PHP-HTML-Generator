<?php

require_once './HtmlElement.php';
/**
 * Description of Div
 *
 * @author Juan
 */
class Div extends HtmlElement{
    
    public function __construct($arguments="") {
        parent::__construct($arguments);
        $this->tagName="div";
    }

    protected function setLocalAttributes() {
        
    }

}

?>
