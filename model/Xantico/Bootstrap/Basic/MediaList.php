<?php
namespace Xantico\Bootstrap\Basic;

class MediaList extends Typography
{

    public function __construct($vars = array(), $attr = array())
    {
        parent::__construct("ul:media-list", $vars, $attr);
    }

    /**
     *
     * {@inheritDoc}
     * @see \model\Xantico\basic\Typography::render()
     */
    public function render($display = false)
    {

        if (!empty($this->innerElements)) {
            foreach ($this->innerElements as &$ele) {
                if ($ele instanceof Media) {
                    $ele->setTagName("li");
                }
            }
        }

        parent::render();

        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }

}
