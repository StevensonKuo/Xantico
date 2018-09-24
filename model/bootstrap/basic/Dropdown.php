<?php
namespace model\bootstrap\basic;
// require_once 'model/bootstrap/basic/ButtonGroup.php';
// require_once 'model/bootstrap/basic/Icon.php';

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;
use model\bootstrap\basic\Icon;

class Dropdown extends Typography  
{
    public $screw;  // Droplet 
    
    protected $activeIndex; // int
    protected $isBuildButton; // boolean, build menu only
    protected $isBuildMenu; // boolean, build button only
    protected $hasPopup; // boolean
    protected $expanded; // boolean
    protected $isDropup; // boolean
    protected $isSplit; // boolean; for btn-group mode only
    
    private $button; // instance of a 
    private $menu; // instance of ul
    private $defaultIcon; // an arrow point down for dropdown btn.
    private static $modeArr = array ("button", "inline"); // inline mode will not enlose by any tag. 
    
    /**
     * @param unknown $type
     * @param array $vars
     * @param array $attrs
     * @return \model\bootstrap\basic\Typography
     */
    public function __construct($vars = array (), $attrs = array ()) 
    {
        parent::__construct("div:btn-group", $vars, $attrs);
        
        $this->type         = "dropdown";
        $this->mode         = "button";
        $this->activeIndex  = isset ($vars ['activeIndex']) ? $vars ['activeIndex'] : -1;
        $this->isBuildButton= isset ($vars ['isBuildButton']) ? $vars ['isBuildButton'] : true;
        $this->isBuildMenu  = isset ($vars ['isBuildMenu']) ? $vars ['isBuildMenu'] : true;
        $this->hasPopup     = isset ($vars ['hasPopup']) ? $vars ['hasPopup'] : true;
        $this->expanded     = isset ($vars ['expanded']) ? $vars ['expanded'] : false;
        $this->isDropup     = isset ($vars ['isDropup']) ? $vars ['isDropup'] : false;
        $this->isSplit      = isset ($vars ['isSplit']) ? $vars ['isSplit'] : false;
        
        $this->button       = null;
        $this->menu         = null;
        $this->screw        = new Droplet();
        $this->defaultIcon  = new Icon("caret", array ("iconSet" => ""));
    }
    
    /**
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        switch($this->mode) {
            default:
            case "button":
                $this->customClass [] = $this->type;
                if ($this->isSplit == true) {
                    if ($this->text) {// in split button dropdown, text will be set into a seperate button,
                        $_splitBtn = new Button(array("text" => $this->text));
                        if (!empty($this->colorSet)) $_splitBtn->setColorSet($this->colorSet);
                        if (!empty($this->size)) $_splitBtn->setColorSet($this->size);
                        $this->innerElements [] = $_splitBtn;
                    }
                }
                if ($this->isBuildButton == true) {
                    if (empty($this->button)) $this->buildButton();
                    $this->innerElements [] = $this->button;
                }
                if ($this->isBuildMenu == true) {
                    if (empty($this->menu)) $this->buildMenu();
                    $this->innerElements [] = $this->menu;
                }
                $this->text = null;
                
                parent::render();
                break;
            case "inline":
                if ($this->isBuildButton == true && empty($this->button)) {
                    $this->buildButton();
                    $this->html = $this->button->render();
                }
                if ($this->isBuildMenu == true && empty($this->menu)) {
                    $this->buildMenu();
                    $this->html .= $this->menu->render ();
                }
                break;
        }
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    
    /**
     * @desc the button trigger dropdown
     */
    protected function buildButton () {
        
        if ($this->mode == "button") {
            $_btn = new Button();
            $_btn->setCustomClass("btn");
            if (!empty($this->size)) $_btn->setSize($this->size);
            if (!empty($this->colorSet)) $_btn->setColorSet($this->colorSet);
        } else {
            $_btn = new Typography("a", null, array ("href" => "#"));
        }
        
        $_btn->setCustomClass(array("dropdown-toggle"))
            ->setId()
            ->setAttrs(array ( // @todo not actually know what they do.
                "data-toggle" => "dropdown",
                "role" => "button",
                "aria-haspopup" => json_encode($this->hasPopup),
                "aria-expanded" => json_encode($this->expanded) 
            ));
            
        // only a single icon. icon style control by parent class dropdown/dropup.
        if ($this->isSplit == true) {
            $_btn->innerElements = array($this->defaultIcon);
        } else {
            $_btn->innerElements = array($this->text, $this->defaultIcon);
        }
        
        $this->button = $_btn;
    }
    
    /**
     * @desc build the menu who drops down
     */
    protected function buildMenu () {
        $_ul = new Typography("ul:dropdown-menu");
        if ($this->align == "right") {
            $_ul->setCustomClass("dropdown-menu-right");
        }
        if ($this->button instanceof Typography && method_exists($this->button, "getId")) {
            $_id = $this->button->getId ();
        } else {
            $_id = "";
            self::setErrMsg("No id for dropdown menu labelled.");
        }
        $_ul->setAttrs(array(
            "aria-labelledby" => $_id  
        ));
        
        if (!empty($this->items)) {
            foreach ($this->items as $key => $item) {
                if ($item->text instanceof HtmlTag && $item->text->getTagName() == "li") {
                    continue;
                } else if (!($item instanceof Droplet)) {
                    self::setErrMsg("[Notice] Set wrong trivial class to Dropdown. Use Droplet in Dropdown.");
                } else if ($item->seperator == true) { // 分隔線
                    $_li = new HtmlTag("li");
                    $_li->setAttrs(array ("role" => "seperator"));
                    $_li->setCustomClass("divider")
                    ->setInnerText("\t");
                } else {
                    $_li = new HtmlTag("li");
                    if ($key == $this->activeIndex || $item->active == true) {
                        $_li->setCustomClass("active");
                    }
                    if ($item->head == true) {
                        $_li->setCustomClass("dropdown-header");
                        $item->url = "";
                    }
                    if ($item->disabled == true) {
                        $_li->setCustomClass("disabled");
                    }
                    
                    if (!empty($item->url)) {
                        $_ia = new HtmlTag("a");
                        $_ia->setAttrs(array ("href" => $item->url));
                        if (is_string($item->text)) {
                            $_ia->setInnerText($item->text);
                        } else {
                            $_ia->setInnerElements($item->text);
                        }
                        
                        $_li->setInnerElements($_ia);
                    } else {
                        $_li->setInnerElements($item->text);
                    }
                }
                
                $_ul->setInnerElements($_li);
                unset ($_li);
                unset ($_ia);
            }
            $this->items = null; 
        }
        
        $this->menu = $_ul;
    }
    
    /**
     * @return the $activeIndex
     */
    public function getActiveIndex()
    {
        return $this->activeIndex;
    }

    /**
     * @param field_type $activeIndex
     */
    public function setActiveIndex($activeIndex)
    {
        $this->activeIndex = $activeIndex;
        return $this;
    }
    
    /**
     * @deprecated 
     * @return the $hasPopup
     */
    public function getHasPopup()
    {
        return $this->hasPopup;
    }

    /**
     * @deprecated 
     * @return the $expanded
     */
    public function getExpanded()
    {
        return $this->expanded;
    }

    /**
     * @deprecated
     * @param Ambigous <boolean, array> $hasPopup
     */
    public function setHasPopup($hasPopup)
    {
        $this->hasPopup = $hasPopup;
        return $this;
    }

    /**
     * @deprecated 
     * @param Ambigous <boolean, array> $expanded
     */
    public function setExpanded($expanded)
    {
        $this->expanded = $expanded;
        return $this;
    }
    
    /**
     * @return the $isBuildButton
     */
    public function getIsBuildButton()
    {
        return $this->isBuildButton;
    }

    /**
     * @return the $isBuildMenu
     */
    public function getIsBuildMenu()
    {
        return $this->isBuildMenu;
    }

    /**
     * @param Ambigous <boolean, array> $isBuildButton
     */
    public function setIsBuildButton($isBuildButton = true)
    {
        $this->isBuildButton = $isBuildButton;
        return $this;
    }

    /**
     * @param Ambigous <boolean, array> $isBuildMenu
     */
    public function setIsBuildMenu($isBuildMenu = true)
    {
        $this->isBuildMenu = $isBuildMenu;
        return $this;
    }
    /**
     * @return the $button
     */
    public function getButton()
    {
        if (empty($this->button)) {
            $this->buildButton();
        }
        
        return $this->button;
    }

    /**
     * @return the $menu
     */
    public function getMenu()
    {
        if (empty($this->menu)) {
            $this->buildMenu();
        }
        
        return $this->menu;
    }

    /**
     * @param Ambigous <NULL, \model\bootstrap\basic\Typography> $button
     */
    public function setButton(HtmlTag $button)
    {
        $_attrs = $button->getAttrs();
        $_attrKeys = array_keys($_attrs);
        if (!in_array("data-toggle", $_attrKeys)) {
            $button->setAttrs(array("data-toggle" => "dropdown"));
        } 
        if (!in_array("role", $_attrKeys)) {
            $button->setAttrs(array("role" => "button"));   
        }
        if (!in_array("aria-haspopup", $_attrKeys)) {
            $button->setAttrs(array("aria-haspopup" => json_encode($this->hasPopup)));
        }
        if (!in_array("aria-expanded", $_attrKeys)) {
            $button->setAttrs(array ("aria-expanded" => json_encode($this->expanded)));
        }
        
        $this->button = $button;
        return $this;
    }

    /**
     * @param Ambigous <NULL, \model\bootstrap\basic\Typography> $menu
     */
    public function setMenu(HtmlTag $menu)
    {
        $this->menu = $menu;
        return $this;
    }

    /**
     * @desc 需要檢查是不是 droplet 的物件.
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::setItems()
     */
    public function setItems($items) {
        if (!empty($items)) {
            for ($i = 0; $i < count($items); $i ++) {
                if (is_array ($items[$i])) {
                    $_text = isset($items[$i] ['text']) ? $items[$i] ['text'] : 0;
                    $_url = isset($items[$i] ['url']) ? $items[$i] ['url'] : "";
                    $_head = isset($items[$i] ['head']) ? $items[$i] ['head'] : false;
                    $_seperator = isset($items[$i] ['seperator']) ? $items[$i] ['seperator'] : false;
                    $_active = isset($items[$i] ['active']) ? $items[$i] ['active'] : false;
                    $_disabled = isset($items[$i] ['disabled']) ? $items[$i] ['disabled'] : false;
                    
                    $items[$i] = new Droplet($_text, $_url, $_head, $_seperator, $_active, $_disabled);
                } else if (!($items[$i] instanceof Droplet)) {
                    // $items[$i] = new Droplet($items[$i]);
                    unset ($items[$i]);
                }
            }
        }
        $this->items = $items;
        return $this;
    }
    
    /**
     * @return the $alignment
     */
    public function getAlignment()
    {
        return $this->alignment;
    }

    /**
     * @param field_type $alignment [right|left]
     */
    public function setAlignment($alignment)
    {
        if (in_array ($alignment, array ("left", "right"))) {
            $this->alignment = $alignment;
        } else {
            $this->alignment = "left";
        }
        
        return $this;
    }
    
    /**
     * @return the $isDropup
     */
    public function getIsDropup()
    {
        return $this->isDropup;
    }

    /**
     * @param Ambigous <boolean, array> $isDropup
     */
    public function setIsDropup($isDropup = true)
    {
        $this->isDropup = $isDropup;
        if ($isDropup == true) $this->type = "dropup";
        
        return $this;
    }

    /**
     * @desc mode : [button|inline]
     * @param field_type $mode [button|inline]
     */
    public function setMode($mode)
    {
        $mode = strtolower($mode);
        if (in_array($mode, self::$modeArr)) {
            $this->mode = $mode;
        } else {
            // @todo format err msg.
            $this->setErrMsg("[Notice] You set a wrong mode of Dropdown. Default mode is button");
        }
        
        return $this;
    }
    
    /**
     * @return the $isSplit
     */
    public function getIsSplit()
    {
        return $this->isSplit;
    }

    /**
     * @param Ambigous <boolean, array> $isSplit
     */
    public function setIsSplit($isSplit = true)
    {
        $this->isSplit = $isSplit;
        return $this;
    }

    /**
     * @desc three sizes [xs|sm|lg]
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
    
}

/**
 * @desc dropdown menu 項目用小物件
 * @author metatronangelo
 *
 */
class Droplet {
    var $text; //string 
    var $url; // string
    var $head; // boolean
    var $seperator; // boolean
    var $active; // boolean
    var $disabled; // boolean
    
    public function __construct($text = "", $url = "", $head = false, $seperator = false, $active = false, $disabled = false) {
        $this->text = $text;
        $this->url = $url;
        $this->head = $head;
        $this->seperator = $seperator; 
        $this->active = $active;
        $this->disabled = $disabled;
    }
}



