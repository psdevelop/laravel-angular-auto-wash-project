<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Auth;

use App\Service;
use App\Auto;
use App\AutoService;
use App\Payment;
use App\Color;

class ColorsController extends Controller
{
  public function index() {

    $result_colors = Color::all();
    return $result_colors;
  }
}
