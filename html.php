<?php

require_once './constants.php';

/**
 * Html generator class
 * @author Juan_David_Sanchez_Neme
 * @link http://judasane.github.io My professional website
 */
class Html {
    
    /**
     * Does the element can have content?
     * @var boolean
     */
    protected $isEmptyElement;

    /**
     * The generated html code
     * @var string 
     */
    protected $html = "";

    /**
     * Element type
     * @var string
     */
    protected $tagName;

    /**
     * Contains the order list of inner elements
     * @var array 
     */
    protected $childList = array();

    /**
     * Attributes to be used in this element
     * @var array
     */
    protected $currentAttributes = array();

    /**
     * Admitted attributes for the element
     * @var array
     */
    protected $admittedAttributes = array();

    /**
     * Creates a new element, initializing the $admittedAttributes array
     */
    public function __construct($element = "", $attributes = "") {
        $this->tagName = $element;
        $this->admittedAttributes = Constants::getAdmittedAttributes($element);
        $this->isEmptyElement = Constants::isEmptyElement($element);
        if (!empty($attributes)) {
            $this->setAttributes($attributes);
        }
    }

    /**
     * Sets attributes to the element
     * @param array $attributes Associative array of valid attributes=>values
     */
    public function setAttributes($attributes) {

        $return = $this->checkAttributes($attributes);
        if ($return) {
            $this->currentAttributes = array_merge($attributes, $this->currentAttributes);
        }
        return $return;
    }

    /**
     * Checks if the given attributes are valid
     * @param array $attributes Associative array of attributes=>values
     * @return boolean
     */
    private function checkAttributes($attributes) {
        $valid = false;
        $cadenaPruebas = "";
        foreach ($attributes as $attribute => $value) {
            $valid = false;
            //First checks if the attribute name is admitted 
            if (array_key_exists($attribute, $this->admittedAttributes)) {
                //Checks if the value is admitted
                $admittedValues = $this->admittedAttributes[$attribute];
                //Checks if there is an array of admitted values for the given attribute
                if (is_array($admittedValues)) {
                    //If exists, checks if the given value is in the array
                    if (in_array($value, $admittedValues)) {
                        $valid = true;
                    } else {
                        return $valid;
                    }
                } else { //if there is not an array of admitted values, checks if the given value is valid
                    //Checks if the given value matches with te valid value
                    if ($admittedValues == $value) {
                        $valid = true;
                    } elseif ($admittedValues == "") {//It's up to the user the validity of the value
                        $valid = true;
                    } else {
                        return $valid;
                    }
                }
            } else {
                return $valid;
            }
        }
        return $valid;
    }

    /**
     * Converts the element into valid HTML code
     * @return String The string with the valid HTML code ready to use
     */
    public function getHtml() {
        $element = $this->tagName;
        $this->html.="<$element";
        foreach ($this->currentAttributes as $attribute => $value) {
            $this->html.=" $attribute=\"$value\"";
        }
        $this->html.=">";
        if (count($this->childList) > 0) {
            foreach ($this->childList as $value) {
                $this->html.=$value->getHTML();
            }
        }
        $this->html.="</$element>";
        return $this->html;
    }

    /**
     * Appends an element inside the current element
     * @param Html $element The html element to be appended
     * @return boolean Returns false if is an empty elemnt
     */
    public function appendChild(Html $element) {
        if (!$this->isEmptyElement) {
            $this->childList[] = $element;
        } else {
            return false;
        }
    }

    public function setClass($classes) {

        $classContent = "";
        if (is_array($classes)) {
            foreach ($classes as $value) {
                if (empty($classContent)) {
                    $classContent.=$value;
                } else {
                    $classContent.=" $value";
                }
            }
        } elseif (is_string($classes)) {
            $classContent = $classes;
        }
        $this->currentAttributes["class"] = $classContent;
    }

}

?>
