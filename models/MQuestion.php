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
class MQuestion implements Template
{

    private $question_id;
    private $question_text;


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
    public function getQuestionId()
    {
        return $this->question_id;
    }

    /**
     * @param mixed $question_id
     */
    public function setQuestionId($question_id)
    {
        $this->question_id = $question_id;
    }

    /**
     * @return mixed
     */
    public function getQuestionText()
    {
        return $this->question_text;
    }

    /**
     * @param mixed $question_text
     */
    public function setQuestionText($question_text)
    {
        $this->question_text = $question_text;
    }

}