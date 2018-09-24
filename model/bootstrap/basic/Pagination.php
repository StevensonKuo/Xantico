<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;
use model\bootstrap\iCaption;

class Pagination extends Typography 
{
    protected $activeIndex; // int
    protected $maxShowPages; // int
    protected $recordsPerPage; // int
    protected $totalRecords; // int
    protected $pages; // int
    protected $url; // string
    protected $queryString; // array
    
    public static $PREVIOUS_SIGN            = "&laquo;";
    public static $NEXT_SIGN                = "&raquo;";
    public static $PREVIOUS_ALIGNED_SIGN    = "&larr;";
    public static $NEXT_ALIGNED_SIGN        = "&rarr;";
    public static $PAGE_PARAM_NAME          = "p";
    
    private static $modeArr = array ("pagination", "pager", "aligned-pager");
    
    /**
     * @param array $vars
     * @param array $attrs
     * @return \model\bootstrap\basic\Typography
     */
    public function __construct($vars = array (), $attrs = array ())
    {
        $attrs ['aria-label']   = "Page navigation";
        parent::__construct("nav", $vars, $attrs);
        
        $this->type             = "pagination"; 
        $this->activeIndex      = isset ($vars ['activeIndex']) ? $vars ['activeIndex'] : 0;
        $this->maxShowPages     = isset ($vars ['maxShowPages']) ? $vars ['maxShowPages'] : 10;
        $this->recordsPerPage   = isset ($vars ['recordsPerPage']) ? $vars ['recordsPerPage'] : 10;
        $this->totalRecords     = isset ($vars ['totalRecords']) ? $vars ['totalRecords'] : 0;
        $this->pages            = isset ($vars ['pages']) ? $vars ['pages'] : 1;
        $this->url              = isset ($vars ['url']) ? $vars ['url'] : "";
        $this->mode             = empty($this->mode) ? "pagination" : $this->mode; // defualt mode.
    }
    
    /**
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        
        if ($this->pages > 0 || ceil($this->totalRecords / $this->recordsPerPage) > 0) {
            $_pages = $this->pages > 0 ?  $this->pages : ceil($this->totalRecords / $this->recordsPerPage);
            if ($this->activeIndex > $_pages-1) $this->activeIndex = $_pages-1; // collate index.
            
            if ($this->mode == "pager" || $this->mode == "aligned-pager") {
                $pager = new Typography("ul:pager");
            } else {
                $pager = new Typography("ul:pagination");
            }
            if (!empty($this->size)) $pager->setCustomClass("pagination-" . $this->size);
            if (!empty($this->queryString)) $_queryStr = http_build_query($this->queryString) . "&";
            else $_queryStr = "";
            
            // Previous button
            $_previous = new HtmlTag("li");
            if ($this->mode == "aligned-pager") $_previous->setCustomClass("previous");
            $_movesTo = $this->activeIndex;
            if ($this->activeIndex == 0) {
                $_previous->setCustomClass("disabled");
                $_movesTo = 1;
            }
            $_prevA = new HtmlTag("a");
            $_prevA->setAttrs(array("href" => $this->url . "?" . $_queryStr . self::$PAGE_PARAM_NAME . "=" . $_movesTo))
            ->setAttrs(array("aria-label" => "Previous"));
            if ($this->mode == "pagination") {
                $_prevSpan = new HtmlTag("span");
                $_prevSpan->setAttrs(array ("aria-hidden" => "true"));
                $_prevSpan->setCdata(self::$PREVIOUS_SIGN);
            } else if ($this->mode == "pager") {
                $_prevSpan = iCaption::CAP_PREVIOUS;
            } else { // aligned-pager
                $_prevSpanInner = new HtmlTag("span");
                $_prevSpanInner->setAttrs(array ("aria-hidden" => "true"));
                $_prevSpanInner->setCdata(self::$PREVIOUS_ALIGNED_SIGN);
                $_prevSpan = $_prevSpanInner->render () . iCaption::CAP_OLDER;
            }
            $_previous->setInnerElements($_prevA->setInnerElements($_prevSpan));
            unset ($_prevSpan);
            $pager->setInnerElements($_previous);
            
            // pages button
            if ($this->mode == "pagination") {
                for ($p = 0; $p < $_pages; $p++) {
                    $_li = new HtmlTag("li");
                    if ($p == $this->activeIndex) { // in current page.
                        $_li->setCustomClass("active");
                        $_a = new HtmlTag("span");
                        $_active = new HtmlTag("span", array ("class" => "sr-only"));
                        $_active->setText("(current)");
                        $_a->setInnerElements(array($p + 1, $_active));
                        unset ($_active);
                    } else {
                        $_a = new HtmlTag("a");
                        $_a->setAttrs(array ("href" => $this->url . "?" . $_queryStr . self::$PAGE_PARAM_NAME . "=" . ($p+1)));
                        $_a->setText($p + 1);
                    }
                    $_li->setInnerElements($_a);
                    $pager->innerElements [] = $_li;
                    unset ($_a);
                    unset ($_li);
                } // end of for pages
            }
            
            // next button
            $_next = new HtmlTag("li");
            if ($this->mode == "aligned-pager") $_next->setCustomClass("next");
            $_movesTo = $this->activeIndex + 2;
            if ($this->activeIndex >= $_pages - 1) {
                $_next->setCustomClass("disabled");
                $_movesTo = $_pages;
            }
            $_nextA = new HtmlTag("a");
            $_nextA->setAttrs(array("href" => $this->url . "?" . $_queryStr . self::$PAGE_PARAM_NAME . "=" . $_movesTo))
            ->setAttrs(array("aria-label" => "Next"));
            if ($this->mode == "pagination") {
                $_nextSpan = new HtmlTag("span");
                $_nextSpan->setAttrs(array ("aria-hidden" => "true"));
                $_nextSpan->setCdata(self::$NEXT_SIGN);
            } else if ($this->mode == "pager") {
                $_nextSpan = iCaption::CAP_NEXT;
            } else { // aligned-pager
                $_nextSpanInner = new HtmlTag("span");
                $_nextSpanInner->setAttrs(array ("aria-hidden" => "true"));
                $_nextSpanInner->setCdata(self::$NEXT_ALIGNED_SIGN);
                $_nextSpan = iCaption::CAP_NEWER . $_nextSpanInner->render ();
            }
            $_next->setInnerElements($_nextA->setInnerElements($_nextSpan));
            unset ($_nextSpan);
            $pager->setInnerElements($_next);
            $this->innerElements [] = $pager;
        }
        
        parent::render();
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    
    /**
     * @return the $activeIndex
     */
    public function getActiveIndex()
    {
        return $this->activeIndex;
    }
    
    /**
     * @return the $activeIndex
     */
    public function getCurrentPage()
    {
        return $this->activeIndex+1;
    }
    
    /**
     * @param field_type $activeIndex
     */
    public function setActiveIndex($activeIndex)
    {
        $this->activeIndex = $activeIndex;
        return $this;
    }
    
    /**
     * @desc setActiveIndex alias, use page, not index.
     * @param field_type $activeIndex
     */
    public function setCurrentPage($page)
    {
        $this->activeIndex = max($page - 1, 0);
        return $this;
    }
    
    /**
     * @return the $maxShowPages
     */
    public function getMaxShowPages()
    {
        return $this->maxShowPages;
    }

    /**
     * @return the $recordsPerPage
     */
    public function getRecordsPerPage()
    {
        return $this->recordsPerPage;
    }

    /**
     * @return the $totalRecords
     */
    public function getTotalRecords()
    {
        return $this->totalRecords;
    }

    /**
     * @return the $pages
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param Ambigous <boolean, array> $maxShowPages
     */
    public function setMaxShowPages($maxShowPages)
    {
        $this->maxShowPages = $maxShowPages;
        return $this;
    }

    /**
     * @param Ambigous <boolean, array> $recordsPerPage
     */
    public function setRecordsPerPage($recordsPerPage)
    {
        $this->recordsPerPage = $recordsPerPage;
        return $this;
    }

    /**
     * @param Ambigous <boolean, array> $totalRecords
     */
    public function setTotalRecords($totalRecords)
    {
        $this->totalRecords = $totalRecords;
        return $this;
    }

    /**
     * @param Ambigous <boolean, array> $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
        return $this;
    }
    
    /**
     * @return the $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param field_type $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @desc three sizes [xs|sm|lg]
     * @param string $size
     */
    public function setSize($size)
    {
        switch ($size) {
            case 1:
                //                 $this->size = "miner";
                $this->size = ""; // preserved.
                break;
            case 2:
                $this->size = "xs";
                break;
            case 3:
                $this->size = "sm";
                break;
            case 4:
                $this->size = "";
                break;
            case 5:
                $this->size = "lg";
                break;
            default:
                $this->size = $size;
                
        }
        
        return $this;
    }
    /**
     * @return the $queryString
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

    /**
     * @param field_type $queryString
     */
    public function setQueryString($queryString)
    {
        $this->queryString = $queryString;
        return $this;
    }

    /**
     * @desc mode : [button|inline]
     * @param field_type $mode [button|inline]
     */
    public function setMode($mode)
    {
        $mode = strtolower($mode);
        if (in_array($mode, self::$modeArr)) {
            $this->mode = $mode;
        } else {
            // @todo format err msg.
            $this->setErrMsg("[Notice] You set a wrong mode of <class>Pagination. Default mode is 'pagination'");
        }
        
        return $this;
    }
    
}

