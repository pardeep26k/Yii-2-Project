<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backoffice\globe\base\controllers;

use Yii;
use common\models\backoffice\oto\UsedcarScrappedLead;
use common\models\backoffice\oto\CarMake;
use yii\data\ArrayDataProvider;
use backoffice\components\AdminController;

class ScrappedpanelController extends AdminController {

    public function actionScrap() {
        $model = Yii::$app->request->post();
        $modelScrapped = new UsedcarScrappedLead();
        $modelMake = new CarMake();
        if (empty($model) || ($model['make'] == "" && $model['source'] == "" && $model['datepickerto'] == "" && $model['datepickerfrom'] == "") || isset($_POST['reset'])) {
            $response = $modelScrapped->getErrorScrappedrecord();
        } else {
            $response = $modelScrapped->getSearchList($model);
        }

        $count = count($response);
        $provider = new ArrayDataProvider([
            'allModels' => $response,
            'sort' => [
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $posts = $provider->getModels(); //echo $count;exit;
        $mk = $modelMake->getMakeName();
        $sourceArray = $modelScrapped->getSourceList();

        $count1 = 1;
        return $this->render('scrap', ['provider' => $provider, 'makeArray' => $mk, 'sourceArray' => $sourceArray, 'count' => $count1]);
    }
    
    public function actionGetPopUp()
    {
        //echo "dddd";exit;
        $modelScrapped=new UsedcarScrappedLead();
       $params = Yii::$app->request->post(); 
       $response = $modelScrapped->getPopUp($params);
       $response1=(array)$response;
      // $response1['Image_url'] = strtok($response1['Image_url'], '||');
       $response1['Image_url'] = explode('||',$response1['Image_url']);
       //print_r($response1);exit;
       $response=json_encode($response1);
       return $response;
    }
    
    public function actionGetModelList()
    {
      $modelMakeModel=new MakeModel();
        $make = Yii::$app->request->post();
       // print_r($make);exit;
        $response = $modelMakeModel->getModelList($make);
        $response=json_encode($response);
          return $response;
    }
       public function actionGetVersionList()
    {
        $modelVersion=new ModelVersion();
        $model = Yii::$app->request->post();
        $response = $modelVersion->getVersionList($model);
        $response=json_encode($response);
        return $response;
    }
      public function actionScrappedMapper()
    {
     $session = Yii::$app->session;
        $model = Yii::$app->request->post();
        //print_r($model);exit;
        $version_id=$this->_scrappedpanelService->getVersionById($model);
        $model['version_id']=$version_id;
        
        $response=$this->_scrappedpanelService->getScrappedMapper($model);
        //print_r($response);exit;
       if($response=="true")
       {
          Yii::$app->session->setFlash('success', 'Successfully mapped');
        return $this->redirect('scrappedPanel');
       }
       else {
         Yii::$app->session->setFlash('failure', 'Error');
        return $this->redirect('scrappedPanel');  
       }
        }

}
