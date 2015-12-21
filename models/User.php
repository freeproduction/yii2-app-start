<?php

namespace app\models;

use Yii;
use dektrium\user\models\User as DektriumUser;

class User extends DektriumUser {
    
    /**
     * @return bool Whether the user is an admin or not.
     */
    public function getIsAdmin()
    {
        return parent::getIsAdmin() || Yii::$app->user->can('admin');
    }
}