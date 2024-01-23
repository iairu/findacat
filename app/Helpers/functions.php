<?php

use App\Cat;

/**
 * Convert file size to have unit string.
 *
 * @param  int  $bytes
 * @return string
 */
function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2).' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2).' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2).' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes.' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes.' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

/**
 * Get cat photo image tag.
 *
 * @param  \App\Cat  $cat
 * @param  array  $attributes
 * @return \Illuminate\Support\HtmlString
 */
function catPhoto(Cat $cat, $attributes = [])
{
    return Html::image(
        catPhotoPath($cat->photo_path, $cat->gender_id),
        null,
        $attributes
    );
}

/**
 * Get cat photo by path. Return default gender icon by default.
 *
 * @param  string  $photoPath
 * @param  int  $genderId
 * @return string
 */
function catPhotoPath($photoPath, $genderId)
{
    if (is_file(public_path('storage/'.$photoPath))) {
        return asset('storage/'.$photoPath);
    }

    return asset('images/icon_cat_'.$genderId.'.png');
}

function is_system_admin(Cat $cat)
{
    if ($cat->email) {
        if (config('app.system_admin_emails')) {
            $adminEmails = explode(';', config('app.system_admin_emails'));
            return in_array($cat->email, $adminEmails);
        }
    }

    return false;
}
