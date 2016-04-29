<?php

namespace app\models\user;

use Yii;
use dektrium\user\models\User as DektriumUser;

class User extends DektriumUser {
    
    const PASSWORD_MIN_LENGTH = 4;
    
    /**
     * @return bool Whether the user is an admin or not.
     */
    public function getIsAdmin()
    {
        return parent::getIsAdmin() || Yii::$app->user->can('admin');
    }
    
    /** @inheritdoc */
    public function rules()
    {
        $rules = parent::rules();
        $rules[count($rules) - 1]['min'] = self::PASSWORD_MIN_LENGTH;
        return $rules;
    }
    
}