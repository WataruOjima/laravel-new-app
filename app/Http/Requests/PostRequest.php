<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => 'required|max:80',
            'message' => 'required|max:350',
            'image_file'=>['file','mimes:jpeg,png,jpg','max:1040'],
        ];
    }

    /**
    * エラーメッセージを日本語化
    * 
    */
    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.max' => '名前は40文字以内で入力してください',
            'subject.required' => '件名を入力してください',
            'subject.max' => '件名は80文字以内で入力してください',
            'message.required' => 'メッセージを入力してください',
            'message.max' => 'メッセージは350文字以内で入力してください',
            'image_file.mimes'                    => '選択できる画像はJPEG・GIF・PNG形式のみです',
            'image_file.max'                      => '1MB以下のファイルを選択してください',
            'image_file.accepted'     => '1MB以下のファイルを選択してください',
        ];
    }
}
