<?php

// app/Constants/OrderConstants.php

namespace App\Constants;

class ReviewStatusConstants
{
    const REVIEWSTATUSES = [
        1 => 'Chờ phê duyệt',
        2 => 'Cho phép',
        3 => 'Từ chối',
    ];
    const REVIEWSTATUSCOLORS = [
        'Chờ phê duyệt' => '#6c757d',//grey
        'Cho phép' => '#fd7e14', //green
        'Từ chối' => '#dc3545', //red
    ];
}
