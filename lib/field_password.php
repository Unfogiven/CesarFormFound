<?php

class field_password extends field_text{

    public function __construct($name, $caption, $is_required = false, $value = "", $maxlength = 255, $size = 41, $parameters = "", $help = "", $help_url = "")
    {
        parent::__construct($name, $caption, $is_required, $value, $parameters, $help, $help_url);
        $this->type = "password";
    }

}
