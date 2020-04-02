<!DOCTYPE html>
<html lang="en">
    
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content />
        <meta name="author" content />
        <title>BGS | Create Organization</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
        <script data-search-pseudo-elements defer src="libs/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="libs/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Libre+Franklin:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;display=swap" rel="stylesheet" />
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <!-- Create Organization-->
                            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
                                <div class="card mt-5">
                                    <div class="card-body p-5 text-center">
                                        <div class="sb-icons-org-create align-items-center mx-auto"><i class="sb-icon-users" data-feather="users"></i><i class="sb-icon-plus fas fa-plus"></i></div>
                                        <div class="h3 text-primary font-weight-300 mb-0">Create an Organization</div>
                                    </div>
                                    <hr class="m-0" />
                                    <div class="card-body p-5">
                                        <form action="/add-organization" method="POST">
                                            @csrf
                                            <div class="form-group"><input class="form-control form-control-solid" type="text" placeholder="Enter new organization name" aria-label="Organization Name" aria-describedby="orgNameExample" name="name" required/></div>
                                            <div class="form-group"><input class="form-control form-control-solid" type="text" placeholder="Enter organization town" aria-label="Organization Town" aria-describedby="orgTownExample" name="town" required/></div>
                                            <div class="form-group"><input class="form-control form-control-solid" type="text" placeholder="Enter organization street/road" aria-label="Organization Street/Road" aria-describedby="orgRoadExample" name="road" required/></div>
                                            <div class="form-group"><input class="form-control form-control-solid" type="text" placeholder="Enter organization building" aria-label="Organization Building" aria-describedby="orgBuildingExample" name="building" required/></div>
                                            <div class="form-group">
                                                <select class="form-control form-control-solid" aria-label="Type of Organization" aria-describedby="orgTypeExample" name="organization_type_id" required>
                                                    <option value="">Type of Organization</option>
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button class="btn btn-block btn-primary" type="submit">Create organization</button>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="/registration">Have an organization? Go to Registration</a></div>
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
                            <div>Copyright &copy; BGS {{date('Y')}}</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="libs/jquery/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="libs/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="/js/isotope.pkgd.min.js"></script>
        <script src="/js/pagify.js"></script>
        <script src="js/scripts.js"></script>

        <!--
        <script src="js/sb-customizer.js"></script>
        <sb-customizer project="sb-admin-pro"></sb-customizer>
        -->
    </body>

</html>
