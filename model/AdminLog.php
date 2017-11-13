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
    
    public static function write($event)
    {
        // 排除日志表自身,没有主键的表不记录（没想到怎么记录。。每个表尽量都有主键吧，不一定非是自增id）
        if($event->sender instanceof \common\models\AdminLog || !$event->sender->primaryKey()) {
            return;
        }
        $type = NULL;

        // 显示详情有待优化,不过基本功能完整齐全
        if ($event->name == ActiveRecord::EVENT_AFTER_INSERT) {
            $description = "%s新增了表%s %s:%s的%s";
            $type = 'add';
        } elseif($event->name == ActiveRecord::EVENT_AFTER_UPDATE) {
            $description = "%s修改了表%s %s:%s的%s";
            $type = 'update';
        } else {
            $description = "%s删除了表%s %s:%s%s";
            $type = 'delete';
        }

        if (!empty($event->changedAttributes)) {
            $desc = '';
            foreach($event->changedAttributes as $name => $value) {
                $desc .= $name . ' : ' . $value . '=>' . $event->sender->getAttribute($name) . ',';
            }
            $desc = substr($desc, 0, -1);
        } else {
            $desc = '';
        }

        $userName = Yii::$app->user->identity->username;

        $tableName = $event->sender->tableSchema->name;

        $description = sprintf($description, $userName, $tableName, $event->sender->primaryKey()[0], $event->sender->getPrimaryKey(), $desc);

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
