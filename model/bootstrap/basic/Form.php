<?php
namespace model\bootstrap\basic;


use model\bootstrap\basic\Typography;

class Form extends Typography
{
    protected $name; // string
    protected $action; // string
    protected $method; // string
    protected $enctype; // string
    protected $role; // string
    protected $formType; // string
    protected $formAction; // array
    
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
        $this->formType         = isset($formType) ? $formType : null;
        $this->method           = isset($vars['method']) ? $vars['method'] : null; // get
        $this->name             = isset($vars['name']) ? $vars['name'] : null;
        $this->id               = isset($vars['id']) ? $vars['id'] : null;
        $this->role             = isset($vars['role']) ? $vars['role'] : "form";
        $this->action           = isset($vars['action']) ? $vars['action'] : null;
        $this->formAction       = array ();
        
        return $this;
    }
    
    public function render($display = false) {
        
        $_class [] = $this->formType;
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
                if ($ele instanceof Typography || true) {
                    if (method_exists($ele, "setFormType")) $ele->setFormType($this->formType);
                }
            }
        }
        
        if ($this->formAction) {
            switch ($this->formType) {
                default:
                    $this->setInnerElements($this->formAction);
                    break;
            }
        }
        
        parent::render();
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    /**
     * @desc Form 轉字串
     * @return string
     */
    function __toString() {
        if ($this->html) {
            return $this->html;
        } else {
            try {
                return $this->render();
            } catch (\Exception $e) {
                return "";
            }
        }
        
    }
    
    public function setMethod ($method = "get") {
        $this->method = $method;
        return $this;
    }
    
    /**
     * variable jQuery getter.
     * @return string
     */
    public function getJQuery () {
        return $this->jQuery;
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
     * @param string $formType
     * inline, horizontal, fieldset 內聯表單／水平表單／？
     */
    public function setFormType($formType)
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
                if ($action instanceof \model\bootstrap\basic\Typography || true) {
                    // @todo 所有的元素還不是繼承 typography
                    $this->formAction [] = $action;
                } else {
                    throw new \Exception("Unsupported Form Action Elements.");
                }
            }
        }
        
        return $this;
    }

    
}
