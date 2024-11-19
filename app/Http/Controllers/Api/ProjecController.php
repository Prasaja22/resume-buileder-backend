<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Project\ProjectHelper as ProjectProjectHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;

class ProjecController extends Controller
{

    private $projectHelper;

    public function __construct()
    {
        $this->projectHelper = new ProjectProjectHelper();
    }

    public function index(Request $request){

        $filter = [
            'm_user_id' => $request->m_user_id ?? '',
            'description' => $request->description ?? '',
            'id' => $request->id ?? '',
        ];

        $project = $this->projectHelper->getAll($filter, $request->page ?? 1, $request->perpage ?? 25, $request->sort ?? '');

        return response()->success(
            [
                'list' => ProjectResource::collection($project['data']['data']),
                'meta' => [
                    'total' => $project['data']['total'],
                ],
            ]
        );

    }

    public function store(Request $request){

        $payload = $request->only(['m_user_id', 'description']);

        $project = $this->projectHelper->create($payload);

        if(!$project['status']){
            return response()->failed($project['error'], 'gagal simpan data');
        }

        return response()->success(new ProjectResource($project['data'], 'data berhasil ditambahkan'));
    }

    public function update(Request $request, string $id)
    {
        $payload =  $request->only(['description', 'm_user_id']);

        $project = $this->projectHelper->update($id, $payload);

        if(!$project['status']) {
            return response()->failed($project['error']);
        }

        return response()->success(new ProjectResource($project['data']['data']));
    }

    public function show(string $id){
        $project = $this->projectHelper->getById($id);

        if (! ($project['status'])) {
            return response()->failed(['Data project tidak ditemukan'], 404);
        }

        return response()->success(new ProjectResource($project['data']));
    }
}
