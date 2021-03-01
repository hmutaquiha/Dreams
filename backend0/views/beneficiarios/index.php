<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\ComiteZonal;
use app\models\ComiteDistrital;
use kartik\select2\Select2;
use app\models\ComiteLocalidades;
use app\models\ComiteCirculos;
use app\models\ComiteCelulas;
use app\models\Us;
use app\models\ServicosBeneficiados;
use yii\widgets\Pjax;


use kartik\grid\EditableColumn;
use app\models\ServicosDream;
use app\models\Utilizadores;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BeneficiariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adolescentes e Jovens';
$this->params['breadcrumbs'][] = $this->title;

//contabilizar o numero de servicos Core por Beneficiario
function core($k){

$cors = ServicosDream::find()->where(['=','core_service',1])->distinct()->all();
$coreServicos=0;
foreach($cors as $cor) {	
	$coreServicos = $coreServicos+ServicosBeneficiados::find()
   ->where(['=','beneficiario_id',intval($k)])
   ->andWhere(['=', 'servico_id', intval($cor->id)])
   ->andWhere(['=', 'status', 1])
   ->select('servico_id')->distinct()
   ->count();			
}
return $coreServicos;
}


if(!Yii::$app->user->isGuest && Yii::$app->user->identity->role>=15) {
include("_index.php");

} else {

?>
<div class="beneficiarios-index">

    <h2 align="center"> 
 <?= Html::img('@web/img/users/bandeira.jpg',['class' => 'img-default','width' => '75px','alt' => 'DREAMS']) ?>   <br>

     <br>Lista de <?= Html::encode($this->title) ?>
    


    </h2>
    <?php    $this->render('_search', ['model' => $searchModel]); ?>
 
   <p>
     <?= Html::a('<i class="glyphicon glyphicon-home"></i>', ['site/index'], ['class' => 'btn btn-danger']) ?>    
        <?= Html::a('<i class="fa fa-plus"></i> Novo Beneficiário', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>
  
<div class="panel panel-default">
    <div class="panel-body">
	 <?php Pjax::begin(['enablePushState'=>false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

         'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
    'headerRowOptions'=>['class'=>'kartik-sheet-style'],
    'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //  'id',
           // 'emp_number',
			
			[
                               'class' => 'kartik\grid\ExpandRowColumn',
                               'expandAllTitle' => 'Expand all',
                               'collapseTitle' => 'Collapse all',
                               'expandIcon'=>'<span class="glyphicon glyphicon-expand"></span>',
                               'value' => function ($model, $key, $index, $column) {
                                       return GridView::ROW_COLLAPSED;
                               },
                               'detail'=>function ($model, $key, $index, $column) {
                                 return Yii::$app->controller->renderPartial('_expand.php', ['model'=>$model]);
                               },

                   'detailOptions'=>[
                       'class'=> 'kv-state-enable',
                   ],
                       ],
			
                  [
            'attribute' => 'img',
            'format' => 'html',
            'label' => 'Profile',
            'value' => function ($data) {
              //   return Html::img(imgProfile($data->emp_number),
               return Html::img('@web/img/users/bandeira.jpg',
                    ['width' => '25px', 'class'=>'img-circle']);
                        },
                     ],

                    [
           'attribute'=> 'member_id',
		    'format' => 'html',
           'label'=>'Código do Beneficiário',
            'value' => function ($model) {
        return  $model->member_id>0 ?  '<font color="#cd2660"><b>'.$model->distrito['cod_distrito'].'/'.$model->member_id.'</b></font>': "-";
      },
        ],  
         
    ['attribute' => 'emp_firstname',
      'label'=>'Nome do Beneficiário',
      'format' => 'raw',
      'value' => function ($model) {
        return  Yii::$app->user->identity->role==20 ?  $model->emp_firstname.' '.$model->emp_middle_name.' '.$model->emp_lastname: "<font color=#261657><b>DREAMS</b></font><span class='label label-success'><font size=+1>".intval($model->member_id)."</font></span>";
      },
    ],
         [
           'attribute'=>'emp_gender',
			 'format' => 'raw',
            'filter'=>array("1"=>"M","2"=>"F"),
            'value' => function ($model) {
        return  $model->emp_gender==1 ? '<i class="fa fa-male"></i>': '<i class="fa fa-female"></i>';
      },
        ],
			
			  [
           'attribute'=>'ponto_entrada',
			 'format' => 'raw',
			'label'=>'PE',
            'filter'=>array("1"=>"US","2"=>"CM","3"=>"ES"),
            'value' => function ($model) {
			//	return $model->ponto_entrada;
          if($model->ponto_entrada==1) {return "US";} elseif($model->ponto_entrada==2){return "CM";} else {return "ES";}
      },
        ],


         /*[
            'attribute'=>'us_id',
            'value'=>'us.name',
            'filter'=> ArrayHelper::map(Us::find()->orderBy('name ASC')->asArray()->all(), 'id', 'name')
          ],*/
			

         [
           'attribute'=>'emp_birthday',
           'label'=>'idade',
            'value' => function ($model) {
		if(!$model->emp_birthday==NULL) {		
        $newDate = substr(date($model->emp_birthday, strtotime($model->emp_birthday)),-4);

       return  date("Y")-$newDate." anos";} else {
		return  $model->idade_anos." anos";
		}
      },
        ], 
			
	[
      'label'=>'#Interv',
      'format' => 'raw',
      'value' => function ($model) {
		  $conta = ServicosBeneficiados::find()->where(['beneficiario_id' => $model->id])->distinct()->count();
		if($conta==0){return  '<span class="label label-danger"> <i class="fa fa-medkit"></i>&nbsp;['.$conta.']</span>';} 
		  elseif ($conta<5) {return  '<span class="label label-warning"> <i class="fa fa-medkit"></i>&nbsp;['.$conta.']</span>';} 
		  elseif ($conta<10) {return  '<span class="label label-info"> <i class="fa fa-medkit"></i>&nbsp;['.$conta.']</span>';} 
		  else {
        return  '<span class="label label-success"> <i class="fa fa-medkit"></i>&nbsp;['.$conta.']</span>';}
		  
		  
      },
	  'filter'=>array("0"=>"0","5"=>"5"),
    ],
			
			[
  'label'=>'#Prim',
  'format' => 'raw',
  'value' => function ($model) {
  $conta = ServicosBeneficiados::find()->where(['beneficiario_id' => $model->id])->distinct()->count();
if($conta==0){return  '<span class="label label-danger"> <i class="fa fa-medkit"></i>&nbsp;['.core( $model->id).']</span>';}
  elseif ($conta<3) {return  '<span class="label label-warning"> <i class="fa fa-medkit"></i>&nbsp;['.core( $model->id).']</span>';}
  elseif ($conta<5) {return  '<span class="label label-info"> <i class="fa fa-medkit"></i>&nbsp;['.core( $model->id).']</span>';}
  else {
    return  '<span class="label label-success"> <i class="fa fa-medkit"></i>&nbsp;['.core( $model->id).']</span>';}


  },
'filter'=>array("0"=>"0","5"=>"5"),
],

[
 'attribute'=>'emp_mobile',
 'label'=>'Contacto',
 'format'=>'raw',
 'value' => function ($model) {
return Yii::$app->user->identity->role>10? $model->emp_mobile: "--";
   
 },
],			
			
          

            ['class' => 'yii\grid\ActionColumn',
            'template'=>'{view} {update}',
                            'buttons'=>[
                              'create' => function ($url, $model) {     
                                return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, [
                                        'title' => Yii::t('yii', 'Create'),
                                ]);                                
            
                              }
                          ]/**/],
        ],

    ]); ?>
		<?php Pjax::end(); ?>
   <p>
     <?= Html::a('<i class="glyphicon glyphicon-home"></i>', ['site/index'], ['class' => 'btn btn-danger']) ?>    
        <?= Html::a('<i class="fa fa-plus"></i> Novo Beneficiário', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
</div>

</div>

<?php } ?>
