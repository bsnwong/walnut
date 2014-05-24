e Illuminate\Database\Migrations\Migration;
class CreateOrganizationTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(!Schema::hasTable('Organization')) {
            Schema::create('Organization', function($table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('code', false, true)->unsigned()->unique();
                $table->string('name', 50);
                $table->bigInteger('parent_node', false, true)->index();
                $table->timestamps();
            });

        }
	}
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('Organization');
	}
}
