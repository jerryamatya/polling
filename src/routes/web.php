<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->group(['prefix' => 'admins'], function () use ($router) {
    
    $router->get('topics', [
        'uses' => "AdminController@topics",
    ]);

    $router->post('topics', [
        'uses' => "AdminController@createTopic",
    ]);
    $router->put('topics/{id}', [
        'uses' => "AdminController@updateTopic",
    ]);
    $router->delete('topics/{id}', [
        'uses' => "AdminController@deleteTopic",
    ]);


    $router->post('topics/{topicid}/questions', [
        'uses' => "AdminController@createQuestion",
    ]);

    $router->put('topics/{topicid}/questions/{id}',[
        'uses' => "AdminController@updateQuestion",
    ]);
    
    $router->delete('topics/{topicid}/questions/{id}',[
        'uses' => "AdminController@deleteQuestion",
    ])  ;


    $router->put('topics/{topicid}/questions/{questionid}/options/{id}',[
        'uses' => "AdminController@updateOption",
    ]);
    
    $router->delete('topics/{topicid}/questions/{questionid}/options/{id}',[
        'uses' => "AdminController@deleteOption",
    ])  ;
   
    $router->get('topics/{topicid}/questions/{questionId}/answers', [
        'uses' => "AdminController@getQuestionsAnswers",
    ]);
    
});


$router->group(['prefix' => 'users'], function () use ($router) {
    $router->post('topics/{topicid}/votes', [
        'uses' => "VoterController@castVote",
    ]);
    $router->post('topics/{topicid}/answers', [
        'uses' => "VoterController@answer",
    ]);

});
$router->get('topics/{id}/questions', [
    'uses' => "AdminController@topicWiseQuestions",
]);
$router->get('/questions/{questionId}/votes', [
    'uses' => "AdminController@getNumberofVotes",
]);
$router->get('/images/{type}/{id}', [
    'uses' => "AdminController@getImage",
]);
