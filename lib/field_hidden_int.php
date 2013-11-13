<?php

class field_hidden_int extends field_hidden{

    public function check()
    {
        if($this->is_required)
        {
            if(!preg_match("|^[\d]+$|", $this->value))
            {
                return "Скрытое поле должно быть целым числом";
            }
        }
        if(!preg_match("|^[\d]*$|", $this->value))
        {
            return "Скрытое поле должно быть целым числом";
        }

        return "";
    }

} 