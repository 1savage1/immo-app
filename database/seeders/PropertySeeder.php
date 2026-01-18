<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    /**
     * تشغيل Seeder: إدخال عقارات تجريبية
     */
    public function run(): void
    {
        // ✅ نحط بيانات تجريبية (مهم: category لازم تكون من القيم المسموحة في migration)
        $properties = [
            [
                'user_id'      => 1, // ✅ لازم يكون عندك user id = 1 (إذا لا، بدّلها)
                'owner_email'  => 'owner1@example.com',
                'owner_phone'  => '0550000001',
                'operation'    => 'location', // ✅ لازم تكون: vente أو location
                'category'     => 'villa',    // ✅ بدّلناها من maison إلى villa
                'title'        => 'Maison moderne - Alger',
                'description'  => 'منزل حديث قريب من كل الخدمات.',
                'city'         => 'Alger',
                'rooms'        => 3,
                'area'         => 120,
                'price'        => 45000,
                'status'       => 'approved',
                'rent_count'   => 0,
            ],
            [
                'user_id'      => 1,
                'owner_email'  => 'owner2@example.com',
                'owner_phone'  => '0550000002',
                'operation'    => 'vente',
                'category'     => 'villa',
                'title'        => 'Villa - Oran',
                'description'  => 'فيلا واسعة مناسبة للعائلات.',
                'city'         => 'Oran',
                'rooms'        => 5,
                'area'         => 260,
                'price'        => 12000000,
                'status'       => 'approved',
                'rent_count'   => 0,
            ],
            [
                'user_id'      => 1,
                'owner_email'  => 'owner3@example.com',
                'owner_phone'  => '0550000003',
                'operation'    => 'location',
                'category'     => 'studio', // ✅ قيمة مسموحة
                'title'        => 'Studio - Constantine',
                'description'  => 'ستوديو صغير ومرتب في وسط المدينة.',
                'city'         => 'Constantine',
                'rooms'        => 1,
                'area'         => 45,
                'price'        => 30000,
                'status'       => 'approved',
                'rent_count'   => 0,
            ],
        ];

        // ✅ إدخال البيانات في جدول properties
        foreach ($properties as $data) {
            Property::create($data);
        }
    }
}
