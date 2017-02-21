<?php
    function addHistory($_params){
        $_history_model = D('history');
        $_history_model->historyCreate($_params);
    }
?>