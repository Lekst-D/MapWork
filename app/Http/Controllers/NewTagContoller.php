<?php

namespace App\Http\Controllers;

use App\Models\MapTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class NewTagContoller extends Controller
{
    public function show_tags()
    {
        $user = Auth::user();
        $id = Auth::id();

        if ($id != null) {
            $tags = MapTag::where('id_user', $id)->get();
            // foreach ($tags as $tag) {
            //     echo (strval($tag->name) . '<br>');
            //     echo (strval($tag->longitude) . '<br>');
            //     echo (strval($tag->latitude) . '<br>');
            // }
            return ($tags);
        } else {
            return (null);
        }
    }

    public function new_tag(Request $request)
    {
        $user = Auth::user();
        $id = Auth::id();

        $name=$request->name;
        $longitude=$request->longitude;
        $latitude=$request->latitude;

        MapTag::create([
            'id_user' => $id,
            'name' => $name,
            'longitude' => $longitude,
            'latitude' => $latitude,
        ]); 

        $tags = MapTag::where('id_user', $id)->first();
        return ($tags->id);
    }

    public function edit_tag(Request $request)
    {
        $user = Auth::user();
        $id = Auth::id();

        $id_tag =$request->id;

        $name=$request->name;
        $longitude=$request->longitude;
        $latitude=$request->latitude;

        $tags = MapTag::where('id', $id_tag)->get();
        foreach ($tags as $tag) {
            $tag->update([
                'id_user' => $id,
                'name' => $name,
                'longitude' => $longitude,
                'latitude' => $latitude,
            ]);
        }
        $tags = MapTag::where('id', $id_tag)->first();

        return response()
        ->json(['longitude' => $tags->longitude, 'latitude' => $tags->latitude]);
    }

    public function delete_tag(Request $request)
    {
        $user = Auth::user();
        $id = Auth::id();

        $id_tag =$request->id;
        $tags = MapTag::where('id', $id_tag )->delete();

        return ('succesfull');
    }
}
