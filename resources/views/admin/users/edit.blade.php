<x-layout>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <a href="/users" class="text-body-secondary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Pengguna" ><i class="bi-people-fill fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Ubah Pengguna</h1>
        </div>
          
            <div class="mt-2 p-3 text-body-secondary">
                <form action="/users/{{$user->id}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    @if ($user->role==1)
                    <input type="hidden" name="role" value="1">
                    @else
                    <input type="hidden" name="role" value="2">
                    @endif
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Cth. Nama Lengkap" value="{{old('name',$user->name)}}" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                        </div>
                        <div class="mb-3">
                        <label for="phone" class="form-label">No HP</label>
                        <input type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Cth. 62811111" value="{{old('phone',$user->phone)}}" required>
                        @error('phone')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                        </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="******">
                        @error('password')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                        </div>
                    <div>
                        <button class="btn btn-success">Simpan</button>
                        </div>
                </form>
            </div>  
</x-layout>