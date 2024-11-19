<?php

namespace App\Helpers\Education;

use App\Helpers\Venturo;
use App\Models\EducationModel;
use Illuminate\Support\Arr;
use Throwable;

class EducationHelper  extends Venturo
{

    private $educationModel;

    public function __construct()
    {
        $this->educationModel = new  EducationModel();
    }


    public function getAll($filter,$page = 1 , $itemPerPage = 0, $sort = ''): array
    {
        $education = $this->educationModel->getAll($filter, $page, $itemPerPage, $sort);

        return [
            'status' => true,
            'data' => $education,
        ];
    }

    public function store(array $payload): array
    {
        try {
            $education = $this->educationModel->store($payload);

            return [
                'status' => true,
                'data' => $education,
            ];
        } catch(Throwable $th){
            return [
                'status' => false,
                'error' => $th->getMessage(),
            ];
        }
    }

    public function getById(String $id): array
    {
        try {
            $education = $this->educationModel->getById($id);

            return [
                'status' => true,
                'data' => $education,
            ];

        } catch (Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage(),
            ];
        }

    }

    public function update(array $payload, string $id): array
    {
        try {
            $this->educationModel->edit($payload, $id);

            $education = $this->getById($id);

            return [
                'status' => true,
                'data' => $education,
            ];

        } catch (Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage(),
            ];
        }

    }
}

?>
