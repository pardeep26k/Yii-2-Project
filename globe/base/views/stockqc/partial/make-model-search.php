<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yiister\gentelella\widgets\Panel;
use common\helpers\StockqcHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\backoffice\UsedcarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Make Model Version List');
$this->params['breadcrumbs'][] = $this->title;
?>

<table class="table table-striped table-bordered table-full-width no-footer dataTable" id="mmvList" width="100%" role="grid" aria-describedby="mmvList_info" style="width: 100%;">
    <thead>
        <tr role="row">
            <th class="sorting_desc" tabindex="0" aria-controls="mmvList" rowspan="1" colspan="1" aria-label="Make: activate to sort column ascending" style="width: 31px;" aria-sort="descending">Make</th>
            <th class="sorting" tabindex="0" aria-controls="mmvList" rowspan="1" colspan="1" aria-label="Model: activate to sort column ascending" style="width: 35px;">Model</th>
            <th class="sorting" tabindex="0" aria-controls="mmvList" rowspan="1" colspan="1" aria-label="Version: activate to sort column ascending" style="width: 45px;">Version</th>
            <th class="sorting" tabindex="0" aria-controls="mmvList" rowspan="1" colspan="1" aria-label="Fuel type: activate to sort column ascending" style="width: 30px;">Fuel type</th>
            <th class="sorting" tabindex="0" aria-controls="mmvList" rowspan="1" colspan="1" aria-label="Body type: activate to sort column ascending" style="width: 37px;">Body type</th>
            <th class="sorting" tabindex="0" aria-controls="mmvList" rowspan="1" colspan="1" aria-label="Tranmission: activate to sort column ascending" style="width: 71px;">Tranmission</th>
            <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Model Status" style="width: 74px;">Model Status</th>
            <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Variant Status" style="width: 74px;">Variant Status</th>
            <th class="sorting" tabindex="0" aria-controls="mmvList" rowspan="1" colspan="1" aria-label="Last Updated date: activate to sort column ascending" style="width: 56px;">Last Updated date</th>
            <th class="sorting" tabindex="0" aria-controls="mmvList" rowspan="1" colspan="1" aria-label="Rpm: activate to sort column ascending" style="width: 27px;">Rpm</th>
            <th class="sorting" tabindex="0" aria-controls="mmvList" rowspan="1" colspan="1" aria-label="Displacement: activate to sort column ascending" style="width: 79px;">Displacement</th>
        </tr>
    </thead>
    <tbody id="table_body">
        <?php
        foreach ($dataProvider as $key => $val) {
            ?>
            <tr role="row" class="odd">
                <td class="sorting_1"><?= $val['brandName']; ?></td>
                <td><?= ($val['modelName'] != '') ? $val['modelName'] : 'N/A'; ?></td>
                <td><?= ($val['versionName'] != '') ? $val['versionName'] : 'N/A'; ?></td>
                <td><?= ($val['FuelType'] != '') ? $val['FuelType'] : 'N/A'; ?></td>
                <td><?= ($val['BodyType'] != '') ? $val['BodyType'] : 'N/A'; ?></td>
                <td><?= ($val['TransmissionType'] != '') ? $val['TransmissionType'] : 'N/A'; ?></td>
                <td><?= ($val['brandStatus'] != '') ? $val['brandStatus'] : 'N/A'; ?></td>
                <td><?= ($val['versionStatus'] != '') ? $val['versionStatus'] : 'N/A'; ?></td>
                <td><?= ($val['Updated_at'] != '') ? $val['Updated_at'] : 'N/A'; ?></td>
                <td><?= ($val['Rpm'] != '') ? $val['Rpm'] : 'N/A'; ?></td>
                <td><?= ($val['Displacement'] != '') ? $val['Displacement'] : 'N/A'; ?></td>
            </tr>
        <?php } ?>
</table>
<script>
    
    $('.dataTable').dataTable({
        "aoColumnDefs": [{'bSortable': false, 'aTargets': [1]}],
        "aLengthMenu": [[10, 20, 50, 100, 150, -1], [10, 20, 50, 100, 150, "All"]],
        "iDisplayLength": 10,
       "ordering": false,
        
    });

</script>