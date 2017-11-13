<?php
use yii\widgets\LinkPager;
use yii\grid\GridView;
use adminlog\models\AdminLog;
$this->title = '操作日志'
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'table_name',
        [
            'attribute'=>'type',
            'value'=>function($data){
                return AdminLog::$types[$data->type]??'';
            }
        ],
        'description',
        'route',
        [
            'attribute'=>'ip',
            'value'=>function($data){
                return long2ip($data->ip);
            }
        ],
        'created_at',
    ],
    'emptyText'=>'当前没有数据',
    'emptyTextOptions'=>['style'=>'color:red;font-weight:bold']
]);?>
