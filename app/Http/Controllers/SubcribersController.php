<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubcribersController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function index()
            {
                return view('modules.subscribers.index',$this->data);
            }
        public function get(Request $request)
            {

            }
    }
