<?php

class HomeController extends Controller{
    
    function item(){
        $browseitem = $this->model("User");
        $item=$browseitem->item();
        $this->view("index",$item);
    }
    
}

?>
