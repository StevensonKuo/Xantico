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
    protected $alignment; // right/left
    protected $hasPopup; // boolean
    protected $expanded; // boolean
    protected $isDropup; // boolean
    protected $isSplit; // boolean; for btn-group mode only
    
    private $button; // instance of a 
    private $menu; // instance of ul
    private $defaultIcon; // an arrow point down for dropdown btn.
    private static $modeArr = array ("btn-group", "button-group", "dropdown"); // 
    
    /**
     * 建構子
     * @param unknown $type
     * @param array $vars
     * @param array $attrs
     * @return \model\bootstrap\basic\Typography
     */
    public function __construct($vars = array ()) 
    {
        parent::__construct("", $vars);
        
        $this->type         = "dropdown";
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
        $this->defaultIcon  = new Icon("caret");
        $this->defaultIcon->setIconSet("");
    }
    
    /**
     * 渲染
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {

        if ($this->mode == "btn-group") {
            $btnGroup = new ButtonGroup();
            $btnGroup->setCustomClass($this->type);
            if ($this->isSplit == true) {
                if ($this->text) {// in split button dropdown, text will be set into a seperate button, 
                    $_splitBtn = new Button(array("text" => $this->text));
                    $btnGroup->setInnerElements($_splitBtn);
                } else if (!empty($this->innerElements)) { // or concat the innerElements.
                    $btnGroup->setInnerElements($this->innerElements);
                }
            }
            if ($this->isBuildButton == true && empty($this->button)) {
                $_btn = $this->buildButton();
                $btnGroup->setInnerElements($_btn);
            }
            if ($this->isBuildMenu == true && empty($this->menu)) {
                $_menu = $this->buildMenu();
                $btnGroup->setInnerElements($_menu);
            }
        } else {
            if ($this->isBuildButton == true && empty($this->button)) {
                $this->buildButton();
                $this->html = $this->button->render();
            }
            if ($this->isBuildMenu == true && empty($this->menu)) {
                $this->buildMenu();
                $this->html .= $this->menu->render ();
            }
        }
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    
    /**
     * @desc 建立觸發 dropdown 的那個按鈕(連結)
     */
    protected function buildButton () {
        
        if ($this->mode == "btn-group") {
            $_btn = new Button();
        } else {
            $_btn = new Typography("a");
        }
        
        $_btn->setCustomClass(array("dropdown-toggle"))
            ->setId()
            ->setAttrs(array ( // 這些之後應該都要變成屬性
                "href" => "#",
                "data-toggle" => "dropdown",
                "role" => "button",
                "aria-haspopup" => json_encode($this->hasPopup),
                "aria-expanded" => json_encode($this->expanded) 
            ));
        
        if (!empty($this->size)) { // size here are still in integer.
            $_btn->setSize($this->size);
        }
        // only a single icon. icon style control by parent class dropdown/dropup.
        $defaultText = new HtmlTag("span", array ("class" => "sr-only"));
        $defaultText->setInnerText("Toggle Dropdown");
        if ($this->isSplit == true) {
            $_btn->innerElements = array($this->defaultIcon, $defaultText);
        } else {
            $_btn->innerElements = array($this->text, $this->defaultIcon, $defaultText);
        }
        
        $this->button = $_btn;
    }
    
    /**
     * @desc 建立 dropdown 的 menu.
     */
    protected function buildMenu () {
        $_ul = new Typography("ul:dropdown-menu");
        if ($this->alignment == "right") {
            $_ul->setInnerElements("dropdown-menu-right");
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
            unset ($this->items); //已經都整理好交給 innerElements 了, 不用再 pass 給 Typograph 的 render 處理
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
    public function setIsDropup($isDropup)
    {
        $this->isDropup = $isDropup;
        $this->type = "dropup";
        
        return $this;
    }

    /**
     * @param field_type $mode [dropdown|btn-group]
     */
    public function setMode($mode)
    {
        $mode = strtolower($mode);
        if (in_array($mode, self::$modeArr)) {
            $this->mode = $mode;
        } else {
            // @todo format err msg.
            $this->setErrMsg("You set a wrong mode of Dropdown.");
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



