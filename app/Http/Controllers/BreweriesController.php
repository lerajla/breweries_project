<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\BreweriesDispatcherBusiness;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BreweriesController extends Controller
{
    public function list(Request $request){

      Log::channel('app')->info('Get breweries list');

      if($request->ajax()){
        $breweriesDispatcherBusiness = new BreweriesDispatcherBusiness();
        $dispatcherDto = $breweriesDispatcherBusiness->listBreweries();

        $result = [
          'success' => false,
          'data' => [],
          'message' => ''
        ];
        if ($dispatcherDto->isSuccess()) {
          $data = $dispatcherDto->getData();
          $result = [
            'success' => true,
            'data' => $data
          ];
          return response()->json($result);
        }else {
          $result['message'] = $dispatcherDto->getMessage();
        }
        return response()->json($result);
      }
        return view('breweries.list');
    }
}
