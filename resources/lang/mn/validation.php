<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute зөвшөөрсөн байх ёстой.',
    'active_url'           => ':attribute зөв URL биш байна.',
    'after'                => ':attribute заавал :date -с хойшхи огноо байх ёстой.',
    'after_or_equal'       => ':attribute заавал :date -с хойшхи эсвэл тэнцүү огноо байх ёстой.',
    'alpha'                => ':attribute зөвхөн үсэг ашиглана.',
    'alpha_dash'           => ':attribute зөвхөн үсэг, тоо, зураас ашиглана.',
    'alpha_num'            => ':attribute зөвхөн үсэг, тоо ашиглана.',
    'array'                => ':attribute хүснэгт өгөгдөл байх ёстой.',
    'before'               => ':attribute заавал :date -с өмнөх огноо байх ёстой.',
    'before_or_equal'      => ':attribute заавал :date -с өмнөх эсвэл тэнцүү огноо байх ёстой.',
    'between'              => [
        'numeric' => ':attribute -н утга :min болон :max -н хооронд байх ёстой.',
        'file'    => ':attribute -н хэмжээ :min болон :max килобайтын хооронд байх ёстой.',
        'string'  => ':attribute -н урт :min - :max тэмдэгт байх ёстой.',
        'array'   => ':attribute -н хэмжээ :min - :max элементтэй байх ёстой.',
    ],
    'boolean'              => ':attribute үнэн эсвэл худал утгын аль нэг байх ёстой.',
    'confirmed'            => ':attribute баталгаажуулалт таарсангүй.',
    'date'                 => ':attribute зөв огноо биш байна.',
    'date_format'          => ':attribute -н утга :format хэлбэртэй байх ёстой.',
    'different'            => ':attribute болон :other ялгаатай байх ёстой.',
    'digits'               => ':attribute -н утга :digits оронтой байх ёстой.',
    'digits_between'       => ':attribute -н утга :min -с :max оронтой байх ёстой.',
    'dimensions'           => ':attribute -н зургийн хэмжээ буруу байна.',
    'distinct'             => ':attribute давхардсан утгатай байна.',
    'email'                => ':attribute зөв цахим шуудан байх ёстой.',
    'exists'               => 'Сонгосон :attribute буруу байна.',
    'file'                 => ':attribute файл байх ёстой.',
    'filled'               => ':attribute заавал утгатай байх ёстой.',
    'image'                => ':attribute зураг байх ёстой.',
    'in'                   => 'Сонгосон :attribute буруу байна.',
    'in_array'             => ':attribute -н утга :other -д байхгүй байна.',
    'integer'              => ':attribute бүхэл тоо байх ёстой.',
    'ip'                   => ':attribute зөв IP хаяг байх ёстой.',
    'ipv4'                 => ':attribute зөв IPv4 хаяг байх ёстой.',
    'ipv6'                 => ':attribute зөв IPv6 хаяг байх ёстой.',
    'json'                 => ':attribute зөв JSON байх ёстой.',
    'max'                  => [
        'numeric' => ':attribute -н утга :max -с их байж болохгүй.',
        'file'    => ':attribute -н хэмжээ :max килобайтаас их байж болохгүй.',
        'string'  => ':attribute -н урт :max тэмдэгтээс их байж болохгүй.',
        'array'   => ':attribute -н элементийн тоо :max -с их байж болохгүй.',
    ],
    'mimes'                => ':attribute -н файлын төрөл дараах хэлбэрүүдийн аль нэг байх ёстой: :values.',
    'mimetypes'            => ':attribute -н файлын төрөл дараах хэлбэрүүдийн аль нэг байх ёстой: :values.',
    'min'                  => [
        'numeric' => ':attribute -н утга хамгийн багадаа :min байх ёстой.',
        'file'    => ':attribute -н хэмжээ хамгийн багадаа :min байх ёстой.',
        'string'  => ':attribute -н урт хамгийн багадаа :min байх ёстой.',
        'array'   => ':attribute -н элементийн тоо хамгийн багадаа :min байх ёстой.',
    ],
    'not_in'               => 'Сонгосон :attribute буруу.',
    'numeric'              => ':attribute тоо байх ёстой.',
    'present'              => ':attribute field must be present.',
    'regex'                => ':attribute -н хэлбэр буруу.',
    'required'             => ':attribute оруулах шаардлагатай.',
    'required_if'          => ':other :value үед :attribute оруулах шаардлагатай.',
    'required_unless'      => ':other :value байхаас бусад тохиолдолд :attribute оруулах шаардлагатай.',
    'required_with'        => ':values байгаа тохиолдолд :attribute оруулах шаардлагатай.',
    'required_with_all'    => ':values байгаа тохиолдолд :attribute оруулах шаардлагатай.',
    'required_without'     => ':values байхгүй бол :attribute оруулах шаардлагатай.',
    'required_without_all' => 'Ямар нэг :values байхгүй бол :attribute оруулах шаардлагатай.',
    'same'                 => ':attribute болон :other адилхан байх ёстой.',
    'size'                 => [
        'numeric' => ':attribute -н хэмжээ :size байх ёстой.',
        'file'    => ':attribute -н хэмжээ :size килобайт байх ёстой.',
        'string'  => ':attribute -н урт :size тэмдэгттэй байх ёстой.',
        'array'   => ':attribute -н дотор :size элемент байх ёстой.',
    ],
    'string'               => ':attribute тэмдэгтийн цуваа байх ёстой.',
    'timezone'             => ':attribute зөв цагийн бүсийг оруулна уу.',
    'unique'               => ':attribute -н утга давхцсан байна.',
    'uploaded'             => ':attribute илгээж чадсангүй.',
    'url'                  => ':attribute -н хэлбэр буруу.',
    'transcription'             => ':attribute дүрмийн дагуу байх ёстой',
    'sisiid'             => ':attribute -н утга Sisi дугаар байх ёстой',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'email' => 'Цахим шуудан',
        'name' => 'Нэр',
        'transcription' => 'Бичвэр',
        'password' => 'Нууц үг',
        'validation' => 'Санал',
    ],

];
