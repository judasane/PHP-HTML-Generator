<?php

/**
 * Description of HtmlElement
 * @author Juan
 */
abstract class HtmlElement {

    protected $html = "";
    protected $tagName;

    /**
     *
     * @var array Contains the order list of inner elements
     */
    protected $childList = array();

    /**
     * Attributes to be used in this element
     * @var array
     */
    protected $currentAttributes = array();

    /**
     * Attributes for the particular kind of element
     * @var array
     */
    protected $localAttributes = array();

    /**
     * Admitted attributes for the element
     * @var array
     */
    protected $admittedAttributes = array();

    /**
     * Admitted attributes for all kind of elements
     * @var type 
     */
    protected $globalAttributes = array(
        "accesskey" => "",
        "class" => "",
        "contenteditable" => array(
            "true",
            "false",
            "inherit"
        ),
        "contextmenu" => "",
        "dir" => "",
        "draggable" => array(
            "true",
            "false",
            "auto"
        ),
        "dropzone" => array(
            "copy",
            "move",
            "link"
        ),
        "hidden" => "hidden",
        "id" => "",
        "lang" => array(
            "ab",
            "aa",
            "af",
            "sq",
            "am",
            "ar",
            "an",
            "hy",
            "as",
            "ay",
            "az",
            "ba",
            "eu",
            "bn",
            "dz",
            "bh",
            "bi",
            "br",
            "bg",
            "my",
            "be",
            "km",
            "ca",
            "zh",
            "zh",
            "co",
            "hr",
            "cs",
            "da",
            "nl",
            "en",
            "eo",
            "et",
            "fo",
            "fa",
            "fj",
            "fi",
            "fr",
            "fy",
            "gl",
            "gd",
            "gv",
            "ka",
            "de",
            "el",
            "kl",
            "gn",
            "gu",
            "ht",
            "ha",
            "he",
            "iw",
            "hi",
            "hu",
            "is",
            "io",
            "id",
            "in",
            "ia",
            "ie",
            "iu",
            "ik",
            "ga",
            "it",
            "ja",
            "jv",
            "kn",
            "ks",
            "kk",
            "rw",
            "ky",
            "rn",
            "ko",
            "ku",
            "lo",
            "la",
            "lv",
            "li",
            "ln",
            "lt",
            "mk",
            "mg",
            "ms",
            "ml",
            "mt",
            "mi",
            "mr",
            "mo",
            "mn",
            "na",
            "ne",
            "no",
            "oc",
            "or",
            "om",
            "ps",
            "pl",
            "pt",
            "pa",
            "qu",
            "rm",
            "ro",
            "ru",
            "sm",
            "sg",
            "sa",
            "sr",
            "sh",
            "st",
            "tn",
            "sn",
            "ii",
            "sd",
            "si",
            "ss",
            "sk",
            "sl",
            "so",
            "es",
            "su",
            "sw",
            "sv",
            "tl",
            "tg",
            "ta",
            "tt",
            "te",
            "th",
            "bo",
            "ti",
            "to",
            "ts",
            "tr",
            "tk",
            "tw",
            "ug",
            "uk",
            "ur",
            "uz",
            "vi",
            "vo",
            "wa",
            "cy",
            "wo",
            "xh",
            "yi",
            "ji",
            "yo",
            "zu"
        ),
        "spellcheck" => array(
            "true",
            "false"
        ),
        "style" => "",
        "tabindex" => "",
        "title" => "",
        "translate" => array(
            "yes",
            "no"
        )
    );

    /**
     * Creates a new element, initializing the $admittedAttributes array
     */
    public function __construct($attributes="") {
        $this->setLocalAttributes();
        $this->admittedAttributes = array_merge(
                $this->globalAttributes, $this->localAttributes
        );
        if(!empty($attributes)){
            $this->setAttributes($attributes);
        }
    }
    
    protected abstract function setLocalAttributes();


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
        if(count($this->childList)>0){
            foreach ($this->childList as $value){
                $this->html.=$value->getHTML();
            }
        }
        $this->html.="</$element>";
        return $this->html;
    }

    /**
     * Appends an element inside the current element
     * @param HtmlElement $element The html element to be appended
     */
    public function appendChild(HtmlElement $element) {
        $this->childList[] = $element;
    }

}

?>
