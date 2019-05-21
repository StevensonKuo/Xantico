<?php
namespace Xantico\Bootstrap\Basic;

use Xantico\Bootstrap\HtmlTag;
use Xantico\Bootstrap\CaptionInterface;

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
     * @return \model\Xantico\basic\Typography
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
            if (!empty($this->size)) $pager->appendCustomClass("pagination-" . $this->size);
            if (!empty($this->queryString)) $_queryStr = http_build_query($this->queryString) . "&";
            else $_queryStr = "";
            
            // Previous button
            $_previous = new HtmlTag("li");
            if ($this->mode == "aligned-pager") $_previous->appendCustomClass("previous");
            $_movesTo = $this->activeIndex;
            if ($this->activeIndex == 0) {
                $_previous->appendCustomClass("disabled");
                $_movesTo = 1;
            }
            $_prevA = new HtmlTag("a");
            $_prevA->appendAttrs(array("href" => $this->url . "?" . $_queryStr . self::$PAGE_PARAM_NAME . "=" . $_movesTo))
            ->appendAttrs(array("aria-label" => "Previous"));
            if ($this->mode == "pagination") {
                $_prevSpan = new HtmlTag("span");
                $_prevSpan->appendAttrs(array ("aria-hidden" => "true"));
                $_prevSpan->setCdata(self::$PREVIOUS_SIGN);
            } else if ($this->mode == "pager") {
                $_prevSpan = CaptionInterface::CAP_PREVIOUS;
            } else { // aligned-pager
                $_prevSpanInner = new HtmlTag("span");
                $_prevSpanInner->appendAttrs(array ("aria-hidden" => "true"));
                $_prevSpanInner->setCdata(self::$PREVIOUS_ALIGNED_SIGN);
                $_prevSpan = $_prevSpanInner->render () . CaptionInterface::CAP_OLDER;
            }
            $_previous->appendInnerElements($_prevA->appendInnerElements($_prevSpan));
            unset ($_prevSpan);
            $pager->appendInnerElements($_previous);
            
            // pages button
            if ($this->mode == "pagination") {
                for ($p = 0; $p < $_pages; $p++) {
                    $_li = new HtmlTag("li");
                    if ($p == $this->activeIndex) { // in current page.
                        $_li->appendCustomClass("active");
                        $_a = new HtmlTag("span");
                        $_active = new HtmlTag("span", array ("class" => "sr-only"));
                        $_active->setText("(current)");
                        $_a->appendInnerElements(array($p + 1, $_active));
                        unset ($_active);
                    } else {
                        $_a = new HtmlTag("a");
                        $_a->appendAttrs(array ("href" => $this->url . "?" . $_queryStr . self::$PAGE_PARAM_NAME . "=" . ($p+1)));
                        $_a->setText($p + 1);
                    }
                    $_li->appendInnerElements($_a);
                    $pager->innerElements [] = $_li;
                    unset ($_a);
                    unset ($_li);
                } // end of for pages
            }
            
            // next button
            $_next = new HtmlTag("li");
            if ($this->mode == "aligned-pager") $_next->appendCustomClass("next");
            $_movesTo = $this->activeIndex + 2;
            if ($this->activeIndex >= $_pages - 1) {
                $_next->appendCustomClass("disabled");
                $_movesTo = $_pages;
            }
            $_nextA = new HtmlTag("a");
            $_nextA->appendAttrs(array("href" => $this->url . "?" . $_queryStr . self::$PAGE_PARAM_NAME . "=" . $_movesTo))
            ->appendAttrs(array("aria-label" => "Next"));
            if ($this->mode == "pagination") {
                $_nextSpan = new HtmlTag("span");
                $_nextSpan->appendAttrs(array ("aria-hidden" => "true"));
                $_nextSpan->setCdata(self::$NEXT_SIGN);
            } else if ($this->mode == "pager") {
                $_nextSpan = CaptionInterface::CAP_NEXT;
            } else { // aligned-pager
                $_nextSpanInner = new HtmlTag("span");
                $_nextSpanInner->appendAttrs(array ("aria-hidden" => "true"));
                $_nextSpanInner->setCdata(self::$NEXT_ALIGNED_SIGN);
                $_nextSpan = CaptionInterface::CAP_NEWER . $_nextSpanInner->render ();
            }
            $_next->appendInnerElements($_nextA->appendInnerElements($_nextSpan));
            unset ($_nextSpan);
            $pager->appendInnerElements($_next);
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
     * pagination mode
     * @param string $mode [pagination|pager|aligned-pager]
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
    
    public function setModePagination () {
        $this->mode = "pagination";
        return $this;
    }
    
    public function setModePager () {
        $this->mode = "pager";
        return $this;
    }
    
    public function setModeAlignedPager () {
        $this->mode = "aligned-pager";
        return $this;
    }
    
}

