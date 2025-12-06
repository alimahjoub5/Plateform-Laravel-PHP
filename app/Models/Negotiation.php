


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

    public function devis()
    {
        return $this->belongsTo(Devis::class, 'devis_id', 'DevisID');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'UserID');
    }
} 