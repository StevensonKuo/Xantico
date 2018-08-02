<?php
namespace app\admin\model\bootstrap\hplus;


class Slider extends \app\admin\model\bootstrap\basic\Slider
{
    
    protected $type; // top-menu, right-menu, bottom-menu, settings-box
    
    public function render($display = false)
    {
        $html = "";
        
        switch ($this->type) {
            case "right-menu":
                $html = "
                    <div id=\"right-menu\" class=\"modal aside\" data-body-scroll=\"false\" data-offset=\"true\" data-placement=\"right\" data-fixed=\"true\" data-backdrop=\"false\" tabindex=\"-1\">
                        <div class=\"modal-dialog\"" . ($this->width ? " style=\"width: {$this->width}px;\"" : "") . ">
                        	<div class=\"modal-content". ($this->scrollBar ? " ace-scroll" : "") . "\">" . 
                              ($this->scrollBar ? "<div class=\"scroll-track scroll-dark no-track idle-hide scroll-active\" style=\"display: block; height: 400px;\"><div class=\"scroll-bar\" style=\"height: 68px; top: 0px;\"></div></div>
                              <div class=\"scroll-content\" style=\"max-height: 400px;\">" : "") . 
                        		"<div class=\"modal-header no-padding\">
                        			<div class=\"table-header\">
                        			" . ($this->closeBtn ? "
                            				<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">
                            					<span class=\"white\">×</span>
                            				</button>" : "") . 
                        				$this->header . "
                        			</div>
                        		</div>
                        
                        		<div class=\"modal-body\">
                                    {$this->body}
                        		</div>". 
                        	   ($this->scrollBar ? "</div><!-- /.scroll-content -->" : "") . 
                        	"</div><!-- /.modal-content -->
                        
                        	<button class=\"aside-trigger btn btn-info btn-app btn-xs ace-settings-btn open\" data-target=\"#right-menu\" data-toggle=\"modal\" type=\"button\">
                        		<i data-icon1=\"fa-minus\" data-icon2=\"fa-plus\" class=\"ace-icon fa bigger-110 icon-only fa-plus\"></i>
                        	</button>
                        </div>
                    </div>
                ";
                break;
            case "top-menu":
                break;
            case "bottom-menu":
                break;
            case "settings-box":
                break;
            default:
        }
        
        $this->jQuery = "
                // These scripts are necessary for side slider.
				$('.modal.aside').ace_aside(); " . 
				($this->isHidden ? "" : "$('.aside-trigger').click(); // auto-initial.    \n");
        $this->html = $html;
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    /**
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @desc Slider Type setter: 
     * @param Ambigous <field_type, unknown> $type
     */
    public function setType($type)
    {
        $this->type = $type;
        
        return $this;
    }

    


}

