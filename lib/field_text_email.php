<?php


class field_text_email extends field_text{

    function check()
    {
        if($this->is_required || !empty($this->value))
        {
            $pattern = "#^[-0-9a-z_\.]+@[-0-9a-z^\.]+\.[a-z]{2,6}$#i";
            if(!preg_match($pattern, $this->value))
            {
                return "Введите e-mail в виде <i>something@server.com</i>";
            }
        }

        return "";
    }

} 