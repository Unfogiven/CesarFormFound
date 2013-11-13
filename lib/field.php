<?php

abstract class field
{
    protected $name;
    protected $type;
    protected $caption;
    protected $value;
    protected $is_required;
    protected $parameters;
    protected $help;
    protected $help_url;
    
    public $css_class;
    public $css_style;
    
    function __construct(
        $name,
        $type,
        $caption,
        $is_required = false,
        $value = "",
        $parameters = "",
        $help = "",
        $help_url = ""
    )
    {
        $this->name = $this->encodestring($name);
        $this->type = $type;
        $this->caption = $caption;
        $this->value = $value;
        $this->is_required = $is_required;
        $this->parameters = $parameters;
        $this->help = $help;
        $this->help_url = $help_url;
    }
    
    abstract function check();
    abstract function get_html();
    
    
    public function __get($key)
    {
        if(isset($this->$key)) return $this->$key;
        else
        {
            throw new ExceptionMember($key,
                                    "Член ".__CLASS__."::{$key} не существует");    
        }
    }
    
    protected function encodestring($st)
    {
        $st = strtr($st, "абвгдеезийклмнопрстуфхъыэ_", "abvgdeeziyklmnoprstufh'iei");
        $st = strtr($st, "АБВГДЕЕЗИЙКЛМНОПРСТУФХЪЫЭ_", "ABVGDEEZIKLMNOPRSTUFH'IEI");
        $st = strtr($st, array(
            "ж" => "zh", "ц" => "ts", "ч" => "ch", "ш" => "sh",
            "щ" => "shch", "ь" => "", "ю" => "yu", "я" => " ya",
            "Ж" => "ZH", "Ц" => "TS", "Ч" => "CH", "Ш" => "SH",
            "Щ" => "SHCH", "Ь" => "", "Ю" => "YU", "Я" => "YA"
        ));
        
        return $st;
    }
}