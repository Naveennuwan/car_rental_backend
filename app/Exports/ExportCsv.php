<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;
use App\Models\PaymentStatus;
use App\Models\CustomPermission;
use App\Models\CustomRole;
use App\Models\User;
use App\Models\Faq;
use App\Models\Category;
use App\Models\ShippingStatus;
use App\Models\ShippingCharge;
use App\Models\Prefecture;
use App\Models\GiftBox;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\OrderHeader;
use App\Models\OrderDetail;
use App\Models\Tax;
use Illuminate\Support\Facades\DB;

class ExportCsv
{
    protected $selected_ids;

    public function __construct($selected_ids)
    {
        $this->selected_ids = $selected_ids;
    }

    public function exportCategory($filePath)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = ['Id', 'Name', 'Created By', 'Created Date'];

        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;

        foreach ($this->selected_ids as $user) {

            $dataObj = Category::with('userCreateInfo')->where('id', $user)->first();

            $formattedCreatedDate = Carbon::parse($dataObj->created_at)->format('Y-m-d');

            $sheet->setCellValue('A' . $row, $dataObj->id);
            $sheet->setCellValue('B' . $row, $dataObj->name);
            $sheet->setCellValue('C' . $row, $dataObj->userCreateInfo->name . " " . $dataObj->userCreateInfo->first_name);
            $sheet->setCellValue('D' . $row, $formattedCreatedDate);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public function exportFaq($filePath)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = ['Id', 'Question', 'Answer', 'Created By', 'Created Date'];

        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;

        foreach ($this->selected_ids as $user) {

            $dataObj = Faq::with('userCreateInfo')->where('id', $user)->first();

            $formattedCreatedDate = Carbon::parse($dataObj->created_at)->format('Y-m-d');

            $sheet->setCellValue('A' . $row, $dataObj->id);
            $sheet->setCellValue('B' . $row, $dataObj->question);
            $sheet->setCellValue('C' . $row, $dataObj->answer);
            $sheet->setCellValue('D' . $row, $dataObj->userCreateInfo->name . " " . $dataObj->userCreateInfo->first_name);
            $sheet->setCellValue('E' . $row, $formattedCreatedDate);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public function exportPaymentStatus($filePath)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['Id', 'Name Jp', 'Name En', 'Created By', 'Created Date'];

        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;

        foreach ($this->selected_ids as $pymt) {

            $dataObj = PaymentStatus::where('id', $pymt)->first();

            $formattedCreatedDate = Carbon::parse($dataObj->created_at)->format('Y-m-d');

            $sheet->setCellValue('A' . $row, $dataObj->id);
            $sheet->setCellValue('B' . $row, $dataObj->name_jp);
            $sheet->setCellValue('C' . $row, $dataObj->name_en);
            $sheet->setCellValue('D' . $row, $dataObj->userCreateInfo->name . " " . $dataObj->userCreateInfo->first_name);
            $sheet->setCellValue('E' . $row, $formattedCreatedDate);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public function exportPermission($filePath)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['Id', 'Name', 'Name jp', 'Resource', 'Created by', 'Created Date'];

        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;

        foreach ($this->selected_ids as $permission) {

            $dataObj = CustomPermission::where('id', $permission)->first();

            $formattedCreatedDate = Carbon::parse($dataObj->created_at)->format('Y-m-d');

            $sheet->setCellValue('A' . $row, $dataObj->id);
            $sheet->setCellValue('B' . $row, $dataObj->name);
            $sheet->setCellValue('C' . $row, $dataObj->name_jp);
            $sheet->setCellValue('D' . $row, $dataObj->resource->name);
            $sheet->setCellValue('E' . $row, $dataObj->userCreateInfo->name . " " . $dataObj->userCreateInfo->first_name);
            $sheet->setCellValue('F' . $row, $formattedCreatedDate);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public function exportRole($filePath)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['Id', 'Name', 'Name Jp', 'Remarks', 'Guard Name', 'Created By', 'Created Date'];

        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;

        foreach ($this->selected_ids as $role) {

            $dataObj = CustomRole::where('id', $role)->first();

            $formattedCreatedDate = Carbon::parse($dataObj->created_at)->format('Y-m-d');

            $sheet->setCellValue('A' . $row, $dataObj->id);
            $sheet->setCellValue('B' . $row, $dataObj->name);
            $sheet->setCellValue('C' . $row, $dataObj->name_jp);
            $sheet->setCellValue('D' . $row, $dataObj->remarks);
            $sheet->setCellValue('E' . $row, $dataObj->guard_name);
            $sheet->setCellValue('F' . $row, $dataObj->userCreateInfo->name . " " . $dataObj->userCreateInfo->first_name);
            $sheet->setCellValue('G' . $row, $formattedCreatedDate);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public function exportShippingStatus($filePath)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = ['Id', 'Name JP', 'Name EN', 'Created By', 'Created Date'];

        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;

        foreach ($this->selected_ids as $user) {

            $dataObj = ShippingStatus::with('userCreateInfo')->where('id', $user)->first();

            $formattedCreatedDate = Carbon::parse($dataObj->created_at)->format('Y-m-d');

            $sheet->setCellValue('A' . $row, $dataObj->id);
            $sheet->setCellValue('B' . $row, $dataObj->name_jp);
            $sheet->setCellValue('C' . $row, $dataObj->name_en);
            $sheet->setCellValue('D' . $row, $dataObj->userCreateInfo->name . " " . $dataObj->userCreateInfo->first_name);
            $sheet->setCellValue('E' . $row, $formattedCreatedDate);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public function exportShippingManagement($filePath)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = ['Id', 'Area', 'Delivery Method', 'Created By', 'Created Date'];

        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;

        foreach ($this->selected_ids as $user) {

            $dataObj = ShippingCharge::with('userCreateInfo')->with('areas')->with('deliveryMethods')->where('id', $user)->first();

            $formattedCreatedDate = Carbon::parse($dataObj->created_at)->format('Y-m-d');

            $sheet->setCellValue('A' . $row, $dataObj->id);
            $sheet->setCellValue('B' . $row, $dataObj->areas->name);
            $sheet->setCellValue('C' . $row, $dataObj->deliveryMethods->name);
            $sheet->setCellValue('D' . $row, $dataObj->userCreateInfo->name . " " . $dataObj->userCreateInfo->first_name);
            $sheet->setCellValue('E' . $row, $formattedCreatedDate);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public function exportUser($filePath)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = ['Id', 'Name', 'First Name', 'Last Name Furigana', 'First Name Furigana', 'Email', 'Created By', 'Created Date'];

        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;

        foreach ($this->selected_ids as $user) {

            $dataObj = User::with('userCreateInfo')->where('id', $user)->first();

            $formattedCreatedDate = Carbon::parse($dataObj->created_at)->format('Y-m-d');

            $sheet->setCellValue('A' . $row, $dataObj->id);
            $sheet->setCellValue('B' . $row, $dataObj->name);
            $sheet->setCellValue('C' . $row, $dataObj->first_name);
            $sheet->setCellValue('D' . $row, $dataObj->last_name_furigana);
            $sheet->setCellValue('D' . $row, $dataObj->first_name_furigana);
            $sheet->setCellValue('F' . $row, $dataObj->email);
            $sheet->setCellValue('G' . $row, $dataObj->userCreateInfo->name . " " . $dataObj->userCreateInfo->first_name);
            $sheet->setCellValue('H' . $row, $formattedCreatedDate);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public function exportPrefecture($filePath)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = ['Id', 'Name', 'Area', 'Created By', 'Created Date'];

        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;

        foreach ($this->selected_ids as $user) {

            $dataObj = Prefecture::with('userCreateInfo')->where('id', $user)->first();

            $formattedCreatedDate = Carbon::parse($dataObj->created_at)->format('Y-m-d');

            $sheet->setCellValue('A' . $row, $dataObj->id);
            $sheet->setCellValue('B' . $row, $dataObj->name);
            $sheet->setCellValue('C' . $row, $dataObj->areas->name);
            $sheet->setCellValue('D' . $row, $dataObj->userCreateInfo->name . " " . $dataObj->userCreateInfo->first_name);
            $sheet->setCellValue('E' . $row, $formattedCreatedDate);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public function exportGiftBox($filePath)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = ['BOX ID', 'サイト表示', '袋', '瓶','BOXタイトル', '説明文', '型番', 'W', 'D', 'H', '金額'];

        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;

        foreach ($this->selected_ids as $user) {

            $dataObj = GiftBox::where('id', $user)->first();

            $sheet->setCellValue('A' . $row, $dataObj->id);
            $sheet->setCellValue('B' . $row, $dataObj->isDisplay);
            $sheet->setCellValue('C' . $row, $dataObj->bag);
            $sheet->setCellValue('D' . $row, $dataObj->bottle);
            $sheet->setCellValue('E' . $row, $dataObj->name);
            $sheet->setCellValue('F' . $row, $dataObj->explanatory_note);
            $sheet->setCellValue('G' . $row, $dataObj->model_number);
            $sheet->setCellValue('H' . $row, $dataObj->width_mm);
            $sheet->setCellValue('I' . $row, $dataObj->depth_mm);
            $sheet->setCellValue('J' . $row, $dataObj->height_mm);
            $sheet->setCellValue('K' . $row, $dataObj->price);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public function exportCustomer($filePath)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = ['顧客ID', '姓', '名', 'せい', 'めい', '郵便番号', '都道府県', '市区町村',
        '番地', 'マンション・ビル名', '電話番号', 'メールアドレス', '生年月日', '過去注文回数'];

        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;

        foreach ($this->selected_ids as $user) {

            $dataObj = User::where('id', $user)->first();

            $totals = OrderHeader::where('created_by', $dataObj->id)
            ->selectRaw('Count(id) as total_orders')
            ->first();

            $sheet->setCellValue('A' . $row, $dataObj->id);
            $sheet->setCellValue('B' . $row, $dataObj->name);
            $sheet->setCellValue('C' . $row, $dataObj->first_name);
            $sheet->setCellValue('D' . $row, $dataObj->last_name_furigana);
            $sheet->setCellValue('E' . $row, $dataObj->first_name_furigana);
            $sheet->setCellValue('F' . $row, $dataObj->postal_code);
            $sheet->setCellValue('G' . $row, $dataObj->prefectures->name);
            $sheet->setCellValue('H' . $row, $dataObj->municipalities);
            $sheet->setCellValue('I' . $row, $dataObj->house_number);
            $sheet->setCellValue('J' . $row, $dataObj->name_of_apartment_building);
            $sheet->setCellValue('K' . $row, $dataObj->phone_number);
            $sheet->setCellValue('L' . $row, $dataObj->email);
            $sheet->setCellValue('M' . $row, $dataObj->date_of_birth);
            $sheet->setCellValue('N' . $row, $totals->total_orders);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public function exportProduct($filePath)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = [
            '商品ID', '商品名', 'サイト表示', '商品分類', '在庫以上の購入', 'ギフトボックス', 'ラッピング', 'カテゴリ', '品番', '内容量', '金額', '説明文',
            '保存方法', '注意事項', '原材料', 'エネルギー', 'たんぱく質', '脂質', '炭水化物', '食塩相当量', '自分用', 'プレゼント用', 'その他' , 'Tax Rate'
        ];

        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;

        foreach ($this->selected_ids as $id) {

            $dataObj = Product::where('id', $id)->first();
            $categories = $dataObj->categories->pluck('name')->implode(', ');
            $relatedRates = $dataObj->taxes->where('id', $dataObj->tax_id)->pluck('rate')->implode(', ');

            $sheet->setCellValue('A' . $row, $dataObj->id);
            $sheet->setCellValue('B' . $row, $dataObj->name);
            $sheet->setCellValue('C' . $row, $dataObj->isDisplay);
            $sheet->setCellValue('D' . $row, $dataObj->classification);
            $sheet->setCellValue('E' . $row, $dataObj->isOverstock);
            $sheet->setCellValue('F' . $row, $dataObj->isGiftBox);
            $sheet->setCellValue('G' . $row, $dataObj->isGiftWrapping);
            $sheet->setCellValue('H' . $row, $categories);
            $sheet->setCellValue('I' . $row, $dataObj->item_stock_number);
            $sheet->setCellValue('J' . $row, $dataObj->content_by_volume);
            $sheet->setCellValue('K' . $row, $dataObj->price);
            $sheet->setCellValue('L' . $row, $dataObj->explanatory_note);
            $sheet->setCellValue('M' . $row, $dataObj->storage_method);
            $sheet->setCellValue('N' . $row, $dataObj->precautions);
            $sheet->setCellValue('O' . $row, $dataObj->raw_material);
            $sheet->setCellValue('P' . $row, $dataObj->nutrition_facts_energy);
            $sheet->setCellValue('Q' . $row, $dataObj->nutrition_facts_protein);
            $sheet->setCellValue('R' . $row, $dataObj->nutrition_facts_lipids);
            $sheet->setCellValue('S' . $row, $dataObj->nutrition_facts_carbohydrates);
            $sheet->setCellValue('T' . $row, $dataObj->nutrition_facts_salt_equivalent);
            $sheet->setCellValue('U' . $row, $dataObj->explanatory_note);
            $sheet->setCellValue('V' . $row, 'not define');
            $sheet->setCellValue('W' . $row, 'not define');
            $sheet->setCellValue('X' . $row, $relatedRates);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public function exportInventory($filePath)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = ['商品ID', '商品名', '在庫数', '増加予定', '削除予定'];

        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;

        foreach ($this->selected_ids as $user) {
            $dataObj = DB::table('products as p')
            ->select([
                'p.id as id',
                'p.name as name',
                DB::raw('(SELECT COALESCE(SUM(CASE WHEN i.inventory_type = "Increase" THEN i.quantity ELSE -i.quantity END), 0)
                    FROM inventories i
                    WHERE i.product_id = p.id
                    AND i.deleted_at IS NULL) AS balance_quantity'),
                DB::raw('(SELECT i.change_date_time
                    FROM inventories i
                    WHERE i.inventory_type = "increase"
                    AND i.product_id = p.id
                    AND i.deleted_at IS NULL
                    ORDER BY i.id
                    LIMIT 1) AS lastIncreaseRecord'),
                DB::raw('(SELECT i.change_date_time
                    FROM inventories i
                    WHERE i.inventory_type = "decrease"
                    AND i.product_id = p.id
                    AND i.deleted_at IS NULL
                    ORDER BY i.id
                    LIMIT 1) AS lastDecreaseRecord')
            ])
            ->first();

                $sheet->setCellValue('A' . $row, $dataObj->id);
                $sheet->setCellValue('B' . $row, $dataObj->name);
                $sheet->setCellValue('C' . $row, $dataObj->balance_quantity);
                $sheet->setCellValue('D' . $row, $dataObj->lastIncreaseRecord);
                $sheet->setCellValue('E' . $row, $dataObj->lastDecreaseRecord);

                $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public function exportOrder($filePath)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = [
            '注文ID', '注文日時', '出荷日', '支払い状況', '配送回数', '伝票番号1', '発送状況1', '伝票番号2', '発送状況2',
            '商品ID', '商品名', '単価', '個数', '顧客ID', '顧客名', 'メールアドレス', '総額', '購入目的',
        ];

        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;

        foreach ($this->selected_ids as $id) {

            $dataObj = OrderHeader::where('id', $id)->first();

            $dataDetails = OrderDetail::where('order_header_id', $id)->get();


            foreach ($dataDetails as $details) {
                $sheet->setCellValue('A' . $row, $dataObj->id);
                $sheet->setCellValue('B' . $row, $dataObj->date_time);
                $sheet->setCellValue('C' . $row, "Which Shipment Date");
                $sheet->setCellValue('D' . $row, $dataObj->paymentStatuses->name_jp);
                $sheet->setCellValue('E' . $row, $dataObj->number_of_shipments);
                $sheet->setCellValue('F' . $row, $dataObj->voucher_no_1);
                $sheet->setCellValue('G' . $row, $dataObj->shippingStatuses_1->name_jp);
                $sheet->setCellValue('H' . $row, $dataObj->voucher_no_2);
                $sheet->setCellValue('I' . $row, $dataObj->shippingStatuses_2->name_jp);
                $sheet->setCellValue('J' . $row, $details->product_id);
                $sheet->setCellValue('K' . $row, $details->products->name);
                $sheet->setCellValue('L' . $row, $details->price);
                $sheet->setCellValue('M' . $row, $details->quantity);
                $sheet->setCellValue('N' . $row, $dataObj->user_id);
                $sheet->setCellValue('O' . $row, $dataObj->customers->name);
                $sheet->setCellValue('P' . $row, $dataObj->customers->email);
                $sheet->setCellValue('Q' . $row, number_format($details->price * $details->quantity, 2));
                $sheet->setCellValue('R' . $row, $dataObj->remarks);

                $row++;

            }
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public function exportOrderDataYamato($filePath)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = [
            'CustomerControlNumber', 'InvoiceType', 'ShippingMethod', 'ShippingPhoneNumber', 'ShippingPostalCode', 'ShippingAddress', 'BuildingName', 'ShippingFullName', 'ProductNameOne',
            'ProductNameTwo', 'BillingCustomerCode', 'FreightControlNumber',
        ];

        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;

        foreach ($this->selected_ids as $dataObj) {
            $sheet->setCellValue('A' . $row, $dataObj->CustomerControlNumber);
            $sheet->setCellValue('B' . $row, $dataObj->InvoiceType);
            $sheet->setCellValue('C' . $row, $dataObj->ShippingMethod);
            $sheet->setCellValue('D' . $row, $dataObj->ShippingPhoneNumber);
            $sheet->setCellValue('E' . $row, $dataObj->ShippingPostalCode);
            $sheet->setCellValue('F' . $row, $dataObj->ShippingAddress);
            $sheet->setCellValue('G' . $row, $dataObj->BuildingName);
            $sheet->setCellValue('H' . $row, $dataObj->ShippingFullName);
            $sheet->setCellValue('I' . $row, $dataObj->ProductNameOne);
            $sheet->setCellValue('J' . $row, $dataObj->ProductNameTwo);
            $sheet->setCellValue('K' . $row, $dataObj->BillingCustomerCode);
            $sheet->setCellValue('L' . $row, $dataObj->FreightControlNumber);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public function exportTax($filePath)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = [
            'Rate',
        ];

        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $row = 2;

        
        foreach ($this->selected_ids as $id) {
            $dataObj = Tax::findOrFail($id);
            // dd($dataObj);
            $sheet->setCellValue('A' . $row, $dataObj->rate);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }
}
