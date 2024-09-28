<?php

namespace App\Controllers;
class Printtext extends BaseController
{
    public function __construct(){

    }
    
    public function printpembayaran(){
        return view('print/print-pembayaran');
    }
}