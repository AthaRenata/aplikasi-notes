<?php 
namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function saveData($data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->repository->save($data);
    }

    public function updateData($data)
    { 
        return $this->repository->update($data);
    }

    public function updateIsActive($id)
    { 
        return $this->repository->updateIsActive($id);
    }

    public function getAll()
    {
        return $this->repository->readPaginate();
    }

    public function getAllInactive()
    {
        return $this->repository->readInactiveUser();
    }

    public function getById($id)
    {
        return $this->repository->readById($id);
    }

    public function deleteById($id)
    {   
        return $this->repository->delete($id);
    }
}