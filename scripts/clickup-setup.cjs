const https = require('https');

const API_TOKEN = 'pk_278415587_ASYVE7LAJVJY61Q0XQ0577KMLTG40J1N';
const TEAM_ID = '90121458327';
const SPACE_ID = '90128864840';
const FOLDER_ID = '901213120323';

function apiCall(method, path, body = null) {
  return new Promise((resolve, reject) => {
    const options = {
      hostname: 'api.clickup.com',
      path: `/api/v2${path}`,
      method: method,
      headers: {
        'Authorization': API_TOKEN,
        'Content-Type': 'application/json'
      }
    };

    const req = https.request(options, (res) => {
      let data = '';
      res.on('data', (chunk) => data += chunk);
      res.on('end', () => {
        try {
          resolve(JSON.parse(data));
        } catch (e) {
          reject(new Error(`Parse error: ${data}`));
        }
      });
    });

    req.on('error', reject);
    if (body) req.write(JSON.stringify(body));
    req.end();
  });
}

async function deleteList(listId) {
  try {
    await apiCall('DELETE', `/list/${listId}`);
    console.log(`   Deleted test list: ${listId}`);
  } catch (e) {
    // Ignore errors
  }
}

async function createList(folderId, name) {
  console.log(`\n📋 Creating List: ${name}...`);
  const result = await apiCall('POST', `/folder/${folderId}/list`, {
    name: name
  });
  console.log(`✅ List created: ${result.id}`);
  return result.id;
}

async function createTask(listId, task) {
  const result = await apiCall('POST', `/list/${listId}/task`, {
    name: task.name,
    description: task.description,
    status: 'to do',
    priority: task.priority,
    tags: task.tags
  });
  console.log(`   ✓ Task: ${task.name}`);
  return result.id;
}

const tasks = {
  phase0: [
    {
      name: 'Step 1: Install Laravel + Breeze + Livewire + Spatie + DomPDF',
      description: '# Step 1: Foundation Setup\n\n## Objective\nInstall all required packages and configure the Laravel project.\n\n## Tasks\n- [ ] Install Laravel Breeze (Blade stack)\n- [ ] Install Livewire 3\n- [ ] Install Spatie Laravel-Permission\n- [ ] Install barryvdh/laravel-dompdf\n- [ ] Install maatwebsite/excel\n- [ ] Configure .env with MySQL credentials\n- [ ] Run initial migration\n\n## Acceptance Criteria\n- php artisan breeze:install blade\n- php artisan migrate successfully\n- All packages listed in composer.json',
      priority: 1,
      tags: ['phase-0', 'setup', 'backend']
    },
    {
      name: 'Step 2: Create All Database Migrations',
      description: '# Step 2: Database Migrations\n\n## Objective\nCreate all database tables as per the architecture.\n\n## Tables to Create\n- users (add user_type, clinic_id columns)\n- clinics\n- subscription_plans\n- clinic_subscriptions\n- patients\n- appointments\n- pregnancies\n- pregnancy_exams\n- prescriptions\n- prescription_items\n- services\n- invoices\n- audit_logs\n\n## Acceptance Criteria\n- php artisan migrate runs without errors\n- All foreign keys properly defined\n- clinic_id column on all tenant tables',
      priority: 1,
      tags: ['phase-0', 'database', 'backend']
    },
    {
      name: 'Step 3: Create Eloquent Models + Relationships',
      description: '# Step 3: Eloquent Models\n\n## Objective\nCreate all models with proper relationships and BelongsToClinic trait.\n\n## Models to Create\n- User (belongsTo Clinic)\n- Clinic (hasMany Patients, Appointments, etc.)\n- SubscriptionPlan\n- ClinicSubscription\n- Patient (belongsTo Clinic, hasMany Appointments)\n- Appointment (belongsTo Clinic, Patient, Doctor)\n- Pregnancy (belongsTo Clinic, Patient)\n- PregnancyExam (belongsTo Pregnancy)\n- Prescription (belongsTo Clinic, Patient, Doctor)\n- PrescriptionItem (belongsTo Prescription)\n- Service (belongsTo Clinic)\n- Invoice (belongsTo Clinic, Patient, Service)\n- AuditLog\n\n## BelongsToClinic Trait\nApply to: Patient, Appointment, Pregnancy, Prescription, Invoice, Service\n\n## Acceptance Criteria\n- All models have proper $fillable, $casts\n- All relationships defined\n- BelongsToClinic trait working with Global Scope',
      priority: 1,
      tags: ['phase-0', 'backend', 'models']
    },
    {
      name: 'Step 4: Seed Roles & Permissions',
      description: '# Step 4: Roles & Permissions Seeder\n\n## Objective\nCreate default roles and permissions using Spatie.\n\n## Roles\n- super-admin (full access)\n- doctor (full access to clinic)\n- assistant (limited, configurable)\n- patient (own data only)\n\n## Permissions\n- patients.view, patients.create, patients.update, patients.delete\n- appointments.view, appointments.create, appointments.update, appointments.cancel\n- pregnancy.view, pregnancy.create, pregnancy.update\n- prescriptions.view, prescriptions.create, prescriptions.update\n- invoices.view, invoices.create, invoices.update, invoices.mark-paid\n- reports.view, reports.export\n- settings.view, settings.update\n- assistants.view, assistants.create, assistants.update, assistants.delete\n\n## Acceptance Criteria\n- RolePermissionSeeder created\n- php artisan db:seed --class=RolePermissionSeeder\n- Roles and permissions visible in database',
      priority: 2,
      tags: ['phase-0', 'backend', 'seeder']
    },
    {
      name: 'Step 5: Build Layouts (Admin/Doctor/Patient)',
      description: '# Step 5: Blade Layouts\n\n## Objective\nCreate main layout files for each dashboard area.\n\n## Layouts\n- resources/views/layouts/admin.blade.php\n- resources/views/layouts/doctor.blade.php\n- resources/views/layouts/patient.blade.php\n- resources/views/layouts/guest.blade.php\n\n## Components\n- Sidebar navigation (role-specific)\n- Top bar with user info\n- Responsive mobile menu\n\n## Acceptance Criteria\n- Each layout extends guest layout\n- Sidebar shows correct menu items per role\n- Responsive on mobile/tablet/desktop',
      priority: 2,
      tags: ['phase-0', 'frontend', 'layouts']
    },
    {
      name: 'Step 6: Build Shared Blade Components',
      description: '# Step 6: Blade Components\n\n## Objective\nCreate reusable Blade components for consistent UI.\n\n## Components\n- components/card.blade.php\n- components/table.blade.php\n- components/modal.blade.php\n- components/button.blade.php\n- components/input.blade.php\n- components/badge.blade.php\n- components/alert.blade.php\n\n## Usage\n<x-card title="Title">Content</x-card>\n<x-table :headers="[\'Name\',\'Date\']">...</x-table>\n<x-button color="primary">Click</x-button>\n<x-modal id="delete">...</x-modal>\n\n## Acceptance Criteria\n- All components work with Tailwind CSS\n- Consistent styling across all 3 dashboards\n- Components accept props for customization',
      priority: 2,
      tags: ['phase-0', 'frontend', 'components']
    },
    {
      name: 'Step 7: Implement Middleware',
      description: '# Step 7: Middleware\n\n## Objective\nCreate custom middleware for multi-tenancy and security.\n\n## Middleware\n- ScopeToClinic: Auto-filter by clinic_id\n- EnsureClinicIsActive: Block suspended clinics\n- CheckSubscriptionLimit: Enforce plan limits\n- RoleRedirect: Redirect based on user_type\n\n## Register in bootstrap/app.php\n\n## Acceptance Criteria\n- ScopeToClinic auto-filters queries\n- EnsureClinicIsActive returns 403 for suspended\n- CheckSubscriptionLimit blocks when limit reached\n- RoleRedirect sends to correct dashboard',
      priority: 2,
      tags: ['phase-0', 'backend', 'middleware']
    }
  ],

  phase1: [
    {
      name: 'Step 8: Admin Authentication',
      description: '# Step 8: Admin Auth\n\n## Objective\nImplement login/forgot-password for admin users.\n\n## Tasks\n- [ ] Create Admin/LoginController\n- [ ] Create admin auth routes\n- [ ] Create admin login Blade view\n- [ ] Create forgot/reset password flow\n- [ ] Configure auth guard for admin\n\n## Acceptance Criteria\n- Admin can login with email/password\n- Forgot password sends reset link\n- Protected routes require auth',
      priority: 2,
      tags: ['phase-1', 'admin', 'auth', 'backend']
    },
    {
      name: 'Step 9: Admin Dashboard Overview',
      description: '# Step 9: Admin Dashboard\n\n## Objective\nShow overview cards and charts for platform metrics.\n\n## Widgets\n- Total clinics count\n- Active subscriptions\n- Revenue chart (Chart.js)\n- Recent activity\n\n## Acceptance Criteria\n- Dashboard loads with real data\n- Charts render correctly\n- Responsive layout',
      priority: 2,
      tags: ['phase-1', 'admin', 'dashboard', 'frontend']
    },
    {
      name: 'Step 10: Clinics CRUD + Suspend/Activate',
      description: '# Step 10: Clinics Management\n\n## Objective\nFull CRUD for clinics with suspend/activate and impersonate.\n\n## Features\n- List all clinics (paginated, searchable)\n- Create new clinic\n- Edit clinic details\n- Suspend/Activate toggle\n- Impersonate doctor (Auth::loginUsingId)\n- Audit log on impersonate\n\n## Acceptance Criteria\n- All CRUD operations work\n- Impersonate logs to audit_logs\n- Suspension blocks clinic access',
      priority: 2,
      tags: ['phase-1', 'admin', 'clinics', 'backend']
    },
    {
      name: 'Step 11: Users Management',
      description: '# Step 11: Users Management\n\n## Objective\nGlobal user list with admin controls.\n\n## Features\n- List all users across clinics\n- Reset password\n- Activate/Deactivate user\n- Filter by clinic, role\n\n## Acceptance Criteria\n- Users list with pagination\n- Reset password sends email\n- Deactivate blocks login',
      priority: 2,
      tags: ['phase-1', 'admin', 'users', 'backend']
    },
    {
      name: 'Step 12: Roles & Permission Templates CRUD',
      description: '# Step 12: Roles & Permissions\n\n## Objective\nManage role templates with permission matrix.\n\n## Features\n- List roles\n- Create/edit role with checkbox matrix\n- Assign permissions per role\n- Delete role (if no users assigned)\n\n## Acceptance Criteria\n- Checkbox matrix shows all permissions\n- Roles saved with correct permissions\n- Assistant roles configurable per clinic',
      priority: 3,
      tags: ['phase-1', 'admin', 'roles', 'backend']
    },
    {
      name: 'Step 13: Subscription Plans CRUD',
      description: '# Step 13: Subscription Plans\n\n## Objective\nManage subscription plans offered to clinics.\n\n## Features\n- List plans\n- Create/edit plan (name, price, limits, features)\n- Delete plan (if no active subscriptions)\n\n## Acceptance Criteria\n- Plans CRUD works\n- Limits enforced (patient_limit, user_limit)\n- Features stored as JSON',
      priority: 2,
      tags: ['phase-1', 'admin', 'subscriptions', 'backend']
    },
    {
      name: 'Step 14: Billing & Payments',
      description: '# Step 14: Billing\n\n## Objective\nView clinic subscriptions and integrate payment webhooks.\n\n## Features\n- List all clinic_subscriptions\n- View payment history\n- Paymob/Stripe webhook handler\n- Update subscription status on payment\n\n## Acceptance Criteria\n- Subscriptions list with filters\n- Webhook updates subscription status\n- Payment history logged',
      priority: 3,
      tags: ['phase-1', 'admin', 'billing', 'backend']
    },
    {
      name: 'Step 15: Reports & Export',
      description: '# Step 15: Admin Reports\n\n## Objective\nPlatform-wide reports with export functionality.\n\n## Reports\n- Clinics by status\n- Revenue over time\n- Subscription distribution\n- User growth\n\n## Export\n- Excel export (maatwebsite/excel)\n- PDF export (dompdf)\n\n## Acceptance Criteria\n- Charts render with Chart.js\n- Export downloads correct file\n- Filters work (date range, clinic)',
      priority: 3,
      tags: ['phase-1', 'admin', 'reports', 'frontend']
    },
    {
      name: 'Step 16: Platform Settings + Audit Log',
      description: '# Step 16: Settings & Audit Log\n\n## Objective\nPlatform settings and audit log viewer.\n\n## Features\n- General settings (site name, logo, etc.)\n- Email/SMS settings\n- Audit log list (filterable by action, user)\n- Pagination on audit logs\n\n## Acceptance Criteria\n- Settings save correctly\n- Audit log shows all actions\n- Filter by action type works',
      priority: 3,
      tags: ['phase-1', 'admin', 'settings', 'backend']
    }
  ],

  phase2: [
    {
      name: 'Step 17: Doctor/Assistant Login + Role Redirect',
      description: '# Step 17: Doctor/Assistant Auth\n\n## Objective\nShared login for doctors and assistants with role-based redirect.\n\n## Tasks\n- [ ] Login form for doctor/assistant\n- [ ] RoleRedirect middleware\n- [ ] Doctor → doctor dashboard\n- [ ] Assistant → doctor dashboard (limited view)\n\n## Acceptance Criteria\n- Single login form works for both roles\n- Redirect based on user_type\n- Session identifies role',
      priority: 2,
      tags: ['phase-2', 'doctor', 'auth', 'backend']
    },
    {
      name: 'Step 18: Doctor Dashboard Overview',
      description: '# Step 18: Doctor Dashboard\n\n## Objective\nOverview widgets for doctor\'s clinic.\n\n## Widgets\n- Today\'s appointments count\n- New patients this week\n- Pregnancy alerts (due soon)\n- Revenue this month\n\n## Acceptance Criteria\n- Real data from clinic only\n- Charts for trends\n- Responsive layout',
      priority: 2,
      tags: ['phase-2', 'doctor', 'dashboard', 'frontend']
    },
    {
      name: 'Step 19: Assistants CRUD + Invite Flow',
      description: '# Step 19: Assistants Management\n\n## Objective\nManage assistants with email invite.\n\n## Features\n- List assistants in clinic\n- Create assistant (sends invite email)\n- Edit assistant details\n- Delete assistant\n- Signed registration link\n\n## Acceptance Criteria\n- Invite sends email with link\n- Assistant can register via link\n- Linked to clinic on registration',
      priority: 2,
      tags: ['phase-2', 'doctor', 'assistants', 'backend']
    },
    {
      name: 'Step 20: Permission Assignment UI',
      description: '# Step 20: Assistant Permissions\n\n## Objective\nLivewire component for toggling permissions per assistant.\n\n## Features\n- Toggle permissions UI\n- Real-time save\n- Visual feedback\n\n## Acceptance Criteria\n- Doctor can grant/revoke permissions\n- Changes take effect immediately\n- Assistant sees correct menu items',
      priority: 3,
      tags: ['phase-2', 'doctor', 'permissions', 'frontend']
    },
    {
      name: 'Step 21: Clinic Profile Edit',
      description: '# Step 21: Clinic Profile\n\n## Objective\nEdit clinic profile with logo upload.\n\n## Features\n- Edit name, address, phone\n- Logo upload (Laravel Storage)\n- Preview uploaded logo\n\n## Acceptance Criteria\n- Logo stored in storage/app/public\n- Profile updates saved\n- Logo displays in sidebar',
      priority: 2,
      tags: ['phase-2', 'doctor', 'clinic', 'backend']
    },
    {
      name: 'Step 22: Patients CRUD + Medical Record',
      description: '# Step 22: Patients Management\n\n## Objective\nFull patient CRUD with medical record page.\n\n## Features\n- List patients (paginated, searchable)\n- Create patient\n- Edit patient details\n- Medical history (JSON field)\n- View full medical record\n\n## Acceptance Criteria\n- Search by name, phone works\n- Medical history editable\n- Scoped to clinic only',
      priority: 2,
      tags: ['phase-2', 'doctor', 'patients', 'backend']
    },
    {
      name: 'Step 23: Appointments (FullCalendar.js)',
      description: '# Step 23: Appointments Calendar\n\n## Objective\nFullCalendar.js integration for appointment management.\n\n## Features\n- Calendar view of appointments\n- Create appointment (click on slot)\n- Update appointment status\n- Cancel appointment\n- AJAX endpoints\n\n## Acceptance Criteria\n- Calendar renders with events\n- Click to create works\n- Drag to reschedule\n- Status changes reflected',
      priority: 2,
      tags: ['phase-2', 'doctor', 'appointments', 'frontend']
    },
    {
      name: 'Step 24: Reminder Notifications',
      description: '# Step 24: Notifications\n\n## Objective\nQueued notifications for appointments.\n\n## Features\n- Appointment reminder (24h before)\n- Notification channels: mail, sms\n- Queued jobs for async\n- Twilio/Vonage integration\n\n## Acceptance Criteria\n- Reminders sent via queue\n- Mail notification works\n- SMS integration configured',
      priority: 3,
      tags: ['phase-2', 'doctor', 'notifications', 'backend']
    },
    {
      name: 'Step 25: Pregnancy Tracking',
      description: '# Step 25: Pregnancy Module\n\n## Objective\nFull pregnancy tracking with exams and charts.\n\n## Features\n- Create pregnancy record\n- Gestational age calculator service\n- Add pregnancy exams\n- Growth chart (Chart.js)\n- EDD calculation\n\n## Acceptance Criteria\n- Pregnancy created with LMP/EDD\n- Exams list with results\n- Growth chart renders\n- Status: active/delivered/miscarried',
      priority: 2,
      tags: ['phase-2', 'doctor', 'pregnancy', 'backend']
    },
    {
      name: 'Step 26: Prescriptions + PDF',
      description: '# Step 26: Prescriptions\n\n## Objective\nCreate prescriptions with PDF generation.\n\n## Features\n- Dynamic repeatable form for medicines\n- Add/remove medicine items\n- PDF generation (dompdf)\n- Send to patient notification\n\n## Acceptance Criteria\n- Form allows multiple items\n- PDF downloads correctly\n- Patient notified of new prescription',
      priority: 2,
      tags: ['phase-2', 'doctor', 'prescriptions', 'backend']
    },
    {
      name: 'Step 27: Invoices + Payment',
      description: '# Step 27: Invoices\n\n## Objective\nCreate invoices linked to services.\n\n## Features\n- Create invoice (select service)\n- Mark as paid\n- Payment method selector\n- Invoice PDF generation\n\n## Acceptance Criteria\n- Invoice linked to service\n- Status: paid/pending\n- PDF downloadable',
      priority: 2,
      tags: ['phase-2', 'doctor', 'invoices', 'backend']
    },
    {
      name: 'Step 28: Clinic Reports',
      description: '# Step 28: Doctor Reports\n\n## Objective\nClinic-level reports with export.\n\n## Reports\n- Patient statistics\n- Appointment trends\n- Revenue reports\n- Pregnancy outcomes\n\n## Acceptance Criteria\n- Charts render correctly\n- Export to Excel/PDF\n- Filtered by date range',
      priority: 3,
      tags: ['phase-2', 'doctor', 'reports', 'frontend']
    },
    {
      name: 'Step 29: Subscription Page',
      description: '# Step 29: Doctor Subscription\n\n## Objective\nView current plan and manage subscription.\n\n## Features\n- Current plan display\n- Usage stats (patients, users)\n- Upgrade/downgrade request\n- Invoice history\n\n## Acceptance Criteria\n- Current plan visible\n- Usage against limits shown\n- Upgrade request creates ticket',
      priority: 3,
      tags: ['phase-2', 'doctor', 'subscription', 'frontend']
    },
    {
      name: 'Step 30: Doctor Settings',
      description: '# Step 30: Doctor Settings\n\n## Objective\nProfile and notification settings.\n\n## Features\n- Profile edit (name, email, phone)\n- Notification preferences\n- Language switch (Laravel Localization)\n\n## Acceptance Criteria\n- Profile updates save\n- Notification preferences work\n- Language switch changes UI',
      priority: 3,
      tags: ['phase-2', 'doctor', 'settings', 'backend']
    }
  ],

  phase3: [
    {
      name: 'Step 31: Patient Registration + OTP',
      description: '# Step 31: Patient Auth\n\n## Objective\nPatient registration via invite link with OTP.\n\n## Features\n- Signed invite link from doctor\n- OTP verification (Twilio/Vonage)\n- Registration form\n- Login for patients\n\n## Acceptance Criteria\n- Invite link works (signed URL)\n- OTP sent and verified\n- Patient linked to clinic',
      priority: 2,
      tags: ['phase-3', 'patient', 'auth', 'backend']
    },
    {
      name: 'Step 32: Patient Dashboard Overview',
      description: '# Step 32: Patient Dashboard\n\n## Objective\nPersonal dashboard for patients.\n\n## Widgets\n- Next appointment\n- Current pregnancy week\n- Latest prescription\n- Alerts/reminders\n\n## Acceptance Criteria\n- Real data for patient only\n- Pregnancy week calculated\n- Responsive on mobile',
      priority: 2,
      tags: ['phase-3', 'patient', 'dashboard', 'frontend']
    },
    {
      name: 'Step 33: Patient Appointments Booking',
      description: '# Step 33: Patient Appointments\n\n## Objective\nBook appointments from available slots.\n\n## Features\n- View available slots\n- Book appointment\n- Cancel own appointment\n- Validate against doctor hours\n\n## Acceptance Criteria\n- Slots show availability\n- Booking validates conflicts\n- Cancel updates status',
      priority: 2,
      tags: ['phase-3', 'patient', 'appointments', 'backend']
    },
    {
      name: 'Step 34: Pregnancy View (Read-Only)',
      description: '# Step 34: Patient Pregnancy View\n\n## Objective\nRead-only pregnancy tracker for patients.\n\n## Features\n- Week-by-week tracker\n- Exams list\n- Educational content by week\n- pregnancy_week_contents table\n\n## Acceptance Criteria\n- Current week displayed\n- Exams visible\n- Educational content loads',
      priority: 2,
      tags: ['phase-3', 'patient', 'pregnancy', 'frontend']
    },
    {
      name: 'Step 35: Prescriptions List + PDF Download',
      description: '# Step 35: Patient Prescriptions\n\n## Objective\nView and download prescriptions.\n\n## Features\n- List all prescriptions\n- View prescription details\n- Download PDF\n\n## Acceptance Criteria\n- List shows all prescriptions\n- PDF downloads correctly\n- Scoped to patient only',
      priority: 2,
      tags: ['phase-3', 'patient', 'prescriptions', 'frontend']
    },
    {
      name: 'Step 36: Invoices + Online Payment',
      description: '# Step 36: Patient Invoices\n\n## Objective\nView invoices and pay online.\n\n## Features\n- List invoices\n- View invoice details\n- Online payment (Paymob/Stripe)\n- Payment confirmation\n\n## Acceptance Criteria\n- Invoice list works\n- Payment redirect works\n- Status updates on payment',
      priority: 2,
      tags: ['phase-3', 'patient', 'invoices', 'backend']
    },
    {
      name: 'Step 37: Medical Profile Edit',
      description: '# Step 37: Patient Medical Profile\n\n## Objective\nPatient can edit their medical profile.\n\n## Features\n- Edit personal info\n- Update medical history\n- Upload documents\n\n## Acceptance Criteria\n- Profile updates save\n- Medical history editable\n- Files stored correctly',
      priority: 3,
      tags: ['phase-3', 'patient', 'profile', 'backend']
    },
    {
      name: 'Step 38: Patient Settings',
      description: '# Step 38: Patient Settings\n\n## Objective\nPatient account settings.\n\n## Features\n- Change password\n- Notification preferences\n- Language switch\n\n## Acceptance Criteria\n- Password change works\n- Preferences save\n- Language switch works',
      priority: 3,
      tags: ['phase-3', 'patient', 'settings', 'backend']
    }
  ],

  phase4: [
    {
      name: 'Step 39: Apply Subscription Limit Middleware',
      description: '# Step 39: Subscription Limits\n\n## Objective\nEnforce plan limits on create actions.\n\n## Tasks\n- Apply CheckSubscriptionLimit to patients.create\n- Apply to users.create\n- Show error when limit reached\n\n## Acceptance Criteria\n- Create blocked when limit reached\n- Error message displayed\n- Works for all limit types',
      priority: 2,
      tags: ['phase-4', 'backend', 'middleware']
    },
    {
      name: 'Step 40: Pest Feature Tests (Role-Based)',
      description: '# Step 40: Role-Based Tests\n\n## Objective\nTest access control per role.\n\n## Tests\n- Assistant cannot access restricted routes (expect 403)\n- Patient cannot access doctor routes\n- Doctor can access all clinic routes\n- Admin can access admin routes\n\n## Acceptance Criteria\n- Tests pass for each role\n- 403 returned for unauthorized\n- Tests cover all major routes',
      priority: 2,
      tags: ['phase-4', 'testing', 'pest']
    },
    {
      name: 'Step 41: Pest Multi-Tenancy Tests',
      description: '# Step 41: Multi-Tenancy Tests\n\n## Objective\nVerify clinic data isolation.\n\n## Tests\n- Clinic A cannot see Clinic B data\n- Cross-clinic access returns 403\n- Scoped queries work correctly\n\n## Acceptance Criteria\n- Tests pass\n- No data leakage between clinics\n- Global scope working',
      priority: 2,
      tags: ['phase-4', 'testing', 'pest']
    },
    {
      name: 'Step 42: Responsive Design Pass',
      description: '# Step 42: Responsive Design\n\n## Objective\nEnsure all views work on mobile/tablet.\n\n## Tasks\n- Test all Blade views on mobile\n- Fix Tailwind breakpoints\n- Ensure sidebar collapses\n- Touch-friendly buttons\n\n## Acceptance Criteria\n- All views responsive\n- No horizontal scroll\n- Buttons/links clickable on mobile',
      priority: 3,
      tags: ['phase-4', 'frontend', 'responsive']
    },
    {
      name: 'Step 43: Demo Data Seeder',
      description: '# Step 43: Demo Data\n\n## Objective\nSeed demo data for staging.\n\n## Tasks\n- Create DemoDataSeeder\n- Seed sample clinics\n- Seed sample patients\n- Seed sample appointments\n- Seed sample prescriptions\n\n## Acceptance Criteria\n- php artisan db:seed --class=DemoDataSeeder\n- Realistic demo data\n- All relationships intact',
      priority: 3,
      tags: ['phase-4', 'backend', 'seeder']
    },
    {
      name: 'Step 44: Deploy to Staging + Smoke Tests',
      description: '# Step 44: Deployment\n\n## Objective\nDeploy to staging and run smoke tests.\n\n## Tasks\n- Deploy to staging server\n- Run all migrations\n- Seed demo data\n- Smoke test all 3 dashboards\n- Document any issues\n\n## Acceptance Criteria\n- All dashboards accessible\n- Login works for all roles\n- No critical errors\n- Performance acceptable',
      priority: 1,
      tags: ['phase-4', 'devops', 'deployment']
    }
  ]
};

async function main() {
  try {
    console.log('🚀 Starting ClickUp Setup for clinicNew...\n');

    // Delete test list
    await deleteList('901220475043');

    // Create Lists and Tasks
    console.log('\n========================================');
    console.log('📋 Creating Lists and Tasks...');
    console.log('========================================');

    // Phase 0
    const list0 = await createList(FOLDER_ID, 'Phase 0 - Foundation');
    console.log('\n🔧 Phase 0: Creating tasks...');
    for (const task of tasks.phase0) {
      await createTask(list0, task);
    }

    // Phase 1
    const list1 = await createList(FOLDER_ID, 'Phase 1 - Admin Dashboard');
    console.log('\n🔧 Phase 1: Creating tasks...');
    for (const task of tasks.phase1) {
      await createTask(list1, task);
    }

    // Phase 2
    const list2 = await createList(FOLDER_ID, 'Phase 2 - Doctor Dashboard');
    console.log('\n🔧 Phase 2: Creating tasks...');
    for (const task of tasks.phase2) {
      await createTask(list2, task);
    }

    // Phase 3
    const list3 = await createList(FOLDER_ID, 'Phase 3 - Patient Dashboard');
    console.log('\n🔧 Phase 3: Creating tasks...');
    for (const task of tasks.phase3) {
      await createTask(list3, task);
    }

    // Phase 4
    const list4 = await createList(FOLDER_ID, 'Phase 4 - Cross-Cutting & QA');
    console.log('\n🔧 Phase 4: Creating tasks...');
    for (const task of tasks.phase4) {
      await createTask(list4, task);
    }

    console.log('\n========================================');
    console.log('🎉 All tasks created successfully!');
    console.log('========================================');
    console.log(`\n📊 Summary:`);
    console.log(`   Space: clinicNew (${SPACE_ID})`);
    console.log(`   Folder: Clinic SaaS Implementation (${FOLDER_ID})`);
    console.log(`   Lists: 5`);
    console.log(`   Tasks: 44`);
    console.log(`\n🔗 Link: https://app.clickup.com/${TEAM_ID}/v/l/${list0}`);

  } catch (error) {
    console.error('❌ Error:', error.message);
    process.exit(1);
  }
}

main();
