<?php

namespace adminlog\models;

use Yii;
use yii\helpers\Url;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "admin_log".
 *
 * @property integer $id
 * @property string $user_id
 * @property string $type
 * @property string $table_name
 * @property string $route
 * @property string $description
 * @property string $ip
 * @property string $created_at
 */
class AdminLog extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_log';
    }

    public static $types = [
        1=>'更新',
        2=>'删除',
        3=>'添加',
    ];

    public function attributeLabels()
    {
        return [
            'id'            => '编号',
            'user_id'       => '用户',
            'type'          => '类型',
            'table_name'    => '表名',
            'description'   => '描述',
            'route'         => '路由',
            'ip'            => 'IP',
            'created_at'    => '时间',
        ];
    }

    public static function write($event)
    {
        if($event->sender instanceof \adminlog\models\AdminLog || !$event->sender->primaryKey()) {
            return;
        }

        $type = NULL;

        if ($event->name == ActiveRecord::EVENT_AFTER_INSERT) {
            $type = 3;
        } elseif($event->name == ActiveRecord::EVENT_AFTER_UPDATE) {
            $type = 1;
        } elseif($event->name == ActiveRecord::EVENT_AFTER_DELETE) {
            $type = 2;
        }else{
            return;
        }

        if (!empty($event->changedAttributes)) {
            $desc = '';
            foreach($event->changedAttributes as $name => $value) {
                $desc .= $name . ' : ' . $value . '=>' . $event->sender->getAttribute($name) . ',';
            }
            $desc = substr($desc, 0, -1);
        } else {
            return;
        }

        $tableName = $event->sender->tableSchema->name;

        $types = self::$types;

        $userName = Yii::$app->user->identity->username;

        $description = $userName . $types[$type].'数据：主键 '.$event->sender->primaryKey()[0].'='.$event->sender->getPrimaryKey().',描述：'.$desc;

        $data = [
            'user_id'       => Yii::$app->user->id,
            'type'          => $type,
            'table_name'    => $tableName,
            'route'         => Url::to(),
            'description'   => $description,
            'ip'            => ip2long(Yii::$app->request->userIP)
        ];

        Yii::$app->db->createCommand()->insert('admin_log',$data)->execute();
    }
}
