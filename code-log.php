<?php
/*
----------------------------
*** index page
** if you don't have a session will open
** if you have a session return for [ admin || *secoundry.php ]
----------------------------
*/
session_start();

// If he has a session
if (isset($_SESSION['phone']) && isset($_SESSION['id'])) {
    // If he is a student
    if ($_SESSION['state'] == '10'/*student*/) {
        // Go to your page
        if ($_SESSION['se'] == '1se') {
            $to_1 = 'location: 1secoundry.php?id=' . $_SESSION['id'];
            header($to_1);
            exit();
        } elseif ($_SESSION['se'] == '2se') {
            $to_2 = 'location: 2secoundry.php?id=' . $_SESSION['id'];
            header($to_2);
            exit();
        } elseif ($_SESSION['se'] == '3se') {
            $to_3 = 'location: 3secoundry.php?id=' . $_SESSION['id'];
            header($to_3);
            exit();
        } else {
            session_unset();
            session_destroy();
            header("location: code-log.php");
            exit();
        }
    }
    // If he is an admin
    elseif ($_SESSION['state'] == '11' /*admin*/) {
        header('location: mr.php');
        exit();
    }
}
// If you don't have a session
else {
    // Open the login page
    include_once 'init.php';
    include_once $connect;
    include_once $functions;
    include_once $db_prog;

    $title = 'المفيد فى الفزياء';
    include_once $header;
    ?>
    <form action="" method="post" class="log-form" onsubmit="makePostRequest(); return false;">
        <div class="back"></div>
        <h1 class="text-center t1">تسجيل االدخول</h1>
        <div class='log-div'>
            <h2 class="text-center ">المفيد فى الفزياء</h2>
            <img src="<?php echo $imges . 'tt.svg' ?>" class="img" alt="book and pin img">
            <div class="name-filed require">
                <div class="txt">كود الطالب</div>
                <input type="text" id="input1" class="input" name="code" placeholder="ادخل كود الطالب...">
                <i class="fa fa-phone icon-1"></i>
            </div>
            <div class="pass-field require">
                <div class="txt">الرمز السري</div>
                <input type="password" id="input2" class="input input-pass" name="password" placeholder="ادخل هنا الرمز السرى...">
                <span class="show-pass"><i class="fa fa-eye-slash"></i></span>
                <span class="hide-pass" style="display: none"><i class="fa fa-eye"></i></span>
                <i class="fa fa-lock icon-2"></i>
            </div>
            <br> 
            <button type="submit" name="log_code" class="btn btn-info btn-md">سجل <i class="fa fa-sign-in-alt"></i></button>
            <!-- <div class="sign-in-div text-center">
                <a href="sign-up.php" class="sign-up">عمل حساب جديد</a>
            </div>
            <div class="sign-in-div text-center">
                <a href="index.php" class="sign-up">لديك حساب</a>
            </div> -->
        </div>
    </form>

    <footer class="footer">
        <span class="my">BY => &hearts; <a href="https://5dmaty.com/">5dmaty</a></span>
        <span class="copy">all right are reserved &copy; 2023</span>
    </footer>

    <!-- <script>
        function makePostRequest() {
            var xhr = new XMLHttpRequest();

            var url = 'backend/request/codelog.php';
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');

            var code = document.getElementById('input1').value;
            var password = document.getElementById('input2').value;

            var data = {
                code: code,
                password: password
            };

            var jsonData = JSON.stringify(data);

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        console.log(xhr.responseText);
                        // Add any additional logic after a successful request
                    } else {
                        console.error('Error: ' + xhr.status);
                        // Handle errors here
                    }
                }
            };

            // Send the POST request with the JSON data as the request body
            xhr.send(jsonData);
        }
    </script> -->

    <?php
    include_once $footer;
}
?>
