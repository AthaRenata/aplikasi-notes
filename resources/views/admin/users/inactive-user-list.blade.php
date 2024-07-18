<x-layout>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-2 mb-3 border-bottom">
        <div >
        <a href="{{route('users.index')}}" class="text-body-secondary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Pengguna" ><i class="bi-people-fill fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        <h1 class="h2 d-inline">Data Registrasi Pengguna</h1>
        </div>
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
                                    <form action="{{route('users.activate',$user->id)}}" method="POST" class="d-inline">
                                        @method('patch')
                                        @csrf
                                        <button class="btn btn-success" onclick="return confirm('Yakin akan mengaktifkan pengguna ini?')"  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Aktifkan"><i class="bi-check"></i></button>
                                    </form>
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