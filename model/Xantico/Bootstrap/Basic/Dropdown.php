<?php

namespace Xantico\Bootstrap\Basic;

use Xantico\Bootstrap\HtmlTag;

class Dropdown extends Typography
{
    private static $modeArr = array("button", "inline");  // Droplet

    public $screw; // int

    protected $activeIndex; // boolean, build menu only
    protected $isBuildButton; // boolean, build button only
    protected $isBuildMenu; // boolean
    protected $hasPopup; // boolean
    protected $expanded; // boolean
    protected $isDropup; // boolean; for btn-group mode only
    protected $isSplit; // an arrow point down for dropdown btn.
    protected $dropdownIcon; // instance of a

    private $button; // instance of ul
    private $menu; // inline mode will not enlose by any tag.

    /**
     * Dropdown constructor.
     * @param array $vars
     * @param array $attrs
     */
    public function __construct($vars = array(), $attrs = array())
    {
        parent::__construct("div:btn-group", $vars, $attrs);

        $this->type = "dropdown";
        $this->mode = "button";
        $this->activeIndex = isset ($vars ['activeIndex']) ? $vars ['activeIndex'] : -1;
        $this->isBuildButton = isset ($vars ['isBuildButton']) ? $vars ['isBuildButton'] : true;
        $this->isBuildMenu = isset ($vars ['isBuildMenu']) ? $vars ['isBuildMenu'] : true;
        $this->hasPopup = isset ($vars ['hasPopup']) ? $vars ['hasPopup'] : true;
        $this->expanded = isset ($vars ['expanded']) ? $vars ['expanded'] : false;
        $this->isDropup = isset ($vars ['isDropup']) ? $vars ['isDropup'] : false;
        $this->isSplit = isset ($vars ['isSplit']) ? $vars ['isSplit'] : false;

        $this->button = null;
        $this->menu = null;
        $this->dropdownIcon = new Icon("caret", array("iconSet" => ""));
        $this->screw = array(
            "text" => "&nbsp;",
            "url" => "",
            "head" => false,
            "seperator" => false,
            "active" => false,
            "disabled" => false
        );
    }

    /**
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        switch ($this->mode) {
            default:
            case "button":
                $this->customClass [] = $this->type;
                if ($this->isSplit == true) {
                    if ($this->innerText) {// in split button dropdown, text will be set into a seperate button,
                        $_splitBtn = new Button();
                        $_splitBtn->setInnerText($this->innerText);
                        if (!empty($this->context)) $_splitBtn->setContext($this->context);
                        if (!empty($this->size)) $_splitBtn->setContext($this->size);
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
                $this->innerText = null;

                parent::render();
                break;
            case "inline":
                if ($this->isBuildButton == true && empty($this->button)) {
                    $this->buildButton();
                    $this->html = $this->button->render();
                }
                if ($this->isBuildMenu == true && empty($this->menu)) {
                    $this->buildMenu();
                    $this->html .= $this->menu->render();
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
    protected function buildButton()
    {

        if ($this->mode == "button") {
            $_btn = new Button();
            if (!empty($this->size)) $_btn->setSize($this->size);
            if (!empty($this->context)) $_btn->setContext($this->context);
        } else {
            $_btn = new Typography("a", null, array("href" => "#"));
        }

        $_btn->appendCustomClass($this->customClass);
        $_btn->appendCustomClass(array("dropdown-toggle"))
            ->setId()
            ->appendAttrs(array( // @todo not actually know what all they do.
                "data-toggle" => "dropdown",
                "role" => "button",
                "aria-haspopup" => json_encode($this->hasPopup),
                "aria-expanded" => json_encode($this->expanded)
            ));

        // only a single icon. icon style control by parent class dropdown/dropup.
        if ($this->isSplit == true) {
            $_btn->innerElements = array($this->dropdownIcon);
        } else {
            if (!empty($this->innerText)) $_btn->innerElements [] = $this->innerText;
            if (!empty($this->innerHtml)) $_btn->innerElements [] = $this->innerHtml;
            $_btn->innerElements [] = $this->dropdownIcon;
        }

        $this->button = $_btn;
    }

    /**
     * @desc build the menu who drops down
     */
    protected function buildMenu()
    {
        $_ul = new Typography("ul:dropdown-menu");
        if ($this->align == "right") {
            $_ul->appendCustomClass("dropdown-menu-right");
        }
        if ($this->button instanceof Typography && method_exists($this->button, "getId")) {
            $_id = $this->button->getId();
        } else {
            $_id = "";
            self::setErrMsg("No id for dropdown menu labelled.");
        }
        $_ul->appendAttrs(array(
            "aria-labelledby" => $_id
        ));

        if (!empty($this->items)) {
            foreach ($this->items as $key => $item) {
                if ($item ['text'] instanceof HtmlTag && $item ['text']->getTagName() == "li") {
                    continue;
                } else if ($item ['seperator'] == true) {
                    $_li = new HtmlTag("li");
                    $_li->appendAttrs(array("role" => "seperator"));
                    $_li->appendCustomClass("divider")
                        ->setInnerText("\t");
                } else {
                    $_li = new HtmlTag("li");
                    if ($key == $this->activeIndex || $item ['active'] == true) {
                        $_li->appendCustomClass("active");
                    }
                    if ($item ['head'] == true) {
                        $_li->appendCustomClass("dropdown-header");
                        $item ['url'] = "";
                    }
                    if ($item ['disabled'] == true) {
                        $_li->appendCustomClass("disabled");
                    }

                    if (!empty($item ['url'])) {
                        $_ia = new HtmlTag("a");
                        $_ia->appendAttrs(array("href" => $item ['url']));
                        if (is_string($item ['text'])) {
                            $_ia->setInnerText($item ['text']);
                        } else {
                            $_ia->appendInnerElements($item ['text']);
                        }

                        $_li->appendInnerElements($_ia);
                    } else {
                        $_li->appendInnerElements($item ['text']);
                    }
                }

                $_ul->appendInnerElements($_li);
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
     * @param Ambigous <boolean, array> $hasPopup
     */
    public function setHasPopup($hasPopup)
    {
        $this->hasPopup = $hasPopup;
        return $this;
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
     * @param Ambigous <boolean, array> $isBuildButton
     */
    public function setIsBuildButton($isBuildButton = true)
    {
        $this->isBuildButton = $isBuildButton;
        return $this;
    }

    /**
     * @return the $isBuildMenu
     */
    public function getIsBuildMenu()
    {
        return $this->isBuildMenu;
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
     * @param Ambigous <NULL, \model\bootstrap\basic\Typography> $button
     */
    public function setButton(HtmlTag $button)
    {
        $_attrs = $button->getAttrs();
        $_attrKeys = array_keys($_attrs);
        if (!in_array("data-toggle", $_attrKeys)) {
            $button->appendAttrs(array("data-toggle" => "dropdown"));
        }
        if (!in_array("role", $_attrKeys)) {
            $button->appendAttrs(array("role" => "button"));
        }
        if (!in_array("aria-haspopup", $_attrKeys)) {
            $button->appendAttrs(array("aria-haspopup" => json_encode($this->hasPopup)));
        }
        if (!in_array("aria-expanded", $_attrKeys)) {
            $button->appendAttrs(array("aria-expanded" => json_encode($this->expanded)));
        }

        $this->button = $button;
        return $this;
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
     * @param Ambigous <NULL, \model\bootstrap\basic\Typography> $menu
     */
    public function setMenu(HtmlTag $menu)
    {
        $this->menu = $menu;
        return $this;
    }

    /**
     * @desc check if droplet
     * {@inheritDoc}
     * @see \model\Xantico\basic\Typography::appendItems()
     */
    public function setItems($items)
    {
        if (!empty($items)) {
            for ($i = 0; $i < count($items); $i++) {
                if (is_array($items[$i])) {
                    $items[$i] ['text'] = isset($items[$i] ['text']) ? $items[$i] ['text'] : $this->screw ['text'];
                    $items[$i] ['url'] = isset($items[$i] ['url']) ? $items[$i] ['url'] : $this->screw ['url'];
                    $items[$i] ['head'] = isset($items[$i] ['head']) ? $items[$i] ['head'] : $this->screw ['head'];
                    $items[$i] ['seperator'] = isset($items[$i] ['seperator']) ? $items[$i] ['seperator'] : $this->screw ['seperator'];
                    $items[$i] ['active'] = isset($items[$i] ['active']) ? $items[$i] ['active'] : $this->screw ['active'];
                    $items[$i] ['disabled'] = isset($items[$i] ['disabled']) ? $items[$i] ['disabled'] : $this->screw ['disabled'];
                } else {
                    $_item ['text'] = $items[$i];
                    $_item ['url'] = $this->screw ['url'];
                    $_item ['head'] = $this->screw ['head'];
                    $_item ['seperator'] = $this->screw ['seperator'];
                    $_item ['active'] = $this->screw ['active'];
                    $_item ['disabled'] = $this->screw ['disabled'];
                    $items [$i] = $_item;
                    unset ($_item);
                }
            }
        }
        parent::setItems($items);
        return $this;
    }

    /**
     * @desc check associative array contents.
     * {@inheritDoc}
     * @see \model\Xantico\basic\Typography::appendItems()
     */
    public function appendItems($items)
    {
        if (!empty($items)) {
            for ($i = 0; $i < count($items); $i++) {
                if (is_array($items[$i])) {
                    $items[$i] ['text'] = isset($items[$i] ['text']) ? $items[$i] ['text'] : $this->screw ['text'];
                    $items[$i] ['url'] = isset($items[$i] ['url']) ? $items[$i] ['url'] : $this->screw ['url'];
                    $items[$i] ['head'] = isset($items[$i] ['head']) ? $items[$i] ['head'] : $this->screw ['head'];
                    $items[$i] ['seperator'] = isset($items[$i] ['seperator']) ? $items[$i] ['seperator'] : $this->screw ['seperator'];
                    $items[$i] ['active'] = isset($items[$i] ['active']) ? $items[$i] ['active'] : $this->screw ['active'];
                    $items[$i] ['disabled'] = isset($items[$i] ['disabled']) ? $items[$i] ['disabled'] : $this->screw ['disabled'];
                } else {
                    $_item ['text'] = $items[$i];
                    $_item ['url'] = $this->screw ['url'];
                    $_item ['head'] = $this->screw ['head'];
                    $_item ['seperator'] = $this->screw ['seperator'];
                    $_item ['active'] = $this->screw ['active'];
                    $_item ['disabled'] = $this->screw ['disabled'];
                    $items [$i] = $_item;
                    unset ($_item);
                }
            }
        }
        parent::appendItems($items);
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
     * Mode : [button|inline]
     * @param string $mode [button|inline]
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

    public function setModeButton()
    {
        $this->mode = "button";
        return $this;
    }

    public function setModeInline()
    {
        $this->mode = "inline";
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
     * @return the $dropdownIcon
     */
    public function getDropdownIcon()
    {
        return $this->dropdownIcon;
    }

    /**
     * @param \model\Xantico\basic\Icon $dropdownIcon
     */
    public function setDropdownIcon($dropdownIcon)
    {
        $this->dropdownIcon = $dropdownIcon;
        return $this;
    }


}


