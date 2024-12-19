<?php
include("config.php");

$selectClass = "SELECT * from class WHERE `status` = 1";
$selectClassResult = mysqli_query($conn, $selectClass);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Student account | ClassHelp</title>
  <link rel="stylesheet" href="assets/css/auth.css">
  <link rel="stylesheet" href="assets/css/modal.css">
</head>

<body>
  <div class="container">
    <main>
      <div class="welcome_txt">
        <span>Create an Account</span>
      </div>
      <form action="#" id="studentForm" method="post">
        <div class="error-box">
          <span id="errorMessage">
            You've entered an invalid password.
          </span>
        </div>
        <div class="input-box active">
          <input type="text" name="" id="firstname" autocomplete="off">
          <span>Firstname*</span>
        </div>
        <div class="input-box">
          <input type="text" name="" id="lastname" autocomplete="off">
          <span>Lastname*</span>
        </div>
        <div class="input-box">
          <select id="class">
            <option value="" disabled selected>Select a class</option>
            <?php while ($row = mysqli_fetch_assoc($selectClassResult)) { ?>
              <option value="<?php echo $row['id']; ?>"><?php echo $row['classname']; ?></option>
            <?php } ?>
          </select>
          <span>Select a class*</span>
        </div>
        <div class="input-box">
          <select id="gender">
            <option value="" disabled selected>Select a gender</option>
            <option value="0">Male</option>
            <option value="1">Female</option>
          </select>
          <span>Select a gender*</span>
        </div>
        <div class="input-box">
          <input type="password" id="password" autocomplete="off">
          <span>Password*</span>
        </div>
        <div class="submit-btn">
          <button type="button">Create Account</button>
        </div>
      </form>
      <div class="cta_refrence">
        <span>Having issues creating an account?<span class="cta_active">Contact an administrator</span></span>
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
    <div class="show_review_modal" id="showReviewModal">
      <div class="modal-box">

        <div class="modal-box-up">
          <div class="icon">
            <img src="assets/icon/Animation - 1733316006168.gif" alt="success spinner">
          </div>
          <div class="txt">
            <span style="color: var(--theme-color);">
              <span class="bigger">Account was created successfully!</span>
              <br />
              <br />
              Together, we are shaping bright futures and empowering students to achieve their fullest potential, unlocking opportunities for growth, greatness every step of the way.</span>
          </div>
        </div>
        <div class="modal-box-down">
          <div class="new-review">
            <button id="cancel">
              <span>Cancel</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/js/resetForm.js"></script>
  <script src="assets/js/form-step.js"></script>
  <script>
    resetForm("studentForm");

    async function submitForm(e) {

      e.preventDefault();

      const firstname = document.getElementById("firstname").value;
      const lastname = document.getElementById("lastname").value;
      const classs = document.getElementById("class").value;
      console.log("Here: ", classs);
      const gender = document.getElementById("gender").value;
      const password = document.getElementById("password").value;
      let isAllStepActiveRemoved = false;
      // Send the class name and hashed password to the server
      fetch("save_student.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            firstname: firstname,
            lastname: lastname,
            classs: classs,
            gender: gender,
            password: password,
          }),
        })
        .then((response) => response.json())
        .then((data) => {
          console.log(data.message);
          const allInput = document.querySelectorAll('.input-box');
          // remove all active input-box, and set only the first one to active
          allInput.forEach(input => {
            input.classList.remove("active");
            if (!isAllStepActiveRemoved) {
              isAllStepActiveRemoved = true;
            }
          });
          if (isAllStepActiveRemoved) {
            showReviewModal();
            allInput[0].classList.add("active");
            document.getElementById("studentForm").reset();
          }
        })
        .catch((error) => console.error("Error:", error));
      // // Basic client-side password hashing function (SHA-256)
      // async function hashPassword(password) {
      //   const encoder = new TextEncoder();
      //   const data = encoder.encode(password);
      //   const hashBuffer = await crypto.subtle.digest("SHA-256", data);
      //   const hashArray = Array.from(new Uint8Array(hashBuffer)); // Convert buffer to byte array
      //   return btoa(String.fromCharCode(...hashArray)); // Convert bytes to base64
      // }
    }

    function showReviewModal() {
      document.getElementById('showReviewModal').classList.add('active');
    }

    function removeReviewModal() {
      document.getElementById('showReviewModal').classList.remove('active');
    }

    // Close 'account successfully created modal'
    document.getElementById('cancel').addEventListener('click', removeReviewModal);
  </script>
</body>

</html>