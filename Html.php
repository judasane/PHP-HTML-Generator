<?php

require_once './constants.php';

/**
 * Html generator class
 * @author Juan_David_Sanchez_Neme
 */
class Html {

    /**
     * Array containing the warnings generated within the element
     * @var array
     */
    public $warnings = array();

    /**
     * The text content for the element
     * @var string
     */
    protected $text = "";

    /**
     * Does the element can have content?
     * @var boolean
     */
    protected $isEmptyElement = null;

    /**
     * The generated html code
     * @var string 
     */
    protected $html = "";

    /**
     * Element type
     * @var string
     */
    protected $tagName = "";

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
        $warnings = $this->checkAttributes($attributes);
        $this->warnings = array_merge($this->warnings, $warnings);
        $this->currentAttributes = array_merge($attributes, $this->currentAttributes);
    }

    /**
     * Checks if the given attributes are valid
     * @param array $attributes Associative array of attributes=>values
     * @return boolean
     */
    private function checkAttributes($attributes) {
        $valid = false;
        $warnings = array();
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
                        $warnings[] = array(
                            "Type" => "Not admitted value",
                            "Element"=>$this->tagName,
                            "Attribute" => $attribute,
                            "Value" => $value);
                    }
                } else { //if there is not an array of admitted values, checks if the given value is valid
                    //Checks if the given value matches with the valid values
                    if ($admittedValues == $value) {
                        $valid = true;
                    } elseif ($admittedValues == "") {//It's up to the user the validity of the value
                        $valid = true;
                    } else {
                        $warnings[] = array(
                            "Type" => "Not admitted value",
                            "Element"=>$this->tagName,
                            "Attribute" => $attribute,
                            "Value" => $value);
                    }
                }
            } else {
                $warnings[] = array(
                    "Type" => "Not admitted attribute",
                    "Element"=>$this->tagName,
                    "Attribute" => $attribute,
                    "Value" => $value);
            }
        }
        if (!empty($warnings)) {
            return $warnings;
        }
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

    public function setText($text) {
        if (!$this->isEmptyElement) {
            $this->childList[] = $text;
        } else {
            return false;
        }
    }

    /**
     * Converts the element into valid HTML code
     * @paramn boolean Do you want to show warnings? (as html comments)
     * @return String The string with the valid HTML code ready to use
     */
    public function toString($showWarnings = false) {
        $element = $this->tagName;
        $this->html.="<$element";
        foreach ($this->currentAttributes as $attribute => $value) {
            $this->html.=" $attribute=\"$value\"";
        }
        if (!$this->isEmptyElement) {
            $this->html.=">";
            if (count($this->childList) > 0) {
                foreach ($this->childList as $value) {
                    if (!is_string($value)) {
                        $this->html.=$value->toString();
                        $this->warnings=  array_merge($this->warnings,$value->warnings);
                    } else {
                        $this->html.=$value;
                    }
                }
            }
            $this->html.="</$element>";
        } else {
            $this->html.="/>";
        }
        if ($showWarnings) {
            $this->html.="\n<!--Warnings found: ". count($this->warnings) ."-->\n";
            $i = 1;
            foreach ($this->warnings as $subArray) {
                $Type=$subArray["Type"];
                $Element=$subArray["Element"];
                $Attribute=$subArray["Attribute"];
                $value=$subArray["Value"];
                $this->html.="<!--$i: Element:$Element Warning Type:$Type, Attribute: $Attribute, Value: $value-->\n";
                $i++;
            }
        }
        return $this->html;
    }

}

?>
