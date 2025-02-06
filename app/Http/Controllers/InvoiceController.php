<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function create(Sale $sale)
    {
        return view('pdf.invoice', ['sale' => $sale]);
    }
}
