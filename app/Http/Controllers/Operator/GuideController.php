<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuideController extends Controller
{
   /**
    * Display the Operator usage guide.
    */
   public function index(Request $request)
   {
      // We could later inject dynamic counts or config if needed.
      return view('operator.guide.index');
   }
}
