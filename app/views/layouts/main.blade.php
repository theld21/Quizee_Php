<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZee</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="<?= BASE_URL ?>public\css\app.css">
</head>

<body>
    <?php if (isset($header)):?>
    <div class="header-dark">
        <nav class="navbar navbar-dark navbar-expand-md navigation-clean-search">
            <div class="container-fluid px-5"><a class="navbar-brand" href="<?= BASE_URL ?>mon-hoc"><i class="fas fa-feather-alt"></i>QUIZee</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle
                        navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <form class="form-inline mr-auto" target="_self">
                        <div class="form-group"><label for="search-field"><i class="fa fa-search"></i></label>
                        </div>
                    </form>
                    <?php if (isset($_SESSION['user'])) { ?>
                        <span class="navbar-text"><a href="<?= BASE_URL ?>dang-xuat" class="login">Logout <i class="fas fa-sign-out-alt"></i></a></span>
                    <?php } else { ?>
                        <span class="navbar-text"><a href="<?= BASE_URL ?>dang-nhap" class="login">Log In</a></span>
                        <a class="btn btn-light action-button" role="button" href="<?= BASE_URL ?>dang-ky">Sign Up</a>
                    <?php } ?>
                </div>
            </div>
        </nav>
    </div>
    <?php endif?>

    <div class="container-fluid px-5">
        @yield('main-content')
    </div>

    
    <div class="modal" id="toast-notifications" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="modalForm">
                        <div class="form-group text-center">
                            <i id="icon-toast" class="fas" style="font-size: 45px"></i>
                            <p style="font-size: 22px;margin: 8px 0;"></p>
                        </div>
                        <div class="text-center">
                            <button class="text-right btn btn-primary" data-dismiss="modal" id="submit-btn">?????ng ??</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        showAlert = (content, type='success')=>{
                console.log(type);
            if (type=='success') {
                $("#icon-toast").removeClass("fa-exclamation-triangle").addClass("fa-check-circle").css('color', 'rgb(40, 214, 49)')
            } else {
                $("#icon-toast").removeClass("fa-check-circle").addClass("fa-exclamation-triangle").css('color', 'rgb(235, 52, 52)')
            }
            $('#toast-notifications p').text(content)
            $('#toast-notifications').modal('toggle')
        }
    </script>

    @yield('main-script')
    @yield('modal-script')
</body>
</html>
