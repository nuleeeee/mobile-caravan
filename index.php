<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="author" content="Nols">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="head office asset transfer, maquiling builders depot asset transfer">
    <title>JABA | Mobile Caravan</title>

    <!-- Bootstrap 5.2 -->
    <link href="stylesheets/css/bootstrap.min.css" rel="stylesheet">
    <script src="stylesheets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="stylesheets/css/bootstrap-icons-1.10.5/font/bootstrap-icons.css">

    <!-- JQuery -->
    <script type="text/javascript" src="stylesheets/js/jquery-3.7.0.js"></script>

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="stylesheets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="stylesheets/css/font-awesome.min.css">
    <link rel="stylesheet" href="stylesheets/login.css">
    <link rel="icon" type="image/x-icon" href="assets/jaba.jpg">

    <!-- Alertify JS -->
    <link rel=" stylesheet" href="stylesheets/css/alertify.min.css" />
    <link rel="stylesheet" href="stylesheets/css/bootstrap.rtl.min.css" />

    </style>
</head>

<body>

    <!-- The Main Body -->
    
    <main class="form-signin w-100 m-auto">
        <div class="text-center">
            <div style="line-height: 30px;">
                <span class="text-jaba">JABA</span><br>
                <span class="text-mobile-caravan">Mobile Caravan</span>
            </div>
        </div>

        <div class="form-floating">
            <input type="password" class="form-control mt-3" id="pin" placeholder="Employee Pin" autocomplete="off" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="6" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'">
            <label for="pin">Employee Pin</label>
        </div>

        <div class="d-flex justify-content-center ">
            <button class="btn w-100 py-2 loginBtn" id="Login" onclick="login();">Log in</button>
        </div>
    </main>

    <!-- Alertify JS -->
    <script src="stylesheets/js/alertify.min.js"></script>

    <script>
        $("#pin").keyup(function(e) {
            if (e.keyCode == 13) {
                login();
            }
        });

        function login() {
            var login_pin = $("#pin").val();
            $.post("php/login.inc.php", {
                login_pin: login_pin
            }, function(result) {
                try {
                    if (result == 1) {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.error('Incorrect Pin Code').dismissOthers();

                    } else {
                        $(".loginBtn").removeClass("w-100").addClass("rounded-5");
                        $(".loginBtn").html("<span class='spinner-border spinner-border-sm'></span>");
                        setTimeout(function() {
                            data = JSON.parse(result);
                            localStorage.setItem("login_name", data.vname);
                            localStorage.setItem("alertShown", data.vname);
                            localStorage.setItem("branch", data.branch);
                            window.location.href = "home.php";
                        }, 1000);
                    }
                } catch {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error('Incorrect Pin Code').dismissOthers();
                }
            });
        }

        /* Clear Login Input Fields */
        const LogtinBtn = document.getElementById('Login');
        LogtinBtn.addEventListener('click', function() {
            event.preventDefault();
            const pinInput = document.getElementById('pin');

            pinInput.value = '';
        });

        $("#pin").keyup(function(e) {
            if ((27 === event.which) || (13 === event.which)) {
                event.preventDefault();
                //this should delete value from the input
                event.currentTarget.value = "";
            }
        })

    </script>


</body>

</html>