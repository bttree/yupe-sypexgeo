<?php

require_once __DIR__ ."/../components/SxGeo.php";

class Geolocation extends CModel
{

    public function attributeNames()
    {
        return [];
    }

    /**
     * @param $ip
     * @return array|bool
     */
    public static function getAllDataByIp($ip) {

        $SxGeo = new SxGeo(__DIR__ .'/../components/SxGeoCity.dat');

        return $SxGeo->getCityFull($ip);
    }

    /**
     * @return MagCity|null
     */
    public static function getNearCity() {
        $earthRadius         = 6372;
        $module              = Yii::app()->getModule('sxgeo');
        $maxDistanceToCityKm = $module->maxDistanceToCityKm;

        $userData              = self::getAllDataByIp(Yii::app()->request->userHostAddress);
        if(!is_array($userData)) {
            return null;
        }
        $userLat = $userData["city"]["lat"];
        $userLon = $userData["city"]['lon'];

        $expression = new CDbExpression(
            '(:earthRadius * acos( cos( radians(city.latitude) ) 
              * cos( radians(:latitude) ) 
              * cos( radians(:longitude) - radians(city.longitude) ) 
              + sin( radians(city.latitude) ) 
              * sin( radians(:latitude) ) )) AS distance, city.*'
        );

        $criteria = new CDbCriteria();
        $criteria->select = $expression;
        $criteria->alias  = 'city';
        $criteria->having = 'distance <= :distance';
        $criteria->order  = 'distance ASC';
        $criteria->params = [
            ':earthRadius' => $earthRadius,
            ':latitude'    => $userLat,
            ':longitude'   => $userLon,
            ':distance'    => $maxDistanceToCityKm
        ];

        $magCity = MagCity::model()->find($criteria);

        return $magCity;
    }
}
