<?php
/**
 * @param $user_type_id
 * @return array|string[]
 */
function user_type_info($user_type_id) {

    $info = [
        'rel_table' => null,
        'foreign_key' => null,
        'ORM_object' => \App\User::class,
        'dir' => 'users',
    ];
    switch ($user_type_id) {
        case 10:
            $info = [
                'rel_table' => 'talent_rel',
                'foreign_key' => 'user_id',
                'ORM_object' => \App\TalentRel::class,
                'dir' => 'talents',
            ];
            break;
        case 9:
            $info = [
                'rel_table' => 'vendor_rel',
                'foreign_key' => 'user_id',
                'ORM_object' => \App\VendorRel::class,
                'dir' => 'vendors',
            ];
            break;
        case 12:
            $info = [
                'rel_table' => null,
                'foreign_key' => 'user_id',
                'ORM_object' => null,
                'dir' => 'employers',
            ];
            break;
        case 13:
            $info = [
                'rel_table' => 'team_rel',
                'foreign_key' => 'user_id',
                'ORM_object' => \App\TeamRel::class,
                'dir' => 'teams',
            ];
            break;

    }

    return $info;
}
