<?php


namespace App\Services;

use App\Http\Resources\TestResource;
use App\Test;
use Illuminate\Http\Request;

class ShowTests
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
  public function list(){
      $list = Test::all();
      TestResource::withoutWrapping();
      return
          TestResource::collection($list);
  }

    /**
     * @param $id
     * @return TestResource
     */
  public  function showtest($id){

      $t = Test::find($id);

      TestResource::withoutWrapping();
      return new TestResource($t);
  }
}
