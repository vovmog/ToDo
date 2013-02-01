<?php
function rus_month($in)
{
    $month = array(
        'January' => "Январь", 'February' => "Февраль", 'March' => "Март",
        'April' => "Апрель", 'May' => "Май", 'June' => "Июнь",
        'July' => "Июль", 'August' => "Август", 'September' => "Сентябрь",
        'October' => "Октябрь", 'November' => "Ноябрь", 'December' => "Декабрь");
    return $month[$in];
}
