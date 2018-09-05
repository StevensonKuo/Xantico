<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Badge;
use model\bootstrap\basic\Icon;
use model\bootstrap\HtmlTag;

class Button extends Typography 
{
    protected $icon; // Icon
    protected $badge; // Badge
    protected $isBlock; // boolean
    protected $isSubmit; // boolean
    protected $isReset; // boolean
    protected $isDisabled; // boolean
    protected $isOutline; // boolean
    protected $isLink; // boolean; use a tag
    protected $url; // string
    
    public function __construct($vars = array (), $attr = array())
    {
        $this->url          = key_exists('url', $vars) ? $vars ['url'] : "";
        if (!empty($this->url)) {
            parent::__construct("a:btn", $vars, $attr);
        } else {
            parent::__construct("button:btn", $vars, $attr);
        }
        
        $this->badge        = key_exists('badge', $vars) && $vars ['badge'] instanceof Badge ? $vars ['badge'] : null;
        $this->icon         = key_exists('icon', $vars) && $vars ['icon'] instanceof Icon ? $vars ['icon'] : null;
        $this->isBlock      = key_exists('isBlock', $vars) ? $vars ['isBlock'] : false;
        $this->isSubmit     = key_exists('isSubmit', $vars) ? $vars ['isSubmit'] : false;
        $this->isReset      = key_exists('isReset', $vars) ? $vars ['isReset'] : false;
        $this->isDisabled   = key_exists('isDisabled', $vars) ? $vars ['isDisabled'] : false;
        $this->isOutline    = key_exists('isOutline', $vars) ? $vars ['isOutline'] : false;
        $this->isLink       = key_exists('isLink', $vars) ? $vars ['isLink'] : false;
        
        return $this;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::render()
     */
    public function render ($display = false) {
//         $jQuery = "";
        $_text = "";
        $class = array ();
        if ($this->isLink == true)          $class [] = "btn-link";
        else if (!empty($this->colorSet))   $class [] = "btn-" . $this->colorSet;
        if (!empty($this->size))            $class [] = "btn-" . $this->size;
        if (!empty($this->border))          $class [] = "btn-" . $this->border;
        if ($this->isBlock == true)         $class [] = "btn-block";
        if ($this->isOutline == true)       $class [] = "btn-outline";
        
        $buttonAttrs = array ();
        if (!empty($this->title))               $buttonAttrs ['title']      = $this->title;
        if (!empty($this->url)) {
            $this->setTagName("a"); // 把按鈕改為 a 標籤
            $buttonAttrs ['href'] = $this->url;
            if ($this->isDisabled == true)      $class []   = "disabled";
        } else {
            if ($this->isSubmit == true)        $buttonAttrs ['type']       = "submit";
            else if ($this->isReset == true)    $buttonAttrs ['type']       = "reset";
            else                                $buttonAttrs ['type']       = "button";
            if ($this->isDisabled == true)      $buttonAttrs ['disabled']   = "disabled";
        }
        
        $this->setCustomClass($class);
        $this->setAttrs($buttonAttrs);
        
        if (!empty($this->textClass)) {
            $textSpan = new HtmlTag("span");
            $textSpan->setInnerText($this->text)
                ->setCustomClass($this->textClass);
            $_text = $textSpan;
        } else {
            try {
                $_text = $this->text;
            } catch (\Exception $e) {
                return;
            }
        }
        unset($this->text); // !!! innerText 和 innerElements 只能擇一
        
        if (!empty($this->badge) && $this->badge->getAlign() == "left") { // badge 優先
            $this->setInnerElements($this->badge);
        }
        if (!empty($this->icon) && $this->icon->getAlign() == "left") {
            $this->setInnerElements($this->icon);
            
        }
        $this->setInnerElements($_text);
        if (!empty($this->icon) && $this->icon->getAlign() == "right") {
            $this->setInnerElements($this->icon);
        }
        if (!empty($this->badge) && $this->badge->getAlign() == "right") {
            $this->setInnerElements($this->badge);
        }

        parent::render();
        
//         $this->jQuery .= $jQuery;
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    
    /**
     * @param string $colorSet
     * default
     * primary
     * info
     * success
     * warning
     * danger
     * inverse
     * pink
     * yellow
     * purple
     * grey
     * light
     * white
     */
    public function setColorSet($colorSet = "default")
    {
        $this->colorSet = strtolower($colorSet);
        return $this;
    }
    
    /**
     * 按鈕大小
     * 可輸入 1~5, 數字愈大按鈕愈大 [xs|sm|lg]
     * @param string $size
     */
    public function setSize($size)
    {
        switch ($size) {
            case 1:
//                 $this->size = "miner";
                $this->size = ""; // preserved.
                break;
            case 2:
                $this->size = "xs";
                break;
            case 3:
                $this->size = "sm";
                break;
            case 4:
                $this->size = "";
                break;
            case 5:
                $this->size = "lg";
                break;
            default:
                $this->size = $size;
                
        }
        
        return $this;
    }
    
    /**
     * @param Ambigous <NULL, \Bootstrap\Aceadmin\Typography> $badge
     */
    public function setBadge(Badge $badge)
    {
        $this->badge = $badge;
        return $this;
    }
    
    /**
     * @param boolean $isSubmit
     */
    public function setIsSubmit($isSubmit = true)
    {
        $this->isSubmit = $isSubmit;
        return $this;
    }
    /**
     * @param Ambigous <NULL, \Bootstrap\Aceadmin\Icon> $icon
     */
    public function setIcon(Icon $icon)
    {
        $this->icon = $icon;
        return $this;
    }
    
    /**
     * @param field_type $url
     */
    public function setUrl($url = "")
    {
        $this->url = $url;
        return $this;
    }
    
    /**
     * @desc disabled button
     * @param string $isDisabled
     * @return boolean
     */
    public function setIsDisabled ($isDisabled = true) {
        $this->isDisabled = $isDisabled;
        
        return true;
    }
    
    /**
     * @return boolean $isOutline
     */
    public function getIsOutline()
    {
        return $this->isOutline;
    }

    /**
     * @param field_type $isOutline
     */
    public function setIsOutline($isOutline = true)
    {
        $this->isOutline = $isOutline;
        return $this;
    }
    
    /**
     * @return the $isBlock
     */
    public function getIsBlock()
    {
        return $this->isBlock;
    }

    /**
     * @param field_type $isBlock
     */
    public function setIsBlock($isBlock = true)
    {
        $this->isBlock = $isBlock;
        return $this;
    }
    
    /**
     * @return the $isReset
     */
    public function getIsReset()
    {
        return $this->isReset;
    }

    /**
     * @param field_type $isReset
     */
    public function setIsReset($isReset = true)
    {
        $this->isReset = $isReset;
        return $this;
    }
    
    /**
     * @return the $isLink
     */
    public function getIsLink()
    {
        return $this->isLink;
    }

    /**
     * @param Ambigous <boolean, \model\bootstrap\basic\Icon> $isLink
     */
    public function setIsLink($isLink = true)
    {
        $this->isLink = $isLink;
        return $this;
    }

    
    
}
