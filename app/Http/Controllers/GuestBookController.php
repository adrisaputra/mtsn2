<?php

namespace App\Http\Controllers;

use App\Models\GuestBook;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class GuestBookController extends Controller
{
    ## Tampikan Data
    public function index()
    {
        $title = "Buku Tamu";
        $guest_book = GuestBook::whereDate('created_at', '=', date('Y-m-d'))->orderBy('id', 'DESC')->paginate(25)->onEachSide(1);

        if(Auth::user()){
            return view('admin.guest_book.index', compact('title', 'guest_book'));
        } else {
            return view('guest_book.index', compact('title', 'guest_book'));
        }
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Buku Tamu";
        $guest_book = $request->get('search');
        if(Auth::user()){
            $date = $request->get('date');
        } else {
            $date = date('Y-m-d');
        }
        $guest_book = GuestBook::whereDate('created_at', '=', $date)
                        ->where(function ($query) use ($guest_book) {
                            $query->where('guest_name', 'LIKE', '%' . $guest_book . '%')
                                ->orWhere('phone_number', 'LIKE', '%' . $guest_book . '%')
                                ->orWhere('agency_name', 'LIKE', '%' . $guest_book . '%')
                                ->orWhere('destination_name', 'LIKE', '%' . $guest_book . '%')
                                ->orWhere('necessity', 'LIKE', '%' . $guest_book . '%');
                        })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        if(Auth::user()){
            return view('admin.guest_book.index', compact('title', 'guest_book'));
        } else {
            return view('guest_book.index', compact('title', 'guest_book'));
        }
    }
	
    ## Simpan Data
    public function store(Request $request)
    {
		$input['guest_name'] = $request->guest_name;
		$input['phone_number'] = $request->phone_number;
		$input['agency_name'] = $request->agency_name;
		$input['destination_name'] = $request->destination_name;
		$input['necessity'] = $request->necessity;

        if(!empty($request->photo)){
            $encoded_data = $request->photo;
            $binary_data = base64_decode( $encoded_data );

            $namafoto = "tamu-".uniqid().".png";
            $result = file_put_contents( public_path().'/upload/images/'.$namafoto, $binary_data );
            if (!$result) die("Could not save image!  Check file permissions.");
         }
        $input['photo'] = $namafoto;
		
        GuestBook::create($input);
        
        activity()->log('Tambah Data Buku Tamu');
		return redirect('/')->with('status','Data Tersimpan');
    }
    
    ## Tampilkan Form Detail
    public function detail($guest_book)
    {
        $title = "Buku Tamu";
        $guest_book = Crypt::decrypt($guest_book);
        $guest_book = GuestBook::where('id',$guest_book)->first();
        $view=view('admin.guest_book.detail', compact('title','guest_book'));
        $view=$view->render();
        return $view;
    }

    ## Hapus Data
    public function delete($guest_book)
    {
        $guest_book = Crypt::decrypt($guest_book);
        $guest_book = GuestBook::where('id',$guest_book)->first();
    	$guest_book->delete();

        activity()->log('Hapus Data guest_book dengan ID = '.$guest_book->id);
        return redirect('/guest_books')->with('status', 'Data Berhasil Dihapus');
    }

    ## Tampilkan Data Search
    public function report_excel(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(6);
		$sheet->getColumnDimension('B')->setWidth(30);
		$sheet->getColumnDimension('C')->setWidth(30);
		$sheet->getColumnDimension('D')->setWidth(30);
		$sheet->getColumnDimension('E')->setWidth(30);
		$sheet->getColumnDimension('F')->setWidth(30);
		$sheet->getColumnDimension('G')->setWidth(30);

        $guest_book = $request->get('search');
        if($request->get('date')){
            $date = $request->get('date');
        } else {
            $date = date('Y-m-d');
        }

        $sheet->setCellValue('A1', 'DATA BUKU TAMU TANGGAL '. date('d-m-Y', strtotime($date))); $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        
        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'NAMA TAMU');
        $sheet->setCellValue('C3', 'NO. HP');
        $sheet->setCellValue('D3', 'ASAL INSTANSI');
        $sheet->setCellValue('E3', 'YANG INGIN DITEMUI');
        $sheet->setCellValue('F3', 'KEPERLUAN');
        $sheet->setCellValue('G3', 'WAKTU');
        
        $sheet->getStyle('A3:G3')->getFont()->setBold(true);

        $rows = 4;
        $no = 1;
    
        $guest_book = GuestBook::whereDate('created_at', '=', $date)
                                ->when(!empty($guest_book), function ($query) use ($guest_book) {
                                    $query->where('guest_name', 'LIKE', '%' . $guest_book . '%')
                                            ->orWhere('phone_number', 'LIKE', '%' . $guest_book . '%')
                                            ->orWhere('agency_name', 'LIKE', '%' . $guest_book . '%')
                                            ->orWhere('destination_name', 'LIKE', '%' . $guest_book . '%')
                                            ->orWhere('necessity', 'LIKE', '%' . $guest_book . '%');
                                })
                                ->orderBy('id','DESC')->get();
        
        foreach($guest_book as $v){
            $sheet->setCellValue('A' . $rows, $no++);
            $sheet->setCellValue('B' . $rows, $v->guest_name);
            $sheet->setCellValue('C' . $rows, $v->phone_number);
            $sheet->getStyle('C' . $rows)->getNumberFormat()->setFormatCode('0');
            $sheet->setCellValue('D' . $rows, $v->agency_name);
            $sheet->setCellValue('E' . $rows, $v->destination_name);
            $sheet->setCellValue('F' . $rows, $v->necessity);
            $sheet->setCellValue('G' . $rows, $v->created_at->format('d-m-Y H:i:s'));
            $rows++;
        }
        
        $sheet->getStyle('A3:G'.($rows-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A3:G'.($rows-1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $type = 'xlsx';
        $fileName = "DATA BUKU TAMU.".$type;

        if($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if($type == 'xls') {
            $writer = new Xls($spreadsheet);			
        }		
        $writer->save("public/upload/report/".$fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/')."/public/upload/report/".$fileName);    

    }
 
}
