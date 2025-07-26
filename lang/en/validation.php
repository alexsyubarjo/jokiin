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
    "accepted" => "Kolom :attribute harus diterima.",
    "accepted_if" =>
        "Kolom :attribute harus diterima saat :other adalah :value.",
    "active_url" => "Kolom :attribute harus berupa URL yang valid.",
    "after" => "Kolom :attribute harus berupa tanggal setelah :date.",
    "after_or_equal" =>
        "Kolom :attribute harus berupa tanggal setelah atau sama dengan :date.",
    "alpha" => "Kolom :attribute hanya boleh mengandung huruf.",
    "alpha_dash" =>
        "Kolom :attribute hanya boleh mengandung huruf, angka, tanda hubung, dan garis bawah.",
    "alpha_num" => "Kolom :attribute hanya boleh mengandung huruf dan angka.",
    "array" => "Kolom :attribute harus berupa array.",
    "ascii" =>
        "Kolom :attribute hanya boleh mengandung karakter alfanumerik satu byte dan simbol.",
    "before" => "Kolom :attribute harus berupa tanggal sebelum :date.",
    "before_or_equal" =>
        "Kolom :attribute harus berupa tanggal sebelum atau sama dengan :date.",
    "between" => [
        "array" => "Kolom :attribute harus memiliki antara :min dan :max item.",
        "file" =>
            "Kolom :attribute harus memiliki ukuran antara :min dan :max kilobita.",
        "numeric" =>
            "Kolom :attribute harus memiliki nilai antara :min dan :max.",
        "string" =>
            "Kolom :attribute harus memiliki panjang antara :min dan :max karakter.",
    ],
    "boolean" => "Kolom :attribute harus bernilai true atau false.",
    "confirmed" => "Konfirmasi kolom :attribute tidak cocok.",
    "current_password" => "Password salah.",
    "date" => "Kolom :attribute harus berupa tanggal yang valid.",
    "date_equals" =>
        "Kolom :attribute harus berupa tanggal yang sama dengan :date.",
    "date_format" => "Kolom :attribute harus sesuai dengan format :format.",
    "decimal" => "Kolom :attribute harus memiliki :decimal tempat desimal.",
    "declined" => "Kolom :attribute harus ditolak.",
    "declined_if" =>
        "Kolom :attribute harus ditolak saat :other adalah :value.",
    "different" => "Kolom :attribute dan :other harus berbeda.",
    "digits" => "Kolom :attribute harus berupa :digits digit.",
    "digits_between" =>
        "Kolom :attribute harus memiliki panjang antara :min dan :max digit.",
    "dimensions" =>
        "Kolom :attribute memiliki dimensi gambar yang tidak valid.",
    "distinct" => "Kolom :attribute memiliki nilai duplikat.",
    "doesnt_end_with" =>
        "Kolom :attribute tidak boleh diakhiri dengan salah satu dari berikut: :values.",
    "doesnt_start_with" =>
        "Kolom :attribute tidak boleh diawali dengan salah satu dari berikut: :values.",
    "email" => "Kolom :attribute harus berupa alamat surel yang valid.",
    "ends_with" =>
        "Kolom :attribute harus diakhiri dengan salah satu dari berikut: :values.",
    "enum" => "Pilihan :attribute yang dipilih tidak valid.",
    "exists" => "Pilihan :attribute yang dipilih tidak valid.",
    "file" => "Kolom :attribute harus berupa file.",
    "filled" => "Kolom :attribute harus memiliki nilai.",
    "gt" => [
        "array" => "Kolom :attribute harus memiliki lebih dari :value item.",
        "file" =>
            "Kolom :attribute harus memiliki ukuran lebih dari :value kilobita.",
        "numeric" => "Kolom :attribute harus memiliki nilai lebih dari :value.",
        "string" =>
            "Kolom :attribute harus memiliki panjang lebih dari :value karakter.",
    ],
    "gte" => [
        "array" => "Kolom :attribute harus memiliki :value item atau lebih.",
        "file" =>
            "Kolom :attribute harus memiliki ukuran lebih dari atau sama dengan :value kilobita.",
        "numeric" =>
            "Kolom :attribute harus memiliki nilai lebih dari atau sama dengan :value.",
        "string" =>
            "Kolom :attribute harus memiliki panjang lebih dari atau sama dengan :value karakter.",
    ],
    "image" => "Kolom :attribute harus berupa gambar.",
    "in" => "Pilihan :attribute yang dipilih tidak valid.",
    "in_array" => "Kolom :attribute harus ada dalam :other.",
    "integer" => "Kolom :attribute harus berupa bilangan bulat.",
    "ip" => "Kolom :attribute harus berupa alamat IP yang valid.",
    "ipv4" => "Kolom :attribute harus berupa alamat IPv4 yang valid.",
    "ipv6" => "Kolom :attribute harus berupa alamat IPv6 yang valid.",
    "json" => "Kolom :attribute harus berupa string JSON yang valid.",
    "lowercase" => "Kolom :attribute harus dalam huruf kecil.",
    "lt" => [
        "array" => "Kolom :attribute harus memiliki kurang dari :value item.",
        "file" =>
            "Kolom :attribute harus memiliki ukuran kurang dari :value kilobita.",
        "numeric" =>
            "Kolom :attribute harus memiliki nilai kurang dari :value.",
        "string" =>
            "Kolom :attribute harus memiliki panjang kurang dari :value karakter.",
    ],
    "lte" => [
        "array" =>
            "Kolom :attribute tidak boleh memiliki lebih dari :value item.",
        "file" =>
            "Kolom :attribute harus memiliki ukuran kurang dari atau sama dengan :value kilobita.",
        "numeric" =>
            "Kolom :attribute harus memiliki nilai kurang dari atau sama dengan :value.",
        "string" =>
            "Kolom :attribute harus memiliki panjang kurang dari atau sama dengan :value karakter.",
    ],
    "mac_address" => "Kolom :attribute harus berupa alamat MAC yang valid.",
    "max" => [
        "array" =>
            "Kolom :attribute tidak boleh memiliki lebih dari :max item.",
        "file" =>
            "Kolom :attribute tidak boleh lebih besar dari :max kilobita.",
        "numeric" => "Kolom :attribute tidak boleh lebih besar dari :max.",
        "string" =>
            "Kolom :attribute tidak boleh lebih besar dari :max karakter.",
    ],
    "max_digits" =>
        "Kolom :attribute tidak boleh memiliki lebih dari :max digit.",
    "mimes" => "Kolom :attribute harus berupa file dengan tipe: :values.",
    "mimetypes" => "Kolom :attribute harus berupa file dengan tipe: :values.",
    "min" => [
        "array" => "Kolom :attribute harus memiliki minimal :min item.",
        "file" =>
            "Kolom :attribute harus memiliki ukuran minimal :min kilobita.",
        "numeric" => "Kolom :attribute harus memiliki nilai minimal :min.",
        "string" =>
            "Kolom :attribute harus memiliki panjang minimal :min karakter.",
    ],
    "min_digits" => "Kolom :attribute harus memiliki minimal :min digit.",
    "missing" => "Kolom :attribute harus hilang.",
    "missing_if" =>
        "Kolom :attribute harus hilang ketika :other adalah :value.",
    "missing_unless" =>
        "Kolom :attribute harus hilang kecuali jika :other adalah :value.",
    "missing_with" => "Kolom :attribute harus hilang ketika :values ada.",
    "missing_with_all" => "Kolom :attribute harus hilang ketika :values ada.",
    "multiple_of" => "Kolom :attribute harus merupakan kelipatan dari :value.",
    "not_in" => "Pilihan :attribute yang dipilih tidak valid.",
    "not_regex" => "Format kolom :attribute tidak valid.",
    "numeric" => "Kolom :attribute harus berupa angka.",
    "password" => [
        "letters" => "Kolom :attribute harus mengandung setidaknya satu huruf.",
        "mixed" =>
            "Kolom :attribute harus mengandung setidaknya satu huruf kapital dan satu huruf kecil.",
        "numbers" => "Kolom :attribute harus mengandung setidaknya satu angka.",
        "symbols" =>
            "Kolom :attribute harus mengandung setidaknya satu simbol.",
        "uncompromised" =>
            "Kolom :attribute yang diberikan telah muncul dalam kebocoran data. Harap pilih :attribute yang berbeda.",
    ],
    "present" => "Kolom :attribute harus ada.",
    "prohibited" => "Kolom :attribute dilarang.",
    "prohibited_if" => "Kolom :attribute dilarang jika :other adalah :value.",
    "prohibited_unless" =>
        "Kolom :attribute dilarang kecuali jika :other ada dalam :values.",
    "prohibits" => "Kolom :attribute melarang :other hadir.",
    "regex" => "Format kolom :attribute tidak valid.",
    "required" => "Kolom :attribute diperlukan.",
    "required_array_keys" =>
        "Kolom :attribute harus berisi entri untuk: :values.",
    "required_if" => "Kolom :attribute diperlukan ketika :other adalah :value.",
    "required_if_accepted" =>
        "Kolom :attribute diperlukan ketika :other diterima.",
    "required_unless" =>
        "Kolom :attribute diperlukan kecuali :other ada dalam :values.",
    "required_with" => "Kolom :attribute diperlukan ketika :values ada.",
    "required_with_all" => "Kolom :attribute diperlukan ketika :values ada.",
    "required_without" =>
        "Kolom :attribute diperlukan ketika :values tidak ada.",
    "required_without_all" =>
        "Kolom :attribute diperlukan ketika tidak ada :values yang ada.",
    "same" => "Kolom :attribute harus sama dengan :other.",
    "size" => [
        "array" => "Kolom :attribute harus memiliki :size item.",
        "file" => "Kolom :attribute harus memiliki ukuran :size kilobita.",
        "numeric" => "Kolom :attribute harus memiliki nilai :size.",
        "string" => "Kolom :attribute harus memiliki panjang :size karakter.",
    ],
    "starts_with" =>
        "Kolom :attribute harus diawali dengan salah satu dari berikut: :values.",
    "string" => "Kolom :attribute harus berupa string.",
    "timezone" => "Kolom :attribute harus berisi zona waktu yang valid.",
    "unique" => "Kolom :attribute sudah ada sebelumnya.",
    "uploaded" => "Kolom :attribute gagal diunggah.",
    "uppercase" => "Kolom :attribute harus dalam huruf kapital.",
    "url" => "Format kolom :attribute tidak valid.",
    "ulid" => "Kolom :attribute harus berupa ULID yang valid.",
    "uuid" => "Kolom :attribute harus berupa UUID yang valid.",

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

    "custom" => [
        "attribute-name" => [
            "rule-name" => "custom-message",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    "attributes" => [],
];
