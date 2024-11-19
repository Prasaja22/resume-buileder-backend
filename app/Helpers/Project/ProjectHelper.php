<?php
namespace App\Helpers\Project;

use App\Helpers\Venturo;
use App\Models\ProjectModel;
use Throwable;

class ProjectHelper extends Venturo
{

    private $projectModel;

    public function __construct()
    {
        $this->projectModel = new ProjectModel();
    }


    public function getAll($filter,$page = 1 , $itemPerPage = 0, $sort = ''): array
    {
        $project = $this->projectModel->getAll($filter, $page, $itemPerPage, $sort);

        return [
            'status' => true,
            'data' => $project
        ];
    }

    public function getByid($id): array
    {
        try {
            $project = $this->projectModel->getById($id);

            return [
                'status' => true,
                'data' => $project
            ];
        } catch (Throwable $th){
            return [
                'status' => false,
                'error' => $th->getMessage(),
            ];
        }
    }

    public function create(array $payload) : array
    {
        try {

            $project = $this->projectModel->store($payload);

            return [
                'status' => true,
                'data' => $project,
            ];

        } catch (Throwable $th){
            return [
                'status' => false,
                'error' => $th->getMessage(),
            ];
        }
    }

    public function update(string $id ,array $payload) : array
    {
        try {

            $this->projectModel->edit($payload, $id);

            $project = $this->getByid($id);

            return [
                'status' => true,
                'data' => $project,
            ];

        } catch (Throwable $th){
            return [
                'status' => false,
                'error' => $th->getMessage(),
            ];
        }
    }

    public function delete(string $id): bool
    {
        try {
            $this->projectModel->delete($id);
            return true;
        } catch (Throwable $th){
            return false;
        }
    }

}

?>
