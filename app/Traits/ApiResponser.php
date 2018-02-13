<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Item;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Transformers\GitLabTransformer;
use App\Transformers\RepoTransformer;
use Illuminate\Support\Facades\Route;
/***
* @author Omar Issa 
* This is an Api Response used by all controller. Main Objective of this class is serve  * response for all request that handel by controller. 
* This class have all method for sort , filter, pagniate and cahce response too.
* 
* @return response object 
*   @response {
*  data: [],
*}
*/

trait ApiResponser
{
	private function successResponse($data, $code)
	{
		return response()->json($data, $code);
	}

	protected function errorResponse($message, $code)
	{
		return response()->json(['error' => $message, 'code' => $code], $code);
	}

	/**
	* This function used to showall response. 
	* @param $data collection , status code
	* @return response filtered , reponsed and paginated.  
	*/
	protected function showAll(Collection $collection, $code = 200)
	{
		if ($collection ->isEmpty()) {
			return $this->successResponse(['data' => $collection], $code);
		}
		$url = Route::currentRouteName();
		if($url == 'github.index' ||$url ==' github.getFiles'){
			$transformer =  new RepoTransformer();
		}else{
			$transformer =  new GitLabTransformer();
		}
	;
		$collection = $this->filterData($collection, $transformer);
		$collection = $this->sortData($collection, $transformer);
		$collection = $this->paginate($collection);
		$collection = $this->transformData($collection,$transformer);
		// $collection = $this->cacheResponse($collection);		

		return $this->successResponse($collection, $code);
	}

	protected function showOne(Model $instance, $code = 200)
	{
		$transformer = $instance->transformer;

		$instance = $this->transformData($instance, $transformer);

		return $this->successResponse($instance, $code);
	}

	protected function showMessage($message, $code = 200)
	{
		return $this->successResponse(['data' => $message], $code);
	}

	/**
	* This function used to filter response. 
	* @param $data collection , $tranformer object 
	* @return collection object 
	*/
	protected function filterData(Collection $collection, $transformer)
	{
		foreach (request()->query() as $query => $value) {
			$attribute = $transformer::originalAttribute($query);

			if (isset($attribute, $value)) {
				$collection = $collection->where($attribute, $value);
			}
		}

		return $collection;
	}

	protected function sortData(Collection $collection, $transformer)
	{
		if (request()->has('sort_by')) {
			$attribute = $transformer::originalAttribute(request()->sort_by);
         	$collection = $collection->sortBy->{$attribute};
		}

		return $collection;
	}

	/**
	* This function used to pafinate  response. 
	* @param $collection 
	* @return pagination object 
	*/
	protected function paginate(Collection $collection)
	{
		$rules = [
			'per_page' => 'integer|min:2|max:25',
		];

		Validator::validate(request()->all(), $rules);

		$page = LengthAwarePaginator::resolveCurrentPage();

		$perPage = 25;
		if (request()->has('per_page')) {
			$perPage = (int) request()->per_page;
		}

		$results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

		$paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
			'path' => LengthAwarePaginator::resolveCurrentPath(),
		]);

		$paginated->appends(request()->all());

		return $paginated;

	}

	/**
	* This function used to transform response. 
	* @param $data collection , $transformer object
	* @return array object  
	*/
	protected function transformData($data,$transformer)
	{
	
		$transformation = fractal($data, new $transformer);

		return $transformation->toArray();
	}
	/**
	* This function used to chache response. 
	* @param $data collection 
	* @return Chache object 
	*/
	protected function cacheResponse($data)
	{
		$url = request()->url();
		$queryParams = request()->query();

		ksort($queryParams);

		$queryString = http_build_query($queryParams);

		$fullUrl = "{$url}?{$queryString}";

		return Cache::remember($fullUrl, 30/60, function() use($data) {
			return $data;
		});
	}
}