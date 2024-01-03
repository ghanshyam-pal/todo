<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>--- TODO ---</title>

    <script src="{{asset('js/sweetalert2/sweetalert2.min.js')}}"></script>
    <link href="{{asset('js/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet">    

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/fontawesome.min.css">

    <style>
        .gradient-custom {
        /* fallback for old browsers */
        background: #6a11cb;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(135deg, #153677, #4e085f);
        }

    </style>
  </head>
  <body>

    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
              <div class="card bg-dark text-white" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">
                <form action="{{url('reg')}}" method="post" class="submit-form">
                  @csrf
                  <div class="mb-md-5 mt-md-4 pb-5">
      
                    <h2 class="fw-bold mb-2 text-uppercase">Register</h2>
                    <p class="text-white-50 mb-5">Please enter your Details!</p>
                    
                    <div class="form-outline form-white mb-4">
                      <input type="email" name="email"  class="form-control form-control-lg" placeholder="Enter Yor Email" />
                      {{-- <label class="form-label" for="typeEmailX">Email</label> --}}
                    </div>
      
                    <div class="form-outline form-white mb-4">
                      <input type="password" name="password"  class="form-control form-control-lg" placeholder="Enter Your Password" />
                      {{-- <label class="form-label" for="typePasswordX">Password</label> --}}
                    </div>

                    <div class="form-outline form-white mb-4">
                      <input type="password" name="confirm_password"  class="form-control form-control-lg" placeholder="Enter Your Password" />
                      {{-- <label class="form-label" for="typePasswordX">Password</label> --}}
                    </div>
      

                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Register</button>
      
      
                  </div>
                </form>
      
                  <div>
                    <p class="mb-0">Already have an account? <a href="{{url('/login')}}" class="text-white-50 fw-bold">Login</a>
                    </p>
                  </div>
      
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>



    <!-- TODO: Here goes your content! -->



    <!-- Including Bootstrap JS (with its jQuery dependency) so that dynamic components work -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="{{asset('js/app.js')}}" ></script>
  </body>
</html>