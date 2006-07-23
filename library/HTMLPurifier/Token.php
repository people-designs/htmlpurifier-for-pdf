<?php

// all objects here are immutable

class HTMLPurifier_Token {} // abstract

class HTMLPurifier_Token_Tag extends HTMLPurifier_Token // abstract
{
    var $is_tag = true;
    var $name;
    var $attributes = array();
    function HTMLPurifier_Token_Tag($name, $attributes = array()) {
        $this->name = ctype_lower($name) ? $name : strtolower($name);
        $this->attributes = $attributes;
    }
}

// start CONCRETE ones

class HTMLPurifier_Token_Start extends HTMLPurifier_Token_Tag
{
    var $type = 'start';
}

class HTMLPurifier_Token_Empty extends HTMLPurifier_Token_Tag
{
    var $type = 'empty';
}

// accepts attributes even though it really can't, for optimization reasons
class HTMLPurifier_Token_End extends HTMLPurifier_Token_Tag
{
    var $type = 'end';
}

class HTMLPurifier_Token_Text extends HTMLPurifier_Token
{
    var $name = '#PCDATA';
    var $type = 'text';
    var $data;
    var $is_whitespace = false;
    function HTMLPurifier_Token_Text($data) {
        $this->data = $data;
        if (ctype_space($data)) $this->is_whitespace = true;
    }
    function append($text) {
        return new HTMLPurifier_Token_Text($this->data . $text->data);
    }
}

class HTMLPurifier_Token_Comment extends HTMLPurifier_Token
{
    var $data;
    var $type = 'comment';
    function HTMLPurifier_Token_Comment($data) {
        $this->data = $data;
    }
}

?>