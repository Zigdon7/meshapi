<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use App\Models\Mesh;



class MeshController extends Controller
{
    /*
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    { }

    /*
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveMesh(Request $request)
    {
        $mesh = new Mesh;
        $mesh->name = $request->name;
        $mesh->uuid = $request->uuid;
        $mesh->srcpts = $request->srcpts;
        $mesh->dstpts = $request->dstpts;
        $mesh->colors = $request->colors;
        $mesh->shorturl = $request->shorturl;
        $mesh->save();
        return $mesh;
    }
    public function shortUrl(Request $request){
        $mesh = Mesh::where('shorturl', $request->shorturl)->get();
        if(!$mesh->isEmpty()){
            return $mesh->first();
        } else {
            return null;
        }
    }
}
