@extends(config('constants.ADMIN_FOLDER') . 'includes/header')

@section('content')
<main class="page-height bg-light-color add-user-section">
    <div class="breadcrumb-wrapper d-lg-flex p-3 border-bottom">
        <h1 class="h3 mb-lg-0 me-3 header-title" id="pageTitle">{{ $pageTitle }}</h1>
        <nav aria-label="breadcrumb" class="d-flex me-3">
            <ol class="breadcrumb bg-transparent p-0 mb-0 align-self-end">
                <li class="breadcrumb-item"><a href="{{ config('constants.USERS_URL') }}" class="category-add-link">{{ trans("messages.users") }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
            </ol>
        </nav>
    </div>
</main>

@endsection