<?php

namespace Xantico\Bootstrap\Basic;

use Xantico\Bootstrap\HtmlTag;
use Xantico\Bootstrap\CaptionInterface;
use Xantico\Bootstrap\Xantico;

class Form extends Typography
{
    const JQUERY_FORM_VALIDATION_URL = 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'; // string

    public static $REQUIRED_HELP_PREFIX = ""; // string

    private static $formTypeArr = array("inline", "form-inline", "form-horizontal", "horizontal", "navbar", "navbar-form", "fieldset", ""); // string

    protected $name; // string
    protected $action; // string
    protected $method; // string
    protected $enctype; // array ();
    protected $role; // array
    protected $formType; // boolean
    protected $labelRatio; // Icon
    protected $formAction;
    protected $isDisabled;
    protected $requireIcon;

    /**
     * @param string $formType
     * @param array $vars
     * @param array $attrs
     */
    public function __construct($formType = "", $vars = array(), $attrs = array())
    {
        parent::__construct("form", $vars, $attrs);
        // form-horizontal, form-inline, navbar-form, navbar-search
        $this->formType = isset($formType) ? $formType : null; // form type allowed to be empty.
        $this->method = isset($vars['method']) ? $vars['method'] : null; // get
        $this->name = isset($vars['name']) ? $vars['name'] : null;
        $this->id = isset($vars['id']) ? $vars['id'] : null;
        $this->role = isset($vars['role']) ? $vars['role'] : "form";
        $this->action = isset($vars['action']) ? $vars['action'] : null;
        $this->labelRatio = isset($vars['labelRatio']) ? $vars ['labelRatio'] : null; // 字寬３欄寬９
        $this->formAction = isset ($vars['formAction']) ? $vars['formAction'] : array();
        $this->isDisabled = isset ($vars ['isDisabled']) ? $vars ['isDisabled'] : false;
        $this->requireIcon = isset ($vars ['requireIcon']) && $vars ['requireIcon'] instanceof Icon ? $vars ['requireIcon'] : new Icon("asterisk", array("textContext" => "danger"));
    }

    /**
     * @desc decorated input depending on form type.
     * {@inheritDoc}
     */
    public function render($display = false)
    {
        if (Input::$AUTO_NAMING == true AND empty($this->name)) { // auto naming.
            if (empty($this->id)) $this->setId();
            $this->name = $this->id;
        }

        if (!empty($this->formType)) $this->customClass [] = $this->formType;
        if (!empty($this->action)) $this->attrs ["action"] = $this->action;
        if (!empty($this->method)) $this->attrs ["method"] = $this->method;
        if (!empty($this->name)) $this->attrs ["name"] = $this->name;
        if (!empty($this->enctype)) $this->attrs ["enctype"] = $this->enctype;


        if (!empty($this->innerElements)) {
            $newElements = array();
            foreach ($this->innerElements as $ele) {
                if (empty($ele)) continue; // pass
                if ($ele instanceof Input || $ele instanceof InputGroup || $ele instanceof Button) {
                    $formGroup = new Typography("div:form-group");
                    if (method_exists($ele, "getValidationState") && !empty($ele->getValidationState())) {
                        $formGroup->appendCustomClass("has-" . $ele->getValidationState());
                        if (method_exists($ele, "getHasFeedback") && $ele->getHasFeedback() == true) {
                            $formGroup->appendCustomClass("has-feedback");
                        }
                    }
                    switch ($this->formType) {
                        case "horizontal":
                        case "form-horizontal":
                            $formGroup->appendCustomClass("row");
                            if (empty($this->labelRatio)) {
                                $_labelRatio = !empty($ele->getLabelRatio()) ? $ele->getLabelRatio() : array(3, 9);
                            } else {
                                $_labelRatio = $this->labelRatio;
                            }
                            if (method_exists($ele, "getCaption") && !empty($ele->getCaption())) {
                                $_label = new HtmlTag("label");
                                if ($this->formType == "form-inline") {
                                    $_label->setCustomClass("sr-only");
                                }
                                if (method_exists($ele, "getValidationState") && !empty($ele->getValidationState())) {
                                    $_label->appendCustomClass("control-label");
                                }
                                $_label->appendCustomClass("col-sm-" . $_labelRatio [0]);
                                if ($ele instanceof InputGroup && empty($ele->getId())) { // search input when input group id is empty.
                                    $_for = $ele->getId();
                                } else {
                                    if (empty($ele->getId())) {
                                        $ele->setId();
                                    }
                                    $_for = $ele->getId();
                                }

                                $_label->appendAttrs(array("for" => $_for));

                                if (method_exists($ele, "getIsRequired") && $ele->getIsRequired() && !empty($this->requireIcon)) {
                                    $_label->appendInnerElements(array($this->requireIcon, $ele->getCaption()));
                                } else {
                                    $_label->setInnerText($ele->getCaption());
                                }

                                $formGroup->appendInnerElements($_label);
                            } else {
                                $_labelRatio [1] = $_labelRatio [0] + $_labelRatio [1];
                            }

                            if (method_exists($ele, "getHelp") && !empty($ele->getHelp())) {
                                if (is_string($ele->getHelp())) {
                                    $_help = new Typography("small");
                                    $_help->appendCustomClass(array("help-block"))
                                        ->setText($ele->getHelp());
                                    $_help->setId();
                                    $ele->appendAttrs(array("aria-describedby" => $_help->getId()));
                                } else {
                                    $_help = $ele->getHelp();
                                }
                            }

                            // input body shorter than column.
                            if (!isset($_labelRatio [2]) && $_labelRatio [0] + $_labelRatio [1] < 12) {
                                $_labelRatio [2] = $_labelRatio [1];
                                $_labelRatio [1] = 12 - $_labelRatio [0];

                                $divPartial1 = new Typography("div:col-sm-" . $_labelRatio [1]);
                                $divPartial2 = new Typography("div:row");
                                $divPartial3 = new Typography("div:col-sm-" . $_labelRatio [2]);
                                $divPartial3->appendInnerElements($ele);
                                // feedback icon
                                if (method_exists($ele, "getHasFeedback") && $ele->getHasFeedback() == true) {
                                    $_icon = $ele->getValidationState() == "success" ? "ok" : ($ele->getValidationState() == "warning" ? "warning-sign" : "remove");
                                    $feedbackIcon = new Icon($_icon);
                                    $feedbackIcon->appendCustomClass("form-control-feedback");
                                    $divPartial3->appendInnerElements($feedbackIcon);
                                }

                                $divPartial2->appendInnerElements($divPartial3);
                                if (isset($_help)) {
                                    $divPartial4 = new Typography("div:col-sm-" . ($_labelRatio [1] - $_labelRatio [2]));
                                    $divPartial4->appendInnerElements($_help);
                                    $divPartial2->appendInnerElements($divPartial4);
                                }
                                $divPartial1->appendInnerElements($divPartial2);
                                $formGroup->appendInnerElements($divPartial1);
                            } else {
                                $eleDiv = new Typography("div:col-sm-" . $_labelRatio [1]);
                                $eleDiv->appendInnerElements(array($ele));
                                // feedback icon
                                if (method_exists($ele, "getHasFeedback") && $ele->getHasFeedback() == true) {
                                    $_icon = $ele->getValidationState() == "success" ? "ok" : ($ele->getValidationState() == "warning" ? "warning-sign" : "remove");
                                    $feedbackIcon = new Icon($_icon);
                                    $feedbackIcon->appendCustomClass("form-control-feedback");
                                    $eleDiv->appendInnerElements($feedbackIcon);
                                }
                                if (isset($_help)) $eleDiv->appendInnerElements($_help);
                                $formGroup->appendInnerElements(array($eleDiv));
                            }

                            break;
                        default: // form type == ""
                        case "navbar":
                        case "navbar-form":
                            // @todo anything special for a navbar-form
                        case "inline":
                        case "form-inline": // enclose by form-group
                            if (method_exists($ele, "getCaption") && !empty($ele->getCaption())) {
                                $_label = new Typography("label");
                                if ($this->formType == "form-inline") {
                                    $_label->appendCustomClass("sr-only");
                                }
                                if (method_exists($ele, "getValidationState") && !empty($ele->getValidationState())) {
                                    $_label->appendCustomClass("control-label");
                                }
                                if ($ele instanceof InputGroup && empty($ele->getId())) { // search input when input group id is empty.
                                    $_for = $ele->getId();
                                } else {
                                    if (empty($ele->getId())) {
                                        $ele->setId();
                                    }
                                    $_for = $ele->getId();
                                }
                                $_label->appendAttrs(array("for" => $_for));
                                if (method_exists($ele, "getIsRequired") && $ele->getIsRequired()) {
                                    $_requireIcon = new Icon("asterisk", array("context" => "danger"));
                                    $_label->appendInnerElements($_requireIcon);
                                }
                                $_label->setText($ele->getCaption());

                                $formGroup->appendInnerElements($_label);
                            }

                            $formGroup->appendInnerElements($ele);
                            if (method_exists($ele, "getHasFeedback") && $ele->getHasFeedback() == true) {
                                $_icon = $ele->getValidationState() == "success" ? "ok" : ($ele->getValidationState() == "warning" ? "warning-sign" : "remove");
                                $feedbackIcon = new Icon($_icon);
                                $feedbackIcon->appendCustomClass("form-control-feedback");
                                $formGroup->appendInnerElements($feedbackIcon);
                            }

                            if (method_exists($ele, "getHelp") && !empty($ele->getHelp())) {
                                if (is_string($ele->getHelp())) {
                                    $_help = new Typography("small");
                                    $_help->appendCustomClass(array("help-block"))
                                        ->setText($ele->getHelp());
                                    $_help->setId();
                                    $ele->appendAttrs(array("aria-describedby" => $_help->getId()));
                                } else {
                                    $_help = $ele->getHelp();
                                }
                                $formGroup->appendInnerElements($_help);
                            }
                            break;
                    }

                    $newElements [] = $formGroup;
                } else { // regular elements.
                    // form row
                    if ($ele instanceof Row) {
                        $ele->setForForm($this->formType);
                        $ele->setRequireIcon($this->requireIcon);
                    }

                    $newElements [] = $ele;
                }

            } // end of foreach innerElements
            $this->innerElements = $newElements;
        } // end if !empty inner elements.

        if ($this->formAction) {
            switch ($this->formType) {
                default:
                    $this->appendInnerElements($this->formAction);
                    break;
            }
        }

        // By default, browsers will treat all native form controls (<input>, <select> and <button> elements) inside a <fieldset disabled> as disabled
        if ($this->isDisabled == true) {
            $disabledField = new HtmlTag("fieldset", array("disabled" => "disabled"));
            $disabledField->appendInnerElements($this->innerElements);
            $this->innerElements = array($disabledField);
        }

        parent::render();

        if (Input::$FORM_VALIDATION_METHOD == "jquery") {
            // search at this time when all inputs been put inside of innerElements
            $inputs = $this->search("input");
            $selects = $this->search("select");
            $textareas = $this->search("textarea");
            $inputs = array_merge($inputs, $selects, $textareas);
            if (!empty($inputs)) {
                $_validation = array();
                foreach ($inputs as $inpt) {
                    if (method_exists($inpt, "getIsRequired")
                        && method_exists($inpt, "getValidation")
                        && $inpt->getIsRequired() == true) {
                        if (method_exists($inpt, "getName") && !empty($inpt->getName())) {
                            $_validation [$inpt->getName()] = $inpt->getValidation();
                        } else {
                            self::setErrMsg("[Notice] Required input needs a name. Passed. (Note: You could choice to enable auto-naming in class Input.)");
                        }
                    }
                }
                // add examine script to $jQuery.
                $this->generateValidationRulesScript($_validation);
                if (!in_array(Form::JQUERY_FORM_VALIDATION_URL, Xantico::$defaultScriptsFiles)) {
                    Xantico::$defaultScriptsFiles [] = self::JQUERY_FORM_VALIDATION_URL;
                }
            }
        }

        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }

    /**
     * @desc build form validation script (json). Have to note it uses input's name to recognize, not id.
     * @param array $validation
     * @return string
     */
    private function generateValidationRulesScript($validation)
    {
        if (!empty($validation)) {
            $validationRules = array();
            foreach ($validation as $name => $value) {
                $validationRules ['rules'][$name]['required'] = true;
                $validationRules ['messages'][$name]['required'] = self::$REQUIRED_HELP_PREFIX . isset($value ['requiredMessage']) ? $value ['requiredMessage'] : "";
                if (isset($value ['maxlength'])) {
                    $validationRules ['rules'][$name]['maxlength'] = $value ['maxlength'];
                    $validationRules ['messages'][$name]['maxlength'] = self::$REQUIRED_HELP_PREFIX . $value ['maxlengthMessage'];
                }
                if (isset($value ['minlength'])) {
                    $validationRules ['rules'][$name]['minlength'] = $value ['minlength'];
                    $validationRules ['messages'][$name]['minlength'] = self::$REQUIRED_HELP_PREFIX . $value ['minlengthMessage'];
                }
                if (isset($value ['equalTo'])) {
                    $validationRules ['rules'][$name]['equalTo'] = $value ['equalTo'];
                    $validationRules ['messages'][$name]['equalTo'] = self::$REQUIRED_HELP_PREFIX . $value ['equalToMessage'];
                }
                if (isset($value ['email'])) {
                    $validationRules ['rules'][$name]['email'] = true;
                    $validationRules ['messages'][$name]['email'] = "．" . $value ['emailMessage'];
                }
            }

            if (!empty($this->id)) {
                $this->jQuery .= "\$(\"#{$this->id}\").validate(" . json_encode($validationRules) . ");";
            } else if (!empty($this->name)) {
                $this->jQuery .= "\$(\"form[name={$this->name}]\").validate(" . json_encode($validationRules) . ");";
            } else { // too late to set name automatic.
                self::setErrMsg("[Warninng] You need a name for your fom to validate (setName() it).");
            }

        }
    }

    /**
     * @desc set form method [get|post]
     * @param string $method
     * @return Form
     */
    public function setMethod($method = "get")
    {
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
     * @param string|null $name
     * @return Form
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormType()
    {
        return $this->formType;
    }

    /**
     * Form type: [inline|horizontal|navbar|fieldset]
     * @param string $formType
     * @return Form
     */
    public function setFormType($formType = "")
    {
        if (!in_array($formType, self::$formTypeArr)) {
            self::setErrMsg("[Notice] Wrong from type going to be set.");
            return $this;
        }
        $this->formType = $formType;
        if ($this->formType == "inline") {
            $this->formType = "form-inline";
        } else if ($this->formType == "horizontal") {
            $this->formType = "form-horizontal";
        } else if ($this->formType == "navbar") {
            $this->formType = "navbar-form";
        }

        return $this;
    }

    public function setFormTypeInline()
    {
        $this->formType = "form-inline";
        return $this;
    }

    public function setFormTypeHorizontal()
    {
        $this->formType = "form-horizontal";
        return $this;
    }

    public function setFormTypeNavbar()
    {
        $this->formType = "navbar-form";
        return $this;
    }

    public function setFormTypeFieldset()
    {
        $this->formType = "fieldset";
        return $this;
    }

    /**
     * @desc form action, an url.
     * @param string $action
     * @return Form
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return string
     */
    public function getEnctype()
    {
        return $this->enctype;
    }

    /**
     * [text/plain|application/x-www-form-urlencoded]
     * @param string $enctype
     * @return Form
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
     * @desc actions, like submit, reset, are all about buttons in bottom of a form.
     * @param \model\Xantico\basic\Typography $formAction
     */
    public function setFormAction($formAction = null)
    {
        if (!empty($formAction)) {
            if (!is_array($formAction)) $formAction = array($formAction);
            foreach ($formAction as $action) {
                // if ($action instanceof Typography) {
                $this->formAction [] = $action;
            }
        } else { // if you don't assign a button class, we create a default one for the form.
            // set a defalut submit button
            $submit = new Button();
            $submit->setIsSubmit()
                ->setContext("primary")
                ->setText(CaptionInterface::CAP_SUBMIT);

            $this->formAction [] = $submit;
        }

        return $this;
    }

    /**
     * @desc getter of the ratio of labels and inputs.
     * @param Ambigous <unknown, multitype:number > $labelRatio
     */
    public function getLabelRatio()
    {
        return $this->labelRatio;
    }

    /**
     * @desc For form-horizontal, the ratio of labels and inputs.
     * @param Ambigous <unknown, multitype:number > $labelRatio
     */
    public function setLabelRatio($labelRatio)
    {
        if (is_array($labelRatio)) {
            $this->labelRatio = $labelRatio;
        } else {
            $this->labelRatio = explode(":", $labelRatio);
        }

        return $this;
    }

    /**
     * @return the $isDisabled
     */
    public function getIsDisabled()
    {
        return $this->isDisabled;
    }

    /**
     * @param field_type $isDisabled
     */
    public function setIsDisabled($isDisabled = true)
    {
        $this->isDisabled = (boolean)$isDisabled;
        return $this;
    }

    /**
     * @return the $requireIcon
     */
    public function getRequireIcon()
    {
        return $this->requireIcon;
    }

    /**
     * @param \model\Xantico\basic\Icon $requireIcon
     */
    public function setRequireIcon($requireIcon)
    {
        if ($requireIcon instanceof Icon) {
            $this->requireIcon = $requireIcon;
        } else {
            $this->requireIcon = null;
        }

        return $this;
    }


}
