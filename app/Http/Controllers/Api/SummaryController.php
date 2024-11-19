<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Summary\SummaryHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\SumaryResource;
use Illuminate\Http\Request;

class SummaryController extends Controller
{

    private $summaryHelper;

    public function __construct()
    {
        $this->summaryHelper = new SummaryHelper();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = [
            'm_user_id' => $request->m_user_id ?? '',
            'description' => $request->description ?? '',
            'id' => $request->id ?? '',
        ];

        $project = $this->summaryHelper->getAll($filter, $request->page ?? 1, $request->perpage ?? 25, $request->sort ?? '');

        return response()->success(
            [
                'list' => SumaryResource::collection($project['data']['data']),
                'meta' => [
                    'total' => $project['data']['total'],
                ],
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $payload = $request->only(['m_user_id', 'description']);

        $project = $this->summaryHelper->create($payload);

        if(!$project['status']){
            return response()->failed($project['error'], 'gagal simpan data');
        }

        return response()->success(new SumaryResource($project['data'], 'data berhasil ditambahkan'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payload =  $request->only(['description', 'm_user_id']);

        $project = $this->summaryHelper->update($id, $payload);

        if(!$project['status']) {
            return response()->failed($project['error']);
        }

        return response()->success(new SumaryResource($project['data']['data']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
