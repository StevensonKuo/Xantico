<?php

namespace Xantico\Bootstrap\Basic;

use Xantico\Bootstrap\HtmlTag;

class Panel extends Typography
{
    public static $HEADING_SIZE = 0; // string; title.

    protected $heading; // string, HtmlTag
    protected $bodyContents; // string, HtmlTag

//     protected $subTitle; // string
//     protected $flat; // boolean
//     protected $toolbox; //  array
protected $footer;

    public function __construct($vars = array(), $attrs = array())
    {
        parent::__construct("div:panel", $vars, $attrs);
        $this->type = "panel";
        $this->heading = isset ($vars ['heading']) ? $vars ['heading'] : "";
        $this->bodyContents = isset ($vars ['bodyContents']) ? $vars ['bodyContents'] : "";
        $this->footer = isset ($vars ['footer']) ? $vars ['footer'] : "";
        $this->context = empty($this->context) ? "default" : $this->context;
//         $this->subTitle     = key_exists('subTitle', $vars) ? $vars ['subTitle'] : "";
//         $this->flat         = key_exists('flat', $vars) ? $vars ['flat'] : true;
//         $this->toolbox      = key_exists('toolbox', $vars) ? $vars ['toolbox'] : array ();

    }

    /**
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        if (!empty($this->context)) {
            $this->appendCustomClass("panel-" . $this->context);
        }

        $_defaultPart = array();
        if (!empty($this->heading)) {
            $headingDiv = new HtmlTag("div");
            $headingDiv->appendCustomClass("panel-heading");
            if (self::$HEADING_SIZE > 0) {
                $titleDiv = new HtmlTag("h" . self::$HEADING_SIZE);
                $titleDiv->appendCustomClass("panel-title")
                    ->setInnerText($this->heading);
                $headingDiv->appendInnerElements($titleDiv);
            } else {
                $headingDiv->setText($this->heading);
            }

            $_defaultPart [] = $headingDiv;
        }

        if (!empty($this->bodyContents)) {
            $bodyDiv = new HtmlTag("div");
            $bodyDiv->appendCustomClass("panel-body")
                ->appendInnerElements($this->bodyContents);

            $_defaultPart [] = $bodyDiv;
        }

        // elements apart of heading and body will be appended follow.
        $this->innerElements = array_merge($_defaultPart, $this->innerElements);

        if (!empty($this->footer)) {
            $footDiv = new HtmlTag("div");
            $footDiv->appendCustomClass("panel-footer")
                ->appendInnerElements($this->footer);
            $this->innerElements [] = $footDiv;
        }


        parent::render();

        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }

    /**
     * @desc return bodyContents attr.
     * @return \model\Xantico\the
     */
    public function getBodyContents()
    {
        return $this->bodyContents;
    }

    /**
     * @desc setter, merge all argvs.
     * @param array $bodyContents
     * @return \model\Xantico\basic\Jumbotron
     */
    public function setBodyContents($bodyContents = array())
    {
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $bodyContents = func_get_args();
        } else {
            if (!is_array($bodyContents)) $bodyContents = array($bodyContents);
        }

        $this->bodyContents = $bodyContents;

        return $this;
    }

    /**
     * @param Ambigous <multitype:, field_type> $bodyContents
     */
    public function appendBodyContents($bodyContents = array())
    {
        if (empty($bodyContents)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $bodyContents = func_get_args();
        } else {
            if (!is_array($bodyContents)) $bodyContents = array($bodyContents);
        }

        if ($this->bodyContents && is_array($this->bodyContents)) $this->bodyContents = array_merge($this->bodyContents, $bodyContents);
        else $this->bodyContents = $bodyContents;

        return $this;
    }

    public function getBody($index)
    {
        if (isset($this->bodyContents [$index])) {
            return $this->bodyContents [$index];
        } else {
            return null;
        }
    }

    public function setBody($index, $content)
    {
        $this->bodyContents [$index] = $content;
        return $this;
    }

    /**
     * @deprecated
     * @param Ambigous <boolean, unknown> $flat
     */
    public function setFlat($flat = false)
    {
        $this->flat = $flat;
        return $this;
    }

    /**
     * @deprecated
     * @return the $subTitle
     */
    public function getSubTitle()
    {
        return $this->subTitle;
    }

    /**
     * @deprecated
     * @param field_type $subTitle
     */
    public function setSubTitle($subTitle)
    {
        $this->subTitle = $subTitle;
        return $this;
    }

    /**
     * @return the $heading
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * @param Ambigous <string, array> $heading
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
        return $this;
    }

    /**
     * @return the $footer
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * @param Ambigous <string, array> $footer
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
        return $this;
    }


}


