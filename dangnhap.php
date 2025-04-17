<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="assets/css/dangkyy.css">
    <link rel="stylesheet" href="assets/css/popup.css">
    <link rel="stylesheet" href="assets/css/mat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
   
<div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <h2></h2>
        <p></p>
        <button onclick="closePopup()">Ok</button>
    </div>
    <div class="container">
        <div class="columns">
            <div class="register-form">
            <p><a href="index.php">Quay lại trang chủ</a></p>
                <h2>Đăng nhập</h2>
                <form class="my-form" id="loginform" action="./api/api.php" method="post"> 
                <input type="hidden" name="action" value="login">
                  
                    <input type="text" id="email" name="email" placeholder="Email/Số điện thoại" required>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Mật khẩu">
                        <i class="far fa-eye" id="eye" onclick="togglePasswordVisibility('password', 'eye')"></i>
                    </div>
                    <input type="text" id="login_type" name="login_type" placeholder="" hidden>
                    
                    <!-- <div class="h-captcha" data-sitekey="7cc22840-c9f4-49f0-942c-f3f0e9ce8f08"></div> -->
                    <button type="submit" onclick="showlogio()">Đăng nhập</button>
                    <?php
include_once("./api/connect.php");
// Đường dẫn đến file log_helper.php
function log_action($conn, $user_id, $action_type, $description,$usertype) {
    $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, action_type, description,user_type) VALUES (?, ?, ?,?)");
    $stmt->bind_param("isss", $user_id, $action_type, $description,$usertype);
    $stmt->execute();
}

if (isset($_GET['state'])) {
if (isset($_GET['state']) && $_GET['state'] == 'google' && isset($_GET['code'])) {
    $client_id = "340284496362-lhog2q4dt6ajs68oc6rcsf5nka48d89n.apps.googleusercontent.com";
    $client_secret = "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";
    $redirect_uri = "http://localhost/tour/dangnhap.php";

    // Gửi request lấy access token
    $token_url = "https://oauth2.googleapis.com/token";
    $post_data = [
        "code" => $_GET['code'],
        "client_id" => $client_id,
        "client_secret" => $client_secret,
        "redirect_uri" => $redirect_uri,
        "grant_type" => "authorization_code"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $token_data = json_decode($response, true);
    if (!isset($token_data["access_token"])) {
        die("Lỗi khi lấy access token");
    }

    $access_token = $token_data["access_token"];

    // Gửi request lấy thông tin user
    $user_info_url = "https://www.googleapis.com/oauth2/v2/userinfo?access_token=" . $access_token;
    $user_info = json_decode(file_get_contents($user_info_url), true);

    $email = $user_info['email'];
    $name = $user_info['name'];
    $randomPhone = '0' . str_pad(rand(0, 999999999), 9, '0', STR_PAD_LEFT);

    // Kiểm tra xem user đã tồn tại chưa
    $query = $conn->prepare("SELECT * FROM user_credit WHERE Email = ? AND login_type = 'google'");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Người dùng đã tồn tại
        $user = $result->fetch_assoc();
    } else {
        // Thêm user mới
        $insert = $conn->prepare("INSERT INTO user_credit (Name, Email,sdt, login_type) VALUES (?, ?,?, 'google')");
        $insert->bind_param("sss", $name, $email,$randomPhone);
        $insert->execute();
        $newUserId = $conn->insert_id;

        // Lấy thông tin người dùng vừa thêm
        $query = $conn->prepare("SELECT * FROM user_credit WHERE id = ?");
        $query->bind_param("i", $newUserId);
        $query->execute();
        $result = $query->get_result();
        $user = $result->fetch_assoc();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Thêm vào bảng tích điểm
            $Diem = 100; // Giá trị điểm khởi tạo, có thể là số khác nếu cần
            $hang='New';
            $insert_query1 = $conn->prepare("INSERT INTO tichdiem (idkh,hangTV, Diem) VALUES (?, ?,?)");
            $insert_query1->bind_param("isi", $newUserId,$hang, $Diem);
            $insert_query1->execute();

            // Tạo session cho người dùng
            session_start();
           
            $_SESSION['Email'] = $user['Email'];
           
            $_SESSION['sdt'] = $user['sdt'] ?? ''; // Giá trị mặc định nếu chưa có
            $_SESSION['Address'] = $user['Address'] ?? ''; // Giá trị mặc định nếu chưa có
            $_SESSION['id'] = $user['id'];
            $_SESSION['Name'] = $user['Name'];
            $_SESSION['profile'] = $user['profile'];
            $_SESSION['Datetime']= $user['Datetime'];
            $_SESSION['login_type']= $user['login_type'];
            // Chuyển hướng đến trang chính
            log_action($conn, $user['id'], 'login', 'Đăng nhập vào hệ thống','user');
            header("Location: logout.php");
            header("Location: dangnhap.php");
            
            exit();
        } else {
            // Trường hợp bất thường, không tìm thấy người dùng vừa thêm
            die("Lỗi: Không thể đăng nhập với thông tin người dùng vừa thêm.");
        }
    }

    // Tạo session
    session_start();
    $_SESSION['Email'] = $user['Email'];
           
    $_SESSION['sdt'] = $user['sdt'] ?? ''; // Giá trị mặc định nếu chưa có
    $_SESSION['Address'] = $user['Address'] ?? ''; // Giá trị mặc định nếu chưa có
    $_SESSION['id'] = $user['id'];
    $_SESSION['Name'] = $user['Name'];
    $_SESSION['profile'] = $user['profile'];
    $_SESSION['Datetime']= $user['Datetime'];
    $_SESSION['login_type']= $user['login_type'];
    // Chuyển hướng về trang chính
    log_action($conn, $user['id'], 'login', 'Đăng nhập vào hệ thống','user');
    header("Location: index.php?ttcnkh");
    exit();
}
?>

<span style="border-top: 2px dashed black; display: block;"></span>
<br>


    <?php



if (isset($_GET['state']) && $_GET['state'] == 'facebook' && isset($_GET['code'])) {

    $fb_app_id = "607173435691578";
$fb_app_secret = "490fc6c15b3d79ad6701f16cc6b62c88";
$redirect_uri = "http://localhost/tour/dangnhap.php";
    $code = $_GET['code'];

    // Lấy access token từ Facebook
    $token_url = "https://graph.facebook.com/v22.0/oauth/access_token?"
        . "client_id={$fb_app_id}&redirect_uri=" . urlencode($redirect_uri)
        . "&client_secret={$fb_app_secret}&code={$code}";

    $response = file_get_contents($token_url);
    
    $params = json_decode($response, true);

    if (isset($params['access_token'])) {
        $access_token = $params['access_token'];

        // Lấy thông tin người dùng
        $graph_url = "https://graph.facebook.com/me?fields=id,name,email,picture&access_token={$access_token}";
        $user_info = json_decode(file_get_contents($graph_url), true);

        if (isset($user_info['email'])) {
            $email = $user_info['email'];
            $name = $user_info['name'];
            $profile_pic = $user_info['picture']['data']['url'];
            $randomPhone = '0' . str_pad(rand(0, 999999999), 9, '0', STR_PAD_LEFT);
            // Kiểm tra xem user đã tồn tại chưa
            $query = $conn->prepare("SELECT * FROM user_credit WHERE Email = ? AND login_type = 'facebook'");
            $query->bind_param("s", $email);
            $query->execute();
            $result = $query->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
            } else {
                // Nếu chưa tồn tại, thêm mới
                $insert = $conn->prepare("INSERT INTO user_credit (Name, Email,sdt, profile, login_type) VALUES (?, ?, ?,?, 'facebook')");
                $insert->bind_param("ssss", $name, $email,$randomPhone, $profile_pic);
                $insert->execute();

                $newUserId = $conn->insert_id;
                $user = ['id' => $newUserId, 'Email' => $email, 'Name' => $name, 'profile' => $profile_pic];

              

        // Lấy thông tin người dùng vừa thêm
        $query = $conn->prepare("SELECT * FROM user_credit WHERE id = ?");
        $query->bind_param("i", $newUserId);
        $query->execute();
        $result = $query->get_result();
        $user = $result->fetch_assoc();
                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
        
                    // Thêm vào bảng tích điểm
                    $Diem = 100; // Giá trị điểm khởi tạo, có thể là số khác nếu cần
                    $hang='New';
                    $insert_query1 = $conn->prepare("INSERT INTO tichdiem (idkh,hangTV, Diem) VALUES (?, ?,?)");
                    $insert_query1->bind_param("isi", $newUserId,$hang, $Diem);
                    $insert_query1->execute();
        
                    // Tạo session cho người dùng
                    session_start();
                    $_SESSION['Email'] = $user['Email'];
                   
                    $_SESSION['sdt'] = $user['sdt'] ?? ''; // Giá trị mặc định nếu chưa có
                    $_SESSION['Address'] = $user['Address'] ?? ''; // Giá trị mặc định nếu chưa có
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['Name'] = $user['Name'];
                    $_SESSION['profile'] = $user['profile'];
                    $_SESSION['Datetime']= $user['Datetime'];
                    // Chuyển hướng đến trang chính
                    $_SESSION['login_type']= $user['login_type'];
                    log_action($conn, $user['id'], 'login', 'Đăng nhập vào hệ thống','user');
                    header("Location: logout.php");
                    header("Location: dangnhap.php");
                    
                    exit();
                } else {
                    // Trường hợp bất thường, không tìm thấy người dùng vừa thêm
                    die("Lỗi: Không thể đăng nhập với thông tin người dùng vừa thêm.");
                }
            }

            // Tạo session
            session_start();
            $_SESSION['Email'] = $user['Email'];
           
            $_SESSION['sdt'] = $user['sdt'] ?? ''; // Giá trị mặc định nếu chưa có
            $_SESSION['Address'] = $user['Address'] ?? ''; // Giá trị mặc định nếu chưa có
            $_SESSION['id'] = $user['id'];
            $_SESSION['Name'] = $user['Name'];
            $_SESSION['profile'] = $user['profile'];
            $_SESSION['Datetime']= $user['Datetime'];
            $_SESSION['login_type']= $user['login_type'];
            log_action($conn, $user['id'], 'login', 'Đăng nhập vào hệ thống','user');
            // Chuyển hướng về trang chính
            header("Location: index.php");
            exit();
        } else {
            echo "Không lấy được email từ Facebook.";
        }
    } else {
        
        echo "Lỗi lấy access token từ Facebook.";
    }
}
}
?>

<?php


    
$client_id = "340284496362-lhog2q4dt6ajs68oc6rcsf5nka48d89n.apps.googleusercontent.com";
$redirect_uri = "http://localhost/tour/dangnhap.php";
$scope = "email profile"; // Lấy email và thông tin profile
$google_login_url = "https://accounts.google.com/o/oauth2/auth?"
    . "client_id=" . $client_id
    . "&redirect_uri=" . urlencode($redirect_uri)
    . "&response_type=code"
    . "&scope=" . urlencode($scope)
    . "&state=google"; // Thêm state để phân biệt dịch vụ


// URL đăng nhập Facebook

$fb_app_id = "607173435691578";
$fb_redirect_uri = urlencode("http://localhost/tour/dangnhap.php"); // URL xử lý đăng nhập
$fb_login_url = "https://www.facebook.com/v22.0/dialog/oauth?"
    . "client_id={$fb_app_id}&redirect_uri={$fb_redirect_uri}&scope=email,public_profile"
    . "&state=facebook"; // Thêm state để phân biệt dịch vụ


?>



<center>Đăng nhập bằng cách khác <br> <br></center>
<div style="display: flex; justify-content: center; align-items: center; gap: 15px;">
<a href="<?php echo htmlspecialchars($google_login_url); ?>" title="Đăng nhập bằng Google">
    <img src="./assets/img/geo.png" width="30px" height="30px" alt="Google">
</a>
<a href="<?php echo htmlspecialchars($fb_login_url); ?>" title="Đăng nhập bằng Facebook">
    <img src="./assets/img/facebook1.png" width="30px" height="30px" alt="Facebook">
</a>

</div>




                    
                </form>
                <!-- <script src="https://hcaptcha.com/1/api.js" async defer></script> -->
                <table style="width:100%">
                    <tr>
                        <td > <p><a href="dangky.php">Chưa có tài khoản</a></p></td>
                        <td style="text-align: right;"> <p><a href="quenmk.php">Quên mật khẩu</a></p></td>
                    </tr>
                </table>
               
            </div>
            <div class="info-box">
                <h3>Tại sao mọi người chọn?</h3>
                <ul>
                    <li>📉 Giá tốt</li>
                    <li>🎧 Dịch vụ hàng đầu</li>
                    <li>💳 Thanh toán an toàn</li>
                    <li>✅ Đáng tin cậy</li>
                </ul>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const state = urlParams.get("state");

    if (state === "google") {
        document.getElementById("login_type").value = "google";
    } else if (state === "facebook") {
        document.getElementById("login_type").value = "facebook";
    }
});

</script>
    <script>

let loginForm = document.querySelector(".my-form"); 
loginForm.addEventListener("submit", (e) => { 
    e.preventDefault(); 
    let email = document.getElementById("email"); 
    let password = document.getElementById("password"); 
    
});

        function openPopup(title, message) {
    popup.querySelector('h2').innerText = title;
    popup.querySelector('p').innerText = message;
    popup.style.display = 'block';
    overlay.style.display = 'block';
}
function closePopup() {
        popup.style.display = 'none';
        overlay.style.display = 'none';
}

$(document).ready(function() {
    $("#loginform").submit(function(e) {
        e.preventDefault(); // Ngăn chặn load lại trang mặc định

        let email = $("#email").val().trim();
        let password = $("#password").val().trim();

        if (email === "" || password === "") {
            openPopup("Lỗi", "Vui lòng điền đầy đủ thông tin.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "./api/api.php",
            data: $(this).serialize(),
            success: function(response) {
                if (response === "customer") {
                    openPopup("Đăng nhập thành công", "");
                    setTimeout(() => { window.location.href = "index.php"; }, 1000);
                } else if (response === "staff" || response === "admin") {
                    openPopup("Đăng nhập thành công", "");
                    setTimeout(() => { window.location.href = "indexa.php"; }, 1000);
                        } else if (response.startsWith("email_error:")) {
                let errorMessage = response.replace("email_error: ", "");
                openPopup("Lỗi gửi email", errorMessage);
            } else if (response === "locked") {
                openPopup("Tài khoản bị khóa", "Vui lòng kiểm tra email để mở khóa.");}
                 else {
                    openPopup("Đăng nhập thất bại", "Thông tin không chính xác.");
                }
            },
            error: function() {
                openPopup("Lỗi kết nối", "Không thể kết nối đến server.");
            }
        });
    });
});


function togglePasswordVisibility(inputId, iconId) {
    let passwordInput = document.getElementById(inputId);
    let eyeIcon = document.getElementById(iconId);

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}

    </script>
</body>
</html>
