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

    'accepted' => ':attribute harus di terima.',
    'accepted_if' => ':attribute harus diterima bila :other adalah :value.',
    'active_url' => ':attribute bukan URL yang valid.',
    'after' => ':attribute harus tanggal setelah :date.',
    'after_or_equal' => ':attribute harus tanggal setelah atau sama dengan :date.',
    'alpha' => ':attribute hanya boleh berisi huruf.',
    'alpha_dash' => ':attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num' => ':attribute hanya boleh berisi huruf dan angka.',
    'array' => ':attribute harus berupa larik.',
    'before' => ':attribute harus tanggal sebelum :date.',
    'before_or_equal' => ':attribute harus tanggal sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => ':attribute harus antara :min dan :max.',
        'file' => ':attribute harus antara :min dan :max kilobytes.',
        'string' => ':attribute harus antara :min dan :max karakter.',
        'array' => ':attribute harus memiliki antara :min dan :max items.',
    ],
    'boolean' => ':attribute bidang harus benar atau salah.',
    'confirmed' => ':attribute konfirmasi tidak cocok.',
    'current_password' => 'password salah.',
    'date' => ':attribute bukan tanggal yang valid.',
    'date_equals' => ':attribute harus tanggal yang sama dengan :date.',
    'date_format' => ':attribute tidak sesuai format :format.',
    'different' => ':attribute dan :other harus berbeda.',
    'digits' => ':attribute harus :digits angka.',
    'digits_between' => ':attribute harus antara :min dan :max digits.',
    'dimensions' => ':attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => ':attribute bidang memiliki nilai duplikat.',
    'email' => ':attribute harus alamat e-mail yang valid.',
    'ends_with' => ':attribute harus diakhiri dengan salah satu dari berikut ini: :values.',
    'exists' => ':attribute yang dipilih tidak valid',
    'file' => ':attribute harus berupa file.',
    'filled' => ':attribute bidang harus memiliki nilai.',
    'gt' => [
        'numeric' => ':attribute harus lebih besar dari :value.',
        'file' => ':attribute harus lebih besar dari :value kilobytes.',
        'string' => ':attribute harus lebih besar dari :value karakter.',
        'array' => ':attribute harus memiliki lebih dari :value items.',
    ],
    'gte' => [
        'numeric' => ':attribute harus lebih besar dari atau sama :value.',
        'file' => ':attribute harus lebih besar dari atau sama :value kilobytes.',
        'string' => ':attribute harus lebih besar dari atau sama :value karakter.',
        'array' => ':attribute harus mempunyai :value item atau lebih.',
    ],
    'image' => ':attribute harus berupa gambar.',
    'in' => ':attribute yang di pilih tidak valid',
    'in_array' => ':attribute bidang tidak ada di :other.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'ip' => ':attribute harus valid IP address.',
    'ipv4' => ':attribute harus valid IPv4 address.',
    'ipv6' => ':attribute harus valid IPv6 address.',
    'json' => ':attribute harus valid JSON string.',
    'lt' => [
        'numeric' => ':attribute harus kurang dari :value.',
        'file' => ':attribute harus kurang dari :value kilobytes.',
        'string' => ':attribute harus kurang dari :value karakter.',
        'array' => ':attribute harus memiliki kurang dari :value item.',
    ],
    'lte' => [
        'numeric' => ':attribute harus kurang dari atau sama :value.',
        'file' => ':attribute harus kurang dari atau sama :value kilobytes.',
        'string' => ':attribute harus kurang dari atau sama :value karakter.',
        'array' => ':attribute tidak boleh lebih dari :value item.',
    ],
    'max' => [
        'numeric' => ':attribute tidak boleh lebih besar dari :max.',
        'file' => ':attribute tidak boleh lebih besar dari :max kilobytes.',
        'string' => ':attribute tidak boleh lebih besar dari :max karakter.',
        'array' => ':attribute tidak boleh lebih dari :max item.',
    ],
    'mimes' => ':attribute harus berupa file dengan tipe: :values.',
    'mimetypes' => ':attribute harus berupa file dengan tipe: :values.',
    'min' => [
        'numeric' => ':attribute harus setidaknya :min.',
        'file' => ':attribute harus setidaknya :min kilobytes.',
        'string' => ':attribute harus setidaknya :min karakter.',
        'array' => ':attribute harus memiliki setidaknya :min item.',
    ],
    'multiple_of' => ':attribute harus kelipatan :value.',
    'not_in' => ':attribute yang dipilih tidak valid.',
    'not_regex' => ':attribute formatnya tidak valid.',
    'numeric' => ':attribute harus berupa angka.',
    'password' => 'password salah.',
    'present' => ':attribute harus ada',
    'regex' => ':attribute formatnya tidak valid.',
    'required' => ':attribute di perlukan',
    'required_if' => ':attribute diperlukan ketika :other adalah :value.',
    'required_unless' => ':attribute diperlukan kecuali :other ada di dalam :values.',
    'required_with' => ':attribute diperlukan ketika :values ada.',
    'required_with_all' => ':attribute diperlukan ketika :values ada.',
    'required_without' => ':attribute diperlukan ketika :values tidak ada.',
    'required_without_all' => ':attribute diperlukan ketika none of :values ada.',
    'prohibited' => ':attribute terlarang.',
    'prohibited_if' => ':attribute dilarang ketika :other adalah :value.',
    'prohibited_unless' => ':attribute dilarang kecuali :other didalam :values.',
    'prohibits' => ':attribute melarang :other untuk ada',
    'same' => ':attribute dan :other harus cocok.',
    'size' => [
        'numeric' => ':attribute harus :size.',
        'file' => ':attribute harus :size kilobytes.',
        'string' => ':attribute harus :size karakter.',
        'array' => ':attribute harus mengandung :size item.',
    ],
    'starts_with' => ':attribute harus dimulai dengan salah satu dari berikut ini: :values.',
    'string' => ':attribute harus berupa rangkaian karakter',
    'timezone' => ':attribute harus zona waktu yang valid',
    'unique' => ':attribute sudah diambil.',
    'uploaded' => ':attribute gagal diunggah.',
    'url' => ':attribute harus URL yang valid.',
    'uuid' => ':attribute harus memiliki UUID yang valid.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'gold_carat_category_id' => 'Karat',
        'shelf_id' => 'Rak',
        'category_id' => 'Kategori',
        'name' => 'Nama',
        'weight' => 'Berat', 
        'quantity' => 'Jumlah', 
        'image' => 'Gambar',
        'customerId' => 'Pelanggan',
        'pawnPrice' => 'Harga Gadai',
        'interestTotal' => 'Total Bunga',
        'totalPrice' => 'Total Harga',
        'deadlineDate' => 'Batas Pembayaran',
        'scaledWeight' => 'Berat Timbangan',
        'roleId' => 'Role',
        'currentPassword' => 'Password Sekarang',
        'newPassword' => 'Password Baru',
        'newConfirmPassword' => 'Konfirmasi Password'
    ],

];
