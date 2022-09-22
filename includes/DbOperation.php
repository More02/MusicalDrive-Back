<?php

class DbOperation
{
    private $con;

    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect();
        $this->con = $db->connect();
    }

    //Method to create a new user
    function registerUser($name, $email, $pass)
    {
        if (!$this->isUserExist($email)) {
            $password = md5($pass);
            $stmt = $this->con->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $password);
            if ($stmt->execute())
                return USER_CREATED;
            return USER_CREATION_FAILED;
        }
        return USER_EXIST;
    }

    //Method for user login
    function userLogin($email, $pass)
    {
        $password = md5($pass);
        $stmt = $this->con->prepare("SELECT id FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    //Method to send a message to another user
    function sendMessage($from, $to, $title, $message)
    {
        $stmt = $this->con->prepare("INSERT INTO messages (from_users_id, to_users_id, title, message) VALUES (?, ?, ?, ?);");
        $stmt->bind_param("iiss", $from, $to, $title, $message);
        if ($stmt->execute())
            return true;
        return false;
    }

    //Method to update profile of user
    function updateProfile($id, $name, $email, $pass)
    {
        $password = md5($pass);
        $stmt = $this->con->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $email, $password,$id);
        if ($stmt->execute())
            return true;
        return false;
    }

    //Method to get messages of a particular user
    function getMessages($userid)
    {
        $stmt = $this->con->prepare("SELECT messages.id, (SELECT users.name FROM users WHERE users.id = messages.from_users_id) as `from`, (SELECT users.name FROM users WHERE users.id = messages.to_users_id) as `to`, messages.title, messages.message, messages.sentat FROM messages WHERE messages.to_users_id = ? ORDER BY messages.sentat DESC;");
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $stmt->bind_result($id, $from, $to, $title, $message, $sent);

        $messages = array();

        while ($stmt->fetch()) {
            $temp = array();

            $temp['id'] = $id;
            $temp['from'] = $from;
            $temp['to'] = $to;
            $temp['title'] = $title;
            $temp['message'] = $message;
            $temp['sent'] = $sent;

            array_push($messages, $temp);
        }

        return $messages;
    }

    //Method to get user by email
    function getUserByEmail($email)
    {
        $stmt = $this->con->prepare("SELECT id, name, email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id, $name, $email);
        $stmt->fetch();
        $user = array();
        $user['id'] = $id;
        $user['name'] = $name;
        $user['email'] = $email;
        return $user;
    }

    //Method to get all users
    function getAllUsers(){
        $stmt = $this->con->prepare("SELECT id, name, email FROM users");
        $stmt->execute();
        $stmt->bind_result($id, $name, $email);
        $users = array();
        while($stmt->fetch()){
            $temp = array();
            $temp['id'] = $id;
            $temp['name'] = $name;
            $temp['email'] = $email;
            array_push($users, $temp);
        }
        return $users;
    }

    //Method to check if email already exist
    function isUserExist($email)
    {
        $stmt = $this->con->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
	
	
	
	 function addMusic($name_music, $id_user, $path_music)
    {
            $stmt = $this->con->prepare("INSERT INTO music (name_music, id_user, path,date_music) VALUES (?, ?, ?, now())");
            $stmt->bind_param("sis", $name_music, $id_user, $path_music);
            if ($stmt->execute())
                return USER_CREATED;
            return USER_CREATION_FAILED;
    }
	
	 function isLikeAdded($id_user, $id_music)
    {
        $stmt = $this->con->prepare("SELECT id_like,id_music,id_user FROM likes WHERE id_user = ? and id_music = ?");
        $stmt->bind_param("ii", $id_user, $id_music);
        $stmt->execute();
		$stmt->bind_result($id_like,$id_music,$id_user);
		$music = array();
		 while($stmt->fetch()){
            $temp = array();
			$temp['id_likei'] = $id_like;
			$temp['id_music'] = $id_music;
			$temp['id_user'] = $id_user;
            array_push($music, $temp);
        }
        return $music;
		
    }
	
	function news($userid)
	{
		$stmt = $this->con->prepare("SELECT podpiska.id_user2,users.name,music.name_music,music.path,music.date_music FROM podpiska INNER JOIN (music INNER JOIN users on music.id_user=users.id) ON podpiska.id_user2=music.id_user WHERE podpiska.id_user1=? ORDER BY music.date_music desc ");
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $stmt->bind_result($id_user2,$name,$name_music,$path,$date);

        $messages = array();

        while ($stmt->fetch()) {
            $temp = array();

            $temp['id_user'] = $id_user2;
            $temp['name'] = $name;
            $temp['name_music'] = $name_music; 
			$temp['path'] = $path;
            $temp['date_music'] = $date;

            array_push($messages, $temp);
        }

        return $messages;
	}
	
	 function isPodpiskaAdded($id_user1, $id_user2)
    {
        $stmt = $this->con->prepare("SELECT id_podpiska,id_user1,id_user2 FROM podpiska WHERE id_user1 = ? and id_user2 = ?");
        $stmt->bind_param("ii", $id_user1, $id_user2);
        $stmt->execute();
		$stmt->bind_result($id_podpiska,$id_user1,$id_user2);

      
        $temp['id_podpiska'] = $id_podpiska;
        $temp['id_user1'] = $id_user1;
		$temp['id_user2'] = $id_user2;
		
		$podpiska = array();
		 while($stmt->fetch()){
            $temp = array();
			$temp['id_podpiska'] = $id_podpiska;
			$temp['id_user1'] = $id_user1;
			$temp['id_user2'] = $id_user2;
            array_push($podpiska, $temp);
        }
        return $podpiska;
		
    }
	 
	 
	 
	 
	 function addLike($id_music, $id_user)
    {
		 if (!$this->isLikeAdded($id_user,$id_music)) {
            $stmt = $this->con->prepare("INSERT INTO likes (id_music, id_user) VALUES (?, ?)");
            $stmt->bind_param("ii", $id_music, $id_user);
            if ($stmt->execute())
                return USER_CREATED;
            return USER_CREATION_FAILED;
		 }
		  return USER_EXIST;
    }
	
	function deleteLike($id_music, $id_user)
    {
		 
            $stmt = $this->con->prepare("DELETE FROM likes where id_music=? and id_user=?");
            $stmt->bind_param("ii", $id_music, $id_user);
            if ($stmt->execute())
                return USER_CREATED;
            return USER_CREATION_FAILED;
		 
		
    }
	
	
	
	 function podpiska($id_user1, $id_user2)
    {
		$stmt = $this->con->prepare("INSERT INTO podpiska (id_user1, id_user2, data_podpiska) VALUES (?, ?, now())");
        $stmt->bind_param("ii", $id_user1, $id_user2);
        if ($stmt->execute())
            return USER_CREATED;
        return USER_CREATION_FAILED;
	}
	
	 function otpiska($id_user1, $id_user2)
    {
		$stmt = $this->con->prepare("DELETE FROM podpiska WHERE id_user1 = ? and id_user2 = ?");
        $stmt->bind_param("ii", $id_user1, $id_user2);
        if ($stmt->execute())
            return USER_CREATED;
        return USER_CREATION_FAILED;
	}
	
	
	
	
	 function updateMusic($name_music, $id_user, $path_music, $likei, $id_music)
    {
            $stmt = $this->con->prepare("UPDATE music SET name_music = ?, id_user = ?, path = ?, likei = ? where id_music = ?");
            $stmt->bind_param("sisii", $name_music, $id_user, $path_music, $likei, $id_music);
            if ($stmt->execute())
                return USER_CREATED;
            return USER_CREATION_FAILED;
    }
	
	function updateLogin($id, $name)
    {
            $stmt = $this->con->prepare("UPDATE users SET name = ? where id = ?");
            $stmt->bind_param("is", $id, $name);
            if ($stmt->execute())
                return USER_CREATED;
            return USER_CREATION_FAILED;
    }
	
	function getMusicByIdUser($name_music)
    {
        $stmt = $this->con->prepare("SELECT id_music, path, id_user FROM music WHERE name_music = ?");
        $stmt->bind_param("s", $name_music);
        $stmt->execute();
        $stmt->bind_result($id_music, $path, $id_user);
        $stmt->fetch();
        $music = array();
        $music['id_music'] = $id_music;
        $music['path'] = $path;
        $music['id_user'] = $id_user;
        return $music;
    }
	
	function podpischiki($id_user2)
    {
        $stmt = $this->con->prepare("SELECT users.name,podpiska.id_user1 FROM podpiska INNER JOIN users on users.id=podpiska.id_user1 WHERE id_user2 = ?");
        $stmt->bind_param("i", $id_user2);
        $stmt->execute();
        $stmt->bind_result($name, $id_user);
		$podpiska = array();
		 while($stmt->fetch()){
            $temp = array();
			$temp['name'] = $name;
            $temp['id_user'] = $id_user;
            array_push($podpiska, $temp);
        }
        return $podpiska;
    }
	
	function podpisci($id_user1)
    {
        $stmt = $this->con->prepare("SELECT users.name,podpiska.id_user2 FROM podpiska inner join users on users.id=podpiska.id_user2 WHERE id_user1 = ?");
        $stmt->bind_param("i", $id_user1);
        $stmt->execute();
        $stmt->bind_result($name, $id_user);
		$podpiska = array();
		 while($stmt->fetch()){
            $temp = array();
			$temp['name'] = $name;
            $temp['id_user'] = $id_user;
            array_push($podpiska, $temp);
        }
        return $podpiska;
    }
	
	function getMusicById($id_music)
    {
        $stmt = $this->con->prepare("SELECT id_music, name_music, id_user, path, likei FROM music WHERE id_music = ?");
        $stmt->bind_param("i", $id_music);
        $stmt->execute();
        $stmt->bind_result($id_music, $name_music, $id_user, $path, $likei);
        $stmt->fetch();
        $music = array();
        $music['id_music'] = $id_music;
		$music['name_music'] = $name_music;
		$music['id_user'] = $id_user;
        $music['path'] = $path;
		$music['likei'] = $likei;
        
        return $music;
    }
	
	function getLikeById($id_like)
    {
        $stmt = $this->con->prepare("SELECT id_music, id_user FROM likes WHERE id_like = ?");
        $stmt->bind_param("i", $id_like);
        $stmt->execute();
        $stmt->bind_result($id_music, $id_user);
        $stmt->fetch();
        $like = array();
        $like['id_music'] = $id_music;
        $like['id_user'] = $id_user;
        return $like;
    }
	
	function getMusicsByIdUser($id_user)
    {
        $stmt = $this->con->prepare("SELECT id_music,name_music,path,likei FROM music WHERE id_user=?");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $stmt->bind_result($id_music, $name_music, $path, $likei);
        $music = array();
		
		 while($stmt->fetch()){
            $temp = array();
			$temp['id_music'] = $id_music;
			$temp['path'] = $path;
			$temp['name_music'] = $name_music;
			$temp['id_user'] =  $id_user;
			$temp['likei'] = $likei;
            array_push($music, $temp);
        }
        return $music;
    }
	
	function getUserByName($name)
    {
        $stmt = $this->con->prepare("SELECT id, name, email FROM users WHERE  name= ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($id, $name, $email);
        $user = array();
		
		 while($stmt->fetch()){
            $temp = array();
			$temp['id'] = $id;
			$temp['name'] = $name;
			$temp['email'] = $email;
			array_push($user, $temp);
		 }
        return $user;
    }
	
	
}