<?php

namespace adminlog\controllers;
use Yii;
use yii\data\ActiveDataProvider;
use adminlog\models\AdminLog;

class AdminLogController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query = AdminLog::find();

        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
            'pagination'=>[
                'pagesize'=>20
            ]
        ]);

        $dataProvider->setSort(false);

        return $this->render('@adminlog/views/admin-log/index', [
            'dataProvider'=>$dataProvider
        ]);
    }

}
