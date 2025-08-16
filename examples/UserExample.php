<?php

namespace Carlxaeron\General\Examples;

use Illuminate\Database\Eloquent\Model;
use Carlxaeron\General\Traits\HasGeneralMaps;
use Carlxaeron\General\Traits\HasGeneralMeta;

/**
 * Example User model showing how to use the General package
 */
class UserExample extends Model
{
    use HasGeneralMaps, HasGeneralMeta;

    protected $fillable = ['name', 'email'];

    /**
     * Example: Add a friend relationship
     */
    public function addFriend(UserExample $friend, string $relationshipKey = null, array $metadata = [])
    {
        return $this->addRelatedModel(
            $friend, 
            'friend', 
            $relationshipKey, 
            $metadata
        );
    }

    /**
     * Example: Get all friends
     */
    public function getFriends()
    {
        return $this->getRelatedModels(UserExample::class, 'friend');
    }

    /**
     * Example: Get best friends specifically
     */
    public function getBestFriends()
    {
        return $this->getRelatedModels(UserExample::class, 'friend', 'best_friend');
    }

    /**
     * Example: Check if someone is a friend
     */
    public function isFriend(UserExample $user): bool
    {
        return $this->hasRelatedModel($user, 'friend');
    }

    /**
     * Example: Set user preferences
     */
    public function setPreference(string $key, $value, string $type = 'string')
    {
        return $this->setGeneralMeta($key, $value, $type);
    }

    /**
     * Example: Get user preference
     */
    public function getPreference(string $key, $default = null)
    {
        return $this->getGeneralMeta($key, $default);
    }

    /**
     * Example: Get all user preferences
     */
    public function getAllPreferences(): array
    {
        return $this->getAllGeneralMeta()->toArray();
    }
}

// Usage examples:
/*
// Create users
$user1 = UserExample::create(['name' => 'John', 'email' => 'john@example.com']);
$user2 = UserExample::create(['name' => 'Jane', 'email' => 'jane@example.com']);
$user3 = UserExample::create(['name' => 'Bob', 'email' => 'bob@example.com']);

// Add friends
$user1->addFriend($user2, 'best_friend', ['since' => '2020', 'met_at' => 'school']);
$user1->addFriend($user3, 'colleague', ['since' => '2021', 'company' => 'TechCorp']);

// Get friends
$allFriends = $user1->getFriends();
$bestFriends = $user1->getBestFriends();

// Check relationships
if ($user1->isFriend($user2)) {
    echo "John and Jane are friends!";
}

// Set preferences
$user1->setPreference('theme', 'dark', 'string');
$user1->setPreference('notifications', true, 'boolean');
$user1->setPreference('age', 25, 'integer');

// Get preferences
$theme = $user1->getPreference('theme', 'light'); // defaults to 'light' if not set
$notifications = $user1->getPreference('notifications', false);
$age = $user1->getPreference('age');

// Get all preferences
$allPreferences = $user1->getAllPreferences();
*/
