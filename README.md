管理后台操作mysql日志 --测试发布一个包
=============
admin backend operating the mysql log

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist easydowork/yii2-admin-log "*"
```

or add

```
"easydowork/yii2-admin-log": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
//main.php 配置文件 添加如下代码
'controllerMap'=>[
    'adminlog'=>[
        'class'=>'adminlog\controllers\AdminLogController',
    ]
],
'on beforeRequest' => function($event) {
    \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_INSERT, ['adminlog\models\AdminLog', 'write']);
    \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_UPDATE, ['adminlog\models\AdminLog', 'write']);
    \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_DELETE, ['adminlog\models\AdminLog', 'write']);
},
```
访问 www.url.com/admin-log
