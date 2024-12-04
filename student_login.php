<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header("Location: student_dashboard.php?access=granted");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/auth.css">
</head>

<body>
  <div class="container">
    <header>
      <div class="webApp_logo">
        <img src="assets/img/logo_text_r.png" alt="">
      </div>
    </header>
    <main>
      <div class="welcome_txt">
        <span>Welcome Back</span>
      </div>
      <form action="#" id="loginForm" method="post">
        <div class="error-box">
          <span id="errorMessage">
            You've entered an invalid password.
          </span>
        </div>
        <div class="input-box active">
          <input type="text" name="" id="login" autocomplete="off">
          <span>Student ID*</span>
        </div>
        <div class="input-box">
          <input type="password" name="" id="password" autocomplete="off">
          <span>Password*</span>
        </div>
        <div class="submit-btn">
          <button type="button">Log In</button>
        </div>
      </form>
      <div class="cta_refrence">
        <span>Don't have an account?<span class="cta_active">Contact an administrator</span></span>
      </div>

      <div class="foot_content">
        <div class="cont">
          <span>Terms of use</span>
        </div>
        <span>|</span>
        <div class="cont">
          <span>Privacy policy</span>
        </div>
      </div>
    </main>
  </div>

  <script>
    let allInput = document.querySelectorAll('input');
    allInput.forEach(input => {
      input.value = " ";
    });


    const allInputBox = document.querySelectorAll('.input-box');
    const submitBtn = document.querySelector('.submit-btn');

    const formLogin = document.getElementById('loginForm');

    const errorMessage = document.getElementById('errorMessage');

    allInputBox.forEach(inputbox => {


      let input = inputbox.querySelector('input');

      let inputMinimun = 2;

      input.addEventListener('input', function() {
        let nextInputBox = inputbox.nextElementSibling;
        if (input.value.length > inputMinimun) {
          let errorIn = document.querySelectorAll('.input-box.error');
          if (nextInputBox && nextInputBox.classList.contains('input-box')) {
            nextInputBox.classList.add('active');

            if (errorIn) {
              errorIn.forEach(error => {
                error.classList.remove('error');
              });
            }
          } else if (nextInputBox && nextInputBox.classList.contains('submit-btn')) {
            submitBtn.classList.add('active');

            if (errorIn) {
              errorIn.forEach(error => {
                error.classList.remove('error');
              });
            }
          }
        } else {
          if (nextInputBox && nextInputBox.classList.contains('input-box')) {
            nextInputBox.classList.remove('active');
            errorMessage.textContent = "";
            errorMessage.parentElement.classList.remove('active');
          } else if (nextInputBox && nextInputBox.classList.contains('submit-btn')) {
            errorMessage.textContent = "";
            errorMessage.parentElement.classList.remove('active');
            submitBtn.classList.remove('active');
          }
        }
      });

      input.addEventListener('keydown', function(event) {
        // event.preventDefault();
        let nextInputBox = inputbox.nextElementSibling;
        if (event.keyCode === 13 || event.key === "ENTER") {
          if (input.value.length > inputMinimun) {
            if (nextInputBox && nextInputBox.classList.contains('input-box')) {
              nextInputBox.classList.add('active');
              nextInputBox.querySelector('input').focus();
            } else if (nextInputBox && nextInputBox.classList.contains('submit-btn')) {
              submitBtn.classList.add('active');
              // submit form here
              submitForm(event);
            }
          }
        }
      });
    });

    submitBtn.addEventListener('click', (e) => submitForm(event));




    async function submitForm(e) {
      e.preventDefault();

      const login = document.getElementById("login").value;
      const password = document.getElementById("password").value;

      // Send the first name and hashed password to the server for verification
      fetch("stdntlogin.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            login: login,
            password: password
          })
        })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // alert("Login successful!");
            window.location.href = "student_dashboard.php";
          } else {
            errorMessage.textContent = data.message;
            errorMessage.parentElement.classList.add('active');

            if (data.ww === "both") {
              allInputBox.forEach(input => {
                input.classList.add('error');
              });
            } else if (data.ww === "password") {
              allInputBox[1].classList.add('error');
            }
          }
        })
        .catch((error) => console.error("Error:", error));
    }

    // Basic client-side password hashing function (SHA-256)
    function hashPassword(password) {
      function rotateRight(n, x) {
        return (x >>> n) | (x << (32 - n));
      }

      function sha256(ascii) {
        const K = [ // SHA-256 constants
          0x428a2f98, 0x71374491, 0xb5c0fbcf, 0xe9b5dba5, 0x3956c25b, 0x59f111f1, 0x923f82a4, 0xab1c5ed5,
          0xd807aa98, 0x12835b01, 0x243185be, 0x550c7dc3, 0x72be5d74, 0x80deb1fe, 0x9bdc06a7, 0xc19bf174,
          0xe49b69c1, 0xefbe4786, 0x0fc19dc6, 0x240ca1cc, 0x2de92c6f, 0x4a7484aa, 0x5cb0a9dc, 0x76f988da,
          0x983e5152, 0xa831c66d, 0xb00327c8, 0xbf597fc7, 0xc6e00bf3, 0xd5a79147, 0x06ca6351, 0x14292967,
          0x27b70a85, 0x2e1b2138, 0x4d2c6dfc, 0x53380d13, 0x650a7354, 0x766a0abb, 0x81c2c92e, 0x92722c85,
          0xa2bfe8a1, 0xa81a664b, 0xc24b8b70, 0xc76c51a3, 0xd192e819, 0xd6990624, 0xf40e3585, 0x106aa070,
          0x19a4c116, 0x1e376c08, 0x2748774c, 0x34b0bcb5, 0x391c0cb3, 0x4ed8aa4a, 0x5b9cca4f, 0x682e6ff3,
          0x748f82ee, 0x78a5636f, 0x84c87814, 0x8cc70208, 0x90befffa, 0xa4506ceb, 0xbef9a3f7, 0xc67178f2
        ];

        const HASH = [ // Initial hash values
          0x6a09e667, 0xbb67ae85, 0x3c6ef372, 0xa54ff53a, 0x510e527f, 0x9b05688c, 0x1f83d9ab, 0x5be0cd19
        ];

        const blocks = [];

        const asciiBitLength = ascii.length * 8;

        for (let i = 0; i < ascii.length; i++) {
          blocks[i >> 2] |= ascii.charCodeAt(i) << (((3 - i) % 4) * 8);
        }
        blocks[ascii.length >> 2] |= 0x80 << (((3 - ascii.length) % 4) * 8);
        blocks[((ascii.length + 64 >> 9) << 4) + 15] = asciiBitLength;

        for (let j = 0; j < blocks.length; j += 16) {
          const W = blocks.slice(j, j + 16);

          for (let i = 16; i < 64; i++) {
            const s0 = rotateRight(7, W[i - 15]) ^ rotateRight(18, W[i - 15]) ^ (W[i - 15] >>> 3);
            const s1 = rotateRight(17, W[i - 2]) ^ rotateRight(19, W[i - 2]) ^ (W[i - 2] >>> 10);
            W[i] = (W[i - 16] + s0 + W[i - 7] + s1) | 0;
          }

          let [a, b, c, d, e, f, g, h] = HASH;

          for (let i = 0; i < 64; i++) {
            const S1 = rotateRight(6, e) ^ rotateRight(11, e) ^ rotateRight(25, e);
            const ch = (e & f) ^ (~e & g);
            const temp1 = (h + S1 + ch + K[i] + W[i]) | 0;
            const S0 = rotateRight(2, a) ^ rotateRight(13, a) ^ rotateRight(22, a);
            const maj = (a & b) ^ (a & c) ^ (b & c);
            const temp2 = (S0 + maj) | 0;

            h = g;
            g = f;
            f = e;
            e = (d + temp1) | 0;
            d = c;
            c = b;
            b = a;
            a = (temp1 + temp2) | 0;
          }

          HASH[0] = (HASH[0] + a) | 0;
          HASH[1] = (HASH[1] + b) | 0;
          HASH[2] = (HASH[2] + c) | 0;
          HASH[3] = (HASH[3] + d) | 0;
          HASH[4] = (HASH[4] + e) | 0;
          HASH[5] = (HASH[5] + f) | 0;
          HASH[6] = (HASH[6] + g) | 0;
          HASH[7] = (HASH[7] + h) | 0;
        }

        return HASH.map(h => ('00000000' + (h >>> 0).toString(16)).slice(-8)).join('');
      }

      console.log(sha256(password));
      return btoa(sha256(password));
    }
  </script>
</body>

</html>

<!-- <form id="loginForm">
    <label>First Name: <input type="text" id="firstname" required /></label><br />
    <label>Password: <input type="password" id="password" required /></label><br />
    <button type="submit">Login</button>
  </form>

  <script>
    document.getElementById("loginForm").addEventListener("submit", async function(e) {
      e.preventDefault();

      const firstname = document.getElementById("firstname").value;
      const password = document.getElementById("password").value;

      // Hash the password client-side
      const passwordHash = await hashPassword(password);

      // Send the first name and hashed password to the server for verification
      fetch("stdntlogin.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            firstname: firstname,
            password_hash: passwordHash
          })
        })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            alert("Login successful!");
            window.location.href = "student_dashboard.php";
          } else {
            alert("Invalid credentials!");
          }
        })
        .catch((error) => console.error("Error:", error));
    });

    // Basic client-side password hashing function (SHA-256)
    async function hashPassword(password) {
      const encoder = new TextEncoder();
      const data = encoder.encode(password);
      const hashBuffer = await crypto.subtle.digest("SHA-256", data);
      const hashArray = Array.from(new Uint8Array(hashBuffer));
      return btoa(String.fromCharCode(...hashArray));
    }
  </script> -->