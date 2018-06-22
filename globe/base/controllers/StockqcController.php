<?php

namespace backoffice\globe\base\controllers;

use Yii;
use common\models\backoffice\Usedcar;
use common\models\BrandModelVariants;
use common\models\BrandModels;
use common\models\VersionNotAvailableLog;
use common\models\Dealer;
use common\models\ReportSqlLog;
use common\models\sfa\SfaUsers;
use common\models\backoffice\UsedcarSearch;
use backoffice\components\AdminController;
use common\models\backoffice\QcUsedcarDetail;
use common\models\backoffice\QcUsedcarLog;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\json;
Use DateTime;

/**
 * StockqcController implements the CRUD actions for Usedcar model.
 */
class StockqcController extends AdminController {

    /**
     * Lists all Usedcar models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UsedcarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Usedcar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usedcar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Usedcar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Displays a single Usedcar model.
     * @return mixed
     */
    public function actionStocksearch() {
        $result = [];
        if (Yii::$app->request->post()) {
            $postData = Yii::$app->request->post();
            $searchKey = $postData['search_key'];
            $searchOn = $postData['search_on'];

            $usedcar = new Usedcar();
            $result = $usedcar->stockDetail($searchOn, $searchKey);
            return $this->render('search-view', [
                        'result' => $result['result'],
                        'totalPics' => $result['totalPics'],
                        'totalLeads' => $result['totalLeads'],
            ]);
        }
        return $this->render('search-view', [
                    'result' => $result,
        ]);
    }

    public function actionQcreport() {
        $results = '';
        $data = [];
        if (Yii::$app->request->post()) {
            $qc = new QcUsedcarLog();
            $qcD = new QcUsedcarDetail();
            $citybyid = new \common\models\City();
            $sfaUser = new SfaUsers();
            $postData = Yii::$app->request->post();
            $startDate = $postData['report_from'];
            $endDate = $postData['report_to'];
            $email = $postData['email'];
            $resultQc = $qc->getQcReport($startDate, $endDate);
            if (!empty($resultQc)) {
                $csvFile = \Yii::$app->params['uploadPath']['dealerCsv'] . md5(time()) . '.csv';
                $output = fopen($csvFile, 'w') or die("Can't open php://output");
                fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
                fputcsv($output, array('Dealer Id', 'Car Id', 'Added Date', 'Regno Before', 'Regno After', 'ModelId Before', 'ModelName Before', 'ModelId After', 'ModelName After', 'VersionId Before', 'VersionName Before', 'VersionId After', 'VersionName After', 'Km Before', 'Km After', 'RegnoValidity Before', 'RegnoValidity After', 'Mgfyear Before', 'Mgfyear After', 'Total Image Count', 'Total Document Count', 'Qc Status Before', 'Qc Status After', 'Qc Status', 'Qc Created By', 'Agent Email', 'Agent Name', 'Qc Started Date', 'Qc End Date', 'Dealer City', 'Profile Picture',
                    'Front View (bumper, bonnet, fr-windshield,headlights, grill)', 'Right Side (fender, doors, qtr panel)', 'Right Quarter Panel',
                    'Front Right Side Interior View', 'Rear (bumper, dicky door, rr-windshield, tail lights)', 'Engine Compartment', 'Dashboard ( from rear seat)',
                    'Odometer Reading (with engine on from driver seat)', 'Front Door Trim', 'STNK 1', 'STNK 2', 'BPKB 1', 'BPKB 2')
                );

                foreach ($resultQc as $key => $value) {
                    $imgTag = [];
                    $variantNameAfter = BrandModelVariants::find()->select('slug')->where(['=', 'id', $value['versionIdafter']])->one();
                    $variantNameBefore = BrandModelVariants::find()->select('slug')->where(['=', 'id', $value['versionIdBefore']])->one();
                    $modelNameAfter = BrandModels::find()->select('slug')->where(['=', 'id', $value['modelIdafter']])->one();
                    $modelNameBefore = BrandModels::find()->select('slug')->where(['=', 'id', $value['modelIdBefore']])->one();
                    $dealer = Dealer::find()->select(['city', 'username', 'name'])->where(['=', 'id', $value['dealerId']])->one();
                    $usDetails = UsedCar::find()->where(['=', 'id', $value['carId']])->one();
                    $sfaDetails = $sfaUser->findById($usDetails['created_by_id']);
                    $qcDetails = $qcD->getImageDetailbyUsedcarId($value['carId']);
                    foreach ($qcDetails as $keys => $values) {
                        $ab = $qcD->getImageTagbyUsedcarId($values['tag_id'], $values['id']);
                        $imgTag[$values['tag_id']] = $ab['image_status'];
                    }
                    $city = $citybyid->getCityName($dealer['city']);
                    $data[$key]['dealerId'] = $value['dealerId'];
                    $data[$key]['carId'] = $value['carId'];
                    $data[$key]['AddedOn'] = $usDetails['created_at'];
                    $data[$key]['regnoBefore'] = $value['regnobefore'];
                    $data[$key]['regnoAfter'] = $value['regnoafter'];
                    $data[$key]['modelIdBefore'] = $value['modelIdBefore'];
                    $data[$key]['modelNameBefore'] = $modelNameBefore['slug'];
                    $data[$key]['modelIdAfter'] = $value['modelIdafter'];
                    $data[$key]['modelNameAfter'] = $modelNameAfter['slug'];
                    $data[$key]['versionIdBefore'] = $value['versionIdBefore'];
                    $data[$key]['versionnameBefore'] = $variantNameBefore['slug'];
                    $data[$key]['versionIdAfter'] = $value['versionIdafter'];
                    $data[$key]['versionnameAfter'] = $variantNameAfter['slug'];
                    $data[$key]['kmBefore'] = $value['kmBefore'];
                    $data[$key]['kmAfter'] = $value['kmafter'];
                    $data[$key]['regnovalidityBefore'] = $value['regnovaliditybefore'];
                    $data[$key]['regnovalidityAfter'] = $value['regnovalidityafter'];
                    $data[$key]['mgfyearBefore'] = $value['mgfyearbefore'];
                    $data[$key]['mgfyearAfter'] = $value['mgfyearafter'];
                    $data[$key]['total_count_image'] = $value['total_count_image'];
                    $data[$key]['total_count_doc'] = $value['total_count_doc'];
                    $data[$key]['qcstatusBefore'] = $value['qcstatusbefore'];
                    $data[$key]['qcstatusAfter'] = $value['qcstatusafter'];
                    $data[$key]['qcstatus'] = $usDetails['qc_status'];
                    $data[$key]['qc_created_by'] = $usDetails['created_by'];
                    $data[$key]['AgentEmail'] = ($usDetails['created_by'] == 'bm') ? $sfaDetails['email'] : $dealer['username'];
                    $data[$key]['AgentName'] = ($usDetails['created_by'] == 'bm') ? $sfaDetails['name'] : $dealer['name'];
                    $data[$key]['startedDate'] = $value['startedDate'];
                    $data[$key]['endDate'] = $value['endDate'];
                    $data[$key]['dealerCity'] = $city;
                    //   p($imgTag['3']);
                    $data[$key]['ProfilePicture'] = isset($imgTag['1']) ? $imgTag['1'] : 'Not Attached';
                    $data[$key]['FrontViewBumper'] = isset($imgTag['2']) ? $imgTag['2'] : 'Not Attached';
                    //echo (($imgTag['3']!='')?$imgTag['3']:'Not Attached');
                    $data[$key]['RightSideDoors'] = isset($imgTag['3']) ? $imgTag['3'] : 'Not Attached';

                    //  echo $data['RightSideDoors'] ;
                    $data[$key]['RightQuarterPanel'] = isset($imgTag['4']) ? $imgTag['4'] : 'Not Attached';
                    $data[$key]['FrontRightSideInteriorView'] = isset($imgTag['5']) ? $imgTag['5'] : 'Not Attached';
                    $data[$key]['Rear'] = isset($imgTag['6']) ? $imgTag['6'] : 'Not Attached';
                    // $data[$key]['LeftQuarterPanel']      =  isset($imgTag['7'])?$imgTag['7']:'Not Attached';
                    // $data[$key]['LeftSidedoors']         =  isset($imgTag['8'])?$imgTag['8']:'Not Attached';
                    // $data['LeftSideProfilePic']    =  isset($imgTag['9'])?$imgTag['9']:'Not Attached';
                    $data[$key]['EngineCompartment'] = isset($imgTag['10']) ? $imgTag['10'] : 'Not Attached';
                    $data[$key]['Dashboard'] = isset($imgTag['11']) ? $imgTag['11'] : 'Not Attached';
                    $data[$key]['OdometerReading'] = isset($imgTag['12']) ? $imgTag['12'] : 'Not Attached';
                    $data[$key]['FrontDoorTrim'] = isset($imgTag['13']) ? $imgTag['13'] : 'Not Attached';
                    $data[$key]['STNK1'] = isset($imgTag['14']) ? $imgTag['14'] : 'Not Attached';
                    $data[$key]['STNK2'] = isset($imgTag['15']) ? $imgTag['15'] : 'Not Attached';
                    $data[$key]['BPKB1'] = isset($imgTag['16']) ? $imgTag['16'] : 'Not Attached';
                    $data[$key]['BPKB2'] = isset($imgTag['17']) ? $imgTag['17'] : 'Not Attached';
                    try {
                        fputcsv($output, $data[$key]);
                    } catch (Exception $ex) {
                        p($ex);
                    }
                }
                $post = Yii::$app->request->post();

                if (isset($post['send_mail'])) {
                    $mailData['subject'] = '[UC-OTO] Qc Report';
                    // $mailData['layout'] = 'layouts/qcRport.php';
                    $mailData['data'] = $data;
                    $mailData['ccList'] = 'apoorva.panchal@girnarsoft.com';
                    $response = $this->sendMail($csvFile, $mailData, $email);
                    if (!$response) {
                        $results = 'Mail not sent';
                    }
                    $results = "Mail sent";
                    fclose($output);
                } else {
                    $start = $startDate;
                    $createDate = new DateTime($start);
                    $strt = $createDate->format('d-m-Y');
                    $ending = $endDate;
                    $createEndDate = new DateTime($ending);
                    $end = $createEndDate->format('d-m-Y');
                    $fileName = "Qc_report" . "_" . $strt . "_" . $end . '.csv';
                    $fileWithPath = $csvFile;
                    header('Content-Description: File Transfer');
                    header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
                    header("Content-Disposition: attachment; filename=" . $fileName);
                    header('Content-Transfer-Encoding: binary');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    ob_clean();
                    flush();
                    readfile($fileWithPath);
                    exit;
                }
            } else {
                $results = "No Qc done between these dates.";
            }
        }

        return $this->render('qc-report-view', [
                    'results' => $results,
        ]);
    }

    public function actionDoqc($id) {
        $this->layout = '//stockqc_layout';
        $usedcar = new \common\models\Usedcar();
        $currentCar = $usedcar::findOne($id);
        $images = $currentCar->usedcarImages;
        $tagQuestions = new \common\models\backoffice\QcUsedcarQuestions();
        $tagFields = new \common\models\backoffice\QcUsedcarFields();
        $taggedImages = [];
        foreach ($images as $image) {
            if ($image->image_tag != '1000') {
                $taggedImages[$image['image_tag']][] = $image;
            }
        }
        $ucit = array_keys($taggedImages);
        $fields = $tagFields::find()->all();
        $additionalParams = $this->getAdditionalParams($currentCar);
        return $this->render('doqc', array_merge(['images' => $taggedImages, 'ucit' => $ucit, 'tagQuestions' => $tagQuestions, 'fields' => $fields, 'car' => $currentCar], $additionalParams));
    }

    public function getAdditionalParams($usedcar) {
        $versionNotAvailable = new VersionNotAvailableLog();
        $BrandModelVariants = new BrandModelVariants();
        $versionNotAvailableData= $versionNotAvailable->find()->where(['usedcar_id'=>$usedcar['id']])->one();
        $userVariants = $usedcar->brandModelVariant;
        $userVariant = $usedcar->brandModelVariant->id;
        $allVariants = $usedcar->brandModelVariant->model->brandModelVariants;
        //$versionWithOtherData= $BrandModelVariants->find()->where(['id'=>$variant->id])->all();
        $variantData = [];
        foreach ($allVariants as $variant) {
           $variantData[$variant->id] = $variant->name.
                   '-'.$variant->fuel_type.
                   '-'.$variant->transmission_type.
                   '-'.$variant->displacement.
                   '-'.$variant->seating_capacity;;
        }
       $userModel = $usedcar->brandModelVariant->model->id;
        $allModels = $usedcar->brandModelVariant->brand->brandModels;
        foreach ($allModels as $modelKey => $model) {
            $modelData[$model->id] = $model->name;
        }
         $userBrand = [$userVariants->brand->id => $userVariants->brand->name];
        return [
            'userBrand'   =>$userBrand,
            'userVariant' => $userVariant,
            'variantData' => $variantData,
            'modelData' => $modelData,
            'userModel' => $userModel,
            'versionNotAvailableData' => $versionNotAvailableData,
        ];
    }

    public function actionSavestockqc() {
        if (Yii::$app->request->isAjax) {
            $params = Yii::$app->request->post();
            $qcProcess = new \common\models\backoffice\StockqcProcess();
            $success = $qcProcess->saveQcData($params);

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($success) {
                return ['status' => true];
            }
        }
    }

    public function actionCropimage() {
        if (Yii::$app->request->isAjax) {
            $params = Yii::$app->request->post();

            $fromPath = $params['imagePath'];
            $toPath = $fromPath;
            $imgName = $params['imageName'];
            $cropImgDtl = (array) json_decode($params['imageData']);
            $width = $cropImgDtl['width'];
            $height = $cropImgDtl['height'];
            $xyArray = [$cropImgDtl['x'], $cropImgDtl['y']];
            \common\helpers\ImageUploader::cropImage($fromPath, $toPath, $width, $height, $xyArray);

            $this->updateResizeFlag($params);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'status' => true,
                'imageName' => $imgName,
                'url' => $params['imageurl']
            ];
        }
    }

    public function actionRotateimage() {
        if (Yii::$app->request->isAjax) {
            $params = Yii::$app->request->post();
            $fromPath = $params['imagePath'];
            $toPath = $fromPath;
            \common\helpers\ImageUploader::rotateImage($fromPath, $toPath);

            $this->updateResizeFlag($params);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'status' => true,
                'imageName' => $params['imageName'],
                'url' => $params['imageElemSrc']
            ];
        }
    }

    public function updateResizeFlag($params) {
        $imgId = $params['imageId'];

        $usedcarImage = \common\models\UsedcarImages::findOne(['id' => $imgId]);
        $usedcarImage->resize_flag = '0';
        $usedcarImage->save();

        \common\models\DataLog::updateLog($usedcarImage->usedcar_id, 'inventory');
    }

    public function actionPowervariant() {
        if (Yii::$app->request->isAjax) {
            $params = Yii::$app->request->post();
            $variant = $params['varient'];
            $qcProcess = new \common\models\BrandModelVariants();
            $powerVarient = $qcProcess->getPower($variant);
            $power = $powerVarient['power'];
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($power) {
                return $power;
            }
        }
    }
    
//    public function actionUpdatevariantonprofilepic() {
//            $params = Yii::$app->request->post();
//            $version = $params['version'];
//            $usedcar = new \common\models\Usedcar();
//            $usedcarData = $usedcar->find()->where(['id' => $params['usedCarID']])->one();
//            if(!empty($usedcarData)){
//            $usedcar = new \common\models\Usedcar();
//             \common\models\Usedcar::updateAll(['version_id' =>$version], ['id' => $usedcarData['id']]);
//            }
//            return TRUE;
//    }

    public function sendMail($csvFile, $mailData, $to) {
        $message = \Yii::$app->mailer->compose(['data' => $mailData['data']])
                ->setFrom(['feedback@girnarsoft.com' => 'feedback@girnarsoft.com'])
                ->setTo($to)
                ->setCc($mailData['ccList'])
                ->setSubject($mailData['subject']);
        $message->attach($csvFile);
        $message->send();
        return true;
    }

    public function actionCreatereport() {
        $results = '';
        if (Yii::$app->request->post()) {
            $reportSqlLog = new ReportSqlLog();
            $postData = Yii::$app->request->post();
            $createSql = serialize($postData['createSql']);
            $reportName = $postData['report_name'];

            $reportSqlLog->created_sql = $createSql;
            $reportSqlLog->report_name = $reportName;
            $reportSqlLog->report_counter = '0';
            if(preg_match('/^select /', strtolower($postData['createSql'])))
            {
            $reportSqlLog->save();
            $results = "Query Created";
            }
            else {
                $results = "Wrong Query";
            }
            
        }
        return $this->render('create-report', ['results' => $results]
        );
    }

    public function actionDownloadreports() {
        $reportSqlLog = new ReportSqlLog();
        $modelData = ReportSqlLog::find()->where(['=','del_status','0'])->all();
        return $this->render('download-reports', ['modelData' => $modelData]
        );
    }

    public function actionDownloaddata() {
        $params = \Yii::$app->request->get();
        $Id = $params['id'];
        $reportSqlLog = new ReportSqlLog();
        $datas = ReportSqlLog::find()->where(['id' => $Id])->one();
        $sqlData = $datas->created_sql;
        $unseralize=  unserialize($sqlData);
        $command= Yii::$app->db->createCommand($unseralize);
        $result = $command->queryAll();
        $reportSqlLog = new ReportSqlLog();
        $counter =$datas->report_counter;
        ReportSqlLog::updateAll(['report_counter' =>$counter+1], ['id' => $datas->id]);
        $i=0;
        $output='';
        //$rowData='';
        foreach ($result as $key=>$data){
                if($i==0){
                foreach ($data as $key=>$val){
                     $output .= '"'.$key.'",';
                    }
                    $output .="\n";
                }
                    foreach ($data as $key=>$val){
                    $output .= '"'.$val.'",';
                }
                    $output .="\n";
                $i++;
        }
        $filename = $datas->report_name.'.csv';
        header("Content-Type:text/csv; charset=utf-8");
        Header('Content-Description: File Transfer');
        Header('Content-Type: application/force-download');
        header("Content-Disposition: attachment; filename=" . $filename);
       print $output;
       die;
    }
    public function actionDeletedata()
    {
        $params = \Yii::$app->request->get();
        $Id = $params['id'];
        $reportSqlLog = new ReportSqlLog();
        $data = ReportSqlLog::updateAll(['del_status' => 1], ['id' => $Id]); 
        $modelData = ReportSqlLog::find()->where(['=','del_status','0'])->all();
        return $this->render('download-reports', ['modelData' => $modelData]
        );
    }
    
       public function actionMakemodel() {
        $searchModel = new \common\models\Brand();
        $brandModel = new \common\models\BrandModels();
        $brandModelVariant = new \common\models\BrandModelVariants();
        $allBrand= $searchModel->getAllBrands();
        $allModels = $brandModel->find()->where(['!=','dis_cont','inactive'])->andWhere(['!=','dis_cont','upcoming'])->all();
        foreach ($allModels  as $model) 
        {
          $models[$model->id] = $model->name;
        }
        $params=Yii::$app->request->get();
        $dataProvider = $brandModelVariant->getAllMakeModelVersion($params);
        return $this->render('make-model', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider['result'],
                    'allBrand' => $allBrand,
                    'models' => $models,
        ]);
    }
 
    public function actionGetmodels() {
        if (Yii::$app->request->isAjax) {
            $brandId = Yii::$app->request->post('brandId');
            $data = [];
            $result = BrandModels::find()->where(['brand_id' => $brandId])->andWhere(['!=','dis_cont','inactive'])->andWhere(['!=','dis_cont','upcoming'])->orderBy(['name' => SORT_ASC])->all();
            $final = array_merge($data,$result);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => $final,
            ];
        } else {
            return false;
        }
    }
    
    public function actionGetvariants() {
        if (Yii::$app->request->isAjax) {
            $modelId = Yii::$app->request->post('modelId');
            $data = [];
            $result = BrandModelVariants::find()->where(['model_id' => $modelId])->orderBy(['name' => SORT_ASC])->all();
            $final = array_merge($data,$result);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => $final,
            ];
        } else {
            return false;
        }
    }
    
    public function actionGetsearchfilter() {
        if (Yii::$app->request->isAjax) {
            $searchModel = new \common\models\Brand();
            $brandModel = new \common\models\BrandModels();
            $brandModelVariant = new \common\models\BrandModelVariants();
            $allBrand = $searchModel->getAllBrands();
            $params =Yii::$app->request->post();
            $allModels = $brandModel->find()->where(['!=','dis_cont','inactive'])->andWhere(['!=','dis_cont','upcoming'])->all();
            foreach ($allModels as $model) {
                $models[$model->id] = $model->name;
            }

            $dataProvider = $brandModelVariant->getAllMakeModelVersion(Yii::$app->request->post());
            return $this->renderPartial('partial/make-model-search', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider['result'],
                        //'pagination' => $dataProvider['pagination'],
                        'allBrand' => $allBrand,
                        'models' => $models,
            ]);
        }
    }

}
