<?php
class field_text_int extends field_text{

    protected $min_value;
    protected $max_value;

    public function __construct($name,
                        $caption,
                        $is_required = false,
                        $value = "",
                        $min_value = 0,
                        $max_value = 0,
                        $maxlength = 255,
                        $size = 41,
                        $parameters = "",
                        $help = "",
                        $help_url = "")
    {
        parent::__construct(
            $name,
            $caption,
            $is_required,
            $value,
            $maxlength,
            $size,
            $parameters,
            $help,
            $help_url
        );

        $this->min_value = intval($min_value);
        $this->max_value = intval($max_value);

        if($this->min_value > $this->max_value)
        {
            throw new Exception("Минимальное значение должно быть меньше
            максимального значения. Поле \"{$this->caption}\"");
        }
    }

    public function check()
    {
        $pattern = "|^[-\d]*$|i";
        if($this->is_required)
        {
            if($this->min_value != $this->max_value)
            {
                if(($this->value < $this->min_value) ||($this->value > $this->max_value))
                {
                    return "Поле \"{$this->caption}\" должно быть
                    больше ".$this->min_value." и меньше ".$this->max_value;
                }
            }
            $pattern = "|^[-\d]+$|i";
        }
        if(!preg_match($pattern, $this->value))
        {
            return "Поле \"{$this->caption}\" должно содержать только цифры";
        }
        return "";
    }

} 