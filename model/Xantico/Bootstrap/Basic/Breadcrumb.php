<?php

namespace Xantico\Bootstrap\Basic;

use Xantico\Bootstrap\HtmlTag;

class Breadcrumb extends Typography
{
    /** @var array */
    public $screw; // crumb

    /** @var int */
    protected $activeIndex; // int
    /** @var bool */
    protected $hideAfter;

    /**
     * @param array $vars
     * @param array $attrs
     */
    public function __construct($vars = array(), $attrs = array())
    {

        parent::__construct("ol:breadcrumb", $vars, $attrs);

//          $this->type         = "breadcrumb"; // will be set in parent class.
        $this->activeIndex = isset($vars['activeIndex']) ? intval($vars['activeIndex']) : 0;
        $this->hideAfter = isset($vars['hideAfter']) ? (bool)$vars['hideAfter'] : true;
        $this->screw = array("text" => "&nbsp;", "url" => "#", "active" => false, "disabled" => false);
    }

    /**
     * @param bool $display
     * @return string|bool
     */
    public function render($display = false)
    {
        if (!empty($this->items)) {
            foreach ($this->items as $key => $item) {
                if ($item ['text'] instanceof HtmlTag && $item ['text']->getTagName() == "li") {
                    continue;
                } else {
                    $_li = new HtmlTag("li");
//                      $_li->appendAttrs(array ("role" => "presentation"));
//                     if ($item->disabled == true) {
//                         $_li->appendCustomClass("disabled");
//                     }
                    if ($key == $this->activeIndex || $item ['active'] == true) {
                        $_li->appendCustomClass("active");

                        $_li->appendInnerElements($item ['text']);
                        if ($this->hideAfter == true) {
                            $this->innerElements [] = $_li;
                            break;
                        }
                    } else if (!empty ($item ['url'])) { // breadcrumb 裡有 active 就沒 a
                        $_a = new HtmlTag("a");
                        $_a->appendAttrs(array("href" => $item['url']));
                        if (is_string($item ['text'])) {
                            $_a->setInnerText($item['text']);
                        } else {
                            $_a->appendInnerElements($item['text']);
                        }

                        $_li->appendInnerElements($_a);
                    } else {
                        $_li->appendInnerElements($item['text']);
                    }
                }

                $this->innerElements [] = $_li;
            }
            $this->items = null; // all items passed to inner elements. set to null to avoid render duplicated.
        }

        parent::render();

        if ($display == true) {
            echo $this->html;
            return true;
        } else {
            return $this->html;
        }
    }

    /**
     * @return int $activeIndex
     */
    public function getActiveIndex()
    {
        return $this->activeIndex;
    }

    /**
     * @param int $activeIndex
     * @return Breadcrumb
     */
    public function setActiveIndex($activeIndex)
    {
        $this->activeIndex = $activeIndex;
        return $this;
    }

    /**
     * @desc check if items are instance of <class>Crumb
     * {@inheritDoc}
     */
    public function setItems($items)
    {
        if (!empty($items)) {
            for ($i = 0; $i < count($items); $i++) {
                if (is_array($items[$i])) {
                    $items[$i] ['text'] = isset($items[$i] ['text']) ? $items[$i] ['text'] : $this->screw ['text'];
                    $items[$i] ['url'] = isset($items[$i] ['url']) ? $items[$i] ['url'] : $this->screw ['url'];
                    $items[$i] ['active'] = isset($items[$i] ['active']) ? $items[$i] ['active'] : $this->screw ['active'];
                    $items[$i] ['disabled'] = isset($items[$i] ['disabled']) ? $items[$i] ['disabled'] : $this->screw ['disabled'];
                } else {
                    $_item ['text'] = $items[$i];
                    $_item ['url'] = $this->screw ['url'];
                    $_item ['active'] = $this->screw ['active'];
                    $_item ['disabled'] = $this->screw ['disabled'];

                    $items[$i] = $_item;
                    unset ($_item);
                }
            }
        }
        parent::setItems($items);
        return $this;
    }

    /**
     * @desc check if items are instance of <class>Crumb
     * {@inheritDoc}
     */
    public function appendItems($items)
    {
        if (!empty($items)) {
            for ($i = 0; $i < count($items); $i++) {
                if (is_array($items[$i])) {
                    $items[$i] ['text'] = isset($items[$i] ['text']) ? $items[$i] ['text'] : $this->screw ['text'];
                    $items[$i] ['url'] = isset($items[$i] ['url']) ? $items[$i] ['url'] : $this->screw ['url'];
                    $items[$i] ['active'] = isset($items[$i] ['active']) ? $items[$i] ['active'] : $this->screw ['active'];
                    $items[$i] ['disabled'] = isset($items[$i] ['disabled']) ? $items[$i] ['disabled'] : $this->screw ['disabled'];
                } else {
                    $_item ['text'] = $items[$i];
                    $_item ['url'] = $this->screw ['url'];
                    $_item ['active'] = $this->screw ['active'];
                    $_item ['disabled'] = $this->screw ['disabled'];

                    $items[$i] = $_item;
                    unset ($_item);
                }
            }
        }
        parent::appendItems($items);
        return $this;
    }

    /**
     * @desc step forward, active index +1
     * @param int $steps
     * @return Breadcrumb
     */
    public function stepForward($steps = 1)
    {
        $_count = !empty($this->items) ? count($this->items) - 1 : 0;
        $this->activeIndex = min($_count, max($this->activeIndex + $steps, 0));
        return $this;
    }

    /**
     * @desc step backward, active index -1
     */
    public function stepBackward($steps = 1)
    {
        $_count = !empty($this->items) ? count($this->items) - 1 : 0;
        $this->activeIndex = min($_count, max($this->activeIndex - $steps, 0));
        return $this;
    }

    /**
     * @return bool $hideAfter
     */
    public function getHideAfter()
    {
        return $this->hideAfter;
    }

    /**
     * @param bool $hideAfter
     * @return Breadcrumb
     */
    public function setHideAfter($hideAfter = true)
    {
        $this->hideAfter = $hideAfter;
        return $this;
    }
}
