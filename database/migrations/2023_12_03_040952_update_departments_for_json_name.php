<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Department;

class UpdateDepartmentsForJsonName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add a temporary column for the JSON data
        Schema::table('departments', function (Blueprint $table) {
            $table->json('name_temp')->nullable();
        });

        // Migrate existing data to the temporary column
        Department::all()->each(function ($department) {
            $department->name_temp = json_encode(['en' => $department->name]);
            $department->save();
        });

        // Drop the old 'name' column and rename 'name_temp' to 'name'
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->renameColumn('name_temp', 'name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // To reverse the migration, create a 'name' column,
        // copy the data back, and remove the 'name_temp' column
        Schema::table('departments', function (Blueprint $table) {
            $table->string('name')->after('name_temp');

            Department::all()->each(function ($department) {
                $departmentData = json_decode($department->name_temp, true);
                $department->name = $departmentData['en'] ?? '';
                $department->save();
            });

            $table->dropColumn('name_temp');
        });
    }
}
