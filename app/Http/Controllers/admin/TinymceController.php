<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TinymceController extends Controller
{
    
    public function upload(Request $request)
{
    $file = $request->file('file');
    $path = $file->store('images/tinymce', 'public'); // یا هر مسیری که می‌خوای
    return response()->json(['location' => asset('storage/' . $path)]);
}
}
