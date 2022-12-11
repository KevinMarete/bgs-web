<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content/>
    <meta name="author" content/>
    <title>Pharmahub | Sign-In</title>
    <link href="css/styles.css" rel="stylesheet"/>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <script data-search-pseudo-elements defer src="libs/ajax/libs/font-awesome/5.11.2/js/all.min.js"
            crossorigin="anonymous"></script>
    <script src="libs/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap"
        rel="stylesheet"/>
    <link
        href="https://fonts.googleapis.com/css?family=Libre+Franklin:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;display=swap"
        rel="stylesheet"/>
</head>

<body class="bg-primary-img">
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                @if (Session::has('bgs_msg'))
                    {!! session('bgs_msg') !!}
                @endif
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-body p-5 text-center">
                                <div class="sb-icons-org-create align-items-center mx-auto">
                                    <i class="sb-icon-users" data-feather="users"></i>
                                    <i class="sb-icon-plus fas fa-solid fa-lock"></i>
                                </div>
                                <div class="h3 text-primary font-weight-300 mb-0">Login</div>
                            </div>
                            <hr class="m-0" />
                            <div class="card-body">
                                <form action="/authenticate" method="POST">
                                    @csrf
                                    <div class="form-group"><label class="small mb-1"
                                                                   for="inputEmailAddress">Email</label><input
                                            class="form-control py-4" id="inputEmailAddress" type="email"
                                            placeholder="Enter email address" name="email" required/></div>
                                    <div class="form-group"><label class="small mb-1"
                                                                   for="inputPassword">Password</label><input
                                            class="form-control py-4" id="inputPassword" type="password"
                                            placeholder="Enter password" name="password" required/></div>
                                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <a class="small" href="/forgot-password">Forgot Password?</a>
                                        <button class="btn btn-primary" type="submit">Login</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center">
                                <div class="small"><a href="/registration">Need an account? Sign up!</a></div>
                                <div class="small"><a href="/">Go to Main Page</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div id="layoutAuthentication_footer">
        <footer class="sb-footer py-4 mt-auto sb-footer-dark">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div>Copyright &copy; Pharmahub {{date('Y')}}</div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="libs/jquery/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="libs/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="libs/jplist/1.2.0/jplist.min.js"></script>
<script src="/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="/libs/multidatespicker/jquery-ui.multidatespicker.js"></script>
<script src="/libs/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
<script src="/libs/daterangepicker/js/moment.min.js"></script>
<script src="/libs/daterangepicker/js/daterangepicker.js"></script>
<script src="/libs/select2/js/select2.min.js"></script>
<script src="/libs/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>

<!--
      <script src="js/sb-customizer.js"></script>
      <sb-customizer project="sb-admin-pro"></sb-customizer>
      -->
</body>

</html>
