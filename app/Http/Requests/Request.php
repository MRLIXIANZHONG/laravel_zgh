<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 20:20
 */

namespace App\Http\Requests;


use App\Exceptions\FailException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class Request extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function check(array $array, $rule)
    {
        if (!empty($array)) {
            $rlt = array();
            foreach ($array as $arr) {
                isset($rule[$arr])  &&  $rlt[$arr] = $rule[$arr];
            }
            return $rlt;
        }

        return [];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new FailException([
            'message'=> current((new ValidationException($validator))->errors())[0]
        ]);

//        throw new HttpResponseException(response()->json([
//            'errors'  =>   (new ValidationException($validator))->errors(),
//        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

    public function rules()
    {
        // action_name + method_name => ruleActionMethod();
        // action_name => ruleAction();
        // method_name => ruleMethod();
        $rules = [
            "rule{action_name}{method_name}",
            "rule{action_name}",
            "rule{method_name}",
        ];

        foreach ($rules as $rule) {
            $invokeMethod = str_replace(["{method_name}", "{action_name}"], [
                ucfirst(strtolower($this->method())),
                ucfirst($this->route()->getActionMethod()),
            ], $rule);

            if ( !method_exists($this, $invokeMethod) ) continue;
            return $this->{$invokeMethod}();
        }
        
        return [];
    }
}