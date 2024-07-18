<?php

namespace App\Http\Controllers\Api;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NoteController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['category', 'favorite', 'search']);

        $data = Note::with(['categories' => function ($query) use ($filters) {
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
            'photo'=>'nullable|image',
            'title'=>'required',
            'content'=>'required',
            'categories.*'=>'nullable'
        ]);

        if ($validator->fails()) {
            return $this->sendBadRequest($validator->messages());
        }

        if($request->photo == null){
            $notes = Note::create([
                'title'=>$request->title,
                'content'=>$request->content,
                'user_id'=>$request->userCredential['id']
            ]);

        }else{
            $upload = Storage::put('image',$request->photo);
            $photo = "storage/{$upload}";

            $notes = Note::create([
                'photo'=>$photo,
                'title'=>$request->title,
                'content'=>$request->content,
                'user_id'=>$request->userCredential['id']
            ]);
        }

        foreach ($request->categories as $category) {
            $notes->categories()->attach($category);
        }

            return $this->sendMessage("Catatan baru berhasil ditambahkan");
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note, Request $request)
    {
        $data = Note::with('categories')
                      ->where('user_id', $request->userCredential['id'])
                      ->where('id', $note->id)
                      ->get();

        return $this->sendSuccess($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        $validator = Validator::make($request->all(),[
            'photo'=>'nullable|image',
            'title'=>'required',
            'content'=>'required',
            'categories.*'=>'nullable'
        ]);

        if ($validator->fails()) {
            return $this->sendBadRequest($validator->messages());
        }

        if($request->photo == null){
            $note->update([
                'title'=>$request->title,
                'content'=>$request->content
            ]);

        }else{
            $dataunlink = Note::find($note->id)->photo;
            if ($dataunlink != null) {
                $unlinkimg = substr($dataunlink,strpos($dataunlink,'/')+1);
                Storage::delete($unlinkimg);
            }
            $upload = Storage::put('image',$request->photo);
            $photo = "storage/{$upload}";

            $note->update([
                'title'=>$request->title,
                'content'=>$request->content,
                'photo'=>$photo
            ]);
        }

            $note->categories()->sync($request->categories);

            return $this->sendMessage("Catatan berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $dataunlink = Note::find($note->id)->photo;
        if ($dataunlink != null) {
            $unlinkimg = substr($dataunlink,strpos($dataunlink,'/')+1);
            Storage::delete($unlinkimg);
        }

        $note->categories()->wherePivot('note', $note->id)->detach();
        $note->delete();

        return $this->sendMessage('Catatan berhasil dihapus');
    }

    public function favorite(Note $note){
        $note->update([
            'is_favorite' => $note->is_favorite ? 0 : 1,
        ]);

        if ($note->is_favorite) {
            return $this->sendMessage('Catatan berhasil ditambahkan ke favorit');
        }else{
            return $this->sendMessage('Catatan berhasil dihapus dari favorit');
        }
    }
}
