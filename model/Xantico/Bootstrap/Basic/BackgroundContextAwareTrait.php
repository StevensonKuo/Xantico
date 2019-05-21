<?php

namespace Xantico\Bootstrap\Basic;

trait BackgroundContextAwareTrait
{
    protected $bgContext;

    protected static $bgContextArr = array("success", "default", "primary", "danger", "warning", "info", "");

    /**
     * @return mixed
     */
    public function getBgContext()
    {
        return $this->bgContext;
    }

    /**
     * @param $bgContext
     * @return $this
     */
    public function setBgContext($bgContext)
    {
        $bgContext = strtolower($bgContext);
        if (in_array($bgContext, self::$bgContextArr)) {
            $this->bgContext = $bgContext;
        } else {
            // @todo trigger set context exception or something else.
        }

        return $this;
    }

    public function setBgContextPrimary()
    {
        $this->bgContext = "primary";
        return $this;
    }

    public function setBgContextSuccess()
    {
        $this->bgContext = "success";
        return $this;
    }

    public function setBgContextInfo()
    {
        $this->bgContext = "info";
        return $this;
    }

    public function setBgContextWarning()
    {
        $this->bgContext = "warning";
        return $this;
    }

    public function setBgContextDanger()
    {
        $this->bgContext = "danger";
        return $this;
    }
}
