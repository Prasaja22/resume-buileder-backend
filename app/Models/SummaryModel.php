<?php

namespace App\Models;

use App\Http\Traits\Uuid;
use App\Repository\CrudInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SummaryModel extends Model implements  CrudInterface
{

    use HasFactory;
    use SoftDeletes;
    use Uuid;

    protected $table = 'm_summary';

    protected $fillable = [
        'm_user_id',
        'description',
    ];

    public function getAll(array $filter, int $page, int $itemPerPage, string $sort)
    {

        $skip = ($page * $itemPerPage) - $itemPerPage;
        $summary = $this->query();

        if (! empty($filter['description'])) {
            $summary->where('description', 'LIKE', '%'.$filter['description'].'%');
        }

        if(! empty($filter['m_user_id'])) {
            $summary->where('m_user_id', 'LIKE', '%'.$filter['m_user_id'].'%');
        }

        if (! empty($filter['id'])){
            $summary->where('id', 'LIKE', '%'.$filter['id'].'%');
        }

        if (empty($sort)){
            $sort = 'id DESC';
        }

        $total = $summary->count();
        $list = $summary->skip($skip)->take($itemPerPage)->orderByRaw($sort)->get();

        return [
            'total' => $total,
            'data' => $list,
        ];

    }

    public function store(array $payload)
    {
        return $this->create($payload);
    }

    public function getById(string $id)
    {
        return $this->find($id);
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
