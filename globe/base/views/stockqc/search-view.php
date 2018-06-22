<?php

use yii\helpers\Html;
use yiister\gentelella\widgets\Panel;

/* @var $this yii\web\View */
/* @var $result common\models\Usedcar */

$this->title = Yii::t('app', 'Stock Generic Search');
?>
<div class="usedcar-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?php
        Panel::begin(
            [
                'header' => Yii::t('app', 'Search By Reg No / Car Id / OTO Id'),
            ]
        )
        ?>
        <div class="x_content">
        <br />
        <?= Html::beginForm(['stocksearch'], 'post', ['name' => 'search_stockqc', 'id' => 'search_stockqc', 'enctype' => 'multipart/form-data', 'data-parsley-validate', 'class' => 'form-vertical form-label-left']) ?>
        <div class="form-group">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <?= Html::input('text', 'search_key', '', ['id' => 'search_key', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => Yii::t('app', 'Enter Keyword'), 'onkeydown' => 'Javascript: if (event.keyCode == 13) { $("#search_button").click(); }', 'required' => 'required']) ?>
            </div>
        </div>
        <div class="form-group">
          <div class="col-md-3 col-sm-3 col-xs-12" style="margin-top: -24px;">
              <label>Search On</label>
              <?php
                $fieldList = [
                    'regno' => 'Reg No',
                    'usedcar.id'  => 'Car Id',
                    'oto_id' => 'Oto Id',
                ];
           ?>
           <?= Html::dropDownList('search_on', '', $fieldList, ['class' => 'form-control', 'id' => 'search_on']) ?>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-1 col-sm-3 col-xs-12">
            <?= Html::submitButton(Yii::t('app', 'Search'), ['id' => 'search_button', 'class' => 'btn btn-success'])?>
          </div>
        </div>
        <?= Html::endForm() ?>
        </div>
        <?php Panel::end() ?>
    </p>
    <?php
        Panel::begin(
            [
                'header' => Yii::t('app', 'Stock Details'),
            ]
        )
        ?>
    <div class="x_content">
    <br />
    <?php
    if(empty($result))
    {
    ?>
        <p>No record found for this keyword</p>
    <?php
    }
    else
    {
    ?>
    <div class="col-md-6 col-sm-6 col-xs-12">
    <?php
        Panel::begin()
        ?>
        <table class="table">
        <tr>
            <th>Reg No</th>
            <td><?=$result['regno'];?></td>
        </tr>
        <tr>
            <th>Car Id</th>
            <td><?=$result['car_id'];?></td>
        </tr>
        <tr>
            <th>Oto Id</th>
            <td><?=$result['oto_id'];?></td>
        </tr>
        <tr>
            <th>Make</th>
            <td><?=$result['make'];?></td>
        </tr>
        <tr>
            <th>Model</th>
            <td><?=$result['model'];?></td>
        </tr>
        <tr>
            <th>Variant</th>
            <td><?=$result['variant'];?></td>
        </tr>
        <tr>
            <th>Seller Type</th>
            <td><?='dealer';?></td>
        </tr>
        <tr>
            <th>Dealer Name</th>
            <td><?=$result['organization'];?></td>
        </tr>
        <tr>
            <th>Dealer Address</th>
            <td><?=$result['address'];?></td>
        </tr>
        <tr>
            <th>Dealer Email</th>
            <td><?=$result['username'];?></td>
        </tr>
        </table>
    <?php Panel::end() ?>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
    <?php
        Panel::begin()
        ?>
        <table class="table">
        <tr>
            <th>Dealer Mobile</th>
            <td><?=$result['mobile'];?></td>
        </tr>
        <tr>
            <th>Uploaded By</th>
            <td><?=($result['created_by'] == 'bm')?$result['created_by'].' ('.$result['bm_name'].')':$result['created_by'].' ('.$result['dealer_name'].')';?></td>
        </tr>
        <tr>
            <th>Uploaded On</th>
            <td><?=date('Y-m-d H:i',strtotime('+1 hour +30 minutes',strtotime($result['created_at'])));
            ?></td>
        </tr>
        <tr>
            <th>Last edited on</th>
            <td><?=$result['updated_at'];?></td>
        </tr>
        <tr>
            <th>Inventory Status</th>
            <td><?=(($result['inventory_status']=='1')?'Active':'Inactive');?></td>
        </tr>
        <tr>
            <th>QC Status</th>
            <td><?=$result['qc_status'];?></td>
        </tr>
        <tr>
            <th>QC Done By</th>
            <td><?=$result['qc_done_by'];?></td>
        </tr>
        <tr>
            <th>Total pics</th>
            <td><?=$totalPics;?></td>
        </tr>
        <tr>
            <th>Total leads</th>
            <td><?=$totalLeads;?></td>
        </tr>
        </table>
    <?php Panel::end() ?>
    </div>
    <?php
        }
     ?>
    </div>
    <?php Panel::end() ?>
</div>