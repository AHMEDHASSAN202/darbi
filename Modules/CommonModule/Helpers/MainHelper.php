<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */


function getCurrentGuard() {
    if (auth('admin_api')->check()) {
        return 'admin_api';
    }
    if (auth('vendor_api')->check()) {
        return 'vendor_api';
    }
    return null;
}

function activities() {
    return app(\Modules\CommonModule\Repositories\ActivityRepository::class);
}

function kebabToWords($str) {
    if(empty($str)) return $str;
    $pieces = preg_split('/(?=[A-Z])/', $str);
    $string = implode(' ', $pieces);
    $string = ucwords($string);
    return $string;
}

function assetsHelper() {
    return \Modules\CommonModule\Helpers\Assets::instance();
}

function imageUrl(?string $image, $dir = '') {
    if (!$image) return '';
    return filter_var($image, FILTER_VALIDATE_URL) ? $image : asset('storage/'. $dir . $image);
}

function translateAttribute(?array $attribute, $locale = null) {
    if (!$attribute) {
        return '';
    }

    if (empty($attribute)) {
        return '';
    }

    if (!$locale) {
        $locale = app()->getLocale();
    }

    return $attribute[$locale] ?? $attribute['en'];
}

function generatePriceLabelFromPrice(?float $price, $priceUnit) : string
{
    if (!$price) {
        \Illuminate\Support\Facades\Log::error('Why Price is Null!!');
        return '';
    }

    return sprintf("%.2f %s / %s", $price, __('SAR'), __($priceUnit));
}

function generateOTPCode()
{
    return (!app()->environment('production')) ? 1234 : mt_rand(1000,9999);
}

function hasEmbed($param) : bool
{
    if ($embedParam = request('embed')) {
        $embed = explode(',', $embedParam);
        return in_array($param, $embed);
    }
    return false;
}

function entityIsFree($state) : bool
{
    return ($state === 'free');
}

function getCarTestImages()
{
    return [
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.1&permmsgid=msg-f:1734975341187499776&th=1813dee1698b0700&view=fimg&realattid=f_l42sf8ax2&disp=thd&attbid=ANGjdJ9T7pfVRRo-OcHeknsc4mUb9FK-5zCSu9ujI73dWsXLM83OlKH_KR0Qvt0NC74XXmPhXV6YPY42HsL4PAQc31Amn0ArGh6PkzZhVp2Df_HEEQPTxOTIlbau5Ik&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.2&permmsgid=msg-f:1734975341187499776&th=1813dee1698b0700&view=fimg&realattid=f_l42sf8ax3&disp=thd&attbid=ANGjdJ-Z4qKABY_PhMPcnnjSZIvZ4zXpHIo4le-mmL8nnD9MQKAmTKiLgsbbQQEpxCVCXfnGjH-p23yP-H0Nbs8hMxE6qxh4TqrD5xE67mSWQCoksDaslY3MMwGlACk&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.3&permmsgid=msg-f:1734975341187499776&th=1813dee1698b0700&view=fimg&realattid=f_l42sf8a70&disp=thd&attbid=ANGjdJ_sUPdhK0rA6HP_CnJWtjR1Odc2df2s1DWYbUVwhokMnhfil6vkdxK8h9NIpksgk-_wjQlHOZveP9Jwgs24plT71whW7zOZ9_-zUbrfKm8C_Ya1eUpjtpQ1Jno&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.4&permmsgid=msg-f:1734975341187499776&th=1813dee1698b0700&view=fimg&realattid=f_l42sf8ax1&disp=thd&attbid=ANGjdJ-ZQJyjtidg4gsCtMI-emLKMKXmED7OEIy6VXv1R8GPMlZqUSPfVOBZcMflpWSOUEPb2-qgjmztvkZHE3K1GfQ-KKifnEGfenGRz39jfwVlMx8Q0YZb61XKVdE&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.5&permmsgid=msg-f:1734975341187499776&th=1813dee1698b0700&view=fimg&realattid=f_l42sf8ay4&disp=thd&attbid=ANGjdJ9hNGBSquRyv1xaxumVOnZTA9js8g_u1KYxW63aehp291uDnfMb_oaH5XhxwKqw2TbszkgXC2cpqemeMVWhyS3iZeAgMLPjqy4DvX5jjEaEs3Gep6xPzqIm_Ms&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.6&permmsgid=msg-f:1734975341187499776&th=1813dee1698b0700&view=fimg&realattid=f_l42sf8ay5&disp=thd&attbid=ANGjdJ-hO95e_4TOj9UL8qatQFc9LgVAU-83TBRxZW8dxS-MZAlOOX_cqa9pDjcBjPSENtF3NuuRuVZQJroGvTzcsodg0K0lp8lx1Q4TxrdFda_0PwAlJSirwph7svY&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.7&permmsgid=msg-f:1734975341187499776&th=1813dee1698b0700&view=fimg&realattid=f_l42sf8ay6&disp=thd&attbid=ANGjdJ8EYm39fEJchQvzN2uxzXYud60t0RC7bSh6B6-YHYMs_bsYxTLc4OKtiIVtbJ_RGg6Q_fbl3JtR49LexAqyRM91akSYNAYO3-X10l0f3UCe8e94gzP1gKzBZhA&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.8&permmsgid=msg-f:1734975341187499776&th=1813dee1698b0700&view=fimg&realattid=f_l42sf8ay7&disp=thd&attbid=ANGjdJ-5bOQiQ_UXhUL_TONRSD2LsjTq96k0BQXLa0fvOhRGHO6c7ZJTgqTzdVrJuRbv1rNH2CexZb5pc9CWmm6ioqkTGqkp97p5en6fSvESYwHwQ5NM2EV9YCHtFyE&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.9&permmsgid=msg-f:1734975341187499776&th=1813dee1698b0700&view=fimg&realattid=f_l42sf8az8&disp=thd&attbid=ANGjdJ9LzgAviDHTEJ0inmKjhbV8UTs-jiUse5xuF1duVMwjrogw9odA31zAbgb8orjGDORSk8pv6bDyxJ6qMqycfX2qQHBrQpHu0N_vnqW73hakddldRfPnE4CT8YI&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.10&permmsgid=msg-f:1734975341187499776&th=1813dee1698b0700&view=fimg&realattid=f_l42sf8az9&disp=thd&attbid=ANGjdJ_whEltD1hb0YvAMSoKkKeZwh7We7_fkhpAVRRt5pN5Ph9B4oEtQL0MEUoa14Sxr4ulh6OukYZtQTnHbYLd1ufaVhhgK-W5JhIfatJJ6F4bOBgEx3iN54s8O3c&ats=2524608000000&sz=w498-h902',
    ];
}

function getAvatarTestImages()
{
    return [
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.1&permmsgid=msg-f:1734980824429057927&th=1813e3de14355787&view=fimg&realattid=f_l44629ny1&disp=thd&attbid=ANGjdJ8BgouI87UAv2RBYzl_0frgVabYelOFQE9Cfcbft64eQnk8e0ZjucmozrhUDraHhpe-9gUjhs7V_S0_oGeL7AyiLYiGB8wlyc38ERRy2Tpb5wlQeNJHYNgn1EU&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.2&permmsgid=msg-f:1734980824429057927&th=1813e3de14355787&view=fimg&realattid=f_l44629np0&disp=thd&attbid=ANGjdJ_67_LlenzV_MjgXa8gKa4R_3OJbsT8qY2G5-LGlNxNnZTUqEaeINEviW3nWmgz7Molai_i4s_-7lnNhXjkJN533MlJTzPJgaFAm57ceapLFzax4S_LSEisjss&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.3&permmsgid=msg-f:1734980824429057927&th=1813e3de14355787&view=fimg&realattid=f_l44629nz2&disp=thd&attbid=ANGjdJ8ZcvxINpUZnIxzR5xt1FOGxfOTCERaiBfkaiovdkJrQNfMSlQD34fQPyeydRAWZ19GVJIToiuWY_Hfh0uG0A0NRLmErOe8AzkT2x8r68W3gH0t8JOmTFZjSyE&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.4&permmsgid=msg-f:1734980824429057927&th=1813e3de14355787&view=fimg&realattid=f_l44629nz3&disp=thd&attbid=ANGjdJ-1MLAkqYmsCHCwEEwap1vYewAsx_DSeK0ZiWyBl6SDJrrGYqhGBH-aBFnhqaEa83oCeb0CJUUwgHCDclabOy5Fj_rh9GVuJUYZEu9eYLyo1W9nMt3c9DsuEWc&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.5&permmsgid=msg-f:1734980824429057927&th=1813e3de14355787&view=fimg&realattid=f_l44629o04&disp=thd&attbid=ANGjdJ8rBTyor3Jvh_2_30NCbdv51X7uYtfS05dK9y09gyG__IruQ4tjdfx0UcpskgU22EEFCHPSKDhrlnwtYTPyrYaBX1Ton2-6_5PkTBY5dwtkij-NBz7T9W8EQ8k&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.6&permmsgid=msg-f:1734980824429057927&th=1813e3de14355787&view=fimg&realattid=f_l44629o16&disp=thd&attbid=ANGjdJ8kpfNsCKXRIyDv5-jvUP5uiba0rUK2cth2-LNqaExI5j5yHVxqCIwe8TvHbG0FQD7JFHKauJcJ6y6QRhqhFMqWAuZxY-RhDLBQL7oXyqpUaLgHwFWFKnv_sAY&ats=2524608000000&sz=w498-h902'
    ];
}

function getYatchTestImages()
{
    return [
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.1&permmsgid=msg-f:1734819134401233151&th=181350cfaf8940ff&view=fimg&realattid=f_l41gwc0a2&disp=thd&attbid=ANGjdJ-OaoUzDWA3bBHifrReaW-uKKp6kcm_6QWWcxkwlTNrPzC1ClA2AmJEucPJ52qAdEvzbGv-FWuESw3YMy8_Ym8-_PxQkB1kxFLep-ggVn1zDqgd53JIf0RPoK0&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.2&permmsgid=msg-f:1734819134401233151&th=181350cfaf8940ff&view=fimg&realattid=f_l41gwc0e4&disp=thd&attbid=ANGjdJ9ahQeGEydsC0yR5cq-jS2eaSYxz81AcD_Oi0pFeFI2p8h8Oppx7FgEwB0coQ0t02Xkb-9xZ7GBb0ZPU1YN4t5jAWXUBGtQ3zfxYw8NDFDE7lkZMwd_E-wIQfg&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.3&permmsgid=msg-f:1734819134401233151&th=181350cfaf8940ff&view=fimg&realattid=f_l41gwbzv0&disp=thd&attbid=ANGjdJ8faZuP8X54R-kZVVxV-Ff02F36TaQ2zd-6eygUAV3QGfBQ9IpfKDlijI89RRLKHFHHnSR5GQEHZCwo74W-onVpwbVgrlqhHxHOu4gdSVaL_WcI_Zjvtkh8hiM&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.4&permmsgid=msg-f:1734819134401233151&th=181350cfaf8940ff&view=fimg&realattid=f_l41gwc081&disp=thd&attbid=ANGjdJ8c2fPGst9ikeqJz7VBb9E360_YbPpItSk9j08i0cUWhTk7VUajYF3g0Q8dyWZxOw_nVFniqUHfmlnquf-uWGiBL4WtnGlHcSfaBKSWlVre1Z1syUfhqjNl1G4&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.5&permmsgid=msg-f:1734819134401233151&th=181350cfaf8940ff&view=fimg&realattid=f_l41gwc0c3&disp=thd&attbid=ANGjdJ-j0PC-lpxdYUdxjkI1oUQLNKN-YyjrCa1CHzGi6tLJG8ZMKPv4Ko6Hg5G3qVyEAcpXZJhVSTTthQjvKfDOZTreud6gxtenvQ5AwwWIrmfzrjnjC7hY9KkO8Ks&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.6&permmsgid=msg-f:1734819134401233151&th=181350cfaf8940ff&view=fimg&realattid=f_l41gwc0g5&disp=thd&attbid=ANGjdJ9PpL_-xBuzwlUHJuzuGjCidZVy-Ccm1zxXZ9iJeGodBfhVfnw_QbBFJBoLqSbNzz0i4WbADQOJ1eEZ-FQ0Wfice5_n2ApGnt-5L0gWRaK0siQEjq8LblMFadA&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.10&permmsgid=msg-f:1734819134401233151&th=181350cfaf8940ff&view=fimg&realattid=f_l41gwc0o10&disp=thd&attbid=ANGjdJ-hFFiLfMa2LZoGaTeKHGppywcUwzOAIcubuGkAsTbn_0_SSwuwwo8gMC_OFrev9vlu8N88NcX3LGygHkF5HjBJpwx5_Ue7Y0jwraS2fJdjMq1T1DL_h1f7eCI&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.11&permmsgid=msg-f:1734819134401233151&th=181350cfaf8940ff&view=fimg&realattid=f_l41gwc0l8&disp=thd&attbid=ANGjdJ9hHkyU6y7Zg0JvWXwvZOCGDZKEERscTU2N5vfrv0PvHE6eX_PKii-bJlWVGk1NAa9vtROhIQOx220v-Ao2GSuVdfSemJ_UEbSBUKllsgzei0vYVvjoZ6rhUb8&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.12&permmsgid=msg-f:1734819134401233151&th=181350cfaf8940ff&view=fimg&realattid=f_l41gwc0p11&disp=thd&attbid=ANGjdJ-VL6dUJX2z77-8M7oL2GUCamLYlXDPkQZYUtBoB3tdgoxHEN1h9MtORUM0xBu7CeCwn3mMCCcG_YM0Ntu4TDK0G40ibdYq_obzRPMbc2MU2ohWvPaAoaS_s1E&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.15&permmsgid=msg-f:1734819134401233151&th=181350cfaf8940ff&view=fimg&realattid=f_l41gwc0w16&disp=thd&attbid=ANGjdJ-cFAgVfktu7f1i83atuD0A1P47gYibciPGPcK0Ksp7AsotsirCImN9hCmMHHe3ISntv_XJOnLH2wG7MKVmN6AbjqEce71gXkbLK99l_OCQ8fQvtNXz5XfJurw&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.16&permmsgid=msg-f:1734819134401233151&th=181350cfaf8940ff&view=fimg&realattid=f_l41gwc0u14&disp=thd&attbid=ANGjdJ8WQKq0l0BsmKxUzAwzkM7pnUC2rlnLrM-iohvJhLB8wkzmtrxk9A7FHxu-PibLinABpqL78PbNudtlsVZc4CHnz50ggqxuJYLk5yrL4C5PD8HvAx2TfSfiXUU&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.17&permmsgid=msg-f:1734819134401233151&th=181350cfaf8940ff&view=fimg&realattid=f_l41gwc0v15&disp=thd&attbid=ANGjdJ_noFUZvTz5MzSwDpXIlF6rQfzbEGMRrAKO0zcn-ojhnufPsf8G5V1KRKfnaP4E9xTt4F03MP7MEY-YGUT3GPHxUvK21Y7F4HRBDml618RFCvaszs-rFTHf5eY&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.18&permmsgid=msg-f:1734819134401233151&th=181350cfaf8940ff&view=fimg&realattid=f_l41gwc0y18&disp=thd&attbid=ANGjdJ_YnZKpkB1Bm89Hu7ONG5O_TB5S8hTZXAQWSAgy0EkHhnhyHD8N2kksaXZ34p1kfMFYoPreyzeMWClr5E2l5wti-Aef-G92VNaSK65l-o5icwnGQKXLbRTpmU8&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.21&permmsgid=msg-f:1734819134401233151&th=181350cfaf8940ff&view=fimg&realattid=f_l41gwc1121&disp=thd&attbid=ANGjdJ-Jw7Wx0mBlfnFjYPic7J1f6vJhAB6BsJobjrIFLQnBJILDFsf62hToGbh0EnOmq4M6XAeqou9hC0PBOFdUjRkSvmMx2uH2nxQ_gTBcCG_5U-tLqpYAVKK0bC8&ats=2524608000000&sz=w498-h902',
        'https://mail.google.com/mail/u/2?ui=2&ik=ce72a50e66&attid=0.22&permmsgid=msg-f:1734819134401233151&th=181350cfaf8940ff&view=fimg&realattid=f_l41gwc1020&disp=thd&attbid=ANGjdJ9-7Ln13JPT_oaeECrncrnax9Mdsj37nZxIf-NyvUrsDQR4DEZE2c0b3ADoOsrRMUENPaq-uat_hRefsWrGMxr2lcnN3qHKhwlLXITR33ZQ28kkJcMlBW7fSrg&ats=2524608000000&sz=w498-h902',
    ];
}

function getRandomImages(array $images, $length = 3)
{
    $imgs = [];
    while ($length > 0) {
        $imgs[] = $images[mt_rand(0, (count($images) - 1))];
        $length--;
    }
    return $imgs;
}

function getOption($option, $default = null)
{
    $settings = app(\Modules\CommonModule\Services\SettingService::class)->getSettings();

    return @$settings->{$option} ?? $default;
}
