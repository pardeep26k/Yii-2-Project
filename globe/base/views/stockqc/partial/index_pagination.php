<div id="inventory-pagination" class ="inventory-pagination">
<?php
use yii\widgets\LinkPager;
	echo LinkPager::widget([
    'pagination' => $pagination,
]);
?>
</div>