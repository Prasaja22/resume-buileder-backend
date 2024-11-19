<?php

namespace App\Models;

use App\Http\Traits\Uuid;
use App\Repository\CrudInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectModel extends Model implements CrudInterface
{

    use HasFactory;
    use SoftDeletes;
    use Uuid;

    protected $table = 'm_project';

    protected $fillable = [
        'm_user_id',
        'description',
    ];

    public function getAll(array $filter, int $page, int $itemPerPage, string $sort)
    {

        $skip = ($page * $itemPerPage) - $itemPerPage;
        $project = $this->query();

        if (! empty($filter['description'])) {
            $project->where('description', 'LIKE', '%'.$filter['description'].'%');
        }

        if(! empty($filter['m_user_id'])) {
            $project->where('m_user_id', 'LIKE', '%'.$filter['m_user_id'].'%');
        }

        if (! empty($filter['id'])){
            $project->where('id', 'LIKE', '%'.$filter['id'].'%');
        }

        if (empty($sort)){
            $sort = 'id DESC';
        }

        $total = $project->count();
        $list = $project->skip($skip)->take($itemPerPage)->orderByRaw($sort)->get();

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
        return $this->find()->delete();
    }

}
