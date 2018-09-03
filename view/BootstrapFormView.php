<?php
namespace view;

// 自己注意大小寫
use model\bootstrap\basic\Typography;
use model\bootstrap\Xantico;
use model\bootstrap\basic\Jumbotron;
use model\bootstrap\basic\Table;
use model\bootstrap\basic\Image;
use model\bootstrap\basic\Badge;
use model\bootstrap\basic\Label;
use model\bootstrap\basic\Nav;
use model\bootstrap\basic\Dropdown;
use model\bootstrap\basic\Navbar;
use model\bootstrap\basic\Alert;
use model\bootstrap\basic\ProgressBar;
use model\bootstrap\basic\PgBar;
use model\bootstrap\basic\ListGroup;
use model\bootstrap\basic\Listle;
use model\bootstrap\basic\Panel;
use model\bootstrap\basic\Carousel;
use model\bootstrap\basic\Slidle;
use model\bootstrap\basic\Navlet;
use model\bootstrap\basic\Droplet;
use model\bootstrap\basic\Form;
use model\bootstrap\basic\Input;
use model\bootstrap\basic\Select;
use model\bootstrap\basic\Textarea;
use model\bootstrap\basic\PageHeader;
use model\bootstrap\basic\FormRow;
use model\bootstrap\basic\FGrid;
use model\bootstrap\basic\Button;

/**
 * 
 * @author metatronangelo
 * @desc form demo page view models.
 */
class BootstrapFormView 
{
    // set management.
    public function fetchView () {
        $btPanel = new Xantico();
        $btPanel->setIsLoadBootstrapFromCDN()->setIsLoadJQueryFromCDN();
        $btPanel->setCustomCSSFiles("https://v3.bootcss.com/dist/css/bootstrap-theme.min.css");
        $btPanel->setCustomScriptsFiles('https://v3.bootcss.com/assets/js/docs.min.js');
        $btPanel->setCSSContents("
        body {
          padding-top: 70px;
          padding-bottom: 30px;
        }
        
        .theme-dropdown .dropdown-menu {
          position: static;
          display: block;
          margin-bottom: 20px;
        }
        
        .theme-showcase > p > .btn {
          margin: 5px 0;
        }
        
        .theme-showcase .navbar .container {
          width: auto;
        }");
        $ddItems = array (
            array ("text" => "Action", "url" => "#"),
            new Droplet("Another action", "#"),
            new Droplet("Something else here", "#"),
            array ("seperator" => true),
            array ("text" => "Nav header", "url" => "#", "head" => true),
            array ("text" => "Separated link", "url" => "#"),
            array ("text" => "One more separated link", "url" => "#") 
        );

        $innerDropdown = new Dropdown();
        $innerDropdown
        ->setText(array ("Dropdown", new Typography("span:caret", array ("text" => "\t"))))
        ->setItems($ddItems);
        
        $nvbItems = array (
            array ("text" => "Home", "url" => "#"),
            new Navlet("About", "#"), // 要有 url 才有 anchor tag, 不然長像不對
            new Navlet("Contact", "#"),
            new Navlet ($innerDropdown)
        );
        
        $navbar = new Navbar();
        $navbar->setHeader("Bootstrap theme")
            ->setIsTop(true)
            ->setActiveIndex(0)
            ->setCollapseButton()
            ->setStyle("inverse")
            ->setItems($nvbItems);
        
        $pageHeader = new PageHeader("Form controls");
        // @todo Form here.
        $form1 = new Form();
        $inputEmail =  new Input("email");
        $inputEmail->setCaption("Email Address")
        ->setHelp("We'll never share your email with anyone else.")
        ->setPlaceholder("Enter Email")
        ->setId("exampleInputEmail1");
        $inputPwd = new Input("password");
        $inputPwd->setCaption("Password")
        ->setPlaceholder("password")
        ->setId("exampleInputPassword1");
        $check = new Input("checkbox");
        $check->setOptions(array ("Check me out"));
        $form1->setFormAction()
        ->setInnerElements(array ($inputEmail, $inputPwd, $check));
        
        // form-control for select, textarea
        $form2 = new Form();
        $inputEmail2 = new Input("email");
        $inputEmail2->setPlaceholder("name@example.com")
        ->setId("exampleFormControlInput1")
        ->setCaption("Email address");
        
        $inputSelect = new Select();
        $inputSelect->setCaption("Example select")
        ->setId("exampleFormControlSelect1")
        ->setOptions(array (1, 2, 3, 4, 5));
        
        $inputSelect2 = clone $inputSelect;
        $inputSelect2->setIsMultiple(true)
        ->setCaption("Example multiple select")
        ->setId("exampleFormControlSelect2");
        
        $textarea = new Textarea();
        $textarea->setRows(3)
        ->setCaption("Example textarea")
        ->setId("exampleFormControlTextarea1");
        
        $form2->setInnerElements(array ($inputEmail2, $inputSelect, $inputSelect2, $textarea));
        
        // file input
        $form3 = new Form();
        $inputFile = new Input("file");
        $inputFile->setId("exampleFormControlFile1")
        ->setCaption("Example file input");
        $form3->setInnerElements($inputFile);
        
        // sizing @todo bs 4.0
        $form4 = new Form();
        /*
        $inputLg = new Input();
        $inputLg->setSize(5)
        ->setPlaceholder(".form-control-lg");
        $inputMd = clone $inputLg;
        $inputMd->setSize(4)
        ->setPlaceholder("Default input");
        $inputSm = clone $inputMd;
        $inputSm->setSize(3)
        ->setPlaceholder(".form-control-sm");
        */
        $inputRO = new Input();
        $inputRO->setIsReadonly(true)
        ->setPlaceholder("Readonly input here…");
        
        $form4->setInnerElements(array ($inputRO));
        
        // plaintext
        $form5 = new Form();
        $form5->setFormType("horizontal")
        ->setLabelRatio("2:10");
        $inputPlain = new Input();
        $inputPlain->setIsStatic()
        ->setDefaultValue("email@example.com")
        ->setCaption("Email")
        ->setId("staticEmail");
        $inputPwd2 = clone $inputPwd;
        $inputPwd2->setId("inputPassword");
        
        $form5->setInnerElements(array ($inputPlain, $inputPwd2));
        
        // form inline
        $form6 = clone $form5;
        $form6->setFormType("inline")
        ->setFormAction();
        $form6Elements = $form6->getInnerElements();
        $form6Elements [0] -> setIsReadonly(true)->setIsStatic(false);
        
        // checkboxes and radios
        $pageHeader2 = new PageHeader("Checkboxes and radios");
        // checkbox
        $form7 = new Form();
        $checkbox1 = new Input("checkbox");
        $checkbox1->setOptions(array ("Default checkbox", "Disabled checkbox"))
        ->setDisabledOption(array (1));
        $form7->setInnerElements($checkbox1);
        
        // radio
        $form8 = new Form();
        $radio1 = new Input("radio");
        $radio1->setOptions(array ("Default radio", "Second default radio", "Disabled radio"))
        ->setDisabledOption(array (2))
        ->setName("exampleRadios");
        $form8->setInnerElements($radio1);
        
        // inline checkbox @todo bs 4.0
        $form9 = new Form();
        $checkbox2 = new Input("checkbox");
        $checkbox2->setOptions(array ("option1" => "1", "option2" => "2", "option3" => "3 (disabled)"))
        ->setDisabledOption(array ("option3"))
        ->setIsStacked(false);
        $form9->setInnerElements($checkbox2);
        
        // without labels
        $form10 = new Form();
        $checkboxNoLbl = new Input("checkbox");
        $checkboxNoLbl->setOptions(array ("option1" => ""))
        ->setCustomClass("position-static");
        $radioNoLbl = new Input ("radio");
        $radioNoLbl->setOptions(array ("option1" => ""))
        ->setName("blankRadio")
        ->setCustomClass("position-static"); // @todo bs 4.0... I don't catch this.
        $form10->setInnerElements(array ($checkboxNoLbl, $radioNoLbl));
        
        // layout
        $pageHeader3 = new PageHeader("Layout");
        
        $form11 = new Form();
        $input1 = new Input();
        $input1->setCaption("Example label")
        ->setPlaceholder("Example input")
        ->setId();
        $input2 = new Input();
        $input2->setCaption("Another label")
        ->setPlaceholder("Another input")
        ->setId();
        $form11->setInnerElements(array ($input1, $input2));
        
        // form grid
        $form12 = new Form();
        $inputFirstName = new Input();
        $inputFirstName->setPlaceholder("First name");
        $inputLastName = new Input();
        $inputLastName->setPlaceholder("Last name");
        $formRow = new FormRow();
        $formRow->setItems(array ($inputFirstName, $inputLastName));
        $form12->setInnerElements($formRow);
        
        // a complex example
        $form13 = new Form();
        $inputEmail3 = new Input("email", array ("caption" => "Email"), array ("id" => "inputEmail4", "placeholder" => "Email"));
        $inputPwd3 = new Input("password", array ("caption" => "Password"), array ("id" => "inputPassword4", "placeholder" => "Password", ));
        $formRow2 = new FormRow();
        $formRow2->setItems(array ($inputEmail3, $inputPwd3));
        $inputAddress = new Input();
        $inputAddress->setCaption("Address")
        ->setPlaceholder("1234 Main St")
        ->setId("inputAddress");
        $inputAddress2 = new Input();
        $inputAddress2->setPlaceholder("Apartment, studio, or floor")
        ->setId("inputAddress2")
        ->setCaption("Address 2");
        $inputCity = new Input ();
        $inputCity->setCaption("City")
        ->setId("inputCity");
        $selectState = new Select();
        $selectState->setOptions(array ("Choose...", "..."))
        ->setDefaultOption(array(0))
        ->setId("inputState")
        ->setCaption("State");
        $inputZip = new Input();
        $inputZip->setCaption("Zip")
        ->setId("inputZip");
        $formRow3 = new FormRow();
        $formRow3->setItems(array (
            array ("input" => $inputCity, "width" => 6),
            array ("input" => $selectState, "width" => 4),
            new FGrid($inputZip, 2)
        ));
        $check2 = new Input("checkbox");
        $check2->setOptions(array ("Check me out"))
        ->setId("gridCheck");
        $form13->setInnerElements($formRow2, $inputAddress, $inputAddress2, $formRow3, $check2);
        $btnSignin = new Button();
        $btnSignin->setIsSubmit()
        ->setColorSet("primary")
        ->setText("Sign in");
        $form13->setFormAction($btnSignin);
        
        
        
        // container
        $container = new Typography("div:container", null, array("role"=> "main"));
        $container->setInnerElements(array (
            $pageHeader, 
            $form1, 
            $form2, 
            $form3,
            $form4,
            $form5,
            $form6,
            $pageHeader2, 
            $form7,
            $form8,
            $form9,
            $form10,
            $pageHeader3,
            $form11,
            $form12,
            $form13
        ))
        ->setCaption("Example textarea")
        ->setCustomClass("theme-showcase");
        
        // bootstrap palette
        $btPanel->setBodyContents(array($navbar, $container));
        
        // echo "Memory usage(real): " . memory_get_usage(true);
//         echo Typography::getErrMsg();
        $btPanel->render(true);
    }
}

