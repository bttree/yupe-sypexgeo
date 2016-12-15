<?php

use yupe\components\WebModule;

class SxGeoModule extends WebModule
{
    const VERSION = '0.0.2';

    public $maxDistanceToCityKm = 100;

    public function getName()
    {
        return Yii::t('SxGeoModule.sxgeo', 'SxGeo');
    }

    public function getIcon()
    {
        return 'fa fa-fw fa-globe';
    }

    public function getCategory()
    {
        return 'Сервисы';
    }

    public function getDescription()
    {
        return Yii::t('SxGeoModule.sxgeo', 'SxGeo');
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getAuthor()
    {
        return Yii::t('SxGeoModule.sxgeo', 'SiteMaket');
    }

    public function getAuthorEmail()
    {
        return Yii::t('SxGeoModule.sxgeo', 'SiteMaket');
    }

    public function getUrl()
    {
        return Yii::t('SxGeoModule.sxgeo', 'http://sitemaket.ru');
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'application.modules.sxgeo.models.*'
            ]
        );
    }

    public function getAuthItems()
    {
        return [
            [
                'type'        => AuthItem::TYPE_TASK,
                'name'        => 'SxGeo.SxGeoBackend.Management',
                'description' => Yii::t('SxGeoModule.sxgeo', 'Manage SxGeo'),
                'items'       => [],
            ],
        ];
    }

    public function getEditableParams()
    {
        return [
            'maxDistanceToCityKm'
        ];
    }

    public function getParamsLabels()
    {
        return [
            'maxDistanceToCityKm' => Yii::t('SxGeoModule.sxgeo', 'Max distance to city km'),
        ];
    }
}
