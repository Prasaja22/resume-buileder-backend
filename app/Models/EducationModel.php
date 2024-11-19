<?php

namespace App\Models;

use App\Http\Traits\Uuid;
use App\Repository\CrudInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psy\CodeCleaner\ReturnTypePass;

class EducationModel extends Model implements CrudInterface
{

    use HasFactory;
    use SoftDeletes;
    use Uuid;


    protected $table = 'm_education';

    protected $fillable = [
        'm_user_id',
        'description',
    ];

    public function  getAll(array $filter, int $page = 1, int $itemPerPage = 0, string $sort = '')
    {
        $skip = ($page * $itemPerPage) - $itemPerPage;
        $education = $this->query();

        if (! empty($filter['description'])) {
            $education->where('description', 'LIKE', '%'.$filter['description'].'%');
        }

        if(! empty($filter['m_user_id'])) {
            $education->where('m_user_id', 'LIKE', '%'.$filter['m_user_id'].'%');
        }

        if (! empty($filter['id'])){
            $education->where('id', 'LIKE', '%'.$filter['id'].'%');
        }

        if (empty($sort)){
            $sort = 'id DESC';
        }

        $total = $education->count();
        $list = $education->skip($skip)->take($itemPerPage)->orderByRaw($sort)->get();

        return [
            'total' => $total,
            'data' => $list,
        ];

    }

    public function getById(string $id)
    {
        return $this->find($id);
    }

    public function store(array $payload)
    {
        return $this->create($payload);
    }

    public function edit(array $payload, string $id)
    {
        return $this->find($id)->update($payload);
    }

    public function drop(string $id)
    {
        return $this->find($id)->delete();
    }
}
