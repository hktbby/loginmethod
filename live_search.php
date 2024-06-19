<?php
require_once('classes/database.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['search'])) {
        $searchterm = $_POST['search']; 
        $con = new database();

        try {
            $connection = $con->opencon();
            
            // Check if the connection is successful
            if ($connection) {
                // SQL query with JOIN
              $query = $connection->prepare("SELECT users.UserID, users.firstname, users.lastname, users.birthday, users.sex, users.Username, users.user_profile_picture,
                CONCAT(user_add_city,', ', user_add_province)
                AS address FROM users INNER JOIN user_address ON users.UserID = user_address.UserID WHERE users.Username
                 LIKE ? OR users.UserID LIKE ? OR users.firstname LIKE ? OR CONCAT(user_add_city,', ', user_add_province) LIKE ? ");

                $query->execute(["%$searchterm%","%$searchterm%","%$searchterm%","%$searchterm%" ]);
                $users = $query->fetchAll(PDO::FETCH_ASSOC);

                // Generate HTML for table rows 
                $html = '';
                foreach ($users as $user) {
                    $html .= '<tr>';
                    $html .= '<td>' . $user['UserID'] . '</td>';
                    $html .= '<td><img src="' . htmlspecialchars($user['user_profile_picture']) . '" alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;"></td>';
                    $html .= '<td>' . $user['firstname'] . '</td>';
                    $html .= '<td>' . $user['lastname'] . '</td>';
                    $html .= '<td>' . $user['birthday'] . '</td>';
                    $html .= '<td>' . $user['sex'] . '</td>';
                    $html .= '<td>' . $user['Username'] . '</td>';
                    $html .= '<td>' . $user['address'] . '</td>';
                    $html .= '<td>'; // Action column
                    $html .= '<form action="update.php" method="post" style="display: inline;">';
                    $html .= '<input type="hidden" name="id" value="' . $user['UserID'] . '">';
                    $html .= '<button type="submit" class="btn btn-primary btn-sm">Edit</button>';
                    $html .= '</form>';
                    $html .= '<form method="POST" style="display: inline;">';
                    $html .= '<input type="hidden" name="id" value="' . $user['UserID'] . '">';
                    $html .= '<input type="submit" name="delete" class="btn btn-danger btn-sm" value="Delete" onclick="return confirm(\'Are you sure you want to delete this user?\')">';
                    $html .= '</form>';
                    $html .= '</td>';
                    $html .= '</tr>';
                }
                echo $html;
            } else {
                echo json_encode(['error' => 'Database connection failed.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'No search query provided.']);
    }
} 