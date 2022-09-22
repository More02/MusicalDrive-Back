<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require_once '../includes/DbOperation.php';
mb_internal_encoding("UTF-8");
//Creating a new app with the config to show errors
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);


//registering a new user
$app->post('/register', function (Request $request, Response $response) {
    if (isTheseParametersAvailable(array('name', 'email', 'password'))) {
        $requestData = $request->getParsedBody();
        $name = $requestData['name'];
        $email = $requestData['email'];
        $password = $requestData['password'];
        $db = new DbOperation();
        $responseData = array();

        $result = $db->registerUser($name, $email, $password);

        if ($result == USER_CREATED) {
            $responseData['error'] = false;
            $responseData['message'] = 'Регистрация прошла успешно';
            $responseData['user'] = $db->getUserByEmail($email);
        } elseif ($result == USER_CREATION_FAILED) {
            $responseData['error'] = true;
            $responseData['message'] = 'При регистрации произошла ошибка';
        } elseif ($result == USER_EXIST) {
            $responseData['error'] = true;
            $responseData['message'] = 'Пользователь с данным email уже существует';
        }

        $response->getBody()->write(json_encode($responseData));
    }
});

//добавление музыки
$app->post('/addMusic', function (Request $request, Response $response) {
	if (isTheseParametersAvailable(array('name_music', 'id_user', 'path'))) {
		$requestData = $request->getParsedBody();
		$id_user = $requestData['id_user'];
		$name_music = $requestData['name_music'];
		$path_music = $requestData['path'];
		$db = new DbOperation();
		$responseData = array();
		
		$result_music = $db->addMusic($name_music, $id_user, $path_music);
		
		if ($result_music == USER_CREATED) {
			$responseData['error'] = false;
			$responseData['message'] = 'Аудиозапись успешно добавлена';
			$responseData['music'] = $db->getMusicByIdUser($name_music);
		} else if ($result_music == USER_CREATION_FAILED) {
            $responseData['error'] = true;
            $responseData['message'] = 'При добавлении аудиозаписи произошла ошибка';
			
        }
		$response->getBody()->write(json_encode($responseData));
	}
	
});


$app->post('/podpiska', function (Request $request, Response $response) {
	if (isTheseParametersAvailable(array('id_user1', 'id_user2'))) {
		$requestData = $request->getParsedBody();
		$id_user1 = $requestData['id_user1'];
		$id_user2 = $requestData['id_user2'];
		$db = new DbOperation();
		$responseData = array();
		
		$result_music = $db->podpiska($id_user1, $id_user2);
		
		if ($result_music == USER_CREATED) {
			$responseData['error'] = false;
			$responseData['message'] = 'Подписка успешно добавлена';
		} else if ($result_music == USER_CREATION_FAILED) {
            $responseData['error'] = true;
            $responseData['message'] = 'При добавлении подписки произошла ошибка';
		}
		else {
			 $responseData['error'] = true;
           $responseData['message'] = 'Подписка уже добавлена';
		}
        }
		$response->getBody()->write(json_encode($responseData));
	});
	
$app->post('/otpiska', function (Request $request, Response $response) {
	if (isTheseParametersAvailable(array('id_user1', 'id_user2'))) {
		$requestData = $request->getParsedBody();
		$id_user1 = $requestData['id_user1'];
		$id_user2 = $requestData['id_user2'];
		$db = new DbOperation();
		$responseData = array();
		
		$result_music = $db->otpiska($id_user1, $id_user2);
		
		if ($result_music == USER_CREATED) {
			$responseData['error'] = false;
			$responseData['message'] = 'Подписка успешно снята';
		} else if ($result_music == USER_CREATION_FAILED) {
            $responseData['error'] = true;
            $responseData['message'] = 'При снятии подписки произошла ошибка';
		}
		else {
			 $responseData['error'] = true;
           $responseData['message'] = 'Подписки не было';
		}
        }
		$response->getBody()->write(json_encode($responseData));
	});

$app->post('/addLike', function (Request $request, Response $response) {
	if (isTheseParametersAvailable(array('id_music', 'id_user'))) {
		$requestData = $request->getParsedBody();
		$id_music = $requestData['id_music'];
		$id_user = $requestData['id_user'];
		$db = new DbOperation();
		$responseData = array();
		
		$result_music = $db->addLike($id_music, $id_user);
		
		if ($result_music == USER_CREATED) {
			$responseData['error'] = false;
			$responseData['message'] = 'Лайк успешно добавлен';
		} else if ($result_music == USER_CREATION_FAILED) {
            $responseData['error'] = true;
            $responseData['message'] = 'При добавлении лайка произошла ошибка';
		}
		else {
			 $responseData['error'] = true;
           $responseData['message'] = 'Лайк уже поставлен';
		}
        }
		$response->getBody()->write(json_encode($responseData));
	});
	
$app->post('/deleteLike', function (Request $request, Response $response) {
	if (isTheseParametersAvailable(array('id_music', 'id_user'))) {
		$requestData = $request->getParsedBody();
		$id_music = $requestData['id_music'];
		$id_user = $requestData['id_user'];
		$db = new DbOperation();
		$responseData = array();
		
		$result_music = $db->deleteLike($id_music, $id_user);
		
		if ($result_music == USER_CREATED) {
			$responseData['error'] = false;
			$responseData['message'] = 'Лайк успешно удалён';
		} else if ($result_music == USER_CREATION_FAILED) {
            $responseData['error'] = true;
            $responseData['message'] = 'При удалении лайка произошла ошибка';
		}
		else {
			 $responseData['error'] = true;
           $responseData['message'] = 'Лайк уже поставлен';
		}
        }
		$response->getBody()->write(json_encode($responseData));
	});

$app->post('/updateMusic/{id}', function (Request $request, Response $response) {
	if (isTheseParametersAvailable(array('name_music', 'id_user', 'path', 'likei'))) {
		$music_id = $request->getAttribute('id');
		$requestData = $request->getParsedBody();
		$id_user = $requestData['id_user'];
		$name_music = $requestData['name_music'];
		$path_music = $requestData['path'];
		$likei = $requestData['likei'];
		$db = new DbOperation();
		$responseData = array();
		
		$result_music = $db->updateMusic($name_music, $id_user, $path_music, $likei ,$music_id);
		
		if ($result_music == USER_CREATED) {
			$responseData['error'] = false;
			$responseData['message'] = 'Обновление прошло успешно';
			$responseData['music'] = $db->getMusicById($music_id);
		} else if ($result_music == USER_CREATION_FAILED) {
            $responseData['error'] = true;
            $responseData['message'] = 'При обновлении произошла ошибка';
			
        }
		$response->getBody()->write(json_encode($responseData));
	}
	
});

$app->post('/updateLogin/{id}', function (Request $request, Response $response) {
	if (isTheseParametersAvailable(array('name'))) {
		$id = $request->getAttribute('id');
		$requestData = $request->getParsedBody();
		$name = $requestData['name'];
		$db = new DbOperation();
		$responseData = array();
		
		$result_music = $db->updateLogin($id, $name);
		
		if ($result_music == USER_CREATED) {
			$responseData['error'] = false;
			$responseData['message'] = 'Логин изменён';
		} else if ($result_music == USER_CREATION_FAILED) {
            $responseData['error'] = true;
            $responseData['message'] = 'При изменении логина возникла ошибка';
			
        }
		$response->getBody()->write(json_encode($responseData));
	}
	
});


//user login route
$app->post('/login', function (Request $request, Response $response) {
    if (isTheseParametersAvailable(array('email', 'password'))) {
        $requestData = $request->getParsedBody();
        $email = $requestData['email'];
        $password = $requestData['password'];

        $db = new DbOperation();

        $responseData = array();

        if ($db->userLogin($email, $password)) {
            $responseData['error'] = false;
            $responseData['user'] = $db->getUserByEmail($email);
        } else {
            $responseData['error'] = true;
            $responseData['message'] = 'Неверный email или пароль';
        }

        $response->getBody()->write(json_encode($responseData));
    }
});

//getting all users
$app->get('/users', function (Request $request, Response $response) {
    $db = new DbOperation();
    $users = $db->getAllUsers();
    $response->getBody()->write(json_encode(array("users" => $users)));
});

//getting messages for a user
$app->get('/messages/{id}', function (Request $request, Response $response) {
    $userid = $request->getAttribute('id');
    $db = new DbOperation();
    $messages = $db->getMessages($userid);
    $response->getBody()->write(json_encode(array("messages" => $messages)));
});

$app->get('/likes/{id_music}/{id_user}', function (Request $request, Response $response) {
    $userid = $request->getAttribute('id_user');
	$musicid = $request->getAttribute('id_music');
    $db = new DbOperation();
    $like = $db->isLikeAdded($userid, $musicid);
	$response->getBody()->write(json_encode(array("likes" => $like)));
	});
	
$app->get('/podpiskas/{id_user1}/{id_user2}', function (Request $request, Response $response) {
    $userid1 = $request->getAttribute('id_user1');
	$userid2 = $request->getAttribute('id_user2');
    $db = new DbOperation();
    $podpiska = $db->isPodpiskaAdded($userid1, $userid2);
	$response->getBody()->write(json_encode(array("podpiskas" => $podpiska)));
	});
	
$app->get('/podpischiki/{id_user2}', function (Request $request, Response $response) {
	$userid2 = $request->getAttribute('id_user2');
    $db = new DbOperation();
    $podpischikes = $db->podpischiki($userid2);
	$response->getBody()->write(json_encode(array("users" => $podpischikes)));
	});
	
$app->get('/podpisci/{id_user1}', function (Request $request, Response $response) {
	$userid1 = $request->getAttribute('id_user1');
    $db = new DbOperation();
    $podpischikes = $db->podpischiki($userid1);
	$response->getBody()->write(json_encode(array("users" => $podpischikes)));
	});
	
$app->get('/news/{id_user1}', function (Request $request, Response $response) {
	$userid1 = $request->getAttribute('id_user1');
    $db = new DbOperation();
    $podpischikes = $db->news($userid1);
	$response->getBody()->write(json_encode(array("news" => $podpischikes)));
	});

$app->get('/musics/{id}', function (Request $request, Response $response) {
    $userid = $request->getAttribute('id');
    $db = new DbOperation();
    $musics = $db->getMusicsByIdUser($userid);
    $response->getBody()->write(json_encode(array("musics" => $musics)));
	
});

//updating a user
$app->post('/update/{id}', function (Request $request, Response $response) {
    if (isTheseParametersAvailable(array('name', 'email', 'password', 'gender'))) {
        $id = $request->getAttribute('id');

        $requestData = $request->getParsedBody();

        $name = $requestData['name'];
        $email = $requestData['email'];
        $password = $requestData['password'];
        $gender = $requestData['gender'];


        $db = new DbOperation();

        $responseData = array();

        if ($db->updateProfile($id, $name, $email, $password, $gender)) {
            $responseData['error'] = false;
            $responseData['message'] = 'Страница успешно обновлена';
            $responseData['user'] = $db->getUserByEmail($email);
        } else {
            $responseData['error'] = true;
            $responseData['message'] = 'Страница не обновлена';
        }

        $response->getBody()->write(json_encode($responseData));
    }
});


$app->get('/user/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $db = new DbOperation();
    $user = $db->getUserByName($name);
    $response->getBody()->write(json_encode(array("users" => $user)));
});


//sending message to user
$app->post('/sendmessage', function (Request $request, Response $response) {
    if (isTheseParametersAvailable(array('from', 'to', 'title', 'message'))) {
        $requestData = $request->getParsedBody();
        $from = $requestData['from'];
        $to = $requestData['to'];
        $title = $requestData['title'];
        $message = $requestData['message'];

        $db = new DbOperation();

        $responseData = array();

        if ($db->sendMessage($from, $to, $title, $message)) {
            $responseData['error'] = false;
            $responseData['message'] = 'Message sent successfully';
        } else {
            $responseData['error'] = true;
            $responseData['message'] = 'Could not send message';
        }

        $response->getBody()->write(json_encode($responseData));
    }
});

//function to check parameters
function isTheseParametersAvailable($required_fields)
{
    $error = false;
    $error_fields = "";
    $request_params = $_REQUEST;

    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        $response = array();
        $response["error"] = true;
        $response["message"] = 'Необходимые данные ' . substr($error_fields, 0, -2) . ' не внесены';
        echo json_encode($response);
        return false;
    }
    return true;
}



$app->run();