<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property numeric $price
 * @property int $discount
 * @property array<array-key, mixed> $images
 * @property array<array-key, mixed> $genre
 * @property array<array-key, mixed> $platform
 * @property \Illuminate\Support\Carbon|null $release_date
 * @property string|null $developer
 * @property string|null $publisher
 * @property numeric $rating
 * @property int $stock
 * @property bool $featured
 * @property array<array-key, mixed>|null $requirements
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $is_active
 * @property int $sales_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GameCode> $gameCodes
 * @property-read int|null $game_codes_count
 * @property-read mixed $price_after_discount
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereDeveloper($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereGenre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame wherePublisher($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereSalesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoGame withoutTrashed()
 * @mixin \Eloquent
 */
class VideoGame extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'video_games';

    protected $fillable = [
        'title',
        'description',
        'price',
        'discount',
        'images',
        'genre',
        'platform',
        'release_date',
        'developer',
        'publisher',
        'stock',
        'featured',
        'requirements',
        'popularity',
        'is_active',
        'sales_count',
    ];


    protected $casts = [
        'images' => 'array',
        'genre' => 'array',
        'platform' => 'array',
        'requirements' => 'array',
        'price' => 'decimal:2',
        'featured' => 'boolean',
        'release_date' => 'date',
        'is_active' => 'boolean',
        'popularity' => 'integer',
        'sales_count' => 'integer',
    ];
    // Relación con GameCode
    public function gameCodes()
    {
        return $this->hasMany(GameCode::class);
    }

    // Relación con las reseñas
    public function reviews()
    {
        return $this->hasMany(GameReview::class);
    }
    // App\Models\VideoGame.php

    public function getPriceAfterDiscountAttribute()
    {
        if (!$this->discount || $this->discount <= 0) {
            return $this->price;
        }

        $price = $this->price - ($this->price * $this->discount / 100);
        return round($price, 2);
    }
    public function getMainImageAttribute()
    {
        // Si está vacío
        if (!$this->images) {
            return 'https://via.placeholder.com/400x400?text=Sin+imagen';
        }

        // Si ya es array → úsalo tal cual
        if (is_array($this->images)) {
            return $this->images[0] ?? 'https://via.placeholder.com/400x400?text=Sin+imagen';
        }

        // Si es string → decodificar JSON
        $arr = json_decode($this->images, true);

        // Si algo falló → placeholder
        if (!is_array($arr) || empty($arr)) {
            return 'https://via.placeholder.com/400x400?text=Sin+imagen';
        }

        // Finalmente, devolver la primera imagen
        return $arr[0];
    }
}
