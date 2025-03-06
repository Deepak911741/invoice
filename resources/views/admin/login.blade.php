@extends(config('constants.ADMIN_FOLDER') . config('constants.GUEST_FOLDER_PATH') . 'login-header')

@section('pageTitle', $pageTitle)

@section('content')

<section class="" style="margin-top: 100px;">
  <div class="container">
    <div class="row d-flex justify-content-center align-items-center h-100">

      <div class="col-12 col-md-6 mb-4 mb-md-0">
        <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
          <div class="carousel-inner text-center">
            <div class="carousel-item active">
              <img src="{{ asset ('public/images/login-slide1.png')}}" class="d-block w-100 mx-auto" alt="Image 1" style="max-height: 400px; object-fit: contain;">
            </div>
            <div class="carousel-item">
              <img src="{{ asset ('public/images/login-slide2.png')}}" class="d-block w-100 mx-auto" alt="Image 2" style="max-height: 400px; object-fit: contain;">
            </div>
            <div class="carousel-item">
              <img src="{{ asset ('public/images/login-slide3.png')}}" class="d-block w-100 mx-auto" alt="Image 3" style="max-height: 400px;  object-fit: contain;">
            </div>
          </div>

        <?php  /* 
          <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>*/
          ?>

          <div class="carousel-indicators custom-indicators mt-5" style="margin-top: 60px;">
            <button type="button" data-bs-target="#imageCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#imageCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#imageCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
          </div>

        </div>
      </div>

      <div class="col-12 col-md-5">
        <div class="p-4">
          <img src="{{ asset ('public/images/Login.png')}}"
          alt="Login Imges"
          class="login-page-image">
            {!! Form::open(array( 'id '=> 'login-form' , 'method' => 'post' , 'url' =>  config('constants.LOGIN_SLUG') .  '/checkLogin' )) !!}
            <div class="form-outline  mb-4">
              <input type="email" id="login-email" name="login_email" class="form-control form-control-lg"
                placeholder="Email address" />
            </div>
            <div class="form-outline mb-3 position-relative">
              <input type="password" id="login-password" name="login_password" class="form-control form-control-lg"
                placeholder="Password" />
              <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y me-3 p-0"
                id="toggle-password" aria-label="Toggle password visibility">
                <i class="fas fa-eye-slash"></i>
              </button>
            </div>
            <div class="text-end">
              <a href="" class="forgot-password custom-forgot-password" title="{{ trans('messages.forgot-password') }}">
                {{ trans('messages.forgot-password') }}?
              </a>
            </div>
            <div class="form-outline mt-3">
              <button type="submit" class="sign-in-button w-100">{{ trans('messages.sign-in')}} <i class="fa-solid fa-arrow-right-to-bracket"></i></button>
            </div>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  $(document).ready(function() {
    $('#login-form').validate({
      errorClass: "invalid-input",
      rules: {
        login_email: {
          required: true,
          email:true,
        },
        login_password: {
          required: true,
        },
      },
      messages: {
        login_email: {
          required: '{{ trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.email-id") ]) }}',
        },
        login_password: {
          required: '{{ trans("messages.required-enter-field-validation" , [ "fieldName" => trans("messages.password") ]) }}',
        }
      },
      submitHandler:function(form){
        showLoader();
        form.submit();
      },
    });
  });
  document.getElementById('toggle-password').addEventListener('click', function() {
    const passwordField = document.getElementById('login-password');
    const icon = this.querySelector('i');

    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    } else {
      passwordField.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye-slash');
    }
  });
</script>

@endsection