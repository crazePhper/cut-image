<?php
use yii\widgets\LinkPager;
$this->title = '操作日志'
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <form action="" method="get" id="form-search">
                    <input type="hidden" name="time" value="<?= $params['time']?>">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-2">
                                <input type="text" placeholder="请输入姓名" class="form-control" name="name" value="<?= isset($params['name']) ? $params['name'] : '' ?>" maxlength="20">
                            </div>
                            <div class="col-md-2">
                                <input type="text" placeholder="请输入手机号" class="form-control" name="phone" value="<?= isset($params['phone']) ? $params['phone'] : '' ?>" maxlength="15">
                            </div>
                            <!--<div class="col-md-3">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input id="start" value="<?/*= $params['startTime'] ?? ''*/?>" name="startTime" class="datepicker form-control" type="text" placeholder="激活时间">
                                    <span class="input-group-addon" style="border: 0px; background-color: #FFF">-</span>
                                    <input id="end" value="<?/*= $params['endTime'] ?? ''*/?>" name="endTime" class="datepicker form-control" type="text" placeholder="激活时间">
                                </div>
                            </div>-->
                            <div>
                                <span class="input-group-btn">
                                   <button type="submit" class="btn btn-primary" style="border-radius: 3px;"> 搜索</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="box-body">
                <div class="col-sm-12">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td>序号</td>
                                <td>用户</td>
                                <td>类型</td>
                                <td>表名</td>
                                <td>路由</td>
                                <td>描述</td>
                                <td>IP</td>
                                <td>时间</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!empty($model)) {
                            $i = 0;
                            foreach ($model as $value) {
                                ?>
                                <tr>
                                    <td>
                                        <?= ++$i+($page - 1) * $pageNum ?>
                                    </td>

                                    <td>
                                        <?= $value['username'] ?? '' ?>
                                    </td>
                                    <td>
                                        <?= $value['type']?>
                                    </td>
                                    <td>
                                        <?= $value['table_name']?>
                                    </td>
                                    <td>
                                        <?= $value['route'] ?? '' ?>
                                    </td>
                                    <td style="width: 55%;">
                                        <?= $value['description'] ?? ''?>
                                    </td>
                                    <td>
                                       <?= long2ip($value['ip']) ?? ''?>
                                    </td>
                                    <td>
                                        <?= $value['created_at'] ?? '' ?>
                                    </td>
                                </tr>
                            <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <div class="data-tables-info">
                        显示 <?= ($page - 1) * $pageNum + 1 ?>到 <?= $page * $pageNum ?> 项，共 <?= $total ?> 项
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="data-tables-page">
                        <?php echo LinkPager::widget(['pagination' => $pages]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>