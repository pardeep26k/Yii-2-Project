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
<script src="http://beta.inspection.gaadi.com/assets/vendor/jquery/jquery.min.js"></script>
<script src="/js/select2.min.js"></script>
<style>
    div.dataTables_wrapper div.dataTables_length select {
        height: 28px;
        background: rgba(255,255,255,0.9);
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        margin-left: -2px;
        border-color: #ccc !important;
        color: #4386cc !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        color: #4386cc !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
        color: #4386cc !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        color: #fff !important;
    }
    .pagination {
        margin-left: 260px;
    }
    .input-group {
        margin-bottom: 10px;
        margin-left: -226px;
    }
    .select2-container--default .select2-selection--single {
        border-radius: 0px; 
    }
    .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
        background-color: #26B99A;
        border-color: #26B99A;
    }
</style>
<?= Html::beginForm(['makemodel'], 'post', ['name' => 'make_model', 'id' => 'make_model', 'data-parsley-validate']) ?>
<h2><?= Html::encode($this->title) ?></h2>    
<div class="clearfix qc-filter">
    <div class="row col-md-12">
        <div class="col-md-2 pad-LR5">
            <div class="form-group">
                <select class="js-example-basic-single js-states form-control changeFilter makeSearch" name="makeSearch" id="makeSearch" tabindex="-1" style="display: none;">
                    <?php
                    $i = 0;
                    foreach ($allBrand as $key => $vals) {
                        ?>
                        <option value="<?= $key ?>">
                            <?= $vals ?>
                        </option>
                        <?php $i++;
                    } ?>
                </select>
                <span style="display: none;" class="select2 select2-container select2-container--default" dir="ltr" style="width: 144px;"><span class="selection">
                        <span class="select2-selection select2-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-owns="select2-makeSearch-results" aria-labelledby="select2-makeSearch-container">
                            <span class="select2-selection__rendered" id="select2-makeSearch-container" title="Select Make">Select Make</span>
                            <span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span>
                    <span class="dropdown-wrapper" aria-hidden="true">

                    </span>

                </span>
            </div>
        </div>
        <div class="col-md-2 pad-LR5">
            <div class="form-group">
                <select class="js-example-basic-single js-states form-control modelSearch changeFilter" name="modelSearch" id="modelSearch" tabindex="-1" style="display: none;">
                    <option value="">Select Model</option>
                    <?php foreach ($models as $k => $v) { ?>
                        <option value="0"><?php echo $v; ?></option>
<?php } ?>
                </select>
                <span style="display:none;" class="select2 select2-container select2-container--default" dir="ltr" style="width: 144px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-owns="select2-modelSearch-results" aria-labelledby="select2-modelSearch-container"><span class="select2-selection__rendered" id="select2-modelSearch-container" title="Select Model">Select Model</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
            </div>
        </div>
        <div class="col-md-2 pad-LR5">
            <div class="form-group">
                <select class="js-example-basic-single js-states form-control changeFilter" name="variantSearch" id="variantSearch" tabindex="-1" style="display: none;">
                    <option value="">Select Variant</option>
                </select>
                <span style="display: none" class="select2 select2-container select2-container--default" dir="ltr" style="width: 144px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-owns="select2-variantSearch-results" aria-labelledby="select2-variantSearch-container"><span class="select2-selection__rendered" id="select2-variantSearch-container" title="Select Variant">Select Variant</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
            </div>
        </div>
        <div class="col-md-3 pad-LR5">
            <div class="form-group">
            <!--                    <select class="js-example-basic-single js-states form-control changeFilter" name="modelStatus" id="modelStatus" tabindex="-1" style="display: none;">
                    <option value="">Select Model Status</option>
                    <option value="0">
                        Active                                </option>
                    <option value="1">
                        Discontinued                                </option>
                    <option value="2">
                        Upcoming                                </option>
                    <option value="3">
                        International                                </option>
                    <option value="4">
                        Dead                                </option>
                    <option value="5">
                        Deleted                                </option>
                </select>-->
                <span style="display: none" class="select2 select2-container select2-container--default" dir="ltr" style="width: 221px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-owns="select2-modelStatus-results" aria-labelledby="select2-modelStatus-container"><span class="select2-selection__rendered" id="select2-modelStatus-container" title="Select Model Status">Select Model Status</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
            </div>
        </div>
        <div class="col-md-2 pad-LR5">
            <div class="input-group input-daterange">
               <span>
<?= Html::buttonInput(Yii::t('app', 'Search'), ['id' => 'search_buttons', 'class' => 'btn btn-success mrg-T20']) ?>
                </span>
                <input type="reset" id="reset_form" class="btn btn-default mrg-T20" style="width: 66px;height: 34px;" value="Reset">

            </div>
        </div>
    </div>
</div>

<div class="usedcar-view">

    <p>

    <div class="row">
        <div class="col-md-12 col-xs-12">

            <div id="mmvList_wrapper " class="dataTables_wrapper no-footer empty_table">
                <div id="mmvList_processing" class="dataTables_processing" style="display: none;"></div>
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
                <?= Html::hiddenInput('page', '1', ['id' => 'page']) ?>
                <?php
//                echo $this->render('partial/index_pagination', [
//                    'pagination' => $pagination,
//                ]);
                ?>
            </div>
<?= Html::endForm() ?>
        </div>
    </div>
</div>

<div id="loadmoreajaxloader"  style="text-align:center;margin-bottom:20px;font-size:10px;display:none;">
<?= Html::img("/backend/web/images/loading.gif", ['title' => Yii::t('app', 'Click for more')]) ?>Loading...</div>
</div>
<script>

   

    $('#reset_form').on('click', function () {
        location.reload();
    });
    $(".js-example-basic-single").select2({
        tags: true
    }).on('change', function () {
        var $selected = $(this).find('option:selected');
        var $container = $(this).siblings('.js-example-tags-container');

        var $list = $('<ul>');
        $selected.each(function (k, v) {
            var $li = $('<li class="tag-selected"><a class="destroy-tag-selected">×</a>' + $(v).text() + '</li>');
            $list.append($li);
        });
        $container.html('').append($list);
    }).trigger('change');

    $(".makeSearch").select2({
        tags: true
    }).on('change', function () {
        var selected = $("#makeSearch option:selected").val();
        $.ajax({
            type: 'POST',
            url: "/stockqc/getmodels",
            data: {brandId: selected},
            success: function (result) {
                $('#modelSearch').children("option").remove();
                $('#modelSearch').prop("disabled", false);
                $('#modelSearch').append(new Option('Select', ''));
                $.each(result.result, function (i, item) {
                    $('#modelSearch').append(new Option(item.model, item.model_id));
                });
            }
        });
    }).trigger('change');


    $(".modelSearch").select2({
        tags: true
    }).on('change', function () {
        var selected = $(".modelSearch option:selected").val();
        //alert(selected);
        $.ajax({
            type: 'POST',
            url: "/stockqc/getvariants",
            data: {modelId: selected},
            success: function (result) {
                $('#variantSearch').children("option").remove();
                $('#variantSearch').prop("disabled", false);
                $('#variantSearch').append(new Option('Select', ''));
                $.each(result.result, function (i, item) {
                    $('#variantSearch').append(new Option(item.variant, item.variant_id));
                });
            }
        });
    }).trigger('change');

    $('#search_buttons').on('click', function () {
        var formData = $('#make_model').serialize();
        getSearchResults(formData);
    });
    $('.resetResults').on('click', function () {
        var formData = $('#make_model').serialize();

        setTimeout(function () {
            getSearchResults(formData);
        }, 500);
    });
    var getSearchResults = function () {
        $('.searchresultloader').css('display', 'block');
        var postData = $("#make_model").serialize();
        $.ajax({
            type: 'POST',
            url: "/stockqc/getsearchfilter",
            data: postData,
            success: function (result) {
                $('.empty_table').empty();
                $('.empty_table').append(result);
                $(".pagination").click(function () {
                    $('body,html').animate({
                        scrollTop: 0
                    }, 500);
                });
            }
        });
    };

</script>
