<?php
class field_title extends field
{
    protected $h_type;

    public function __construct($value = "", $h_type = 3, $parameters = "")
    {
        parent::__construct("", "title", "", false, $value, $parameters, "", "");
        if($h_type > 0 && $h_type < 7) $this->h_type = $h_type;
        else $this->h_type = 3;
    }

    public function get_html()
    {
        $tag = htmlspecialchars($this->value, ENT_QUOTES);
        $pattern = "#\[b\](.+)\[\/b\]#isU";
        $tag = preg_replace($pattern, "<b>\\1</b>", $tag);
        $pattern = "#\[i\](.+)\[\/i\]#isU";
        $tag = preg_replace($pattern, "<i>\\1</i>", $tag);
        $pattern = "#\[url\][\s]*((?=http:)[\S]*)[\s]*\[\/url\]#si";
        $tag = preg_replace($pattern, '<a href="\\1" target=_blank>\\1</a>', $tag);
        $pattern =
        "#\[url[\s]*=[\s]*((?=http:)[\S]+)[\s]*\][\s]*([^\[]*)\[/url\]#isU";
        $tag = preg_replace($pattern, '<a href="\\1" target=_blank>\\2</a>', $tag);
        if(get_magic_quotes_gpc()) $tag = stripcslashes($tag);
        $tag = "<h".$this->h_type.">".$this->value."</h".$this->h_type.">";
        return array($this->caption, $tag);
    }

   public function check()
   {
       return "";
   }
} 