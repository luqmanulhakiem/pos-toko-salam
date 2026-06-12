<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = [
    'users',
    'kategoris',
    'produks',
    'stok_flows',
    'carts',
    'notas',
    'penjualans',
    'tokos',
    'roles',
    'permissions',
    'model_has_roles',
    'role_has_permissions'
];

$output = "erDiagram\n";

foreach ($tables as $table) {
    $columns = DB::select("SHOW COLUMNS FROM `$table`");
    $output .= "    $table {\n";
    foreach ($columns as $column) {
        $type = preg_replace('/[^a-zA-Z0-9_]/', '', $column->Type);
        $field = $column->Field;
        // determine if primary key
        $key = $column->Key == 'PRI' ? 'PK' : ($column->Key == 'MUL' ? 'FK' : '');
        // format for mermaid
        $output .= "        $type $field $key\n";
    }
    $output .= "    }\n";
}

// Hardcode relationships based on common Laravel conventions
$output .= "    kategoris ||--o{ produks : \"has\"\n";
$output .= "    produks ||--o{ stok_flows : \"has\"\n";
$output .= "    produks ||--o{ carts : \"has\"\n";
$output .= "    users ||--o{ carts : \"has\"\n";
$output .= "    users ||--o{ notas : \"has\"\n";
$output .= "    tokos ||--o{ notas : \"has\"\n";
$output .= "    notas ||--o{ penjualans : \"has\"\n";
$output .= "    produks ||--o{ penjualans : \"has\"\n";
$output .= "    roles ||--o{ model_has_roles : \"has\"\n";
$output .= "    users ||--o{ model_has_roles : \"has\"\n";
$output .= "    roles ||--o{ role_has_permissions : \"has\"\n";
$output .= "    permissions ||--o{ role_has_permissions : \"has\"\n";

file_put_contents('schema.mmd', $output);
echo "Mermaid schema generated!\n";
