<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;

class Dropdown extends Typography  
{
    public $screw;  // Droplet 
    
    protected $activeIndex; // int
    protected $isBuildButton; // boolean, build menu only
    protected $isBuildMenu; // boolean, build button only
    protected $alignment; // right/left
    protected $hasPopup; // boolean
    protected $expanded; // boolean
    
    private $button; // instance of a 
    private $menu; // instance of ul
    private static $typeArr = array ("btn-group", "dropdown", "dropup"); // 
    
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
        
        $this->button       = null;
        $this->menu         = null;
        $this->screw        = new Droplet();
        
        return $this;
    }
    
    /**
     * 渲染（佔位）
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {

        if ($this->isBuildButton == true && empty($this->button)) {
            $this->buildButton();
            $this->html = $this->button->render();
        }
        if ($this->isBuildMenu == true && empty($this->menu)) {
            $this->buildMenu();
            $this->html .= $this->menu->render ();
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
        $_a = new Typography("a");
        $_a->setCustomClass(array("dropdown-toggle"))
        ->setId()
        ->setInnerElements($this->text)
        ->setAttrs(array ( // 這些之後應該都要變成屬性
            "href" => "#",
            "data-toggle" => "dropdown",
            "role" => "button",
            "aria-haspopup" => json_encode($this->hasPopup),
            "aria-expanded" => json_encode($this->expanded) 
        ));
        
        $this->button = $_a;
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
     * @desc 設定 dropdown 樣式
     * {@inheritDoc}
     * @param string $type [btn-group|dropdown|dropup] 
     * @see \model\bootstrap\basic\Typography::setType()
     */
    public function setType ($type) {
        // @todo 這另人不解, 那 btn-group 要用 dropup 怎麼辦?
        $type = strtolower($type);
        if (!in_array($type, self::$typeArr)) {
            $type = "dropdown";
        }
        $this->type = $type;
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



