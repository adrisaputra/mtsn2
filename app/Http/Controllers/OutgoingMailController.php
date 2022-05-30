<?php

namespace App\Http\Controllers;

use App\Models\OutgoingMail;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class OutgoingMailController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Surat Keluar";
        $outgoing_mail = OutgoingMail::orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.outgoing_mail.index',compact('title','outgoing_mail'));
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Surat Keluar";
        $outgoing_mail = $request->get('search');
        $outgoing_mail = OutgoingMail::where(function ($query) use ($outgoing_mail) {
                        $query->where('mail_number', 'LIKE', '%' . $outgoing_mail . '%')
                            ->orWhere('sender', 'LIKE', '%' . $outgoing_mail . '%')
                            ->orWhere('destination', 'LIKE', '%' . $outgoing_mail . '%')
                            ->orWhere('about', 'LIKE', '%' . $outgoing_mail . '%');
                        })
                        ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        return view('admin.outgoing_mail.index',compact('title','outgoing_mail'));
    }
	
    ## Tampilkan Form Create
    public function create()
    {
        $title = "Surat Keluar";
		$view=view('admin.outgoing_mail.create',compact('title'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'mail_number' => 'required',
            'letter_date' => 'required',
            'sender' => 'required',
            'destination' => 'required',
            'about' => 'required',
            'link' => 'required_if:file,==,NULL',
            'file' => 'mimes:jpg,jpeg,png,pdf|max:1000',
        ]);

		$input['mail_number'] = $request->mail_number;
		$input['letter_date'] = $request->letter_date;
		$input['sender'] = $request->sender;
		$input['destination'] = $request->destination;
		$input['about'] = $request->about;
		$input['link'] = $request->link;

        if($request->file('file')){
			$input['file'] = time().'.'.$request->file->getClientOriginalExtension();
			$request->file->move(public_path('upload/file_surat_keluar'), $input['file']);
    	}	

		$input['user_id'] = Auth::user()->id;
		
        OutgoingMail::create($input);
        
        activity()->log('Tambah Data Surat Keluar');
		return redirect('/outgoing_mail')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($outgoing_mail)
    {
        $title = "Surat Keluar";
        $outgoing_mail = Crypt::decrypt($outgoing_mail);
        $outgoing_mail = OutgoingMail::where('id',$outgoing_mail)->first();
        $view=view('admin.outgoing_mail.edit', compact('title','outgoing_mail'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $outgoing_mail)
    {
        
        $outgoing_mail = Crypt::decrypt($outgoing_mail);
        $outgoing_mail = OutgoingMail::where('id',$outgoing_mail)->first();

        $this->validate($request, [
            'mail_number' => 'required',
            'letter_date' => 'required',
            'sender' => 'required',
            'destination' => 'required',
            'about' => 'required',
            'link' => 'required_if:file,==,NULL',
            'file' => 'mimes:jpg,jpeg,png,pdf|max:1000',
        ]);

        if($request->file('file') && $outgoing_mail->file){
            $pathToYourFile = public_path('upload/file_surat_keluar/'.$outgoing_mail->file);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $outgoing_mail->fill($request->all());
        
        if($request->file('file')){
            $filename = time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path('upload/file_surat_keluar'), $filename);
            $outgoing_mail->file = $filename;
		}

		$outgoing_mail->user_id = Auth::user()->id;
    	$outgoing_mail->save();
		
        activity()->log('Ubah Data Surat Keluar dengan ID = '.$outgoing_mail->id);
		return redirect('/outgoing_mail')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($outgoing_mail)
    {
        $outgoing_mail = Crypt::decrypt($outgoing_mail);
        $outgoing_mail = OutgoingMail::where('id',$outgoing_mail)->first();

        $pathToYourFile = public_path('upload/file_surat_keluar/'.$outgoing_mail->file);
        if($outgoing_mail->file)
        {
            unlink($pathToYourFile);
        }

    	$outgoing_mail->delete();

        activity()->log('Hapus Data Surat Keluar dengan ID = '.$outgoing_mail->id);
        return redirect('/outgoing_mail')->with('status', 'Data Berhasil Dihapus');
    }

    ## Tampilkan Data Search
    public function report_excel(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(6);
		$sheet->getColumnDimension('B')->setWidth(30);
		$sheet->getColumnDimension('C')->setWidth(25);
		$sheet->getColumnDimension('D')->setWidth(30);
		$sheet->getColumnDimension('E')->setWidth(30);
		$sheet->getColumnDimension('F')->setWidth(90);

        $sheet->setCellValue('A1', 'DATA SURAT KELUAR'); $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        
        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'NOMOR SURAT');
        $sheet->setCellValue('C3', 'TANGGAL SURAT KELUAR');
        $sheet->setCellValue('D3', 'NAMA PENGANTAR SURAT');
        $sheet->setCellValue('E3', 'INSTANSI TUJUAN');
        $sheet->setCellValue('F3', 'PERIHAL');
        
        $sheet->getStyle('A3:F3')->getFont()->setBold(true);

        $rows = 4;
        $no = 1;
    
        $outgoing_mail = OutgoingMail::get();
        
        foreach($outgoing_mail as $v){
            $sheet->setCellValue('A' . $rows, $no++);
            $sheet->setCellValue('B' . $rows, $v->mail_number);
            $sheet->setCellValue('C' . $rows, date('d-m-Y', strtotime($v->letter_date)));
            $sheet->setCellValue('D' . $rows, $v->sender);
            $sheet->setCellValue('E' . $rows, $v->destination);
            $sheet->setCellValue('F' . $rows, $v->about);
            $rows++;
        }
        
        $sheet->getStyle('A3:F'.($rows-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A3:F'.($rows-1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $type = 'xlsx';
        $fileName = "DATA SURAT KELUAR.".$type;

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
