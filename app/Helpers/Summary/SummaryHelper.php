<?php

namespace App\Helpers\Summary;

use App\Helpers\Venturo;
use App\Models\SummaryModel;
use Throwable;

class SummaryHelper extends Venturo
{
    private $sumaryModel;


    public function __construct()
    {
        $this->sumaryModel = new SummaryModel();
    }


    public function getAll($filter,$page = 1 , $itemPerPage = 0, $sort = ''): array
    {
        $summary = $this->sumaryModel->getAll($filter, $page, $itemPerPage, $sort);

        return [
            'status' => true,
            'data' => $summary
        ];
    }

    public function getByid($id): array
    {
        try {
            $summary = $this->sumaryModel->getById($id);

            return [
                'status' => true,
                'data' => $summary
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

            $summary = $this->sumaryModel->store($payload);

            return [
                'status' => true,
                'data' => $summary,
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

            $this->sumaryModel->edit($payload, $id);

            $summary = $this->getByid($id);

            return [
                'status' => true,
                'data' => $summary,
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
            $this->sumaryModel->delete($id);
            return true;
        } catch (Throwable $th){
            return false;
        }
    }

}

?>
