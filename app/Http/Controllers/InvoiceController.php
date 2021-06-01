<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage as Resp;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function getInvoice($invoiceNumber)
    {
        try {
            $data = \App\Models\Invoice::where(['invoiceNumber' => $invoiceNumber])->get();
            return Resp::Success('تم', $data);
        } catch (\Throwable $th) {
            return Resp::Error('حدث خطأ ما', $th->getMessage());
        }
    }
}
