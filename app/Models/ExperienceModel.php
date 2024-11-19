<?php

namespace App\Models;

use App\Http\Traits\Uuid;
use App\Repository\CrudInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExperienceModel extends Model implements CrudInterface
{

    use HasFactory;
    use SoftDeletes;
    use Uuid;
    //

    protected $table = 'm_experience';

    protected $fillable = [
        'm_user_id',
        'description',
    ];

    public function getAll(array $filter, int $page = 1, int $itemPerPage = 0, string $sort)
    {
        $skip = ($page * $itemPerPage) - $itemPerPage;
        $experience = $this->query();

        if (! empty($filter['description'])) {
            $experience->where('description', 'LIKE', '%'.$filter['description'].'%');
        }

        if(! empty($filter['m_user_id'])) {
            $experience->where('m_user_id', 'LIKE', '%'.$filter['m_user_id'].'%');
        }

        if(! empty($filter['id'])){
            $experience->where('id', 'LIKE', '%'.$filter['id'].'%');
        }

        if (empty($sort)){
            $sort = 'id DESC';
        }

        $total = $experience->count();
        $list = $experience->skip($skip)->take($itemPerPage)->orderByRaw($sort)->get();

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
