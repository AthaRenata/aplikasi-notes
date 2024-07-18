<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search']);

        $data = Category::with(['notes' => function ($query) use ($filters) {
            $query->filter($filters);
        }])
                      ->where('user_id', $request->userCredential['id'])
                      ->filter($filters)
                      ->get();

        return $this->sendSuccess($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
        ]);

        if ($validator->fails()) {
            return $this->sendBadRequest($validator->messages());
        }

        Category::create([
            'name'=>$request->name,
            'user_id'=>$request->userCredential['id']
        ]);

        return $this->sendMessage("Kategori $request->name berhasil ditambahkan");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
        ]);

        if ($validator->fails()) {
            return $this->sendBadRequest($validator->messages());
        }

        $category->update([
            'name'=>$request->name,
        ]);

        return $this->sendMessage("Kategori $request->name berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->notes()->wherePivot('category', $category->id)->detach();
        $category->delete();

        return $this->sendMessage("Kategori $category->name berhasil dihapus");
    }
}
