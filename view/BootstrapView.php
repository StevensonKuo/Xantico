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
use model\bootstrap\HtmlTag;
use model\bootstrap\basic\Code;
use model\bootstrap\basic\Breadcrumb;
use model\bootstrap\basic\Crumb;
use model\bootstrap\basic\Pagination;
use model\bootstrap\basic\Thumbnail;
use model\bootstrap\basic\Media;
use model\bootstrap\basic\MediaList;


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
            ->setBodyContents("This is a template showcasing the optional theme stylesheet included in Bootstrap. Use it as a starting point to create something more unique by building on or modifying it.");
        
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
        
        $thumbnail = new Thumbnail();
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
        $navbar->setBrand("Bootstrap theme")
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
        $pb->setNow(60);
        
        $pb2 = clone $pb;
        $pb2->setNow(40)
        ->setColorSet("success");
        
        $pb3 = clone $pb;
        $pb3->setNow(20)
        ->setColorSet("info");
        
        $pb4 = clone $pb;
        $pb4->setNow(60)
        ->setColorSet("warning");
        
        $pb5 = clone $pb;
        $pb5->setNow(80)
        ->setColorSet("danger");
        
        $pb6 = clone $pb;
        $pb6->setNow(60)
        ->setIsStriped();
        
        $pb7 = clone $pb;
        $pb7->setItems(array(
            new PgBar(35, "success"), 
            new PgBar(20, "warning"),
            array ("now" => 10, "colorSet" => "danger")
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
        
        // @todo 要改... 不直接支援 heading 了
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
        $btPanel->setIsLoadBootstrapFromCDN()->setIsLoadJQueryFromCDN()
        ->setCustomCSSFiles('https://getbootstrap.com/docs/3.3/assets/css/docs.min.css');
        
        // Forms here.
        $bsExample = new Typography("div:bs-example");
        $code = new Code();
        
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
         $form1Code = $code->cloneInstance()->setText('
            <?php
            $form1 = new Form();
            $inputEmail = new Input("email");
            $inputEmail->setCaption("Email Address")
            ->setHelp("We\'ll never share your email with anyone else.")->setPlaceholder("Enter Email")->setId("exampleInputEmail1");
            $inputPwd = new Input("password");
            $inputPwd->setCaption("Password")->setPlaceholder("password")->setId("exampleInputPassword1");
            $check = new Input("checkbox");
            $check->setOptions(array ("Check me out"));
            $form1->setFormAction()->setInnerElements(array ($inputEmail, $inputPwd, $check));
            $form1->render(true);
            ?>');
        
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
        $form12Well = clone $bsExample;
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
        $form13Well = clone $bsExample;
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
        $form14Well = clone $bsExample;
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
        ->setFormType("inline")->enclose(clone $bsExample);
        
        // direct set form to inline
        $form16 = new Form();
        $form16->setInnerElements(array (clone $inputName, clone $inputUserGrp, clone $check4))
        ->setFormType("inline")
        ->setFormAction(clone $btn);
        $form16Well = clone $bsExample;
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
        ->enclose(clone $bsExample);
        
        // Help text
        $pageHeader4 = new PageHeader("Help text");
        $form18 = new Form();
        $inputPwd5 = new Input("password");
        $inputPwd5->setCaption("Password")
        ->setId("inputPassword5")
        ->setHelp("Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.");
        $form18Well = $form18->setInnerElements($inputPwd5)->enclose(clone $bsExample);
        
        $inputPwd6 = new Input("password");
        $well19 = $inputPwd6->setHelp("Must be 8-20 characters long.")
        ->setId("inputPassword6")
        ->setCaption("inputPassword6")
        ->enclose(new Form())->setFormType("inline")->enclose(clone $bsExample);
        
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
        ->enclose(clone $bsExample);
        
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
            $form1->enclose(clone $bsExample),
            $form1Code, 
            new Typography("h2", array ("text" => "Form controls")),
            $form2->enclose(clone $bsExample),
            $form3->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Readonly")),
            $form4->enclose(clone $bsExample),
            $form5->enclose(clone $bsExample),
            $form6->enclose(clone $bsExample),
            $pageHeader2,
            $form7->enclose(clone $bsExample),
            $form8->enclose(clone $bsExample),
            $form9->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Without labels")),
            $form10->enclose(clone $bsExample),
            $pageHeader3,
            new Typography("h2", array ("text" => "Form group")),
            $form11->enclose(clone $bsExample),
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
            $form21->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Server side")),
            $form22->enclose(clone $bsExample)
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
        $btPanel->setIsLoadBootstrapFromCDN()->setIsLoadJQueryFromCDN()
        ->setCustomCSSFiles('https://getbootstrap.com/docs/3.3/assets/css/docs.min.css')
        ->setCustomScriptsFiles('https://v3.bootcss.com/assets/js/docs.min.js'); 
        
        // Components here.
        $bsExample = new Typography("div:bs-example");
        $code = new Code();
        
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
        $well1 = clone $bsExample;
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
        $dropdownDiv3 = $dropdown3->setItems($dropMenu3)
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
        $well2 = clone $bsExample;
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
        $well3 = clone $bsExample;
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
        $well5 = clone $bsExample;
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
        $well6 = clone $bsExample;
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
        ->enclose(clone $bsExample);
        
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
        
        $nav6 =new Nav();
        $navMenu = array (
            new Navlet("Clickable link", "#"),
            new Navlet("Clickable link", "#"),
            new Navlet("Disaled link", "#", false, true)
        );
        $nav6->setItems($navMenu)->setStyle("pills");
        
        $nav7 = new Nav();
        $dropdown4 = new Dropdown();
        $dropdown4->setItems($dropMenu)->setText("Dropdown")->setMode("inline");
        $nav7->setItems(array (
            new Navlet("Home", "#", true),
            new Navlet("Help", "#"),
            new Navlet($dropdown4)
        ));
        
        $nav8 = clone $nav7;
        $nav8->setStyle("pills");
        
        $pageHeader8 = new PageHeader("Navbar");
        $navbar = new Navbar();
        $dropdown5 = new Dropdown();
        $dropdown5->setMode("inline")
        ->setText("Dropdown")
        ->setItems(array_merge($dropMenu, array (new Droplet("", "", false, true), new Droplet("One more seperated link", "#"))));
        $navbar->setBrand("Brand")
        ->setItems(array (
            new Navlet("Link", "#", true),
            new Navlet("Link", "#"),
            new Navlet($dropdown5), // remember don't add url after a Typography instance.
        ));
        $formInNavbar = new Form ();
        $formInNavbar->setFormType("navbar-form")->setCustomClass("navbar-left")->setFormAction();
        $inputInNavbar = new Input();
        $inputInNavbar->setPlaceholder("Search");
        $formInNavbar->setInnerElements(array($inputInNavbar));
        $navInNavbar = new Nav();
        $navInNavbar->setItems(array (
            new Navlet("Link", "#"),
            new Navlet(clone $dropdown4)
        ))->setAlign("right")->setStyle("navbar");
        $navbar->setCollapseButton()
        ->setInnerElements(array ($formInNavbar, $navInNavbar));
        
        $navbar2 = new Navbar();
        $brandImg = new HtmlTag("img");
        $navbar2->setBrand($brandImg
            ->setAttrs(array("src" => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAB+0lEQVR4AcyYg5LkUBhG+1X2PdZGaW3btm3btm3bHttWrPomd1r/2Jn/VJ02TpxcH4CQ/dsuazWgzbIdrm9dZVd4pBz4zx2igTaFHrhvjneVXNHCSqIlFEjiwMyyyOBilRgGSqLNF1jnwNQdIvAt48C3IlBmHCiLQHC2zoHDu6zG1iXn6+y62ScxY9AODO6w0pvAqf23oSE4joOfH6OxfMoRnoGUm+de8wykbFt6wZtA07QwtNOqKh3ZbS3Wzz2F+1c/QJY0UCJ/J3kXWJfv7VhxCRRV1jGw7XI+gcO7rEFFRvdYxydwcPsVsC0bQdKScngt4iUTD4Fy/8p7PoHzRu1DclwmgmiqgUXjD3oTKHbAt869qdJ7l98jNTEblPTkXMwetpvnftA0LLHb4X8kiY9Kx6Q+W7wJtG0HR7fdrtYz+x7iya0vkEtUULIzCjC21wY+W/GYXusRH5kGytWTLxgEEhePPwhKYb7EK3BQuxWwTBuUkd3X8goUn6fMHLyTT+DCsQdAEXNzSMeVPAJHdF2DmH8poCREp3uwm7HsGq9J9q69iuunX6EgrwQVObjpBt8z6rdPfvE8kiiyhsvHnomrQx6BxYUyYiNS8f75H1w4/ISepDZLoDhNJ9cdNUquhRsv+6EP9oNH7Iff2A9g8h8CLt1gH0Qf9NMQAFnO60BJFQe0AAAAAElFTkSuQmCC',
                "width" => 20,
                "height" => 20)
            )
        );
        
        $navbar3 = new Navbar();
        $navbar3->setBrand("Brand");
        $formInNavbar2 = clone $formInNavbar;
        $navbar3->setInnerElements($formInNavbar2);
        
        $navbar4 = new Navbar();
        $navbar4->setBrand("Brand")->setIsFluid();
        $buttonInNavbar = new Button();
        $buttonInNavbar->setColorSet('default')->setText('Sign in');
        $navbar4->setInnerElements($buttonInNavbar);
        
        $navbar5 = new Navbar();
        $navbar5->setBrand("Brand")->setIsFluid()->setText("Signed in as Mark Otto");
        $navbar5Code = $code->cloneInstance()->setText('
        <?php 
        $navbar5 = new Navbar();
        $navbar5->setBrand("Brand")->setIsFluid()->setText("Signed in as Mark Otto");
        ?>');
        
        $navbar6 = new Navbar();
        $navbar6->setBrand("Brand")->setIsFluid();
        $link = new HtmlTag("a", array ("href" => "#", "class" => "navbar-link"));
        $navText = new Typography("p");
        $navText->setCustomClass(array("navbar-right", "navbar-text"))->setCdata("Signed in as " . $link->setText("Mark Otto")->render());
        $navbar6->setInnerElements($navText);
        
        $navbar7 = new Navbar();
        $navbar7->setBrand("Brand")->setItems(array (
            array ("text" => "Home", "url" => "#", "active" => true),
            array ("text" => "Link", "url" => "#"),
            array ("text" => "Link", "url" => "#")
        ))->setIsTop('static');
        $navbar7Code = $code->cloneInstance()->setText('
        <?php
        $navbar7 = new Navbar();
        $navbar7->setBrand("Brand")->setItems(array (
            array ("text" => "Home", "url" => "#", "active" => true),
            array ("text" => "Link", "url" => "#"),
            array ("text" => "Link", "url" => "#")
        ))->setIsTop();
        ');
        
        $navbar8 = clone $navbar7;
        $navbar8->setStyle("inverse")->setIsTop(false);
        
        $pageHeader9 = new PageHeader("Breadcrumbs");
        $bcrumbs = new Breadcrumb();
        $bcrumbMenu = array (
            new Crumb("Home", "#"),
            new Crumb("Library", "#"),
            new Crumb("Data", "#")
        );
        $bcrumbs->setItems($bcrumbMenu)->setHideAfter()->setActiveIndex(0);
        $bcrumbs2 = clone $bcrumbs;
        $bcrumbs2->setActiveIndex(1);
        $bcrumbs3 = clone $bcrumbs2;
        $bcrumbs3->stepForward();
        $bsExample2 = clone $bsExample;
        $bsExample2->setInnerElements(array ($bcrumbs, $bcrumbs2, $bcrumbs3));
        
        $pageHeader10 = new PageHeader("Pagination");
        $pagi = new Pagination();
        $pagi->setPages(5);
        if (isset($_REQUEST [Pagination::$PAGE_PARAM_NAME])) $pagi->setCurrentPage($_REQUEST [Pagination::$PAGE_PARAM_NAME]);
        
        $pagi2 = new Pagination();
        $pagi2->setPages(5)->setSize(5);
        $pagi3 = clone $pagi2;
        $pagi3->setSize(4);
        $pagi4 = clone $pagi3;
        $pagi4->setSize(3);
        $bsExample3 = clone $bsExample;
        $bsExample3->setInnerElements(array ($pagi2, $pagi3, $pagi4));
        
        $pagi5 = new Pagination();
        $pagi5->setPages(10)->setMode("pager");
        
        $pagi6 = new Pagination();
        $pagi6->setPages(10)->setMode("aligned-pager");
        
        $pageHeader11 = new PageHeader("Labels");
        $lbl1 = new Typography("h1");
        $lbl1->setInnerElements(array ("Example heading", new Label("New")));
        $lbl2 = new Typography("h2");
        $lbl2->setInnerElements(array ("Example heading", new Label("New")));
        $lbl3 = new Typography("h3");
        $lbl3->setInnerElements(array ("Example heading", new Label("New")));
        $lbl4 = new Typography("h4");
        $lbl4->setInnerElements(array ("Example heading", new Label("New")));
        $lbl5 = new Typography("h5");
        $lbl5->setInnerElements(array ("Example heading", new Label("New")));
        $lbl6 = new Typography("h6");
        $lbl6->setInnerElements(array ("Example heading", new Label("New")));
        $bsExample4 = $bsExample->cloneInstance()
        ->setInnerElements(array ($lbl1, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6));
        
        $lbld = new Label();
        $lbld->setColorSet("default")->setText("Default");
        $lblp = new Label();
        $lblp->setColorSet("primary")->setText("Primary");
        $lbls = new Label();
        $lbls->setColorSet("success")->setText("Success");
        $lbli = new Label();
        $lbli->setColorSet("info")->setText("Info");
        $lblw = new Label();
        $lblw->setColorSet("warning")->setText("Warning");
        $lblg = new Label();
        $lblg->setColorSet("danger")->setText("Danger");
        $bsExample5 = $bsExample->cloneInstance()
        ->setInnerElements(array ($lbld, $lblp, $lbls, $lbli, $lblw, $lblg));
        
        $pageHeader12 = new PageHeader("Badges");
        $inbox = new HtmlTag("a");
        $inbox->setInnerElements(array ("Inbox", new Badge("42")));
        $msgBtn = new Button();
        $msgBtn->setText("Messages")->setBadge(new Badge("4"))->setColorSet("primary");
        $bsExample6 = $bsExample->cloneInstance()
        ->setInnerElements(array ($inbox, "<br/>", $msgBtn));
        
        $nav9 = new Nav();
        $navItems = array (
            array ("text" => array ("Home", new Badge(42)), "url" => "#"),
            array ("text" => "Profile", "url" => "#"),
            new Navlet(array("Messages", new Badge(3)), "#")
        );
        $nav9->setActiveIndex(0)
        ->setItems($navItems)
        ->setStyle("pills");
        
        $pageHeader13 = new PageHeader("Jumbotron");
        $jbt = new Jumbotron();
        $jbtBtn = new Button();
        $jbtBtn->setText("Learn more")->setSize(5)->setColorSet("Primary");
        $jbt->setHeader("Hello, world!")
        ->setBodyContents(array (
            "This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.",
            $jbtBtn
        ));
        
        $pageHeader14 = new PageHeader("Page header");
        $pageHeader15 = new PageHeader("Example page header");
        $pageHeader15->setSubText("Subtext for header");
        
        $pageHeader16 = new PageHeader("Thumbnails");
        $rowThumbnails = new Row();
        $tn1 = new Thumbnail();
        $tn1->setSource("holder.js")->setWidth("100%")->setHeight("180")->setUrl("#")
        ->setAttrs(array ("data-holder-rendered" => "true"))->setAlt("100%x180");
        $rowThumbnails->setItems(array(
            new Grid($tn1, array ("col-xs-6", "col-md-3")),
            new Grid(clone $tn1, array ("col-xs-6", "col-md-3")),
            new Grid(clone $tn1, array ("col-xs-6", "col-md-3")),
            new Grid(clone $tn1, array ("col-xs-6", "col-md-3"))
        ));
        
        $rowThumbnails2 = new Row();
        $tn2 = new Thumbnail();
        $tn2->setSource("holder.js")->setWidth("100%")->setHeight("200")
        ->setAttrs(array ("data-holder-rendered" => "true"))->setAlt("100%x200");
        $captionH3 = new HtmlTag("h3");
        $captionH3->setText("Thumbnail label");
        $captionText = new HtmlTag("p");
        $captionText->setText("Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.");
        $captionBtns = new HtmlTag("p");
        $captionBtn1 = new Button();
        $captionBtn1->setText("Button")->setColorSet("default");
        $captionBtn2 = $captionBtn1->cloneInstance()->setColorSet("primary");
        $captionBtns->setInnerElements(array($captionBtn1, $captionBtn2));
        $tn2->setCaption(array($captionH3, $captionText, $captionBtns));
        $rowThumbnails2->setItems(array(
            new Grid($tn2, array ("col-sm-6", "col-md-4")),
            new Grid(clone $tn2, array ("col-sm-6", "col-md-4")),
            new Grid(clone $tn2, array ("col-sm-6", "col-md-4"))
        ));
        
        $pageHeader17 = new PageHeader("Alerts");
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
        $bsExample7 = $bsExample->cloneInstance()
        ->setInnerElements(array (
            $alert1, $alert2, $alert3, $alert4 
        ));
        
        $alert5 = $alert3->cloneInstance()->setIsDismissible();
        
        $alert6 = new Alert();
        $alert6->setInnerElements(array (
            new Typography("strong", array ("text" => "Well done!")), 
            "You successfully read ",
            new Typography("a", array ("text" => "this important alert message."))
        ));
        $alert7 = new Alert();
        $alert7->setInnerElements(array (
            new Typography("strong", array ("text" => "Heads up!")), 
            "This ",
            new Typography("a", array ("text" => "alert needs your attention")),
            ", but it's not super important."
        ))
        ->setColorSet("info");
        $alert8 = new Alert();
        $alert8->setInnerElements(array (
            new Typography("strong", array ("text" => "Warning!")), 
            "Best check yo self, you're ",
            new Typography("a", array ("text" => "not looking too good."))
        ))
        ->setColorSet("warning");
        $alert9 = new Alert();
        $alert9->setInnerElements(array (
            new Typography("strong", array ("text" => "Oh snap!")), 
            new Typography("a", array ("text" => "Change a few things up")),
            " and try submitting again."
            ))
        ->setColorSet("danger");
        $bsExample8 = $bsExample->cloneInstance()->setItems(array(
            $alert6, $alert7, $alert8, $alert9
        ));
        
        $pageHeader18 = new PageHeader("Progress bars");
        
        $pb = new ProgressBar();
        $pb->setNow(60);
        
        $pb2 = $pb->cloneInstance()->setText("60%");
        
        $pb3 = $pb->cloneInstance()->setNow(0)->setText("0%");
        $pb4 = $pb->cloneInstance()->setNow(2)->setText("2%");
        $bsExample9 = $bsExample->cloneInstance()->setItems(array (
            $pb3, $pb4 
        ));
        
        $pb5 = clone $pb;
        $pb5->setNow(40)
        ->setColorSet("success");
        $pb6 = clone $pb;
        $pb6->setNow(20)
        ->setColorSet("info");
        $pb7 = clone $pb;
        $pb7->setNow(60)
        ->setColorSet("warning");
        $pb8 = clone $pb;
        $pb8->setNow(80)
        ->setColorSet("danger");
        $bsExample10 = $bsExample->cloneInstance()->setInnerElements(array (
            $pb5, $pb6, $pb7, $pb8  
        ));
        
        $bsExample11 = clone $bsExample10;
        $bsExample11->getElement(0)->setIsStriped();
        $bsExample11->getElement(1)->setIsStriped();
        $bsExample11->getElement(2)->setIsStriped();
        $bsExample11->getElement(3)->setIsStriped();
        
        $pb9 = $pb->cloneInstance()->setIsStriped()->setIsAnimated();
        
        $pb10 = new ProgressBar();
        $pb10->setItems(array(
            new PgBar(35, "success", ""),
            new PgBar(20, "warning", "", true),
            new PgBar(10, "danger", "")
        ));
        
        $pageHeader19 = new PageHeader("Media object");
        $media = new Media();
        $mediaObject = new Thumbnail();
        $mediaObject->setSource("holder.js")->setWidth(64)->setHeight(64);
        $media->setMediaObject($mediaObject);
        $media->setBodyContents(array(
            new Typography("h4", array("text" => "Media heading")),
            "Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. " 
        ));
        $media2 = clone $media;
        $mediaNested = new Media();
        $mediaNested->setMediaObject($mediaObject);
        $mediaNested->setBodyContents(array(
            new Typography("h4", array("text" => "Nested Media heading")),
            "Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. "
        ));
        $media2->setBodyContents($mediaNested);
        $media3 = clone $media;
        $media3->setMediaObject($mediaObject->cloneInstance()->setAlign("right"));
        
        $media4 = clone $media;
        $media4->setMediaObject(array($mediaObject->cloneInstance()->setAlign("left"), $mediaObject->cloneInstance()->setAlign("right")));
        $bsExample14 = $bsExample->cloneInstance()->setInnerElements(array(
            $media, $media2, $media3, $media4 
        ));
        
        $media5 = new Media();
        $media5->setMediaObject($mediaObject->cloneInstance()->setVerticalAlign("top"));
        $media5->setBodyContents(array(
            new Typography("h4", array("text" => "Top aligned media")),
            "Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. ",
            "Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus."
        ));
        $media6 = new Media();
        $media6->setMediaObject($mediaObject->cloneInstance()->setVerticalAlign("middle"));
        $media6->setBodyContents(array(
            new Typography("h4", array("text" => "Middle aligned media")),
            "Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. ",
            "Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus."
        ));
        $media7 = new Media();
        $media7->setBodyContents(array(
            new Typography("h4", array("text" => "Bottom aligned media")),
            "Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. ",
            "Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus."
        ));
        $media7->setMediaObject($mediaObject->cloneInstance()->setVerticalAlign("bottom"));
        $bsExample15 = $bsExample->cloneInstance()->setInnerElements(array(
            $media5, $media6, $media7 
        ));
        
        $mediaList = new MediaList();
        $media8 = clone $media;
        $media8->setBodyContents(array($mediaNested->cloneInstance()->setBodyContents(clone $mediaNested), clone $mediaNested));
        $mediaList->setInnerElements(array($media8));
        
        $pageHeader20 = new PageHeader("List group");
        // @todo
        $lstGrp = new ListGroup();
        $lstGrp->setItems(array(
            new Listle("Cras justo odio"),
            new Listle("Dapibus ac facilisis in"),
            new Listle("Morbi leo risus"),
            new Listle("Porta ac consectetur ac"),
            new Listle("Vestibulum at eros")
        ));
        
        $lstGrp2 = new ListGroup();
        $lstGrp2->setItems(array(
            new Listle(array("Cras justo odio", new Badge(14))),
            new Listle(array("Dapibus ac facilisis in", new Badge(2))),
            new Listle(array("Morbi leo risus", new Badge(1))),
        ));
        
        $lstGrp3 = new ListGroup();
        $lstGrp3->setItems(array(
            new Listle("Cras justo odio", "#", true),
            new Listle("Dapibus ac facilisis in", "#"),
            new Listle("Morbi leo risus", "#"),
            new Listle("Porta ac consectetur ac", "#"),
            new Listle("Vestibulum at eros", "#")
        ));
        
        $lstGrp4 = new ListGroup();
        $lstGrp4->setMode("button")
        ->setItems(array(
            new Listle("Cras justo odio"),
            new Listle("Dapibus ac facilisis in"),
            new Listle("Morbi leo risus"),
            new Listle("Porta ac consectetur ac"),
            new Listle("Vestibulum at eros")
        ));
        
        $lstGrp5 = new ListGroup();
        $lstGrp5->setItems(array(
            new Listle("Cras justo odio", "#", false, true),
            new Listle("Dapibus ac facilisis in", "#"),
            new Listle("Morbi leo risus", "#"),
            new Listle("Porta ac consectetur ac", "#"),
            new Listle("Vestibulum at eros", "#")
        ));
        
        $lstGrp6 = new ListGroup();
        $lstGrp6->setItems(array(
            array("text" => "Dapibus ac facilisis in", "context" => "success"),
            array("text" => "Morbi leo risus", "context" => "info"),
            array("text" => "Porta ac consectetur ac", "context" => "warning"),
            array("text" => "Vestibulum at eros", "context" => "danger"),
        ));
        
        $lstGrp7 = new ListGroup();
        $lstGrp7->setItems(array(
            new Listle("Dapibus ac facilisis in", "#", false, false, "", "success"),
            new Listle("Morbi leo risus", "#", false, false, "", "info"),
            new Listle("Porta ac consectetur ac", "#", false, false, "", "warning"),
            new Listle("Vestibulum at eros", "#", false, false, "", "danger")
        ));
        $row9 = new Row();
        $row9->setItems(array(
            $lstGrp6, $lstGrp7 
        ));

        $lstGrp8 = new ListGroup();
        $lstGrp8->setItems(array(
            array("text" => "Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.", "heading" => "List group item heading", "active" => true),
            array("text" => "Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.", "heading" => "List group item heading"),
            array("text" => "Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.", "heading" => "List group item heading")
        ));
        
        $pageHeader21 = new PageHeader("Panels");
        $panel = new Panel();
        $panel->setBodyContents("Basic panel example ");
        
        $panel2 = new Panel();
        $panel2->setHeading("Panel title")
        ->setBodyContents("Panel content");
        
        $panel3 = new Panel();
        $panel3->setFooter("Panel footer")
        ->setBodyContents("Panel content");
        
        $panelPrimary = clone $panel2;
        $panelPrimary->setContextualClassPrimary();
        $panelSuccess = clone $panel2;
        $panelSuccess->setContextualClassSuccess();
        $panelInfo = clone $panel2;
        $panelInfo->setContextualClassInfo();
        $panelWarning = clone $panel2;
        $panelWarning->setContextualClassWarning();
        $panelDanger = clone $panel2;
        $panelDanger->setContextualClassDanger();
        $bsExample16 = $bsExample->cloneInstance()
        ->setInnerElements(array(
            $panelPrimary, $panelSuccess, $panelInfo, $panelWarning, $panelDanger 
        ));
        
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
        $panel4 = new Panel();
        $panel4->setHeading("Panel heading")
        ->setBodyContents("Some default panel content here. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Nullam id dolor id nibh ultricies vehicula ut id elit.")
        ->setInnerElements($table);
        
        $panel5 = new Panel();
        $panel5->setHeading("Panel heading")
        ->setInnerElements(clone $table);
        
        $panel6 = clone $panel4;
        $panel6->setElement(0, clone $lstGrp);
        
        $pageHeader22 = new PageHeader("Wells");
        $well11 = new Well();
        $well11->setInnerElements("Look, I'm in a well! ");
        $well12 = clone $well11;
        $well12->setSizeLg();
        $well13 = clone $well11;
        $well13->setSizeSm();
        
        //@todo final video embed
        
        
        // container
        $container = new Typography("div:container", null, array("role"=> "main"));
        $container->setInnerElements(array (
            $pageHeader,
            $well1,
            $pageHeader2, 
            $dropdownDiv->enclose(clone $bsExample),
            $dropupDiv->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Headers")), 
            $dropdownDiv2->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Disabled menu item")),
            $dropdownDiv3->enclose(clone $bsExample),
            $pageHeader3, 
            $btnGrp1->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Button toolbar")),
            $btnToolbar->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Sizing")),
            $well2, 
            new Typography("h2", array ("text" => "Nesting")),
            $btnGrp9->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Vertical variation")),
            $btnGrpVertical->enclose(clone $bsExample), 
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
            $form2->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Checkboxes and radio addons")),
            $form3->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Button addons")),
            $form4->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Buttons with dropdowns")),
            $form5->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Segmented buttons")),
            $form6->enclose(clone $bsExample), 
            new Typography("h2", array ("text" => "Multiple buttons")),
            $form7->enclose(clone $bsExample),  
            $pageHeader7,
            $nav1->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Pills")),
            $nav2->enclose(clone $bsExample),
            $nav3->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Justified")),
            $well8,
            new Typography("h2", array ("text" => "Disabled links")),
            $nav6->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Using dropdowns")),
            $nav7->enclose(clone $bsExample),
            $nav8->enclose(clone $bsExample),
            $pageHeader8,
            $navbar->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Brand image")),
            $navbar2->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Forms")),
            $navbar3->enclose(clone $bsExample), 
            new Typography("h2", array ("text" => "Buttons")),
            $navbar4->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Text")),
            $navbar5->enclose(clone $bsExample),
            // $navbar5Code, 
            new Typography("h2", array ("text" => "Non-nav links")),
            $navbar6->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Static")),
            $navbar7->enclose(clone $bsExample),
            // $navbar7Code,
            new Typography("h2", array ("text" => "Inverted navbar")),
            $navbar8->enclose(clone $bsExample),
            $pageHeader9,
            $bsExample2,
            $pageHeader10,
            $pagi->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Sizing")),
            $bsExample3,
            new Typography("h2", array ("text" => "Pager")),
            $pagi5->enclose(clone $bsExample), 
            $pagi6->enclose(clone $bsExample),
            $pageHeader11, 
            $bsExample4,
            $bsExample5,
            $pageHeader12,
            $bsExample6,
            $nav9->enclose(clone $bsExample),
            $pageHeader13,
            $jbt->enclose(clone $bsExample),
            $pageHeader14,
            $pageHeader15->enclose(clone $bsExample),
            $pageHeader16,
            $rowThumbnails->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Custom content")),
            $rowThumbnails2->enclose(clone $bsExample),
            $pageHeader17,
            $bsExample7,
            new Typography("h2", array ("text" => "Dismissible alerts")),
            $alert5->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Links in alerts")),
            $bsExample8,
            $pageHeader18,
            $pb->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "With label")),
            $pb2->enclose(clone $bsExample),
            $bsExample9,
            new Typography("h2", array ("text" => "Contextual alternatives")),
            $bsExample10,
            new Typography("h2", array ("text" => "Striped")),
            $bsExample11,
            new Typography("h2", array ("text" => "Animated")),
            $pb9->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Stacked")),
            $pb10->enclose(clone $bsExample),
            $pageHeader19,
            $bsExample14,
            new Typography("h2", array ("text" => "Media alignment")),
            $bsExample15,
            new Typography("h2", array ("text" => "Media list")),
            $mediaList->enclose(clone $bsExample),
            $pageHeader20,
            $lstGrp->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Badges")),
            $lstGrp2->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Linked items")),
            $lstGrp3->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Button items")),
            $lstGrp4->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Disabled items")),
            $lstGrp5->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Contextual classes")),
            $row9->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Custom content")),
            $lstGrp8->enclose(clone $bsExample),
            $pageHeader21,
            $panel->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Panel with heading")),
            $panel2->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Panel with footer")),
            $panel3->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Contextual alternatives")),
            $bsExample16,
            new Typography("h2", array ("text" => "With tables")),
            $panel4->enclose(clone $bsExample),
            $panel5->enclose(clone $bsExample),
            $panel6->enclose(clone $bsExample),
            $pageHeader22,
            $well11->enclose(clone $bsExample),
            new Typography("h2", array ("text" => "Optional classes")),
            $well12->enclose(clone $bsExample),
            $well13->enclose(clone $bsExample)
        ));
        // bootstrap palette
        $btPanel->setBodyContents(array($container));
        
        $btPanel->render(true);
        var_dump(Typography::getErrMsg());
        // echo "Memory usage(real): " . memory_get_usage(true);
    }
    
}

