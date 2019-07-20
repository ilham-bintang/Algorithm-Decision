<?php

/**
 * File created by : Nullphantom.
 * https://nullphantom.tech
 *
 * Author : Bintang
 */

/**
 * File created by : Nullphantom.
 * https://nullphantom.tech
 *
 * Author : Bintang
 */
class MDecision implements Template
{

    private $decision_id;
    private $decision_question;
    private $decision_yes;
    private $decision_no;


    public function _id()
    {
        return $this->question_id;
    }

    public function _init($request)
    {
        foreach ($request as $field => $value)
            !array_key_exists($field, $this->_toArray())
            || $this->{'set' . Util::_camel_case($field, '_', '')}($request[$field]);

        return $this;
    }

    public function _toArray($type = Util::type_attribute_all, $exclude = array())
    {
        return Util::_to_array(get_object_vars($this), $type, $exclude);
    }

    /**
     * @return mixed
     */
    public function getDecisionId()
    {
        return $this->decision_id;
    }

    /**
     * @param mixed $decision_id
     */
    public function setDecisionId($decision_id)
    {
        $this->decision_id = $decision_id;
    }

    /**
     * @return mixed
     */
    public function getDecisionQuestion()
    {
        return $this->decision_question;
    }

    /**
     * @param mixed $decision_question
     */
    public function setDecisionQuestion($decision_question)
    {
        $this->decision_question = $decision_question;
    }

    /**
     * @return mixed
     */
    public function getDecisionYes()
    {
        return $this->decision_yes;
    }

    /**
     * @param mixed $decision_yes
     */
    public function setDecisionYes($decision_yes)
    {
        $this->decision_yes = $decision_yes;
    }

    /**
     * @return mixed
     */
    public function getDecisionNo()
    {
        return $this->decision_no;
    }

    /**
     * @param mixed $decision_no
     */
    public function setDecisionNo($decision_no)
    {
        $this->decision_no = $decision_no;
    }

}