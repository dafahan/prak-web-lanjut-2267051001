<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the 'user' table if it doesn't exist
        if (!Schema::hasTable('user')) {
            Schema::create('user', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->foreignId('kelas_id')->constrained();
                $table->timestamps();
            });
        }

        // Modify the 'user' table to add new columns if they don't already exist
        Schema::table('user', function (Blueprint $table) {
            // Check if 'jurusan' column exists before adding it
            if (!Schema::hasColumn('user', 'jurusan')) {
                $table->enum('jurusan', ['fisika', 'kimia', 'biologi', 'matematika', 'ilmu komputer'])->after('nama');
            }

            // Check if 'semester' column exists before adding it
            if (!Schema::hasColumn('user', 'semester')) {
                $table->integer('semester')->unsigned()->default(1)->after('jurusan')
                      ->check('semester <= 14');
            }

            // Check if 'fakultas_id' column exists before adding it
            if (!Schema::hasColumn('user', 'fakultas_id')) {
                $table->foreignId('fakultas_id')->constrained('fakultas')->after('semester');
            }

            // Check if 'foto' column exists before adding it
            if (!Schema::hasColumn('user', 'foto')) {
                $table->string('foto')->nullable()->after('fakultas_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'user' table if it exists
        Schema::dropIfExists('user');
    }
};
