<?php

namespace Xantico\Bootstrap\Basic;

use Xantico\Bootstrap\HtmlTag;

class Carousel extends Typography
{
    public $screw; // array

    protected $activeIndex; // int
    protected $withIndicator; // boolean
    protected $withControl; // boolean
    protected $interval; // int. ms


    /**
     * @param unknown $type
     * @param array $vars
     * @param array $attrs
     * @return \model\Xantico\basic\Typography
     */
    public function __construct($vars = array(), $attrs = array())
    {

        parent::__construct("div:carousel", $vars, $attrs);

        $this->type = "carousel";
        $this->activeIndex = isset ($vars ['activeIndex']) ? $vars ['activeIndex'] : 0; // There is on element active in need in Carousel, or it will not work.
        $this->withIndicator = isset ($vars ['withIndicator']) ? $vars ['withIndicator'] : true;
        $this->withControl = isset ($vars ['withControl']) ? $vars ['withControl'] : true;

        $this->screw = array("source" => "", "text" => "&nbsp;", "active" => false);
    }

    /**
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        $this->setId();
        $this->appendCustomClass("slide")
            ->appendAttrs(array("data-ride" => "carousel"));

        if ($this->withIndicator == true) {
            $_indicator = new HtmlTag("ol");
            $_indicator->appendCustomClass("carousel-indicators");
        }

        $_body = new HtmlTag("div");
        $_body->appendCustomClass("carousel-inner");
        $_body->appendAttrs(array("role" => "listbox"));

        if (!empty($this->items)) {
            foreach ($this->items as $key => $item) {
                $_div = new HtmlTag("div");
                $_div->appendCustomClass("item");

                if ($item ['active'] == true) {
                    $_div->appendCustomClass("active");
                }

                $_img = new HtmlTag("img", array("data-src" => $item ['source'], "alt" => $item ['text']));
                $_div->appendInnerElements($_img);
                if (!empty($item ['text'])) {
                    $_textDiv = new HtmlTag("div");
                    $_textDiv->appendCustomClass(array("carousel-caption", "d-none", "d-md-block"));
                    $_textDiv->appendInnerElements($item ['text']);

                    $_div->appendInnerElements($_textDiv);
                }

                $_body->appendInnerElements($_div);

                if ($this->withIndicator == true) {
                    // @todo I can't click indicator the shit... don't know why...  
                    $_li = new HtmlTag("li");
                    $_li->appendAttrs(array("data-target" => $this->id, "data-slide-to" => $key))
                        ->setText("\t");

                    if ($item ['active'] == true) {
                        $_div->appendCustomClass("active");
                        $_li->appendCustomClass("active");
                    }

                    $_indicator->appendInnerElements($_li);
                }
            }
            $this->items = null;
        }

        if ($this->withIndicator == true) {
            $this->innerElements = array($_indicator, $_body);
        } else {
            $this->innerElements = array($_body);
        }

        if ($this->withControl == true) {
            $_previous = new HtmlTag("a");
            $_previous->appendAttrs(array("href" => "#" . $this->getId(), "role" => "button", "data-slide" => "prev"))
                ->appendCustomClass(array("left", "carousel-control"));
            $_icon = new Icon("chevron-left");
            $_icon->appendAttrs(array("aria-hidden" => "true"));
            $_comment = new Typography("span:sr-only", array("innerText" => self::CAP_PREVIOUS));
            $_previous->appendInnerElements(array($_icon, $_comment));

            $_next = clone $_previous;
            $_next->appendAttrs(array("data-slide" => "next"))// will overwrite old attr.
            ->setCustomClass(null)
                ->appendCustomClass(array("right", "carousel-control"));
            $_next->getElement(0)->setIcon("chevron-right");
            $_next->getElement(1)->setText(self::CAP_NEXT);

            $this->appendInnerElements($_previous, $_next);
        }

        parent::render();

        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }

    /**
     * @desc check if slidle.
     * {@inheritDoc}
     * @see \model\Xantico\basic\Typography::appendItems()
     */
    public function setItems($items)
    {
        if (!empty($items)) {
            for ($i = 0; $i < count($items); $i++) {
                if (is_array($items[$i])) {
                    $items[$i] ['source'] = isset($items[$i] ['source']) ? $items[$i] ['source'] : $this->screw ['source'];
                    $items[$i] ['text'] = isset($items[$i] ['text']) ? $items[$i] ['text'] : $this->screw ['text'];
                    $items[$i] ['active'] = isset($items[$i] ['active']) ? $items[$i] ['active'] : $this->screw ['active'];
                } else {
                    $_item ['source'] = $items [$i];
                    $_item ['text'] = $this->screw ['text'];
                    $_item ['active'] = $this->screw ['active'];
                    $items [$i] = $_item;
                    unset ($_item);
                }
            }
        }
        parent::setItems($items);
        return $this;
    }

    /**
     * @desc check if slidle.
     * {@inheritDoc}
     * @see \model\Xantico\basic\Typography::appendItems()
     */
    public function appendItems($items)
    {
        if (!empty($items)) {
            for ($i = 0; $i < count($items); $i++) {
                if (is_array($items[$i])) {
                    $items[$i] ['source'] = isset($items[$i] ['source']) ? $items[$i] ['source'] : $this->screw ['source'];
                    $items[$i] ['text'] = isset($items[$i] ['text']) ? $items[$i] ['text'] : $this->screw ['text'];
                    $items[$i] ['active'] = isset($items[$i] ['active']) ? $items[$i] ['active'] : $this->screw ['active'];
                } else {
                    $_item ['source'] = $items [$i];
                    $_item ['text'] = $this->screw ['text'];
                    $_item ['active'] = $this->screw ['active'];
                    $items [$i] = $_item;
                    unset ($_item);
                }
            }
        }

        parent::appendItems($items);
        return $this;
    }

    /**
     * @return the $withIndicator
     */
    public function getWithIndicator()
    {
        return $this->withIndicator;
    }

    /**
     * @param field_type $withIndicator
     */
    public function setWithIndicator($withIndicator = true)
    {
        $this->withIndicator = $withIndicator;
        return $this;
    }

    /**
     * @return the $withControl
     */
    public function getWithControl()
    {
        return $this->withControl;
    }

    /**
     * @param field_type $withControl
     */
    public function setWithControl($withControl = true)
    {
        $this->withControl = $withControl;
        return $this;
    }

    /**
     * @return the $activeIndex
     */
    public function getActiveIndex()
    {
        return $this->activeIndex;
    }

    /**
     * @param Ambigous <number, array> $activeIndex
     */
    public function setActiveIndex($activeIndex = 0)
    {
        $this->activeIndex = intval($activeIndex);
        return $this;
    }


}
