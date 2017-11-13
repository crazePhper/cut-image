<?php

namespace backend\controllers;
use Yii;
use yii\db\Query;
use yii\data\Pagination;
use backend\models\AdminLog;

class AdminLogController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        $pageNum = 10;
        //设置默认请求页
        $request =  Yii::$app->request;
        $page = $request->get('page', 1);
        $data['ip'] = Yii::$app->request->get('ip');
        $data['phone'] = trim(Yii::$app->request->get('phone'));
        $data['name'] = Yii::$app->request->get('name');
        $data['time'] = Yii::$app->request->get('time');

        $query = AdminLog::find()->select('id')->orderBy("id desc");

        if (!empty($data['user_id'])) {
            $query->andWhere(['user_id'=>$data['user_id']]);
        }

        if (!empty($data['phone'])) {
            $query->andWhere(['ip'=>ip2long($data['ip'])]);
        }

        $total = $query->count();

        $pages = new Pagination(['totalCount' => $total, 'pageSize' => $pageNum]);

        $idArr = $query->offset(($page - 1) * $pageNum)->limit($pages->limit)->orderBy('id desc')->asArray()->all();

        $model = (new Query())->select(['l.*',
            'u.username'])->from("admin_log as l")
            ->leftJoin("user as u","l.user_id=u.id")
            ->where(['in','l.id',array_column($idArr,'id')])->orderBy('l.id desc')->all();

        return $this->render('index', [
            'model'     => $model,
            'pages'     => $pages,
            'total'     => $total,
            'page'      => $page,
            'pageNum'   => $pageNum,
            'params'    => $data,
        ]);

        return $this->render('index');
    }

}
