<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ url('storage/'.setting('site.logo') )}}" sizes="16x16" type="image/png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{url('/css/fonts.css')}}">
    <link rel="stylesheet" href="{{url('/css/all.min.css')}}">
    <link rel="stylesheet" href="{{url('/css/lib/animate.css')}}">
    <link rel="stylesheet" href="{{url('css/lib/jquery.toast.min.css')}}" />
    <link rel="stylesheet" href="{{url('css/lib/select2/select2.min.css')}}" />
    <link rel="stylesheet" href="{{url('/css/app.css')}}">
    @stack('styles')

    <title>{{ setting('site.title')}}</title>
  </head>
  <body>
    <div class="site-wrppaer">
        @include('components.navigation')
        <div class="site-content">
            @yield('content')
        </div>
        <section class="site-footer py-2 bg-white text-center shadow-lg text-dark">{!! setting('site.footer') !!}</section>
    </div>
    @if(!Auth::check())
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content border-0">
                    <div class="modal-body bg-light rounded">
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="login-wrapper">
                                    <div class="text-center">
                                        <img class="mb-5" src="{{ url('storage/'.setting('site.logo') )}}" alt="{{ setting('site.title')}}"/>
                                        <h4>Indian journal of photography</h4>
                                        <div class="sub-title mb-3">By Indians, for Indians</div>
                                    </div>
                                    <form class="login-form" autocomplete="nope" action="/login" method="POST">
                                        {{ csrf_field() }}
                                        <div class="border mb-3 bg-white">
                                            <div class="form-group m-0">
                                                <div class="input-group border-bottom">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-transparent border-0 color-secondary" id="inputGroup-sizing-default"><i class="fas fa-envelope"></i></span>
                                                    </div>
                                                    <input type="email" name="username" class="form-control border-0" placeholder="Email" autocomplete="nope" value="" required>
                                                </div>
                                            </div>
                                            <div class="form-group m-0">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-transparent border-0 color-secondary" id="inputGroup-sizing-default"><i class="fas fa-key"></i></span>
                                                    </div>
                                                    <input type="password" name="password" class="form-control border-0" placeholder="Password" autocomplete="nope" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2 message"></div>
                                        <button type="submit" class="btn btn-primary btn-block mb-3">Login</button>
                                        <div class="other-options">
                                            <div class="border-bottom"></div>
                                            <div class="text">OR</div>
                                        </div>
                                        <a href="/redirect/google" class="btn btn-primary btn-block mb-3 google"><i class="fab fa-google mr-2"></i> Continue with Google</a>
                                        <a href="/redirect/facebook" class="btn btn-primary btn-block mb-3 facebook"><i class="fab fa-facebook-square mr-2"></i> Continue with Facebook</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content border-0">
                    <div class="modal-body bg-light rounded">
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="register-wrapper">
                                    <div class="text-center">
                                        <img class="mb-5" src="{{ url('storage/'.setting('site.logo') )}}" alt="{{ setting('site.title')}}"/>
                                        <h4>Indian journal of photography</h4>
                                        <div class="sub-title mb-3">By Indians, for Indians</div>
                                    </div>
                                    <form class="register-form" autocomplete="nope" action="/register" method="POST">
                                        {{ csrf_field() }}
                                        <div class="border mb-3 bg-white">
                                            <div class="form-group m-0">
                                                <div class="input-group border-bottom">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-transparent border-0 color-secondary" id="inputGroup-sizing-default"><i class="fas fa-user"></i></span>
                                                    </div>
                                                    <input type="text" name="name" class="form-control border-0" placeholder="Full Name" autocomplete="nope" value="" required>
                                                </div>
                                            </div>
                                            <div class="form-group m-0">
                                                <div class="input-group border-bottom">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-transparent border-0 color-secondary" id="inputGroup-sizing-default"><i class="fas fa-envelope"></i></span>
                                                    </div>
                                                    <input type="email" name="username" class="form-control border-0" placeholder="Email" autocomplete="nope" value="" required>
                                                </div>
                                            </div>
                                            <div class="form-group m-0">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-transparent border-0 color-secondary" id="inputGroup-sizing-default"><i class="fas fa-key"></i></span>
                                                    </div>
                                                    <input type="password" name="password" class="form-control border-0" placeholder="Password" autocomplete="nope" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="message"></div>
                                        <button type="submit" class="btn btn-primary btn-block mb-3">Register</button>
                                        <div class="other-options">
                                            <div class="border-bottom"></div>
                                            <div class="text">OR</div>
                                        </div>
                                        <a href="/redirect/google" class="btn btn-primary btn-block mb-3 google"><i class="fab fa-google mr-2"></i> Continue with Google</a>
                                        <a href="/redirect/facebook" class="btn btn-primary btn-block mb-3 facebook"><i class="fab fa-facebook-square mr-2"></i> Continue with Facebook</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- <div class="modal fade" id="new-post-old" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg rounded post-details" role="document">
                <div class="modal-content border-0">
                            <div class="modal-body rounded">
                                <form class="new-post" action="/addPost" method="POST" enctype="multipart/form-data">
                                         {{ csrf_field() }}
                                        <div class="site-badge gray mb-3">Submission #{{count($posts) + 1}}</div>
                                            <input type="text" name="title" class="title" placeholder="Title" required>
                                            
                                            <textarea class="subject" name="excerpt" placeholder="Subject" rows="3" required></textarea>

                                            <div class="featured-image-upload">
                                                <div class="icon">
                                                    <i class="fas fa-camera"></i>
                                                </div>
                                                <div class="text">Drop your photo</div>
                                            </div>
                                            
                                            <input type="file" name="image" class="featured-image" accept="image/*" required />

                                            <textarea class="body-content" name="body" placeholder="Wanna describe more?" rows="3" required></textarea>
                                </from>
                            </div>
                            <div class="modal-footer text-right bg-light">
                                <small class="mr-2 body-content-count">0/500</small>
                                <button class="btn btn-primary">Submit for peer review</button>
                            </div>
                </div>
            </div>
        </div> --}}
        <div class="modal fade" id="new-post" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg rounded post-details" role="document">
                <div class="modal-content border-0">
                    <div class="modal-body rounded">
                        <form class="new-post" action="/addPost" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" value="0" name="is_draft" />
                            <input type="hidden" value="" name="post_id" />
                            <h5 class="text-primary">Personal Information</h5>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{Auth::user()->name}}" disabled />
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="text" name="email" class="form-control" value="{{Auth::user()->email}}" disabled />
                            </div>
                            <hr />
                            <h5 class="text-primary">About the Photo</h5>
                            <div class="form-group">
                                <label>Article Type</label>
                                <div class="row">
                                    @foreach ($categories as $category)
                                        <div class="col-sm-4">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="category-{{$category['id']}}" name="category" class="custom-control-input" value="{{$category['id']}}" required>
                                                <label class="custom-control-label text-body" for="category-{{$category['id']}}">{{$category['name']}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Article Title</label>
                                <input type="text" name="title" class="form-control" placeholder="" required/>
                            </div>
                            <div class="form-group">
                                <label>Article Keywords</label>
                                <select name="keywords[]" class="form-control select2" data-tags="true" multiple="multiple" data-token-separators="[',']" name="keywords" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Article Description</label>
                                <textarea class="form-control tinyMCE" id="mytextarea" name="description" required></textarea>
                                <small class="form-text text-muted">Maximum 300 words only allowed!</small>
                            </div>
                            <div class="form-group">
                                <label>Upload Your Photo</label>
                                <div class="preview"></div>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image" aria-describedby="inputGroupFileAddon01" accept="image/*" required>
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <h5 class="text-primary">Terms and Conditions</h5>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. <a href="#">Read More...</a></p>
                            <hr />
                            <h5 class="text-primary">Declaration</h5>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="confirm_author" required>
                                    <label class="custom-control-label" for="customCheck1">I confirm that I am the author of photo.</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck2" name="not_published_ijp" required>
                                    <label class="custom-control-label" for="customCheck2">I confirm that this photo is not published by other journal as well as by IJP.</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer text-right bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary draft">Save as Draft</button>
                        <button class="btn btn-primary submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="{{url('js/lib/jquery-3.4.1.js')}}" ></script>
    <script src="{{url('js/lib/popper.min.js')}}" ></script>
    <script src="{{url('js/lib/bootstrap.min.js')}}" ></script>
    <script src="{{url('js/lib/jquery.toast.min.js')}}"></script>
    <script src="{{url('js/lib/select2/select2.full.min.js')}}"></script>
    <script src="https://cdn.tiny.cloud/1/ggcddu7bj27dpcsxm3cwuns5nyvvgnzctq7l3jt6hk2dxp2j/tinymce/5/tinymce.min.js"></script>
    <script src="{{url('js/lib/jquery.validate.js')}}"></script>
    <script src="{{url('js/lib/additional-methods.js')}}"></script>
    <script src="{{url('js/lib/moment.js')}}"></script>
    <script>
      window.url = (url='') => `{{url('/')}}${(url[0] != '/' ? '/' : '') + url}`;
      window.storage = (url='') => `{{url('/storage')}}${(url[0] != '/' ? '/' : '') + url}`;
      window._token = '{{csrf_token()}}';
      @if(Session::has('toast'))
          @php $toast = Session::get('toast'); @endphp
            let bg = {
                error:'#dc3545',
                info:'#ffffff',
                success: '#28a745'
            };
            let text = {
                error:'#fffff',
                info:'#000000',
                success: '#fffff'
            };
            $.toast({
                heading: '{{ $toast['message'] }}',
                position: 'top-center',
                stack: false,
                bgColor: bg['{{ $toast['type'] }}'] || '',
                textColor: text['{{ $toast['type'] }}'] || '',
                hideAfter: false
            })
      @endif
    </script>
    <script src="{{url('js/script.js')}}"></script>
    <script src="{{url('js/site/add-post.js')}}"></script>
    @stack('scripts')

  </body>
</html>