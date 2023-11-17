<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content>
<meta name="author" content>
<title>2fa.skin Lấy mã bảo mật 2 lớp</title>
<link rel="canonical" href="https://2fa.skin">
<link rel="alternate" href="https://2fa.skin/" hreflang="en-us" />
<link rel="alternate" href="https://2fa.skin/" hreflang="vi-vn" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
<style>
	html {
	  font-size: 14px;
	}
	@media (min-width: 768px) {
	  html {
	    font-size: 16px;
	  }
	}

	.container {
	  max-width: 960px;
	}

	.pricing-header {
	  max-width: 700px;
	}

	.card-deck .card {
	  min-width: 220px;
	}
</style>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-L553VMWZW6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-L553VMWZW6');
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1103837818351688" crossorigin="anonymous"></script>
</head>
<body>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
<h5 class="my-0 mr-md-auto font-weight-normal">2FA.SKIN</h5>
<nav class="my-2 my-md-0 mr-md-3">
</nav>
</div>
<div class="container">
<form class="mt-4" id="form_secret" method="post">
<div class="form-group">
<label for="SECRET2FA">Secret Key</label>
<textarea class="form-control" name="SECRET2FA" id="SECRET2FA" rows="4" placeholder="5NQV HJNP QCNP JJIY ... &#x0a;L2WA M4BZ RBM2 YVJP ..."></textarea>
<small id="SECRET2FAHelp" class="form-text text-muted">Chỉ chấp nhận chữ cái, số và khoảng cách. Mỗi dòng sẽ lấy 1 code. </small>
</div>
<button class="btn btn-primary" type="button" onclick="get2FACode()">Lấy CODE</button>
</form>
<div class="mt-3 table_list_code" style="display:none;">
<table class="table  table-bordered table-striped">
<thead class="thead-dark">
<tr>
<th scope="col text-center" style="width:120px; text-align:center">CODE</th>
<th scope="col text-center">Secret Key</th>
</tr>
</thead>
<tbody id="newlistsecret">
</tbody>
</table>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script>
function get2FACode() {
    var secretsInput = document.getElementById("SECRET2FA").value;
    
    if (secretsInput.trim() === "") {
        alert("Vui lòng nhập SECRET KEY !");
        return;
    }
    
    var secretsArray = secretsInput.split(/\r?\n/);
    var tableBody = document.getElementById("newlistsecret");
    
    function updateRow(secretKey, response) {
        var existingRow = tableBody.querySelector("[data-secret='" + secretKey + "']");
        
        if (existingRow) {
            existingRow.querySelector(".code-column").textContent = secretKey;
            existingRow.querySelector(".secret-key-column").textContent = response;
        } else {
            var newRow = "<tr data-secret='" + secretKey + "'><td class='secret-key-column'>" + response + "</td><td class='code-column'>" + secretKey + "</td></tr>";
            tableBody.innerHTML += newRow;
            document.querySelector(".table_list_code").style.display = "block";
        }
    }

    function fetchAndUpdate(secretKey) {
        var cleanedSecretKey = secretKey.replace(/\s+/g, ''); // Xóa dấu cách nếu có trong giá trị input gửi đi
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "server.php?key=" + encodeURIComponent(cleanedSecretKey), false);
        xhr.send();

        if (xhr.status === 200) {
            var response = xhr.responseText;
            updateRow(cleanedSecretKey, response);
        } else {
            console.log("Error:", xhr.status);
        }
    }

    function updateCodes() {
        for (var i = 0; i < secretsArray.length; i++) {
            var secretKey = secretsArray[i];
            fetchAndUpdate(secretKey);
        }
    }

    updateCodes(); 

    setInterval(function () {
        secretsArray = document.getElementById("SECRET2FA").value.split(/\r?\n/);
        updateCodes();
    }, 15000); 
}
</script>
</body>
</html>
