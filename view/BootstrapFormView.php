<?php
namespace view;

use model\bootstrap\basic\Button; // 自己注意大小寫
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
        
        // @todo Form here.
        
        $container = new Typography("div:container", null, array("role"=> "main"));
        $container->setInnerElements(array ()) 
            ->setCustomClass("theme-showcase");
                
        $btPanel->setBodyContents(array($navbar, $container));
        
        // echo "Memory usage(real): " . memory_get_usage(true);
//         echo Typography::getErrMsg();
        $btPanel->render(true);
    }
}

