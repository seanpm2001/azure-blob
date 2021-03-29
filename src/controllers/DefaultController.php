<?php

namespace craft\azureblob\controllers;

use Craft;
use craft\azureblob\Volume;
use craft\web\Controller as BaseController;
use yii\web\Response;

/**
 * This controller provides functionality to load data from Azure Cloud.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 1.0
 */
class DefaultController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->defaultAction = 'load-container-data';
    }

    /**
     * Load container data for specified credentials.
     *
     * @return Response
     */
    public function actionLoadContainerData(): Response
    {
        $this->requirePostRequest();
        $this->requireAcceptsJson();

        $request = Craft::$app->getRequest();
        $connectionString = Craft::parseEnv($request->getRequiredBodyParam('connectionString'));

        try {
            return $this->asJson(Volume::loadContainerList($connectionString));
        } catch (\Throwable $e) {
            return $this->asErrorJson($e->getMessage());
        }
    }
}