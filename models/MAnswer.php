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
class MAnswer implements Template
{

    private $answer_id;
    private $answer_text;


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
    public function getAnswerId()
    {
        return $this->answer_id;
    }

    /**
     * @param mixed $answer_id
     */
    public function setAnswerId($answer_id)
    {
        $this->answer_id = $answer_id;
    }

    /**
     * @return mixed
     */
    public function getAnswerText()
    {
        return $this->answer_text;
    }

    /**
     * @param mixed $answer_text
     */
    public function setAnswerText($answer_text)
    {
        $this->answer_text = $answer_text;
    }



}