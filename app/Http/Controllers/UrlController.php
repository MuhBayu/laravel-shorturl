<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Url;

class UrlController extends Controller
{
   public function __construct()
   {
   }
   public function index($alias) {
      $url = Url::where(['alias' => $alias]);
      if ($data = $url->first()) {
         $url->update(['views' => ++$data->views]);
         return redirect($data->source_url);
      } else {
         abort(404);
      }
   }
   public function shorten(Request $request) {
      $long_url = $request->input('long_url');
      $alias = generateRandomString();

      $url = Url::where(['source_url' => $long_url]);
      if ($data = $url->first()) {
         $alias = $data->alias;
      } else {
         $insert = Url::insert([
            'alias' => $alias,
            'source_url' => $long_url,
            'views' => 0,
         ]);
      }
      return response()->json([
         'success' => true,
         'data' => array(
            'alias' => $alias,
            'long_url' => $long_url,
            'link' => url($alias)
         )
      ]);
   }
}
