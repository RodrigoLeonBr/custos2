<?php

namespace SMSPlan;

class PageAdmin extends Page {

    public function __construct($opts = array(), $tpl_dir = "/views/") {

        parent::__construct($opts, $tpl_dir);
    }

    public function __destruct() {

        if ($this->options["footer"] === true)
            $this->tpl->draw("footer");

        if (isset($this->options["footern"]))
            $this->tpl->draw($this->options["footern"]);
    }

}

?>