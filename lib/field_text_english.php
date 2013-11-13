<?php
class field_text_english extends field_text{

    function check()
    {
        if(!get_magic_quotes_gpc())
        {
            $this->value = mysql_real_escape_string($this->value);
        }
        if($this->is_required) $pattern = "|^[a-z]+$|i";
        else $pattern = "|^[a-z]*$|i";

        if(!preg_match($pattern, $this->value))
        {
            return "Поле \"{$this->caption}\"
            должно только символы латинского алфавита";
        }

        return "";
    }
} 