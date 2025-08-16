<?php

namespace Carlxaeron\General\Tests;

use Orchestra\Testbench\TestCase;
use Carlxaeron\General\GeneralServiceProvider;
use Carlxaeron\General\Models\GeneralMap;
use Carlxaeron\General\Models\GeneralMeta;
use Carlxaeron\General\Traits\HasGeneralMaps;
use Carlxaeron\General\Traits\HasGeneralMeta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GeneralTest extends TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [GeneralServiceProvider::class];
    }

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test tables
        $this->createTables();
    }

    private function createTables()
    {
        // Create general_maps table
        $this->app['db']->connection()->getSchemaBuilder()->create('general_maps', function ($table) {
            $table->id();
            $table->string('mappable_type', 100);
            $table->unsignedBigInteger('mappable_id');
            $table->string('related_type', 100);
            $table->unsignedBigInteger('related_id');
            $table->string('relationship_type', 100)->default('general');
            $table->string('relationship_key', 100)->nullable();
            $table->json('metadata')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Create general_meta table
        $this->app['db']->connection()->getSchemaBuilder()->create('general_meta', function ($table) {
            $table->id();
            $table->string('metable_type');
            $table->unsignedBigInteger('metable_id');
            $table->string('key');
            $table->text('value')->nullable();
            $table->string('type')->default('string');
            $table->timestamps();
        });

        // Create test users table
        $this->app['db']->connection()->getSchemaBuilder()->create('users', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    public function test_general_maps_functionality()
    {
        $user1 = TestUser::create(['name' => 'User 1', 'email' => 'user1@test.com']);
        $user2 = TestUser::create(['name' => 'User 2', 'email' => 'user2@test.com']);

        // Test adding relationship
        $user1->addRelatedModel($user2, 'friend', 'best_friend', ['since' => '2020']);

        // Test getting related models
        $friends = $user1->getRelatedModels(TestUser::class, 'friend');
        $this->assertCount(1, $friends);
        $this->assertEquals($user2->id, $friends->first()->id);

        // Test relationship metadata
        $metadata = $user1->getRelationshipMetadata($user2, 'friend');
        $this->assertEquals('2020', $metadata['since']);

        // Test checking relationship
        $this->assertTrue($user1->hasRelatedModel($user2, 'friend'));
    }

    public function test_general_meta_functionality()
    {
        $user = TestUser::create(['name' => 'Test User', 'email' => 'test@test.com']);

        // Test setting meta
        $user->setGeneralMeta('theme', 'dark', 'string');
        $user->setGeneralMeta('age', 25, 'integer');

        // Test getting meta
        $this->assertEquals('dark', $user->getGeneralMeta('theme'));
        $this->assertEquals(25, $user->getGeneralMeta('age'));
        $this->assertEquals('default', $user->getGeneralMeta('nonexistent', 'default'));

        // Test checking meta
        $this->assertTrue($user->hasGeneralMeta('theme'));
        $this->assertFalse($user->hasGeneralMeta('nonexistent'));

        // Test getting all meta
        $allMeta = $user->getAllGeneralMeta();
        $this->assertArrayHasKey('theme', $allMeta);
        $this->assertArrayHasKey('age', $allMeta);
    }

    public function test_helper_functions()
    {
        $user1 = TestUser::create(['name' => 'User 1', 'email' => 'user1@test.com']);
        $user2 = TestUser::create(['name' => 'User 2', 'email' => 'user2@test.com']);

        // Test helper functions
        add_related_model($user1, $user2, 'friend');
        $this->assertTrue(has_related_model($user1, $user2, 'friend'));

        $friends = get_related_models($user1, TestUser::class, 'friend');
        $this->assertCount(1, $friends);

        // Test meta helper functions
        set_meta($user1, 'preference', 'dark_theme');
        $this->assertEquals('dark_theme', get_meta($user1, 'preference'));
        $this->assertTrue(has_meta($user1, 'preference'));
    }
}

// Test User model
class TestUser extends Model
{
    use HasGeneralMaps, HasGeneralMeta;

    protected $fillable = ['name', 'email'];
}
