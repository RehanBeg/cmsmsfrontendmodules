<?php
if( !isset($gCms) ) exit;
if( !$this->have_users_perm() ) exit;

$term = \cge_param::get_string( $_REQUEST, 'term' );
$list = null;
if( is_numeric( $term ) && (int) $term > 0 ) {
    // assume it's a uid.
    $sql = 'SELECT id, username FROM '.CMS_DB_PREFIX.'module_feusers_users WHERE CAST(id AS CHAR) LIKE ? LIMIT 10';
    $list = $db->GetArray( $sql, [ '%'.$term.'%' ] );
    debug_to_log( $db->sql );
} else {
    // assume it's part of the username
    $sql = 'SELECT id, username FROM '.CMS_DB_PREFIX.'module_feusers_users WHERE username LIKE ? LIMIT 10';
    $list = $db->GetArray( $sql, [ '%'.$term.'%' ] );
}

if( !is_array( $list ) || !count($list) ) exit;

$out = null;
foreach( $list as $one ) {
    $out[] = [ 'label'=>$one['username'].' ('.$one['id'].')', 'value'=>$one['id'] ];
}
\cge_utils::send_ajax_and_exit( $out );