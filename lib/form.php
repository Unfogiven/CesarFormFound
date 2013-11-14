<?php

class form
{
    public $fields;
    protected $button_name;
    
    protected $css_td_class;
    protected $css_td_style;
    
    protected $css_fld_class;
    protected $css_fld_style;
    
    public function __construct(
                $flds,
                $button_name,
                $css_td_class = "",
                $css_td_style = "",
                $css_fld_class = "",
                $css_fld_style = ""
    )
    {
        $this->fields = $flds;
        $this->button_name = $button_name;
        $this->css_td_class = $css_td_class;
        $this->css_td_style = $css_td_style;
        $this->css_fld_class = $css_fld_class;
        $this->css_fld_style = $css_fld_style;
        
        foreach($flds as $key => $obj)
        {
            if(!is_subclass_of($obj, "field"))
            {
                throw new ExceptionObject($key, "\"{$key}\" не является элементом управления");
            }
        }
    }
    
    public function print_form()
    {
        $enctype = "";
        if(!empty($this->fields))
        {
            foreach($this->fields as $obj)
            {
                if(!empty($this->css_fld_class))
                {
                    $obj->css_class = $this->css_fld_class;
                }
                if(!empty($this->css_fld_style))
                {
                    $obj->css_style = $this->css_fld_style;
                }
                if($obj->type == "file")
                {
                    $enctype = "enctype='multipart/form-data'";
                }
            }
        }
        
        if(!empty($this->css_td_style))
        {
            $style = "style=\"".$this->css_td_style."\"";
        }
        else $style = "";
        if(!empty($this->css_td_class))
        {
            $class = "class=\"".$this->css_td_class."\"";
        }
        else $class = "";
        
        echo "<form name=form {$enctype} method=post action='{$_SERVER[PHP_SELF]}'>";
        echo "<table>";
        if(!empty($this->fields))
        {
            foreach($this->fields as $obj)
            {
                list($caption, $tag, $help, $alternative) = $obj->get_html();
                if(is_array($tag)) $tag = implode("<br />", $tag);
                switch($obj->type)
                {
                    case "hidden":
                        echo $tag;
                        break;
                    case "title":
                        echo "<tr>
                            <td $style $class colspan='2' valign='top'>$tag</td>
                        </tr>\n";
                        break;
                    default:
                        echo "<tr>
                        <td width=100
                        {$style} {$class} valign=top>{$caption}:</td>
                        <td {$style} {$class} valign=top>{$tag}</td>
                        </tr>\n";
                        if(!empty($help))
                        {
                            echo "<tr>
                                    <td>&nbsp;</td>
                                    <td {$style} {$class} valign=top>{$help}</td>
                                </tr>";
                        }
                        break;
                }

            }
        }
        echo "<tr>
            <td {$style} {$class}>
            <td {$style} {$class}>
                <input class=button type=submit
                 value=\"".htmlspecialchars($this->button_name, ENT_QUOTES)."\" />
            </td>
        </tr>\n";
        echo "</table>";
        echo "</form>";
    }
    
    public function __toString()
    {
        return $this->print_form();
    }
    
    public function check()
    {
        $arr = array();
        foreach($this->fields as $obj)
        {
            $str = $obj->check();
            if(!empty($str)) $arr[] = $str;
        }
        return $arr;
    }
    
}