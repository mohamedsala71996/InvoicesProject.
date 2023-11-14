<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        //Permissions
        $permissions = [
            'الفواتير',
            'قائمة الفواتير',
            'الفواتير المدفوعة',
            'الفواتير المدفوعة جزئيا',
            'الفواتير الغير مدفوعة',
            'أرشيف الفواتير',
            'قائمة التقارير',
            'تقارير الفواتير',
            'تقارير العملاء',
            'المستخدمين',
            'قائمة المستخدمين',
            'صلاحيات المستخدمين',
            'الاعدادات',
            'المنتجات',
            'الأقسام',
             'عرض صلاحية',

    
            // 'اضافة فاتورة',
            // 'حذف الفاتورة',
            // 'تحميل الاكسيل',
            // 'تغيير حالة الدفع',
            // 'تعديل',
            // 'نقل للأرشيف',
            // 'طباعة',
            // 'اضافة مرفق',
            // 'حذف المرفق',
    
            // 'اضافة مستخدم',
            // 'تعديل مستخدم',
            // 'حذف مستخدم',
    
            // 'عرض صلاحية',
            // 'اضافة صلاحية',
            // 'تعديل صلاحية',
            // 'حذف صلاحية',
    
            // 'اضافة منتج',
            // 'تعديل منتج',
            // 'حذف منتج',
    
            // 'اضافة قسم',
            // 'تعديل قسم',
            // 'حذف قسم',
            // 'الاشعارات',
            ];
       
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
