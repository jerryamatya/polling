<?php


namespace GeniusSystems\Poll\Repositories\Interfaces;


interface AdminInterface
{
  public function createTopic($data);
  public function updateTopic($id,$data);
  public function deleteTopic($id);
  public function getTopics($data);

  public function createQuestion($data);
  public function updateQuestion($id,$data);
  public function deleteQuestion($id);
  public function getQuestionByTopicId($id);
  public function getNumberOfVotes($questionId);
  public function getQuestionsAnswers($questionId);
  public function updateOption($id,$data);
  public function deleteOption($id);
  public function getImage($type,$id);
}