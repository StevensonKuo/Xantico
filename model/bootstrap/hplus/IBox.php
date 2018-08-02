<?php
namespace app\admin\model\bootstrap\hplus;

class IBox extends \app\admin\model\bootstrap\basic\Panel 
{ // hplus 的 widget 叫 ibox
    protected $toolbox = array ("collapse" => false, "dropdown" => array(), "close" => false, "refresh" => false); // string, 工具箱有: collapse, dropdown, close

    /**
     * 
     * @param unknown $display
     * @return unknown
     */
    public function render ($display = false) {
        $this->bodyContents = $this->innerElements;
        $class = $this->customClass;
        $class [] = "ibox";
        if ($this->flat == true) $class [] = "float-e-margins";
        $html = "<div class=\"" . join(" ", $class) . "\">\n";
        $jquery = "";
        if ($this->title) {
        		$html .= "<div class=\"ibox-title\">
        			         <h5>{$this->title}</h5>";
        		if ($this->subTitle) $html .= "<small class=\"m-l-sm\">" . $this->subTitle . "</small>\n";
        		if (!empty($this->toolbox)) {
        		    $html .= "<div class=\"ibox-tools\" id=\"{$this->id}\">\n";
        		    if (isset($this->toolbox['collapse']) && $this->toolbox['collapse'] == true) {
            		    $html .= "<a class=\"collapse-link\" title=\"Collapse\">
            		              <i class=\"fa fa-chevron-up\"></i>
            		              </a>";
            		    $jquery .= "
                    		    //折叠ibox
                    		    $('#{$this->id} .collapse-link').click(function () {
                    		        var ibox = $(this).closest('div.ibox');
                    		        var button = $(this).find('i');
                    		        var content = ibox.find('div.ibox-content');
                    		        content.slideToggle(200);
                    		        button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
                    		        ibox.toggleClass('').toggleClass('border-bottom');
                    		        setTimeout(function () {
                    		            ibox.resize();
                    		            ibox.find('[id^=map-]').resize();
                    		        }, 50);
                    		    });
            		        ";
        		    }
        		    if (isset($this->toolbox["dropdown"]) && count($this->toolbox["dropdown"]) > 0) {
            		    $html .= "<a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"tabs_panels.html#\" title=\"More...\">
            		                  <i class=\"fa fa-wrench\"></i>
            		              </a>
            		              <ul class=\"dropdown-menu dropdown-user\">";
        		        foreach ($this->toolbox["dropdown"] as $dropdown) {
        		            $html .= "<li><a href=\"".(isset($dropdown['href']) ? $dropdown['href'] : "")."\">".(isset($dropdown['text']) ? $dropdown['text'] : "")."</a>
        		                     </li>\n";
        		        }
            		    $html .= "</ul>";
        		            		        
        		    }
        		    if (isset($this->toolbox['close']) && $this->toolbox['close'] == true) {
            		    $html .= "<a class=\"close-link\" title=\"Close\">
            		              <i class=\"fa fa-times\"></i>
            		              </a>";
            		    $jquery .= "
                            //关闭ibox
            		        $('#{$this->id} .close-link').click(function () {
            		            var content = $(this).closest('div.ibox');
            		            content.remove();
            		        });
                            ";
        		    }
        		    if (isset($this->toolbox['refresh']) && $this->toolbox['refresh'] == true) {
        		        $html .= "<a class=\"refresh-link\" title=\"Refresh\">
            		              <i class=\"fa fa-refresh\"></i>
            		              </a>";
        		        $jquery .= "
                            //刷新頁面
                            $('#{$this->id} .refresh-link').click(function() {
                                location.reload();
                            });
                            ";
        		    }
        		    $html .= "</div>"; // end of ibox-toolbox div
        		}
        		$html .= "</div>\n"; // end of ibox-title div
        }
        
        $html .= "<div class=\"ibox-content table-responsive\">";
        if ($this->bodyContents) {
            foreach ($this->bodyContents as $ele) {
                if (!$ele) continue; // pass 空物件
                if (method_exists($ele, "render") && method_exists($ele, "getJQuery")) {
                    $html .= $ele->render() . "\n";
                    $jquery .= $ele->getJQuery () . "\n";
                } else {
                    $html .= $ele . "\n";
                }
            }
        } else {
            $html .= "&nbsp;";
        }
        $html .= "</div>
            </div>"; // end of ibox div.
                        
        $this->html = $html;
        $this->jQuery .= $jquery;
        
        if ($display) {
            echo $html;
        } else {
            return $html;
        }
    }
    /**
     * @return the $toolbox
     */
    public function getToolbox()
    {
        return $this->toolbox;
    }

    /**
     * @param Ambigous <multitype:, multitype:boolean multitype: > $toolbox
     */
    public function setToolbox($collapse = false, $dropdown = array (), $close = false, $refresh = false)
    {
        $this->toolbox ['collapse'] = $collapse;
        $this->toolbox ['dropdown'] = $dropdown;
        $this->toolbox ['close']    = $close;
        $this->toolbox ['refresh']  = $refresh;
        
        return $this;
    }

    
 
}


