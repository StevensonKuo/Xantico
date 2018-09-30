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
use model\bootstrap\basic\ListGroup;
use model\bootstrap\basic\Panel;
use model\bootstrap\basic\Carousel;
use model\bootstrap\basic\Well;
use model\bootstrap\basic\Form;
use model\bootstrap\basic\PageHeader;
use model\bootstrap\basic\Row;
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
use model\bootstrap\basic\Pagination;
use model\bootstrap\basic\Media;
use model\bootstrap\basic\MediaList;
use model\bootstrap\plugins\Video;


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
            ->appendBodyContents("This is a template showcasing the optional theme stylesheet included in Bootstrap. Use it as a starting point to create something more unique by building on or modifying it.");
        
        // pager-header
        $ph = new Typography("div:page-header");
        $ph->appendInnerElements(new Typography("h1", array ("innerText" => "Buttons")));
        // 大按鈕
        $lbl = new Button();
        $lbl->setContext("default")
        ->setText("Default")
        ->setSize(5);
        $lbl2 = clone $lbl;
        $lbl2->setContext("primary")->setText("Primary");
        $lbl3 = clone $lbl;
        $lbl3->setContext("success")->setText("Success");
        $lbl4 = clone $lbl;
        $lbl4->setContext("info")->setText("Info");
        $lbl5 = clone $lbl;
        $lbl5->setContext("warning")->setText("Warning");
        $lbl6 = clone $lbl;
        $lbl6->setContext("danger")->setText("Danger");
        $lbl7 = clone $lbl;
        $lbl7->setIsLink()->setText("Link");
        $p1 = new Typography("p");
        $p1->appendInnerElements(array($lbl, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6, $lbl7));
        
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
        $ph2->appendInnerElements(new Typography("h1", array ("innerText" => "Tables")));
        
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
        $row->appendInnerElements(array($column->appendInnerElements($table), $column2->appendInnerElements($table2)));
        $row2->appendInnerElements(array($column3->appendInnerElements($table3), $column4->appendInnerElements($table4)));
        
        $ph3 = new Typography("div:page-header");
        $ph3->appendInnerElements(new Typography("h1", array ("innerText" => "Thumbnails")));
        
        $thumbnail = new Image("thumbnail");
        $thumbnail->setSource("holder.js")
        ->setAlt("A generic square placeholder image with a white border around it, making it resemble a photograph taken with an old instant camera");
                
        
        $ph4 = new Typography("div:page-header");
        $ph4->appendInnerElements(new Typography("h1", array ("innerText" => "Labels")));

        $lbl = new Label("Default");
        $lbl2 = clone $lbl;
        $lbl2->setContext("primary")->setText("Primary");
        $lbl3 = clone $lbl;
        $lbl3->setContext("success")->setText("Success");
        $lbl4 = clone $lbl;
        $lbl4->setContext("info")->setText("Info");
        $lbl5 = clone $lbl;
        $lbl5->setContext("warning")->setText("Warning");
        $lbl6 = clone $lbl;
        $lbl6->setContext("danger")->setText("Danger");
        
        $p5 = new Typography("h1");
        $p5->appendInnerElements(array($lbl, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6));
        
        $p6 = new Typography("h2");
        $p6->appendInnerElements(array ($lbl, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6));
        
        $p7 = new Typography("h3");
        $p7->appendInnerElements(array ($lbl, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6));
        
        $p8 = new Typography("h4");
        $p8->appendInnerElements(array ($lbl, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6));
        
        $p9 = new Typography("h5");
        $p9->appendInnerElements(array ($lbl, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6));
        
        $p10 = new Typography("h6");
        $p10->appendInnerElements(array ($lbl, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6));
        
        $p11 = new Typography("p");
        $p11->appendInnerElements(array ($lbl, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6));
        
        $ph5 = new Typography("div:page-header");
        $ph5->appendInnerElements(new Typography("h1", array ("innerText" => "Badges")));
        $a = new Typography("a");
        $a->appendInnerElements(array ("Inbox", new Badge("42")));
        $p12 = new Typography("p");
        $p12->appendInnerElements($a);
        $nav = new Nav();
        $navItems = array (
            array ("text" => array ("Home", new Badge(42)), "url" => "#"),
            array ("text" => "Profile", "url" => "#"),
            array ("text" => array("Messages", new Badge(3)), "url" => "#")
        );
        $nav->setActiveIndex(0) 
            ->appendItems($navItems)
            ->setStyle("pills");
        
        $ph6 = new Typography("div:page-header");
        $ph6->appendInnerElements(new Typography("h1", array ("innerText" => "Dropdown Menus")));
        
        $ddDiv = new Typography("div:dropdown");
        $ddDiv->appendCustomClass(array ("theme-dropdown", "clearfix"));
        $dropdown = new Dropdown();
        $ddItems = array (
            array ("text" => "Action", "url" => "#"),
            array ("text" => "Another action", "url" => "#"), 
            array ("text" => "Something else here", "url" => "#"),
            array ("seperator" => true), 
            array ("text" => "Seperated link", "url" => "#") 
        );
        $dropdown->setMode("inline")->getButton()->setCustomClass("sr-only");
        $dropdown->appendItems($ddItems)
            ->setText ("Dropdown") 
            ->setMode("dropdown")
            ->setActiveIndex (0);
        $ddDiv->appendInnerElements($dropdown);
        
        $ph7 = new Typography("div:page-header");
        $ph7->appendInnerElements(new Typography("h1", array ("innerText" => "Navs")));
        $navItems = array (
            array ("text" => "Home", "url" => "#"),
            array ("text" => "Profile", "url" => "#"),
            array ("text" => "Messages", "url" => "#")
        );
        $nav3 = new Nav();
        $nav3->appendItems($navItems)
            ->setActiveIndex(0) 
            ->setStyle("tabs");
        $nav4 = clone $nav3;
        $nav4->setStyle("pills");
        
        $ph8 = new Typography("div:page-header");
        $ph8->appendInnerElements(new Typography("h1", array ("innerText" => "Navbars")));
        
        array_pop($ddItems);
        $ddItems [] = array ("text" => "Nav header", "url" => "#", "head" => true); 
        $ddItems [] = array ("text" => "Separated link", "url" => "#");
        $ddItems [] = array ("text" => "One more separated link", "url" => "#");
        $innerDropdown = new Dropdown();
        $innerDropdown->setMode("inline")
        ->setText(array ("Dropdown", new Typography("span:caret")))
        ->setItems($ddItems);
        
        $nvbItems = array (
            array ("text" => "Home", "url" => "#"),
            array ("text" => "About", "url" => "#"), // 要有 url 才有 anchor tag, 不然長像不對
            array ("text" => "Contact", "url" => "#"),
            $innerDropdown 
        );

        $navbar = new Navbar();
        $navbar->setBrand("Bootstrap theme")
        ->setActiveIndex(0)
        ->setCollapseButton() 
        ->appendItems($nvbItems);
        
        $nvbItems [3] = $innerDropdown;
        $navbar2 = clone $navbar;
        $navbar2->setStyle("inverse")
        ->setItems($nvbItems);
        
        $navbar3 = clone $navbar2;
        $navbar3->setIsTop(true) 
        ->setItems($nvbItems);
        
        $ph9 = new Typography("div:page-header");
        $ph9->appendInnerElements(new Typography("h1", array ("innerText" => "Alerts")));
        
        $alert1 = new Alert();
        $alert1->appendInnerElements(array (new Typography("strong", array ("innerText" => "Well done!")), "You successfully read this important alert message."));
        $alert2 = new Alert();
        $alert2->appendInnerElements(array (new Typography("strong", array ("innerText" => "Heads up!")), "This alert needs your attention, but it's not super important."))
        ->setContext("info");
        $alert3 = new Alert();
        $alert3->appendInnerElements(array (new Typography("strong", array ("innerText" => "Warning!")), "Best check yo self, you're not looking too good."))
        ->setContext("warning");
        $alert4 = new Alert();
        $alert4->appendInnerElements(array (new Typography("strong", array ("innerText" => "Oh snap!")), "Change a few things up and try submitting again."))
        ->setContext("danger");
        
        $phA = new Typography("div:page-header");
        $phA->appendInnerElements(new Typography("h1", array ("innerText" => "Progress Bars")));
        
        $pb = new ProgressBar();
        $pb->setNow(60);
        
        $pb2 = clone $pb;
        $pb2->setNow(40)
        ->setContext("success");
        
        $pb3 = clone $pb;
        $pb3->setNow(20)
        ->setContext("info");
        
        $pb4 = clone $pb;
        $pb4->setNow(60)
        ->setContext("warning");
        
        $pb5 = clone $pb;
        $pb5->setNow(80)
        ->setContext("danger");
        
        $pb6 = clone $pb;
        $pb6->setNow(60)
        ->setIsStriped();
        
        $pb7 = clone $pb;
        $pb7->appendItems(array(
            array ("now" => 35, "context" => "success"), 
            array ("now" => 20, "context" => "warning"),
            array ("now" => 10, "context" => "danger")
        ));
        
        $phB = new Typography("div:page-header");
        $phB->appendInnerElements(new Typography("h1", array ("innerText" => "List groups")));
        
        $listGroup = new ListGroup();
        $listGroup->appendItems(array (
            "Cras justo odio",
            "Dapibus ac facilisis in",
            "Morbi leo risus",
            "Porta ac consectetur ac",
            "Vestibulum at eros" 
        ));
        $lgDiv1 = new Typography("div:col-sm-4");
        $lgDiv1->appendInnerElements($listGroup);
        
        $listGroup2 = clone $listGroup;
        $listGroup2->setItems(array (
            array("text" => "Cras justo odio", "url" => "#", "active" => true),
            array("text" => "Dapibus ac facilisis in", "url" => "#"),
            array("text" => "Morbi leo risus", "url" => "#"),
            array("text" => "Porta ac consectetur ac", "url" => "#"),
            array("text" => "Vestibulum at eros", "url" => "#")
        ));
        $lgDiv2 = new Typography("div:col-sm-4");
        $lgDiv2->appendInnerElements($listGroup2);
        
        $listGroup3 = new ListGroup();
        $listGroup3->appendItems(array (
            array("text" => "Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.", "url" => "#", 'active' => true, "heading" => "List group item heading"),
            array("text" => "Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.", "url" => "#", "heading" => "List group item heading"),
            array("text" => "Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.", "url" => "#", "heading" => "List group item heading"),
        ));
        $lgDiv3 = new Typography("div:col-sm-4");
        $lgDiv3->appendInnerElements($listGroup3);
        
        $lgRow = new Typography("div:row");
        $lgRow->appendInnerElements($lgDiv1, $lgDiv2, $lgDiv3);
        
        $phC = new Typography("div:page-header");
        $phC->appendInnerElements(new Typography("h1", array ("innerText" => "Panels")));
        
        $panel = new Panel();
        $panel->setHeading("Panel title")
        ->appendBodyContents("Panel content")
        ->setContext("default");
        $plDiv1 = new Typography("div:col-sm-4");
        $plDiv1->appendInnerElements($panel);
        $panel2 = clone $panel;
        $panel2->setContext("primary");
        $plDiv2 = new Typography("div:col-sm-4");
        $plDiv2->appendInnerElements($panel2);
        $panel3 = clone $panel;
        $panel3->setContext("success");
        $plDiv3 = new Typography("div:col-sm-4");
        $plDiv3->appendInnerElements($panel3);
        $panel4 = clone $panel;
        $panel4->setContext("info");
        $plDiv4 = new Typography("div:col-sm-4");
        $plDiv4->appendInnerElements($panel4);
        $panel5 = clone $panel;
        $panel5->setContext("warning");
        $plDiv5 = new Typography("div:col-sm-4");
        $plDiv5->appendInnerElements($panel5);
        $panel6 = clone $panel;
        $panel6->setContext("danger");
        $plDiv6 = new Typography("div:col-sm-4");
        $plDiv6->appendInnerElements($panel6);
        $plRowDiv = new Typography("div:row");
        $plRowDiv->appendInnerElements(array ($plDiv1, $plDiv2, $plDiv3, $plDiv4, $plDiv5, $plDiv6));
        
        $phD = new Typography("div:page-header");
        $phD->appendInnerElements(new Typography("h1", array ("innerText" => "Wells")));
        
        $well = new Well();
        $text = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sed diam eget risus varius blandit sit amet non magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Aenean lacinia bibendum nulla sed consectetur.";
        $well->setText($text);
        
        $phE = new Typography("div:page-header");
        $phE->appendInnerElements(new Typography("h1", array ("innerText" => "Carousel")));
        
        $caro = new Carousel();
        $caro->appendItems(array (
            array("source" => "holder.js/1140x500/auto/#777:#555/text:First slide", "active" => true),
            array("source" => "holder.js/1140x500/auto/#666:#444/text:Second slide"),
            array("source" => "holder.js/1140x500/auto/#555:#333/text:Third slide")
        ));
        
        $container = new Typography("div:container", null, array("role"=> "main"));
        $container->appendInnerElements(array ($jumbotron)) 
            ->appendCustomClass("theme-showcase")
            ->appendInnerElements(array ($ph, $p1, $p2, $p3, $p4)) 
            ->appendInnerElements(array ($ph2, $row, $row2))
            ->appendInnerElements(array ($ph3, $thumbnail))
            ->appendInnerElements(array ($ph4, $p5, $p6, $p7, $p8, $p9, $p10, $p11))
            ->appendInnerElements(array ($ph5, $p12, $nav))
            ->appendInnerElements(array ($ph6, $ddDiv))
            ->appendInnerElements(array ($ph7, $nav3, $nav4))
            ->appendInnerElements(array ($ph8, $navbar, $navbar2))
            ->appendInnerElements(array ($ph9, $alert1, $alert2, $alert3, $alert4))
            ->appendInnerElements(array ($phA, $pb, $pb2, $pb3, $pb4, $pb5, $pb6, $pb7))
            ->appendInnerElements(array ($phB, $lgRow))
            ->appendInnerElements(array ($phC, $plRowDiv))
            ->appendInnerElements(array ($phD, $well))
            ->appendInnerElements(array ($phE, $caro));
        
                
        $btPanel->appendBodyContents(array($navbar3, $container));
        
//         echo Typography::getErrMsg();
        $btPanel->render(true);
        // echo "Memory usage(real): " . memory_get_usage(true);
    }
    
    /**
     * @desc basic example. [Typography, grid system etc...
     */
    public function defaultView () {
        $btPanel = new Xantico();
        $btPanel->setIsLoadBootstrapFromCDN()->setIsLoadJQueryFromCDN()
        ->setCustomCSSFiles('https://getbootstrap.com/docs/3.3/assets/css/docs.min.css')
        ->setCustomScriptsFiles('https://v3.bootcss.com/assets/js/docs.min.js');
        
        // Forms here.
        $bsExample = new Typography("div:bs-example");
        $code = new Code();
        
        $pageHeader_1 = new PageHeader("Grid system");
        $row1 = new Row();
        $row1->appendCustomClass("show-grid")
        ->setItems(array (
            array("text" => ".col-md-1", "width" => 1),
            array("text" => ".col-md-1", "width" => 1),
            array("text" => ".col-md-1", "width" => 1),
            array("text" => ".col-md-1", "width" => 1),
            array("text" => ".col-md-1", "width" => 1),
            array("text" => ".col-md-1", "width" => 1),
            array("text" => ".col-md-1", "width" => 1),
            array("text" => ".col-md-1", "width" => 1),
            array("text" => ".col-md-1", "width" => 1),
            array("text" => ".col-md-1", "width" => 1),
            array("text" => ".col-md-1", "width" => 1),
            array("text" => ".col-md-1", "width" => 1) 
        ));
        $row2 = new Row();
        $row2->appendCustomClass("show-grid")
        ->setItems(array(
            array("text" => ".col-md-8", "width" => 8),
            array("text" => ".col-md-4", "width" => 4)
        ));
        $row3 = new Row();
        $row3->appendCustomClass("show-grid")
        ->setItems(array (
            array("text" => ".col-md-4", "width" => 4),
            array("text" => ".col-md-4", "width" => 4),
            array("text" => ".col-md-4", "width" => 4)
        ));
        $row4 = new Row();
        $row4->appendCustomClass("show-grid")
        ->setColumns(array (
            array("text" => ".col-md-6", "width" => 6),
            array("text" => ".col-md-6", "width" => 6)
        ));
        $bsExample2 = clone $bsExample;
        $bsExample2->setInnerElements(array (
            $row1,
            $row2,
            $row3,
            $row4 
        ));
        
        $row5 = new Row();
        $row5->appendCustomClass("show-grid")
        ->setColumns(array (
            array("text" => ".col-xs-12 .col-md-8", "width" => array ("col-xs-12", "col-md-8")),
            array("text" => ".col-xs-6 .col-md-4", "width" => array ("col-xs-6", "col-md-4")),
        ));
        $row6 = new Row();
        $row6->appendCustomClass("show-grid")
        ->setColumns(array (
            array("text" => ".col-xs-6 .col-md-4", "width" => array ("col-xs-6", "col-md-4")),
            array("text" => ".col-xs-6 .col-md-4", "width" => array ("col-xs-6", "col-md-4")),
            array("text" => ".col-xs-6 .col-md-4", "width" => array ("col-xs-6", "col-md-4"))
        ));
        $row7 = new Row();
        $row7->appendCustomClass("show-grid")
        ->setDefaultScreenSize("xs")
        ->setColumns(array (
            array("text" => ".col-xs-6", "width" => 6),
            array("text" => ".col-xs-6", "width" => 6)
        ));
        $bsExample3 = clone $bsExample;
        $bsExample3->setInnerElements(array (
            $row5, $row6, $row7 
        ));
        
        $row8 = new Row();
        $row8->appendCustomClass("show-grid")
        ->setColumns(array (
            array("text" => "col-md-4", "width" => 4),
            array("text" => "col-md-4 col-md-offset-4", "width" => 4, "offset" => 4),
        ));
        $row9 = new Row();
        $row9->appendCustomClass("show-grid")
        ->setColumns(array (
            array("text" => ".col-md-3 .col-md-offset-3", "width" => 3, "offset" => 3),
            array("text" => ".col-md-3 .col-md-offset-3", "width" => 3, "offset" => 3)
        ));
        $row10 = new Row();
        $row10->appendCustomClass("show-grid")
        ->setColumns(array (
            array("text" => ".col-md-6 .col-md-offset-3", "width" => 6, "offset" => 3)
        ));
        $bsExample4 = $bsExample->cloneInstance()
        ->setInnerElements(array(
            $row8, $row9, $row10 
        ));
        
        $pageHeader_2 = new PageHeader("Typography");
        $h1 = new Typography("h1", array("innerText" => "h1. Bootstrap heading"));
        $h2 = new Typography("h2", array("innerText" => "h2. Bootstrap heading"));
        $h3 = new Typography("h3", array("innerText" => "h3. Bootstrap heading"));
        $h4 = new Typography("h4", array("innerText" => "h4. Bootstrap heading"));
        $h5 = new Typography("h5", array("innerText" => "h5. Bootstrap heading"));
        $h6 = new Typography("h6", array("innerText" => "h6. Bootstrap heading"));
        $bsExample5 = $bsExample->cloneInstance()
        ->setInnerElements(array (
            $h1, $h2, $h3, $h4, $h5, $h6 
        ));
        
        $pLead = new Typography("p");
        $pLead->setIsLead()
        ->setInnerText("Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus.");
        
        $pLeft = new Typography("p");
        $pLeft->setTextAlign("left")
        ->setText("Left aligned text.");
        $pCenter = new Typography("p");
        $pCenter->setTextAlign("center")
        ->setText("Center aligned text.");
        $pRight = new Typography("p");
        $pRight->setTextAlignRight()
        ->setText("Right aligned text.");
        $pJustify = new Typography("p");
        $pJustify->setTextAlignJustify()
        ->setText("Justified text.");
        $pNowrap = new Typography("p");
        $pNowrap->setTextAlignNowrap()
        ->setText("No wrap text.");
        $bsExample6 = $bsExample->cloneInstance()
        ->setInnerElements(array (
            $pLeft, $pCenter, $pRight, $pJustify, $pNowrap 
        ));
        
        $pLower = new Typography("p");
        $pLower->setTextTransform("lowercase")
        ->setText("Lowercased text.");
        $pUpper = new Typography("p");
        $pUpper->setTextTransform("uppercase")
        ->setText("Uppercased text.");
        $pCap = new Typography("p");
        $pCap->setTextTransform("capitalize")
        ->setText("capitalized text.");
        $bsExample7 = $bsExample->cloneInstance()
        ->setInnerElements(array (
            $pLower, $pUpper, $pCap 
        ));
        
        $list = new Typography("ul");
        $listNested = new Typography("ul");
        $listNested->setItems(array (
            "Phasellus iaculis neque",
            "Purus sodales ultricies",
            "Vestibulum laoreet porttitor sem",
            "Ac tristique libero volutpat at",
        ));
        $list->setItems(array (
            "Lorem ipsum dolor sit amet",
            "Consectetur adipiscing elit",
            "Integer molestie lorem at massa",
            "Facilisis in pretium nisl aliquet",
            array ("Nulla volutpat aliquam velit", $listNested),
            "Faucibus porta lacus fringilla vel",
            "Aenean sit amet erat nunc",
            "Eget porttitor lorem",
        ));
        
        $listUnstyled = clone $list;
        $listUnstyled->setIsListUnstyled();
        
        // Lorem ipsum Phasellus iaculis Nulla volutpat
        $listInline = new Typography("ul");
        $listInline->setIsListInline()
        ->setItems(array (
            "Lorem ipsum", "Phasellus iaculis", "Nulla volutpat"
        ));
        
        $pageHeader_3 = new PageHeader("Code");
        $codeInline = new HtmlTag("code");
        $codeInline->setInnerText("<section>");
        $codeSection = new HtmlTag("p");
        $codeSection->setInnerHtml("For example, $codeInline should be wrapped as inline.");
        $codeUserInput = new HtmlTag("kbd");
        $codeUserInput->setInnerText("cd");
        $codeUserInput2 = new HtmlTag("kbd");
        $codeUserInput2->setInnerText("ctrl + ,");
        $sectionUserInput = new HtmlTag("p");
        $sectionUserInput->setInnerHtml(
            "To switch directories, type $codeUserInput followed by the name of the directory.<br>
            To edit settings, press $codeUserInput2");
        
        $phpCode = new Code('
            <?php
            $codeInline = new HtmlTag("code");
            $codeInline->setInnerText("<section>");
            $codeSection = new HtmlTag("p");
            $codeSection->setInnerHtml("For example, $codeInline should be wrapped as inline.");
            ?>
        ');
        
        $pageHeader_4 = new PageHeader("Tables");
        $table1 = new Table();
        $table1->setCaption("Optional table caption.");
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
        $table1->setHeaders($tableHeaders)->setCells($tableCells);
        
        $table2 = new Table();
        $tableHeaders2 = array (
            "#", "Column heading", "Column heading", "Column heading"
        );
        $tableCells2 = array (
            array("isActive" => true, "td" => array (1, "Column content", "Column content", "Column content")),
            array (2, "Column content", "Column content", "Column content"),
            array("context" => "success", "td" => array (3, "Column content", "Column content", "Column content")),
            array("td" => array (4, "Column content", "Column content", "Column content")),
            array("context" => "info", "td" => array (5, "Column content", "Column content", "Column content")),
            array("td" => array (6, "Column content", "Column content", "Column content")),
            array("context" => "warning", "td" => array (7, "Column content", "Column content", "Column content")),
            array("td" => array (8, "Column content", "Column content", "Column content")),
            array("context" => "danger", "td" => array (9, "Column content", "Column content", "Column content")),
        );
        $table2->setHeaders($tableHeaders2)->setCells($tableCells2);
        
        $table3 = new Table();
        $tableHeaders3 = array (
            "#", "Table heading", "Table heading", "Table heading", "Table heading", "Table heading", "Table heading"
        );
        $tableCells3 = array (
            array (1, "Table cell", "Table cell", "Table cell", "Table cell", "Table cell", "Table cell"),
            array (2, "Table cell", "Table cell", "Table cell", "Table cell", "Table cell", "Table cell"),
            array (3, "Table cell", "Table cell", "Table cell", "Table cell", "Table cell", "Table cell")
        );
        $table3->setHeader($tableHeaders3)->setCells($tableCells3);
        $divTable = new Typography("div");
        $divTable->setInnerElements($table3->setIsResponsive());
        $divTable2 = new Typography("div");
        $divTable2->setInnerElements($table3->cloneInstance()->setIsBordered());
        $bsExample8 = $bsExample->cloneInstance()->setInnerElements(array (
            $divTable, $divTable2 
        ));
        
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
        ->appendInnerElements(array ($inputEmail, $inputPwd, $check));
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
        
        $form2->appendInnerElements(array ($inputEmail2, $inputSelect, $inputSelect2, $textarea));
        
        // file input
        $form3 = new Form();
        $inputFile = new Input("file");
        $inputFile->setId("exampleFormControlFile1")
        ->setCaption("Example file input");
        $form3->appendInnerElements($inputFile);
        
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
        
        $form4->appendInnerElements(array ($inputRO));
        
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
        
        $form5->appendInnerElements(array ($inputPlain, $inputPwd2));
        
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
        $form7->appendInnerElements($checkbox1);
        
        // radio
        $form8 = new Form();
        $radio1 = new Input("radio");
        $radio1->setOptions(array ("Default radio", "Second default radio", "Disabled radio"))
        ->setDisabledOption(array (2))
        ->setName("exampleRadios");
        $form8->appendInnerElements($radio1);
        
        // inline checkbox @todo bs 4.0
        $form9 = new Form();
        $checkbox2 = new Input("checkbox");
        $checkbox2->setOptions(array ("option1" => "1", "option2" => "2", "option3" => "3 (disabled)"))
        ->setDisabledOption(array ("option3"))
        ->setIsStacked(false);
        $form9->appendInnerElements($checkbox2);
        
        // without labels
        $form10 = new Form();
        $checkboxNoLbl = new Input("checkbox");
        $checkboxNoLbl->setOptions(array ("option1" => ""))
        ->appendCustomClass("position-static");
        $radioNoLbl = new Input ("radio");
        $radioNoLbl->setOptions(array ("option1" => ""))
        ->setName("blankRadio");
//         ->appendCustomClass("position-static"); // @todo bs 4.0... I don't catch this.
        $form10->appendInnerElements(array ($checkboxNoLbl, $radioNoLbl));
        
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
        $form11->appendInnerElements(array ($input1, $input2));
        
        // form grid
        $form12 = new Form();
        $inputFirstName = new Input();
        $inputFirstName->setPlaceholder("First name");
        $inputLastName = new Input();
        $inputLastName->setPlaceholder("Last name");
        $formRow = new Row();
        $formRow->appendItems(array ($inputFirstName, $inputLastName));
        $form12->appendInnerElements($formRow);
        $form12Well = clone $bsExample;
        $form12Well->appendInnerElements($form12);
        
        // a complex example
        $form13 = new Form();
        $inputEmail3 = new Input("email", array ("caption" => "Email"), array ("id" => "inputEmail4", "placeholder" => "Email"));
        $inputPwd3 = new Input("password", array ("caption" => "Password"), array ("id" => "inputPassword4", "placeholder" => "Password", ));
        $formRow2 = new Row();
        $formRow2->appendItems(array ($inputEmail3, $inputPwd3));
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
        $formRow3->appendItems(array (
            array ("text" => $inputCity, "width" => 6),
            array ("text" => $selectState, "width" => 4),
            array ("text" => $inputZip, "width" => 2)
        ));
        $check2 = new Input("checkbox");
        $check2->setOptions(array ("Check me out"))
        ->setId("gridCheck");
        $form13->appendInnerElements($formRow2, $inputAddress, $inputAddress2, $formRow3, $check2);
        $btnSignin = new Button();
        $btnSignin->setIsSubmit()
        ->setContext("primary")
        ->setText("Sign in");
        $form13->setFormAction($btnSignin);
        $form13Well = clone $bsExample;
        $form13Well->appendInnerElements($form13);
        
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
        $form14->appendInnerElements(array ($inputEmail4, $inputPwd4, $radio2, $check3))
        ->setFormAction(clone $btnSignin)
        ->setLabelRatio("2:10");
        $form14Well = clone $bsExample;
        $form14Well->appendInnerElements($form14);
        
        // inline form with grid
        $form15 = new Form();
        $inputName = new Input();
        $inputName->setPlaceholder("Jane Doe")
        ->setCaption("Name")
        ->setId("inlineFormInput");
        $inputUserGrp = new InputGroup();
        $inputUserGrp->setLeftAddon("@")
        ->setCaption("Username")
        ->setId("inlineFormInputGroup")
        ->setPlaceHolder ("Username");
        $check4 = new Input("checkbox");
        $check4-> setOptions(array ("Remember me"));
        $btn = new Button();
        $btn->setIsSubmit()->setText("Submit")->setContext("primary");
        $formRow4 = new Row();
        $formRow4->appendItems(array(
            array ("text" => $inputName, "width" => 4),
            array ("text" => $inputUserGrp, "width" => 4),
            array ("text" => $check4, "width" => 2),
            array ("text" => $btn, "width" => 2)
        ))
        ->appendCustomClass("align-items-center");
        $form15Well = $form15->appendInnerElements(array ($formRow4))
        ->setFormType("inline")->enclose(clone $bsExample);
        
        // direct set form to inline
        $form16 = new Form();
        $form16->appendInnerElements(array (clone $inputName, clone $inputUserGrp, clone $check4))
        ->setFormType("inline")
        ->setFormAction(clone $btn);
        $form16Well = clone $bsExample;
        $form16Well-> appendInnerElements($form16);
        
        // inline form with select, this one failed, but you can insert the checkbox and button into a row before.
        $form17 = new Form();
        $select = new Select();
        $select->setCaption("Preference")
        ->setOptions(array ("Choose...", "One", "Two", "Three"))
        ->setId("inlineFormCustomSelectPref");
        $check5 = new Input("checkbox");
        $check5->setOptions(array ("Remember my preference"))
        ->setId("customControlInline");
        $form17Well = $form17->appendInnerElements(array ($select, $check5))
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
        $form18Well = $form18->appendInnerElements($inputPwd5)->enclose(clone $bsExample);
        
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
        ->appendInnerElements(array ($inputDisabled, $selectDisabled, $checkDisabled))
        ->enclose(clone $bsExample);
        
        $pageHeader6 = new PageHeader("Validation");
        Input::$AUTO_NAMING = true;
//         Input::$FORM_VALIDATION_METHOD = "browser";
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
        $inputGrp2 = new InputGroup();
        $inputGrp2->setPlaceholder("Username")
        ->setId("validationCustomUsername")
        ->setIsRequired()
        ->setLeftAddon(array ("@"))
        ->setCaption("Username");
        $formRow5 = new Row();
        $formRow5->setForForm()
        ->appendItems(array ($inputFirstName, $inputLastName, $inputGrp2));
        $formRow6 = clone $formRow3;
        $rowGrids = $formRow6->getItems();
        $rowGrids[0]['text']->setCaption("City")->setIsRequired()->setPlaceHolder("City");
        $rowGrids[1]['text'] = new Input();
        $rowGrids[1]['text']->setPlaceHolder("State")->setCaption("State")->setIsRequired()->setId("inputState");
        $rowGrids[1]['width'] = 3;
        $rowGrids[2]['text']->setIsRequired()->setPlaceHolder("Zip");
        $rowGrids[2]['width'] = 3;
        $check6 = new Input("checkbox");
        $check6->setOptions(array("Agree to terms and conditions "))
        ->setIsRequired();
        $btn2 = new Button();
        $btn2->setIsSubmit()
        ->setContext("primary")
        ->setText("Submit form");
        $form21->appendInnerElements(array ($formRow5, $formRow6, $check6))
        ->setRequireIcon(null)
        ->setFormAction($btn2);
        // server-side validation @todo bs 4.0.0
        /*
        $form22 = new Form();
        $form22->appendCustomClass("was-validated");
        $checkValid = new Input("checkbox");
        $checkValid->setIsRequired()
        ->appendCustomClass("is-invalid")
        ->setId("customControlValidation1")
        ->setOptions (array ("Check this custom checkbox"))
        ->setHelp(new Typography("div:text-danger", array ("innerText" => "Example invalid feedback text"))); // invalid-feedback
        $radioValid = new Input("radio");
        $radioValid->setIsRequired()
        ->setId("customControlValidation2")
        ->setOptions(array ("Toggle this custom radio", "Or toggle this other custom radio"))
        ->setHelp(new Typography("div:text-danger", array ("innerText" => "More example invalid feedback text")));
        $selectValid = new Select ();
        $selectValid->setOptions(array ("Open this select menu", "One", "Two", "Three"))
        ->setIsRequired()
        ->setHelp(new Typography("div:text-danger", array ("innerText" => "Example invalid custom select feedback")))
        ->appendCustomClass(array("is-invalid"));
        $fileValid = new Input("file");
        $fileValid->setIsRequired()
        ->appendCustomClass("is-invalid")
        ->setHelp(new Typography("div:text-danger", array ("innerText" => "Example invalid custom file feedback")));
        $form22->appendInnerElements(array ($checkValid, $radioValid, $selectValid, $fileValid));
        */
        $form22 = new Form();
        $inputVldt = new Input();
        $inputVldt->setCaption("Input with success")
        ->setValidationState("success")
        ->setHasFeedback(false)
        ->setId("inputSuccess1")
        ->setHelp("A block of help text that breaks onto a new line and may extend beyond one line.");
        $inputVldt2 = new Input();
        $inputVldt2->setCaption("Input with warning")
        ->setValidationState("warning")
        ->setHasFeedback(false)
        ->setId("inputWarning1");
        $inputVldt3 = new Input();
        $inputVldt3->setCaption("Input with error")
        ->setValidationState("error")
        ->setHasFeedback(false)
        ->setId("inputError1");
        $inputVldt4 = new Input("checkbox");
        $inputVldt4->setOptions(array ("Checkbox with success"))
        ->setValidationState("success")
        ->setId("checkboxSuccess");
        $inputVldt5 = new Input("checkbox");
        $inputVldt5->setOptions(array ("Checkbox with warning"))
        ->setValidationStateWarning()
        ->setId("checkboxWarning");
        $inputVldt6 = new Input("checkbox");
        $inputVldt6->setOptions(array ("Checkbox with error"))
        ->setValidationStateDanger()
        ->setId("checkboxError");
        $form22->setInnerElements(array(
            $inputVldt, $inputVldt2, $inputVldt3, $inputVldt4, $inputVldt5, $inputVldt6
        ));
        
        $inputFeedback = $inputVldt->cloneInstance()->setHasFeedback(true)->setHelp("");
        $inputFeedback2 = $inputVldt2->cloneInstance()->setHasFeedback(true);
        $inputFeedback3 = $inputVldt3->cloneInstance()->setHasFeedback(true);
        $inputFeedback4 = new InputGroup();
        $inputFeedback4->setCaption("Input group with success")
        ->setLeftAddon("@")
        ->setId("inputGroupSuccess1")
        ->setValidationState("success");
        $form23 = new Form();
        $form23->setInnerElements(array (
            $inputFeedback, $inputFeedback2, $inputFeedback3, $inputFeedback4 
        ));
        
        $form24 = new Form();
        $form24->setFormTypeHorizontal()->setInnerElements(array (
            clone $inputFeedback, clone $inputFeedback4
        ));
        
        $form25 = new Form ();
        $form25->setFormType("form-inline")->setInnerElements(array (
            clone $inputFeedback, clone $inputFeedback4
        ));
        
        $pageHeader_5 = new PageHeader("Buttons");
        $basicBtn = new Button();
        $basicBtn->setUrl("#")->setText("Link");
        $basicBtn2 = new Button();
        $basicBtn2->setText("Button");
        $basicBtn3 = new Button();
        $basicBtn3->setText("Input"); // actually can't do a button by Input class yet.
        $basicBtn4 = new Button();
        $basicBtn4->setIsSubmit()->setText("Submit");
        $bsExample9 = $bsExample->cloneInstance()->setInnerElements(array (
            $basicBtn, $basicBtn2, $basicBtn3, $basicBtn4 
        ));
        
        $defaultBtn = new Button();
        $defaultBtn->setText("Default");
        $defaultBtn2 = new Button();
        $defaultBtn2->setText("Primary")->setContext("primary");
        $defaultBtn3 = new Button();
        $defaultBtn3->setText("success")->setContext("success");
        $defaultBtn4 = new Button();
        $defaultBtn4->setText("Info")->setContext("info");
        $defaultBtn5 = new Button();
        $defaultBtn5->setText("Warning")->setContextWarning();
        $defaultBtn6 = new Button();
        $defaultBtn6->setText("Danger")->setContextDanger();
        $defaultBtn7 = new Button();
        $defaultBtn7->setText("Link")->setIsLink();
        $bsExample10 = $bsExample->cloneInstance()->setInnerElements(array (
            $defaultBtn, $defaultBtn2, $defaultBtn3, $defaultBtn4, $defaultBtn5, $defaultBtn6, $defaultBtn7
        ));
        
        $blockBtn = new Button();
        $blockBtn->setIsBlock()->setContextPrimary()->setText("Block level button")->setSizeLg();
        $blockBtn2 = new Button();
        $blockBtn2->setIsBlock()->setContextDefault()->setText("Block level button")->setSizeLg();
        $well20 = new Well();
        $well20->setIsCenterBlock()->setCustomStyle("max-width:400px")
        ->setInnerElements(array (
            $blockBtn, $blockBtn2
        ));
        $activeBtn = new Button();
        $activeBtn->setText("Primary button")->setContextPrimary()->setSizeLg()->setIsActive();
        $activeBtn2 = new Button();
        $activeBtn2->setText("Button")->setContextDefault()->setSizeLg()->setIsActive();
        $bsExample11 = $bsExample->cloneInstance()->setInnerElements(array (
            $activeBtn, $activeBtn2
        ));
        
        $disabledBtn = new Button();
        $disabledBtn->setText("Primary button")->setContextPrimary()->setSize(5)->setIsDisabled();
        $disabledBtn2 = new Button();
        $disabledBtn2->setText("Button")->setContextDefault()->setSize(5)->setIsDisabled();
        $bsExample12 = $bsExample->cloneInstance()->setInnerElements(array (
            $disabledBtn, $disabledBtn2
        ));
        
        $pageHeader_6 = new PageHeader("Images");
        $img = new Image("rounded");
        $img->setSource("holder.js")->setWidth(140)->setHeight(140);
        $img2 = new Image("circle");
        $img2->setSource("holder.js")->setWidth(140)->setHeight(140);
        $img3 = new Image("thumbnail");
        $img3->setSource("holder.js")->setWidth(140)->setHeight(140);
        $bsExample13 = $bsExample->cloneInstance()->setInnerElements(array(
            $img, $img2, $img3 
        ));
        
        $pageHeader_7 = new PageHeader("Helper classes");
        $text = new Typography("p");
        $text->setTextContext("muted")->setText("Fusce dapibus, tellus ac cursus commodo, tortor mauris nibh.");
        $text2 = new Typography("p");
        $text2->setTextContext("primary")->setText("Nullam id dolor id nibh ultricies vehicula ut id elit.");
        $text3 = new Typography("p");
        $text3->setTextContext("success")->setText("Duis mollis, est non commodo luctus, nisi erat porttitor ligula.");
        $text4 = new Typography("p");
        $text4->setTextContext("info")->setText("Maecenas sed diam eget risus varius blandit sit amet non magna.");
        $text5 = new Typography("p");
        $text5->setTextContext("warning")->setText("Etiam porta sem malesuada magna mollis euismod.");
        $text6 = new Typography("p");
        $text6->setTextContext("danger")->setText("Donec ullamcorper nulla non metus auctor fringilla.");
        $bsExample14 = $bsExample->cloneInstance()->setInnerElements(array (
            $text, $text2, $text3, $text4, $text5, $text6
        ));
        $bsExample15 = $bsExample->cloneInstance()
        ->appendCustomClass("bs-example-bg-classes")
        ->setInnerElements(array (
            $text2->cloneInstance()->setBgContext("primary")->setTextContext(""), 
            $text3->cloneInstance()->setBgContext("success")->setTextContext(""),
            $text4->cloneInstance()->setBgContext("info")->setTextContext(""),
            $text5->cloneInstance()->setBgContext("warning")->setTextContext(""),
            $text6->cloneInstance()->setBgContext("danger")->setTextContext("")
        ));
        
        // container
        $container = new Typography("div:container", null, array("role"=> "main"));
        $container->appendInnerElements(array (
            $pageHeader_1,
            $bsExample2,
            new Typography("h2", array ("innerText" => "Mobile and desktop")),
            $bsExample3, 
            new Typography("h2", array ("innerText" => "Offsetting columns")),
            $bsExample4,
            $pageHeader_2,
            $bsExample5,
            new Typography("h2", array ("innerText" => "Lead body copy")),
            $pLead->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Alignment classes")),
            $bsExample6,
            new Typography("h2", array ("innerText" => "Transformation classes")),
            $bsExample7,
            new Typography("h2", array ("innerText" => "Lists")),
            $list->enclose(clone $bsExample), 
            new Typography("h3", array ("innerText" => "Unstyled")),
            $listUnstyled->enclose(clone $bsExample),
            new Typography("h3", array ("innerText" => "Inline")),
            $listInline->enclose(clone $bsExample),
            $pageHeader_3,
            new Typography("h2", array ("innerText" => "Inline")),
            $codeSection->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "User input")),
            $sectionUserInput->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "PHP code")),
            $phpCode->enclose(clone $bsExample),
            $pageHeader_4,
            $table1->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Striped rows")),
            $table1->cloneInstance()->setIsStriped()->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Bordered table")),
            $table1->cloneInstance()->setIsBordered()->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Hover rows")),
            $table1->cloneInstance()->setWithHoverState()->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Condensed table")),
            $table1->cloneInstance()->setIsCondensed()->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Contextual classes")),
            $table2->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Responsive tables")),
            $bsExample8,
            $pageHeader,
            $form1->enclose(clone $bsExample),
            // $form1Code, 
            new Typography("h2", array ("innerText" => "Form controls")),
            $form2->enclose(clone $bsExample),
            $form3->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Readonly")),
            $form4->enclose(clone $bsExample),
            $form5->enclose(clone $bsExample),
            $form6->enclose(clone $bsExample),
            $pageHeader2,
            $form7->enclose(clone $bsExample),
            $form8->enclose(clone $bsExample),
            $form9->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Without labels")),
            $form10->enclose(clone $bsExample),
            $pageHeader3,
            new Typography("h2", array ("innerText" => "Form group")),
            $form11->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Form grid")),
            $form12Well,
            new Typography("h2", array ("innerText" => "Form row")),
            $form13Well,
            new Typography("h2", array ("innerText" => "Horizontal form")),
            $form14Well,
            new Typography("h2", array ("innerText" => "Inline forms")),
            $form15Well,
            $form16Well,
            $form17Well,
            $pageHeader4,
            $form18Well,
            $well19,
            $pageHeader5,
            $fieldset20,
            $pageHeader6,
            new Typography("h2", array ("innerText" => "Browser defaults")),
            $form21->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Validation states")),
            $form22->enclose(clone $bsExample),
            $form23->enclose(clone $bsExample),
            $form24->enclose(clone $bsExample),
            $form25->enclose(clone $bsExample),
            $pageHeader_5, 
            $bsExample9,
            $bsExample10,
            $well20->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Active state")),
            $bsExample11,
            new Typography("h2", array ("innerText" => "Disabled state")),
            $bsExample12,
            $pageHeader_6,
            $bsExample13,
            $pageHeader_7,
            new Typography("h2", array ("innerText" => "Contextual colors")),
            $bsExample14,
            new Typography("h2", array ("innerText" => "Contextual backgrounds")),
            $bsExample15 
        ))
        ->setCaption("Example textarea")
        ->appendCustomClass("theme-showcase");
        
        // bootstrap palette
        $btPanel->appendBodyContents(array($container));
        
        $btPanel->render(true);
        // var_dump(Typography::getErrMsg());
        // echo "Memory usage(real): " . memory_get_usage(true);
    }
    
    /**
     * @desc default components demo.
     */
    public function componentsView () {
        $btPanel = new Xantico();
        $btPanel->setIsLoadBootstrapFromCDN()->setIsLoadJQueryFromCDN()
        ->setCustomCSSFiles('https://getbootstrap.com/docs/3.3/assets/css/docs.min.css')
        ->setCustomScriptsFiles('https://v3.bootcss.com/assets/js/docs.min.js'); 
        
        // Components here.
        $bsExample = new Typography("div:bs-example");
        $code = new Code();
        
        $pageHeader = new PageHeader("Glyphicons");
        $iconUl = new Typography("ul:bs-glyphicons-list");
        $iconUl->appendItems(array (
            array (new Icon("asterisk"), new Typography("span:glyphicon-class", array ("innerText" => "glyphicon glyphicon-asterisk"))),
            array (new Icon("plus"), new Typography("span:glyphicon-class", array ("innerText" => "glyphicon glyphicon-plus"))),
            array (new Icon("euro"), new Typography("span:glyphicon-class", array ("innerText" => "glyphicon glyphicon-euro"))),
            array (new Icon("eur"), new Typography("span:glyphicon-class", array ("innerText" => "glyphicon glyphicon-eur"))),
            array (new Icon("minus"), new Typography("span:glyphicon-class", array ("innerText" => "glyphicon glyphicon-minus"))),
            array (new Icon("cloud"), new Typography("span:glyphicon-class", array ("innerText" => "glyphicon glyphicon-cloud"))),
            array (new Icon("envelope"), new Typography("span:glyphicon-class", array ("innerText" => "glyphicon glyphicon-envelope"))),
            array (new Icon("pencil"), new Typography("span:glyphicon-class", array ("innerText" => "glyphicon glyphicon-pencil"))),
            array (new Icon("glass"), new Typography("span:glyphicon-class", array ("innerText" => "glyphicon glyphicon-glass"))),
            array (new Icon("music"), new Typography("span:glyphicon-class", array ("innerText" => "glyphicon glyphicon-music"))),
            array (new Icon("search"), new Typography("span:glyphicon-class", array ("innerText" => "glyphicon glyphicon-search"))),
            array (new Icon("heart"), new Typography("span:glyphicon-class", array ("innerText" => "glyphicon glyphicon-sheart"))),
            array (new Icon("star"), new Typography("span:glyphicon-class", array ("innerText" => "glyphicon glyphicon-star"))),
            array (new Icon("star-empty"), new Typography("span:glyphicon-class", array ("innerText" => "glyphicon glyphicon-star-empty"))),
            array (new Icon("user"), new Typography("span:glyphicon-class", array ("innerText" => "glyphicon glyphicon-user"))),
            array (new Icon("film"), new Typography("span:glyphicon-class", array ("innerText" => "glyphicon glyphicon-film")))
        ));
        $iconDiv = $iconUl->enclose(new Typography("div:bs-glyphicons"));
        
        $pageHeader2 = new PageHeader("Dropdown");
        $dropMenu = array (
            array("text" => "Action", "url" => "#"),
            array("text" => "Another action", "url" => "#"),
            array("text" => "Something else here", "url" => "#"),
            array("seperator" => true),
            array("text" => "Seperated link", "url" => "#")
        );
        $dropdown = new Dropdown();
        $dropdownDiv = $dropdown->appendItems($dropMenu)
        ->setText("Dropdown")
        ->setContext("default") 
        ->enclose(new Typography("div"));
        
        $dropup = new Dropdown();
        $dropupDiv = $dropup->setIsDropup()
        ->appendItems($dropMenu)
        ->setText("Dropup")
        ->setContext("default")
        ->enclose(new Typography("div"));
        
        $dropMenu2 = array (
            array("text" => "Dropdown Header", "head" => true),
            array("text" => "Action", "url" => "#"),
            array("text" => "Another action", "url" => "#"),
            array("text" => "Something else here", "url" => "#"),
            array("text" => "Dropdown Header", "head" => true),
            array("text" => "Seperated link", "url" => "#")
        );
        $dropdown2 = new Dropdown();
        $dropdownDiv2 = $dropdown2->appendItems($dropMenu2)
        ->setText("Dropdown")
        ->setContext("default")
        ->enclose(new Typography("div"));
        
        $dropMenu3 = array (
            array("text" => "Regular link", "url" => "#"),
            array("text" => "Disabled link", "url" => "#", "disabled" => true),
            array("text" => "Another link", "url" => "#"),
        );
        $dropdown3 = new Dropdown();
        $dropdownDiv3 = $dropdown3->appendItems($dropMenu3)
        ->setText("Dropdown")
        ->setContext("default")
        ->enclose(new Typography("div"));
        
        $pageHeader3 = new PageHeader("Button groups");
        $btnLeft = new Button();
        $btnMid = new Button();
        $btnRight = new Button();
        $btnLeft->setText("Left");
        $btnMid->setText("Middle");
        $btnRight->setText("Right");
        $btnGrp1 = new ButtonGroup();
        $btnGrp1->appendInnerElements(array ($btnLeft, $btnMid, $btnRight));
        
        $btn1 = new Button(array ("innerText" => 1));
        $btn2 = new Button(array ("innerText" => 2));
        $btn3 = new Button(array ("innerText" => 3));
        $btn4 = new Button(array ("innerText" => 4));
        $btn5 = new Button(array ("innerText" => 5));
        $btn6 = new Button(array ("innerText" => 6));
        $btn7 = new Button(array ("innerText" => 7));
        $btn8 = new Button(array ("innerText" => 8));
        $btnGrp2 = new ButtonGroup();
        $btnGrp3 = new ButtonGroup();
        $btnGrp4 = new ButtonGroup();
        $btnGrp2->appendInnerElements(array ($btn1, $btn2, $btn3, $btn4));
        $btnGrp3->appendInnerElements(array ($btn5, $btn6, $btn7));
        $btnGrp4->appendInnerElements($btn8);
        $btnToolbar = new ButtonToolbar();
        $btnToolbar->appendInnerElements($btnGrp2, $btnGrp3, $btnGrp4);
        
        $btnGrp5 = clone $btnGrp1;
        $btnGrp6 = clone $btnGrp1;
        $btnGrp7 = clone $btnGrp1;
        $btnGrp8 = clone $btnGrp1;
        $btnGrp5 = $btnGrp5->setSize(5)->enclose(new Row());
        $btnGrp6 = $btnGrp6->setSize(4)->enclose(new Row());
        $btnGrp7 = $btnGrp7->setSize(3)->enclose(new Row());
        $btnGrp8 = $btnGrp8->setSize(2)->enclose(new Row());
        $well2 = clone $bsExample;
        $well2->appendInnerElements(array($btnGrp5, $btnGrp6, $btnGrp7, $btnGrp8));
        
        $dropdownGrp = new Dropdown();
        $dropMenu4 = array (
            array("text" => "Dropdown link", "url" => "#"),
            array("text" => "Dropdown link", "url" => "#")
        );
        $dropdownGrp->appendItems($dropMenu4)->setText("Dropdown");
        $btnGrp9 = new ButtonGroup();
        $btnGrp9->appendInnerElements(array ($btn1, $btn2, $dropdownGrp));

        $btnButton = new Button();
        $btnButton->setText("Button");
        $btnGrpVertical = new ButtonGroup();
        $btnGrpVertical->setIsVertical()
        ->appendInnerElements(array ($btnButton, clone $btnButton, clone $dropdownGrp, clone $btnButton, clone $btnButton, clone $dropdownGrp, clone $dropdownGrp));
        
        $pageHeader4 = new PageHeader("Button dropdowns");
        $btnDropdown = new Dropdown();
        $btnDropdown->setContext("default")
        ->setText("Default")
        ->setItems($dropMenu);
        $btnDropdown2 = clone $btnDropdown;
        $btnDropdown2->setContext("primary")->setText("Primary");
        $btnDropdown3 = clone $btnDropdown;
        $btnDropdown3->setContext("success")->setText("Success");
        $btnDropdown4 = clone $btnDropdown;
        $btnDropdown4->setContext("info")->setText("Info");
        $btnDropdown5 = clone $btnDropdown;
        $btnDropdown5->setContext("warning")->setText("Warning");
        $btnDropdown6 = clone $btnDropdown;
        $btnDropdown6->setContext("danger")->setText("Danger");
        $well3 = clone $bsExample;
        $well3->appendInnerElements(array ($btnDropdown, $btnDropdown2, $btnDropdown3, $btnDropdown4, $btnDropdown5, $btnDropdown6));
        
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
        $well5->appendInnerElements(array ($lgDropdown->enclose(new Row()), $smDropdown->enclose(new Row()), $xsDropdown->enclose(new Row())));
        
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
        ->setContext("Primary")
        ->setItems($dropMenu);
        $well6 = clone $bsExample;
        $well6->appendInnerElements(array ($dropRight, $dropRightPmy));
        
        $pageHeader6 = new PageHeader("Input groups");
        $inputUserGrp = new InputGroup();
        $inputUserGrp->setPlaceholder("Username")
        ->setLeftAddon("@");
        $inputUserGrp2 = new InputGroup();
        $inputUserGrp2->setPlaceholder("Recipient's username")
        ->setRightAddon("@example.com");
        $inputUserGrp3 = new InputGroup();
        $inputUserGrp3->setLeftAddon("https://example.com/users/")->setCaption("Your vanity URL");
        $form1 = new Form();
        $well7 = $form1->appendInnerElements(array ($inputUserGrp, $inputUserGrp2, $inputUserGrp3))
        ->enclose(clone $bsExample);
        
        $inputUserGrp4 = clone $inputUserGrp;
        $inputUserGrp4->setSize(5);
        $inputUserGrp5 = clone $inputUserGrp;
        $inputUserGrp6 = clone $inputUserGrp;
        $inputUserGrp6->setSize(3);
        $form2 = new Form ();
        $form2->appendInnerElements(array ($inputUserGrp4, $inputUserGrp5, $inputUserGrp6));
        
        $inputCheckGrp = new InputGroup();
        $inputCheckGrp->setLeftAddon(new Input("checkbox"));
        $inputRadioGrp = new InputGroup();
        $inputRadioGrp->setLeftAddon(new Input("radio"));
        $row4 = new Row();
        $row4->appendItems(array (
            array("text" => $inputCheckGrp, "width" => 6),
            array("text" => $inputRadioGrp, "width" => 6)
        ));
        $form3 = new Form();
        $form3->appendInnerElements($row4);
        
        $btnAddon = new Button();
        $btnAddon->setText("Go!");
        $inputSearchGrp = new InputGroup();
        $inputSearchGrp->setPlaceholder("Search ...")->setLeftAddon($btnAddon);
        $inputSearchGrp2 = new InputGroup();
        $inputSearchGrp2->setPlaceholder("Search ...")->setRightAddon(clone $btnAddon);
        $row5 = new Row ();
        $row5->appendItems(array (
            array("text" => $inputSearchGrp, "width" => 6),
            array("text" => $inputSearchGrp2, "width" => 6)
        ));
        $form4 = new Form();
        $form4->appendInnerElements($row5);
        
        $dropdownAddon = new Dropdown();
        $dropdownAddon->setText("Action")->setItems($dropMenu);
        $inputActionGrp = new InputGroup();
        $inputActionGrp->setLeftAddon($dropdownAddon);
        $inputActionGrp2 = new InputGroup();
        $inputActionGrp2->setRightAddon($dropdownAddon->cloneInstance()->setAlign("right"));
        $row6 = new Row ();
        $row6->appendItems(array (
            array("text" => $inputActionGrp, "width" => 6),
            array("text" => $inputActionGrp2, "width" => 6)
        ));
        $form5 = new Form();
        $form5->appendInnerElements($row6);
        
        $dropdownAddon2 = $dropdownAddon->cloneInstance()->setIsSplit();
        $actionBtn = new Button();
        $actionBtn->setText("Action")->setContext("Default");
        $inputActionGrp3 = new InputGroup();
        $inputActionGrp3->setLeftAddon(array($actionBtn, $dropdownAddon2->getButton(), $dropdownAddon2->getMenu()));
        $inputActionGrp4 = new InputGroup();
        $dropdownAddon3 = $dropdownAddon2->cloneInstance()->setAlign("right");
        $inputActionGrp4->setRightAddon(array (clone $actionBtn, $dropdownAddon3->getButton(), $dropdownAddon3->getMenu()));
        $row7 = new Row ();
        $row7->appendItems(array (
            array("text" => $inputActionGrp3, "width" => 6),
            array("text" => $inputActionGrp4, "width" => 6)
        ));
        $form6 = new Form();
        $form6->appendInnerElements($row7);
        
        $mplBtn = new InputGroup();
        $boldBtn = new Button();
        $boldBtn->appendInnerElements(new Icon("bold"));
        $italicBtn = new Button();
        $italicBtn->appendInnerElements(new Icon("italic"));
        $signBtn = new Button();
        $signBtn->appendInnerElements(new Icon("question-sign"));
        $mplBtn->setLeftAddon(array ($boldBtn, $italicBtn));
        $mplBtn2 = new InputGroup();
        $mplBtn2->setRightAddon(array ($signBtn, clone $actionBtn));
        $row8 = new Row();
        $row8->appendItems(array (
            array("text" => $mplBtn, "text" => 6),
            array("text" => $mplBtn2, "text" => 6) 
        ));
        $form7 = new Form();
        $form7->appendInnerElements($row8);
        
        $pageHeader7 = new PageHeader("Navs");
        // navs
        $nav1 = new Nav();
        $nav1->setStyle("tabs")
        ->appendItems(array (
            array ("text" => "Home", "url" => "#", "active" => true),
            array ("text" => "Profile", "url" => "#"),
            array ("text" => "Messages", "url" => "#")
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
        $well8->appendInnerElements(array ($nav4, $nav5));
        
        $nav6 =new Nav();
        $navMenu = array (
            array ("text" => "Clickable link", "url" => "#"),
            array ("text" => "Clickable link", "url" => "#"),
            array ("text" => "Disaled link", "url" => "#", "disabled" => true)
        );
        $nav6->appendItems($navMenu)->setStyle("pills");
        
        $nav7 = new Nav();
        $dropdown4 = new Dropdown();
        $dropdown4->appendItems($dropMenu)->setText("Dropdown")->setMode("inline");
        $nav7->appendItems(array (
            array("text" => "Home", "url" => "#", 'active' => true),
            array("text" => "Help", "url" => "#"),
            $dropdown4
        ));
        
        $nav8 = clone $nav7;
        $nav8->setStyle("pills");
        
        $pageHeader8 = new PageHeader("Navbar");
        $navbar = new Navbar();
        $dropdown5 = new Dropdown();
        $dropdown5->setMode("inline")
        ->setText("Dropdown")
        ->setItems(array_merge($dropMenu, array (
            array("seperator" => true), 
            array("text" => "One more seperated link", "url" => "#"))));
        $navbar->setBrand("Brand")
        ->appendItems(array (
            array("text" => "Link", "url" => "#", 'active' => true),
            array("text" => "Link", "url" => "#"),
            $dropdown5, // remember don't add url after a Typography instance.
        ));
        $formInNavbar = new Form ();
        $formInNavbar->setFormType("navbar-form")->appendCustomClass("navbar-left")->setFormAction();
        $inputInNavbar = new Input();
        $inputInNavbar->setPlaceholder("Search");
        $formInNavbar->appendInnerElements(array($inputInNavbar));
        $navInNavbar = new Nav();
        $navInNavbar->appendItems(array (
            array('text' => "Link", 'url' => "#"),
            clone $dropdown4
        ))->setAlign("right")->setStyle("navbar");
        $navbar->setCollapseButton()
        ->appendInnerElements(array ($formInNavbar, $navInNavbar));
        
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
        $navbar3->appendInnerElements($formInNavbar2);
        
        $navbar4 = new Navbar();
        $navbar4->setBrand("Brand")->setIsFluid();
        $buttonInNavbar = new Button();
        $buttonInNavbar->setContext('default')->setText('Sign in');
        $navbar4->appendInnerElements($buttonInNavbar);
        
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
        $navText->appendCustomClass(array("navbar-right", "navbar-text"))->setCdata("Signed in as " . $link->setText("Mark Otto")->render());
        $navbar6->appendInnerElements($navText);
        
        $navbar7 = new Navbar();
        $navbar7->setBrand("Brand")->appendItems(array (
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
            array("text" => "Home", "url" => "#"),
            array("text" => "Library", "url" => "#"),
            array("text" => "Data", "url" => "#")
        );
        $bcrumbs->appendItems($bcrumbMenu)->setHideAfter()->setActiveIndex(0);
        $bcrumbs2 = clone $bcrumbs;
        $bcrumbs2->setActiveIndex(1);
        $bcrumbs3 = clone $bcrumbs2;
        $bcrumbs3->stepForward();
        $bsExample2 = clone $bsExample;
        $bsExample2->appendInnerElements(array ($bcrumbs, $bcrumbs2, $bcrumbs3));
        
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
        $bsExample3->appendInnerElements(array ($pagi2, $pagi3, $pagi4));
        
        $pagi5 = new Pagination();
        $pagi5->setPages(10)->setMode("pager");
        
        $pagi6 = new Pagination();
        $pagi6->setPages(10)->setMode("aligned-pager");
        
        $pageHeader11 = new PageHeader("Labels");
        $lbl1 = new Typography("h1");
        $lbl1->appendInnerElements(array ("Example heading", new Label("New")));
        $lbl2 = new Typography("h2");
        $lbl2->appendInnerElements(array ("Example heading", new Label("New")));
        $lbl3 = new Typography("h3");
        $lbl3->appendInnerElements(array ("Example heading", new Label("New")));
        $lbl4 = new Typography("h4");
        $lbl4->appendInnerElements(array ("Example heading", new Label("New")));
        $lbl5 = new Typography("h5");
        $lbl5->appendInnerElements(array ("Example heading", new Label("New")));
        $lbl6 = new Typography("h6");
        $lbl6->appendInnerElements(array ("Example heading", new Label("New")));
        $bsExample4 = $bsExample->cloneInstance()
        ->appendInnerElements(array ($lbl1, $lbl2, $lbl3, $lbl4, $lbl5, $lbl6));
        
        $lbld = new Label();
        $lbld->setContext("default")->setText("Default");
        $lblp = new Label();
        $lblp->setContext("primary")->setText("Primary");
        $lbls = new Label();
        $lbls->setContext("success")->setText("Success");
        $lbli = new Label();
        $lbli->setContext("info")->setText("Info");
        $lblw = new Label();
        $lblw->setContext("warning")->setText("Warning");
        $lblg = new Label();
        $lblg->setContext("danger")->setText("Danger");
        $bsExample5 = $bsExample->cloneInstance()
        ->appendInnerElements(array ($lbld, $lblp, $lbls, $lbli, $lblw, $lblg));
        
        $pageHeader12 = new PageHeader("Badges");
        $inbox = new HtmlTag("a");
        $inbox->appendInnerElements(array ("Inbox", new Badge("42")));
        $msgBtn = new Button();
        $msgBtn->setText("Messages")
        ->setInnerElements(new Badge("4"))
        ->setContext("primary");
        $bsExample6 = $bsExample->cloneInstance()
        ->appendInnerElements(array ($inbox, "<br/>", $msgBtn));
        
        $nav9 = new Nav();
        $navItems = array (
            array ("text" => array ("Home", new Badge(42)), "url" => "#"),
            array ("text" => "Profile", "url" => "#"),
            array ("text" => array("Messages", new Badge(3)), "url" => "#")
        );
        $nav9->setActiveIndex(0)
        ->appendItems($navItems)
        ->setStyle("pills");
        
        $pageHeader13 = new PageHeader("Jumbotron");
        $jbt = new Jumbotron();
        $jbtBtn = new Button();
        $jbtBtn->setText("Learn more")->setSize(5)->setContext("Primary");
        $jbt->setHeader("Hello, world!")
        ->appendBodyContents(array (
            "This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.",
            $jbtBtn
        ));
        
        $pageHeader14 = new PageHeader("Page header");
        $pageHeader15 = new PageHeader("Example page header");
        $pageHeader15->setSubText("Subtext for header");
        
        $pageHeader16 = new PageHeader("Thumbnails");
        $rowThumbnails = new Row();
        $tn1 = new Image();
        $tn1->setSource("holder.js")->setWidth("100%")->setHeight("180")->setUrl("#")
        ->setAttrs(array ("data-holder-rendered" => "true"))->setAlt("100%x180");
        $rowThumbnails->appendItems(array(
            array("text" => $tn1, "width" => array ("col-xs-6", "col-md-3")),
            array("text" => clone $tn1, "width" => array ("col-xs-6", "col-md-3")),
            array("text" => clone $tn1, "width" => array ("col-xs-6", "col-md-3")),
            array("text" => clone $tn1, "width" => array ("col-xs-6", "col-md-3"))
        ));
        
        $rowThumbnails2 = new Row();
        $tn2 = new Image();
        $tn2->setSource("holder.js")->setWidth("100%")->setHeight("200")
        ->setAttrs(array ("data-holder-rendered" => "true"))->setAlt("100%x200");
        $captionH3 = new HtmlTag("h3");
        $captionH3->setText("Thumbnail label");
        $captionText = new HtmlTag("p");
        $captionText->setText("Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.");
        $captionBtns = new HtmlTag("p");
        $captionBtn1 = new Button();
        $captionBtn1->setText("Button")->setContext("default");
        $captionBtn2 = $captionBtn1->cloneInstance()->setContext("primary");
        $captionBtns->appendInnerElements(array($captionBtn1, $captionBtn2));
        $tn2->setCaption(array($captionH3, $captionText, $captionBtns));
        $rowThumbnails2->appendItems(array(
            array("text" => $tn2, "width" => array ("col-sm-6", "col-md-4")),
            array("text" => clone $tn2, "width" => array ("col-sm-6", "col-md-4")),
            array("text" => clone $tn2, "width" => array ("col-sm-6", "col-md-4"))
        ));
        
        $pageHeader17 = new PageHeader("Alerts");
        $alert1 = new Alert();
        $alert1->appendInnerElements(array (new Typography("strong", array ("innerText" => "Well done!")), "You successfully read this important alert message."));
        $alert2 = new Alert();
        $alert2->appendInnerElements(array (new Typography("strong", array ("innerText" => "Heads up!")), "This alert needs your attention, but it's not super important."))
        ->setContext("info");
        $alert3 = new Alert();
        $alert3->appendInnerElements(array (new Typography("strong", array ("innerText" => "Warning!")), "Best check yo self, you're not looking too good."))
        ->setContext("warning");
        $alert4 = new Alert();
        $alert4->appendInnerElements(array (new Typography("strong", array ("innerText" => "Oh snap!")), "Change a few things up and try submitting again."))
        ->setContext("danger");
        $bsExample7 = $bsExample->cloneInstance()
        ->appendInnerElements(array (
            $alert1, $alert2, $alert3, $alert4 
        ));
        
        $alert5 = $alert3->cloneInstance()->setIsDismissible();
        
        $alert6 = new Alert();
        $alert6->setInnerElements(array (
            new Typography("strong", array ("innerText" => "Well done!")), 
            "You successfully read ",
            new Typography("a", array ("innerText" => "this important alert message."))
        ));
        $alert7 = new Alert();
        $alert7->appendInnerElements(array (
            new Typography("strong", array ("innerText" => "Heads up!")), 
            "This ",
            new Typography("a", array ("innerText" => "alert needs your attention")),
            ", but it's not super important."
        ))
        ->setContext("info");
        $alert8 = new Alert();
        $alert8->appendInnerElements(array (
            new Typography("strong", array ("innerText" => "Warning!")), 
            "Best check yo self, you're ",
            new Typography("a", array ("innerText" => "not looking too good."))
        ))
        ->setContext("warning");
        $alert9 = new Alert();
        $alert9->appendInnerElements(array (
            new Typography("strong", array ("innerText" => "Oh snap!")), 
            new Typography("a", array ("innerText" => "Change a few things up")),
            " and try submitting again."
            ))
        ->setContext("danger");
        $bsExample8 = $bsExample->cloneInstance()->setInnerElements(array(
            $alert6, $alert7, $alert8, $alert9
        ));
        
        $pageHeader18 = new PageHeader("Progress bars");
        
        $pb = new ProgressBar();
        $pb->setNow(60);
        
        $pb2 = $pb->cloneInstance()->setText("60%");
        
        $pb3 = $pb->cloneInstance()->setNow(0)->setText("0%");
        $pb4 = $pb->cloneInstance()->setNow(2)->setText("2%");
        $bsExample9 = $bsExample->cloneInstance()->setInnerElements(array (
            $pb3, $pb4 
        ));
        
        $pb5 = clone $pb;
        $pb5->setNow(40)
        ->setContext("success");
        $pb6 = clone $pb;
        $pb6->setNow(20)
        ->setContext("info");
        $pb7 = clone $pb;
        $pb7->setNow(60)
        ->setContext("warning");
        $pb8 = clone $pb;
        $pb8->setNow(80)
        ->setContext("danger");
        $bsExample10 = $bsExample->cloneInstance()->appendInnerElements(array (
            $pb5, $pb6, $pb7, $pb8  
        ));
        
        $bsExample11 = clone $bsExample10;
        $bsExample11->getElement(0)->setIsStriped();
        $bsExample11->getElement(1)->setIsStriped();
        $bsExample11->getElement(2)->setIsStriped();
        $bsExample11->getElement(3)->setIsStriped();
        
        $pb9 = $pb->cloneInstance()->setIsStriped()->setIsAnimated();
        
        $pb10 = new ProgressBar();
        $pb10->appendItems(array(
            array ("now" => 35, "context" => "success"),
            array ("now" => 20, "context" => "warning", "isStriped" => true),
            array ("now" => 10, "context" => "danger")
        ));
        
        $pageHeader19 = new PageHeader("Media object");
        $media = new Media();
        $mediaObject = new Image("thumbnail");
        $mediaObject->setSource("holder.js")->setWidth(64)->setHeight(64);
        $media->setMediaObject($mediaObject);
        $media->appendBodyContents(array(
            new Typography("h4", array("innerText" => "Media heading")),
            "Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. " 
        ));
        $media2 = clone $media;
        $mediaNested = new Media();
        $mediaNested->setMediaObject($mediaObject);
        $mediaNested->appendBodyContents(array(
            new Typography("h4", array("innerText" => "Nested Media heading")),
            "Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. "
        ));
        $media2->appendBodyContents($mediaNested);
        $media3 = clone $media;
        $media3->setMediaObject($mediaObject->cloneInstance()->setAlign("right"));
        
        $media4 = clone $media;
        $media4->setMediaObject(array($mediaObject->cloneInstance()->setAlign("left"), $mediaObject->cloneInstance()->setAlign("right")));
        $bsExample14 = $bsExample->cloneInstance()->appendInnerElements(array(
            $media, $media2, $media3, $media4 
        ));
        
        $media5 = new Media();
        $media5->setMediaObject($mediaObject->cloneInstance()->setVerticalAlign("top"));
        $media5->appendBodyContents(array(
            new Typography("h4", array("innerText" => "Top aligned media")),
            "Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. ",
            "Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus."
        ));
        $media6 = new Media();
        $media6->setMediaObject($mediaObject->cloneInstance()->setVerticalAlign("middle"));
        $media6->appendBodyContents(array(
            new Typography("h4", array("innerText" => "Middle aligned media")),
            "Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. ",
            "Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus."
        ));
        $media7 = new Media();
        $media7->appendBodyContents(array(
            new Typography("h4", array("innerText" => "Bottom aligned media")),
            "Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. ",
            "Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus."
        ));
        $media7->setMediaObject($mediaObject->cloneInstance()->setVerticalAlign("bottom"));
        $bsExample15 = $bsExample->cloneInstance()->appendInnerElements(array(
            $media5, $media6, $media7 
        ));
        
        $mediaList = new MediaList();
        $media8 = clone $media;
        $media8->appendBodyContents(array($mediaNested->cloneInstance()->appendBodyContents(clone $mediaNested), clone $mediaNested));
        $mediaList->appendInnerElements(array($media8));
        
        $pageHeader20 = new PageHeader("List group");
        
        $lstGrp = new ListGroup();
        $lstGrp->appendItems(array(
            array("text" => "Cras justo odio"),
            array("text" => "Dapibus ac facilisis in"),
            array("text" => "Morbi leo risus"),
            array("text" => "Porta ac consectetur ac"),
            array("text" => "Vestibulum at eros")
        ));
        
        $lstGrp2 = new ListGroup();
        $lstGrp2->appendItems(array(
            array("text" => array("Cras justo odio", new Badge(14))),
            array("text" => array("Dapibus ac facilisis in", new Badge(2))),
            array("text" => array("Morbi leo risus", new Badge(1))),
        ));
        
        $lstGrp3 = new ListGroup();
        $lstGrp3->appendItems(array(
            array("text" => "Cras justo odio", "url" => "#", 'active' => true),
            array("text" => "Dapibus ac facilisis in", "url" => "#"),
            array("text" => "Morbi leo risus", "url" => "#"),
            array("text" => "Porta ac consectetur ac", "url" => "#"),
            array("text" => "Vestibulum at eros", "url" => "#")
        ));
        
        $lstGrp4 = new ListGroup();
        $lstGrp4->setMode("button")
        ->appendItems(array(
            array("text" => "Cras justo odio"),
            array("text" => "Dapibus ac facilisis in"),
            array("text" => "Morbi leo risus"),
            array("text" => "Porta ac consectetur ac"),
            array("text" => "Vestibulum at eros")
        ));
        
        $lstGrp5 = new ListGroup();
        $lstGrp5->appendItems(array(
            array("text" => "Cras justo odio", "url" => "#", "disabled" => true),
            array("text" => "Dapibus ac facilisis in", "url" => "#"),
            array("text" => "Morbi leo risus", "url" => "#"),
            array("text" => "Porta ac consectetur ac", "url" => "#"),
            array("text" => "Vestibulum at eros", "url" => "#")
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
            array("text" => "Dapibus ac facilisis in", "url" => "#", "context" => "success"),
            array("text" => "Morbi leo risus", "url" => "#", "context" => "info"),
            array("text" => "Porta ac consectetur ac", "url" => "#", "context" => "warning"),
            array("text" => "Vestibulum at eros", "url" => "#", "context" => "danger")
        ));
        $row9 = new Row();
        $row9->setItems(array(
            $lstGrp6, $lstGrp7 
        ));

        $lstGrp8 = new ListGroup();
        $lstGrp8->appendItems(array(
            array("text" => "Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.", "heading" => "List group item heading", "active" => true),
            array("text" => "Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.", "heading" => "List group item heading"),
            array("text" => "Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.", "heading" => "List group item heading")
        ));
        
        $pageHeader21 = new PageHeader("Panels");
        $panel = new Panel();
        $panel->appendBodyContents("Basic panel example ");
        
        $panel2 = new Panel();
        $panel2->setHeading("Panel title")
        ->appendBodyContents("Panel content");
        
        $panel3 = new Panel();
        $panel3->setFooter("Panel footer")
        ->appendBodyContents("Panel content");
        
        $panelPrimary = clone $panel2;
        $panelPrimary->setContextPrimary();
        $panelSuccess = clone $panel2;
        $panelSuccess->setContextSuccess();
        $panelInfo = clone $panel2;
        $panelInfo->setContextInfo();
        $panelWarning = clone $panel2;
        $panelWarning->setContextWarning();
        $panelDanger = clone $panel2;
        $panelDanger->setContextDanger();
        $bsExample16 = $bsExample->cloneInstance()
        ->appendInnerElements(array(
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
        ->appendBodyContents("Some default panel content here. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Nullam id dolor id nibh ultricies vehicula ut id elit.")
        ->appendInnerElements($table);
        
        $panel5 = new Panel();
        $panel5->setHeading("Panel heading")
        ->appendInnerElements(clone $table);
        
        $panel6 = clone $panel4;
        $panel6->setElement(0, clone $lstGrp);
        
        $pageHeader22 = new PageHeader("Wells");
        $well11 = new Well();
        $well11->appendInnerElements("Look, I'm in a well! ");
        $well12 = clone $well11;
        $well12->setSizeLg();
        $well13 = clone $well11;
        $well13->setSizeSm();
        
        $pageHeader23 = new PageHeader("Responsive embed");
        $embedRspDiv = new Typography("div");
        $embedRspDiv->setEmbedResponsive("4:3");
        $embedRspDiv->appendInnerElements(new Typography("iframe", null, array ("src" => "http://localhost/Xantico/index.php", "allowfullscreen" => "true")));
        
        $pageHeader24 = new PageHeader("Video (Plyr, a demo of plugins)");
        $video = new Video();
        $video->setSource("http://video.touchforu.com/sv/7da05c-163ecbf7536/7da05c-163ecbf7536.mp4")
        ->setModuleType("plyr")
        ->setWithControls();
        $row10 = new Row();
        $row10->appendItems(array (
            array("text" => $video, "width" => 6),
        ));
        
        // container
        $container = new Typography("div:container", null, array("role"=> "main"));
        $container->appendInnerElements(array (
            $pageHeader,
            $iconDiv->enclose(clone $bsExample),
            $pageHeader2, 
            $dropdownDiv->enclose(clone $bsExample),
            $dropupDiv->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Headers")), 
            $dropdownDiv2->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Disabled menu item")),
            $dropdownDiv3->enclose(clone $bsExample),
            $pageHeader3, 
            $btnGrp1->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Button toolbar")),
            $btnToolbar->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Sizing")),
            $well2, 
            new Typography("h2", array ("innerText" => "Nesting")),
            $btnGrp9->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Vertical variation")),
            $btnGrpVertical->enclose(clone $bsExample), 
            $pageHeader4,
            $well3,
            new Typography("h2", array ("innerText" => "Split button dropdowns")), 
            $well4,
            new Typography("h2", array ("innerText" => "Sizing")),  
            $well5,
            new Typography("h2", array ("innerText" => "Dropup variation")),
            $well6,
            $pageHeader6,
            $well7,
            new Typography("h2", array ("innerText" => "Sizing")),
            $form2->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Checkboxes and radio addons")),
            $form3->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Button addons")),
            $form4->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Buttons with dropdowns")),
            $form5->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Segmented buttons")),
            $form6->enclose(clone $bsExample), 
            new Typography("h2", array ("innerText" => "Multiple buttons")),
            $form7->enclose(clone $bsExample),  
            $pageHeader7,
            $nav1->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Pills")),
            $nav2->enclose(clone $bsExample),
            $nav3->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Justified")),
            $well8,
            new Typography("h2", array ("innerText" => "Disabled links")),
            $nav6->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Using dropdowns")),
            $nav7->enclose(clone $bsExample),
            $nav8->enclose(clone $bsExample),
            $pageHeader8,
            $navbar->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Brand image")),
            $navbar2->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Forms")),
            $navbar3->enclose(clone $bsExample), 
            new Typography("h2", array ("innerText" => "Buttons")),
            $navbar4->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Text")),
            $navbar5->enclose(clone $bsExample),
            // $navbar5Code, 
            new Typography("h2", array ("innerText" => "Non-nav links")),
            $navbar6->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Static")),
            $navbar7->enclose(clone $bsExample),
            // $navbar7Code,
            new Typography("h2", array ("innerText" => "Inverted navbar")),
            $navbar8->enclose(clone $bsExample),
            $pageHeader9,
            $bsExample2,
            $pageHeader10,
            $pagi->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Sizing")),
            $bsExample3,
            new Typography("h2", array ("innerText" => "Pager")),
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
            new Typography("h2", array ("innerText" => "Custom content")),
            $rowThumbnails2->enclose(clone $bsExample),
            $pageHeader17,
            $bsExample7,
            new Typography("h2", array ("innerText" => "Dismissible alerts")),
            $alert5->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Links in alerts")),
            $bsExample8,
            $pageHeader18,
            $pb->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "With label")),
            $pb2->enclose(clone $bsExample),
            $bsExample9,
            new Typography("h2", array ("innerText" => "Contextual alternatives")),
            $bsExample10,
            new Typography("h2", array ("innerText" => "Striped")),
            $bsExample11,
            new Typography("h2", array ("innerText" => "Animated")),
            $pb9->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Stacked")),
            $pb10->enclose(clone $bsExample),
            $pageHeader19,
            $bsExample14,
            new Typography("h2", array ("innerText" => "Media alignment")),
            $bsExample15,
            new Typography("h2", array ("innerText" => "Media list")),
            $mediaList->enclose(clone $bsExample),
            $pageHeader20,
            $lstGrp->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Badges")),
            $lstGrp2->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Linked items")),
            $lstGrp3->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Button items")),
            $lstGrp4->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Disabled items")),
            $lstGrp5->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Contextual classes")),
            $row9->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Custom content")),
            $lstGrp8->enclose(clone $bsExample),
            $pageHeader21,
            $panel->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Panel with heading")),
            $panel2->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Panel with footer")),
            $panel3->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Contextual alternatives")),
            $bsExample16,
            new Typography("h2", array ("innerText" => "With tables")),
            $panel4->enclose(clone $bsExample),
            $panel5->enclose(clone $bsExample),
            $panel6->enclose(clone $bsExample),
            $pageHeader23,
            $embedRspDiv->enclose(clone $bsExample),
            $pageHeader22,
            $well11->enclose(clone $bsExample),
            new Typography("h2", array ("innerText" => "Optional classes")),
            $well12->enclose(clone $bsExample),
            $well13->enclose(clone $bsExample),
            $pageHeader24, 
            $row10->enclose(clone $bsExample)
        ));
        // bootstrap palette
        $btPanel->setBodyContents(array($container));
        
        $btPanel->render(true);
//         var_dump(Typography::getErrMsg());
        // echo "Memory usage(real): " . memory_get_usage(true);
    }
    
}

