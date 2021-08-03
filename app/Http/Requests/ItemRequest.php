<?php
namespace App\Http\Requests;

use App\Rules\BannedWord;
use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:items,name', 'min:10', 'max:255', $banned_word],
            'rating' => ['required', 'integer', 'between:0,5'],
            'category' => ['required', 'string', 'max:50', 'in:'.config('trivago.categories')],
            'location.city' => ['required', 'string', 'max:100'],
            'location.state' => ['required', 'string', 'max:100'],
            'location.country' => ['required', 'string', 'max:100'],
            'location.zip_code' => ['required', 'integer', 'digits_between:1,5'],
            'location.address' => ['required', 'string'],
            'image_url' => ['required', 'url', 'max:255'],
            'reputation' => ['required', 'integer', 'between:0,10000'],
            'price' => ['required', 'integer'],
            'availability' => ['required', 'integer'],
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
