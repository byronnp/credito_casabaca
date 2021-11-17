<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\TestDriveEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public static function testDrive(Request $request)
    {
        dd($request);
        Mail::to($request)
            ->send(new TestDriveEmail());

    }
}
