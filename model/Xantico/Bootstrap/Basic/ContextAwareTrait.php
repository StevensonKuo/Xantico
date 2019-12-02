<?php

namespace Xantico\Bootstrap\Basic;

trait ContextAwareTrait
{
    protected $context;

    protected static $contextArr = array("success", "default", "primary", "danger", "warning", "info", "");

    /**
     * @param $context
     * @return $this
     */
    public function setContext($context)
    {
        $context = strtolower($context);
        if (in_array($context, self::$contextArr)) {
            $this->context = strtolower($context);
        } else {
            false;
            // @todo trigger warning for set context failed.
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    public function setContextSuccess()
    {
        $this->context = "success";
        return $this;
    }

    // contextual class setter end.

    public function setContextInfo()
    {
        $this->context = "info";
        return $this;
    }

    public function setContextWarning()
    {
        $this->context = "warning";
        return $this;
    }

    public function setContextDanger()
    {
        $this->context = "danger";
        return $this;
    }

    public function setContextPrimary()
    {
        $this->context = "primary";
        return $this;
    }

    public function setContextDefault()
    {
        $this->context = "default";
        return $this;
    }
}
