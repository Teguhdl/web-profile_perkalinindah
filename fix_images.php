<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$pages = \App\Models\Page::all();
foreach($pages as $p) {
    if(strpos($p->content, '../../storage') !== false) {
        $p->content = str_replace('../../storage', asset('storage'), $p->content);
        $p->save();
        echo "Fixed {$p->slug}\n";
    }
}
