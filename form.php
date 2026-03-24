<?php

$nameErr = $emailErr = $websiteErr = $genderErr = $phoneErr = $passwordErr = $confirmPasswordErr = $termsErr = "";


$name = $email = $website = $comment = $gender = $phone = "";
$password = $confirmPassword = "";
$terms = "";
$submitted = false;


$attempt = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submitted = true;

    
    $attempt = isset($_POST["attempt"]) ? (int)$_POST["attempt"] + 1 : 1;

    
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
        }
    }

    
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    
    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
    } else {
        $phone = test_input($_POST["phone"]);
        if (!preg_match("/^[+]?[0-9 \-]{7,15}$/", $phone)) {
            $phoneErr = "Invalid phone format";
        }
    }

    
    if (!empty($_POST["website"])) {
        $website = test_input($_POST["website"]);
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $websiteErr = "Invalid URL format";
        }
    }

    
    $comment = empty($_POST["comment"]) ? "" : test_input($_POST["comment"]);

    
    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
    }

    
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters long";
        }
    }

    
    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Confirm Password is required";
    } else {
        $confirmPassword = test_input($_POST["confirm_password"]);
        if ($password !== $confirmPassword) {
            $confirmPasswordErr = "Passwords do not match";
        }
    }

    
    if (!isset($_POST["terms"])) {
        $termsErr = "You must agree to the terms and conditions";
    } else {
        $terms = "checked";
    }
}


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


$formValid = $submitted &&
    empty($nameErr) &&
    empty($emailErr) &&
    empty($phoneErr) &&
    empty($websiteErr) &&
    empty($genderErr) &&
    empty($passwordErr) &&
    empty($confirmPasswordErr) &&
    empty($termsErr);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Form Validation</title>
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-color: #f9fafb;
            --card-bg: #ffffff;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --error-red: #ef4444;
            --success-green: #10b981;
            --border-color: #e5e7eb;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .form-container {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 550px;
        }

        h2 {
            margin-top: 0;
        }

        .field-row {
            margin-bottom: 18px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="password"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            box-sizing: border-box;
        }

        .radio-group {
            display: flex;
            gap: 15px;
        }

        .error {
            color: var(--error-red);
            font-size: 0.9rem;
            margin-top: 4px;
            display: block;
        }

        .success-box, .output-box {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
        }

        .success-box {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .output-box {
            background-color: #f3f4f6;
            border: 1px solid var(--border-color);
        }

        button {
            width: 100%;
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: var(--primary-hover);
        }

        .attempt-box {
            margin-bottom: 15px;
            color: var(--text-muted);
            font-size: 0.95rem;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Get in Touch</h2>
    <p>Fields marked with <span style="color:red">*</span> are required.</p>

    <div class="attempt-box">
        Submission attempt: <?= $attempt ?>
    </div>

    <?php if ($formValid): ?>
        <div class="success-box">
            Form submitted successfully!
        </div>
    <?php endif; ?>

    <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
        <input type="hidden" name="attempt" value="<?= $attempt ?>">

        <div class="field-row">
            <label for="name">Name <span style="color:red">*</span></label>
            <input type="text" id="name" name="name" value="<?= $name ?>">
            <?php if ($nameErr): ?><span class="error"><?= $nameErr ?></span><?php endif; ?>
        </div>

        <div class="field-row">
            <label for="email">E-mail <span style="color:red">*</span></label>
            <input type="text" id="email" name="email" value="<?= $email ?>">
            <?php if ($emailErr): ?><span class="error"><?= $emailErr ?></span><?php endif; ?>
        </div>

        <div class="field-row">
            <label for="phone">Phone Number <span style="color:red">*</span></label>
            <input type="text" id="phone" name="phone" value="<?= $phone ?>">
            <?php if ($phoneErr): ?><span class="error"><?= $phoneErr ?></span><?php endif; ?>
        </div>

        <div class="field-row">
            <label for="website">Website</label>
            <input type="text" id="website" name="website" value="<?= $website ?>">
            <?php if ($websiteErr): ?><span class="error"><?= $websiteErr ?></span><?php endif; ?>
        </div>

        <div class="field-row">
            <label for="comment">Comment</label>
            <textarea id="comment" name="comment"><?= $comment ?></textarea>
        </div>

        <div class="field-row">
            <label>Gender <span style="color:red">*</span></label>
            <div class="radio-group">
                <label><input type="radio" name="gender" value="Female" <?= ($gender == "Female") ? "checked" : "" ?>> Female</label>
                <label><input type="radio" name="gender" value="Male" <?= ($gender == "Male") ? "checked" : "" ?>> Male</label>
                <label><input type="radio" name="gender" value="Other" <?= ($gender == "Other") ? "checked" : "" ?>> Other</label>
            </div>
            <?php if ($genderErr): ?><span class="error"><?= $genderErr ?></span><?php endif; ?>
        </div>

        <div class="field-row">
            <label for="password">Password <span style="color:red">*</span></label>
            <input type="password" id="password" name="password">
            <?php if ($passwordErr): ?><span class="error"><?= $passwordErr ?></span><?php endif; ?>
        </div>

        <div class="field-row">
            <label for="confirm_password">Confirm Password <span style="color:red">*</span></label>
            <input type="password" id="confirm_password" name="confirm_password">
            <?php if ($confirmPasswordErr): ?><span class="error"><?= $confirmPasswordErr ?></span><?php endif; ?>
        </div>

        <div class="field-row">
            <label>
                <input type="checkbox" name="terms" <?= $terms ?>>
                I agree to the terms and conditions <span style="color:red">*</span>
            </label>
            <?php if ($termsErr): ?><span class="error"><?= $termsErr ?></span><?php endif; ?>
        </div>

        <button type="submit">Send Message</button>
    </form>

    <div class="output-box">
        <?php if ($submitted && $formValid): ?>
            <h3>Your Input:</h3>
            <p><strong>Name:</strong> <?= $name ?></p>
            <p><strong>E-mail:</strong> <?= $email ?></p>
            <p><strong>Phone:</strong> <?= $phone ?></p>
            <?php if (!empty($website)): ?><p><strong>Website:</strong> <?= $website ?></p><?php endif; ?>
            <?php if (!empty($comment)): ?><p><strong>Comment:</strong> <?= $comment ?></p><?php endif; ?>
            <p><strong>Gender:</strong> <?= $gender ?></p>
        <?php elseif ($submitted && !$formValid): ?>
            <p style="color:red; margin:0;">Please fix the errors and try again.</p>
        <?php else: ?>
            <p style="margin:0; font-style: italic;">Results will appear here after submission.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
