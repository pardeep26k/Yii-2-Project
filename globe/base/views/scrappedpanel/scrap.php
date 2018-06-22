
<?php

use yii\helpers\Html;
use yii\web\Cookie;
use yii\widgets\LinkPager;

$this->registerJsFile('@web/js/oto_panel.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
 
  
<div class="col-lg-12">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div id="flashmsg" class="alert alert-success" role="alert">
            <?php echo Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>
</div>
<div class="col-lg-12">
    <?php if (Yii::$app->session->hasFlash('failure')): ?>
        <div id="flashmsgerror" class="alert alert-danger" role="alert">
            <?php echo Yii::$app->session->getFlash('failure') ?>
        </div>
    <?php endif; ?>
</div>

<!-- search options -->
<form action="" method="Post">
    <div class="clearfix mrgT">
        <div class="col-md-2">
            <label>Make</label>
            <select name="make" id="make" class="form-control" style="background-color: #eee;" >
                <option selected="selected"></option>
                <?php
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                } else {
                    $page = 1;
                };
                $count = $count + $count * ($page - 1) * 10;
                foreach ($makeArray as $mk) {
                    ?>
                    <option value="<?php echo $mk->make; ?>"><?php echo $mk->make; ?></option>

                <?php } ?>
                Make</select>  

        </div>
        <div class="col-md-2">
            <label>Source</label>
            <select name="source" id="source" class="form-control" style="background-color: #eee;">
                <option selected="selected"></option>
                <?php foreach ($sourceArray as $sa) { ?>
                    <option value="<?php echo $sa->portal_name; ?>"><?php echo $sa->portal_name; ?></option>

                <?php } ?>
                Make</select>  

        </div>
       <div class="col-md-6">
            <div class="col-md-6">
                 <label>To:</label><?= \yii\jui\DatePicker::widget([
                  'name' => 'datepickerto',
   'language' => 'en',
   'dateFormat' => 'yyyy-MM-dd',
   'options' => ['class' => 'span2 form-control add-on follow_calender calender','placeholder' => Yii::t('app', 'To'), 'style'=>'cursor:pointer;','readonly'=>'readonly', 'id' => 'follow_date_to']
]); ?>
            </div>
            <div class="col-md-6">
               
 <label>From:</label><?= \yii\jui\DatePicker::widget([
                  'name' => 'datepickerfrom',
   'language' => 'en',
   'dateFormat' => 'yyyy-MM-dd',
   'options' => ['class' => 'span2 form-control add-on follow_calender calender','placeholder' => Yii::t('app', 'From'), 'style'=>'cursor:pointer;','readonly'=>'readonly', 'id' => 'follow_date_from']
]); ?>
            </div>
        </div>
        <div class="col-md-2">
            <label class="">&nbsp;</label>
            <div class="">
                <input type="submit" class="btn btn-success" value="search" />
                <input type="submit" class="btn btn-default" value="reset" />
            </div>

        </div>

    </div>
</form> 

<!-- scrapped data in table -->

<form method="post" action="">
    <div class="col-md-12">
        <table class="table table-bordered mrgTB">

            <thead>
                <tr>
                    <th scope="col">S.No.</th>
                    <th scope="col">Source</th>
                    <th scope="col">Make</th>
                    <th scope="col">Model</th>
                    <th scope="col">Variant</th>
                    <th scope="col">Displacement</th>
                    <th scope="col">Seating Capacity</th>
                    <th scope="col">Transmission</th>
                    <th scope="col">Scrapped On</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>

            <tfoot>
                <?php
//$scrapped
                if ($provider->getPagination()->totalCount) {

                    $scrappedDetail = $provider->getModels();

                    foreach ($scrappedDetail as $scrap) {
                        ?>
                        <tr>  <td><?php echo $count; ?> </td>
                            <td><?php echo $scrap->portal_name; ?> </td>
                            <td><?php echo $scrap->make; ?> </td>
                            <td><?php echo $scrap->model; ?> </td>
                            <td><?php echo $scrap->version; ?> </td>
                            <td><?php echo $scrap->displacement_1; ?> </td>
                            <td><?php echo $scrap->seating_capacity; ?> </td>
                            <td><?php echo $scrap->transmission; ?> </td>
                            <td><?php echo $scrap->listing_date; ?> </td>

                            <?php
                            $count++;
                            ?>
                            <td> <button type="button" class="btn btn-default" id="<?php echo $scrap->id; ?>" value="button">Map</button></td>
                        </tr>
                    <?php }
                    ?>
                    <?php
                    echo yii\widgets\LinkPager::widget([
                        'pagination' => $provider->getPagination(),
                    ]);
                }
                ?>
            </tfoot>

        </table>
    </div>

</form>

<!-- Pop Up Window -->
<!--
<form action="<?php //echo SITE_URL.USEDCARS_PART;  ?>/scrappedMapper" method="post">
    <div class="modal fade" id="bsModal3" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="mySmallModalLabel">Mapper</h4>
                </div>
                <div class="modal-body">
                    <div style="width: 100%;">
                        <div style="float:left; width: 60%">

                            <table cellspacing="1">
                                <tr>
                                    <td>
                                        <strong> Make: </strong><label id="labelmake"></label>
                                    </td>
                                    <td>
                                        <strong>Model:</strong> <label id="labelmodel"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong> Variant: </strong><label id="labelversion"></label> 
                                    </td>
                                    <td>
                                        <strong>Displacement: </strong><label id="labeldisplacement"></label> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Transmission: </strong><label id="labeltransmission"></label> 
                                    </td>
                                    <td>
                                        <strong>Seating Capacity: </strong><label id="labelseatcap"></label> 
                                        <input type="hidden" name="make" id="ins_make" value="" />
                                        <input type="hidden" name="model" id="ins_model" value="" />
                                        <input type="hidden" name="version" id="ins_version" value="" />
                                        <input type="hidden" name="transmission_type" id="ins_tt" value="" />
                                        <input type="hidden" name="source" id="ins_source" value="" />
                                        <input type="hidden" name="id" id="ins_id" value="" />
                                    </td>



                                </tr>
                            </table>

                        </div>      
                        <div style="float:right;">

                            <div class="slideshow-container">

                                <div id="slider-image"></div>


                                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                                <a class="next" onclick="plusSlides(1)">&#10095;</a>
                            </div>
                            <br>



                        </div>

                    </div>
                    <div style="clear:both"></div>
                    <table><tr>      <td>

                                <select name="mas_make" id="mas_make" >
                                     <option value="">Select make </option>
<?php //foreach ($makeArray as $mk) {  ?>
                                        <option value="<?php //echo $mk->make; ?>" onchange="getMakeModel();"><?php //echo $mk->make; ?></option>

<?php //}  ?>
                                    Make-Map</select>
                            </td>



                            <td>

                                <select name="mas_model" id="mas_model">
                                    <option value="">Select make first</option>
                                    Model-Map</select>
                            </td>



                            <td>
                                <select name="mas_version" id="mas_version">
                                    <option value="">Select model first</option>
                                    Version-Map</select>
                            </td>

                        </tr>



                    </table>
                </div>
                <div class="modal-footer">

                    <td><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></td>
                    <td><button type="submit" class="btn btn-default">Save</button></td>

                </div>
            </div>
        </div>
    </div>
</form>-->



