<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobsController extends Controller
    {
        public function failed()
            {
                return view('modules.Jobs.failed',$this->data);
            }
        public function get_failed(Request $request)
            {
                #
            }
        public function queued()
            {
                return view('modules.Jobs.queued',$this->data);
            }
        public function get_queued(Request $request)
            {
                #
            }
    }
