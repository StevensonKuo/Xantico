<?php
namespace model\bootstrap;

use model\bootstrap\HtmlTag;

class Xantico
{
    protected $customCSSFiles; // string
    protected $customScriptsFiles; // string
    protected $bodyContents; // array 
    protected $headContents; // array
    protected $CSSContents; // string
    protected $scriptsContents; // string
    
    protected $lang; // string
    protected $encoding; // string
    protected $isResponsive; // boolean
    protected $isLoadBootstrapFromCDN; // boolean
    protected $isLoadJQueryFromCDN; // boolean
    
    public static $elements = array (); // all Typography classes will be gathered into here.
    public static $defaultCSSFiles = array (); // array
    public static $defaultScriptsFiles = array (); // array
    
    const BOOTSTRAP_VERSION                 = '3.3.7'; // string
    const JQUERY_VERSION                    = '2.2.2'; // string
    
    const BOOTSTRAP_HREF                    = '/static/admin/css/bootstrap.min.css'; // local bootstrap css path.
    const BOOTSTRAP_JS_HREF                 = '/static/admin/js/bootstrap.min.js'; // local bootstrap css path.
    const JQUERY_HREF                       = '/static/admin/js/jquery.min.js'; // local jquery path.
    const SHARED_CSS_PATH                   = '/static/admin/css/plugins/';
    const SHARED_JS_PATH                    = '/static/admin/js/plugins/';
    
    const BOOTSTRAP_CDN_URL                 = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css';
    const BOOTSTRAP_CDN_INTEGRITY           = 'sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u';
    const BOOTSTRAP_OPTIONAL_CDN_URL        = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css';
    const BOOTSTRAP_OPTIONAL_CDN_INTEGRITY  = 'sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp';
    const BOOTSTRAP_JS_CDN_URL              = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js';
    const BOOTSTRAP_JS_CDN_INTEGRITY        = 'sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa';
    const JQUERY_CDN_URL                    = 'https://code.jquery.com/jquery-2.2.4.min.js';
    const JQUERY_CDN_INTEGRITY              = 'sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=';
    // localization 
    // https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/localization/messages_zh_TW.min.js
    
    public function __construct()
    {
        // bootstrap config
        $this->lang                     = 'zh-cn';
        $this->encoding                 = 'utf-8';
        
        // default bootstrap
        $this->customCSSFiles           = array ();
        $this->customScriptsFiles       = array ();
        $this->headContents             = array ();
        $this->bodyContents             = array ();
        
        $this->isResponsive             = true;
        $this->isLoadBootstrapFromCDN   = false;
        $this->isLoadJQueryFromCDN      = false;
        // bootstrap config end.
    }
    
    public function render ($display = false) {
        
        $body = $this->buildBody();
        $head = $this->buildHead();
        $html = $this->buildHtml($head, $body);
        
        if ($display == false) {
            return $html;
        } else {
            echo $html;
        }
        
    }
    
    private function buildHead () {
        if (!empty(self::$defaultCSSFiles)) {
            $_cfiles = array ();
            foreach (self::$defaultCSSFiles as $cfile) {
                if (is_string($cfile)) {
                    $_cfiles [] = array ("rel" => "stylesheet", 'href' => $cfile);
                } else if (is_array($cfile)) {
                    $_cfiles [] =  $cfile;
                }
            }
            self::$defaultCSSFiles = $_cfiles;
        }
        
        if ($this->isLoadBootstrapFromCDN == true) {
            // @todo take out this optional css.
            array_unshift(self::$defaultCSSFiles, array (
                "rel" => "stylesheet",
                "href" => self::BOOTSTRAP_OPTIONAL_CDN_URL,
                "integrity" => self::BOOTSTRAP_OPTIONAL_CDN_INTEGRITY,
                "crossorigin" => "anonymous"
            ));
            
            array_unshift(self::$defaultCSSFiles, array (
                "rel" => "stylesheet",
                "href" => self::BOOTSTRAP_CDN_URL,
                "integrity" => self::BOOTSTRAP_CDN_INTEGRITY,
                "crossorigin" => "anonymous"
            ));
            
            array_unshift(self::$defaultScriptsFiles, array (
                "src" => self::BOOTSTRAP_JS_CDN_URL,
                "integrity" => self::BOOTSTRAP_JS_CDN_INTEGRITY,
                "crossorigin" => "anonymous"
            ));
        } else {
            // add your bootstrap css file path here.
            array_unshift(self::$defaultCSSFiles, array (
                "href" => self::BOOTSTRAP_HREF,
                "rel" => "stylesheet"
            ));
        }
        
        $head = new HtmlTag("head");
        $head->setInnerElements(new HtmlTag("meta", array ("charset" => $this->encoding)));
        if ($this->isResponsive) {
            $head->setInnerElements(new HtmlTag("meta", 
                array ( "name" => "viewport",
                        "content" => "width=device-width, initial-scale=1, shrink-to-fit=no"
                )));
        }
        if (!empty(self::$defaultCSSFiles)) {
            foreach (self::$defaultCSSFiles as $css) {
                $_cssTag = new HtmlTag("link", $css);
                $head->setInnerElements($_cssTag);
                
                unset ($_cssTag);
            }
        }
        if (!empty($this->customCSSFiles)) {
            foreach ($this->customCSSFiles as $css) {
                $_cssTag = new HtmlTag("link", array ( "rel" => "stylesheet", "href" => $css));
                $head->setInnerElements($_cssTag);
                
                unset ($_cssTag);
            }
        }
        
        if(!empty($this->CSSContents)) {
            $styleTag = new HtmlTag("style");
            $styleTag->setAttrs(array ("type" => "text/css"));
            $styleTag->setCdata($this->CSSContents);
            $head->setInnerElements($styleTag);
        }
        
        return $head;
    }
    
    /**
     * @desc 建立整個 html string
     * @param unknown $head
     * @param unknown $body
     * @return string
     */
    private function buildHtml ($head, $body) {
        $htmlTag = new HtmlTag("html", array ("lang" => $this->lang));
        $htmlTag->setInnerElements(array ($head, $body));
        
        $html = "<!doctype html>\n" . $htmlTag->render();
        return $html;
    }
    
    /**
     * @desc 建立 html 的 body 部份
     * @return \model\bootstrap\HtmlTag
     */
    private function buildBody () {
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
            $bodyTag->truncateElements();
            $this->scriptsContents = (!empty($this->scriptsContents) ? $this->scriptsContents . "\n" : "") . $_jQuery;
        }
        
        // default js
        if (!empty(self::$defaultScriptsFiles)) {
            $_jfiles = array ();
            foreach (self::$defaultScriptsFiles as $jfile) {
                if (is_string($jfile)) {
                    $_jfiles [] = array ('src' => $jfile);
                } else if (is_array($jfile)) {
                    $_jfiles [] =  $jfile;
                }
            }
            self::$defaultScriptsFiles = $_jfiles;
        }
        
        if ($this->isLoadJQueryFromCDN) {
            array_unshift(self::$defaultScriptsFiles, array (
                "src" => self::JQUERY_CDN_URL,
                "integrity" => self::JQUERY_CDN_INTEGRITY,
                "crossorigin" => "anonymous"
            ));
        }
        
        if (!empty(self::$defaultScriptsFiles)) {
            foreach (self::$defaultScriptsFiles as $script) {
                $_scriptTag = new HtmlTag("script", $script);
                $bodyTag->setInnerElements($_scriptTag);
                
                unset($_scriptTag);
            }
        }
        if (!empty($this->customScriptsFiles)) {
            foreach ($this->customScriptsFiles as $script) {
                $_scriptTag = new HtmlTag("script", array ("src" => $script));
                $bodyTag->setInnerElements($_scriptTag);
                
                unset($_scriptTag);
            }
        }
        
        if (!empty ($this->scriptsContents)) {
            $scriptTag = new HtmlTag("script");
            $scriptTag->setCdata($this->scriptsContents);
            $bodyTag->setInnerElements($scriptTag);
        }
        
        return $bodyTag;
    }

    /**
     * @return the $customCSSFiles
     */
    public function getCustomCSSFiles()
    {
        return $this->customCSSFiles;
    }

    /**
     * @return the $customScriptsFiles
     */
    public function getCustomScriptsFiles()
    {
        return $this->customScriptsFiles;
    }

    /**
     * @return the $bodyContents
     */
    public function getBodyContents()
    {
        return $this->bodyContents;
    }

    /**
     * @return the $headContents
     */
    public function getHeadContents()
    {
        return $this->headContents;
    }

    /**
     * @return the $CSSContents
     */
    public function getCSSContents()
    {
        return $this->CSSContents;
    }

    /**
     * @return the $scriptsContents
     */
    public function getScriptsContents()
    {
        return $this->scriptsContents;
    }

    /**
     * @return the $lang
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @return the $encoding
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * @return the $isResponsive
     */
    public function getIsResponsive()
    {
        return $this->isResponsive;
    }

    /**
     * @return the $isLoadOptionalCSS
     */
    public function getIsLoadOptionalCSS()
    {
        return $this->isLoadOptionalCSS;
    }

    /**
     * @param field_type $customCSSFiles
     */
    public function setCustomCSSFiles($customCSSFiles = array ())
    {
        if (empty($customCSSFiles)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $customCSSFiles = func_get_args();
        } else {
            if (!is_array($customCSSFiles)) $customCSSFiles = array ($customCSSFiles);
        }
        
        if ($this->customCSSFiles && is_array($this->customCSSFiles)) $this->customCSSFiles = array_merge($this->customCSSFiles, $customCSSFiles);
        else $this->customCSSFiles = $customCSSFiles;
        
        return $this;
    }

    /**
     * @param field_type $customScriptsFiles
     */
    public function setCustomScriptsFiles($customScriptsFiles = array ())
    {
        if (empty($customScriptsFiles)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $customScriptsFiles = func_get_args();
        } else {
            if (!is_array($customScriptsFiles)) $customScriptsFiles = array ($customScriptsFiles);
        }
        
        if ($this->customScriptsFiles && is_array($this->customScriptsFiles)) $this->customScriptsFiles = array_merge($this->customScriptsFiles, $customScriptsFiles);
        else $this->customScriptsFiles = $customScriptsFiles;
        
        return $this;
    }

    /**
     * @param field_type $headContents
     */
    public function setHeadContents($headContents = array ())
    {
        if (empty($headContents)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $headContents = func_get_args();
        } else {
            if (!is_array($headContents)) $headContents = array ($headContents);
        }
        
        if ($this->headContents && is_array($this->headContents)) $this->headContents = array_merge($this->headContents, $headContents);
        else $this->headContents = $headContents;
        
        return $this;
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
     * @param field_type $scriptsContents
     */
    public function setScriptsContents($scriptsContents = "")
    {
        $this->scriptsContents = $scriptsContents;
        return $this;
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
     * @param field_type $encoding
     */
    public function setEncoding($encoding = "utf-8")
    {
        $this->encoding = $encoding;
        return $this;
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
     * @param field_type $isLoadBootstrapFromCDN
     */
    public function setIsLoadBootstrapFromCDN($isLoadBootstrapFromCDN = true)
    {
        $this->isLoadBootstrapFromCDN = $isLoadBootstrapFromCDN;
        return $this;
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
     * @param Ambigous <multitype:, field_type> $bodyContents
     */
    public function setBodyContents($bodyContents = array ())
    {
        if (empty($bodyContents)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $bodyContents = func_get_args();
        } else {
            if (!is_array($bodyContents)) $bodyContents = array ($bodyContents);
        }
        
        if ($this->bodyContents && is_array($this->bodyContents)) $this->bodyContents = array_merge($this->bodyContents, $bodyContents);
        else $this->bodyContents = $bodyContents;
        
        return $this;
    }




}

