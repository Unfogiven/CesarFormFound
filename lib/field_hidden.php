<?php
class field_hidden extends field{

    public function __construct($name,
                        $is_required = false,
                        $value = "")
    {
        parent::__construct($name,
        "hidden", "-", $is_required, $value, "", "", "");

    }

    public function get_html()
    {
        $tag = "<input type=\"".$this->type."\"
               name=\"".$this->name."\"
               value=\"".
               htmlspecialchars($this->value, ENT_QUOTES)."\">\n";
        return array("", $tag);
    }

    public function check()
    {
        if(!get_magic_quotes_gpc())
        {
            $this->value = mysql_real_escape_string($this->value);
        }
        if($this->is_required)
        {
            if(empty($this->value)) return "Скрытое поле не заполнено";
        }

        return "";
    }

} 