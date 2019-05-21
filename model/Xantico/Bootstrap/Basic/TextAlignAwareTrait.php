<?php

namespace Xantico\Bootstrap\Basic;

trait TextAlignAwareTrait
{
    protected $textAlign;

    protected static $textAlignArr = array("left", "center", "right", "justify", "nowrap", "");

    /**
     * @return string
     */
    public function getTextAlign()
    {
        return $this->textAlign;
    }

    /**
     * @param string $textAlign
     * @return TextAlignAwareTrait
     */
    public function setTextAlign($textAlign)
    {
        $textAlign = strtolower($textAlign);
        if (in_array($textAlign, self::$textAlignArr)) {
            $this->textAlign = $textAlign;
        }

        return $this;
    }

    public function setTextAlignLeft()
    {
        $this->textAlign = "left";
        return $this;
    }

    public function setTextAlignCenter()
    {
        $this->textAlign = "center";
        return $this;
    }

    public function setTextAlignRight()
    {
        $this->textAlign = "right";
        return $this;
    }

    public function setTextAlignJustify()
    {
        $this->textAlign = "justify";
        return $this;
    }

    public function setTextAlignNowrap()
    {
        $this->textAlign = "nowrap";
        return $this;
    }
}
