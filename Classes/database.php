<?php
class database {
    function opencon() {
        return new PDO('mysql:host=localhost;dbname=loginmethod','root','');
    }

    function check($username, $password) {
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT * FROM users WHERE Username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['Pass_word'])) {
            return $user;
        }
        return false;
    }

    function SignUpser($username, $password, $firstname, $lastname, $birthday, $sex){
        $con = $this->opencon();

        $query = $con->prepare("SELECT Username FROM users WHERE Username = ?");
        $query->execute([$username]);
        $existingUser = $query->fetch();

        if ($existingUser){
            return false; // User already exists
        }

        $stmt = $con->prepare("INSERT INTO users (Username, Pass_word, firstname, lastname, birthday, sex) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$username, $password, $firstname, $lastname, $birthday, $sex]);
    }

    function insertAddress($user_id, $street, $barangay, $city, $province) {
        $con = $this->opencon();
        return $con->prepare("INSERT INTO user_address (UserID, user_add_street, user_add_barangay, user_add_city, user_add_province) VALUES (?, ?, ?, ?, ?)")->execute([$user_id, $street, $barangay, $city, $province]);
    }

    function view(){
        $con = $this->opencon();
        return $con->query("SELECT users.UserID, users.firstname, users.lastname, users.birthday, users.sex, users.Username, users.Pass_word, users.user_profile_picture,
        CONCAT(user_address.user_add_street,' ', user_address.user_add_barangay,' ', user_address.user_add_city,' ', user_address.user_add_province)
        AS address FROM users JOIN user_address ON users.UserID=user_address.UserID;")->fetchAll();
    }

    function Delete($id){
        try{
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("DELETE FROM user_address WHERE UserID = ?");
            $query->execute([$id]);
            $query2 = $con->prepare("DELETE FROM users WHERE UserID = ?");
            $query2->execute([$id]);

            $con->commit();
            return true;
        } catch (PDOException $e){
            $con->rollBack();
            return false;
        }
    }

    function viewdata($id){
        try{
            $con = $this->opencon();
            $query = $con->prepare("SELECT users.UserID, users.firstname, users.lastname, users.birthday, users.sex, users.Username, users.Pass_word, user_address.user_add_street, user_address.user_add_barangay, user_address.user_add_city, user_address.user_add_province, users.user_profile_picture FROM users JOIN user_address ON users.UserID = user_address.UserID WHERE users.UserID=?");
            $query->execute([$id]);
            return $query->fetch();

        } catch (PDOException $e){
            return [];
        }  
    }

    function updateUser($user_id, $firstname, $lastname, $birthday, $sex, $username, $password) {
        try {
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("UPDATE users SET firstname=?, lastname=?, birthday=?, sex=?, Username=?, Pass_word=? WHERE UserID=?");
            $query->execute([$firstname, $lastname, $birthday, $sex, $username, $password, $user_id]);
            $con->commit();
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }

    function updateUserAddress($user_id, $street, $barangay, $city, $province) {
        try {
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("UPDATE user_address SET user_add_street=?, user_add_barangay=?, user_add_city=?, user_add_province=? WHERE UserID=?");
            $query->execute([$street, $barangay, $city, $province, $user_id]);
            $con->commit();
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }

    function signupUser($tenantFN, $tenantLN, $sex, $number, $profilePicture){
        $con = $this->opencon();
        // Save user data along with profile picture path to the database
        $stmt = $con->prepare("INSERT INTO users (Tfirstname, Tlastname, sex, number, user_profile_picture) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$tenantFN, $tenantLN, $sex, $number, $profilePicture]);
        return $con->lastInsertId();
    }

    function validateCurrentPassword($userId, $currentPassword) {
        $con = $this->opencon();
        $query = $con->prepare("SELECT Pass_word FROM users WHERE UserID = ?");
        $query->execute([$userId]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($currentPassword, $user['Pass_word'])) {
            return true;
        }
        return false;
    }

    function updatePassword($userId, $hashedPassword) {
        try {
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("UPDATE users SET Pass_word = ? WHERE UserID = ?");
            $query->execute([$hashedPassword, $userId]);
            $con->commit();
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }

    function updateUserProfilePicture($userID, $profilePicturePath) {
        try {
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("UPDATE users SET user_profile_picture = ? WHERE UserID = ?");
            $query->execute([$profilePicturePath, $userID]);
            $con->commit();
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }
}
?>