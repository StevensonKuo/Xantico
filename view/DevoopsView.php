<?php
namespace view;

// basic bootstrsp
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
use model\bootstrap\basic\Container;

// devoops

/**
 *
 * @author metatronangelo
 * @desc demo page view models.
 */
class DevoopsView
{
    /**
     * @desc basic example. [Typography, grid system etc...
     */
    public function defaultView () {
        $btPanel = new Xantico();
        $btPanel->setIsLoadBootstrapFromCDN()->setIsLoadJQueryFromCDN()
        ->setCustomCSSFiles('https://getbootstrap.com/docs/3.3/assets/css/docs.min.css')
        ->setCustomScriptsFiles('https://v3.bootcss.com/assets/js/docs.min.js')
        ->setMetaContents(array (
            "description" => "description",
            "author" => "DevOOPS" 
        ))
        ->setTitle("DevOOPS");

        // container
        $container = new Typography("div:container", null, array("role"=> "main"));
        $container->appendInnerElements(array (
            "hereeee" 
        ));

        // bootstrap palette
        $btPanel->appendBodyContents(array($container));

        $btPanel->render(true);
        // var_dump(Typography::getErrMsg());
        // echo "Memory usage(real): " . memory_get_usage(true);
    }

    /**
     * @desc default components demo.
     */
    
}
