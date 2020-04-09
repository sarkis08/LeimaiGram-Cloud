<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = []; // disabling mass assignment

    public function profileImage()
    {
      $imageLocation = ($this->image) ? $this->image :  'profile/RrydFHDHouWF7d9nfeJV3I8BbYCLLErwCyGNCT1J.jpeg';
      return '/storage/' . $imageLocation;
    }

    public function followers()
    {
      return $this->belongsToMany(User::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
