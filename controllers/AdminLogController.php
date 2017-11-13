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
            'sort' => ['defaultOrder' => ['id' => SORT_ASC]],
            'pagination'=>[
                'pagesize'=>2
            ]
        ]);

        $dataProvider->setSort(false);

        return $this->render('@adminlog/views/admin-log/index', [
            'dataProvider'=>$dataProvider
        ]);
    }

}
