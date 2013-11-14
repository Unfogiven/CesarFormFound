<?php
class field_file extends field{

    protected $dir;
    protected $prefix;

    public function __construct($name,
                        $caption,
                        $is_required = false,
                        $value,
                        $dir,
                        $prefix = "",
                        $help = "",
                        $help_url = "")
    {
        parent::__construct($name,
                        "file",
                        $caption,
                        $is_required,
                        $value,
                        "",
                        $help,
                        $help_url);
        $this->dir = $dir;
        $this->prefix = $prefix;
        if(!empty($this->value))
        {
            $extensions = array("#\.php#is",
                                "#\.phtml#is",
                                "#\.php3#is",
                                "#\.html#is",
                                "#\.htm#is",
                                "#\.hta#is",
                                "#\.pl#is",
                                "#\.xml#is",
                                "#\.inc#is",
                                "#\.shtml#is",
                                "#\.xht#is",
                                "#\.xhtml#is");
            $this->value[$this->name]['name'] = $this->encodestring($this->value[$this->name]['name']);
            $path_parts = pathinfo($this->value[$this->name]['name']);
            $ext = ".".$path_parts['extension'];
            $path = basename($this->value[$this->name]['name'], $ext);
            $add = $ext;
            foreach($extensions as $exten)
            {
                if(preg_match($exten, $ext)) $add = ".txt";
            }
            $path .= $add;
            $path = str_replace("//", "/", $dir."/".$prefix.$path);
            if(copy($this->value[$this->name]['tmp_name'], $path))
            {
                @unlink($this->value[$this->name]['tmp_name']);
                @chmod($path, 0644);
            }
        }
    }

    public function get_html()
    {
        if(!empty($this->css_style))
        {
            $style = "style=\"".$this->css_style."\"";
        }
        else $style = "";
        if(!empty($this->css_class))
        {
            $class = "class=\"".$this->css_class."\"";
        }
        else $class = "";

        $tag = "<input $class $style
                type=\"".$this->type."\"
                name=\"".$this->name."\">\n";

        $help = "";
        if(!empty($this->help))
        {
            $help .= "<span style='color:blue'>".
                nl2br($this->help)."</span>";
        }
        if(!empty($help)) $help .= "<br />";
        if(!empty($this->help_url))
        {
            $help .= "<span style='color:blue;'>
                <a href=".$this->help_url.">помощь</a>
            </span>";
        }

        return array($this->caption, $tag, $help);
    }

    public function check()
    {
        if($this->is_required)
        {
            if(empty($this->value[$this->name]))
            {
                return "Поле \"".$this->caption."\" не заполнено";
            }
        }

        return "";
    }

    function get_filename()
    {
        if(!empty($this->value[$this->name]['name']))
        {
            if(!empty($this->value[$this->name]['name']))
            {
                return mysql_real_escape_string($this->encodestring(
                    $this->prefix.$this->value[$this->name]['name']
                ));
            }
            else return "";
        }
        else return "";
    }
} 