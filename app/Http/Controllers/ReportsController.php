<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage as Resp;
use App\Http\Requests\ReportBetweenRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    private $id = ['id' => 'الرقم التعريفي'];
    private $clientName = ['clientName' => 'إسم العميل'];
    private $clientPhone = ['clientPhone' => 'رقم العميل'];
    private $created_at = ['created_at' => 'تاريخ الإنشاء'];
    private $updated_at = ['updated_at' => 'تاريخ التحديث'];
    private $timestamp = ['created_at' => 'تاريخ الإنشاء', 'updated_at' => 'تاريخ التحديث'];
    private $phone = ['phone' => 'رقم الهاتف'];
    private $price = ['price' => 'المبلغ'];
    private $amount = ['amount' => 'الكمية'];
    private $shiftUser = ['shiftUser' => 'المستخدم المناوب'];

    public function ReportBetween(ReportBetweenRequest $request)
    {
        $validate = (object) $request->validated();

        $colums = [
            'invoices' => [...$this->id, 'invoiceNumber' => 'رقم الفاتورة', ...$this->clientName, ...$this->clientPhone, 'total' => 'المجوع', 'products' => 'المنتج', 'discount' => 'التخفيض', 'payment_method' => 'طريقة الدفع', 'paid' => 'المبلغ المدفوع', 'rest' => 'المبلغ المتبقي', 'status' => 'الحالة', 'receiptDate' => 'تاريخ الإستلام', ...$this->shiftUser, ...$this->created_at, ...$this->updated_at],
            'new_measures' => [...$this->id, ...$this->created_at, ...$this->updated_at, ...$this->shiftUser, ...$this->clientPhone, ...$this->clientName, 'customType' => 'نوع التفصيل', 'shoulderHeight' => 'طول الأكتاف', 'height' => 'الطول', 'armHeight' => 'طول الزراع', 'sides' => 'الجوانب', 'goba' => 'القبة', 'buttonsType' => 'تفصيل القماش', 'kafaType' => 'نوع الكفة', ...$this->amount, ...$this->price, 'paymentMethod' => 'طرقة الدفع', 'paid' => 'المبلغ المدفوع', 'rest' => 'المبلغ المتبقي', 'dateOfRecive' => 'تاريخ الإستلام', 'receiptNumber' => 'رقم الإستلام'],
            'ready_sales' => [...$this->clientName, ...$this->id, ...$this->amount, ...$this->price, 'paymentMethod' => 'طرقة الدفع', ...$this->shiftUser, ...$this->timestamp],
            'receipts' => [...$this->id, ...$this->timestamp, ...$this->clientName, ...$this->clientPhone, ...$this->shiftUser, 'receiptNumber' => 'رقم الإستلام', 'receiptStatus' => 'حالة الإستلام'],
            'users' => [...$this->id, ...$this->timestamp, 'empNumber' => 'رقم الموظف', 'empName' => 'إسم الموظف', ...$this->phone, 'address' => 'العنوان', 'perDay' => 'اليومية', 'salary' => 'المرتب', 'username' => 'اسم المستخدم', 'role' => 'الصلاحية'],
            'indebtedness' => [...$this->id, ...$this->timestamp, ...$this->phone, ...$this->amount, 'name' => 'الإسم', 'status' => 'الحالة', 'statement' => 'البيان'],
            'import_froms' => [...$this->id, ...$this->timestamp, 'totalPrice' => 'السعر الكلي', 'jalabeya' => 'الجلابية', 'jalabeyaPrice' => 'سعر الجلابية', 'alaalla' => 'العلى الله', 'alaallaPrice' => 'سعر العلى الله', 'pants' => 'السروال', 'pantsPrice' => 'سعر السروال', 'tageeya' => 'الطاقية', 'tageeyaPrice' => 'سعر الطاقية'],
            'expenses' => [...$this->id, ...$this->timestamp, 'dailies' => 'اليوميات', 'meals' => 'الوجبات', 'salaries' => 'المرتبات', 'extraExpenses' => 'منصرفات إضافية', 'note' => 'ملاحظة'],
            'buys' => [...$this->id, ...$this->timestamp, ...$this->amount, ...$this->price, 'productName' => 'اسم المنتج', 'measure' => 'المقاس'],
        ][$validate->table];

        try {
            //code...
            $data = DB::table($validate->table)->whereBetween('created_at', [$validate->startDate, $validate->endDate])->get();
            Resp::Success('تم', collect($data)->concat($colums));
        } catch (\Throwable $th) {
            //throw $th;
            Resp::Error('حدث خطأ ما في عملية المقارنة', $th);
        }
    }
}
