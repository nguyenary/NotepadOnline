<?php
// Url Home
$base_url = 'https://';

// Tiêu đề
$title = 'Notepad Online';

// Vô hiệu hóa caching.
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Nếu tên của một ghi chú không được cung cấp hoặc chứa các ký tự không phải chữ và số / không phải ASCII.
if (!isset($_GET['note']) || !preg_match('/^[a-zA-Z0-9]+$/', $_GET['note'])) {
    // Tạo tên với 5 ký tự ngẫu nhiên rõ ràng. Chuyển hướng đến nó.
    header("Location: $base_url/" . substr(str_shuffle('234579abcdefghjkmnpqrstwxyz'), -5));
    die;
}

$path = '_tmp/' . $_GET['note'];

if (isset($_POST['text'])) {
    // Cập nhật tệp.
    file_put_contents($path, $_POST['text']);
    // Nếu đầu vào được cung cấp trống, hãy xóa tệp.
    if (!strlen($_POST['text'])) {
        unlink($path);
    }
    die;
}

// Đầu ra tập tin thô nếu khách hàng là curl.
if (strpos($_SERVER['HTTP_USER_AGENT'], 'curl') === 0) {
    if (is_file($path)) {
        print file_get_contents($path);
    }
    die;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?php print $title; ?> -<?php print $_GET['note']; ?></title>
        <link rel="shortcut icon" href="<?php print $base_url; ?>/favicon.ico" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div style="height: 50%;" class="form-group">
                <textarea placeholder="Nhập nội dung cần lưu trữ vào đây..." class="form-control" id="content">
                <?php
                    if (is_file($path)) {
                        print htmlspecialchars(file_get_contents($path), ENT_QUOTES, 'UTF-8');
                    }
                ?>
                </textarea>
            </div>
            <div class="form-group">
                <a onclick="window.location.reload(true);">
                    <button onclick="myFunction()" type="submit" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu Notepad</button>
                </a>
                <a href="javascript:;" onclick="CopyLink()" type="submit" class="btn btn-danger"><i class="fa fa-clipboard"></i> Copy Link Notepad</a>
                <div class="btn btn-primary" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button" data-size="large" data-mobile-iframe="true">
                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore" class="btn btn-primary">
                        <i class="fa fa-facebook"></i> Share Lên Facebook
                    </a>
                </div>

                <script>
                    function copyTextToClipboard(e) {
                        var t = document.createElement("textarea");
                        (t.style.position = "fixed"),
                            (t.style.top = 0),
                            (t.style.left = 0),
                            (t.style.width = "2em"),
                            (t.style.height = "2em"),
                            (t.style.padding = 0),
                            (t.style.border = "none"),
                            (t.style.outline = "none"),
                            (t.style.boxShadow = "none"),
                            (t.style.background = "transparent"),
                            (t.value = e),
                            document.body.appendChild(t),
                            t.select();
                        try {
                            document.execCommand("copy"), alert("Đã sao chép liên kết vào khay nhớ tạm thời!");
                        } catch (o) {
                            alert("Không thể sao chép liên kết!");
                        }
                        document.body.removeChild(t);
                    }
                    function CopyLink() {
                        copyTextToClipboard(location.href);
                    }
                </script>
                <script>
                    function myFunction() {
                        alert("Bạn đã lưu thành công !");
                    }
                </script>
                <script type="text/javascript">
                    function Copy() {
                        urlCopied.innerHTML = window.location.href;
                    }
                </script>
                <script>
                    document.getElementById("demo").innerHTML = "" + window.location.href;
                </script>
            </div>
        </div>
        <link rel="stylesheet" href="<?php print $base_url; ?>/style.css" />
        <pre id="printable"></pre>
        <div id="fb-root"></div>
        <script>
            (function (d, s, id) {
                var js,
                    fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = "https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.2";
                fjs.parentNode.insertBefore(js, fjs);
            })(document, "script", "facebook-jssdk");
        </script>

        <script src="<?php print $base_url; ?>/script.js"></script>
    </body>
</html>
