<?php

namespace Xantico\Bootstrap;

class Xantico
{
    const BOOTSTRAP_VERSION = '3.3.7';
    const JQUERY_VERSION = '2.2.4'; // string
    const JQUERY_UI_VERSION = '1.10.4'; // string
    const BOOTSTRAP_HREF = '/static/admin/css/bootstrap.min.css'; // array
    const BOOTSTRAP_JS_HREF = '/static/admin/js/bootstrap.min.js'; // array
    const JQUERY_HREF = '/static/admin/js/jquery.min.js'; // string
    const SHARED_CSS_PATH = '/static/admin/css/plugins/'; // string
    const SHARED_JS_PATH = '/static/admin/js/plugins/'; // string
    const BOOTSTRAP_CDN_URL = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'; // string
    const BOOTSTRAP_CDN_INTEGRITY = 'sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u'; // boolean
    const BOOTSTRAP_JS_CDN_URL = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'; // array
    const BOOTSTRAP_JS_CDN_INTEGRITY = 'sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa'; // string
    const JQUERY_CDN_URL = 'https://code.jquery.com/jquery-2.2.4.min.js'; // boolean
    const JQUERY_CDN_INTEGRITY = 'sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44='; // boolean
    const JQUERY_UI_CDN_URL = 'https://code.jquery.com/ui/1.10.4/jquery-ui.min.js'; // boolean
    const JQUERY_UI_CDN_INTEGRITY = 'sha256-oTyWrNiP6Qftu4vs2g0RPCKr3g1a6QTlITNgoebxRc4='; // all Typography classes will be gathered into here.
    const JQUERY_UI_CSS_CDN_URL = 'https://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css'; // array

    public static $elements = array(); // array
    public static $defaultCSSFiles = array(); // string
    public static $defaultScriptsFiles = array(); // string

    protected $title;
    protected $customCSSFiles; // local bootstrap css path.
    protected $customScriptsFiles; // local bootstrap css path.
    protected $bodyContents; // local jquery path.
    protected $metaContents;
    protected $CSSContents;
    protected $scriptsContents;
    protected $lang;
    protected $encoding;
    protected $isResponsive;
    protected $keywords;
    protected $description;
    protected $isLoadBootstrapFromCDN;
    protected $isLoadJQueryFromCDN;
    protected $isLoadJQueryUIFromCDN;
    // localization 
    // https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/localization/messages_zh_TW.min.js

    public function __construct()
    {
        // bootstrap config
        $this->lang = 'zh-cn';
        $this->encoding = 'utf-8';

        // default bootstrap
        $this->customCSSFiles = array();
        $this->customScriptsFiles = array();
        $this->metaContents = array();
        $this->bodyContents = array();

        $this->isResponsive = true;
        $this->isLoadBootstrapFromCDN = false;
        $this->isLoadJQueryFromCDN = false;
        $this->isLoadJQueryUIFromCDN = false;
        // bootstrap config end.
    }

    public function render($display = false)
    {

        $body = $this->buildBody();
        $head = $this->buildHead();
        $html = $this->buildHtml($head, $body);

        if ($display == false) {
            return $html;
        } else {
            echo $html;
        }

    }

    /**
     * @desc build html <body> tag.
     * @return \model\Xantico\HtmlTag
     */
    private function buildBody()
    {
        $bodyTag = new HtmlTag("body"); // need jQuery attribute
        if (!empty($this->bodyContents)) {
            $_html = "";
            $_jQuery = "";
            foreach ($this->bodyContents as $ctnt) {
                if ($ctnt instanceof HtmlTag) {
                    $_html .= $ctnt->render() . "\n";
                    if (method_exists($ctnt, "getJQuery") && $ctnt->getJQuery()) {
                        $_jQuery = $ctnt->getJQuery() . "\n";
                    }
                } else {
                    $_html .= htmlspecialchars($ctnt) . "\n";
                }
            }

            $htmlLines = explode("\n", $_html);
            // there are just two tabs under body tag.
            $_html = implode("\n\t\t", $htmlLines);
            $bodyTag->setInnerHtml($_html);
            $bodyTag->setInnerElements(null);
            $this->scriptsContents = (!empty($this->scriptsContents) ? $this->scriptsContents . "\n" : "") . $_jQuery;
        }

        // default js
        if (!empty(self::$defaultScriptsFiles)) {
            $_jfiles = array();
            foreach (self::$defaultScriptsFiles as $jfile) {
                if (is_string($jfile)) {
                    $_jfiles [] = array('src' => $jfile);
                } else if (is_array($jfile)) {
                    $_jfiles [] = $jfile;
                }
            }
            self::$defaultScriptsFiles = $_jfiles;
        }

        if ($this->isLoadBootstrapFromCDN == true) {
            array_unshift(self::$defaultScriptsFiles, array(
                "src" => self::BOOTSTRAP_JS_CDN_URL,
                "integrity" => self::BOOTSTRAP_JS_CDN_INTEGRITY,
                "crossorigin" => "anonymous"
            ));
        }
        if ($this->isLoadJQueryFromCDN == true) {
            array_unshift(self::$defaultScriptsFiles, array(
                "src" => self::JQUERY_CDN_URL,
                "integrity" => self::JQUERY_CDN_INTEGRITY,
                "crossorigin" => "anonymous"
            ));
        }

        if ($this->isLoadJQueryUIFromCDN == true) {
            array_unshift(self::$defaultScriptsFiles, array(
                "src" => self::JQUERY_UI_CDN_URL,
                "integrity" => self::JQUERY_UI_CDN_INTEGRITY,
                "crossorigin" => "anonymous"
            ));
        }

        if (!empty(self::$defaultScriptsFiles)) {
            foreach (self::$defaultScriptsFiles as $script) {
                $_scriptTag = new HtmlTag("script", $script);
                $bodyTag->appendInnerElements($_scriptTag);

                unset($_scriptTag);
            }
        }
        if (!empty($this->customScriptsFiles)) {
            foreach ($this->customScriptsFiles as $script) {
                $_scriptTag = new HtmlTag("script", array("src" => $script));
                $bodyTag->appendInnerElements($_scriptTag);

                unset($_scriptTag);
            }
        }

        if (!empty ($this->scriptsContents)) {
            $scriptTag = new HtmlTag("script");
            $scriptTag->setCdata($this->scriptsContents);
            $bodyTag->appendInnerElements($scriptTag);
        }

        return $bodyTag;
    }

    /**
     * @desc build the header part of html.
     * @return \model\Xantico\HtmlTag
     */
    private function buildHead()
    {
        if (!empty(self::$defaultCSSFiles)) {
            $_cfiles = array();
            foreach (self::$defaultCSSFiles as $cfile) {
                if (is_string($cfile)) {
                    $_cfiles [] = array("rel" => "stylesheet", 'href' => $cfile);
                } else if (is_array($cfile)) {
                    $_cfiles [] = $cfile;
                }
            }
            self::$defaultCSSFiles = $_cfiles;
        }

        if ($this->isLoadBootstrapFromCDN == true) {
            array_unshift(self::$defaultCSSFiles, array(
                "rel" => "stylesheet",
                "href" => self::BOOTSTRAP_CDN_URL,
                "integrity" => self::BOOTSTRAP_CDN_INTEGRITY,
                "crossorigin" => "anonymous"
            ));
        } else {
            // add your bootstrap css file path here.
            array_unshift(self::$defaultCSSFiles, array(
                "href" => self::BOOTSTRAP_HREF,
                "rel" => "stylesheet"
            ));
        }

        if ($this->isLoadJQueryUIFromCDN == true) {
            array_unshift(self::$defaultCSSFiles, array(
                "href" => self::JQUERY_UI_CSS_CDN_URL,
                "rel" => "stylesheet"
            ));
        }

        $head = new HtmlTag("head");
        $head->setInnerElements(new HtmlTag("meta", array("charset" => $this->encoding)));

        if (!empty($this->title)) {
            $title = new HtmlTag("title");
            $title->setText($this->title);
            $head->appendInnerElements($title);
        }

        if ($this->isResponsive == true) {
            $head->appendInnerElements(new HtmlTag("meta",
                array(
                    "name" => "viewport",
                    "content" => "width=device-width, initial-scale=1, shrink-to-fit=no"
                )));
        }

        if (!empty($this->keywords)) {
            array_walk($this->keywords, "htmlspecialchars");
            $head->sppendInnerElements(new HtmlTag("meta",
                array(
                    "name" => "keywords",
                    "content" => join(",", $this->keywords)
                )));

        }

        if (!empty($this->description)) {
            $head->sppendInnerElements(new HtmlTag("meta",
                array(
                    "name" => "description",
                    "content" => htmlspecialchars($this->description)
                )));
        }

        if (!empty($this->metaContents)) { // will override keywords/description if set.
            foreach ($this->metaContents as $key => $meta) {
                if (isset ($meta ['name'])) {
                    $head->appendInnerElements(new HtmlTag("meta",
                        array(
                            "name" => htmlspecialchars($meta ['name']),
                            "content" => htmlspecialchars($meta ['content'])
                        )));
                } else {
                    $head->appendInnerElements(new HtmlTag("meta",
                        array(
                            "name" => $key,
                            "content" => htmlspecialchars($meta)
                        )));
                }

            }
        }

        if (!empty(self::$defaultCSSFiles)) {
            foreach (self::$defaultCSSFiles as $css) {
                $_cssTag = new HtmlTag("link", $css);
                $head->appendInnerElements($_cssTag);
                unset ($_cssTag);
            }
        }

        if (!empty($this->customCSSFiles)) {
            foreach ($this->customCSSFiles as $css) {
                $_cssTag = new HtmlTag("link", array("rel" => "stylesheet", "href" => $css));
                $head->appendInnerElements($_cssTag);
                unset ($_cssTag);
            }
        }

        if (!empty($this->CSSContents)) {
            $styleTag = new HtmlTag("style");
            $styleTag->setAttrs(array("type" => "text/css"));
            $styleTag->setCdata($this->CSSContents);
            $head->appendInnerElements($styleTag);
        }

        return $head;
    }

    /**
     * @desc build whole html string.
     * @param unknown $head
     * @param unknown $body
     * @return string
     */
    private function buildHtml($head, $body)
    {
        $htmlTag = new HtmlTag("html", array("lang" => $this->lang));
        $htmlTag->setInnerElements(array($head, $body));

        $html = "<!doctype html>\n" . $htmlTag->render();
        return $html;
    }

    /**
     * @return the $customCSSFiles
     */
    public function getCustomCSSFiles()
    {
        return $this->customCSSFiles;
    }

    /**
     * @param field_type $customCSSFiles
     */
    public function setCustomCSSFiles($customCSSFiles = array())
    {
        if (empty($customCSSFiles)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $customCSSFiles = func_get_args();
        } else {
            if (!is_array($customCSSFiles)) $customCSSFiles = array($customCSSFiles);
        }

        if ($this->customCSSFiles && is_array($this->customCSSFiles)) $this->customCSSFiles = array_merge($this->customCSSFiles, $customCSSFiles);
        else $this->customCSSFiles = $customCSSFiles;

        return $this;
    }

    /**
     * @return the $customScriptsFiles
     */
    public function getCustomScriptsFiles()
    {
        return $this->customScriptsFiles;
    }

    /**
     * @param field_type $customScriptsFiles
     */
    public function setCustomScriptsFiles($customScriptsFiles = array())
    {
        if (empty($customScriptsFiles)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $customScriptsFiles = func_get_args();
        } else {
            if (!is_array($customScriptsFiles)) $customScriptsFiles = array($customScriptsFiles);
        }

        if ($this->customScriptsFiles && is_array($this->customScriptsFiles)) $this->customScriptsFiles = array_merge($this->customScriptsFiles, $customScriptsFiles);
        else $this->customScriptsFiles = $customScriptsFiles;

        return $this;
    }

    /**
     * @return the $bodyContents
     */
    public function getBodyContents()
    {
        return $this->bodyContents;
    }

    /**
     * @param Ambigous <multitype:, field_type> $bodyContents
     */
    public function setBodyContents($bodyContents = array())
    {
        if (empty($bodyContents)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $bodyContents = func_get_args();
        } else {
            if (!is_array($bodyContents)) $bodyContents = array($bodyContents);
        }

        $this->bodyContents = $bodyContents;

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

    /**
     * @return the $metaContents
     */
    public function getMetaContents()
    {
        return $this->metaContents;
    }

    /**
     * @param field_type $metaContents
     */
    public function setMetaContents($metaContents = array())
    {
        if (empty($metaContents)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $metaContents = func_get_args();
        } else {
            if (!is_array($metaContents)) $metaContents = array($metaContents);
        }

        if ($this->metaContents && is_array($this->metaContents)) $this->metaContents = array_merge($this->metaContents, $metaContents);
        else $this->metaContents = $metaContents;

        return $this;
    }

    /**
     * @return the $CSSContents
     */
    public function getCSSContents()
    {
        return $this->CSSContents;
    }

    /**
     * @param field_type $CSSContents
     */
    public function setCSSContents($CSSContents)
    {
        $this->CSSContents = $CSSContents;
        return $this;
    }

    /**
     * @return the $scriptsContents
     */
    public function getScriptsContents()
    {
        return $this->scriptsContents;
    }

    /**
     * @param field_type $scriptsContents
     */
    public function setScriptsContents($scriptsContents = "")
    {
        $this->scriptsContents = $scriptsContents;
        return $this;
    }

    /**
     * @return the $lang
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param field_type $lang
     */
    public function setLang($lang = 'zh-tw')
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * @return the $encoding
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * @param field_type $encoding
     */
    public function setEncoding($encoding = "utf-8")
    {
        $this->encoding = $encoding;
        return $this;
    }

    /**
     * @return the $isResponsive
     */
    public function getIsResponsive()
    {
        return $this->isResponsive;
    }

    /**
     * @param field_type $isResponsive
     */
    public function setIsResponsive($isResponsive = true)
    {
        $this->isResponsive = $isResponsive;
        return $this;
    }

    /**
     * @return the $isLoadOptionalCSS
     */
    public function getIsLoadOptionalCSS()
    {
        return $this->isLoadOptionalCSS;
    }

    /**
     * @param field_type $isLoadOptionalCSS
     */
    public function setIsLoadOptionalCSS($isLoadOptionalCSS = false)
    {
        $this->isLoadOptionalCSS = $isLoadOptionalCSS;
        return $this;
    }

    /**
     * @return the $isLoadBootstrapFromCDN
     */
    public function getIsLoadCSSFromCDN()
    {
        return $this->isLoadBootstrapFromCDN;
    }

    /**
     * @return the $isLoadJQueryFromCDN
     */
    public function getIsLoadJQueryFromCDN()
    {
        return $this->isLoadJQueryFromCDN;
    }

    /**
     * @param field_type $isLoadJQueryFromCDN
     */
    public function setIsLoadJQueryFromCDN($isLoadJQueryFromCDN = true)
    {
        $this->isLoadJQueryFromCDN = $isLoadJQueryFromCDN;
        return $this;
    }

    /**
     * @return the $isLoadBootstrapFromCDN
     */
    public function getIsLoadBootstrapFromCDN()
    {
        return $this->isLoadBootstrapFromCDN;
    }

    /**
     * @param field_type $isLoadBootstrapFromCDN
     */
    public function setIsLoadBootstrapFromCDN($isLoadBootstrapFromCDN = true)
    {
        $this->isLoadBootstrapFromCDN = $isLoadBootstrapFromCDN;
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

    public function setBody($index, $body)
    {
        $this->bodyContents [$index] = $body;
        return $this;
    }

    /**
     * @return the $keywords
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param field_type $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * @return the $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param field_type $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return the $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param field_type $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return the $isLoadJQueryUIFromCDN
     */
    public function getIsLoadJQueryUIFromCDN()
    {
        return $this->isLoadJQueryUIFromCDN;
    }

    /**
     * @param field_type $isLoadJQueryUIFromCDN
     */
    public function setIsLoadJQueryUIFromCDN($isLoadJQueryUIFromCDN = true)
    {
        $this->isLoadJQueryUIFromCDN = $isLoadJQueryUIFromCDN;
        return $this;
    }


}

