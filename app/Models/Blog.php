


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
    // Relation avec l'auteur
    public function author()
    {
        return $this->belongsTo(User::class, 'AuthorID', 'UserID');
    }
}