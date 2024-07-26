<?php 
namespace App\Repositories;

use App\Models\Category;
use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserRepository{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function save($data)
    {
       return $this->model::create($data);
    }

    public function update($data)
    {
        $user = $this->model::findOrFail($data['id']);

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->fill(Arr::except($data,['password']));
        $user->save();

        return $user;
    }

    public function updateIsActive($id)
    {
        $this->model::findOrFail($id)
        ->update(['is_active'=>1]);
    }

    public function readPaginate()
    {
        return $this->model::latest()->where('is_active',1)->paginate(10)->withQueryString();
    }

    public function readInactiveUser()
    {
        return $this->model::latest()->where('is_active',0)->paginate(10)->withQueryString();
    }

    public function readById($id)
    {
        return $this->model::find($id);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        $note_ids = $user->notes()->pluck('id');

        foreach ($note_ids as $note_id) {
            $note = Note::find($note_id);
            if ($note) {
                $note->categories()->detach();
            }
        }

        $user->notes()->delete();

        $user->categories()->delete();

        return $user->delete();
    }
}