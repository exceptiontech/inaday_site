<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Status;
use App\Department;
use App\Faq;
use App\Sponsor;
use App\Article;
use App\Page;
use App\Level;
use App\Prefer;
use App\Costkind;
use App\Applykind;
use App\Averagekind;
use App\Rewardkind;
use App\Readinesskind;
use App\Jobtype;
use App\Country;
use App\Skill;
use App\Stage;
use App\Section;
use App\Qtype;
use App\City;
use App\Beneficiary;
use App\Replaykind;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
           'name' => 'admin',
           'mobile' => '0540437879',
           'email' => 'admin@inaday.sa',
           'password' => bcrypt('admin987123')
        ]);

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        $role1 = Role::create(['name' => 'Manager']);
        $role2 = Role::create(['name' => 'employee']);
        $role3 = Role::create(['name' => 'content_editor']);
        $role4 = Role::create(['name' => 'services_provider']);
        $role5 = Role::create(['name' => 'entrepreneur']);
        $role5 = Role::create(['name' => 'student']);


        $title  = array();
        $title['ar'] = 'السعودية';
        $title['en'] = 'Saudi Arabia';

        $country = Country::create([
            'title' => $title,
            'slug' => 'saudi_arabia',
        ]);

        // $title  = array();
        // $title['ar'] = 'الامارات';
        // $title['en'] = 'Emirates';

        // $country = Country::create([
        //     'title' => $title,
        //     'slug' => 'emirates',
        // ]);


        $title  = array();
        $title['ar'] = 'الرياض';
        $title['en'] = 'Riyadh';

        $country = City::create([
            'title' => $title,
            'slug' => 'riyadh',
            'country_id' => '1',
        ]);


        $title  = array();
        $title['ar'] = 'الدمام';
        $title['en'] = 'Dammam';

        $country = City::create([
            'title' => $title,
            'slug' => 'Dammam',
            'country_id' => '1',
        ]);


        $title  = array();
        $title['ar'] = 'دبي';
        $title['en'] = 'dubai';

        $country = City::create([
            'title' => $title,
            'slug' => 'dubai',
            'country_id' => '2',
        ]);



        $title  = array();
        $title['ar'] = 'متاح';
        $title['en'] = 'available';

        $status = Status::create([
            'title' => $title,
            'slug' => 'available',
            'desc' => $title,
        ]);

        $title  = array();
        $title['ar'] = 'قيد التنفيذ';
        $title['en'] = 'pending';

        $status = Status::create([
            'title' => $title,
            'slug' => 'pending',
            'desc' => $title,
        ]);


        $title  = array();
        $title['ar'] = 'مكتمل';
        $title['en'] = 'complete';

        $status = Status::create([
            'title' =>  $title,
            'slug' => 'complete',
            'desc' =>  $title,
        ]);


        $title  = array();
        $title['ar'] = 'ملغي';
        $title['en'] = 'canceled';

        $status = Status::create([
            'title' =>  $title,
            'slug' => 'canceled',
            'desc' =>  $title,
        ]);




        $title  = array();
        $title['ar'] = 'مقدمي الخدمات';
        $title['en'] = 'services provider';
        $department = Department::create(['title' => $title,'slug' => 'servicesـprovider','type' => 'blog','desc' =>  $title]);



        $title  = array();
        $title['ar'] = 'رواد الاعمال';
        $title['en'] = 'entrepreneurs';
        $department2 = Department::create(['title' => $title,'slug' => 'entrepreneurs','type' => 'blog','desc' =>  $title]);


        $title  = array();
        $title['ar'] = 'مقدمي الخدمات';
        $title['en'] = 'services provider';
        $department = Department::create(['title' => $title,'slug' => 'servicesـprovider','type' => 'sponsors','desc' =>  $title]);


        $title  = array();
        $title['ar'] = 'رواد الاعمال';
        $title['en'] = 'entrepreneurs';
        $department2 = Department::create(['title' => $title,'slug' => 'entrepreneurs','type' => 'sponsors','desc' =>  $title]);

        $title  = array();
        $title['ar'] = 'مقدمي الخدمات';
        $title['en'] = 'services provider';
        $department = Department::create(['title' => $title,'slug' => 'servicesـprovider','type' => 'faqs','desc' =>  $title]);


        $title  = array();
        $title['ar'] = 'رواد الاعمال';
        $title['en'] = 'entrepreneurs';
        $department2 = Department::create(['title' => $title ,'slug' => 'entrepreneurs','type' => 'faqs','desc' =>  $title]);



        $title  = array();
        $title['ar'] = 'اقتراح';
        $title['en'] = 'suggest';
        $department = Department::create(['title' => $title,'slug' => 'suggest','type' => 'support','desc' =>  $title]);


        $title  = array();
        $title['ar'] = 'شكوى';
        $title['en'] = 'Complaint';
        $department = Department::create(['title' => $title,'slug' => 'Complaint','type' => 'support','desc' =>  $title]);




        $title  = array();
        $title['ar'] = 'برامج تعليمية تأهيلية وعلاجية متخصصة';
        $title['en'] = 'Specialized rehabilitative and therapeutic educational programs';
        $desc  = array();
        $desc['ar'] = 'برامج تعليمية تأهيلية وعلاجية متخصصة برامج تعليمية تأهيلية وعلاجية متخصصة برامج تعليمية تأهيلية وعلاجية متخصصة برامج تعليمية تأهيلية وعلاجية متخصصة برامج تعليمية تأهيلية وعلاجية متخصصة برامج تعليمية تأهيلية وعلاجية متخصصة برامج تعليمية تأهيلية وعلاجية متخصصة';
        $desc['en'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

        $article = Article::create(['title' =>  $title ,'slug' => 'private','department_id' => '1','desc' => $desc]);





        $title  = array();
        $title['ar'] = 'برامج تعليمية تأهيلية وعلاجية متخصصة';
        $title['en'] = 'Specialized rehabilitative and therapeutic educational programs';
        $desc  = array();
        $desc['ar'] = 'برامج تعليمية تأهيلية وعلاجية متخصصة برامج تعليمية تأهيلية وعلاجية متخصصة برامج تعليمية تأهيلية وعلاجية متخصصة برامج تعليمية تأهيلية وعلاجية متخصصة برامج تعليمية تأهيلية وعلاجية متخصصة برامج تعليمية تأهيلية وعلاجية متخصصة برامج تعليمية تأهيلية وعلاجية متخصصة';
        $desc['en'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
        $article = Article::create(['title' =>  $title ,'slug' => 'private','department_id' => '1','desc' => $desc]);



        $title  = array();
        $title['ar'] = 'وش فكرة منصة .انادي';
        $title['en'] = 'services provider';
        $answer  = array();
        $answer['ar'] = 'هي نموذج لإسلوب الحياة الرقمي، المتاح في كل مكان وزمان، ومجتمع لجذب الموهوبين والمتخصصين لخلق وظائف عن بعد وتأسيس أعمال تجارية ناجحة';
        $answer['en'] = 'هي نموذج لإسلوب الحياة الرقمي، المتاح في كل مكان وزمان، ومجتمع لجذب الموهوبين والمتخصصين لخلق وظائف عن بعد وتأسيس أعمال تجارية ناجحة';


        //$faq = Faq::create(['question' => $title,'department_id' => '5','slug' => 'servicesـprovider','answer' => $answer]);

        //$faq = Faq::create(['question' => $title,'department_id' => '6','slug' => 'servicesـprovider2','answer' => $answer]);




        $title  = array();
        $title['ar'] = 'سياسة الخصوصية';
        $title['en'] = 'Privacy policy';
        $desc  = array();
        $desc['ar'] = 'سياسة الخصوصية والاستخدام : مرحبا بكم في موقع (In.A.Day) أرجو الإطلاع على الشروط والأحكام بعناية قبل استخدام التطبيق والتصفح أو إضافة إعلان يعتبر إقرار منك بالموافقة على الشروط والأحكام تعنى (سياسة الخصوصية والاستخدام ) لدينا بطريقة جمعنا وحفظنا واستخدامنا وطريقة حماية معلوماتك الشخصية ومن المهم ان تقوم بالإطلاع سياسة الخصوصية هذه. ونقصد بالمعلومات الشخصية هي المعلومات التي ترتبط بشخص معين والتي تستخدم في التعريف عنه سياسة الخصوصية والاستخدام في تطبيق حاجة عن كيفية جمع واستخدام وحفظ البيانات الشخصية، كما نحرص على اتباع الإجراءات المتبعة لضمان حماية خصوصة المعلومات الشخصية لعملائنا الكرام والتى تستخدم في التعريف عن المستخدم للتطبيق. ومن المهم ان تقوم بالإطلاع على سياسة الخصوصية والاستخدام . لذا ومن خلال استخدامك للتطبيق، أنت توافق على التطبيقات المفصلة في هذه السياسة. ونحن نحرص في تطبيق حاجة على الاهتمام بمعلومات مستخدمي تطبيق التطبيق وبالتالي سوف يتم استخدام معلوماتك الشخصية التى تم ادخالها عند استخدامك للتطبيق كمعرف ومستخدم وغيرها من المعلومات التى تتعلق بك على النحو المبين في سياسة الخصوصية والاستخدام ، وسوف نقوم بجمع المعلومات عنك عند الضرورة وفي الحالات التى لها صلة مباشرة بمعاملاتنا معك . وسنقوم بالاحتفاظ ببياناتك إذا طلب منا بوجوب القانون أو لاستخدامها للأغراض التي جمعت لأجلها. 1. حفظ وتجميع البيانات كجزء من التسجيل على التطبيق أو استخدامه سوف يطب منك تزويدنا بمعلومات شخصية قد نحتاج لجمع المعلومات الخاصة بكَ إذا أردت تسجيل طلبية شراءٍ لسلعةٍ من تطبيقنا او استبدال او استرجاع ما تم شراؤه نقوم بجمع البيانات لازمة أخرى لتأمين أية مطالب محتملة قد تظهر لاحقا¬، ولتزويدكَ بالخدمات المتوفرة لدينا. مثال على ذلك ، الإسم والجنس وتاريخ الميلاد وعنوان البريد الإلكتروني والعنوان البريدي (إذا كان مختلفا) ورقم الهاتف ورقم الجوّال وتفاصيل الدفع أي تفاصيلٍ عن بطاقات الدفع أو تفاصيلٍ عن الحساب المصرفي. تستخدم المعلومات التي تقدّمها لتزويدكَ بمعلومات حول المنتجات والخدمات المتوفرة لدينا والتي تطلبها ، وللتحقق من المعاملات المالية التي تجريها على الإنترنت وإدارة حسابك الخاص. كما تستخدم هذه المعلومات في عمليات تدقيقَ تحميل البيانات من التطبيق وتحديد هويّة زائري التطبيق ، وتطوير تصاميم صفحات التطبيق و / أو محتوياته وتخصيصها للمستخدمين ، ونُرسلَ المعلوماتٍ المفيدة أو المطلوبة إلى المستخدم. ويتم التواصل عبر البريد الإلكتروني لتزويدكَ ببعض التفاصيل حول المنتجات والخدمات الأخرى إذا كنت ترغب في ذلك، وإذا قد يتم التواصل معك على رقم هاتفك لاعلامك بأي تحديث أو لأي اعلان عن آخر تخفيضاتنا وعروضنا الترويجية. يقوم وكيلنا بإدارة المعاملات المالية عبر الإنترنت. وما عليك فعله هو تقديم معلومات دقيقة وغير مضللة للوكيل أو الموقع، ويجدر بك تحديثها على الدوام وإبلاغنا بالتغييرات. قد نتمكن من تخزين التفاصيل المتعلقة بطلبيتك الحالية على موقعنا ولكن لا يمكننا سحبها مباشرةً لأسبابٍ أمنية. وبتسجيل الدخول إلى حسابك على التطبيق يمكنك الاطلاع على المعلومات وتفاصيل مشترياتك التي طلبتها أو التي ستتقدّم بها قريبًا. وبمقدورك أيضا إدارة تفاصيل عنوانك، والتفاصيل المصرفية وأية نشرةٍ إخباريةٍ قد اشتركت فيها. كما يجدر بك التعهد بالتعامل بسريّة تامة عند النّفاذ إلى بياناتك الشخصيّة فلا تجعلها متاحةً لطرف ثالث غير مصرّح به. نستخدم معلوماتك الشخصية لتقديم خدمات ودعم من فريق العملاء وبهدف قياس مستوى خدماتنا وتحسينها لك ومنع النشاطات غير القانونية وتنفيذ لبنود اتفاقية الاستخدام الموفقة معك ("اتفاقية الاستخدام")، اضافة الى حل المشاكل وجمع الرسوم وتزويدك برسائل الكترونية ترويجية وكذلك من اجل توثيق المعلومات التي زودتنا بها مع اطراف ثالثة مثلا قد نلجأ الى مشاركة بعض من معلوماتك الشخصية مع البنوك او التفويض لبطاقات الائتمان لمعالجة وتوثيق خدمات أو مع اطراف ثالثة لغايات التحقق من عمليات الاحتيال. برغم حرصنا للمحافظة على سرّيتك، الا اننا قد نحتاج الى الافصاح عن معلوماتك الشخصية لاجهزة تنفيذ القانون والهيئات الحكومية او اطراف ثالثة، نكون ملزمين بفعل ذلك باوامر من المحكمة اوغيرها من الدوائر القانونية لنكون ملتزمين ببنود القانون أو عند اعتقادنا ان الافصاح عن معلوماتك الشخصية ربما يقي من أذى جسدي او خسارة مالية او للاخبار عن نشاط مشبوه او للتحقيق في امكانية انتهاك لبنود وشروط اتفاقية المستخدم واية اتفاقيات أو لحماية الحقوق أو ملكية أو سلامة كيدزون أومستخدمينا أو الغير. قد نفصح عن معلوماتك الشخصية في حال تم بيع تطبيق كيدزون اي من الشركات الفرعية او التابعة لها أو اي من موجداتها المتعلقة باعمالها الى المشتري المحتمل وذلك بهدف استمرار نشاط التطبيق أو فيما يتعلق بهذا البيع للغايات الموضحة في هذه السياسة. قد نشارك معلوماتك الشخصية مع مجموعة الشركات الأخرى التابعة لنا للأغراض الموضحة في سياسة الخصوصية هذه. ان معلومات الاتصال ستكون المعلومات الشخصية التي قمت بتزويدنا بها عند التسجيل والتي يجب أن تبقى محدثة دائما. سيتم عرض المعلومات المتعلقة بالمنتجات التي تقوم بشرائها. يمكن أن تتضمن هذه المعلومات تفاصيل حول هوية المستخدم الخاصة بك والتقييمات والتعليقات المرتبطة باستخدامك للتطبيق. لا نبيع أو نؤجر اي من معلوماتك الشخصية لطرف ثالث ضمن نطاق عملنا التجاري المعتاد وسوف نشارك فقط معلوماتك الشخصية فقط وفق ما جاء في (سياسة الخصوصية) هنا. 2- الأمان نستخدم تقنيات وإجراءات الأمان الملائمة لمنع نفاذٍ غير مصرّح به أو غير قانوني لمعلوماتك أو فقدانها أو تدميرها . فعندما نجمع البيانات من خلال التطبيق، نقوم بتخزين معلوماتك الشخصية على قاعدة بيانات ضمن خادم إلكتروني آمن. فنستخدم أنظمة جدر الحماية على خوادمنا. وعندما نقوم بجمع تفاصيل بطاقات الدفع إلكترونيا، فإننا نحميها من خلال استخدام التشفير، مثل طبقة مآخذ التوصيل الآمنة (SSL ). فيصعب بالتالي على أيّ متسللٍ فكّ تشفير معلوماتك بما أننا لا نستطيع ضمان الحماية بنسبة مئة في المئة. وننصحك بشدة عدم إرسال كامل تفاصيل بطاقة الائتمان أو بطاقة السحب الآلي عندما تتواصل معنا إلكترونيا ومن دون تشفير. ونضع ضمانات مادية والكترونية وإجرائية مباشرة على عملية جمع معلوماتك اوالإفصاح عنها. وتتطلب إجراءاتنا الأمنية أن نطلب منك أحيانا إثبات هويتك قبل أن نفصح لك عن معلوماتك الشخصية. وتقع على عاتقك مسؤولية حماية كلمتك السرية وحاسوبك من أي نفاذ غير مصرح به. 3-اقرار عندما تقوم بارسال بيانات لنا أو لوكلائنا أو باستخدام التطبيق، فإنك توافق على استخدامنا لمعلوماتك على النحو المبين في هذه الخصوصية للتحقق من هويتك. 7في حال تشعر بالقلق على بياناتك، يحقّ لك طلب سياسة الخصوصية والاستخدام من خلال ارسال اميل الى خدمة العملاء';
        $desc['en'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';


        $page = Page::create(['title' => $title,'slug' => 'privacy_policy','desc' => $desc]);



        $title  = array();
        $title['ar'] = 'سياسة الاستخدام';
        $title['en'] = 'Usage policy';
        $desc  = array();
        $desc['ar'] = 'سياسة الخصوصية والاستخدام : مرحبا بكم في موقع (In.A.Day) أرجو الإطلاع على الشروط والأحكام بعناية قبل استخدام التطبيق والتصفح أو إضافة إعلان يعتبر إقرار منك بالموافقة على الشروط والأحكام تعنى (سياسة الخصوصية والاستخدام ) لدينا بطريقة جمعنا وحفظنا واستخدامنا وطريقة حماية معلوماتك الشخصية ومن المهم ان تقوم بالإطلاع سياسة الخصوصية هذه. ونقصد بالمعلومات الشخصية هي المعلومات التي ترتبط بشخص معين والتي تستخدم في التعريف عنه سياسة الخصوصية والاستخدام في تطبيق حاجة عن كيفية جمع واستخدام وحفظ البيانات الشخصية، كما نحرص على اتباع الإجراءات المتبعة لضمان حماية خصوصة المعلومات الشخصية لعملائنا الكرام والتى تستخدم في التعريف عن المستخدم للتطبيق. ومن المهم ان تقوم بالإطلاع على سياسة الخصوصية والاستخدام . لذا ومن خلال استخدامك للتطبيق، أنت توافق على التطبيقات المفصلة في هذه السياسة. ونحن نحرص في تطبيق حاجة على الاهتمام بمعلومات مستخدمي تطبيق التطبيق وبالتالي سوف يتم استخدام معلوماتك الشخصية التى تم ادخالها عند استخدامك للتطبيق كمعرف ومستخدم وغيرها من المعلومات التى تتعلق بك على النحو المبين في سياسة الخصوصية والاستخدام ، وسوف نقوم بجمع المعلومات عنك عند الضرورة وفي الحالات التى لها صلة مباشرة بمعاملاتنا معك . وسنقوم بالاحتفاظ ببياناتك إذا طلب منا بوجوب القانون أو لاستخدامها للأغراض التي جمعت لأجلها. 1. حفظ وتجميع البيانات كجزء من التسجيل على التطبيق أو استخدامه سوف يطب منك تزويدنا بمعلومات شخصية قد نحتاج لجمع المعلومات الخاصة بكَ إذا أردت تسجيل طلبية شراءٍ لسلعةٍ من تطبيقنا او استبدال او استرجاع ما تم شراؤه نقوم بجمع البيانات لازمة أخرى لتأمين أية مطالب محتملة قد تظهر لاحقا¬، ولتزويدكَ بالخدمات المتوفرة لدينا. مثال على ذلك ، الإسم والجنس وتاريخ الميلاد وعنوان البريد الإلكتروني والعنوان البريدي (إذا كان مختلفا) ورقم الهاتف ورقم الجوّال وتفاصيل الدفع أي تفاصيلٍ عن بطاقات الدفع أو تفاصيلٍ عن الحساب المصرفي. تستخدم المعلومات التي تقدّمها لتزويدكَ بمعلومات حول المنتجات والخدمات المتوفرة لدينا والتي تطلبها ، وللتحقق من المعاملات المالية التي تجريها على الإنترنت وإدارة حسابك الخاص. كما تستخدم هذه المعلومات في عمليات تدقيقَ تحميل البيانات من التطبيق وتحديد هويّة زائري التطبيق ، وتطوير تصاميم صفحات التطبيق و / أو محتوياته وتخصيصها للمستخدمين ، ونُرسلَ المعلوماتٍ المفيدة أو المطلوبة إلى المستخدم. ويتم التواصل عبر البريد الإلكتروني لتزويدكَ ببعض التفاصيل حول المنتجات والخدمات الأخرى إذا كنت ترغب في ذلك، وإذا قد يتم التواصل معك على رقم هاتفك لاعلامك بأي تحديث أو لأي اعلان عن آخر تخفيضاتنا وعروضنا الترويجية. يقوم وكيلنا بإدارة المعاملات المالية عبر الإنترنت. وما عليك فعله هو تقديم معلومات دقيقة وغير مضللة للوكيل أو الموقع، ويجدر بك تحديثها على الدوام وإبلاغنا بالتغييرات. قد نتمكن من تخزين التفاصيل المتعلقة بطلبيتك الحالية على موقعنا ولكن لا يمكننا سحبها مباشرةً لأسبابٍ أمنية. وبتسجيل الدخول إلى حسابك على التطبيق يمكنك الاطلاع على المعلومات وتفاصيل مشترياتك التي طلبتها أو التي ستتقدّم بها قريبًا. وبمقدورك أيضا إدارة تفاصيل عنوانك، والتفاصيل المصرفية وأية نشرةٍ إخباريةٍ قد اشتركت فيها. كما يجدر بك التعهد بالتعامل بسريّة تامة عند النّفاذ إلى بياناتك الشخصيّة فلا تجعلها متاحةً لطرف ثالث غير مصرّح به. نستخدم معلوماتك الشخصية لتقديم خدمات ودعم من فريق العملاء وبهدف قياس مستوى خدماتنا وتحسينها لك ومنع النشاطات غير القانونية وتنفيذ لبنود اتفاقية الاستخدام الموفقة معك ("اتفاقية الاستخدام")، اضافة الى حل المشاكل وجمع الرسوم وتزويدك برسائل الكترونية ترويجية وكذلك من اجل توثيق المعلومات التي زودتنا بها مع اطراف ثالثة مثلا قد نلجأ الى مشاركة بعض من معلوماتك الشخصية مع البنوك او التفويض لبطاقات الائتمان لمعالجة وتوثيق خدمات أو مع اطراف ثالثة لغايات التحقق من عمليات الاحتيال. برغم حرصنا للمحافظة على سرّيتك، الا اننا قد نحتاج الى الافصاح عن معلوماتك الشخصية لاجهزة تنفيذ القانون والهيئات الحكومية او اطراف ثالثة، نكون ملزمين بفعل ذلك باوامر من المحكمة اوغيرها من الدوائر القانونية لنكون ملتزمين ببنود القانون أو عند اعتقادنا ان الافصاح عن معلوماتك الشخصية ربما يقي من أذى جسدي او خسارة مالية او للاخبار عن نشاط مشبوه او للتحقيق في امكانية انتهاك لبنود وشروط اتفاقية المستخدم واية اتفاقيات أو لحماية الحقوق أو ملكية أو سلامة كيدزون أومستخدمينا أو الغير. قد نفصح عن معلوماتك الشخصية في حال تم بيع تطبيق كيدزون اي من الشركات الفرعية او التابعة لها أو اي من موجداتها المتعلقة باعمالها الى المشتري المحتمل وذلك بهدف استمرار نشاط التطبيق أو فيما يتعلق بهذا البيع للغايات الموضحة في هذه السياسة. قد نشارك معلوماتك الشخصية مع مجموعة الشركات الأخرى التابعة لنا للأغراض الموضحة في سياسة الخصوصية هذه. ان معلومات الاتصال ستكون المعلومات الشخصية التي قمت بتزويدنا بها عند التسجيل والتي يجب أن تبقى محدثة دائما. سيتم عرض المعلومات المتعلقة بالمنتجات التي تقوم بشرائها. يمكن أن تتضمن هذه المعلومات تفاصيل حول هوية المستخدم الخاصة بك والتقييمات والتعليقات المرتبطة باستخدامك للتطبيق. لا نبيع أو نؤجر اي من معلوماتك الشخصية لطرف ثالث ضمن نطاق عملنا التجاري المعتاد وسوف نشارك فقط معلوماتك الشخصية فقط وفق ما جاء في (سياسة الخصوصية) هنا. 2- الأمان نستخدم تقنيات وإجراءات الأمان الملائمة لمنع نفاذٍ غير مصرّح به أو غير قانوني لمعلوماتك أو فقدانها أو تدميرها . فعندما نجمع البيانات من خلال التطبيق، نقوم بتخزين معلوماتك الشخصية على قاعدة بيانات ضمن خادم إلكتروني آمن. فنستخدم أنظمة جدر الحماية على خوادمنا. وعندما نقوم بجمع تفاصيل بطاقات الدفع إلكترونيا، فإننا نحميها من خلال استخدام التشفير، مثل طبقة مآخذ التوصيل الآمنة (SSL ). فيصعب بالتالي على أيّ متسللٍ فكّ تشفير معلوماتك بما أننا لا نستطيع ضمان الحماية بنسبة مئة في المئة. وننصحك بشدة عدم إرسال كامل تفاصيل بطاقة الائتمان أو بطاقة السحب الآلي عندما تتواصل معنا إلكترونيا ومن دون تشفير. ونضع ضمانات مادية والكترونية وإجرائية مباشرة على عملية جمع معلوماتك اوالإفصاح عنها. وتتطلب إجراءاتنا الأمنية أن نطلب منك أحيانا إثبات هويتك قبل أن نفصح لك عن معلوماتك الشخصية. وتقع على عاتقك مسؤولية حماية كلمتك السرية وحاسوبك من أي نفاذ غير مصرح به. 3-اقرار عندما تقوم بارسال بيانات لنا أو لوكلائنا أو باستخدام التطبيق، فإنك توافق على استخدامنا لمعلوماتك على النحو المبين في هذه الخصوصية للتحقق من هويتك. 7في حال تشعر بالقلق على بياناتك، يحقّ لك طلب سياسة الخصوصية والاستخدام من خلال ارسال اميل الى خدمة العملاء';
        $desc['en'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

        $page = Page::create(['title' => $title,'slug' => 'usage_policy','desc' => $desc]);



        $title  = array();
        $title['ar'] = ' سياسة الاسترداد والإلغاء';
        $title['en'] = 'Refund Policy';
        $desc  = array();
        $desc['ar'] = 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل افتراضي كنموذج عن النص، وإذا قمت بإدخال "lorem ipsum" في أي محرك بحث ستظهر العديد من المواقع الحديثة العهد في نتائج البحث. على مدى السنين ظهرت نسخ جديدة ومختلفة من نص لوريم إيبسوم، أحياناً عن طريق الصدفة، وأحياناً عن عمد كإدخال بعض العبارات الفكاهية إليها.';
        $desc['en'] = 'Refund Policy';


        $page = Page::create(['title' => $title,'slug' => 'refund_policy','desc' => $desc]);


        $title  = array();
        $title['ar'] = ' كيف يعمل انادي ؟ ';
        $title['en'] = 'How Inaday Work?';
        $desc  = array();
        $desc['ar'] = 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل افتراضي كنموذج عن النص، وإذا قمت بإدخال "lorem ipsum" في أي محرك بحث ستظهر العديد من المواقع الحديثة العهد في نتائج البحث. على مدى السنين ظهرت نسخ جديدة ومختلفة من نص لوريم إيبسوم، أحياناً عن طريق الصدفة، وأحياناً عن عمد كإدخال بعض العبارات الفكاهية إليها.';
        $desc['en'] = 'How Inaday Work?.';


        $page = Page::create(['title' => $title,'slug' => 'how_inaday','desc' => $desc]);



        $title  = array();
        $title['ar'] = 'تصميم الهوية البصرية';
        $title['en'] = 'identity design';
        $skill = Skill::create([
            'title' => $title,
            'slug' => '1',
        ]);


        $title  = array();
        $title['ar'] = 'تصميم وبرمجة المنصات الالكترونية';
        $title['en'] = 'Designing and programming electronic platforms';
        $skill = Skill::create([
            'title' => $title,
            'slug' => '1',
        ]);


        $title  = array();
        $title['ar'] = 'تخليص المستندات الحكومية';
        $title['en'] = 'Clearance of government documents';
        $skill = Skill::create([
            'title' => $title,
            'slug' => '1',
        ]);

        $title  = array();
        $title['ar'] = 'تصميم العروض التقديمية';
        $title['en'] = 'Designing presentations';
        $skill = Skill::create([
            'title' => $title,
            'slug' => '1',
        ]);

        $title  = array();
        $title['ar'] = 'تصميم المواقع الالكترونية';
        $title['en'] = 'website design';
        $skill = Skill::create([
            'title' => $title,
            'slug' => '1',
        ]);

        $title  = array();
        $title['ar'] = 'تصميم الحملات الاعلانية';
        $title['en'] = 'Advertising campaigns design';
        $skill = Skill::create([
            'title' => $title,
            'slug' => '1',
        ]);

        $title  = array();
        $title['ar'] = 'تصميم الالعاب الالكترونية';
        $title['en'] = 'Electronic games design';
        $skill = Skill::create([
            'title' => $title,
            'slug' => '1',
        ]);




        $title  = array();
        $title['ar'] = 'عمل بدوام كلي';
        $title['en'] = 'full time';
        $jobtype = Jobtype::create([
            'title' => $title,
            'slug' => 'full_time',
        ]);

        $title  = array();
        $title['ar'] = 'عمل بدوام جزئي';
        $title['en'] = 'part time';
        $jobtype = Jobtype::create([
            'title' => $title,
            'slug' => 'part_time',
        ]);

        $title  = array();
        $title['ar'] = 'تدريب صيفي';
        $title['en'] = 'summer training';
        $jobtype = Jobtype::create([
            'title' => $title,
            'slug' => 'summer_training',
        ]);

        $title  = array();
        $title['ar'] = 'تطوع';
        $title['en'] = 'volunteering';
        $jobtype = Jobtype::create([
            'title' => $title,
            'slug' => 'volunteering',
        ]);

        $title  = array();
        $title['ar'] = 'عندما اكون متاح';
        $title['en'] = 'When I am available';
        $jobtype = Jobtype::create([
            'title' => $title,
            'slug' => 'When_I_am_available',
        ]);


        $title  = array();
        $title['ar'] = 'مستوى متقدم لا احتاج تدريب';
        $title['en'] = 'مستوى متقدم لا احتاج تدريب';
        $level = Level::create([
            'title' => $title,
            'slug' => '1',
        ]);


        $title  = array();
        $title['ar'] = 'مستوى متوسط بحاجة لبعض التدريب';
        $title['en'] = 'مستوى متوسط بحاجة لبعض التدريب';
        $level = Level::create([
            'title' => $title,
            'slug' => '2',
        ]);

        $title  = array();
        $title['ar'] = 'مستوى مبتدئ ااحتاج تدريب مكثف';
        $title['en'] = 'مستوى متوسط بحاجة لبعض التدريب';
        $level = Level::create([
            'title' => $title,
            'slug' => '3',
        ]);

        $title  = array();
        $title['ar'] = 'افضل العمل الفردي';
        $title['en'] = 'افضل العمل الفردي';
        $prefer = Prefer::create([
            'title' => $title,
            'slug' => '1',
        ]);

        $title  = array();
        $title['ar'] = 'افضل العمل مع فريق';
        $title['en'] = 'افضل العمل مع فريق';
        $prefer = Prefer::create([
            'title' => $title,
            'slug' => '2',
        ]);


        $title  = array();
        $title['ar'] = 'افضل ادير فريق';
        $title['en'] = 'افضل ادير فريق';
        $prefer = Prefer::create([
            'title' => $title,
            'slug' => '3',
        ]);

        $title  = array();
        $title['ar'] = 'تكلفة بالساعة';
        $title['en'] = 'تكلفة بالساعة';
        $Costkind = Costkind::create([
            'title' => $title,
            'slug' => '1',
        ]);

        // $title  = array();
        // $title['ar'] = 'تكلفة بالمشروع';
        // $title['en'] = 'تكلفة بالمشروع';
        // $Costkind = Costkind::create([
        //     'title' => $title,
        //     'slug' => '2',
        // ]);


        $title  = array();
        $title['ar'] = 'عام';
        $title['en'] = 'عام';
        $Applykind = Applykind::create([
            'title' => $title,
            'slug' => '1',
        ]);

        $title  = array();
        $title['ar'] = 'خاص';
        $title['en'] = 'خاص';
        $Applykind = Applykind::create([
            'title' => $title,
            'slug' => '2',
        ]);

        
        $title  = array();
        $title['ar'] = 'جميع ماسبق';
        $title['en'] = 'all the above';
        $Applykind = Applykind::create([
            'title' => $title,
            'slug' => '3',
        ]);


        $title  = array();
        $title['ar'] = 'تصاعدي';
        $title['en'] = 'تصاعدي';
        $Averagekind = Averagekind::create([
            'title' => $title,
            'slug' => '1',
        ]);

        $title  = array();
        $title['ar'] = 'الحد الادني للمهمه';
        $title['en'] = 'الحد الادني للمهمه';
        $Averagekind = Averagekind::create([
            'title' => $title,
            'slug' => '2',
        ]);

        $title  = array();
        $title['ar'] = 'الحد الاعلى للمهمه';
        $title['en'] = 'الحد الاعلى للمهمه';
        $Averagekind = Averagekind::create([
            'title' => $title,
            'slug' => '3',
        ]);

        $title  = array();
        $title['ar'] = 'مبلغ مقطوع بالساعة';
        $title['en'] = 'مبلغ مقطوع بالساعة';
        $Averagekind = Averagekind::create([
            'title' => $title,
            'slug' => '4',
        ]);

        $title  = array();
        $title['ar'] = 'حسب تحديد صاحب المشروع';
        $title['en'] = 'حسب تحديد صاحب المشروع';
        $Averagekind = Averagekind::create([
            'title' => $title,
            'slug' => '5',
        ]);

        $title  = array();
        $title['ar'] = 'تطوع';
        $title['en'] = 'تطوع';
        $Averagekind = Averagekind::create([
            'title' => $title,
            'slug' => '6',
        ]);

        $title  = array();
        $title['ar'] = 'فردية حسب انجازي';
        $title['en'] = 'فردية حسب انجازي';
        $Rewardkind = Rewardkind::create([
            'title' => $title,
            'slug' => '1',
        ]);


        $title  = array();
        $title['ar'] = 'توزع بالتساوي على فريق العمل';
        $title['en'] = 'توزع بالتساوي على فريق العمل';
        $Rewardkind = Rewardkind::create([
            'title' => $title,
            'slug' => '2',
        ]);

        $title  = array();
        $title['ar'] = 'حسب تحديد صاحب المشروع';
        $title['en'] = 'حسب تحديد صاحب المشروع';
        $Rewardkind = Rewardkind::create([
            'title' => $title,
            'slug' => '3',
        ]);

        $title  = array();
        $title['ar'] = 'التبرع بها لدعم مشاريع اخرى';
        $title['en'] = 'التبرع بها لدعم مشاريع اخرى';
        $Rewardkind = Rewardkind::create([
            'title' => $title,
            'slug' => '4',
        ]);


        // $title  = array();
        // $title['ar'] = 'ترشيحي لدورات متخصصة';
        // $title['en'] = 'ترشيحي لدورات متخصصة';
        // $Rewardkind = Rewardkind::create([
        //     'title' => $title,
        //     'slug' => '5',
        // ]);


        $title  = array();
        $title['ar'] = 'مستعد الان ابدأ';
        $title['en'] = 'مستعد الان ابدأ';
        $Readinesskind = Readinesskind::create([
            'title' => $title,
            'slug' => '1',
        ]);


        $title  = array();
        $title['ar'] = 'مستعد وببدأ بعد اسبوع';
        $title['en'] = 'مستعد وببدأ بعد اسبوع';
        $Readinesskind = Readinesskind::create([
            'title' => $title,
            'slug' => '2',
        ]);


        $title  = array();
        $title['ar'] = 'ابي ابدأ الان ولكن عندي مشكلة';
        $title['en'] = 'ابي ابدأ الان ولكن عندي مشكلة';
        $Readinesskind = Readinesskind::create([
            'title' => $title,
            'slug' => '3',
        ]);


        $title  = array();
        $title['ar'] = 'ما زلت متردد';
        $title['en'] = 'ما زلت متردد';
        $Readinesskind = Readinesskind::create([
            'title' => $title,
            'slug' => '4',
        ]);


        $title  = array();
        $title['ar'] = 'التصميم الجرافيكي ( هوية المشروع )';
        $title['en'] = 'التصميم الجرافيكي ( هوية المشروع )';
        $section = Section::create([
            'title' => $title,
            'slug' => 'graphic_design', 
        ]);

        $title  = array();
        $title['ar'] = 'تصميم موقع إلكتروني UI/UX';
        $title['en'] = 'تصميم موقع إلكتروني UI/UX';
        $section = Section::create([
            'title' => $title,
            'slug' => 'ui_ux', 
        ]);

        $title  = array();
        $title['ar'] = 'إنشاء موقع إلكتروني Web Development';
        $title['en'] = 'إنشاء موقع إلكتروني Web Development';
        $section = Section::create([
            'title' => $title,
            'slug' => 'web', 
        ]);

        $title  = array();
        $title['ar'] = 'إنهاء الإجراءات الحكومية للبدء بالمشروع';
        $title['en'] = 'إنهاء الإجراءات الحكومية للبدء بالمشروع';
        $section = Section::create([
            'title' => $title,
            'slug' => 'graphic_design', 
        ]);

        $title  = array();
        $title['ar'] = 'الهوية البصرية';
        $title['en'] = 'الهوية البصرية';
        $section = Section::create([
            'title' => $title,
            'slug' => 'graphic_design', 
        ]);
        

        $title  = array();
        $title['ar'] = 'ماعندي حتى فكرة، بس لازم أبدء';
        $title['en'] = 'ماعندي حتى فكرة، بس لازم أبدء';
        $stage = Stage::create([
            'title' => $title,
            'slug' => '1',
        ]);

        $title  = array();
        $title['ar'] = 'فكرة';
        $title['en'] = 'فكرة';
        $stage = Stage::create([
            'title' => $title,
            'slug' => '2',
        ]);

        $title  = array();
        $title['ar'] = 'بديت بشكل بسيط و يدوي';
        $title['en'] = 'بديت بشكل بسيط و يدوي';
        $stage = Stage::create([
            'title' => $title,
            'slug' => '3',
        ]);

        $title  = array();
        $title['ar'] = 'بديت من زمان بشكل بسيط بس وقفت';
        $title['en'] = 'بديت من زمان بشكل بسيط بس وقفت';
        $stage = Stage::create([
            'title' => $title,
            'slug' => '4',
        ]);

        $title  = array();
        $title['ar'] = 'بديت بشكل متوسط من خلال حسابات التواصل';
        $title['en'] = 'بديت بشكل متوسط من خلال حسابات التواصل';
        $stage = Stage::create([
            'title' => $title,
            'slug' => '5',
        ]);


        $title  = array();
        $title['ar'] = 'عندي منصة، بس احتاج أطور العمل بشكل أكثر';
        $title['en'] = 'عندي منصة، بس احتاج أطور العمل بشكل أكثر';
        $stage = Stage::create([
            'title' => $title,
            'slug' => '6',
        ]);

        $title  = array();
        $title['ar'] = 'أجهز مشروعي لجولة استثمارية';
        $title['en'] = 'أجهز مشروعي لجولة استثمارية';
        $stage = Stage::create([
            'title' => $title,
            'slug' => '7',
        ]);


        $title  = array();
        $title['ar'] = 'سؤال حواري';
        $title['en'] = 'Discussion question';
        $desc  = array();
        $desc['ar'] = 'سؤال حواري';
        $desc['en'] = 'Discussion question';
        $qtypes = Qtype::create([
            'title' => $title,
            'desc' => $desc,
        ]);

        $title  = array();
        $title['ar'] = 'سؤال اختيار';
        $title['en'] = 'Choice question';
        $desc  = array();
        $desc['ar'] = 'سؤال اختيار';
        $desc['en'] = 'Choice question';
        $qtypes = Qtype::create([
            'title' => $title,
            'desc' => $desc,
        ]);


        $title  = array();
        $subtitle  = array();
        $desc  = array();
        $title['ar'] = 'مقدم الخدمة';
        $title['en'] = 'services provider';
        $subtitle['ar'] = 'باحث عن عمل';
        $subtitle['en'] = 'Looking for job';
        $desc['ar'] = 'هو كل موهوب ومتخصص عنده الرغبة بالتعلم و تطوير مهاراته ومن ثم تقديمها كخدمة تساعد أصحاب الأعمال في تأسيس مشاريعهم وتنفيذ أعمالهم بأقل الأسعار.
مقدم الخدمة ممكن يعمل وقت كامل أو جزئي أو حسب مباشر حسب الطلب.
مقدم الخدمة ممكن يكون موظف يرغب بتحويل عمله ليكون عن بعد، ممكن يكون دكتور, ربة منزل, متقاعد، أو حتى طالب.';
        $desc['en'] = 'He is a talented and specialized individual who has the desire to learn and develop his skills and then provide it as a service that helps business owners in establishing their projects and carrying out their work at the lowest prices.
The service provider can work full or part time or according to direct request.
The service provider may be an employee who wants to convert his work to be remotely, it may be a doctor, a housewife, a retiree, or even a student.';
        $beneficiary = Beneficiary::create(['title' => $title,'subtitle' => $subtitle,'desc' =>  $desc ,'image'=>'assets/images/img1.jpg']);


        $title  = array();
        $subtitle  = array();
        $desc  = array();
        $title['ar'] = 'صاحب المشروع';
        $title['en'] = 'entrepreneur';
        $subtitle['ar'] = 'رواد الأعمال الجدد';
        $subtitle['en'] = 'New entrepreneurs';
        $desc['ar'] = 'هو كل مبادر و صاحب فكرة وعزيمة لديه حلم في بدء أعمال تجارية، تخدمه وتخدم مجتمعه و تكون سبب في خلق الوظائف، و يكون ملهم و قدوة ومثال لجيل الرؤية.';
        $desc['en'] = 'He is every entrepreneur and one who has an idea and a determination that has a dream in starting a business, serving him and serving his community and being a reason in creating jobs, and it is an inspiration and role model and example for the generation of vision.';
        $beneficiary = Beneficiary::create(['title' => $title,'subtitle' => $subtitle,'desc' =>  $desc ,'image'=>'assets/images/img2.jpg']);




        $title  = array();
        $title['ar'] = 'تعليق او استفسار';
        $title['en'] = 'comment';
        $replaykind = Replaykind::create([
            'title' => $title,
            'slug' => 'comment',
        ]);

        $title  = array();
        $title['ar'] = 'طلب مهلة';
        $title['en'] = 'request duration';
        $replaykind = Replaykind::create([
            'title' => $title,
            'slug' => 'request_duration',
        ]);

        $title  = array();
        $title['ar'] = 'طلب تعميد تسلم المشروع';
        $title['en'] = 'confirm booking';
        $replaykind = Replaykind::create([
            'title' => $title,
            'slug' => 'confirm_booking',
        ]);



    }
}
