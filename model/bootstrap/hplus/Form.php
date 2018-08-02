<?php
namespace app\admin\model\bootstrap\hplus;

use app\admin\model\bootstrap\HtmlTag;
use app\admin\model\bootstrap\hplus\Typography;

class Form extends \app\admin\model\bootstrap\basic\Form
{
    
    public static $validationCSS;
    public static $validationScript;
    
    private $validation; // array
    
    public function __construct($formType = "horizontal", $vars = array (), $attrs = array ()) {
        parent::__construct($formType, $vars, $attrs);
        
        $this->formType         = isset($formType) ? $formType : "horizontal";
        $this->validation       = array ();
        
        self::$validationCSS = "/" . __DIR__ . "assets/cmxform.css";
        self::$validationScript = "/" . __DIR__ . "javascripts/jquery/jquery.validate.min.js";
        
    }
    /**
     * generate html.
     * @param string $display
     */
    function render ($display = false) {
        $this->formType = "form-" . $this->formType;
        
        $jQuery = "";
        $actionHtml = "";
        if ($this->formAction) {
            switch ($this->formType) {
                case "double-column":
                case "form-horizontal":
                    foreach ($this->formAction as $act) {
                        if (empty($act)) continue;
                        if ($act instanceof Typography || true) {
                            if (method_exists($act, "render")) $actionHtml .= $act->render () . "\n";
                            if (method_exists($act, "getJQuery")) $jQuery .= $act->getJQuery () . "\n";
                        } else { // string
                            $actionHtml .= $act . "\n";
                        }
                    }
                    
                    $divHr = new Typography("div:hr-line-dashed");
                    $divHr->setText("\t");
                    $divFormGrp = new Typography("div:form-group");
                    $divCol12 = new Typography("div:col-sm-12");
                    //  col-sm-offset-2
                    $divFormGrp->setInnerElements($divCol12->setInnerElements($actionHtml));
                    $divFormGrp->setJQuery($jQuery); // 把原來 formActions 的 jQuery 併到 divFormGrp 裡
                    $this->formAction = array($divHr, $divFormGrp);
                    break;
                case "form-inline":
                default:
                    break;
            }
        }
        
        /* 目前沒fieldset 的 form, 先等一下
        if ($this->formType == "fieldset") {
            // @todo 像這樣也是原來 elements 的 js 都會不見.... 
            $fieldSet = new HtmlTag("fieldset");
            $fieldSet->setInnerElements($this->getInnerElements ());
            $this->innerElements = $fieldSet;
        }
        */
        
        parent::render();
        
        if (!empty($this->validation)) {
            $jQuery .= $this->generateValidationRulesScript() . "\n";
        }
        
        $this->jQuery .= $jQuery;
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
        
    }
    
    /**
     * @desc 建立必須欄位的檢查規則 script (json). 注意用的是 input 的 name, 不是 id
     * @author Stevenson Kuo
     */
     private function generateValidationRulesScript()
     {
         
        foreach ($this->validation as $name => $value) {
            $validationRules ['rules'][$name]['required'] = true;
            $validationRules ['messages'][$name]['required'] = "．" . $value ['requiredMessage'];
            if (isset($value ['maxlength'])) {
                $validationRules ['rules'][$name]['maxlength'] = $value ['maxlength'];
                $validationRules ['messages'][$name]['maxlength'] = "．" . $value ['maxlengthMessage'];
            }
            if (isset($value ['minlength'])) {
                $validationRules ['rules'][$name]['minlength'] = $value ['minlength'];
                $validationRules ['messages'][$name]['minlength'] = "．" . $value ['minlengthMessage'];
            }
            if (isset($value ['equalTo'])) {
                $validationRules ['rules'][$name]['equalTo'] = $value ['equalTo'];
                $validationRules ['messages'][$name]['equalTo'] = "．" . $value ['equalToMessage'];
            }
            if (isset($value ['email'])) {
                $validationRules ['rules'][$name]['email'] = true;
                $validationRules ['messages'][$name]['email'] = "．" . $value ['emailMessage'];
            }
        }
        
        $script = "\$(\"form[name={$this->name}]\").validate(" . json_encode($validationRules) . ")";
        return $script;
     }

    
    /**
     * @desc set one default submit button.
     * @param Button $buttonObj
     * @return \Bootstrap\Aceadmin\Form
     */
     function setFormAction ($formAction = null) {
         $numargs = func_num_args();
         if ($numargs >= 2) {
             $formAction = func_get_args();
         }
         
         if (!empty($formAction)) {
             if (!is_array($formAction)) $formAction = array ($formAction);
             foreach ($formAction as $action) {
                 if ($action instanceof \app\admin\model\bootstrap\basic\Typography || true) {
                     // @todo 所有的元素還不是繼承 typography
                     $this->formAction [] = $action;
                 } else {
                     throw new \Exception("Unsupported Form Action Elements.");
                 }
             }
         } else {
             $submit = new Button();
             $submit->setIsSubmit(true);
             $submit->setText("送出")
                 ->setColorSet("primary")
                 ->setSize(5)
                 ->setIsBlock()
                 ->setIcon(new Icon("floppy-o"));
             $this->formAction [] = $submit;
         }

        return $this;
    }


}




