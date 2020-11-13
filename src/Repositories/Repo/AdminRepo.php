<?php

namespace GeniusSystems\Poll\Repositories\Repo;
use GeniusSystems\Poll\Repositories\Interfaces\AdminInterface;
use App\Models\Topics;
use App\Models\Questions;
use App\Models\Options;
use App\Models\UserAnswer;
use App\Models\UserVote;
use Symfony\Component\Console\Question\Question;
use Illuminate\Support\Facades\DB;
class AdminRepo implements AdminInterface
{
    private $topics;
    private $userVotes;
    private $options;
    private $userAnswer;
    public function __construct(Topics $topics,UserVote $userVotes,Options $options,UserAnswer $userAnswer,Questions $questions)
    {
        $this->topics = $topics;
        $this->userVotes = $userVotes;
        $this->options = $options;
        $this->userAnswer = $userAnswer;
        $this->questions = $questions;
        
    }

    public function createTopic($data)
    {
       
        $topic=new Topics();
        $topic['name']=$data['name'];
        $topic['type']=$data['type'];
        $topic['description']=$data['description'];
        $topic['start_at']=$data['start_at'];
        $topic['expires_at']=$data['expires_at'];
        if(isset($data['image'])){
                 
            $image_file = $data->file('image');
        
            $extension = $image_file->getClientOriginalExtension();
          
            
            $file_name = $image_file->getClientOriginalName();
        
            //path

            $minio_store=\Storage::disk('minio')->put('/topic/'.$file_name, file_get_contents($image_file));

            $topic['image'] = "/topic/".$file_name;
        }            
      
        $topic->save();
       
    }
    public function updateTopic($id,$data)
    {
       
        $topic=$this->topics->findorFail($id);
        $topic['name']=$data['name'];
        $topic['type']=$data['type'];
        $topic['expires_at']=$data['expires_at'];
        $topic['start_at']=$data['start_at'];
        $topic['description']=$data['description'];
        $topic->update();
    }

    public function deleteTopic($id)
    {
       
        $topic=$this->topics->where('id',$id)->delete();
        
    }

    public function getTopics($data)
    {
       $today=date('Y-m-d H:i:s');
        $topic=$this->topics->where('start_at','<=',$today)->where('expires_at','>=',$today)->get();
        foreach($topic as $tp){
            if($tp['image'] || $tp['image'] != null || $tp['image']!="" ){
                $tp['image']=\URL::to('/') . "/images/topics/".$tp['id'];
            }else{
                $tp['image']="";
            }
          
        
        }
      
        return $topic;
    }

    public function createQuestion($data)
    {
        DB::beginTransaction();
        $question=new Questions();
        $question['topic_id']=$data['topic_id'];
        $question['name']=$data['name'];
        $question['type']=$data['type'];

        if(isset($data['image'])){
                 
                    $image_file = $data->file('image');
                
                    $extension = $image_file->getClientOriginalExtension();
                  
                    
                    $file_name = $image_file->getClientOriginalName();
                
                    //path
       
                    $minio_store=\Storage::disk('minio')->put('/questions/'.$file_name, file_get_contents($image_file));
       
                    $question['image'] = "/questions/".$file_name;
        }            
                    


        $question->save();
        
        if(isset($data['options'])){

            foreach($data['options'] as $option){
            
                $option_data=new Options();
                $option_data['question_id']=$question['id'];
                $option_data['name']=$option;
             
                $option_data->save();
            }
        }
        DB::commit();
       
    }
    public function updateQuestion($id,$data){
        $question= $this->questions->findorFail($id);
        $result = $question->update($data);
      

    }
    public function deleteQuestion($id){
        $this->questions->where('id',$id)->delete();
    }
    public function getQuestionByTopicId($id){

       
        $data=$this->topics->where('id',$id)->with('questions')->get();
        foreach($data as $topic){
           
            if($topic['image'] || $topic['image'] != null || $topic['image']!="" ){
                $topic['image']=\URL::to('/') . "/images/topics/".$topic['id'];
            }else{
                $topic['image']="";
            }
           foreach($topic['questions'] as $ques){
                    if($ques['image'] || $ques['image'] != null || $ques['image']!="" ){
                        $ques['image']=\URL::to('/') . "/images/questions/".$ques['id'];
                    }else{
                        $ques['image']="";
                    }
           }

       
        }
        return $data;
    }   

    public function getNumberOfVotes($questionId){
       
        $options=$this->options->where('question_id',$questionId)->select('id','name')->get();
        foreach ($options as $option){
            $votes=$this->userVotes->where('question_id',$questionId)->where('option_id',$option['id'])->count();
            $option['vote_count']=$votes;
        }
        return $options;
    }

    public function getQuestionsAnswers($questionId){
       
      
            $answers=$this->userAnswer->where('question_id',$questionId)->get();
            return $answers;
      
      
    }
  
    public function updateOption($id,$data){
        $options= $this->options->findorFail($id);
        $result = $options->update($data);
      
    }
    public function deleteOption($id){
        $this->options->where('id',$id)->delete();
    }


    public function getImage($type,$id)
    {
      
        if($type=="questions"){
            $data = $this->questions->where('id', $id)->first();
        }
        elseif($type=="topics"){
            
            $data = $this->topics->where('id', $id)->first();
          
        }
      
        
        $files = response(\Storage::disk('minio')->get($data['image']))->header('Content-Type',
            'image/jpeg');

        

        return $files;
    }
}