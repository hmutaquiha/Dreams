<?php
/* @var $this Dreams\web\View */
use yii\helpers\Html;
use  app\models\Beneficiarios;
use common\models\User;


use  app\models\ServicosDream;
use  app\models\ServicosBeneficiados;

use  app\models\Distritos;
use app\models\Organizacoes;
use yii\helpers\ArrayHelper;

function totalProv($id) {
   $status=(int)1;
 $total = Beneficiarios::find()->where(['provin_code'=>(int)$id])
 ->andWhere('emp_status=:emp_status', [':emp_status' => $status])->count();
 return $total;
exit;
}

 function totalDist($prov,$id) {
 $total = Distritos::find()->where(['LIKE','province_code',(int)$prov])->count();
 return $total;
exit;
}

function totalParc($prov,$id) {
$distritos = Distritos::find()->where(['LIKE','province_code',(int)$prov])->asArray()->all();

$ids=ArrayHelper::getColumn($distritos,'district_code');
$total = Organizacoes::find()->where(['IN','distrito_id',$ids])->andWhere(['status'=>1])->count();
return $total;
exit;
}
 ?>

<!--ROW -->
 <div class="row">
   <div class="col-lg-4">
   <div class="panel panel-primary">
     <div class="panel-heading"> <strong align="center"><i class="ion ion-pie-graph info"></i> SOFALA
   <span class="badge badge-light"> <?=  number_format(totalProv(5)); ?></span>
     </strong></div>
     <div class="panel-body">
<i class="fa fa-globe"  style="color:green;"></i> <span>Distritos DREAMS </span>
<span class="badge pull-right">
  <?=  number_format(totalDist(5,1)); ?></span>
  <br/>
        <i class="fa fa-briefcase"  style="color:green;"></i> <span>Parceiros DREAMS </span>
        <span class="badge pull-right">
          <?=  totalParc(5,1); ?></span>

  <div class="raw">&nbsp;</div>
 <a href="#"   data-toggle="collapse" data-target="#5"><i class="fa fa-arrow-circle-down"  style="float:right;color:green;"></i></a>
    </div>
    </div>
   </div>

 <div class="col-lg-4">
 <div class="panel panel-info">
   <div class="panel-heading"> <strong align="center"><i class="ion ion-pie-graph info"></i> ZAMBEZIA

       <span class="badge badge-light"> <?=  number_format(totalProv(8)); ?></span>


   </strong></div>
   <div class="panel-body">
     <i class="fa fa-globe"  style="color:green;"></i> <span>Distritos DREAMS </span>
     <span class="badge pull-right">
       <?=  number_format(totalDist(8,1)); ?></span>
       <br/>
             <i class="fa fa-briefcase"  style="color:green;"></i> <span>Parceiros DREAMS </span>
             <span class="badge pull-right">
               <?=  totalParc(8,1); ?></span>
          <div class="raw">&nbsp;</div>
       <a href="#"  data-toggle="collapse" data-target="#8"><i class="fa fa-arrow-circle-down"  style="float:right;color:green;"></i></a>
  </div>
  </div>
</div>


<div class="col-lg-4">
<div class="panel panel-danger">
  <div class="panel-heading"> <strong align="center"><i class="ion ion-pie-graph info"></i> GAZA

  </strong><span class="badge badge-light"> <?=  number_format(totalProv(3)); ?></span></div>
  <div class="panel-body">
    <i class="fa fa-globe"  style="color:green;"></i> <span>Distritos DREAMS </span>
    <span class="badge pull-right">
      <?=  number_format(totalDist(3,1)); ?></span>
<br/>
      <i class="fa fa-briefcase"  style="color:green;"></i> <span>Parceiros DREAMS </span>
      <span class="badge pull-right">
        <?=  totalParc(3,1); ?></span>
        <div class="raw">&nbsp;</div>
 <a href="#"  data-toggle="collapse" data-target="#3"><i class="fa fa-arrow-circle-down"  style="float:right;color:green;"></i></a>
 </div>
 </div>
</div>

</div> <!--ROW-->

<!--ROW -->
 <div class="row">
   <div class="col-lg-4">
   <div class="panel panel-primary">
     <div class="panel-heading"> <strong align="center"><i class="ion ion-pie-graph info"></i> MAPUTO PROV&Iacute;NCIA
   <span class="badge badge-light"> <?= number_format(totalProv(2)); ?></span>
     </strong></div>
     <div class="panel-body">
<i class="fa fa-globe"  style="color:green;"></i> <span>Distritos DREAMS </span>
<span class="badge pull-right">
  <?=  number_format(totalDist(2,1)); ?></span>
  <br/>
        <i class="fa fa-briefcase"  style="color:green;"></i> <span>Parceiros DREAMS </span>
        <span class="badge pull-right">
          <?=  totalParc(2,1); ?></span>
  <div class="raw">&nbsp;</div>
 <a href="#"   data-toggle="collapse" data-target="#2"><i class="fa fa-arrow-circle-down"  style="float:right;color:green;"></i></a>
    </div>
    </div>
   </div>
</div> <!--ROW-->


<div id="5" class="collapse">
SOFALA
</div>

<div id="8" class="collapse">
Zambezia
</div>

<div id="3" class="collapse">
GAZA
</div>

<div id="2" class="collapse">
MAPUTO PROV&Iacute;NCIA
</div>



