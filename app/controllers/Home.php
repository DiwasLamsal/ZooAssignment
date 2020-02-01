<?php

  class Home extends Controller{

    public function index(){
      session_start();
      if(isset($_SESSION['loggedin'])){
        if($_SESSION['loggedin']['urole']=="Administrator")
          header("Location:AdminHome");
        else if($_SESSION['loggedin']['urole']=="Module Leader")
          header("Location:ModuleLeaderHome");
      }

      $fileName = '../app/templates/UserTemplate.php';
      $content = loadTemplate($fileName, ['title'=>'Claybrook Zoo']);
      $this->view($content);

    }

  }





?>
