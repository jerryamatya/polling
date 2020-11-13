<?php

namespace GeniusSystems\Poll\Http\Controllers;
use Illuminate\Http\Request;

use GeniusSystems\Poll\Repositories\Interfaces\VoterInterface;
class VoterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $admin;
    public function __construct(VoterInterface $voter)
    {
        $this->voter=$voter;
    }

    public function castVote(Request $request){
       
        try {
            $this->validate($request, [
             
                'topic_id' => 'required',
                'votes' => 'required|array'
                
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => '422',
                'message' => $ex->response->original,
            ], 422);
        }
        $question_count=$this->voter->countQuestionsInTopic($request['topic_id']);
        $vote_count=count($request['votes']);
        if($question_count !=$vote_count ){
            return response()->json([
                'status' => '422',
                'message' => "Please vote in all the questions.",
            ], 422);
        }
        return $this->voter->castVote($request->all());


    }

    public function answer(Request $request){
        try {
            $this->validate($request, [
             
                'topic_id' => 'required',
                'answers' => 'required|array',
               
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => '422',
                'message' => $ex->response->original,
            ], 422);
        }
        $question_count=$this->voter->countQuestionsInTopic($request['topic_id']);
        
        $answer_count=count($request['answers']);
        if($question_count !=$answer_count ){
            return response()->json([
                'status' => '422',
                'message' => "Please answer all the questions.",
            ], 422);
        }
        return $this->voter->answer($request->all());


    }


}
