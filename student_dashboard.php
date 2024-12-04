<?php
session_start();
include("config.php");

$studentData = null;
$subjectData = [];

$greetTxtFromTime = "";
$emojiFromTime = "";

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];

  // Fetch student data
  $getStudentData = "SELECT * FROM student WHERE id = $user_id AND `status` = '1'";
  $getStudentDataResult = mysqli_query($conn, $getStudentData);
  if ($getStudentDataResult && mysqli_num_rows($getStudentDataResult) > 0) {
    $studentData = mysqli_fetch_assoc($getStudentDataResult);
  }

  // Fetch subjects
  $getSubjectData = "SELECT * FROM subject WHERE `status` = '1'";
  $getSubjectDataResult = mysqli_query($conn, $getSubjectData);
  while ($row = mysqli_fetch_assoc($getSubjectDataResult)) {
    $subjectData[] = $row;
  }


  // Check time to show greeting text
  $time = date('H');
  if ($time < 12) {
    $greetTxtFromTime = "Good Morning, ";
    $emojiFromTime = "🌞";
  } else if ($time >= 12 && $time < 18) {
    $greetTxtFromTime = "Good Afternoon ~ ";
    $emojiFromTime = "👌🏽";
  } else {
    $greetTxtFromTime = "Good evening ~ ";
    $emojiFromTime = "🌙";
  }
} else {
  // echo "Please log in.";
  header("Location: student_login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student | Dashboard</title>
  <!-- <script src="route.js" defer></script> -->
  <link rel="stylesheet" href="assets/css/stdn.css">
  <style>
    /* body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      width: 100%;
      background-color: #eee;
      font-family: Helvetica, Arial, sans-serif;
      flex-direction: column;
    }

    .greeting {
      font-size: 2.4rem;
      color: #333;
    }

    ul {
      list-style-type: none;
      padding: 0;
      cursor: pointer;
    }

    .custom-radio input[type="radio"] {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      position: absolute;
      opacity: 0;
    }

    .custom-radio {
      display: flex;
      margin: 5px;
      border: 2px solid #007bff;
      border-radius: 12px;
      padding: 0px;
      cursor: pointer;
      transition: background-color 0.3s, color 0.3s;
      font-weight: bold;
    }

    .custom-radio span {
      color: #007bff;
      border-radius: inherit;
      padding: 13px 20px;
      width: 100%;
      height: 100%;
    }

    .custom-radio:hover {
      background-color: #007bff;
      color: white;
    }

    .custom-radio:hover>span {
      color: #FFFFFF;
    }

    .custom-radio input[type="radio"]:checked {
      border: none;
    }

    .custom-radio input[type="radio"]:checked+span {
      background-color: #007bff;
      color: white;
    } */
  </style>
</head>

<body>

  <div class="container">
    <header>
      <!-- <a href="addsubject.php">Add Subject</a> -->
    </header>
    <main>
      <div class="all_content">
        <div class="greet">
          <span><?= htmlspecialchars($greetTxtFromTime); ?> <?= htmlspecialchars($studentData['firstname']); ?><?= htmlspecialchars($emojiFromTime) ?>.</span>
        </div>

        <form action="" id="multiStepForm" method="post">
          <input type="hidden" name="studentid" value="<?= htmlspecialchars($studentData['id']); ?>">
          <div class="review_pane">
            <div class="step startReview active" id="step1">
              <input type="hidden" name="subjectid" id="subjectId">
              <div class="open_txt">
                <span>Select a subject to review</span>
              </div>
              <ul id="subjectList">
                <?php foreach ($subjectData as $subject): ?>
                  <li class="a_item" style="--subject-theme: <?= $subject['theme'] ?>" data-subj-id="<?= htmlspecialchars($subject['id']); ?>" data-class-id="<?= htmlspecialchars($studentData['class']); ?>" onclick="nextStep()" data-real-val="<?= htmlspecialchars($subject['id']); ?>" data-input-val="subjectId"><?= $subject['subject_name']; ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <div class="step" id="step2">
              <input type="hidden" name="topicid" id="topicId">
              <div class="open_txt">
                <span>Select a topic to review</span>
              </div>
              <ul id="topicList">
              </ul>
              <div class="action-btns">
                <div class="act-btn previous" onclick="prevStep()">
                  <button type="button">
                    <div class="svg_icon">
                      <!-- 
                        Title: “Arrow Left 5 SVG Vector”
                        Author: “Ankush Syal“— https://www.svgrepo.com/author/Ankush%20Syal/
                        Source: “svgrepo.com“— https://www.svgrepo.com/
                        License: “CC Attribution License”— https://www.svgrepo.com/page/licensing/#CC%20Attribution 
                      -->
                      <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 7L10 12L15 17" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </div>
                    <div class="text">Previous</div>
                  </button>
                </div>
                <div class="act-btn next" onclick="nextStep()" style="display: none">
                  <button type="button">
                    <div class="svg_icon">
                      <!-- 
                        Title: “Arrow Left 5 SVG Vector”
                        Author: “Ankush Syal“— https://www.svgrepo.com/author/Ankush%20Syal/
                        Source: “svgrepo.com“— https://www.svgrepo.com/
                        License: “CC Attribution License”— https://www.svgrepo.com/page/licensing/#CC%20Attribution 
                      -->
                      <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 7L10 12L15 17" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </div>
                    <div class="text">Continue</div>
                  </button>
                </div>
              </div>
            </div>
            <?php
            $countStep = 3;
            $query = "SELECT * FROM question_formats WHERE `status` = '1'";
            $res = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($res)) {
              // Fetch a single question
              $query2 = "SELECT * FROM questions WHERE format = '$row[id]' ORDER BY rand() LIMIT 1";
              $res2 = mysqli_query($conn, $query2);

              if ($data = mysqli_fetch_assoc($res2)) {
                // Fetch all options related to the question
                $query3 = "SELECT * FROM options WHERE question_format = '$row[id]' ORDER BY rand()";
                $res3 = mysqli_query($conn, $query3);
            ?>
                <div class="step" id="<?php echo "step$countStep"; ?>">
                  <input type="hidden" name="format[]" value="<?= $row['id']; ?>">
                  <input type="hidden" name="questionid[]" value="<?= $data['id']; ?>">
                  <div class="question_n_option">
                    <div class="question_sec">
                      <span><?= htmlspecialchars($data['question']); ?></span>
                    </div>
                    <div class="option_sec">
                      <?php
                      if ($row['type'] === "write") {
                      ?>
                        <div class="option_txt">
                          <!-- <textarea name="review[<?= $data['id'] ?>]" id=""></textarea> -->
                          <div id="textreview" data-placeholder="Type your message here...(Optional)" name="review[<?= $data['id'] ?>]" class="textingarea" contenteditable="true" role="textbox"></div>

                        </div>
                        <?php
                      } else {
                        while ($option = mysqli_fetch_assoc($res3)) {
                        ?>
                          <label class="options">
                            <input type="radio" name="review[<?= $data['id'] ?>]" value="<?= htmlspecialchars($option['id']) ?>" onclick="nextStep()">
                            <span><?= htmlspecialchars($option['option']) ?></span>
                          </label>
                      <?php
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <div class="action-btns">
                    <div class="act-btn previous" onclick="prevStep()">
                      <button type="button">
                        <div class="svg_icon">
                          <!-- 
                        Title: “Arrow Left 5 SVG Vector”
                        Author: “Ankush Syal“— https://www.svgrepo.com/author/Ankush%20Syal/
                        Source: “svgrepo.com“— https://www.svgrepo.com/
                        License: “CC Attribution License”— https://www.svgrepo.com/page/licensing/#CC%20Attribution 
                      -->
                          <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 7L10 12L15 17" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                        </div>
                        <div class="text">Previous</div>
                      </button>
                    </div>
                    <?php if ($row['type'] === "write") { ?>
                      <div class="act-btn next">
                        <button type="submit">
                          <div class="svg_icon">
                            <!-- 
                              Title: “Arrow Left 5 SVG Vector”
                              Author: “Ankush Syal“— https://www.svgrepo.com/author/Ankush%20Syal/
                              Source: “svgrepo.com“— https://www.svgrepo.com/
                              License: “CC Attribution License”— https://www.svgrepo.com/page/licensing/#CC%20Attribution 
                            -->
                            <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M15 7L10 12L15 17" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                          </div>
                          <div class="text">Submit</div>
                        </button>
                      </div>
                    <?php } ?>
                  </div>
                  <?php if ($row['type'] != "write") { ?>
                    <div class="open_txt">
                      <span>To continue the review, please select an option.</span>
                    </div>
                  <?php } ?>
                </div>
            <?php
                $countStep++;
              }
            }
            ?>
          </div>
        </form>

        <div class="show_review_modal" id="showReviewModal">
          <div class="modal-box">

            <div class="modal-box-up">
              <div class="close-sec">
                <div class="logout-btn">
                  <span>Logout</span>
                </div>
              </div>
              <div class="icon">
                <img src="assets/icon/Animation - 1733316006168.gif" alt="success spinner">
              </div>
              <div class="txt">
                <span>Your feedback has been captured with precision —thank you for sharing your thoughts!</span>
              </div>
            </div>
            <div class="modal-box-down">
              <div class="new-review">
                <button id="newReview">
                  <span>Start a new review</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="assets/js/randomHexCode.js" defer></script>
  <script>
    // Select all subject list items and add click event listeners
    document.querySelectorAll("#subjectList li").forEach(item => {
      item.addEventListener("click", function() {
        // Get subject ID and class Id from data attribute
        const subjectId = this.getAttribute("data-subj-id");

        const classId = this.getAttribute("data-class-id");

        // Fetch topics related to this subject
        fetch("fetch_subject.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              subject_id: subjectId,
              class_id: classId
            }),
          })
          .then(response => response.json())
          .then(data => {
            // Display topics
            const topicList = document.getElementById("topicList");
            if (data.length > 0) {
              // Populate the list if topics are available
              topicList.innerHTML = data.map(topic => `<li class="a_item" onclick="nextStep()" style="--topic-theme: ${generateRandomColor('white')}" data-real-val="${topic.id}" data-input-val="topicId">${topic.name}</li>`).join("");
            } else {
              // Display a message if no topics are found
              topicList.innerHTML = "<p>No topics under this subject yet.</p>";
            }
          })
          .catch(error => console.error("Error:", error));
      });
    });


    // Get all a_item
    document.body.addEventListener('click', async (event) => {
      if (event.target.matches('.a_item')) {
        // Get values from data attributes
        const realDataValue = event.target.getAttribute('data-real-val');
        const inputToStoreVal = event.target.getAttribute('data-input-val');

        console.log(inputToStoreVal);

        // Find the target input element by ID and set its value
        const inputToStore = document.getElementById(inputToStoreVal);
        if (inputToStore) {
          inputToStore.value = realDataValue;
          console.log('Data set:', realDataValue, '->', inputToStoreVal);
        } else {
          console.error(`No input element found with ID: ${inputToStoreVal}`);
        }
      }
    });

    let currentStep = 1;
    const steps = document.querySelectorAll(".step");

    window.addEventListener('popstate', function(event) {
      const state = event.state;
      if (state) {
        currentStep = state.step;
        updateStep();
      }
    })

    function nextStep() {

      if (currentStep < steps.length) {
        currentStep++;
        updateStep();
        // Update the browser's history state
        history.pushState({
          step: currentStep
        }, null, `?step=${currentStep}`);
      }
    }

    function prevStep() {
      if (currentStep > 1) {
        currentStep--;
        updateStep();
        // Update the browser's history state
        history.pushState({
          step: currentStep
        }, null, `?step=${currentStep}`);
      }
    }

    updateStep();

    function updateStep() {
      const formStep = document.querySelectorAll(".step");
      formStep.forEach(step => {
        step.classList.remove('active');
      });



      const currentStepElement = document.getElementById(`step${currentStep}`);
      currentStepElement.classList.add('active');

      if (currentStepElement.id === "step1") {
        // alert("JESUS IS LORD");
        const form = document.getElementById("multiStepForm");
        if (form) {
          // Reset all radio buttons within the form
          const radioButtons = form.querySelectorAll('input[type="radio"]');
          radioButtons.forEach(radio => {
            radio.checked = false;
          });

          // Optional: Reset other form fields (e.g., text inputs, checkboxes, etc.)
          form.reset();
        } else {
          console.error("Form not found");
        }
      }
    }

    // Update the browser's history state
    history.replaceState({
      step: currentStep
    }, null, `?step=${currentStep}`);


    let isAllStepActiveRemoved = false;

    function submitForm(event) {
      const form = document.getElementById("multiStepForm");
      const formData = new FormData(form);
      event.preventDefault();

      fetch("save_review.php", {
          method: "POST",
          body: formData,
        })
        .then(response => response.text())
        .then(data => {
          console.log(data);
          showReviewModal();
        })
        .catch(error => console.error("Error:", error));
    }
    const multiForm = document.getElementById("multiStepForm");
    multiForm.addEventListener('submit', submitForm);



    // Handle radio inputs
    document.querySelectorAll('.options input[type="radio"]').forEach(input => {
      const parent = input.closest('.options');

      // Initial state: remove the 'checked' class from the parent
      parent.classList.remove('checked');

      input.addEventListener('click', () => {
        // Remove the 'checked' class from all parents to reset the state
        document.querySelectorAll('.options').forEach(option => {
          option.classList.remove('checked');
        });
        // Add the 'checked' class only to the parent of all currently checked inputs
        document.querySelectorAll('.options input[type="radio"]:checked').forEach(checkedInput => {
          const checkedParent = checkedInput.closest('.options');
          if (checkedParent) {
            checkedParent.classList.add('checked');
          }
        });

      });
    });


    function showReviewModal() {
      document.getElementById('showReviewModal').classList.add('active');

      const newReviewBtn = document.getElementById('newReview');
      const form = document.getElementById("multiStepForm");

      if (newReviewBtn) {
        newReviewBtn.addEventListener('click', async () => {
          //reset the form and go back to subject selection
          form.reset();
          steps.forEach(step => {
            // step.classList.remove('active');
            step.classList.remove('active');
            if (!isAllStepActiveRemoved) {
              isAllStepActiveRemoved = true;
            }
          });
          if (isAllStepActiveRemoved) {
            // steps[0].classList.add("active");'
            currentStep = 1;
            steps[0].classList.add('active');
            // Update the browser's history state
            history.pushState({
              step: currentStep
            }, null, `?step=${currentStep}`);

            // Remove the review modal
            removeReviewModal();
            // Add text // Do you want to review another subject //
          }
        });
      }
    }

    function removeReviewModal() {
      document.getElementById('showReviewModal').classList.remove('active');
    }
  </script>
</body>

</html>