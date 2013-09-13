<?php

/**
 * Constant wrapper class
 * @author Juan
 */
class Constants {

    private static $emptyTags = array(
        'img', 'br', 'hr', 'input', 'area', 'link', 'meta', 'param'
    );

    /**
     * List of admitted elements for work with the generator
     * @var array 
     */
    private static $admittedElements = array(
        "div", "form"
    );

    /**
     * Admitted attributes for all kind of elements
     * @var array 
     */
    private static $globalAttributes = array(
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
            "ab", "aa", "af", "sq", "am", "ar", "an", "hy", "as", "ay", "az",
            "eu", "bn", "dz", "bh", "bi", "br", "bg", "my", "be", "km", "ca",
            "zh", "co", "hr", "cs", "da", "nl", "en", "eo", "et", "fo", "fa",
            "fi", "fr", "fy", "gl", "gd", "gv", "ka", "de", "el", "kl", "gn",
            "ht", "ha", "he", "iw", "hi", "hu", "is", "io", "id", "in", "ia",
            "iu", "ik", "ga", "it", "ja", "jv", "kn", "ks", "kk", "rw", "ky",
            "ko", "ku", "lo", "la", "lv", "li", "ln", "lt", "mk", "mg", "ms",
            "mt", "mi", "mr", "mo", "mn", "na", "ne", "no", "oc", "or", "om",
            "pl", "pt", "pa", "qu", "rm", "ro", "ru", "sm", "sg", "sa", "sr",
            "st", "tn", "sn", "ii", "sd", "si", "ss", "sk", "sl", "so", "es",
            "sw", "sv", "tl", "tg", "ta", "tt", "te", "th", "bo", "ti", "to",
            "tr", "tk", "tw", "ug", "uk", "ur", "uz", "vi", "vo", "wa", "cy",
            "xh", "yi", "ji", "yo", "zu", "ba", "fj", "gu", "ie", "rn", "ml",
            "ps", "sh", "su", "ts", "wo"
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
     * Admitted attributes for form elements 
     * @var array
     */
    private static$form = array(
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
    
    private static $div=array();

    /**
     * Returns the admitted attributes for an element.
     * @param string $elementType the name of the element.
     * @return boolean|array False if the element is not admitted, or an array 
     * containing the admitted values for the given element. If the given string
     * is empty, returns an array containing the global admitted attributes for
     * all html elements.
     */
    public static function getAdmittedAttributes($elementType = "") {
        $elementType = strtolower($elementType);
        if (!empty($elementType)) {
            if (in_array($elementType, self::$admittedElements)) {
                return array_merge(self::$globalAttributes, self::$$elementType);
            } else {
                return array();
            }
        } else {
            return self::$globalAttributes;
        }
    }
    
    /**
     * Is the element an empty element?
     * @param string $elementType
     * @return boolean
     */
    public static function isEmptyElement($elementType = "") {
        $elementType = strtolower($elementType);
        return (in_array($elementType, self::$emptyTags))?true:false;
    }

}
?>
