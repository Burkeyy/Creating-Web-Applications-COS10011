<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Quiz" />
  <meta name="keywords" content="Canvas, University, Education" />
  <meta name="author" content="Anthony Burke" />
  <title>What is Canvas?</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet" />
  <link href="styles/style.css" rel="stylesheet" type="text/css" />
  <script src="scripts/quiz.js"></script>
  <script src="scripts/enhancements.js"></script>
  <script src="scripts/enhancements2.js"></script>
</head>

<body>
  <?php
  include_once "header&menu.inc";
  ?>

  <h1>Canvas Form and Quiz</h1>

  <form id="quizform" method="post" action="markquiz.php" novalidate="novalidate">
    <fieldset>
      <legend>Student Details</legend>
      <p>
        <label for="stuID">Student Number</label>
        <input type="text" name="stuID" id="stuID" size="10" pattern="[0-9]{7}([0-9]{3})?" required="required" />
      </p>
      <p>
        <label for="GivenName">Given Name</label>
        <input name="GivenName" id="GivenName" maxlength="25" pattern="[a-zA-Z- ]{1,25}" required="required" />

        <label for="FamName">Family Name</label>
        <input type="text" name="FamName" id="FamName" maxlength="25" pattern="[a-zA-Z]{1,25}" size="10" required="required" />
      </p>
    </fieldset>

    <h2>Quiz</h2>

    <h3>Time Remaining: <span id="timeDisplay">200</span> (Seconds)</h3>

    <fieldset id="q1Answer">
      <legend>Q1</legend>
      <p>What is one other product created by Instructure?</p>
      <p>
        <input type="radio" id="Pathway" name="q1Answer" value="Pathway" />
        <label for="Pathway">Pathway</label>

        <input type="radio" id="CanvasK-9" name="q1Answer" value="CanvasK-9" />
        <label for="CanvasK-9">Canvas K-9</label>

        <input type="radio" id="Bridge" name="q1Answer" value="Bridge" required="required" />
        <label for="Bridge">Bridge</label>
      </p>
    </fieldset>

    <fieldset>
      <legend>Q2</legend>

      <p>
        <label for="competitor">What competitor was mentioned on the site?</label>
        <select name="Q2" id="competitor" required>
          <option value="" selected="selected">Please Select</option>
          <option value="TalentLMS">TalentLMS</option>
          <option value="Edmodo">Edmodo</option>
          <option value="Google Class">Google Class</option>
          <option value="Moodle">Moodle</option>
        </select>
      </p>
    </fieldset>

    <fieldset id="q3Answer">
      <legend>Q3</legend>

      <p>Who does Canvas benefit? (Two correct answers)</p>

      <p>
        <label for="students">Students</label>
        <input type="checkbox" id="students" name="q3[0]" value="students" />

        <label for="educators">Educators</label>
        <input type="checkbox" id="educators" name="q3[1]" value="educators" />

        <label for="pets">Pets</label>
        <input type="checkbox" id="pets" name="q3[2]" value="pets" />
      </p>
    </fieldset>

    <fieldset>
      <legend>Q4</legend>
      <p>
        <label for="Q4">What does LMS stand for?</label><br />
        <textarea id="Q4" name="Q4" rows="4" cols="40" placeholder="Write answer..." required="required"></textarea>
      </p>
    </fieldset>

    <fieldset>
      <legend>Q5</legend>
      <p>What year was Instructure formed?</p>
      <label for="Date">Date</label>
      <input type="text" name="Q5" id="Date" pattern="\d{4}" maxlength="4" size="10" placeholder="yyyy" required="required" />
    </fieldset>

    <input id="submit" type="submit" name="submit" value="Submit" />
  </form>

  <?php
  include_once "footer.inc";
  ?>
</body>

</html>