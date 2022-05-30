<?php

namespace App\Http\Controllers;

use App\Models\IncomingMail;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class IncomingMailController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Surat Masuk";
        $incoming_mail = IncomingMail::orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.incoming_mail.index',compact('title','incoming_mail'));
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Surat Masuk";
        $incoming_mail = $request->get('search');
        $incoming_mail = IncomingMail::where(function ($query) use ($incoming_mail) {
                        $query->where('mail_number', 'LIKE', '%' . $incoming_mail . '%')
                            ->orWhere('sender', 'LIKE', '%' . $incoming_mail . '%')
                            ->orWhere('about', 'LIKE', '%' . $incoming_mail . '%');
                        })
                        ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        return view('admin.incoming_mail.index',compact('title','incoming_mail'));
    }
	
    ## Tampilkan Form Create
    public function create()
    {
        $title = "Surat Masuk";
		$view=view('admin.incoming_mail.create',compact('title'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'mail_number' => 'required',
            'letter_date' => 'required',
            'entry_date' => 'required',
            'sender' => 'required',
            'about' => 'required',
            'link' => 'required_if:file,==,NULL',
            'file' => 'mimes:jpg,jpeg,png,pdf|max:1000',
        ]);

		$input['mail_number'] = $request->mail_number;
		$input['letter_date'] = $request->letter_date;
		$input['entry_date'] = $request->entry_date;
		$input['sender'] = $request->sender;
		$input['about'] = $request->about;
		$input['link'] = $request->link;

        if($request->file('file')){
			$input['file'] = time().'.'.$request->file->getClientOriginalExtension();
			$request->file->move(public_path('upload/file_surat_masuk'), $input['file']);
    	}	

		$input['user_id'] = Auth::user()->id;
		
        IncomingMail::create($input);
        
        activity()->log('Tambah Data Surat Masuk');
		return redirect('/incoming_mail')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($incoming_mail)
    {
        $title = "Surat Masuk";
        $incoming_mail = Crypt::decrypt($incoming_mail);
        $incoming_mail = IncomingMail::where('id',$incoming_mail)->first();
        $view=view('admin.incoming_mail.edit', compact('title','incoming_mail'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $incoming_mail)
    {
        
        $incoming_mail = Crypt::decrypt($incoming_mail);
        $incoming_mail = IncomingMail::where('id',$incoming_mail)->first();

        $this->validate($request, [
            'mail_number' => 'required',
            'letter_date' => 'required',
            'entry_date' => 'required',
            'sender' => 'required',
            'about' => 'required',
            'link' => 'required_if:file,==,NULL',
            'file' => 'mimes:jpg,jpeg,png,pdf|max:1000',
        ]);

        if($request->file('file') && $incoming_mail->file){
            $pathToYourFile = public_path('upload/file_surat_masuk/'.$incoming_mail->file);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $incoming_mail->fill($request->all());
        
        if($request->file('file')){
            $filename = time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path('upload/file_surat_masuk'), $filename);
            $incoming_mail->file = $filename;
		}

		$incoming_mail->user_id = Auth::user()->id;
    	$incoming_mail->save();
		
        activity()->log('Ubah Data Surat Masuk dengan ID = '.$incoming_mail->id);
		return redirect('/incoming_mail')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($incoming_mail)
    {
        $incoming_mail = Crypt::decrypt($incoming_mail);
        $incoming_mail = IncomingMail::where('id',$incoming_mail)->first();
        
        $pathToYourFile = public_path('upload/file_surat_masuk/'.$incoming_mail->file);
        if($incoming_mail->file)
        {
            unlink($pathToYourFile);
        }

    	$incoming_mail->delete();

        activity()->log('Hapus Data Surat Masuk dengan ID = '.$incoming_mail->id);
        return redirect('/incoming_mail')->with('status', 'Data Berhasil Dihapus');
    }

    ## Tampilkan Data Search
    public function report_excel(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(6);
		$sheet->getColumnDimension('B')->setWidth(30);
		$sheet->getColumnDimension('C')->setWidth(20);
		$sheet->getColumnDimension('D')->setWidth(30);
		$sheet->getColumnDimension('E')->setWidth(20);
		$sheet->getColumnDimension('F')->setWidth(90);

        $sheet->setCellValue('A1', 'DATA SURAT MASUK'); $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        
        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'NOMOR SURAT');
        $sheet->setCellValue('C3', 'TANGGAL SURAT');
        $sheet->setCellValue('D3', 'INSTANSI PENGIRIM');
        $sheet->setCellValue('E3', 'TANGGAL MASUK');
        $sheet->setCellValue('F3', 'PERIHAL');
        
        $sheet->getStyle('A3:F3')->getFont()->setBold(true);

        $rows = 4;
        $no = 1;
    
        $incoming_mail = IncomingMail::get();
        
        foreach($incoming_mail as $v){
            $sheet->setCellValue('A' . $rows, $no++);
            $sheet->setCellValue('B' . $rows, $v->mail_number);
            $sheet->setCellValue('C' . $rows, date('d-m-Y', strtotime($v->letter_date)));
            $sheet->setCellValue('D' . $rows, $v->sender);
            $sheet->setCellValue('E' . $rows, date('d-m-Y', strtotime($v->entry_date)));
            $sheet->setCellValue('F' . $rows, $v->about);
            $rows++;
        }
        
        $sheet->getStyle('A3:F'.($rows-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A3:F'.($rows-1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $type = 'xlsx';
        $fileName = "DATA SURAT MASUK.".$type;

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
