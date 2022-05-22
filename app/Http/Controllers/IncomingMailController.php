<?php

namespace App\Http\Controllers;

use App\Models\IncomingMail;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

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
                            ->orWhere('mail_from', 'LIKE', '%' . $incoming_mail . '%')
                            ->orWhere('mail_from', 'LIKE', '%' . $incoming_mail . '%')
                            ->orWhere('sender', 'LIKE', '%' . $incoming_mail . '%')
                            ->orWhere('destination', 'LIKE', '%' . $incoming_mail . '%')
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
            'mail_from' => 'required',
            'sender' => 'required',
            'destination' => 'required',
            'about' => 'required',
            'link' => 'required_if:file,==,NULL',
            'file' => 'required_if:link,==,NULL|mimes:jpg,jpeg,png,pdf|max:1000',
        ]);

		$input['mail_number'] = $request->mail_number;
		$input['letter_date'] = $request->letter_date;
		$input['entry_date'] = $request->entry_date;
		$input['mail_from'] = $request->mail_from;
		$input['sender'] = $request->sender;
		$input['destination'] = $request->destination;
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
            'mail_from' => 'required',
            'sender' => 'required',
            'destination' => 'required',
            'about' => 'required',
            'link' => 'required_if:file,==,NULL',
            'file' => 'required_if:link,==,NULL|mimes:jpg,jpeg,png,pdf|max:1000',
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
    	$incoming_mail->delete();

        activity()->log('Hapus Data Surat Masuk dengan ID = '.$incoming_mail->id);
        return redirect('/incoming_mail')->with('status', 'Data Berhasil Dihapus');
    }
}
