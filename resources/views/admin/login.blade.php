@include('layouts.adminlayout.header')
<body style="background:#F7F7F7;">    
    <div class="">
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper">
            <div id="login" class="animate form">
                <section class="login_content">
                    <form action="{{ url('admin') }}" method="post">{{ csrf_field() }}
                        <h1>Admin Login</h1>
                        @if(Session::has('flash_message_success'))
                        <div class="alert alert-success">{!! session('flash_message_success') !!}</div>
                        @endif
                        <div class="clear"></div>
                        @if(Session::has('flash_message_error'))
                        <div class="alert alert-danger">{!! session('flash_message_error') !!}</div>
                        @endif
                        <div>
                            <input type="text" name="email" class="form-control" placeholder="Email" required="" />
                        </div>
                        <div>
                            <input type="password" name="password" class="form-control" placeholder="Password" required="" />
                        </div>
                        <div>
                            <input type="submit" class="btn btn-default submit" value="Login">
                            <a class="change_link" href="{{ url('/password/reset') }}">Forgot your password?</a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">
                            <div class="clearfix"></div>
                            <br />
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>
</html>