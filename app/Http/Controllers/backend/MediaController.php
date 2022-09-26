<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{
  public function index()
  {
    $directory =  'public/media';
    $files = Storage::allFiles($directory);
    $directories = Storage::allDirectories($directory);
    $data = array(
      'title' => 'All files',
      'files' => $files,
      'directories' => $directories
    );

    $download = Storage::download('public/media');
    dd($download);
    dd($data);

    return view('backend.medias.index')->with($data);
    dd(Storage::allFiles('public/media'));
    dd(Storage::allDirectories('public/media'));
    dd(Storage::allDirectories('public/media'));
    dd(File::allFiles('public/media'));
    dd(Storage::allDirectories('public/media'));
  }
}
