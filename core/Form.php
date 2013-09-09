<?php

require_once './HtmlElement.php';

/**
 * Description of Form
 *
 * @author Juan
 */
class Form extends HtmlElement {

    /**
     *  Admitted attributes for Form elements
     * @var array 
     */
    public function __construct($arguments = "") {
        parent::__construct($arguments);
        $this->tagName = "form";
    }

    public function getAdmittedAttributes() {
        return $this->admittedAttributes;
    }

    protected function setLocalAttributes() {
        
        $this->localAttributes = array(
            "accept-charset" => array(
                "ISO-8859-1",
                "ISO-8859-2",
                "ISO-8859-3",
                "ISO-8859-4",
                "ISO-8859-5",
                "ISO-8859-6",
                "ISO-8859-7",
                "ISO-8859-8",
                "ISO-8859-9",
                "ISO-8859-10",
                "ISO-8859-15",
                "ISO-2022-JP",
                "ISO-2022-JP-2",
                "ISO-2022-KR",
                "UTF-8",
                "UTF-16"
            ),
            "action" => "",
            "autocomplete" => array(
                "on",
                "off"
            ),
            "enctype" => array(
                "application/x-www-form-urlencoded",
                "multipart/form-data",
                "text/plain"
            ),
            "method" => array(
                "POST",
                "GET"
            ),
            "name" => "",
            "novalidate" => "novalidate",
            "target" => array(
                "_blank",
                "_self",
                "_parent",
                "_top"
            )
        );
    }

}

?>
