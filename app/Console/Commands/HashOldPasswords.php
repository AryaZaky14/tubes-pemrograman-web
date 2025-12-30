<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HashOldPasswords extends Command
{
    protected $signature = 'user:hash-old-passwords';
    protected $description = 'Hash ulang password user yang masih plaintext';

    public function handle()
    {
        $users = DB::table('user')->get();

        $count = 0;

        foreach ($users as $user) {

            // cek apakah password BELUM di-hash
            if (!str_starts_with($user->password, '$2y$')) {

                DB::table('user')
                    ->where('id_user', $user->id_user)
                    ->update([
                        'password' => Hash::make($user->password)
                    ]);

                $count++;
            }
        }

        $this->info("✅ {$count} password berhasil di-hash ulang");
    }
}
