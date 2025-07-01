<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'image' => [
                'nullable',// 省略可
                'file', // ファイルがアップロードされている
                'image', // 画像ファイルである
                'max:2000', // ファイル容量が2000kb以下である
                'mimes:jpeg,jpg,png', // 形式はjpegかpng
                'dimensions:min_width=200,min_height=200,max_width=2000,max_height=2000', // 画像の解像度が200px * 200px ~ 2000px * 2000px
            ],
            'body' => ['required', 'max:20000'],
        ];
    }
}
