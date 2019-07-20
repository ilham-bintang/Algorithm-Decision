<?php

global $page_title;

$questions_id = Routes::_gi()->_depth(2);
$obj_question = CQuestion::_gi()->_get($questions_id);

$obj_decision =  CDecision::_gi()->_get($questions_id, 'decision_question');

$kind_yes = Util::u_question;
$kind_no = Util::u_question;
if (substr($obj_decision->getDecisionYes(), 0,1) == "A") {
    $kind_yes = Util::u_answer;
}
if (substr($obj_decision->getDecisionNo(), 0,1) == "A") {
    $kind_no = Util::u_answer;
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="ibox box">
            <div class="ibox-title">
                <h2>Question <?php echo substr($questions_id, 1,1); ?></h2>
            </div>
            <div class="ibox-content ">
                <?php echo $obj_question->getQuestionText(); ?><br/><br/>

                <div class="btn-group">
                    <a href="<?php echo Util::_a_u($kind_yes . DS . $obj_decision->getDecisionYes()); ?>" class="btn btn-lg btn-primary">Yes</a>
                    <a href="<?php echo Util::_a_u($kind_no . DS . $obj_decision->getDecisionNo()); ?>" class="btn btn-lg btn-danger ">No</a>
                </div>
            </div>
        </div>
    </div>


    </div>
</div>