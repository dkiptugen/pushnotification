<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AddNotification extends FormRequest
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
        public function rules(Request $request)
            {
                return [
                            'title'         =>  ['required',Rule::unique('stories')->where(function ($query) use ($request) {

                                return $query
                                    ->whereProductId($request->product_id)
                                    ->whereTitle($request->title);
                            })],
                            'link'          =>  'required',
                            'thumbnail'     =>  'required',
                            'summary'       =>  'nullable',
                            'ttl'           =>  'nullable',
                            'publishdate'   =>  'nullable'
                        ];
            }
    }
