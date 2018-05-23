<?php

namespace App\Http\Controllers;
use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
   function index() {
       return response()->json([
           'collection' => Customer::advancedFilter()
       ]);
   }
}
