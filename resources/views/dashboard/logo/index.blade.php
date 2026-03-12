@extends('dashboard.master')

@section('content')
<main class="page-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9 col-md-10">

                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">

                        <img
                            src="{{ asset('dashboard/assets/images/NM8PCvUixr5I9At_YBcbjaQ7f8bG4m8eW_buCKiL1DvqYQluFGp0HlA49jSpor1a8nTsjebOdk5n6yFQtET4eCh4AyIdIQgcPj6qwseRZGY.jpg') }}"
                            alt="Admin Dashboard"
                            class="img-fluid mb-4"
                            style="max-width: 600px;"
                        >

                        <h4 class="fw-bold mb-2">لوحة التحكم</h4>
                        <p class="text-muted mb-0">
                            إدارة المتجر، المستخدمين، الصلاحيات، والدفع من مكان واحد
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection
