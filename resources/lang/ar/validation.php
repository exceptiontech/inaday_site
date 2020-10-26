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


    'accepted'             => 'لابد أن يكون  :attribute مقبولاً .',

    'active_url'           => ':attribute غير صحيح .',

    'after'                => ':attribute لابد أن يكون بعد :date.',

    'alpha'                => ':attribute من حروف.',

    'alpha_dash'           => ':attribute من حروف وأرقام ومسافات.', 

    'alpha_num'            => ':attribute من حروف وأرقام.',

    'array'                => 'لابد أن تكون :attribute مصفوفة.',

    'before'               => ':attribute لابد أن يكون قبل :date.',

    'between'              => [

        'numeric' => ':attribute يتراوح بين :min و :max.',

        'file'    => ':attribute يتراوح بين :min و :max.',

        'string'  => ':attribute يتراوح بين :min و :max.',

        'array'   => 'The :attribute يتراوح بين :min و :max  عنصر.',

    ],

    'boolean'              => ':attribute إمّا صح أو خطأ.',

    'confirmed'            => 'لابد من تطابق :attribute.',

    'date'                 => ':attribute غير صحيح.',

    'date_format'          => ':attribute غير متطابقة :format.',

    'different'            => 'يجب عدم تطابق :attribute مع :other.',

    'digits'               => ':attribute يتكون من :digits أرقام.',

    'digits_between'       => ':attribute يتراوح بين :min و :max رقم.',

    'dimensions'           => 'أبعاد :attribute غير صحيحة.',

    'distinct'             => 'توجد في :attribute قيمة مكررة.',

    'email'                => ':attribute غير صحيح.',

    'exists'               => ':attribute المختارة غير صحيحة.',

    'file'                 => ':attribute يتوجب ان يكون ملفاً.',

    'filled'               => ':attribute مطلوب/ة.',

    'image'                => ':attribute must be an image.',

    'in'                   => ':attribute المختارة غير صحيحة.',

    'in_array'             => ':attribute غير متاح في :other.',

    'integer'              => ':attribute يجب أن يكون رقمياً.',

    'ip'                   => ':attribute يجب أن يكون صحيحاً.',

    'json'                 => ':attribute يجب أن يكون بصيغة JSON.',

    'max'                  => [

        'numeric' => 'لا تزيد :attribute عن  :max.',

        'file'    => 'لا يزيد حجم :attribute عن :max كيلو بايت.',

        'string'  => 'محتوى :attribute لا يزيد عن :max حرف.',

        'array'   => 'عدد :attribute لا يزيد عن :max عناصر.',

    ],

    'mimes'                => ':attribute.. استخدم إحدى الصيغ: :values.',

    'mimetypes'            => ':attribute.. استخدم إحدى الصيغ: : :values.',

    'min'                  => [

        'numeric' => ':attribute لا يقل / تقل عن :min خانات.',

        'file'    => ':attribute لا يقل / تقل عن :min كيلو بايت.',

        'string'  => ':attribute لا يقل / تقل عن :min خانات.',

        'array'   => ':attribute يجب ألاّ تقل عن :min عناصر.',

    ],

    'not_in'               => ':attribute غير صحيح.',

    'numeric'              => ':attribute يجب أن يكون رقمياً.',

    'present'              => ':attribute يجب أن يكون حديثاً.',

    'regex'                => 'صيغة :attribute غير صحيحة.',

    'required'             => ':attribute مطلوب/ة.',

    'required_if'          => ':attribute field is required when :other is :value.',

    'required_unless'      => 'The :attribute field is required unless :other is in :values.',

    'required_with'        => 'The :attribute field is required when :values is present.',

    'required_with_all'    => 'The :attribute field is required when :values is present.',

    'required_without'     => 'The :attribute field is required when :values is not present.',

    'required_without_all' => 'The :attribute field is required when none of :values are present.',

    'same'                 => 'يجب  تطابق :attribute مع :other.',

    'size'                 => [

        'numeric' => ':attribute يجب أن يكون :size.',

        'file'    => ':attribute يجب أن يكون :size كيلو بايت.',

        'string'  => ':attribute يجب أن يكون :size أحرق.',

        'array'   => ':attribute يجب ألاّ تقل عن  :size عناصر.',

    ],

    'string'               => ':attribute يجب أن يكون اسماً.',

    'timezone'             => ':attribute يجب أن يكون توقيتاً صحيحاً.',

    'unique'               => ':attribute مختارة مسبقاً.',

    'uploaded'             => 'تعذر تحميل :attribute',

    'url'                  => ':attribute غير صحيح.',



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

        'password' => [

            'regex' => 'كلمة المرور تحتوي على رموز @$!%*#?& وحروف كبيرة وصغيرة وأرقام',

        ],

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

        'first_name' => 'الاسم الأول',

        'last_name' => 'الاسم الأخير',

        'password' => 'كلمة المرور',

        'mobile' => 'الجوال',

        'user_type' => 'نوع العضوية',

        'email' => 'البريد الإلكتروني',

        'start_date' => 'تاريخ البداية',

        'end_date' => 'تاريخ النهاية',

        'title' => 'الاسم',

        'desc' => 'التفاصيل',

        'image' => 'الصورة',

        'img' => 'الصورة',

        'files' => 'الملفات',

        'position' => 'الوظيفة',

        'company' => 'الشركة',

        'user_id' => 'المستخدم',

        'team_id' => 'الفريق',

        'section_id' => 'القسم',

        'users' => 'الأعضاء',

        'skills' => 'المهارات',

        'services' => 'الخدمات',

        'users' => 'الأعضاء',

        'applykind_id' => 'نوع التقديم',

        'num_team' => 'عدد الفريق',

        'cost' => 'التكلفة',

        'duration' => 'المدة',

        'review' => 'نص التقييم',

        'duration' => 'المدّة',



    ],



];



