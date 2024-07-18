<header class="z-0 w-100 navbar justify-content-between sticky-top bg-theme1 flex-md-nowrap p-0 shadow" data-bs-theme="dark">
<a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-5 text-white" href="/users">Aplikasi Notes</a>
<div>
<p class="navbar-nav d-none d-lg-inline text-white fs-6 px-3">Selamat Datang, {{Auth::user()->name}} | 
  <form action="/logout" method="POST" class="d-inline">
  @csrf
<button class="btn btn-danger d-inline m-1" onclick="return confirm('Yakin akan keluar dari aplikasi?')">Sign out</button>
</form>
</p>
</div>
<ul class="navbar-nav flex-row d-md-none">
  {{-- <li class="nav-item text-nowrap">
    <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search">
      <svg class="bi"><use xlink:href="#search"/></svg>
    </button>
  </li> --}}
  <li class="nav-item text-nowrap">
    <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <svg class="bi"><use xlink:href="#list"/></svg>
    </button>
  </li>
    <li class="nav-item">
      <span class="fs-6">
        {{Auth::user()->name}}
      </span>
    </li>
    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2 linkwborder" href="#">
        <i class="bi-door-closed"></i>
        <form action="/logout" method="POST">
          @csrf
      <button class="btn text-danger" onclick="return confirm('Yakin akan keluar dari aplikasi?')">Sign out</button>
      </form>
      </a>
    </li>
</ul>

{{-- <div id="navbarSearch" class="navbar-search w-100 collapse">
  <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
</div> --}}
</header>

<div class="container-fluid">
<div class="row">
  <main class="px-md-4 bg-theme4 vh-100">
    
      
    