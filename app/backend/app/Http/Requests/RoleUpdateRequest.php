<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Roles\RolesRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use App\Models\Roles;
use Illuminate\Contracts\Validation\Validator;
// use Illuminate\Validation\ValidationException;
// use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Config;

class RoleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return in_array($this->header(Config::get('myapp.headers.authority')), Config::get('myapp.executionRole.services.members'), true);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // ルーティングで設定しているidパラメーターをリクエストデータとして設定する
        $this->merge(['id' => $this->route('id')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $permissionsModel = app()->make(Roles::class);

        return [
            'id'          => 'required|integer',
            'name'        => 'required|string|between:1,50',
            'code'        => 'required|string|between:1,50',
            'permissions' => 'required|integer|exists:' . $permissionsModel->getTable() . ',id'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'id.integer'  => ':attributeは整数で入力してください。',
            'required'    => ':attributeは必須項目です。',
            'string'      => ':attributeは文字列を入力してください。',
            'between'     => ':attributeは:min〜:max文字以内で入力してください。'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'id'          => 'id',
            'name'        => 'ロール名',
            'code'        => 'ロールコード',
            'permissions' => 'パーミッション'
        ];
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedAuthorization()
    {
        $response = [
            'status' => 403,
            'errors' => [],
            'message' => 'Forbidden'
        ];

        throw (new HttpResponseException(response()->json($response, 403)));
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = [
            'status' => 422,
            'errors' => [],
            'message' => 'Unprocessable Entity'
        ];

        $response['errors'] = $validator->errors()->toArray();
        throw (new HttpResponseException(response()->json($response, 422)));

        // 本来のエラークラス
        /* throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl()); */
    }
}
