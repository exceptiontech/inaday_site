<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

           'employe-list',
           'employe-create',
           'employe-edit',
           'employe-delete',

           'user-list',
           'user-create',
           'user-edit',
           'user-delete',

           'role-list',
           'role-create',
           'role-edit',
           'role-delete',

           'status-list',
           'status-create',
           'status-edit',
           'status-delete',

           'department-list',
           'department-create',
           'department-edit',
           'department-delete',
           'article-list',
           'article-create',
           'article-edit',
           'article-delete',

           'section-list',
           'section-create',
           'section-edit',
           'section-delete',

           'project-list',
           'project-create',
           'project-edit',
           'project-delete',

           'service-list',
           'service-create',
           'service-edit',
           'service-delete',

           'country-list',
           'country-create',
           'country-edit',
           'country-delete',
           'city-list',
           'city-create',
           'city-edit',
           'city-delete',


           'page-list',
           'page-create',
           'page-edit',
           'page-delete',

           'order-list',
           'order-create',
           'order-edit',
           'order-delete',

           'invoice-list',
           'invoice-create',
           'invoice-edit',

           'faq-list',
           'faq-create',
           'faq-edit',
           'faq-delete',

           'question-list',
           'question-create',
           'question-edit',
           'question-delete',



           'level-list',
           'level-create',
           'level-edit',
           'level-delete',

           
           'prefer-list',
           'prefer-create',
           'prefer-edit',
           'prefer-delete',
           
           'rewardkind-list',
           'rewardkind-create',
           'rewardkind-edit',
           'rewardkind-delete',

           'readinesskind-list',
           'readinesskind-create',
           'readinesskind-edit',
           'readinesskind-delete',

           
           'costkind-list',
           'costkind-create',
           'costkind-edit',
           'costkind-delete',
           
           'sponsor-list',
           'sponsor-create',
           'sponsor-edit',
           'sponsor-delete',


           'applykind-list',
           'applykind-create',
           'applykind-edit',
           'applykind-delete',

           'averagekind-list',
           'averagekind-create',
           'averagekind-edit',
           'averagekind-delete',

           'jobtype-list',
           'jobtype-create',
           'jobtype-edit',
           'jobtype-delete',

           'skill-list',
           'skill-create',
           'skill-edit',
           'skill-delete',

           'stage-list',
           'stage-create',
           'stage-edit',
           'stage-delete',

           'qtype-list',
           'qtype-create',
           'qtype-edit',
           'qtype-delete',


           'beneficiary-list',
           'beneficiary-create',
           'beneficiary-edit',
           'beneficiary-delete',

           'booking-list',
           'booking-create',
           'booking-edit',
           'booking-delete',

           'contactus-list',
           'contactus-create',
           'contactus-edit',
           'contactus-delete',

           'file-list',
           'file-create',
           'file-edit',
           'file-delete',

           'image-list',
           'image-create',
           'image-edit',
           'image-delete',

           'interview-list',
           'interview-create',
           'interview-edit',
           'interview-delete',

           'offer-list',
           'offer-create',
           'offer-edit',
           'offer-delete',

           'payment-list',
           'payment-create',
           'payment-edit',
           'payment-delete',

           'phase-list',
           'phase-create',
           'phase-edit',
           'phase-delete',

           'qoption-list',
           'qoption-create',
           'qoption-edit',
           'qoption-delete',

           'userdetail-list',
           'userdetail-create',
           'userdetail-edit',
           'userdetail-delete',



           'reports-list',
           'logs-list',
        ];


        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
