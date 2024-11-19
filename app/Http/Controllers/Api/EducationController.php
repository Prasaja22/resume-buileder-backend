<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Education\EducationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\EducationResource;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    private $educationHelper;

    public function __construct()
    {
        $this->educationHelper = new EducationHelper();
    }

    public function index(Request $request){

        $filter = [
            'm_user_id' => $request->m_user_id ?? '',
            'description' => $request->description ?? '',
            'id' => $request->id ?? '',
        ];


        $education = $this->educationHelper->getAll($filter, $request->page ?? 1, $request->per_page ?? 25, $request->sort ?? '');

        return response()->success([
            'list' => EducationResource::collection($education['data']['data']),
            'meta' => [
                'total' => $education['data']['total'],
            ],
        ]);

    }

    public function store(Request $request){

        $payload = $request->only(['m_user_id', 'description']);


        $education = $this->educationHelper->store($payload);


        if(!$education['status']){
            return response()->failed($education['error']);
        }

        return response()->success(new EducationResource($education['data']));
    }

    public function show(string $id)
    {
        $education = $this->educationHelper->getById($id);

        return response()->success(new EducationResource($education['data']));
    }

    public function update(Request $request, string $id)
    {
        $payload =  $request->only(['description', 'm_user_id']);

        $education = $this->educationHelper->update($payload,$id);

        if(!$education['status']) {
            return response()->failed($education['error']);
        }

        return response()->success(new EducationResource($education['data']['data']));
    }
}
