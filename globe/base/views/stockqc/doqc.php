<?php

use common\helpers\DateHelper;
$minYear = DateHelper::getYearsList(1990);
$qcStartTime = date('Y-m-d h:m:s',time());
$fieldValues['regno'] = ['value' => $car->usedcarRegistration->regno];
$fieldValues['km'] = ['value' => $car->km];
$fieldValues['model'] = ['value' => $userModel, 'items' => $modelData];
$fieldValues['variant'] = ['value' => $userVariant, 'items' => $variantData];
$fieldValues['version'] = ['value' => $userVariant, 'items' => $variantData];
$fieldValues['year'] = ['value' => $car->year, 'items' => $minYear];
$fieldValues['power'] = ['value' => $car->brandModelVariant->power];
$fieldValues['validity'] = ['value' => $car->usedcarRegistration->validity];
$fieldValues['make'] = ['value' => $userBrand, 'items' => $userBrand];
$fieldValues['Displacement'] = ['value' => $versionNotAvailableData['displacement'], 'items' => $versionNotAvailableData['displacement']];
$fieldValues['SeatingCapacity'] = ['value' => $versionNotAvailableData['seating_capacity'], 'items' => $versionNotAvailableData['seating_capacity']];
$fieldValues['versionTemp'] = ['value' => $versionNotAvailableData['version_text'], 'items' => $versionNotAvailableData['version_text']];
?>
<div id="app">
    <div id="app" class="padding-top-0 qcpanelparent">
        <div class="app-content">
            <div class="main-content margin-left-0" >
                <div class="wrap-content container" id="container">
                    <!-- start: PAGE TITLE -->
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle">QC Panel <span class="subtitle-qc">QC Checklist</span></h1>

                            </div>
                            <ol class="breadcrumb">
                                <li>										
                                    <a href="/"><span>Home</span></a>
                                </li>
                                <li class="dealerQcList">
                                    <a href="/stockqc"><span>Stock Evaluation QC</span></a>
                                </li>
                                <li class="active">
                                    <span>QC Panel</span>
                                </li>
                            </ol>
                        </div>
                    </section>
                    <!-- end: PAGE TITLE -->
                    <!-- start: YOUR CONTENT HERE -->
                    <!-- end: YOUR CONTENT HERE -->
                </div>

                <!-- start: QC PANEL -->
                <div class="container-fluid container-fullw padding-bottom-5 border-bottom">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="clearfix padding-10 padding-vertical-15">
                                    <div class="col-md-2 text-center no-padding">
                                        <div class="border-right border-dark">
                                            <span class="text-bold block text-large"><?= $car->usedcarRegistration->regno ?></span>
                                            <span class="text-light">Registration Number</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center no-padding">
                                        <div class="border-right border-dark">
                                            <span class="text-bold block text-large"><?= $car->created_at ?></span>
                                            <span class="text-light">Evaluation Date</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center no-padding">
                                        <div class="border-right border-dark">
                                            <span class="text-bold block text-large"><?= $car->dealer->name; ?></span>
                                            <span class="text-light">Dealer Name</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center no-padding">
                                        <div class="border-right border-dark">
                                            <span class="text-bold block text-large"><?php echo $car->sfaUser->name; ?></span>
                                            <span class="text-light">CE Name</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center no-padding">
                                        <span class="text-bold block text-large"><?= count($car->usedcarImages); ?></span>
                                        <span class="text-light">Total Images</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if($car->qc_status != 'pending')
                {
                    echo '<div class="container-fluid container-fullw bg-white padding-bottom-5 margin-bottom-60 border-bottom">
                    <p>QC has been done already for this stock.</p>
                    </div>';
                }
                elseif($car->created_by == 'dealer')
                {
                    echo '<div class="container-fluid container-fullw bg-white padding-bottom-5 margin-bottom-60 border-bottom">
                    <p>QC not required, Stock created by dealer.</p>
                    </div>';
                }
                else
                {
                ?>
                <form action="" method="post" name="qcPanelForm" id="qcPanelForm">
                    <input name="qcPanelData" id="qcPanelData" type="hidden" 
                           value="qcPanelData">
                    <input name="nameform" id="nameform" type="hidden" 
                           value="qcPanelData">
                    <input name="qcStartDatetime" id="qcStartDatetime" type="hidden" 
                           value="<?=$qcStartTime;?>">
                    <input name="certificationID" id="certificationID" type="hidden" 
                           value="<?= $car->id; ?>">
                    <input name="usedCarID" id="usedCarID" type="hidden" 
                           value="<?= $car->id; ?>">
                    <input name="group_id" id="owner_id" type="hidden" 
                           value="1">
                    <div class="container-fluid container-fullw bg-white padding-bottom-5 margin-bottom-60 border-bottom">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 tag-pane">
                                <h5 class="over-title margin-bottom-15 margin-top-15"><span class="text-bold tag-name-title">Title Name</span></h5>
                            </div>						
                            <div class="col-md-8 col-lg-9">
                                <div class="qc-slider">

                                    <div class="docs-buttons hide edit-img-btns">
                                        <div class="btn-group">
                                            <button class="btn btn-primary" title="Crop" data-option="crop" data-method="setDragMode" type="button">
                                                <span class="docs-tooltip" title="Crop" data-toggle="tooltip" data-original-title="$().cropper(\"setDragMode\", \"crop\")">
                                                      <span class="fa fa-check"></span>
                                                </span>
                                            </button>
                                            <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
                                                <span class="docs-tooltip" data-toggle="tooltip" title="Clear">
                                                    <span class="fa fa-remove"></span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>


                                    <ul class="bxslider">
                <?php
                $items = '';
                foreach ($ucit as $tag) {
                    foreach ($images[$tag] as $image) {
                        $tagName = \common\models\UsedcarImageTag::findOne(['id' => $tag]);
                        $items .= '<li id="' . $tag . '"><input type="hidden" name="tag-name-' . "$tag" . '" id="tag-name-' . "$tag" . '" value="' . \common\helpers\LocaleHelper::translate('tag_name', $tagName) . '">
<div class="list-thumb" id="list-thumb-' . "$tag" . '">
<div class="img-thumb img-container" id="cropContainerPreload-' . "$tag" . '">
<div class="slider-btn-box">
<div class="slider-btn imageEditContainerCropper" id="' . "$tag" . '" style="margin-right:15px" title="Crop Image">
<i class="fa fa-crop"></i>
</div>
<div class="slider-btn imageEditContainerCropperZoom" id="' . "$tag" . '" style="margin-right:15px" title="Zoom Image">
  <i class="fa fa-search-plus"></i>
</div>
<div class="slider-btn imageRotateContainer" id="rotate-' . "$tag" . '" title="Rotate Image">
<span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
</div>
</div>' .
                                "<img class='img-responsive' id = '" . 'imageCont-' . $tag . "' src='" . \Yii::$app->params['imageUrl'] . '/usedcar/original/' . $image->image . "' img-path='" . \Yii::getAlias('@upload') . '/' . $image->url . "' img-name='".$image->image."' img-id='".$image->id."' cert-id='".$car->id."' img_type='1'>" .
                                '<div class="imageCheck">
<div class="checkbox clip-check check-primary">
</div>  
</div>
</div> 
</div></li>';
                    }
                }
                echo $items;
                ?>
                                    </ul>

                                </div>

                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="clearfix pull-left">
                                            <label for=""></label>
                                            <div class="form-group">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="clearfix pull-right">
                                            <div class="outside bx-slider-controls">
                                                <span id="slider-prev" class="slide-prev" style="display:none"></span>
                                                <span id="slider-next" class="slide-next"></span>
                                                <span id="slider-finish" class="bx-slider-finish slide-finish" style="display: none"><a>Finish</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php foreach ($ucit as $tag) { ?>
                                <div class="col-md-4 col-lg-3 image-tag-pane" id="image-tag-<?= $tag; ?>" style="display: <?= ($tag == $ucit[0]) ? 'block' : 'none'; ?>;">
                                <?php $questions = $tagQuestions->getTagQuestions($tag);
                                ?>
                                    <div class="clearfix margin-bottom-20">
                                        <div class="radio clip-radio radio-primary no-margin">
                                            <input type="radio" id="imageSatisfactionY<?= $tag; ?>" checked="checked" class="required questionY questionY_<?= $tag; ?>" data-tagid="<?= $tag; ?>" name="imageSatisfaction[<?= $tag; ?>][answer]" value="Satisfactory">
                                            <label for="imageSatisfactionY<?= $tag; ?>">Image Satisfactory</label>
                                        </div>
                                        <div class="clearfix margin-left-20">
    <?php foreach ($questions[1] as $question) { ?>
                                                <div class="checkbox clip-check check-primary">
                                                <?= $question->question; ?>
                                                </div> 
                                                <?php } ?>
                                        </div>
                                    </div>
                                    <div class="clearfix margin-bottom-20">
                                        <div class="radio clip-radio radio-primary no-margin">
                                            <input type="radio" value="Not Satisfactory" id="imageSatisfactionN<?= $tag; ?>" data-tagid="<?= $tag; ?>" class="required imageNo_3 questionN" name="imageSatisfaction[<?= $tag; ?>][answer]">
                                            <label for="imageSatisfactionN<?= $tag; ?>">Image Not Satisfactory</label>
                                        </div>
                                        <div class="clearfix margin-left-20">
    <?php foreach ($questions[0] as $key => $question) { ?>
                                                <div class="checkbox clip-check check-primary">
                                                    <input type="checkbox" value="<?= $question->id; ?>" data-tagid="<?= $tag; ?>" class="questionN questionN_<?= $tag; ?>" data-otherval="<?= $question->question; ?>" id="imageSatisfaction[<?= $tag; ?>][reason][<?= $key; ?>]" name="imageSatisfaction[<?= $tag; ?>][reason][]">
                                                    <label for="imageSatisfaction[<?= $tag; ?>][reason][<?= $key; ?>]"><?= $question->question; ?></label>
                                                </div>
    <?php } ?>
                                            <div class="form-group col-lg-12">
                                                <textarea rows="3" class="form-control otherText_<?= $tag; ?>" style="display: none;" name="imageSatisfaction[<?= $tag; ?>][otherReason]"></textarea>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
<?php } ?>
                            <div class="clearfix"></div>
                        </div>

                        <div class="clearfix margin-top-20">
<?php 
foreach ($fields as $field) {
    if (in_array($field->tag_id, $ucit)) {
        ?>
                                    <div class="col-md-3 field-tag-pane field-tag-<?= $field->tag_id; ?>" style="display: <?= ($field->tag_id == $ucit[0]) ? 'block' : 'none'; ?>;">                                	
                                        <div class="form-group">
        <?= $this->render('partial/fieldPartial', ['field' => $field, 'fieldValues' => $fieldValues, 'inputType' => $field->field_input_type]); ?>
                                        </div>
                                    </div>
    <?php }
}
?>
                        </div>
                        <input type="hidden" id="nextprevflag" name="nextprevflag" value="0">
                        </form>
                        <?php
                }
                        ?>
                        <!-- end: QC PANEL -->
                    </div>
            </div>
        </div>
    </div>
</div>
<script>

 </script>