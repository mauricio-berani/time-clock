<?php

namespace App\Enums\Auth;

enum Permissions: string
{
    case MOUNT_DASHBOARD                   = 'mount dashboard';

    case MOUNT_PROFILE                     = 'mount profile';
    case UPDATE_PROFILE                    = 'update profile';

    case MOUNT_USER                        = 'mount user';
    case LIST_USER                         = 'list user';
    case FIND_ALL_USER                     = 'findall user';
    case FIND_ONE_USER                     = 'findone user';
    case UPDATE_USER                       = 'update user';
    case DELETE_USER                       = 'delete user';
    case CREATE_USER                       = 'create user';

    case MOUNT_CLOCK                       = 'mount clock';
    case LIST_CLOCK                        = 'list clock';
    case FIND_ALL_CLOCK                    = 'findall clock';
    case FIND_ONE_CLOCK                    = 'findone clock';
    case UPDATE_CLOCK                      = 'update clock';
    case DELETE_CLOCK                      = 'delete clock';
    case CREATE_CLOCK                      = 'create clock';
}
