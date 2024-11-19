<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Experience\ExperienceHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExperienceResource;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    private $experienceHelper;

    public function __construct()
    {
       $this->experienceHelper = new ExperienceHelper();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = [
            'id' => $request->id ?? '',
            'm_user_id' => $request->m_user_id ?? '',
            'description' => $request->description ?? '',
        ];


        $experience = $this->experienceHelper->getAll($filter, $request->page ?? 1, $request->per_page ?? 25, $request->sort ?? '');

        return response()->success([
            'list' =>  ExperienceResource::collection($experience['data']['data']),
            'meta' => [
                'total' => $experience['data']['total'],
            ]
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }


        $payload = $request->only(['m_user_id', 'description']);
        $experience = $this->experienceHelper->create($payload);

        if (! $experience['status']) {
            return response()->failed($experience['error']);
        }

        return response()->success(new ExperienceResource($experience['data'], 'data berhasil ditambahkan'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $experience = $this->experienceHelper->getById($id);

        if (! ($experience['status'])) {
            return response()->failed(['Data role tidak ditemukan'], 404);
        }

        return response()->success(new ExperienceResource($experience['data']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload = $request->only(['description', 'm_user_id']);

        // dd($payload);

        $experience = $this->experienceHelper->update($id, $payload);

        if(!$experience['status']){
            return response()->failed($experience['error']);
        }

        // dd($experience['data']['data']);

        return response()->success(new ExperienceResource($experience['data']['data']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $experience =  $this->experienceHelper->delete($id);

        if(!$experience['status']){
            return response()->failed($experience['error'], 'gagal menghapusd data');
        }

        return response()->success($experience, 'berhasil haspus data');
    }
}
