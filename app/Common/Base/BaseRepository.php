<?php
// 공통DB처리의 기반
namespace App\Common\Base;

// import
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected Model $model;

    // 새로운 것을 작성
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }


    // id 찾기
    public function findById(int $id): ?Model
    {
        return $this->model->find($id);
    }


    // 삭제
    public function delete(int $id): bool
    {
        $item = $this->findById($id);
        if(!$item){
            return false;
        }
        return $item->delete();
    }
}