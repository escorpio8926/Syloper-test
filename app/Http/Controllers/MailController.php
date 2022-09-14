<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class MailController extends Controller
{
    public function sendEmail(Request $request){
        $details=[
            "title" => $request -> Motivo,
            "body" => $request -> descripcion
        ];
    Mail::to($request -> mail)->send(new TestMail($details));
    return view('emails.contacto');
    }

    public function index() 
    {   
        return view('emails.contacto');
    }
}
