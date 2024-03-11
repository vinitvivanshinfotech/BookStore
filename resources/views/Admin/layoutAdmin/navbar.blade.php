<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{__('adminview.dashboardtitle')}}</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    @include('cdn')

    <div class="container-fluid">
      <a class="navbar-brand" href="#">{{__('adminview.navabar_title')}}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      </button>
      <div class="collapse navbar-collapse flex-grow-0" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          </form>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{route('admin.dashboard')}}">{{__('adminview.navabar_home')}}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="">{{__('adminview.navabar_gifting_orders')}}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="">{{__('adminview.navabar_categories')}}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="">{{__('adminview.navabar_ondemad')}}</a>
          </li>
          <li class="nav-item">
            <i class="bi bi-person"></i>
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="36" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
              <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
            </svg>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page">{{__('adminview.admin')}}</a>
            <ul></ul>
          </li>
          <div>
          <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href=""></a>
                        <a class="dropdown-item" href=""></a>
                    </div>
                </li>
            </ul>
        </div>
        </ul>
      </div>
    </div>
  </nav>
</body>

</html>