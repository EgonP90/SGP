<?php 

    class PageNotFound extends Controller{


        public function __construct()
        {
            
        }
        // Show home page with the most visited functions
        public function index(){
            $this->view('pagenotfound');
        }
    }

?>