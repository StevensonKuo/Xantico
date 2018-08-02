<?php
namespace model\bootstrap\basic;


class Slider 
{
    
    protected $type; // string: top-menu, right-menu, bottom-menu, settings-box
    protected $id; // string
    protected $name; // string
    protected $header; // string
    protected $body; // string
    protected $scrollBar = true;
    protected $closeBtn = true;
    protected $colorSet; // string
    protected $width; // int
    protected $height; // int
    protected $isHidden = true; 
    
    protected $html;
    protected $jQuery;
    
    public function __construct($type, $vars = array ())
    {
        $this->type = $type;
        $this->id = $vars ['id'];
        $this->name = $vars ['name'];
        $this->scrollBar = isset($vars ['scrollBar']) ? $vars ['scrollBar'] : $this->scrollBar;
        $this->closeBtn = isset($vars ['closeBtn']) ? $vars ['closeBtn'] : $this->closeBtn;
        $this->isHidden = isset($vars ['isHidden']) ? $vars ['isHidden'] : $this->isHidden;
        
        return $this;
    }

    /**
     * @desc 渲染（佔位）
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        if ($display)
            echo $this->html;
            else
                return $this->html;
    }
    
    /**
     * @desc magic function to string.
     * @return string
     */
    function __toString()
    {
        if ($this->html)
            return $this->html;
            else
                return $this->render();
    }
    
    /**
     * @param field_type $type
     */
    public function setType($type)
    {
        $this->type = $type;
        
        return $this;
    }

    /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }

    /**
     * @param field_type $name
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * @param field_type $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
        
        return $this;
    }

    /**
     * @param field_type $body
     */
    public function setBody($body)
    {
        $this->body = $body;
        
        return $this;
    }
    
    /**
     * @param Ambigous <boolean, unknown> $scrollBar
     */
    public function setScrollBar($scrollBar)
    {
        $this->scrollBar = $scrollBar;
        
        return $this;
    }
    /**
     * @param Ambigous <boolean, unknown> $closeBtn
     */
    public function setCloseBtn($closeBtn)
    {
        $this->closeBtn = $closeBtn;
        
        return $this;
    }

    /**
     * it's necessary, html render always call getJQuery function.
     */
    public function getJQuery()
    {
        return $this->jQuery;
    }
    /**
     * @param field_type $colorSet
     */
    public function setColorSet($colorSet)
    {
        $this->colorSet = $colorSet;
        return $this;
    }

    /**
     * @param field_type $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @param field_type $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }
    /**
     * @param Ambigous <boolean, unknown> $hidden
     */
    public function setIsHidden($isHidden)
    {
        $this->isHidden = $isHidden;
        return $this;
    }




}

