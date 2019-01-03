<?php

namespace Xantico\Bootstrap\Basic;

use Xantico\Bootstrap\HtmlTag;

class Breadcrumb extends Typography
{
    public $screw; // crumb

    protected $activeIndex; // int
    protected $hideAfter; // boolean; hide levels after actived index.

    /**
     * @param array $vars
     * @param array $attrs
     * @return Typography
     */
    public function __construct($vars = array(), $attrs = array())
    {

        parent::__construct("ol:breadcrumb", $vars, $attrs);

//          $this->type         = "breadcrumb"; // will be set in parent class.
        $this->activeIndex = isset ($vars ['activeIndex']) ? $vars ['activeIndex'] : 0;
        $this->hideAfter = isset ($vars ['hideAfter']) ? $vars ['hideAfter'] : true;
        $this->screw = array("text" => "&nbsp;", "url" => "#", "active" => false, "disabled" => false);
    }

    /**
     * @param string $display
     * @return unknown
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
                        $_a->appendAttrs(array("href" => $item ['url']));
                        if (is_string($item ['text'])) {
                            $_a->setInnerText($item ['text']);
                        } else {
                            $_a->appendInnerElements($item ['text']);
                        }

                        $_li->appendInnerElements($_a);
                    } else {
                        $_li->appendInnerElements($item ['text']);
                    }
                }

                $this->innerElements [] = $_li;
            }
            $this->items = null; // all items passed to inner elements. set to null to avoid render duplicated.
        }

        parent::render();

        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
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
     * @desc check if items are instance of <class>Crumb
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
     * @see \model\Xantico\basic\Typography::appendItems()
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
     * @return the $hideAfter
     */
    public function getHideAfter()
    {
        return $this->hideAfter;
    }

    /**
     * @param Ambigous <number, array> $hideAfter
     */
    public function setHideAfter($hideAfter = true)
    {
        $this->hideAfter = $hideAfter;
        return $this;
    }

}
