<x-layout>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Pengguna Aktif</h1>
        </div>

        <div class="d-flex justify-content-end mb-3">
          <div class="mx-3">
            <a href="{{route('users.inactive')}}" class="btn btn-success text-decoration-none"><i class="bi-check px-1"></i> Aktifkan Pengguna</button></a>
          </div>
            <a href="{{route('users.create')}}" class="btn btn-primary text-decoration-none"><i class="bi-plus-circle px-1"></i> Tambah Pengguna</button></a>
        </div>

        @if (session()->has('success'))
        <div class="alert alert-success w-100 mt-3 d-flex align-items-center justify-content-between" role="alert">
          <div>
            {!! session('success') !!}
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-info">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Peran</th>
                            <th>Aksi</th>
                            </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                            <tr>
                                <td>{{ $users->firstItem() + $loop->index}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{($user->role==1) ? "Admin" : "Pengguna"}}</td>
                                <td>
                                    <a href="{{route('users.edit',$user->id)}}" class="btn btn-warning"  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Ubah Data"><i class="bi-pencil"></i></a>
                                    @if ($user->id==1)
                                        Utama
                                    @else
                                    <form action="{{route('users.destroy',$user->id)}}" method="POST" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger" onclick="return confirm('Yakin akan hapus data ini?')"  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Hapus Data"><i class="bi-trash"></i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                  </table>
                  <div class="mt-4 d-flex justify-content-end">
                    {{$users->links()}}
                  </div>
            </div>
</x-layout>