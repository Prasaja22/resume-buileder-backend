<?php

namespace App\Helpers\Experience;

use App\Helpers\Venturo;
use App\Models\ExperienceModel;
use Throwable;

class ExperienceHelper extends Venturo{

    private $experienceModel;

    public function __construct()
    {
        $this->experienceModel = new ExperienceModel();
    }


    public function getAll($filter,$page = 1 , $itemPerPage = 0, $sort = ''): array
    {

        $experience = $this->experienceModel->getAll($filter,$page,$itemPerPage,$sort);

        return [
            'status' => true,
            'data' => $experience,
        ];
    }

    public function getById($id): array
    {
        $experience = $this->experienceModel->getById($id);

        return [
            'status' => true,
            'data' => $experience,
        ];
    }

    public function create(array $payload): array
    {

        try
        {
            $experience = $this->experienceModel->create($payload);

            return [
                'status' => true,
                'data' => $experience,
            ];
        } catch (Throwable $th){
            return [
                'status' => false,
                'error' => $th->getMessage(),
            ];
        }

    }

    public function update(string $id, array $payload): array
    {
        try {

            $this->experienceModel->edit($payload, $id);

            $experience = $this->getById($id);

            return [
                'status' => true,
                'data' => $experience,
            ];
        } catch(Throwable $th){
            return [
                'status' => false,
                'errror' => $th->getMessage(),
            ];
        }
    }

    public function delete(string $id): bool
    {
        try{

            $this->experienceModel->delete($id);

            return true;

        } catch (Throwable $th){
            return false;
        }
    }

}

?>
