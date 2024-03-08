<?php

namespace App\Http\Controllers;

use App\Files;
use App\Traits\Upload;
use Illuminate\Http\Request;

class FilesController extends Controller
{
  use Upload; //add this trait

  public function store(Request $request)
  {
    $photo = false;
    $vac = false;
    if ($request->hasFile('photo')) {
      $path = $this->uploadFile($request->file('photo'), 'Photos'); //use the method in the trait
      Files::create([
        'path' => $path
      ]);
      $photo = true;
    }
    if ($request->hasFile('vet_confirmation')) {
      $path = $this->uploadFile($request->file('vet_confirmation'), 'VetConfirmations'); //use the method in the trait
      Files::create([
        'path' => $path
      ]);
      $vac = true;
    }
    if ($vac or $photo) {
      return redirect()->route('files.index')->with('success', 'File Uploaded Successfully');
    }
    return redirect()->route('files.index')->with('error', 'File Upload Failed');
  }
}
