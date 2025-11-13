<?php

use App\Models\User;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';

$manager = User::where('email', 'manager@example.com')->first();
if ($manager) {
    echo "Manager permissions:\n";
    $permissions = $manager->getAllPermissions()->pluck('name');
    foreach ($permissions as $perm) {
        echo "  - $perm\n";
    }
    echo "\nManager can view sections: " . ($manager->can('sections.view') ? 'YES' : 'NO') . "\n";
} else {
    echo "Manager user not found\n";
}
