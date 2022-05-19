<?php

namespace App\Http\Controllers;

use App\Models\GuestBook;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class GuestBookController extends Controller
{
    ## Tampikan Data
    public function index()
    {
        $title = "Buku Tamu";
        $guest_book = GuestBook::orderBy('id', 'DESC')->paginate(25)->onEachSide(1);
        return view('guest_book.index', compact('title', 'guest_book'));
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Buku Tamu";
        $guest_book = $request->get('search');
        $guest_book = GuestBook::
                        where(function ($query) use ($guest_book) {
                            $query->where('guest_name', 'LIKE', '%' . $guest_book . '%')
                                ->orWhere('agency_name', 'LIKE', '%' . $guest_book . '%')
                                ->orWhere('destination_name', 'LIKE', '%' . $guest_book . '%')
                                ->orWhere('necessity', 'LIKE', '%' . $guest_book . '%');
                        })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        return view('guest_book.index', compact('title', 'guest_book'));
    }
	
    ## Simpan Data
    public function store(Request $request)
    {
		$input['guest_name'] = $request->guest_name;
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
 
}
