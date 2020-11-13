<?php

namespace  GeniusSystems\Poll\Http\Controllers;
use Illuminate\Http\Request;

use  GeniusSystems\Poll\Repositories\Interfaces\AdminInterface;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $admin;
    public function __construct(AdminInterface $admin)
    {
        $this->admin=$admin;
    }

    public function createTopic(Request $request){
        try {
            $this->validate($request, [
             
                'name' => 'required',
                'type' => 'required|in:poll,quiz',
                'start_at'=>'required',
                'expires_at'=>'required'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => '422',
                'message' => $ex->response->original,
            ], 422);
        }

        $topic=$this->admin->createTopic($request);
        return response()->json([
            'status' => '200',
            'message' => "Successfully created",
        ], 200);
        
    }
    public function updateTopic($id,Request $request){
        try {
            $this->validate($request, [
             
                'name' => 'required',
                'type' => 'required|in:poll,quiz',
                'start_at'=>'required',
                'expires_at'=>'required'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => '422',
                'message' => $ex->response->original,
            ], 422);
        }

        $topic=$this->admin->updateTopic($id,$request->all());
        return response()->json([
            'status' => '200',
            'message' => "Successfully updated",
        ], 200);
    }
    public function deleteTopic($id){
        $topic=$this->admin->deleteTopic($id);
        return response()->json([
            'status' => '200',
            'message' => "Successfully deleted",
        ], 200);
    }

    public function topics(Request $request){
        return $topic=$this->admin->getTopics($request->all());
    }


    public function createQuestion(Request $request){

        try {
            $this->validate($request, [
                'topic_id'=>'required',
                'name' => 'required',
                
                'type' => 'required|in:option,text',
                'options'=>'required_if:type,==,option',
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => '422',
                'message' => $ex->response->original,
            ], 422);
        }
        
       $this->admin->createQuestion($request);
       return response()->json([
        "status" => "200",
        "message" => "question created succesfully",
         ], 200);

    }

    public function updateQuestion($id,Request $request){
    
        try {
            $this->validate($request, [
                'topic_id'=>'required',
                
                'name' => 'required',
                'type' => 'required|in:option,text'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => '422',
                'message' => $ex->response->original,
            ], 422);
        }

        $topic=$this->admin->updateQuestion($id,$request->all());
        return response()->json([
            'status' => '200',
            'message' => "Successfully updated",
        ], 200);
    }

    public function deleteQuestion($id){
        $topic=$this->admin->deleteQuestion($id);
        return response()->json([
            'status' => '200',
            'message' => "Successfully deleted",
        ], 200);
    }

    public function topicWiseQuestions($id){
        
        return $topic=$this->admin->getQuestionByTopicId($id);
    }

    public function getNumberofVotes($questionId){
      
        return $votes=$this->admin->getNumberOfVotes($questionId);
    }

    public function getQuestionsAnswers($questionId){
        return $votes=$this->admin->getQuestionsAnswers($questionId);
    }


    public function updateOption($id,Request $request){
       
        try {
            $this->validate($request, [
              
                
                'name' => 'required',
              
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => '422',
                'message' => $ex->response->original,
            ], 422);
        }

        $topic=$this->admin->updateOption($id,$request->all());
        return response()->json([
            'status' => '200',
            'message' => "Successfully updated",
        ], 200);
    }

    public function deleteOption($id){
        $topic=$this->admin->deleteOption($id);
        return response()->json([
            'status' => '200',
            'message' => "Successfully deleted",
        ], 200);
    }

    public function getImage($type,$id){
        return $image=$this->admin->getImage($type,$id);
    }
}
