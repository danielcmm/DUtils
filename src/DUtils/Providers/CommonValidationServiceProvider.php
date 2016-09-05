<?php

namespace DUtils\Providers;

use DUtils\CurrencyUtils;
use DUtils\StringUtils;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class CommonValidationServiceProvider extends ServiceProvider {


    public function boot() {

        Validator::extend('currency', function($attribute, $value, $parameters, $validator) {

            if (!empty($value)){
                $valor = CurrencyUtils::prepareToPersist($value);
                return $valor >= 0.01 && $valor <= 999999999.99;
            }
        });

        Validator::extend('person_pin', function($attribute, $value, $parameters, $validator) {
            return StringUtils::validatePersonPinBR($value);
        });

        Validator::extend('company_pin', function($attribute, $value, $parameters, $validator) {
            return StringUtils::validateCompanyPinBR($value);
        });

        Validator::extend('phone_number', function($attribute, $value, $parameters, $validator) {
            return StringUtils::validatePhoneNumberBR($value);
        });

    }

    public function register() {
        //
    }
}
