<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;
use model\bootstrap\iCaption;

class Form extends Typography
{
    protected $name; // string
    protected $action; // string
    protected $method; // string
    protected $enctype; // string
    protected $role; // string
    protected $formType; // string
    protected $labelRatio; // array ();
    protected $formAction; // array

    private static $formTypeArr = array ("inline", "form-inline", "form-horizontal", "horizontal", "navbar", "navbar-form", "fieldset", "");
    /**
     * @desc 建構子
     * @param string $formType
     * @param array $attrs
     * @return \model\bootstrap\basic\Form
     */
    public function __construct($formType = "", $vars = array (), $attrs = array ())
    {
        parent::__construct("form", $vars, $attrs);
        // form-horizontal, form-inline, navbar-form, navbar-search
        $this->formType         = isset($formType) ? $formType : null; // formtype alowed to be empty.
        $this->method           = isset($vars['method']) ? $vars['method'] : null; // get
        $this->name             = isset($vars['name']) ? $vars['name'] : null;
        $this->id               = isset($vars['id']) ? $vars['id'] : null;
        $this->role             = isset($vars['role']) ? $vars['role'] : "form";
        $this->action           = isset($vars['action']) ? $vars['action'] : null;
        $this->labelRatio       = isset($vars['labelRatio']) ? $vars ['labelRatio'] : null; // 字寬３欄寬９
        $this->formAction       = array ();
    }
    
    public function render($display = false) {
        
        if ($this->formType == "inline") {
            $this->formType = "form-inline";
        } else if ($this->formType == "horizontal") {
            $this->formType = "form-horizontal";
        } else if ($this->formType == "navbar") {
            $this->formType = "navbar-form";
        }
        if (!empty($this->formType)) $_class [] = $this->formType;
        $_attrs = array ();
        if ($this->action)  $_attrs ["action"] = $this->action;
        if ($this->method)  $_attrs ["method"] = $this->method;
        if ($this->name)    $_attrs ["name"] = $this->name;
        if ($this->id)      $_attrs ["id"] = $this->id;
        if ($this->enctype) $_attrs ["enctype"] = $this->enctype;
        $this->setCustomClass($_class);
        $this->setAttrs($_attrs);
        
        if (!empty($this->innerElements)) {
            foreach ($this->innerElements as $ele) {
                if (empty($ele)) continue; // pass 空物件.
                if ($ele instanceof Input) {
                    $formGroup = new Typography("div:form-group");
                    switch ($this->formType) {
                        case "form-horizontal":
                            if (empty($this->labelRatio)) $this->labelRatio = !empty($ele->getLabelRatio()) ? $ele->getLabelRatio() : array (3, 9);
                            if (!empty($ele->getCaption())) {
                                $_label = new Typography("div:label");
                                $_label->setCustomClass(array("col-sm-" . $this->labelRatio [0], "control-label", "no-padding-right"));
                                $_label->setAttrs(array ("for" => $ele->getId()));
                                if ($ele->getIsRequired()) {
                                    $_requireIcon = new Icon("asterisk", array ("colorSet" => "danger"));
                                    $_label->setInnerElements($_requireIcon);
                                }
                                $_label->setInnerText($ele->getCaption());
                                
                                $formGroup->setInnerElements($_label);
                            } else {
                                $this->labelRatio [1] = $this->labelRatio [0] + $this->labelRatio [1];
                            }
                            
                            // input 比格子短小的情況
                            if (!isset($this->labelRatio [2]) && $this->labelRatio [0] + $this->labelRatio [1] != 12) {
                                $this->labelRatio [2] = $this->labelRatio [1];
                                $this->labelRatio [1] = 12 - $this->labelRatio [0];
                                
                                $divPartial1 = new Typography("div:col-sm-" . $this->labelRatio [1]);
                                $divPartial2 = new Typography("div:row");
                                $divPartial3 = new Typography("div:col-sm-" . $this->labelRatio [2]);
                                $divPartial3->setInnerElements($ele);
                                $divPartial2->setInnerElements($divPartial3);
                                $formGroup->setInnerElements(array ($divPartial1, $divPartial2));
                            } else {
                                $divPartial3 = new Typography("div:col-sm-" . $this->labelRatio [1]);
                                $divPartial3->setInnerElements($ele);
                                $formGroup->setInnerElements($divPartial3);
                            }
                            if (!empty($ele->getHelp())) {
                                $_help = new HtmlTag("small");
                                $_help->setCustomClass(array ("form-text", "text-muted"))
                                ->setText($ele->getHelp());
                                $divPartial3->setInnerElements($_help);
                            }
                            
                            break;
                        default: // form type == ""
                        case "navbar-form":
                            // @todo anything special for a navbar-form
                        case "form-inline": // enclose by form-group
                            if (!empty($ele->getCaption())) {
                                $_label = new Typography("label");
                                $_label->setAttrs(array ("for" => $ele->getId()));
                                if ($ele->getIsRequired()) {
                                    $_requireIcon = new Icon("asterisk", array ("colorSet" => "danger"));
                                    $_label->setInnerElements($_requireIcon);
                                }
                                $_label->setInnerText($ele->getCaption());
                                
                                $formGroup->setInnerElements($_label);
                            }
                            $formGroup->setInnerElements($ele);
                            if (!empty($ele->getHelp())) {
                                $_help = new HtmlTag("small");
                                $_help->setCustomClass(array ("form-text", "text-muted"))
                                ->setText($ele->getHelp());
                                $formGroup->setInnerElements($_help);
                            }
                            
                            break;
                    }
                    
                    $newElements [] = $formGroup;
                } else { // regular elements.
                    $newElements [] = $ele; 
                }
            }
        }
        
        $this->innerElements = $newElements;
        
        if ($this->formAction) {
            switch ($this->formType) {
                default:
                    $this->setInnerElements($this->formAction);
                    break;
            }
        }
        
        parent::render();
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }

    /**
     * @desc set form method [get|post]
     * @param string $method
     * @return \model\bootstrap\basic\Form
     */
    public function setMethod ($method = "get") {
        $this->method = $method;
        return $this;
    }
    
    /**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @param Ambigous <NULL, string> $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
     * @return the $formType
     */
    public function getFormType()
    {
        return $this->formType;
    }
    
    /**
     * @param string $formType [inline|horizontal|navbar|fieldset]
     */
    public function setFormType($formType = "")
    {
        $this->formType = $formType;
        return $this;
    }
    
    public function setAction ($action) {
        $this->action = $action;
        return $this;
    }
    /**
     * @return the $enctype
     */
    public function getEnctype()
    {
        return $this->enctype;
    }
    
    /**
     * @desc [text/plain|application/x-www-form-urlencoded]
     * @param field_type $enctype
     */
    public function setEnctype($enctype)
    {
        $this->enctype = $enctype;
        return $this;
    }

    /**
     * @return the $formAction
     */
    public function getFormAction()
    {
        return $this->formAction;
    }

    /**
     * @desc 加入 form 的動作按鈕，
     * @param \model\bootstrap\basic\Typography $formAction
     */
    public function setFormAction($formAction = null)
    {
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $formAction = func_get_args();
        }
        
        if (!empty($formAction)) {
            if (!is_array($formAction)) $formAction = array ($formAction);
            foreach ($formAction as $action) {
                // if ($action instanceof Typography) {
                $this->formAction [] = $action;
            }
        } else {
            // set a defalut submit button
            $submit = new Button();
            $submit->setIsSubmit()
            ->setColorSet("primary")
            ->setText(iCaption::CAP_SUBMIT);
            
            $this->formAction [] = $submit;
        }
        
        return $this;
    }

    
}
