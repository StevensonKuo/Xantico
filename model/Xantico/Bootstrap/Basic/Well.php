<?php

namespace Xantico\Bootstrap\Basic;

use Xantico\Bootstrap\HtmlTag;

class Well extends Typography
{
    protected $isCenterBlock; // boolean

    public function __construct($vars = array(), $attr = array())
    {
        parent::__construct("div:well", $vars, $attr);

        $this->isCenterBlock = isset ($vars ['center-block']) ? $vars ['center-block'] : false;
    }

    /**
     * @desc add a h1 tag for text.
     * {@inheritDoc}
     * @see \model\Xantico\basic\Typography::render()
     */
    public function render($display = false)
    {
        if (!empty($this->innerText)) {
            $_text = preg_split("/[\n\r]/", $this->innerText);
            if (!empty($_text)) {
                foreach ($_text as $t) {
                    $p = new HtmlTag("p");
                    $p->setText($t);

                    $this->innerElements [] = $p;
                    unset ($p);
                }
            }
            $this->innerText = null;
        }

        if (!empty($this->size)) {
            $this->customClass [] = "well-" . $this->size;
        }

        if ($this->isCenterBlock == true) {
            $this->customClass [] = "center-block";
        }


        parent::render();

        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }

    }

    /**
     * @return the $isCenterBlock
     */
    public function getIsCenterBlock()
    {
        return $this->isCenterBlock;
    }

    /**
     * @param Ambigous <boolean, array> $isCenterBlock
     */
    public function setIsCenterBlock($isCenterBlock = true)
    {
        $this->isCenterBlock = $isCenterBlock;
        return $this;
    }


}



