<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{__('adminview.dashboardtitle')}}</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
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
            <a class="nav-link active" aria-current="page" href="">{{__('adminview.navabar_home')}}</a>
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
        </ul>
      </div>
    </div>
  </nav>
</body>

</html>
