<?php

global $page_title;

$answer_id = Routes::_gi()->_depth(2);
$obj_answer = CAnswer::_gi()->_get($answer_id);


?>

<div class="row">
    <div class="col-sm-12">
        <div class="ibox box">
            <div class="ibox-title">
                <h2>Answer No : <?php echo substr($answer_id, 1,1); ?></h2>
            </div>
            <div class="ibox-content ">
                <?php echo $obj_answer->getAnswerText(); ?><br/><br/>

                <div class="btn-group">
                    <a href="<?php echo Util::_a_u(Util::u_question . DS . 'Q1'); ?>" class="btn btn-lg btn-warning">Retry</a>
                    <a href="<?php echo Util::_a_beranda(); ?>" class="btn btn-lg btn-primary">Home</a>
                </div>
            </div>
        </div>
    </div>


</div>
</div>