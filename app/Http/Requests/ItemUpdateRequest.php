<?php
namespace App\Http\Requests;

use App\Rules\BannedWord;
use Illuminate\Foundation\Http\FormRequest;

class ItemUpdateRequest extends FormRequest
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
    public function rules(BannedWord $banned_word)
    {                
        return [
            'name' => ['sometimes', 'required', 'string', 'min:10', 'max:255', $banned_word],
            'rating' => ['sometimes', 'required', 'integer', 'between:0,5'],
            'category' => ['sometimes', 'required', 'string', 'max:50', 'in:'.config('trivago.categories')],
            'location.city' => ['sometimes', 'required', 'string', 'max:50'],
            'location.state' => ['sometimes', 'required', 'string', 'max:50'],
            'location.country' => ['sometimes', 'required', 'string', 'max:50'],
            'location.zip_code' => ['sometimes', 'required', 'integer', 'digits_between:1,5'],
            'location.address' => ['sometimes','required', 'string'],
            'image_url' => ['sometimes', 'required', 'url', 'max:255'],
            'reputation' => ['sometimes', 'required', 'integer', 'between:0,10000'],
            'price' => ['sometimes', 'required', 'integer'],
            'availability' => ['sometimes', 'required', 'integer'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.unique' => 'The accommodation already exists in database',
            'category.in' => 'The category must be one of ['.config('trivago.categories').']',
            'image_url.url' => 'The image url must be URL e.g (http//example.com/folder/image.png)',
        ];
    }
   
}
