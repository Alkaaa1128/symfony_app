<?php

namespace App\Controller;

class HelloController {

    function hello() {
        return new response('Hello !');
    }

}

?>