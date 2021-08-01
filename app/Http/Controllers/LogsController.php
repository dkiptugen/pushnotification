<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogsController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function index()
            {
                return view('modules.logs.index',$this->data);
            }
        public function get(Request $request)
            {

            }
        public function export_view()
            {
                return view('modules.logs.index',$this->data);
            }
        public function export(Request $request)
            {

            }
    }
