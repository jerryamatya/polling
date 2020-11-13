<?php


namespace GeniusSystems\Poll\Repositories\Interfaces;


interface VoterInterface
{
    public function castVote($data);
    public function answer($data);
    public function countQuestionsInTopic($topic_id);
}