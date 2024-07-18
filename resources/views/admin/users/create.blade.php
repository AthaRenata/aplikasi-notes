<x-layout>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <a href="/users" class="text-body-secondary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Pengguna" ><i class="bi-people-fill fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Tambah Pengguna</h1>
        </div>

                <div class="mt-2 p-3 text-body-secondary">
                    <form action="/users" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Cth. Nama Lengkap" value="{{old('name')}}" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                          </div>
                          <div class="mb-3">
                            <label for="phone" class="form-label">No HP</label>
                            <input type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Cth. 6281111" value="{{old('phone')}}" required>
                            @error('phone')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                          </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="******" required>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                          </div>
                          <div class="mb-3">
                            <label for="role" class="form-label">Peran</label>
                            <select name="role" id="role" class="form-select  @error('role') is-invalid @enderror" required>
                                    <option value="1">Admin</option>
                                    <option value="2">Pengguna</option>
                            </select>
                            @error('role')
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