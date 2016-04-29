<?php

namespace app\models\user;

use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use app\models\user\User;

/**
 * Registration form collects user input on registration process, validates it and creates new User model.
 */
class RegistrationForm extends BaseRegistrationForm {
    
    /**
     * @inheritdoc
     */
    public function rules() {
        $rules = parent::rules();
        $rules[count($rules) - 1]['min'] = User::PASSWORD_MIN_LENGTH;
        return $rules;
    }

}
