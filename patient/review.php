<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="patient.css">
    <title>Write a Review</title>
    <style>
    .dash-body {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 30px;
    }

    .review-container {
        background-color: #f9f9f9;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: 80%;
        max-width: 600px;
    }

    .review-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }

    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
        font-size: 16px;
    }

    .submit-btn {
        background-color: #007bff;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .submit-btn:hover {
        background-color: #0056b3;
    }

    .submit-btn-disabled {
        background-color: #6c757d;
        cursor: not-allowed;
    }

    .submit-btn-disabled:hover {
        background-color: #6c757d;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .review-note {
        text-align: center;
        margin-top: 20px;
        color: #777;
        font-size: 0.9em;
        font-style: italic;
    }
    </style>
</head>

<?php

session_start();
require '../tresspass/connection.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if user is logged in
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("Location: ../tresspass/notresspass.php");
    exit(0);
}

$fname = $_SESSION['auth_user']['fname'];
$email = $_SESSION['auth_user']['email'];
$user_id = $_SESSION['auth_user']['user_id'] ?? null;

// Fetch lname from the database
$query_lname = "SELECT lname FROM patient WHERE email = ?";
$stmt_lname = $conn->prepare($query_lname);
if ($stmt_lname) {
    $stmt_lname->bind_param("s", $email);
    $stmt_lname->execute();
    $result_lname = $stmt_lname->get_result();
    if ($result_lname && $result_lname->num_rows == 1) {
        $row_lname = $result_lname->fetch_assoc();
        $lname = $row_lname['lname'];
    }
    $stmt_lname->close();
}

$review_message = "";
$review_type = "";
$has_reviewed = false;

// Check if the user has already submitted a review
if ($user_id !== null) {
    $check_review_query = "SELECT review_id FROM review WHERE user_id = ?";
    $check_review_stmt = $conn->prepare($check_review_query);
    if ($check_review_stmt) {
        $check_review_stmt->bind_param("i", $user_id);
        $check_review_stmt->execute();
        $check_review_result = $check_review_stmt->get_result();
        if ($check_review_result && $check_review_result->num_rows > 0) {
            $has_reviewed = true;
        }
        $check_review_stmt->close();
    } else {
        $review_message = "Error checking for existing review: " . $conn->error;
        $review_type = "danger";
    }
}

if (isset($_POST['submit_review']) && !$has_reviewed) {
    if ($user_id === null) {
        $review_message = "Error: User ID not found. Please log in again.";
        $review_type = "danger";
    } else {
        $message = trim($_POST['review_text']);

        if (empty($message)) {
            $review_message = "Please enter your review message.";
            $review_type = "danger";
        } else {
            $insert_query = "INSERT INTO review (user_id, message) VALUES (?, ?)";
            $insert_stmt = $conn->prepare($insert_query);

            if ($insert_stmt) {
                $insert_stmt->bind_param("is", $user_id, $message);
                if ($insert_stmt->execute()) {
                    $review_message = "Thank you for your review!";
                    $review_type = "success";
                    $has_reviewed = true; // Update the status after successful review
                } else {
                    $review_message = "Error saving your review: " . $insert_stmt->error;
                    $review_type = "danger";
                }
                $insert_stmt->close();
            } else {
                $review_message = "Error preparing review statement: " . $conn->error;
                $review_type = "danger";
            }
        }
    }
} elseif (isset($_POST['submit_review']) && $has_reviewed) {
    $review_message = "You have already submitted a review.";
    $review_type = "warning"; // Or "info" depending on your styling
}

?>

<body>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:1px; text-align: left;">
                                    <img src="../images/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo htmlspecialchars($fname . ' ' . $lname); ?></p>
                                    <p class="profile-subtitle"><?php echo htmlspecialchars($email); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php"><input type="button" value="Log out"
                                            class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-home">
                        <a href="index.php" class="non-style-link-menu">
                            <div>
                                <i class="fas fa-home"></i>
                                <p class="menu-text">Home</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session">
                        <a href="appointment.php" class="non-style-link-menu">
                            <div>
                                <i class="far fa-calendar-check"></i>
                                <p class="menu-text">Make an Appointment</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="record.php" class="non-style-link-menu">
                            <div>
                                <i class="fas fa-file-medical-alt"></i>
                                <p class="menu-text">My Record</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td
                        class="menu-btn menu-icon-review menu-active menu-icon-review-active <?php echo $has_reviewed ? 'menu-btn-disabled' : ''; ?>">
                        <a href="review.php"
                            class="non-style-link-menu <?php echo $has_reviewed ? 'link-disabled' : ''; ?>">
                            <div>
                                <i class="fas fa-star"></i>
                                <p class="menu-text">Review</p>
                            </div>
                        </a>
                    </td>
                </tr>
            </table>
        </div>

        <div class="dash-body">
            <div class="review-container">
                <h2>Share Your Experience</h2>
                <?php if ($review_message): ?>
                <div class="alert alert-<?php echo htmlspecialchars($review_type); ?>" role="alert">
                    <?php echo htmlspecialchars($review_message); ?>
                </div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="review_text">Your Review:</label>
                        <textarea id="review_text" name="review_text" rows="5"
                            placeholder="Tell us about your experience at the clinic."
                            <?php echo $has_reviewed ? 'disabled' : ''; ?>></textarea>
                    </div>
                    <button type="submit" name="submit_review"
                        class="submit-btn <?php echo $has_reviewed ? 'submit-btn-disabled' : ''; ?>"
                        <?php echo $has_reviewed ? 'disabled' : ''; ?>>Submit Review</button>
                </form>
                <p class="review-note">You can only write one review for our clinic, thank you.</p>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuButtons = document.querySelectorAll('.menu-btn');
        menuButtons.forEach(button => {
            button.addEventListener('click', function() {
                menuButtons.forEach(btn => {
                    btn.classList.remove('menu-active');
                    btn.classList.remove(btn.classList[1] + '-active');
                });
                this.classList.add('menu-active');
                this.classList.add(this.classList[1] + '-active');
            });
        });

        const reviewButton = document.querySelector('.menu-icon-review');
        if (reviewButton) {
            reviewButton.classList.add('menu-active');
            reviewButton.classList.add('menu-icon-review-active');
        }
    });



    (function() {
        if (!window.chatbase || window.chatbase("getState") !== "initialized") {
            window.chatbase = (...arguments) => {
                if (!window.chatbase.q) {
                    window.chatbase.q = []
                }
                window.chatbase.q.push(arguments)
            };
            window.chatbase = new Proxy(window.chatbase, {
                get(target, prop) {
                    if (prop === "q") {
                        return target.q
                    }
                    return (...args) => target(prop, ...args)
                }
            })
        }
        const onLoad = function() {
            const script = document.createElement("script");
            script.src = "https://www.chatbase.co/embed.min.js";
            script.id = "DpaevYyIB0fUF5fMsUmKN";
            script.domain = "www.chatbase.co";
            document.body.appendChild(script)
        };
        if (document.readyState === "complete") {
            onLoad()
        } else {
            window.addEventListener("load", onLoad)
        }
    })();
    </script>
</body>

</html>