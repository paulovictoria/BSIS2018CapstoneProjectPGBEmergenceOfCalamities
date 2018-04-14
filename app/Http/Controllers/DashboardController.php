<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Admin;
use PDF;
class DashboardController extends Controller
{

    public function gotoDashboard()
    {
        return view('admin.dashboard');
    }

    public function getPdf()
    {
      $pdf = PDF::loadView('admin.pdf');
      return $pdf->download('report.pdf');

    }
}
