<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProduct extends FormRequest
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
                            'name'      =>  ['required'],
                            'domains'   =>  ['required'],
                            'image'     =>  ['nullable','image','mimes:jpeg,png,jpg,gif,svg','max:2048']
                        ];
            }
    }
