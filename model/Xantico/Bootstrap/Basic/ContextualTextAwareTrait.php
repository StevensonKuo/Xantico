<?php

namespace Xantico\Bootstrap\Basic;

trait ContextualTextAwareTrait
{
    protected $textContext;

    protected static $textContextArr = array("success", "muted", "primary", "danger", "warning", "info", "");

    /**
     * @return string
     */
    public function getTextContext()
    {
        return $this->textContext;
    }

    /**
     * @param string $textContext
     * @return ContextualTextAwareTrait
     */
    public function setTextContext($textContext)
    {
        $textContext = strtolower($textContext);
        if (in_array($textContext, self::$textContextArr)) {
            $this->textContext = $textContext;
        }

        return $this;
    }

    public function setTextContextMuted()
    {
        $this->textContext = "muted";
        return $this;
    }

    public function setTextContextSuccess()
    {
        $this->textContext = "success";
        return $this;
    }

    public function setTextContextPrimary()
    {
        $this->textContext = "primary";
        return $this;
    }

    public function setTextContextInfo()
    {
        $this->textContext = "info";
        return $this;
    }

    public function setTextContextWarning()
    {
        $this->textContext = "warning";
        return $this;
    }

    public function setTextContextDanger()
    {
        $this->textContext = "danger";
        return $this;
    }
}
