<?php
namespace view;

use model\bootstrap\basic\Button; // 自己注意大小寫
use model\bootstrap\basic\Typography;
use model\bootstrap\Bootstrap;
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

/**
 * 
 * @author metatronangelo
 * @desc 會員套餐那一塊的 view models.
 */
class BootstrapView 
{
    // set management.
    public function fetchView () {
        $btPanel = new Bootstrap();
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
        $lbl7->setColorSet("link")->setText("Link");
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
        $column = new Typography("div", array ("grids" => 6));
        
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
        $dropdown->getButton()->setCustomClass("sr-only");
        $dropdown->setItems($ddItems)
        ->setText (array ("Dropdown", new Typography("span:caret", array ("text" => "\t")))) 
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
        ->setActiveIndex(0)
        ->setCollapseButton() 
        ->setItems($nvbItems);
        
        $nvbItems [3] = new Navlet ($innerDropdown);
        $navbar2 = clone $navbar;
        $navbar2->setFgStyle("inverse")
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
        
        $well = new Typography("div:well");
        $text = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sed diam eget risus varius blandit sit amet non magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Aenean lacinia bibendum nulla sed consectetur.";
        $well->setInnerElements(new Typography("p", array ("text" => $text)));
        
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
        
        echo memory_get_usage(true);
//         echo Typography::getErrMsg();
        $btPanel->render(true);
    }
}

