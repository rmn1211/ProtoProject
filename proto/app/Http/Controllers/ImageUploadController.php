<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ImageUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function imageUploadPost(Request $request)
    {
        /*$request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);*/
        $imageName = "time()" . '.' . $request->image->extension();
        //$request->image->storeAs('images', $imageName);// storage/app/images/file.png  aktueller ort
        //$request->image-> neue request nur mit image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $response = Http::attach(
                'file', file_get_contents($image), $imageName)
                ->post('192.168.1.168:8000/upload/1');
        }
        //nächste Blade

        /* Store $imageName name in DATABASE from HERE */
        return response()->view('report.control_handwriting', compact('response')); //  ->with('success','You have successfully upload image.')
        //->with('image',$imageName);
    }
}
