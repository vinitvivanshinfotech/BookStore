<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{__('adminview.dashboardtitle')}}</title>
</head>

<body>
  <a class="btn" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
    <i class="bi bi-list"></i>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
    </svg>
  </a>

  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">{{__('adminview.siderbar_title')}}</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

      <div>
        <a type="button" class="btn btn-secondary mb-2" href="{{route('add.books')}}">{{__('adminview.siderbar_add_new_book')}}</a>
      </div>
      <div>
        <a type="button" class="btn btn-secondary mb-2" href="{{route('showAll.books')}}">{{__('adminview.siderbar_books_list')}}</a>
      </div>
      <div>
        <a type="button" class="btn btn-secondary mb-2" href="{{route('order.book')}}">{{__('adminview.siderbar_books_order')}}</a>
      </div>
      <div>
        <a type="button" class="btn btn-secondary mb-2">{{__('adminview.siderbar_categories')}}</a>
      </div>
      <div>
        <a type="button" class="btn btn-secondary mb-2" href="{{route('book.importBook')}}">{{__('adminview.siderbar_book_csv')}}</a>
      </div>
      <div>
        <a type="button" class="btn btn-secondary mb-2" href="{{route('admin.logout')}}">{{__('adminview.logout')}}</a>
      </div>
    </div>
  </div>
</body>

</html>