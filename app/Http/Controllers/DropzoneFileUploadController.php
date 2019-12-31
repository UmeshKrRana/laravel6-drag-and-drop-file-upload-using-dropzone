<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ImageUpload;

class DropzoneFileUploadController extends Controller
{
    public function index() {
        return view('image-upload');
    }

// ------------------------ [ Upload Image ] --------------------------
    public function uploadImages(Request $request) {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName().'.'.$image->extension();
        $image->move(public_path('images'),$imageName);
        $data  =   ImageUpload::create(['image_name' => $imageName]);
        return response()->json(["status" => "success", "data" => $data]);
    }

// --------------------- [ Delete image ] -----------------------------
    public function deleteImage(Request $request) {
        $image = $request->file('filename');
        $filename =  $request->get('filename').'.jpeg';
        ImageUpload::where('image_name', $filename)->delete();
        $path = public_path().'/images/'.$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}

