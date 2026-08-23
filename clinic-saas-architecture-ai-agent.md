# Clinic SaaS – Full Architecture & AI Agent Implementation Guide

### Laravel \+ Blade | Multi-Tenant Clinic Management System (OB-GYN)

This document is written so an **AI coding agent** (e.g., Claude Code) can implement the entire project **task by task**, following one consistent architecture, without deviating between modules.

---

## 1\. Tech Stack

| Layer | Technology |
| :---- | :---- |
| Backend Framework | Laravel 11.x |
| Views | Blade Templates \+ Blade Components |
| Interactivity | Livewire 3 \+ Alpine.js |
| Styling | Tailwind CSS |
| Database | MySQL 8 |
| Auth | Laravel Breeze (Blade stack) \+ Spatie Laravel-Permission |
| PDF Generation | barryvdh/laravel-dompdf |
| Calendar | FullCalendar.js (via Blade \+ Alpine) |
| Notifications | Laravel Notifications \+ Queues (Email/SMS/WhatsApp) |
| Charts | Chart.js |
| File Storage | Laravel Storage (local/S3) |
| Payments | Paymob / Stripe SDK |
| Testing | Pest PHP |

---

## 2\. High-Level Architecture

                          ┌─────────────────────────┐

                          │        Browser           │

                          │  Blade Views \+ Livewire   │

                          └────────────┬─────────────┘

                                       │

                          ┌────────────▼─────────────┐

                          │   Route Groups (3 areas)  │

                          │  /admin  /doctor  /patient│

                          └────────────┬─────────────┘

                                       │

                    ┌──────────────────┼──────────────────┐

                    │                  │                  │

            ┌───────▼──────┐  ┌────────▼───────┐  ┌───────▼───────┐

            │ Auth Middleware│  │ Role Middleware │  │ Tenant Scope  │

            │ (per guard)    │  │ (Spatie)        │  │ Middleware    │

            └───────┬──────┘  └────────┬───────┘  └───────┬───────┘

                    └──────────────────┼──────────────────┘

                                       │

                          ┌────────────▼─────────────┐

                          │      Controllers          │

                          │  (Admin/Doctor/Patient)   │

                          └────────────┬─────────────┘

                                       │

                          ┌────────────▼─────────────┐

                          │   Services / Actions      │

                          │ (business logic layer)    │

                          └────────────┬─────────────┘

                                       │

                          ┌────────────▼─────────────┐

                          │        Models             │

                          │  (Eloquent \+ Global Scope) │

                          └────────────┬─────────────┘

                                       │

                          ┌────────────▼─────────────┐

                          │         MySQL             │

                          └───────────────────────────┘

**Key principle:** Every table except `users`, `clinics`, `subscription_plans`, `roles`, `permissions` has a `clinic_id` column and is auto-scoped via a Global Scope \+ Middleware — this is what makes it Multi-Tenant.

---

## 3\. Folder / File Structure

app/

├── Http/

│   ├── Controllers/

│   │   ├── Admin/

│   │   │   ├── DashboardController.php

│   │   │   ├── ClinicController.php

│   │   │   ├── UserController.php

│   │   │   ├── RoleController.php

│   │   │   ├── SubscriptionPlanController.php

│   │   │   ├── BillingController.php

│   │   │   ├── ReportController.php

│   │   │   └── SettingController.php

│   │   ├── Doctor/

│   │   │   ├── DashboardController.php

│   │   │   ├── AssistantController.php

│   │   │   ├── PermissionController.php

│   │   │   ├── ClinicProfileController.php

│   │   │   ├── PatientController.php

│   │   │   ├── AppointmentController.php

│   │   │   ├── PregnancyController.php

│   │   │   ├── PrescriptionController.php

│   │   │   ├── InvoiceController.php

│   │   │   ├── ReportController.php

│   │   │   └── SubscriptionController.php

│   │   └── Patient/

│   │       ├── DashboardController.php

│   │       ├── AppointmentController.php

│   │       ├── PregnancyController.php

│   │       ├── PrescriptionController.php

│   │       ├── InvoiceController.php

│   │       └── MedicalProfileController.php

│   ├── Middleware/

│   │   ├── EnsureClinicIsActive.php

│   │   ├── ScopeToClinic.php

│   │   ├── CheckSubscriptionLimit.php

│   │   └── RoleRedirect.php

│   └── Requests/

│       ├── Admin/...

│       ├── Doctor/...

│       └── Patient/...

├── Models/

│   ├── User.php

│   ├── Clinic.php

│   ├── SubscriptionPlan.php

│   ├── ClinicSubscription.php

│   ├── Patient.php

│   ├── Appointment.php

│   ├── Pregnancy.php

│   ├── PregnancyExam.php

│   ├── Prescription.php

│   ├── PrescriptionItem.php

│   ├── Invoice.php

│   ├── Service.php

│   └── AuditLog.php

├── Services/

│   ├── AppointmentService.php

│   ├── PregnancyService.php

│   ├── PrescriptionPdfService.php

│   ├── InvoicePdfService.php

│   ├── SubscriptionLimitService.php

│   └── NotificationService.php

├── Traits/

│   └── BelongsToClinic.php

├── Enums/

│   ├── AppointmentStatus.php

│   ├── InvoiceStatus.php

│   └── SubscriptionStatus.php

└── Notifications/

    ├── AppointmentReminder.php

    ├── PrescriptionReady.php

    └── InvoiceIssued.php

resources/

└── views/

    ├── layouts/

    │   ├── admin.blade.php

    │   ├── doctor.blade.php

    │   ├── patient.blade.php

    │   └── guest.blade.php

    ├── components/

    │   ├── card.blade.php

    │   ├── table.blade.php

    │   ├── modal.blade.php

    │   ├── button.blade.php

    │   ├── input.blade.php

    │   ├── badge.blade.php

    │   └── alert.blade.php

    ├── admin/

    │   ├── dashboard/index.blade.php

    │   ├── clinics/{index,create,edit,show}.blade.php

    │   ├── users/index.blade.php

    │   ├── roles/{index,create,edit}.blade.php

    │   ├── subscriptions/{index,create,edit}.blade.php

    │   ├── billing/index.blade.php

    │   ├── reports/index.blade.php

    │   └── settings/index.blade.php

    ├── doctor/

    │   ├── dashboard/index.blade.php

    │   ├── assistants/{index,create,edit}.blade.php

    │   ├── clinic-profile/edit.blade.php

    │   ├── patients/{index,create,edit,show}.blade.php

    │   ├── appointments/index.blade.php

    │   ├── pregnancies/{create,show}.blade.php

    │   ├── prescriptions/create.blade.php

    │   ├── invoices/{index,create}.blade.php

    │   ├── reports/index.blade.php

    │   ├── subscription/index.blade.php

    │   └── settings/index.blade.php

    └── patient/

        ├── auth/{login,register}.blade.php

        ├── dashboard/index.blade.php

        ├── appointments/{index,create}.blade.php

        ├── pregnancy/show.blade.php

        ├── prescriptions/index.blade.php

        ├── invoices/index.blade.php

        ├── medical-profile/edit.blade.php

        └── settings/index.blade.php

routes/

├── admin.php

├── doctor.php

├── patient.php

└── web.php   (includes the 3 above with prefixes \+ middleware groups)

---

## 4\. Database Schema (Core Tables)

users

 ├─ id, name, email, phone, password, user\_type(admin|doctor|assistant|patient)

 ├─ clinic\_id (nullable for super admin)

 └─ timestamps

clinics

 ├─ id, name, owner\_id(doctor user\_id), address, logo, phone

 ├─ status(active|suspended), timezone

 └─ timestamps

subscription\_plans

 ├─ id, name, price, patient\_limit, user\_limit, features(json)

 └─ timestamps

clinic\_subscriptions

 ├─ id, clinic\_id, plan\_id, status, starts\_at, ends\_at

 └─ timestamps

roles / permissions / role\_has\_permissions / model\_has\_roles   (Spatie package tables)

patients

 ├─ id, clinic\_id, user\_id(nullable), full\_name, phone, dob

 ├─ medical\_history(json)

 └─ timestamps

appointments

 ├─ id, clinic\_id, patient\_id, doctor\_id, date, time, status(pending|confirmed|cancelled|done)

 └─ timestamps

pregnancies

 ├─ id, clinic\_id, patient\_id, lmp\_date, edd\_date, status(active|delivered|miscarried)

 └─ timestamps

pregnancy\_exams

 ├─ id, pregnancy\_id, exam\_type, exam\_date, result(json/file\_path)

 └─ timestamps

prescriptions

 ├─ id, clinic\_id, patient\_id, doctor\_id, notes, pdf\_path

 └─ timestamps

prescription\_items

 ├─ id, prescription\_id, medicine\_name, dosage, duration

 └─ timestamps

services

 ├─ id, clinic\_id, name, price

 └─ timestamps

invoices

 ├─ id, clinic\_id, patient\_id, service\_id, amount, status(paid|pending), payment\_method

 └─ timestamps

audit\_logs

 ├─ id, user\_id, action, target\_type, target\_id, meta(json)

 └─ timestamps

**Relationships summary:**

- `Clinic hasMany Patients, Appointments, Prescriptions, Invoices, Services`  
- `Patient hasMany Appointments, Pregnancies, Prescriptions, Invoices`  
- `Pregnancy hasMany PregnancyExams`  
- `Prescription hasMany PrescriptionItems`  
- `User belongsTo Clinic` (nullable for Super Admin)

---

## 5\. Multi-Tenancy Implementation

**Trait:** `app/Traits/BelongsToClinic.php`

trait BelongsToClinic

{

    protected static function bootBelongsToClinic()

    {

        static::addGlobalScope('clinic', function ($query) {

            if (auth()-\>check() && auth()-\>user()-\>clinic\_id) {

                $query-\>where('clinic\_id', auth()-\>user()-\>clinic\_id);

            }

        });

        static::creating(function ($model) {

            if (auth()-\>check() && auth()-\>user()-\>clinic\_id && \!$model-\>clinic\_id) {

                $model-\>clinic\_id \= auth()-\>user()-\>clinic\_id;

            }

        });

    }

}

Apply this trait to: `Patient`, `Appointment`, `Pregnancy`, `Prescription`, `Invoice`, `Service`.

**Middleware:** `ScopeToClinic` — ensures the logged-in doctor/assistant can only touch their own `clinic_id`; blocks cross-clinic access with 403\.

---

## 6\. Roles & Permissions Matrix

| Module | Doctor | Assistant (default) | Patient |
| :---- | :---- | :---- | :---- |
| Patients | Full | View/Add (no medical history edit unless granted) | View own only |
| Appointments | Full | Full | Book/Cancel own |
| Pregnancy | Full | View only (unless granted) | View own |
| Prescriptions | Full | No access (unless granted) | View own |
| Invoices | Full | View/Add (unless restricted) | View/Pay own |
| Reports | Full | No access | N/A |
| Settings | Full | No access | Own account only |

Implemented via **Spatie Laravel-Permission**: each Assistant gets a `Role` with specific `Permission` records (e.g., `patients.view`, `prescriptions.create`) assigned per clinic.

---

## 7\. Route Structure (example)

// routes/web.php

Route::prefix('admin')-\>middleware(\['auth:admin','role:super-admin'\])

    \-\>name('admin.')-\>group(base\_path('routes/admin.php'));

Route::prefix('doctor')-\>middleware(\['auth','clinic.active','scope.clinic'\])

    \-\>name('doctor.')-\>group(base\_path('routes/doctor.php'));

Route::prefix('patient')-\>middleware(\['auth','role:patient'\])

    \-\>name('patient.')-\>group(base\_path('routes/patient.php'));

Each sub-route file uses `Route::resource()` where possible, e.g.:

Route::resource('patients', PatientController::class);

Route::resource('appointments', AppointmentController::class)-\>except('show');

Route::post('pregnancies/{pregnancy}/exams', \[PregnancyController::class,'addExam'\]);

---

## 8\. Blade Component Conventions (used everywhere, all 3 dashboards)

\<x-card title="Today's Appointments"\>

    ...

\</x-card\>

\<x-table :headers="\['Name','Date','Status'\]"\>

    @foreach($appointments as $a)

        \<tr\>...\</tr\>

    @endforeach

\</x-table\>

\<x-button color="primary" href="{{ route('doctor.patients.create') }}"\>Add Patient\</x-button\>

\<x-modal id="confirm-delete"\>...\</x-modal\>

Rule for the AI agent: **never write raw HTML tables/buttons/cards inline** — always use/create the shared component first, then reuse it across Admin/Doctor/Patient views. This keeps the 3 dashboards visually consistent.

---

## 9\. Step-by-Step Implementation Plan (for the AI Agent)

> The agent must complete each step fully (migration → model → policy → controller → routes → Blade views → tests) before moving to the next. Follow this order exactly.

### Phase 0 – Foundation

1. Install Laravel \+ Breeze (Blade) \+ Livewire \+ Spatie Permission \+ DomPDF.  
2. Create all migrations listed in Section 4\.  
3. Create Eloquent models with relationships \+ `BelongsToClinic` trait where applicable.  
4. Seed default roles/permissions (Super Admin, Doctor, Assistant, Patient) via a `RolePermissionSeeder`.  
5. Build `layouts/admin.blade.php`, `layouts/doctor.blade.php`, `layouts/patient.blade.php` with shared sidebar/topbar partials.  
6. Build shared Blade components (`card`, `table`, `modal`, `button`, `input`, `badge`, `alert`).  
7. Implement `ScopeToClinic`, `EnsureClinicIsActive`, `CheckSubscriptionLimit` middleware.

### Phase 1 – Admin Dashboard

8. Auth: login/forgot-password for `user_type = admin`.  
9. Dashboard overview (cards \+ Chart.js widgets, query aggregates from `clinics`, `clinic_subscriptions`).  
10. Clinics CRUD \+ Suspend/Activate \+ Impersonate (`Auth::loginUsingId()` \+ audit log entry).  
11. Users management (global list, reset password, activate/deactivate).  
12. Roles & Permission Templates CRUD (checkbox matrix Blade view bound to Spatie permissions).  
13. Subscription Plans CRUD.  
14. Billing (list `clinic_subscriptions` \+ payments, integrate Paymob/Stripe webhook).  
15. Reports (Blade \+ Chart.js \+ Export via `maatwebsite/excel` and `dompdf`).  
16. Platform Settings \+ Audit Log viewer.

### Phase 2 – Doctor Dashboard

17. Doctor/Assistant shared login, redirect based on role.  
18. Dashboard overview (today's appointments, new patients, pregnancy alerts, revenue).  
19. Assistants CRUD \+ invite flow (Notification with signed registration link).  
20. Permission assignment UI (Livewire component: toggle permissions per Assistant).  
21. Clinic profile edit (logo upload via Laravel Storage).  
22. Patients CRUD \+ full medical record page.  
23. Appointments (FullCalendar.js Blade integration \+ AJAX endpoints for create/update/cancel).  
24. Reminder notifications (Queued Jobs \+ Notification channels: mail/sms).  
25. Pregnancy tracking (create pregnancy, gestational-age calculator service, exams table, growth chart via Chart.js).  
26. Prescriptions (dynamic repeatable form for medicine items \+ PDF generation \+ send-to-patient notification).  
27. Invoices (create linked to Services, mark as paid, payment method selector).  
28. Reports (clinic-level, export).  
29. Subscription page (current plan, upgrade/downgrade request, invoice history).  
30. Doctor settings (profile, notifications, language switch via Laravel Localization).

### Phase 3 – Patient Dashboard

31. Patient registration via signed invite link \+ OTP verification (Twilio/Vonage).  
32. Dashboard overview (next appointment, current pregnancy week, latest prescription, alerts).  
33. Appointments (book from available slots — validate against doctor's working hours \+ existing bookings).  
34. Pregnancy view (read-only week tracker \+ exams \+ educational content by week — static content table `pregnancy_week_contents`).  
35. Prescriptions list \+ PDF download.  
36. Invoices list \+ online payment (Paymob/Stripe checkout).  
37. Medical profile edit.  
38. Patient settings.

### Phase 4 – Cross-Cutting & QA

39. Apply `CheckSubscriptionLimit` middleware to all "create" actions that count against plan limits (patients, users).  
40. Write Pest feature tests per role: verify Assistant cannot access restricted routes (expect 403).  
41. Write Pest tests for multi-tenancy isolation (Clinic A cannot see Clinic B's data).  
42. Responsive design pass (Tailwind breakpoints) across all Blade views.  
43. Final seed of demo data (`php artisan db:seed --class=DemoDataSeeder`) for staging.  
44. Deploy to staging, run smoke tests on all 3 dashboards.

---

## 10\. AI Agent Working Rules

1. **One module at a time** — finish migration → model → controller → routes → views → test before starting the next numbered step.  
2. **Reuse before creating** — always check if a Blade component/Service/Trait already exists before writing new code.  
3. **Consistent naming** — Controllers: `{Resource}Controller`, Views: `{resource}/{action}.blade.php`, Routes: `{area}.{resource}.{action}`.  
4. **Every clinic-owned model** must use the `BelongsToClinic` trait — no exceptions.  
5. **Every destructive/sensitive action** (impersonate, delete clinic, reset password) must write to `audit_logs`.  
6. **Every list view** must support pagination \+ search/filter using Laravel's query builder, not collection methods, for performance.  
7. **Every create/edit form** must have a matching `FormRequest` class for validation — no inline `$request->validate()` in controllers.  
8. **Commit after each completed step** with a message referencing the step number (e.g., `feat: step 23 - appointments calendar`).

---

## 11\. Suggested Composer Packages

composer require laravel/breeze

composer require livewire/livewire

composer require spatie/laravel-permission

composer require barryvdh/laravel-dompdf

composer require maatwebsite/excel

composer require twilio/sdk  
