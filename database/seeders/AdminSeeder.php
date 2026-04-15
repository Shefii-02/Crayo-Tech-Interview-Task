<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Form;
use App\Models\FormField;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. CREATE ADMIN
        |--------------------------------------------------------------------------
        */
        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 2. CREATE SAMPLE USERS (COMPANY USERS)
        |--------------------------------------------------------------------------
        */
        $companyUser = User::create([
            'name'     => 'Company User',
            'email'    => 'company@test.com',
            'password' => Hash::make('password123'),
            'role'     => 'user',
        ]);

        $users = [
            ['name' => 'John Doe', 'email' => 'john@example.com'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ['name' => 'Bob Johnson', 'email' => 'bob@example.com'],
            ['name' => 'Alice Brown', 'email' => 'alice@example.com'],
        ];

        foreach ($users as $userData) {
            User::create([
                'name'     => $userData['name'],
                'email'    => $userData['email'],
                'password' => Hash::make('password123'),
                'role'     => 'user',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. FORM 1 — CONTACT FORM
        |--------------------------------------------------------------------------
        */
        $form = Form::create([
            'title'      => 'Contact Inquiry Form',
            'status'     => 1,
            'created_by' => $admin->id,
            'company_id' => $companyUser->id,
        ]);

        // Default Fields
        FormField::create([
            'form_id' => $form->id,
            'label' => 'Full Name',
            'type' => 'text',
            'name' => Str::slug('Full Name'),
            'required' => true,
            'order' => 1,
            'is_default' => true,
            'placeholder' => 'Enter your full name'
        ]);

        FormField::create([
            'form_id' => $form->id,
            'label' => 'Email Address',
            'type' => 'email',
            'name' => Str::slug('Email Address'),
            'required' => true,
            'order' => 2,
            'is_default' => true,
            'placeholder' => 'Enter your email'
        ]);

        FormField::create([
            'form_id' => $form->id,
            'label' => 'Phone Number',
            'type' => 'text',
            'name' => Str::slug('Phone Number'),
            'required' => false,
            'order' => 3,
            'is_default' => true,
            'placeholder' => 'Enter your phone'
        ]);

        // Dynamic Fields
        FormField::create([
            'form_id' => $form->id,
            'label' => 'Subject',
            'type' => 'dropdown',
            'name' => 'subject',
            'required' => true,
            'order' => 4,
            'options' => json_encode(['General', 'Support', 'Sales', 'Billing']),
        ]);

        FormField::create([
            'form_id' => $form->id,
            'label' => 'Message',
            'type' => 'text',
            'name' => 'message',
            'required' => true,
            'order' => 5,
            'validation_rules' => json_encode(['min:10', 'max:1000']),
        ]);

        FormField::create([
            'form_id' => $form->id,
            'label' => 'Age',
            'type' => 'number',
            'name' => 'age',
            'required' => false,
            'order' => 6,
            'validation_rules' => json_encode(['min:18', 'max:100']),
        ]);

        /*
        |--------------------------------------------------------------------------
        | 4. FORM 2 — EVENT REGISTRATION
        |--------------------------------------------------------------------------
        */
        $form2 = Form::create([
            'title'      => 'Event Registration',
            'status'     => 1,
            'created_by' => $admin->id,
            'company_id' => $companyUser->id,
        ]);

        // Default Fields
        FormField::create([
            'form_id' => $form2->id,
            'label' => 'Full Name',
            'type' => 'text',
            'name' => 'name',
            'required' => true,
            'order' => 1,
            'is_default' => true
        ]);

        FormField::create([
            'form_id' => $form2->id,
            'label' => 'Email',
            'type' => 'email',
            'name' => 'email',
            'required' => true,
            'order' => 2,
            'is_default' => true
        ]);

        FormField::create([
            'form_id' => $form2->id,
            'label' => 'Phone',
            'type' => 'text',
            'name' => 'phone',
            'required' => false,
            'order' => 3,
            'is_default' => true
        ]);

        // Dynamic Fields
        FormField::create([
            'form_id' => $form2->id,
            'label' => 'Session Preference',
            'type' => 'checkbox',
            'name' => 'sessions',
            'required' => false,
            'order' => 4,
            'options' => json_encode([
                'Morning Session',
                'Afternoon Session',
                'Workshop',
                'Networking Dinner'
            ]),
        ]);

        FormField::create([
            'form_id' => $form2->id,
            'label' => 'Registration Date',
            'type' => 'date',
            'name' => 'registration_date',
            'required' => true,
            'order' => 5,
        ]);
    }
}
