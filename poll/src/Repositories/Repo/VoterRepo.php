<?php
namespace GeniusSystems\Poll\Repositories\Repo;
use GeniusSystems\Poll\Repositories\Interfaces\VoterInterface;
use App\Models\Topics;
use App\Models\Questions;
use App\Models\Options;
use App\Models\UserAnswer;
use App\Models\UserVote;

class VoterRepo implements VoterInterface
{
    private $topics;
    private $questions;
    public function __construct(Topics $topics,Questions $questions)
    {
        $this->topics = $topics;
        $this->questions = $questions;

    }

    public function castVote($data){
       
        $topic=$this->topics->where('id',$data['topic_id'])->first();
       
        if(date('Y-m-d H:i:s') > $topic['expires_at']){
            return response()->json([
                'status' => '422',
                'message' => "cannot cast vote because topic has expired.",
            ], 422);
        }
        
        foreach($data['votes'] as $userVote){
          
            $vote=new UserVote();
            $vote['topic_id']=$data['topic_id'];
            $vote['question_id']=$userVote['question_id'];
            $vote['option_id']=$userVote['option_id'];
            $vote->save();
        }
        
        return response()->json([
            'status' => '200',
            'message' => "successfully posted",
        ], 200);
    }

    public function answer($data){
        $topic=$this->topics->where('id',$data['topic_id'])->first();
        if(date('Y-m-d H:i:s') > $topic['expires_at']){
            return response()->json([
                'status' => '402',
                'message' => "cannot enter answer because topic has expired.",
            ], 402);
        }
        foreach($data['answers'] as $user_answer){
            $ans=new UserAnswer();
            $ans['topic_id']=$data['topic_id'];
            $ans['question_id']=$user_answer['question_id'];
            $ans['answer']=$user_answer['answer'];
            $ans->save();
        }
      
        return response()->json([
            'status' => '200',
            'message' => "successfully posted",
        ], 200);
    }
    
    public function countQuestionsInTopic($topic_id){
        return $this->questions->where('topic_id',$topic_id)->count();
    }
}