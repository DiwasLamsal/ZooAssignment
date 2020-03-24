<?php

class ManageVacancies extends Controller{

  public function index(){
    header("Location:./all");
  }

  public function all($val=""){
    if(is_numeric($val)){
      $this->browse($val);
      return;
    }

    $areaClass = new DatabaseTable('areas');
    $areas = $areaClass->findAll();
    $template = '../app/views/adminDash/dataTableCode.php';
    $dataTableCode = loadTemplate($template, []);

    $template = '../app/views/adminDash/ManageAreas.php';
    $content = loadTemplate($template, ['areas'=>$areas, 'dataTableCode'=>$dataTableCode]);
    $title = "Dashboard - Areas";
    $breadcrumbContent=["ManageAreas"=>"Areas"];
    $bodyTitle="Areas";
    require_once "../app/controllers/adminLoadView.php";
  }

  public function add(){
    $areaClass = new DatabaseTable('areas');
    if(isset($_POST['submit'])){
      $areaClass->save($_POST['area']);
      header("Location:../ManageAreas/all/addsuccess");
    }

    $template = '../app/views/adminDash/addArea.php';
    $content = loadTemplate($template, []);
    $title = "Dashboard - Add new area";
    $breadcrumbContent=["ManageAreas"=>"areas", "ManageAreas/Add"=>"Add Area"];
    $bodyTitle="Add area";
    require_once "../app/controllers/adminLoadView.php";
  }



  public function browse($val = ""){
    $areaClass = new DatabaseTable('areas');
    $area = $areaClass->find('aid', $val);

    if($area->rowCount()>0){
      if(isset($_POST['submit'])){
        $_POST['area']['aid']=$val;
        $areaClass->save($_POST['area'], 'aid');
        header("Location:../all/editsuccess");
      }

      $link='/ZooAssignment/public/ManageAreas/delete/'.$val;
      if(checkAreaContainsLocations($val))
        $link = false;

      $message = ($link==false)?"This area contains locations and cannot be deleted.":"";
      $template = '../app/views/adminDash/modal.php';
      $modal = loadTemplate($template, ['type'=>'Area', 'link'=>$link, 'message'=>$message]);
      $template = '../app/views/adminDash/addArea.php';
      $content = loadTemplate($template, ['area'=>$area, 'modal'=>$modal]);

      $title = "Dashboard - Add new area";
      $breadcrumbContent=["ManageAreas"=>"Areas", "ManageAreas/browse"=>"View area"];
      $bodyTitle="Edit area";
      require_once "../app/controllers/adminLoadView.php";
    }

    else{
      header("Location:../all/nosucharea");
    }

  }


  public function delete($val = ""){
    $areaClass = new DatabaseTable('areas');
    $area = $areaClass->find('aid',$val);
    if($area->rowCount()>0){
      $areaClass->delete('aid', $val);
      header("Location:../all/deletesuccess");
    }
    else{
      header("Location:../all/nosucharea");
    }

  }




}

?>