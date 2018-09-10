<?php
namespace view;

use model\bootstrap\Xantico;
use model\bootstrap\basic\Button; // 自己注意大小寫
use model\bootstrap\basic\Typography;
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
use model\bootstrap\basic\Well;
use model\bootstrap\basic\Form;
use model\bootstrap\basic\PageHeader;
use model\bootstrap\basic\Row;
use model\bootstrap\basic\Grid; 
use model\bootstrap\basic\Input;
use model\bootstrap\basic\InputGroup;
use model\bootstrap\basic\Select;
use model\bootstrap\basic\Textarea;
use model\bootstrap\basic\Icon;
use model\bootstrap\basic\ButtonGroup;
use model\bootstrap\basic\ButtonToolbar;


/**
 * 
 * @author metatronangelo
 * @desc demo page view models.
 */
class BootstrapView 
{
    // set management.
    /**
     * @desc theme demo.
     */
    public function themeView () {
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
        
        // Jumbo
        $jumbotron = new Jumbotron();
        $jumbotron->setHeader("Theme example")
            ->setText("This is a template showcasing the optional theme stylesheet included in Bootstrap. Use it as a starting point to create something more unique by building on or modifying it.");
        
        // pager-header
        $ph = new Typography("div:page-header");
        $ph->setInnerElements(new Typography("h1", array ("text" => "Buttons")));
        // 大按鈕
        $lbl = new Button();
        $lbl->setColorSet("default")
        ->setText("Default")
        ->setType("button")
        ->setSize(5);
        $lbl2 = clone $lbl;
        $lbl2->setColorSet("primary")->setText("Primary");
        $lbl3 = clone $lbl;
        $lbl3->setColorSet("success")->setText("Success");
        $lbl4 = clone $lbl;
        $lbl4->setColorSet("info")->setText("Info");
        $lbl5 = clone $lbl;
        $lbl5->setColorSet("warning")->setText("Warning");
        $lbl6 = clone $lbl;
        $lbl6->setColorSet("danger")->setText("Danger");
        $lbl7 = clone $lbl;
        $lbl7->setIsLink()->setText("Link");
        $p1 = new Typography("p");
        $p1->setInnerElements(array($lbl, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6, $lbl7));
        
        $p2 = clone $p1; // 只有 p 被clone, 裡面的 btn 都還是原來的, 好妙!
        foreach ($p2->getInnerElements() as &$el) {
            if ($el instanceof Button) {
                $el->setSize(4);
            }
        }
        
        $p3 = clone $p1;
        foreach ($p3->getInnerElements() as &$el) {
            if ($el instanceof Button) {
                $el->setSize(3);
            }
        }
        
        $p4 = clone $p1;
        foreach ($p4->getInnerElements() as &$el) {
            if ($el instanceof Button) {
                $el->setSize(2);
            }
        }
        
        $ph2 = new Typography("div:page-header");
        $ph2->setInnerElements(new Typography("h1", array ("text" => "Tables")));
        
        $row = new Typography("div:row");
        $column = new Typography("div", array ("grid" => 6));
        
        $tableHeaders = array (
            array("text" => "#"),
            array("text" => "First Name"),
            array("text" => "Last Name"),
            array("text" => "Username")  
        );
        
        $tableCells = array (
            array("1", "Mark", "Otto", "@mdo"),
            array("2", "Jacob", "Thornton", "@fat"),
            array("3", "Larry", "the Bird", "@twitter") 
        );
        
        $table = New Table();
        $table->setHeaders($tableHeaders)->setCells($tableCells);
        $table2 = clone $table;
        $table2->setIsStriped();
        $column2 = clone $column;
        
        $row2 = clone $row;
        $tableCells = array (
            array(array("rowspan" => 2, "text" => 1), array("text" => "Mark"), array("text" => "Otto"), array("text" => "@mdo")),
            array(array("text" => "Mark"), array("text" => "Otto"), array("text" => "@TwBootstrap")),
            array("2", "Jacob", "Thornton", "@fat"), 
            array(array("text" => 3), array("colspan" => 2, "text" => "Larry the Bird"), array("text" => "@twitter")),
        );
        $table3 = clone $table;
        $table3->setIsBordered()->setCells($tableCells);
        $column3 = clone $column;
        $table4 = clone $table;
        $table4->setIsCondensed();
        $column4 = clone $column;
        $row->setInnerElements(array($column->setInnerElements($table), $column2->setInnerElements($table2)));
        $row2->setInnerElements(array($column3->setInnerElements($table3), $column4->setInnerElements($table4)));
        
        $ph3 = new Typography("div:page-header");
        $ph3->setInnerElements(new Typography("h1", array ("text" => "Thumbnails")));
        
        $thumbnail = new Image("thumbnail");
        $thumbnail->setSource("holder.js")
        ->setAlt("A generic square placeholder image with a white border around it, making it resemble a photograph taken with an old instant camera");
                
        
        $ph4 = new Typography("div:page-header");
        $ph4->setInnerElements(new Typography("h1", array ("text" => "Labels")));

        $lbl = new Label("Default");
        $lbl2 = clone $lbl;
        $lbl2->setColorSet("primary")->setText("Primary");
        $lbl3 = clone $lbl;
        $lbl3->setColorSet("success")->setText("Success");
        $lbl4 = clone $lbl;
        $lbl4->setColorSet("info")->setText("Info");
        $lbl5 = clone $lbl;
        $lbl5->setColorSet("warning")->setText("Warning");
        $lbl6 = clone $lbl;
        $lbl6->setColorSet("danger")->setText("Danger");
        
        $p5 = new Typography("h1");
        $p5->setInnerElements(array($lbl, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6));
        
        $p6 = new Typography("h2");
        $p6->setInnerElements(array ($lbl, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6));
        
        $p7 = new Typography("h3");
        $p7->setInnerElements(array ($lbl, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6));
        
        $p8 = new Typography("h4");
        $p8->setInnerElements(array ($lbl, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6));
        
        $p9 = new Typography("h5");
        $p9->setInnerElements(array ($lbl, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6));
        
        $p10 = new Typography("h6");
        $p10->setInnerElements(array ($lbl, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6));
        
        $p11 = new Typography("p");
        $p11->setInnerElements(array ($lbl, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6));
        
        $ph5 = new Typography("div:page-header");
        $ph5->setInnerElements(new Typography("h1", array ("text" => "Badges")));
        $a = new Typography("a");
        $a->setInnerElements(array ("Inbox", new Badge("42")));
        $p12 = new Typography("p");
        $p12->setInnerElements($a);
        $nav = new Nav();
        $navItems = array (
            array ("text" => array ("Home", new Badge(42)), "url" => "#"),
            array ("text" => "Profile", "url" => "#"),
            new Navlet(array("Messages", new Badge(3)), "#")
        );
        $nav->setActiveIndex(0) 
            ->setItems($navItems)
            ->setStyle("pills");
        
        $ph6 = new Typography("div:page-header");
        $ph6->setInnerElements(new Typography("h1", array ("text" => "Dropdown Menus")));
        
        $ddDiv = new Typography("div:dropdown");
        $ddDiv->setCustomClass(array ("theme-dropdown", "clearfix"));
        $dropdown = new Dropdown();
        $ddItems = array (
            array ("text" => "Action", "url" => "#"),
            new Droplet("Another action", "#"), 
            new Droplet("Something else here", "#"),
            array ("seperator" => true), 
            new Droplet("Seperated link", "#") 
        );
        $dropdown->setMode("inline")->getButton()->setCustomClass("sr-only");
        $dropdown->setItems($ddItems)
            ->setText ("Dropdown") 
            ->setMode("dropdown")
            ->setActiveIndex (0);
        $ddDiv->setInnerElements($dropdown);
        
        $ph7 = new Typography("div:page-header");
        $ph7->setInnerElements(new Typography("h1", array ("text" => "Navs")));
        $navItems = array (
            array ("text" => "Home", "url" => "#"),
            array ("text" => "Profile", "url" => "#"),
            new Navlet("Messages", "#")
        );
        $nav3 = new Nav();
        $nav3->setItems($navItems)
            ->setActiveIndex(0) 
            ->setStyle("tabs");
        $nav4 = clone $nav3;
        $nav4->setStyle("pills");
        
        $ph8 = new Typography("div:page-header");
        $ph8->setInnerElements(new Typography("h1", array ("text" => "Navbars")));
        
        array_pop($ddItems);
        $ddItems [] = array ("text" => "Nav header", "url" => "#", "head" => true); 
        $ddItems [] = array ("text" => "Separated link", "url" => "#");
        $ddItems [] = array ("text" => "One more separated link", "url" => "#");
        $innerDropdown = new Dropdown();
        $innerDropdown->setMode("inline")
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
        ->setActiveIndex(0)
        ->setCollapseButton() 
        ->setItems($nvbItems);
        
        $nvbItems [3] = new Navlet ($innerDropdown);
        $navbar2 = clone $navbar;
        $navbar2->setStyle("inverse")
        ->assignItems($nvbItems);
        
        $nvbItems [3] = new Navlet ($innerDropdown);
        $navbar3 = clone $navbar2;
        $navbar3->setIsTop(true) 
        ->assignItems($nvbItems);
        
        $ph9 = new Typography("div:page-header");
        $ph9->setInnerElements(new Typography("h1", array ("text" => "Alerts")));
        
        $alert1 = new Alert();
        $alert1->setInnerElements(array (new Typography("strong", array ("text" => "Well done!")), "You successfully read this important alert message."));
        $alert2 = new Alert();
        $alert2->setInnerElements(array (new Typography("strong", array ("text" => "Heads up!")), "This alert needs your attention, but it's not super important."))
        ->setColorSet("info");
        $alert3 = new Alert();
        $alert3->setInnerElements(array (new Typography("strong", array ("text" => "Warning!")), "Best check yo self, you're not looking too good."))
        ->setColorSet("warning");
        $alert4 = new Alert();
        $alert4->setInnerElements(array (new Typography("strong", array ("text" => "Oh snap!")), "Change a few things up and try submitting again."))
        ->setColorSet("danger");
        
        $phA = new Typography("div:page-header");
        $phA->setInnerElements(new Typography("h1", array ("text" => "Progress Bars")));
        
        $pb = new ProgressBar();
        $pb->setNow(60)
        ->setText("60% Complete");
        
        $pb2 = clone $pb;
        $pb2->setNow(40)
        ->setColorSet("success") 
        ->setText("40% Complete (success)");
        
        $pb3 = clone $pb;
        $pb3->setNow(20)
        ->setColorSet("info")
        ->setText("20% Complete");
        
        $pb4 = clone $pb;
        $pb4->setNow(60)
        ->setColorSet("warning")
        ->setText("60% Complete (warning)");
        
        $pb5 = clone $pb;
        $pb5->setNow(80)
        ->setColorSet("danger")
        ->setText("80% Complete (danger)");
        
        $pb6 = clone $pb;
        $pb6->setNow(60)
        ->setIsStriped() 
        ->setText("60% Complete");
        
        $pb7 = clone $pb;
        $pb7->setNowSet(array(
            new PgBar("35", "success", "35% Complete"), 
            new PgBar("20", "warning", "25% Complete"),
            array ("now" => 10, "colorSet" => "danger", "text" => "10% Complete")
            // 陣列，物件都行 
        ));
        
        $phB = new Typography("div:page-header");
        $phB->setInnerElements(new Typography("h1", array ("text" => "List groups")));
        
        $listGroup = new ListGroup();
        $listGroup->setItems(array (
            new Listle("Cras justo odio"),
            new Listle("Dapibus ac facilisis in"),
            new Listle("Morbi leo risus"),
            new Listle("Porta ac consectetur ac"),
            new Listle("Vestibulum at eros") 
        ));
        $lgDiv1 = new Typography("div:col-sm-4");
        $lgDiv1->setInnerElements($listGroup);
        
        $listGroup2 = clone $listGroup;
        $listGroup2->getItem(0)->url = "#";
        $listGroup2->getItem(0)->active = true;
        $listGroup2->getItem(1)->url = "#";
        $listGroup2->getItem(2)->url = "#";
        $listGroup2->getItem(3)->url = "#";
        $listGroup2->getItem(4)->url = "#";
        $lgDiv2 = new Typography("div:col-sm-4");
        $lgDiv2->setInnerElements($listGroup2);
        
        $listGroup3 = new ListGroup();
        $listGroup3->setItems(array (
            new Listle("Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.", "#", "List group item heading", true),
            new Listle("Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.", "#", "List group item heading"),
            new Listle("Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.", "#", "List group item heading"),
        ));
        $lgDiv3 = new Typography("div:col-sm-4");
        $lgDiv3->setInnerElements($listGroup3);
        
        $lgRow = new Typography("div:row");
        $lgRow->setInnerElements($lgDiv1, $lgDiv2, $lgDiv3);
        
        $phC = new Typography("div:page-header");
        $phC->setInnerElements(new Typography("h1", array ("text" => "Panels")));
        
        $panel = new Panel();
        $panel->setHeading("Panel title")
        ->setBodyContents("Panel content")
        ->setColorSet("default");
        $plDiv1 = new Typography("div:col-sm-4");
        $plDiv1->setInnerElements($panel);
        $panel2 = clone $panel;
        $panel2->setColorSet("primary");
        $plDiv2 = new Typography("div:col-sm-4");
        $plDiv2->setInnerElements($panel2);
        $panel3 = clone $panel;
        $panel3->setColorSet("success");
        $plDiv3 = new Typography("div:col-sm-4");
        $plDiv3->setInnerElements($panel3);
        $panel4 = clone $panel;
        $panel4->setColorSet("info");
        $plDiv4 = new Typography("div:col-sm-4");
        $plDiv4->setInnerElements($panel4);
        $panel5 = clone $panel;
        $panel5->setColorSet("warning");
        $plDiv5 = new Typography("div:col-sm-4");
        $plDiv5->setInnerElements($panel5);
        $panel6 = clone $panel;
        $panel6->setColorSet("danger");
        $plDiv6 = new Typography("div:col-sm-4");
        $plDiv6->setInnerElements($panel6);
        $plRowDiv = new Typography("div:row");
        $plRowDiv->setInnerElements(array ($plDiv1, $plDiv2, $plDiv3, $plDiv4, $plDiv5, $plDiv6));
        
        $phD = new Typography("div:page-header");
        $phD->setInnerElements(new Typography("h1", array ("text" => "Wells")));
        
        $well = new Well();
        $text = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sed diam eget risus varius blandit sit amet non magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Aenean lacinia bibendum nulla sed consectetur.";
        $well->setText($text);
        
        $phE = new Typography("div:page-header");
        $phE->setInnerElements(new Typography("h1", array ("text" => "Carousel")));
        
        $caro = new Carousel();
        $caro->setItems(array (
            new Slidle("holder.js/1140x500/auto/#777:#555/text:First slide", "", true),
            new Slidle("holder.js/1140x500/auto/#666:#444/text:Second slide", ""),
            new Slidle("holder.js/1140x500/auto/#555:#333/text:Third slide", "")
        ));
        
        $container = new Typography("div:container", null, array("role"=> "main"));
        $container->setInnerElements(array ($jumbotron)) 
            ->setCustomClass("theme-showcase")
            ->setInnerElements(array ($ph, $p1, $p2, $p3, $p4)) 
            ->setInnerElements(array ($ph2, $row, $row2))
            ->setInnerElements(array ($ph3, $thumbnail))
            ->setInnerElements(array ($ph4, $p5, $p6, $p7, $p8, $p9, $p10, $p11))
            ->setInnerElements(array ($ph5, $p12, $nav))
            ->setInnerElements(array ($ph6, $ddDiv))
            ->setInnerElements(array ($ph7, $nav3, $nav4))
            ->setInnerElements(array ($ph8, $navbar, $navbar2))
            ->setInnerElements(array ($ph9, $alert1, $alert2, $alert3, $alert4))
            ->setInnerElements(array ($phA, $pb, $pb2, $pb3, $pb4, $pb5, $pb6, $pb7))
            ->setInnerElements(array ($phB, $lgRow))
            ->setInnerElements(array ($phC, $plRowDiv))
            ->setInnerElements(array ($phD, $well))
            ->setInnerElements(array ($phE, $caro));
        
                
        $btPanel->setBodyContents(array($navbar3, $container));
        
//         echo Typography::getErrMsg();
        $btPanel->render(true);
        echo "Memory usage(real): " . memory_get_usage(true);
    }
    
    /**
     * @desc forms example.
     */
    public function formView () {
        $btPanel = new Xantico();
        $btPanel->setIsLoadBootstrapFromCDN()->setIsLoadJQueryFromCDN();
        
        // Forms here.
        $pageHeader = new PageHeader("Forms");
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
        $formRow = new Row();
        $formRow->setItems(array ($inputFirstName, $inputLastName));
        $form12->setInnerElements($formRow);
        $form12Well = new Well ();
        $form12Well->setInnerElements($form12);
        
        // a complex example
        $form13 = new Form();
        $inputEmail3 = new Input("email", array ("caption" => "Email"), array ("id" => "inputEmail4", "placeholder" => "Email"));
        $inputPwd3 = new Input("password", array ("caption" => "Password"), array ("id" => "inputPassword4", "placeholder" => "Password", ));
        $formRow2 = new Row();
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
        $formRow3 = new Row();
        $formRow3->setItems(array (
            array ("input" => $inputCity, "width" => 6),
            array ("input" => $selectState, "width" => 4),
            new Grid($inputZip, 2)
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
        $form13Well = new Well();
        $form13Well->setInnerElements($form13);
        
        // forizontal form
        $form14 = new Form ();
        $form14->setFormType("horizontal");
        $inputEmail4 = new Input("email");
        $inputEmail4->setCaption("Email")
        ->setPlaceholder("Email")
        ->setId("inputEmail3");
        $inputPwd4 = new Input("password");
        $inputPwd4->setCaption("Password")
        ->setPlaceholder("Password")
        ->setId("inputPassword3");
        $radio2 = new Input("radio");
        $radio2->setOptions(array("First radio", "Second radio", "Thrid disabled radio"))
        ->setCaption("Radios")
        ->setName("gridRadios")
        ->setDisabledOption(array (2));
        $check3 = new Input("checkbox");
        $check3->setCaption("Checkbox")
        ->setOptions(array("Example checkbox"));
        $form14->setInnerElements(array ($inputEmail4, $inputPwd4, $radio2, $check3))
        ->setFormAction(clone $btnSignin)
        ->setLabelRatio("2:10");
        $form14Well = new Well();
        $form14Well->setInnerElements($form14);
        
        // inline form with grid
        $form15 = new Form();
        $inputName = new Input();
        $inputName->setPlaceholder("Jane Doe")
        ->setCaption("Name")
        ->setId("inlineFormInput");
        $inputUser = new Input();
        $inputUser->setId("inlineFormInputGroup")
        ->setPlaceHolder ("Username");
        $inputUserGrp = new InputGroup();
        $inputUserGrp->setLeftAddon("@")
        ->setCaption("Username")
        ->setInnerElements($inputUser);
        $check4 = new Input("checkbox");
        $check4-> setOptions(array ("Remember me"));
        $btn = new Button();
        $btn->setIsSubmit()->setText("Submit")->setColorSet("primary");
        $formRow4 = new Row();
        $formRow4->setItems(array(
            new Grid($inputName, 4),
            new Grid($inputUserGrp, 4),
            new Grid($check4, 2),
            new Grid($btn, 2)
        ))
        ->setCustomClass("align-items-center");
        $form15Well = $form15->setInnerElements(array ($formRow4))
        ->setFormType("inline")->enclose(new Well());
        
        // direct set form to inline
        $form16 = new Form();
        $form16->setInnerElements(array (clone $inputName, clone $inputUserGrp, clone $check4))
        ->setFormType("inline")
        ->setFormAction(clone $btn);
        $form16Well = new Well();
        $form16Well-> setInnerElements($form16);
        
        // inline form with select, this one failed, but you can insert the checkbox and button into a row before.
        $form17 = new Form();
        $select = new Select();
        $select->setCaption("Preference")
        ->setOptions(array ("Choose...", "One", "Two", "Three"))
        ->setId("inlineFormCustomSelectPref");
        $check5 = new Input("checkbox");
        $check5->setOptions(array ("Remember my preference"))
        ->setId("customControlInline");
        $form17Well = $form17->setInnerElements(array ($select, $check5))
        ->setFormAction()
        ->setFormType("inline")
        ->enclose(new Well());
        
        // Help text
        $pageHeader4 = new PageHeader("Help text");
        $form18 = new Form();
        $inputPwd5 = new Input("password");
        $inputPwd5->setCaption("Password")
        ->setId("inputPassword5")
        ->setHelp("Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.");
        $form18Well = $form18->setInnerElements($inputPwd5)->enclose(new Well());
        
        $inputPwd6 = new Input("password");
        $well19 = $inputPwd6->setHelp("Must be 8-20 characters long.")
        ->setId("inputPassword6")
        ->setCaption("inputPassword6")
        ->enclose(new Form())->setFormType("inline")->enclose(new Well);
        
        // disabled forms
        $pageHeader5 = new PageHeader("Disabled forms");
        $form20 = new Form();
        $inputDisabled = new Input();
        $inputDisabled->setCaption("Disabled input")
        ->setPlaceholder("Disabled input")
        ->setId("disabledTextInput");
        $selectDisabled = new Select();
        $selectDisabled->setCaption("Disabled select menu")
        ->setOptions(array ("Disabled select"))
        ->setId("disabledSelect");
        $checkDisabled = new Input("checkbox");
        $checkDisabled->setOptions(array ("Can't check this"))
        ->setId("disabledFieldsetCheck");
        $fieldset20 = $form20->setFormAction()
        ->setIsDisabled()
        ->setInnerElements(array ($inputDisabled, $selectDisabled, $checkDisabled))
        ->enclose(new Well());
        
        $pageHeader6 = new PageHeader("Validation");
        Input::$AUTO_NAMING = true;
        Input::$FORM_VALIDATION_METHOD = "browser";
        $form21 = new Form();
        $inputFirstName = new Input();
        $inputFirstName->setCaption("First name")
        ->setPlaceholder("First name")
        ->setDefaultValue("Mark")
        ->setIsRequired()
        ->setId("validationCustom01");
        $inputLastName = new Input();
        $inputLastName->setCaption("Last name")
        ->setPlaceholder("Last name")
        ->setDefaultValue("Otto")
        ->setIsRequired()
        ->setId("validationCustom02");
        $inputUser2 = new Input();
        $inputGrp2 = $inputUser2->setPlaceholder("Username")
        ->setId("validationCustomUsername")
        ->setIsRequired()
        ->enclose(new InputGroup())
        ->setLeftAddon(array ("@"))
        ->setCaption("Username");
        
        $formRow5 = new Row();
        $formRow5->setForForm()
        ->setItems(array ($inputFirstName, $inputLastName, $inputGrp2));
        $formRow6 = clone $formRow3;
        $rowGrids = $formRow6->getItems();
        $rowGrids[0]->text->setCaption("City")->setIsRequired()->setPlaceHolder("City");
        $rowGrids[1]->input = new Input();
        $rowGrids[1]->text->setPlaceHolder("State")->setCaption("State")->setIsRequired()->setId("inputState");
        $rowGrids[1]->width = 3;
        $rowGrids[2]->text->setIsRequired()->setPlaceHolder("Zip");
        $rowGrids[2]->width = 3;
        $check6 = new Input("checkbox");
        $check6->setOptions(array("Agree to terms and conditions "))
        ->setIsRequired();
        $btn2 = new Button();
        $btn2->setIsSubmit()
        ->setColorSet("primary")
        ->setText("Submit form");
        $form21->setInnerElements(array ($formRow5, $formRow6, $check6))
        ->setRequireIcon(null)
        ->setFormAction($btn2);
        
        $form21 = new Form();
        $inputFirstName = new Input();
        $inputFirstName->setCaption("First name")
        ->setPlaceholder("First name")
        ->setDefaultValue("Mark")
        ->setIsRequired()
        ->setId("validationCustom01");
        $inputLastName = new Input();
        $inputLastName->setCaption("Last name")
        ->setPlaceholder("Last name")
        ->setDefaultValue("Otto")
        ->setIsRequired()
        ->setId("validationCustom02");
        $inputUser2 = new Input();
        $inputGrp2 = $inputUser2->setPlaceholder("Username")
        ->setId("validationCustomUsername")
        ->setIsRequired()
        ->enclose(new InputGroup())
        ->setLeftAddon(array ("@"))
        ->setCaption("Username");
        
        $formRow5 = new Row();
        $formRow5->setForForm()
        ->setItems(array ($inputFirstName, $inputLastName, $inputGrp2));
        $formRow6 = clone $formRow3;
        $rowGrids = $formRow6->getItems();
        $rowGrids[0]->text->setCaption("City")->setIsRequired()->setPlaceHolder("City");
        $rowGrids[1]->input = new Input();
        $rowGrids[1]->text->setPlaceHolder("State")->setCaption("State")->setIsRequired()->setId("inputState");
        $rowGrids[1]->width = 3;
        $rowGrids[2]->text->setIsRequired()->setPlaceHolder("Zip");
        $rowGrids[2]->width = 3;
        $check6 = new Input("checkbox");
        $check6->setOptions(array("Agree to terms and conditions "))
        ->setIsRequired();
        $btn2 = new Button();
        $btn2->setIsSubmit()
        ->setColorSet("primary")
        ->setText("Submit form");
        $form21->setInnerElements(array ($formRow5, $formRow6, $check6))
        ->setRequireIcon(null)
        ->setFormAction($btn2);
        
        // server-side validation @todo bs 4.0.0
        $form22 = new Form();
        $form22->setCustomClass("was-validated");
        $checkValid = new Input("checkbox");
        $checkValid->setIsRequired()
        ->setCustomClass("is-invalid")
        ->setId("customControlValidation1")
        ->setOptions (array ("Check this custom checkbox"))
        ->setHelp(new Typography("div:text-danger", array ("text" => "Example invalid feedback text"))); // invalid-feedback
        $radioValid = new Input("radio");
        $radioValid->setIsRequired()
        ->setId("customControlValidation2")
        ->setOptions(array ("Toggle this custom radio", "Or toggle this other custom radio"))
        ->setHelp(new Typography("div:text-danger", array ("text" => "More example invalid feedback text")));
        $selectValid = new Select ();
        $selectValid->setOptions(array ("Open this select menu", "One", "Two", "Three"))
        ->setIsRequired()
        ->setHelp(new Typography("div:text-danger", array ("text" => "Example invalid custom select feedback")))
        ->setCustomClass(array("is-invalid"));
        $fileValid = new Input("file");
        $fileValid->setIsRequired()
        ->setCustomClass("is-invalid")
        ->setHelp(new Typography("div:text-danger", array ("text" => "Example invalid custom file feedback")));
        $form22->setInnerElements(array ($checkValid, $radioValid, $selectValid, $fileValid));
        
        // container
        $container = new Typography("div:container", null, array("role"=> "main"));
        $container->setInnerElements(array (
            $pageHeader,
            $form1->enclose(new Well()),
            new Typography("h2", array ("text" => "Form controls")),
            $form2->enclose(new Well()),
            $form3->enclose(new Well()),
            new Typography("h2", array ("text" => "Readonly")),
            $form4->enclose(new Well()),
            $form5->enclose(new Well()),
            $form6->enclose(new Well()),
            $pageHeader2,
            $form7->enclose(new Well()),
            $form8->enclose(new Well()),
            $form9->enclose(new Well()),
            new Typography("h2", array ("text" => "Without labels")),
            $form10->enclose(new Well()),
            $pageHeader3,
            new Typography("h2", array ("text" => "Form group")),
            $form11->enclose(new Well()),
            new Typography("h2", array ("text" => "Form grid")),
            $form12Well,
            new Typography("h2", array ("text" => "Form row")),
            $form13Well,
            new Typography("h2", array ("text" => "Horizontal form")),
            $form14Well,
            new Typography("h2", array ("text" => "Inline forms")),
            $form15Well,
            $form16Well,
            $form17Well,
            $pageHeader4,
            $form18Well,
            $well19,
            $pageHeader5,
            $fieldset20,
            $pageHeader6,
            new Typography("h2", array ("text" => "Browser defaults")),
            $form21->enclose(new Well()),
            new Typography("h2", array ("text" => "Server side")),
            $form22->enclose(new Well())
        ))
        ->setCaption("Example textarea")
        ->setCustomClass("theme-showcase");
        
        // bootstrap palette
        $btPanel->setBodyContents(array($container));
        
        $btPanel->render(true);
        var_dump(Typography::getErrMsg());
        // echo "Memory usage(real): " . memory_get_usage(true);
    }
    
    /**
     * @desc default components demo.
     */
    public function defaultView () {
        $btPanel = new Xantico();
        $btPanel->setIsLoadBootstrapFromCDN()->setIsLoadJQueryFromCDN();
        
        // Components here.
        $pageHeader = new PageHeader("Glyphicons");
        $row1 = new Row();
        $row1->setItems(array (
            new Grid(new Icon("asterisk"), 1),
            new Grid(new Icon("plus"), 1),
            new Grid(new Icon("euro"), 1),
            new Grid(new Icon("eur"), 1),
            new Grid(new Icon("minus"), 1),
            new Grid(new Icon("cloud"), 1),
            new Grid(new Icon("envelope"), 1),
            new Grid(new Icon("pencil"), 1),
            new Grid(new Icon("glass"), 1),
            new Grid(new Icon("music"), 1),
            new Grid(new Icon("search"), 1),
            new Grid(new Icon("heart"), 1) 
        ));
        $row2 = new Row();
        $row2->setItems(array (
            new Grid(new Icon("star"), 1),
            new Grid(new Icon("star-empty"), 1),
            new Grid(new Icon("user"), 1),
            new Grid(new Icon("film"), 1),
            new Grid(new Icon("th-large"), 1),
            new Grid(new Icon("th"), 1),
            new Grid(new Icon("th-list"), 1),
            new Grid(new Icon("ok"), 1),
            new Grid(new Icon("remove"), 1),
            new Grid(new Icon("zoom-in"), 1),
            new Grid(new Icon("zoom-out"), 1),
            new Grid(new Icon("off"), 1)
        ));
        $row3 = new Row();
        $row3->setItems(array (
            new Grid(new Icon("object-align-right"), 1),
            new Grid(new Icon("triangle-left"), 1),
            new Grid(new Icon("triangle-right"), 1),
            new Grid(new Icon("triangle-bottom"), 1),
            new Grid(new Icon("triangle-top"), 1),
            new Grid(new Icon("console"), 1),
            new Grid(new Icon("superscript"), 1),
            new Grid(new Icon("subscript"), 1),
            new Grid(new Icon("menu-left"), 1),
            new Grid(new Icon("menu-right"), 1),
            new Grid(new Icon("menu-down"), 1),
            new Grid(new Icon("menu-up"), 1)
        ));
        $well1 = new Well();
        $well1->setInnerElements(array ($row1, $row2, $row3));
        
        $pageHeader2 = new PageHeader("Dropdown");
        $dropMenu = array (
            new Droplet("Action", "#"),
            new Droplet("Another action", "#"),
            new Droplet("Something else here", "#"),
            new Droplet("", "", false, true),
            new Droplet("Seperated link", "#")
        );
        $dropdown = new Dropdown();
        $dropdownDiv = $dropdown->setItems($dropMenu)
        ->setText("Dropdown")
        ->setColorSet("default") 
        ->enclose(new Typography("div"));
        
        $dropup = new Dropdown();
        $dropupDiv = $dropup->setIsDropup()
        ->setItems($dropMenu)
        ->setText("Dropup")
        ->setColorSet("default")
        ->enclose(new Typography("div"));
        
        $dropMenu2 = array (
            new Droplet("Dropdown Header", "", true),
            new Droplet("Action", "#"),
            new Droplet("Another action", "#"),
            new Droplet("Something else here", "#"),
            new Droplet("Dropdown Header", "", true),
            new Droplet("Seperated link", "#")
        );
        $dropdown2 = new Dropdown();
        $dropdownDiv2 = $dropdown2->setItems($dropMenu2)
        ->setText("Dropdown")
        ->setColorSet("default")
        ->enclose(new Typography("div"));
        
        $dropMenu3 = array (
            new Droplet("Regular link", "#"),
            new Droplet("Disabled link", "#", false, false, false, true),
            new Droplet("Another link", "#"),
        );
        $dropdown3 = new Dropdown();
        $dropdownDiv3 = $dropdown2->setItems($dropMenu3)
        ->setText("Dropdown")
        ->setColorSet("default")
        ->enclose(new Typography("div"));
        
        $pageHeader3 = new PageHeader("Button groups");
        $btnLeft = new Button();
        $btnMid = new Button();
        $btnRight = new Button();
        $btnLeft->setText("Left");
        $btnMid->setText("Middle");
        $btnRight->setText("Right");
        $btnGrp1 = new ButtonGroup();
        $btnGrp1->setInnerElements(array ($btnLeft, $btnMid, $btnRight));
        
        $btn1 = new Button(array ("text" => 1));
        $btn2 = new Button(array ("text" => 2));
        $btn3 = new Button(array ("text" => 3));
        $btn4 = new Button(array ("text" => 4));
        $btn5 = new Button(array ("text" => 5));
        $btn6 = new Button(array ("text" => 6));
        $btn7 = new Button(array ("text" => 7));
        $btn8 = new Button(array ("text" => 8));
        $btnGrp2 = new ButtonGroup();
        $btnGrp3 = new ButtonGroup();
        $btnGrp4 = new ButtonGroup();
        $btnGrp2->setInnerElements(array ($btn1, $btn2, $btn3, $btn4));
        $btnGrp3->setInnerElements(array ($btn5, $btn6, $btn7));
        $btnGrp4->setInnerElements($btn8);
        $btnToolbar = new ButtonToolbar();
        $btnToolbar->setInnerElements($btnGrp2, $btnGrp3, $btnGrp4);
        
        $btnGrp5 = clone $btnGrp1;
        $btnGrp6 = clone $btnGrp1;
        $btnGrp7 = clone $btnGrp1;
        $btnGrp8 = clone $btnGrp1;
        $btnGrp5 = $btnGrp5->setSize(5)->enclose(new Row());
        $btnGrp6 = $btnGrp6->setSize(4)->enclose(new Row());
        $btnGrp7 = $btnGrp7->setSize(3)->enclose(new Row());
        $btnGrp8 = $btnGrp8->setSize(2)->enclose(new Row());
        $well2 = new Well();
        $well2->setInnerElements(array($btnGrp5, $btnGrp6, $btnGrp7, $btnGrp8));
        
        $dropdownGrp = new Dropdown();
        $dropMenu4 = array (
            new Droplet("Dropdown link", "#"),
            new Droplet("Dropdown link", "#")
        );
        $dropdownGrp->setItems($dropMenu4)->setText("Dropdown");
        $btnGrp9 = new ButtonGroup();
        $btnGrp9->setInnerElements(array ($btn1, $btn2, $dropdownGrp));

        $btnButton = new Button();
        $btnButton->setText("Button");
        $btnGrpVertical = new ButtonGroup();
        $btnGrpVertical->setIsVertical()
        ->setInnerElements(array ($btnButton, clone $btnButton, clone $dropdownGrp, clone $btnButton, clone $btnButton, clone $dropdownGrp, clone $dropdownGrp));
        
        $pageHeader4 = new PageHeader("Button dropdowns");
        $btnDropdown = new Dropdown();
        $btnDropdown->setColorSet("default")
        ->setText("Default")
        ->setItems($dropMenu);
        $btnDropdown2 = clone $btnDropdown;
        $btnDropdown2->setColorSet("primary")->setText("Primary");
        $btnDropdown3 = clone $btnDropdown;
        $btnDropdown3->setColorSet("success")->setText("Success");
        $btnDropdown4 = clone $btnDropdown;
        $btnDropdown4->setColorSet("info")->setText("Info");
        $btnDropdown5 = clone $btnDropdown;
        $btnDropdown5->setColorSet("warning")->setText("Warning");
        $btnDropdown6 = clone $btnDropdown;
        $btnDropdown6->setColorSet("danger")->setText("Danger");
        $well3 = new Well();
        $well3->setInnerElements(array ($btnDropdown, $btnDropdown2, $btnDropdown3, $btnDropdown4, $btnDropdown5, $btnDropdown6));
        
        $well4 = clone $well3;
        $well4->getElement(0)->setIsSplit();
        $well4->getElement(1)->setIsSplit();
        $well4->getElement(2)->setIsSplit();
        $well4->getElement(3)->setIsSplit();
        $well4->getElement(4)->setIsSplit();
        $well4->getElement(5)->setIsSplit();
        
        $lgDropdown = new Dropdown();
        $lgDropdown->setText("Large dropdown")
        ->setItems($dropMenu)
        ->setSize(5);
        $smDropdown = clone $lgDropdown;
        $smDropdown->setSize(3)->setText("Small dropdown");
        $xsDropdown = clone $lgDropdown;
        $xsDropdown->setSize(2)->setText("Extra small dropdown");
        $well5 = new Well();
        $well5->setInnerElements(array ($lgDropdown->enclose(new Row()), $smDropdown->enclose(new Row()), $xsDropdown->enclose(new Row())));
        
        $dropRight = new Dropdown();
        $dropRight->setText("Dropup")
        ->setIsSplit()
        ->setIsDropup()
        ->setItems($dropMenu);
        $dropRightPmy = new Dropdown();
        $dropRightPmy->setText('Right dropup')
        ->setIsDropup()
        ->setIsSplit()
        ->setAlign("right")
        ->setColorSet("Primary")
        ->setItems($dropMenu);
        $well6 = new Well();
        $well6->setInnerElements(array ($dropRight, $dropRightPmy));
        
        $pageHeader6 = new PageHeader("Input groups");
        $inputUser = new Input();
        $inputUserGrp = $inputUser->setPlaceholder("Username")
        ->enclose(new InputGroup())->setLeftAddon("@");
        $inputUser2 = new Input();
        $inputUserGrp2 = $inputUser2->setPlaceholder("Recipient's username")
        ->enclose(new InputGroup())->setRightAddon("@example.com");
        $inputUser3 = new Input();
        $inputUser3->setCaption("Your vanity URL");
        $inputUserGrp3 = new InputGroup();
        $inputUserGrp3->setInputBody($inputUser3)->setLeftAddon("https://example.com/users/");
        $form1 = new Form();
        $well7 = $form1->setInnerElements(array ($inputUserGrp, $inputUserGrp2, $inputUserGrp3))
        ->enclose(new Well());
        
        $inputUserGrp4 = clone $inputUserGrp;
        $inputUserGrp4->setSize(5);
        $inputUserGrp5 = clone $inputUserGrp;
        $inputUserGrp6 = clone $inputUserGrp;
        $inputUserGrp6->setSize(3);
        $form2 = new Form ();
        $form2->setInnerElements(array ($inputUserGrp4, $inputUserGrp5, $inputUserGrp6));
        
        $inputCheckGrp = new InputGroup();
        $inputCheckGrp->setInputBody(new Input())->setLeftAddon(new Input("checkbox"));
        $inputRadioGrp = new InputGroup();
        $inputRadioGrp->setInputBody(new Input())->setLeftAddon(new Input("radio"));
        $row4 = new Row();
        $row4->setItems(array (
            new Grid($inputCheckGrp, 6),
            new Grid($inputRadioGrp, 6)
        ));
        $form3 = new Form();
        $form3->setInnerElements($row4);
        
        $inputSearch = new Input();
        $inputSearch->setPlaceholder("Search ...");
        $btnAddon = new Button();
        $btnAddon->setText("Go!");
        $inputSearchGrp = new InputGroup();
        $inputSearchGrp->setInputBody($inputSearch)->setLeftAddon($btnAddon);
        $inputSearchGrp2 = new InputGroup();
        $inputSearchGrp2->setInputBody(clone $inputSearch)->setRightAddon(clone $btnAddon);
        $row5 = new Row ();
        $row5->setItems(array (
            new Grid($inputSearchGrp, 6),
            new Grid($inputSearchGrp2, 6)
        ));
        $form4 = new Form();
        $form4->setInnerElements($row5);
        
        $dropdownAddon = new Dropdown();
        $dropdownAddon->setText("Action")->setItems($dropMenu);
        $inputAction = new Input();
        $inputActionGrp = new InputGroup();
        $inputActionGrp->setInputBody($inputAction)->setLeftAddon($dropdownAddon);
        $inputActionGrp2 = new InputGroup();
        $inputActionGrp2->setInputBody(clone $inputAction)->setRightAddon($dropdownAddon->cloneInstance()->setAlign("right"));
        $row6 = new Row ();
        $row6->setItems(array (
            new Grid($inputActionGrp, 6),
            new Grid($inputActionGrp2, 6)
        ));
        $form5 = new Form();
        $form5->setInnerElements($row6);
        
        $dropdownAddon2 = $dropdownAddon->cloneInstance()->setIsSplit();
        $actionBtn = new Button();
        $actionBtn->setText("Action")->setColorSet("Default");
        $inputActionGrp3 = new InputGroup();
        $inputActionGrp3->setInputBody(new Input())->setLeftAddon(array($actionBtn, $dropdownAddon2->getButton(), $dropdownAddon2->getMenu()));
        $inputActionGrp4 = new InputGroup();
        $dropdownAddon3 = $dropdownAddon2->cloneInstance()->setAlign("right");
        $inputActionGrp4->setInputBody(new Input())->setRightAddon(array (clone $actionBtn, $dropdownAddon3->getButton(), $dropdownAddon3->getMenu()));
        $row7 = new Row ();
        $row7->setItems(array (
            new Grid($inputActionGrp3, 6),
            new Grid($inputActionGrp4, 6)
        ));
        $form6 = new Form();
        $form6->setInnerElements($row7);
        
        $mplBtn = new InputGroup();
        $boldBtn = new Button();
        $boldBtn->setIcon(new Icon("bold"));
        $italicBtn = new Button();
        $italicBtn->setIcon(new Icon("italic"));
        $signBtn = new Button();
        $signBtn->setIcon(new Icon("question-sign"));
        $mplBtn->setLeftAddon(array ($boldBtn, $italicBtn))->setInputBody(new Input());
        $mplBtn2 = new InputGroup();
        $mplBtn2->setRightAddon(array ($signBtn, clone $actionBtn))->setInputBody(new Input());
        $row8 = new Row();
        $row8->setItems(array (
            new Grid($mplBtn, 6),
            new Grid($mplBtn2, 6) 
        ));
        $form7 = new Form();
        $form7->setInnerElements($row8);
        
        $pageHeader7 = new PageHeader("Navs");
        // navs
        $nav1 = new Nav();
        $nav1->setStyle("tabs")
        ->setItems(array (
            new Navlet("Home", "#", true),
            new Navlet("Profile", "#"),
            new Navlet("Messages", "#")
        ));
        
        $nav2 = clone $nav1;
        $nav2->setStyle("pills");
        
        $nav3 = clone $nav1;
        $nav3->setStyle("stacked");
        
        $nav4 = clone $nav1;
        $nav4->setIsJustified();
        $nav5 = clone $nav2;
        $nav5->setIsJustified();
        $well8 = new Well();
        $well8->setInnerElements(array ($nav4, $nav5));
        
        // container
        $container = new Typography("div:container", null, array("role"=> "main"));
        $container->setInnerElements(array (
            $pageHeader,
            $well1,
            $pageHeader2, 
            $dropdownDiv->enclose(new Well()),
            $dropupDiv->enclose(new Well()),
            new Typography("h2", array ("text" => "Headers")), 
            $dropdownDiv2->enclose(new Well()),
            new Typography("h2", array ("text" => "Disabled menu item")),
            $dropdownDiv3->enclose(new Well()),
            $pageHeader3, 
            $btnGrp1->enclose(new Well()),
            new Typography("h2", array ("text" => "Button toolbar")),
            $btnToolbar->enclose(new Well()),
            new Typography("h2", array ("text" => "Sizing")),
            $well2, 
            new Typography("h2", array ("text" => "Nesting")),
            $btnGrp9->enclose(new Well()),
            new Typography("h2", array ("text" => "Vertical variation")),
            $btnGrpVertical->enclose(new Well()), 
            $pageHeader4,
            $well3,
            new Typography("h2", array ("text" => "Split button dropdowns")), 
            $well4,
            new Typography("h2", array ("text" => "Sizing")),  
            $well5,
            new Typography("h2", array ("text" => "Dropup variation")),
            $well6,
            $pageHeader6,
            $well7,
            new Typography("h2", array ("text" => "Sizing")),
            $form2->enclose(new Well()),
            new Typography("h2", array ("text" => "Checkboxes and radio addons")),
            $form3->enclose(new Well()),
            new Typography("h2", array ("text" => "Button addons")),
            $form4->enclose(new Well()),
            new Typography("h2", array ("text" => "Buttons with dropdowns")),
            $form5->enclose(new Well()),
            new Typography("h2", array ("text" => "Segmented buttons")),
            $form6->enclose(new Well()), 
            new Typography("h2", array ("text" => "Multiple buttons")),
            $form7->enclose(new Well()),  
            $pageHeader7,
            $nav1->enclose(new Well()),
            new Typography("h2", array ("text" => "Pills")),
            $nav2->enclose(new Well()),
            $nav3->enclose(new Well()),
            new Typography("h2", array ("text" => "Justified")),
            $well8 
        ));
        // bootstrap palette
        $btPanel->setBodyContents(array($container));
        
        $btPanel->render(true);
        var_dump(Typography::getErrMsg());
        // echo "Memory usage(real): " . memory_get_usage(true);
    }
    
}

