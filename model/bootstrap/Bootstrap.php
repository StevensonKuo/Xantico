<?php
namespace model\bootstrap;

use model\bootstrap\HtmlTag;

class Bootstrap
{
    protected $defaultCSSFiles; // array 
    protected $defaultScriptsFiles; // array
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
    protected $isLoadOptionalCSS; // boolean
    protected $isLoadJQueryFromCDN; // boolean
    
    public $elements; // BootstrapElements
    public $bootstrapVersion; // string
    public $jQueryVersion; // string
    
    const BOOTSTRAP_HREF    = '/static/admin/css/bootstrap.min.css'; // 自己 local 端的 bootstrap css path.
    const BOOTSTRAP_JS_HREF = '/static/admin/js/bootstrap.min.js'; // 自己 local 端的 bootstrap css path.
    const JQUERY_HREF       = '/static/admin/js/jquery.min.js'; // 自己 local 端的 jquery path.
    const SHARED_CSS_PATH   = '/static/admin/css/plugins/';
    const SHARED_JS_PATH    = '/static/admin/js/plugins/';
    
    const BOOTSTRAP_CDN_HREF                = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css';
    const BOOTSTRAP_CDN_INTEGRITY           = 'sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u';
    const BOOTSTRAP_OPTIONAL_CDN_HREF       = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css';
    const BOOTSTRAP_OPTIONAL_CDN_INTEGRITY  = 'sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp';
    const BOOTSTRAP_JS_CDN_HREF             = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js';
    const BOOTSTRAP_JS_CDN_INTEGRITY        = 'sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa';
    const JQUERY_CDN_HREF                   = 'https://code.jquery.com/jquery-2.2.4.min.js';
    const JQUERY_CDN_INTEGRITY              = 'sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=';
    
    public function __construct()
    {
        // bootstrap config
        $this->bootstrapVersion = '3.3.7';
        $this->jQueryVersion    = '2.2.2';
        $this->lang             = 'zh-cn';
        $this->encoding         = 'utf-8';
        
        // default bootstrap
        $this->defaultCSSFiles      = array ();
        $this->defaultScriptsFiles  = array ();
        $this->customCSSFiles       = array ();
        $this->customScriptsFiles   = array ();
        $this->headContents         = array ();
        $this->bodyContents         = array ();
        
        $this->isResponsive             = true;
        $this->isLoadBootstrapFromCDN   = false;
        $this->isLoadJQueryFromCDN      = false;
        $this->isLoadOptionalCSS        = false;
        // bootstrap config end.
    }
    
    public function render ($display = false) {
        // default js
        if ($this->isLoadJQueryFromCDN) {
            $this->defaultScriptsFiles [] = array (
                "src" => self::JQUERY_CDN_HREF,
                "integrity" => self::JQUERY_CDN_INTEGRITY,
                "crossorigin" => "anonymous"
            );
        }
        
        if ($this->isLoadBootstrapFromCDN) {
            $this->defaultCSSFiles [] = array (
                "rel" => "stylesheet",
                "href" => self::BOOTSTRAP_CDN_HREF,
                "integrity" => self::BOOTSTRAP_CDN_INTEGRITY,
                "crossorigin" => "anonymous"
            );
            $this->defaultScriptsFiles [] = array (
                "src" => self::BOOTSTRAP_JS_CDN_HREF,
                "integrity" => self::BOOTSTRAP_JS_CDN_INTEGRITY,
                "crossorigin" => "anonymous"
            );
            
            if ($this->isLoadOptionalCSS) {
                $this->defaultCSSFiles [] = array (
                    "rel" => "stylesheet",
                    "href" => self::BOOTSTRAP_OPTIONAL_CDN_HREF,
                    "integrity" => self::BOOTSTRAP_OPTIONAL_CDN_INTEGRITY,
                    "crossorigin" => "anonymous"
                );
                
            }
        } else {
            // add your bootstrap css file path here.
            $this->defaultCSSFiles [] = array (
                "href" => self::BOOTSTRAP_HREF,
                "rel" => "stylesheet"
            );
        }
        
        $head = $this->buildHead();
        $body = $this->buildBody();
        $html = $this->buildHtml($head, $body);
        
        if ($display == false) {
            return $html;
        } else {
            echo $html;
        }
        
        /*
         * 
         * <!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <h1>Hello, world!</h1>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>

         */
    }
    
    private function buildHead () {
        $head = new HtmlTag("head");
        $head->setInnerElements(new HtmlTag("meta", array ("charset" => $this->encoding)));
        if ($this->isResponsive) {
            $head->setInnerElements(new HtmlTag("meta", 
                array ( "name" => "viewport",
                        "content" => "width=device-width, initial-scale=1, shrink-to-fit=no"
                )));
        }
        if (!empty($this->defaultCSSFiles)) {
            foreach ($this->defaultCSSFiles as $css) {
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
        $bodyTag = new HtmlTag("body");
        $bodyTag->setInnerElements($this->bodyContents);
        
        if (!empty($this->defaultScriptsFiles)) {
            foreach ($this->defaultScriptsFiles as $script) {
                $_scriptTag = new HtmlTag("script", $script);
                $_scriptTag->setInnerText("\t"); // script 不是 <script/> 的 tag
                $bodyTag->setInnerElements($_scriptTag);
                
                unset($_scriptTag);
            }
        }
        if (!empty($this->customScriptsFiles)) {
            foreach ($this->customScriptsFiles as $script) {
                $_scriptTag = new HtmlTag("script", array ("src" => $script));
                $_scriptTag->setInnerText("\t");
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
     * @return the $defaultCSSFiles
     */
    public function getDefaultCSSFiles()
    {
        return $this->defaultCSSFiles;
    }

    /**
     * @return the $defaultScriptsFiles
     */
    public function getDefaultScriptsFiles()
    {
        return $this->defaultScriptsFiles;
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
     * @param multitype:multitype:string   $defaultCSSFiles
     */
    public function setDefaultCSSFiles($defaultCSSFiles = array ())
    {
        if (empty($defaultCSSFiles)) return $this;
        
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $defaultCSSFiles = func_get_args();
        } else {
            if (!is_array($defaultCSSFiles)) $defaultCSSFiles = array ($defaultCSSFiles);
        }
        
        if ($this->defaultCSSFiles && is_array($this->defaultCSSFiles)) $this->defaultCSSFiles = array_merge($this->defaultCSSFiles, $defaultCSSFiles);
        else $this->defaultCSSFiles = $defaultCSSFiles;
        
        return $this;
    }

    /**
     * @param field_type $defaultScriptsFiles
     */
    public function setDefaultScriptsFiles($defaultScriptsFiles = array ())
    {
        if (empty($defaultScriptsFiles)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $defaultScriptsFiles = func_get_args();
        } else {
            if (!is_array($defaultScriptsFiles)) $defaultScriptsFiles = array ($defaultScriptsFiles);
        }
        
        if ($this->defaultScriptsFiles && is_array($this->defaultScriptsFiles)) $this->defaultScriptsFiles = array_merge($this->defaultScriptsFiles, $defaultScriptsFiles);
        else $this->defaultScriptsFiles = $defaultScriptsFiles;
        
        return $this;
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

