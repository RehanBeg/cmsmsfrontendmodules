<?php
namespace CGFEURegister;

// load registrations, allow filtering by date and username match
try {
    $filter = $this->regManager()->create_user_filter();
    // todo:pagination and filtering

    $matches = $this->regManager()->load_users_by_filter($filter);
    $tpl = $this->CreateSmartyTemplate('defaultadmin.tpl');
    $tpl->assign('users', $matches);
    $tpl->display();
}
catch( \Exception $e ) {
    echo $this->ShowErrors($e);
}