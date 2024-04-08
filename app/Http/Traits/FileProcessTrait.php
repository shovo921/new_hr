<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileProcessTrait {

    public function processMultiple(Request $request, $name, $path) {


        foreach ($request->$name as $file) {
            $fileName = uniqid() . Str::random(5) . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public-root')->put($path . '/' . $fileName, file_get_contents($file));
            $fileNames[] = $path . '/' . $fileName;
        }



        if (isset($fileNames)) {
            return $fileNames;
        } else {
            return null;
        }
    }

    public function processSingle(Request $request, $name, $path) {

        $fileName = uniqid() . Str::random(5) . time() . '.' . $request->file($name)->getClientOriginalExtension();
        Storage::disk('public-root')->put($path . '/' . $fileName, file_get_contents($request->file($name)));
        return $path . '/' . $fileName;
    }

}
