<?php

namespace Xantico\Bootstrap\Basic;

use Xantico\Bootstrap\HtmlTag;

class Code extends Typography
{
    protected $lang; //string

    public function __construct($code = "", $vars = array(), $attr = array())
    {
        parent::__construct("figure:highlight", $vars, $attr);

        $this->type = "code";
        $this->lang = isset($vars['lang']) ? $vars['lang'] : "php";
        $this->innerText = $code;

    }

    public function render($display = false)
    {
        $pre = new HtmlTag("pre");
        if ($this->lang == "php") {
            if (!preg_match("/^[<][?](php)?/i", trim($this->innerText))) {
                // @todo text-indent will be messed.
                $this->innerText = "<?php\n" . $this->innerText . "\n?>";
            }
            $pre->setInnerElements(highlight_string($this->innerText, true));
        } else {
            // @todo don't know how to deal other language at this moment.
            $codeTag = new HtmlTag("code", array("data-lang" => $this->lang));
            $codeTag->setCustomClass("language-" . $this->lang);
            $codeTag->setInnerElements(trim($this->innerText));
            $pre->appendInnerElements($codeTag);
        }

        $this->innerElements [] = $pre;
        $this->innerText = null;

        parent::render();

        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }


}



