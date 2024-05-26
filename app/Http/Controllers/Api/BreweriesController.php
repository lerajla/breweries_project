<?php

namespace App\Http\Controllers\Api;

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

      Log::channel('api')->info('API: Get breweries list');

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
}
