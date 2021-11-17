<?php

namespace App\Http\Requests\Game;

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

class EnemiesUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return in_array($this->header(Config::get('myapp.headers.authority')), Config::get('myapp.executionRole.services.game.enemies'), true);
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
            'id'      => 'required|integer',
            'name'    => 'required|string|between:1,50',
            'level'   => 'required|integer|between:1,100',
            'hp'      => 'required|integer|between:1,999',
            'mp'      => 'required|integer|between:1,999',
            'offence' => 'required|integer|between:1,999',
            'defense' => 'required|integer|between:1,999',
            'speed'   => 'required|integer|between:1,999',
            'magic'   => 'required|integer|between:1,999',
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
            'id.integer' => ':attributeは整数で入力してください。',
            'required'   => ':attributeは必須項目です。',
            'string'     => ':attributeは文字列を入力してください。',
            'array'      => ':attributeは配列で入力してください。',
            'between'    => ':attributeは:min〜:maxの範囲内で入力してください。',
            'min'        => ':attributeは:min以上で入力してください。',
            'exists'     => '指定した:attributeは存在しません。'
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
            'id'      => 'id',
            'name'    => '敵キャラクター名',
            'level'   => 'レベル',
            'hp'      => 'HP',
            'mp'      => 'MP',
            'offence' => '攻撃力',
            'defense' => '守備力',
            'speed'   => '素早さ',
            'magic'   => '魔力'
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
    }
}
