<?php

namespace App\Http\Controllers;

use App\Models\GuestBook;   //nama model
use App\Models\IncomingMail;   //nama model
use App\Models\OutgoingMail;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index()
    {
        $guest_book = GuestBook::count();
        $incoming_mail = IncomingMail::count();
        $outgoing_mail = OutgoingMail::count();
        return view('admin.beranda', compact('guest_book','incoming_mail','outgoing_mail'));
    }
}
