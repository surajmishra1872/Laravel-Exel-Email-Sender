<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class emailsender extends Controller
{
    public function store(Request $request)
    {
        $file = $request->exelfile;
        $path = $file->store('exelfiles');
        $file_path = Storage::path($path);
        $file = fopen($file_path,"r");
        $all_data = [];
        while ( ($data = fgetcsv($file) ) !== FALSE ) {
            array_push($all_data,$data);
        }
        for($i=1;$i<sizeof($all_data);$i++) {  
         Mail::to($all_data[$i][3])->send(new WelcomeMail($all_data[$i][2]));
        }

    }
}
